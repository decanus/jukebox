<?php
namespace GuzzleHttp\Psr7;

use Psr\Http\Message\UriInterface;

/**
 * PSR-7 URI implementation.
 *
 * @author Michael Dowling
 * @author Tobias Schultze
 * @author Matthew Weier O'Phinney
 */
class Uri implements UriInterface
{
    private static $schemes = [
        'http'  => 80,
        'https' => 443,
    ];

    private static $charUnreserved = 'a-zA-Z0-9_\-\.~';
    private static $charSubDelims = '!\$&\'\(\)\*\+,;=';
    private static $replaceQuery = ['=' => '%3D', '&' => '%26'];

    /** @var string Uri scheme. */
    private $scheme = '';

    /** @var string Uri user info. */
    private $userInfo = '';

    /** @var string Uri host. */
    private $host = '';

    /** @var int|null Uri port. */
    private $port;

    /** @var string Uri path. */
    private $path = '';

    /** @var string Uri query string. */
    private $query = '';

    /** @var string Uri fragment. */
    private $fragment = '';

    /**
     * @param string $uri URI to parse and wrap.
     */
    public function __construct($uri = '')
    {
        if ($uri != '') {
            $parts = parse_url($uri);
            if ($parts === false) {
                throw new \InvalidArgumentException("Unable to parse URI: $uri");
            }
            $this->applyParts($parts);
        }
    }

    public function __toString()
    {
        return self::createUriString(
            $this->scheme,
            $this->getAuthority(),
            $this->getPath(),
            $this->query,
            $this->fragment
        );
    }

    /**
     * Removes dot segments from a path and returns the new path.
     *
     * @param string $path
     *
     * @return string
     * @link http://tools.ietf.org/html/rfc3986#section-5.2.4
     */
    public static function removeDotSegments($path)
    {
        static $noopPaths = ['' => true, '/' => true, '*' => true];
        static $ignoreSegments = ['.' => true, '..' => true];

        if (isset($noopPaths[$path])) {
            return $path;
        }

        $results = [];
        $segments = explode('/', $path);
        foreach ($segments as $segment) {
            if ($segment === '..') {
                array_pop($results);
            } elseif (!isset($ignoreSegments[$segment])) {
                $results[] = $segment;
            }
        }

        $newPath = implode('/', $results);
        // Add the leading slash if necessary
        if (substr($path, 0, 1) === '/' &&
            substr($newPath, 0, 1) !== '/'
        ) {
            $newPath = '/' . $newPath;
        }

        // Add the trailing slash if necessary
        if ($newPath !== '/' && isset($ignoreSegments[end($segments)])) {
            $newPath .= '/';
        }

        return $newPath;
    }

    /**
     * Resolve a base URI with a relative URI and return a new URI.
     *
     * @param UriInterface        $base Base URI
     * @param string|UriInterface $rel  Relative URI
     *
     * @return UriInterface
     */
    public static function resolve(UriInterface $base, $rel)
    {
        if ($rel == '') {
            return $base;
        }

        if (!($rel instanceof UriInterface)) {
            $rel = new self($rel);
        }

        // Return the relative uri as-is if it has a scheme.
        if ($rel->getScheme() != '') {
            return $rel->withPath(self::removeDotSegments($rel->getPath()));
        }

        $relParts = [
            'scheme'    => $rel->getScheme(),
            'authority' => $rel->getAuthority(),
            'path'      => $rel->getPath(),
            'query'     => $rel->getQuery(),
            'fragment'  => $rel->getFragment()
        ];

        $parts = [
            'scheme'    => $base->getScheme(),
            'authority' => $base->getAuthority(),
            'path'      => $base->getPath(),
            'query'     => $base->getQuery(),
            'fragment'  => $base->getFragment()
        ];

        if ($relParts['authority'] != '') {
            $parts['authority'] = $relParts['authority'];
            $parts['path'] = self::removeDotSegments($relParts['path']);
            $parts['query'] = $relParts['query'];
            $parts['fragment'] = $relParts['fragment'];
        } elseif ($relParts['path'] != '') {
            if (substr($relParts['path'], 0, 1) == '/') {
                $parts['path'] = self::removeDotSegments($relParts['path']);
                $parts['query'] = $relParts['query'];
                $parts['fragment'] = $relParts['fragment'];
            } else {
                if ($parts['authority'] != '' && $parts['path'] == '') {
                    $mergedPath = '/';
                } else {
                    $mergedPath = substr($parts['path'], 0, strrpos($parts['path'], '/') + 1);
                }
                $parts['path'] = self::removeDotSegments($mergedPath . $relParts['path']);
                $parts['query'] = $relParts['query'];
                $parts['fragment'] = $relParts['fragment'];
            }
        } elseif ($relParts['query'] != '') {
            $parts['query'] = $relParts['query'];
        } elseif ($relParts['fragment'] != '') {
            $parts['fragment'] = $relParts['fragment'];
        }

        return new self(self::createUriString(
            $parts['scheme'],
            $parts['authority'],
            $parts['path'],
            $parts['query'],
            $parts['fragment']
        ));
    }

