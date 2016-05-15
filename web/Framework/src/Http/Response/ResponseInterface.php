<?php

namespace Jukebox\Framework\Http\Response
{

    use Jukebox\Framework\Http\Redirect\RedirectInterface;
    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\ValueObjects\Cookie;

    interface ResponseInterface
    {
        /**
         * @param StatusCodeInterface $code
         */
        public function setStatusCode(StatusCodeInterface $code);

        /**
         * @param Cookie $cookie
         */
        public function setCookie(Cookie $cookie);

        /**
         * @param string $key
         * @param string $value
         */
        public function setHeader($key, $value);

        /**
         * @return array
         */
        public function getHeaders(): array;

        /**
         * @return array
         */
        public function getCookies(): array;

        /**
         * @param string $body
         */
        public function setBody($body);

        /**
         * @param RedirectInterface $redirect
         */
        public function setRedirect(RedirectInterface $redirect);
        
        /**
         * @return string
         */
        public function getBody(): string;

        public function send();
    }
}
