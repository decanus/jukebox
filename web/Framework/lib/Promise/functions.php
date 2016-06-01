<?php

namespace React\Promise;

function resolve($promiseOrValue = null)
{
    if ($promiseOrValue instanceof ExtendedPromiseInterface) {
        return $promiseOrValue;
    }

    if (method_exists($promiseOrValue, 'then')) {
        $canceller = null;

        if (method_exists($promiseOrValue, 'cancel')) {
            $canceller = [$promiseOrValue, 'cancel'];
        }

        return new Promise(function ($resolve, $reject) use ($promiseOrValue) {
            $promiseOrValue->then($resolve, $reject);
        }, $canceller);
    }

    return new FulfilledPromise($promiseOrValue);
}

function reject($promiseOrValue = null)
{
    if ($promiseOrValue instanceof PromiseInterface) {
        return resolve($promiseOrValue)->then(function ($value) {
            return new RejectedPromise($value);
        });
    }

    return new RejectedPromise($promiseOrValue);
}

function all(array $promisesOrValues)
{
    return map($promisesOrValues, function ($val) {
        return $val;
    });
}

function race(array $promisesOrValues)
{
    if (!$promisesOrValues) {
        return resolve();
    }

    $cancellationQueue = new CancellationQueue();

    return new Promise(function ($resolve, $reject) use ($promisesOrValues, $cancellationQueue) {
        $fulfiller = function ($value) use ($cancellationQueue, $resolve) {
            $cancellationQueue();
            $resolve($value);
        };

        $rejecter = function ($reason) use ($cancellationQueue, $reject) {
            $cancellationQueue();
            $reject($reason);
        };

        foreach ($promisesOrValues as $promiseOrValue) {
            $cancellationQueue->enqueue($promiseOrValue);

            resolve($promiseOrValue)
                ->done($fulfiller, $rejecter);
        }
    }, $cancellationQueue);
}

function any(array $promisesOrValues)
{
    return some($promisesOrValues, 1)
        ->then(function ($val) {
            return array_shift($val);
        });
}

function some(array $promisesOrValues, $howMany)
{
    if ($howMany < 1) {
        return resolve([]);
    }

    $len = count($promisesOrValues);

    if ($len < $howMany) {
        return reject(
            new Exception\LengthException(
                sprintf(
                    'Input array must contain at least %d item%s but contains only %s item%s.',
                    $howMany,
                    1 === $howMany ? '' : 's',
                    $len,
                    1 === $len ? '' : 's'
                )
            )
        );
    }

    $cancellationQueue = new CancellationQueue();

    return new Promise(function ($resolve, $reject) use ($len, $promisesOrValues, $howMany, $cancellationQueue) {
        $toResolve = $howMany;
        $toReject  = ($len - $toResolve) + 1;
        $values    = [];
        $reasons   = [];

        foreach ($promisesOrValues as $i => $promiseOrValue) {
            $fulfiller = function ($val) use ($i, &$values, &$toResolve, $toReject, $resolve, $cancellationQueue) {
                if ($toResolve < 1 || $toReject < 1) {
                    return;
                }

                $values[$i] = $val;

                if (0 === --$toResolve) {
                    $cancellationQueue();
                    $resolve($values);
                }
            };

            $rejecter = function ($reason) use ($i, &$reasons, &$toReject, $toResolve, $reject, $cancellationQueue) {
                if ($toResolve < 1 || $toReject < 1) {
                    return;
                }

                $reasons[$i] = $reason;

                if (0 === --$toReject) {
                    $cancellationQueue();
                    $reject($reasons);
                }
            };

            $cancellationQueue->enqueue($promiseOrValue);

            resolve($promiseOrValue)
                ->done($fulfiller, $rejecter);
        }
    }, $cancellationQueue);
}

function map(array $promisesOrValues, callable $mapFunc)
{
    if (!$promisesOrValues) {
        return resolve([]);
    }

    $cancellationQueue = new CancellationQueue();

    return new Promise(function ($resolve, $reject) use ($promisesOrValues, $mapFunc, $cancellationQueue) {
        $toResolve = count($promisesOrValues);
        $values    = [];

        foreach ($promisesOrValues as $i => $promiseOrValue) {
            $cancellationQueue->enqueue($promiseOrValue);

            resolve($promiseOrValue)
                ->then($mapFunc)
                ->done(
                    function ($mapped) use ($i, &$values, &$toResolve, $resolve) {
                        $values[$i] = $mapped;

                        if (0 === --$toResolve) {
                            $resolve($values);
                        }
                    },
                    $reject
                );
        }
    }, $cancellationQueue);
}

function reduce(array $promisesOrValues, callable $reduceFunc, $initialValue = null)
{
    $cancellationQueue = new CancellationQueue();

    return new Promise(function ($resolve, $reject) use ($promisesOrValues, $reduceFunc, $initialValue, $cancellationQueue) {
        $total = count($promisesOrValues);
        $i = 0;

        $wrappedReduceFunc = function ($current, $val) use ($reduceFunc, $cancellationQueue, $total, &$i) {
            $cancellationQueue->enqueue($val);

            return $current
                ->then(function ($c) use ($reduceFunc, $total, &$i, $val) {
                    return resolve($val)
                        ->then(function ($value) use ($reduceFunc, $total, &$i, $c) {
                            return $reduceFunc($c, $value, $i++, $total);
                        });
                });
        };

        $cancellationQueue->enqueue($initialValue);

        array_reduce($promisesOrValues, $wrappedReduceFunc, resolve($initialValue))
            ->done($resolve, $reject);
    }, $cancellationQueue);
}

function queue(Queue\QueueInterface $queue = null)
{
    static $globalQueue;

    if ($queue) {
        return ($globalQueue = $queue);
    }

    if (!$globalQueue) {
        $globalQueue = new Queue\SynchronousQueue();
    }

    return $globalQueue;
}

// Internal functions
function _checkTypehint(callable $callback, $object)
{
    if (!is_object($object)) {
        return true;
    }

    if (is_array($callback)) {
        $callbackReflection = new \ReflectionMethod($callback[0], $callback[1]);
    } elseif (is_object($callback) && !$callback instanceof \Closure) {
        $callbackReflection = new \ReflectionMethod($callback, '__invoke');
    } else {
        $callbackReflection = new \ReflectionFunction($callback);
    }

    $parameters = $callbackReflection->getParameters();

    if (!isset($parameters[0])) {
        return true;
    }

    $expectedException = $parameters[0];

    if (!$expectedException->getClass()) {
        return true;
    }

    return $expectedException->getClass()->isInstance($object);
}