    /**
     * Create a new URI with a specific query string value removed.
     *
     * Any existing query string values that exactly match the provided key are
     * removed.
     *
     * Note: this function will convert "=" to "%3D" and "&" to "%26".
     *
     * @param UriInterface $uri URI to use as a base.
     * @param string       $key Query string key value pair to remove.
     *
     * @return UriInterface
     */
    public static function withoutQueryValue(UriInterface $uri, $key)
    {
        $current = $uri->getQuery();
        if ($current == '') {
            return $uri;
        }

        $result = [];
        foreach (explode('&', $current) as $part) {
            if (explode('=', $part)[0] !== $key) {
                $result[] = $part;
            };
        }

        return $uri->withQuery(implode('&', $result));
    }

    /**
     * Create a new URI with a specific query string value.
     *
     * Any existing query string values that exactly match the provided key are
     * removed and replaced with the given key value pair.
     *
     * Note: this function will convert "=" to "%3D" and "&" to "%26".
     *
     * @param UriInterface $uri URI to use as a base.
     * @param string $key   Key to set.
     * @param string $value Value to set.
     *
     * @return UriInterface
     */
    public static function withQueryValue(UriInterface $uri, $key, $value)
    {
        $current = $uri->getQuery();
        $key = strtr($key, self::$replaceQuery);

        if ($current == '') {
            $result = [];
        } else {
            $result = [];
            foreach (explode('&', $current) as $part) {
                if (explode('=', $part)[0] !== $key) {
                    $result[] = $part;
                };
            }
        }

        if ($value !== null) {
            $result[] = $key . '=' . strtr($value, self::$replaceQuery);
        } else {
            $result[] = $key;
        }

        return $uri->withQuery(implode('&', $result));
    }

