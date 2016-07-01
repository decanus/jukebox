<?php

namespace Jukebox\Frontend\Handlers\Post\Login
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Frontend\Commands\LoginCommand;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var LoginCommand
         */
        private $loginCommand;

        public function __construct(LoginCommand $loginCommand)
        {
            $this->loginCommand = $loginCommand;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {

                $result = $this->loginCommand->execute(
                    new Email($request->getParameter('email')),
                    new Password($request->getParameter('password'))
                );

            } catch (\Exception $e) {

            }
        }
    }
}
