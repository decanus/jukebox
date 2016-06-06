<?php


namespace Jukebox\API\Endpoints
{

    use Jukebox\Framework\Controllers\ControllerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;

    interface EndpointInterface
    {
        public function getApiEndpoint(): string;

        public function requiresAccessToken(): bool;

        public function getRequestType(): string;
        
        public function isEndpoint(RequestInterface $request): bool;

        public function handle(RequestInterface $request): ControllerInterface;
    }
}