    /**
     * Create a URI from a hash of parse_url parts.
     *
     * @param array $parts
     *
     * @return self
     */
    public static function fromParts(array $parts)
    {
        $uri = new self();
        $uri->applyParts($parts);
        return $uri;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getAuthority()
    {
        if ($this->host == '') {
            return '';
        }

        $authority = $this->host;
        if ($this->userInfo != '') {
            $authority = $this->userInfo . '@' . $authority;
        }

        if ($this->port !== null) {
            $authority .= ':' . $this->port;
        }

        return $authority;
    }

    public function getUserInfo()
    {
        return $this->userInfo;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function getFragment()
    {
        return $this->fragment;
    }

    public function withScheme($scheme)
    {
        $scheme = $this->filterScheme($scheme);

        if ($this->scheme === $scheme) {
            return $this;
        }

        $new = clone $this;
        $new->scheme = $scheme;
        $new->port = $new->filterPort($new->port);
        return $new;
    }

    public function withUserInfo($user, $password = null)
    {
        $info = $user;
        if ($password != '') {
            $info .= ':' . $password;
        }

        if ($this->userInfo === $info) {
            return $this;
        }

        $new = clone $this;
        $new->userInfo = $info;
        return $new;
    }

    public function withHost($host)
    {
        $host = $this->filterHost($host);

        if ($this->host === $host) {
            return $this;
        }

        $new = clone $this;
        $new->host = $host;
        return $new;
    }

    public function withPort($port)
    {
        $port = $this->filterPort($port);

        if ($this->port === $port) {
            return $this;
        }

        $new = clone $this;
        $new->port = $port;
        return $new;
    }

    public function withPath($path)
    {
        $path = $this->filterPath($path);

        if ($this->path === $path) {
            return $this;
        }

        $new = clone $this;
        $new->path = $path;
        return $new;
    }

    public function withQuery($query)
    {
        $query = $this->filterQueryAndFragment($query);

        if ($this->query === $query) {
            return $this;
        }

        $new = clone $this;
        $new->query = $query;
        return $new;
    }

    public function withFragment($fragment)
    {
        $fragment = $this->filterQueryAndFragment($fragment);

        if ($this->fragment === $fragment) {
            return $this;
        }

        $new = clone $this;
        $new->fragment = $fragment;
        return $new;
    }

    /**
     * Apply parse_url parts to a URI.
     *
     * @param array $parts Array of parse_url parts to apply.
     */
    private function applyParts(array $parts)
    {
        $this->scheme = isset($parts['scheme'])
            ? $this->filterScheme($parts['scheme'])
            : '';
        $this->userInfo = isset($parts['user']) ? $parts['user'] : '';
        $this->host = isset($parts['host'])
            ? $this->filterHost($parts['host'])
            : '';
        $this->port = isset($parts['port'])
            ? $this->filterPort($parts['port'])
            : null;
        $this->path = isset($parts['path'])
            ? $this->filterPath($parts['path'])
            : '';
        $this->query = isset($parts['query'])
            ? $this->filterQueryAndFragment($parts['query'])
            : '';
        $this->fragment = isset($parts['fragment'])
            ? $this->filterQueryAndFragment($parts['fragment'])
            : '';
        if (isset($parts['pass'])) {
            $this->userInfo .= ':' . $parts['pass'];
        }
    }

    /**
     * Create a URI string from its various parts
     *
     * @param string $scheme
     * @param string $authority
     * @param string $path
     * @param string $query
     * @param string $fragment
     * @return string
     */
    private static function createUriString($scheme, $authority, $path, $query, $fragment)
    {
        $uri = '';

        if ($scheme != '') {
            $uri .= $scheme . ':';
        }

        if ($authority != '') {
            $uri .= '//' . $authority;
        }

        if ($path != '') {
            if ($path[0] !== '/') {
                if ($authority != '') {
                    // If the path is rootless and an authority is present, the path MUST be prefixed by "/"
                    $path = '/' . $path;
                }
            } elseif (isset($path[1]) && $path[1] === '/') {
                if ($authority == '') {
                    // If the path is starting with more than one "/" and no authority is present, the
                    // starting slashes MUST be reduced to one.
                    $path = '/' . ltrim($path, '/');
                }
            }

            $uri .= $path;
        }

        if ($query != '') {
            $uri .= '?' . $query;
        }

        if ($fragment != '') {
            $uri .= '#' . $fragment;
        }

        return $uri;
    }

    /**
     * Is a given port non-standard for the current scheme?
     *
     * @param string $scheme
     * @param int    $port
     *
     * @return bool
     */
    private static function isNonStandardPort($scheme, $port)
    {
        return !isset(self::$schemes[$scheme]) || $port !== self::$schemes[$scheme];
    }

    /**
     * @param string $scheme
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the scheme is invalid.
     */
    private function filterScheme($scheme)
    {
        if (!is_string($scheme)) {
            throw new \InvalidArgumentException('Scheme must be a string');
        }

        return strtolower($scheme);
    }

    /**
     * @param string $host
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the host is invalid.
     */
    private function filterHost($host)
    {
        if (!is_string($host)) {
            throw new \InvalidArgumentException('Host must be a string');
        }

        return strtolower($host);
    }

    /**
     * @param int|null $port
     *
     * @return int|null
     *
     * @throws \InvalidArgumentException If the port is invalid.
     */
    private function filterPort($port)
    {
        if ($port === null) {
            return null;
        }

        $port = (int) $port;
        if (1 > $port || 0xffff < $port) {
            throw new \InvalidArgumentException(
                sprintf('Invalid port: %d. Must be between 1 and 65535', $port)
            );
        }

        return self::isNonStandardPort($this->scheme, $port) ? $port : null;
    }

    /**
     * Filters the path of a URI
     *
     * @param string $path
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the path is invalid.
     */
    private function filterPath($path)
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('Path must be a string');
        }

        return preg_replace_callback(
            '/(?:[^' . self::$charUnreserved . self::$charSubDelims . '%:@\/]++|%(?![A-Fa-f0-9]{2}))/',
            [$this, 'rawurlencodeMatchZero'],
            $path
        );
    }

    /**
     * Filters the query string or fragment of a URI.
     *
     * @param string $str
     *
     * @return string
     *
     * @throws \InvalidArgumentException If the query or fragment is invalid.
     */
    private function filterQueryAndFragment($str)
    {
        if (!is_string($str)) {
            throw new \InvalidArgumentException('Query and fragment must be a string');
        }

        return preg_replace_callback(
            '/(?:[^' . self::$charUnreserved . self::$charSubDelims . '%:@\/\?]++|%(?![A-Fa-f0-9]{2}))/',
            [$this, 'rawurlencodeMatchZero'],
            $str
        );
    }

    private function rawurlencodeMatchZero(array $match)
    {
        return rawurlencode($match[0]);
    }
}
