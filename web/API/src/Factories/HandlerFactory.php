<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\ValueObjects\Uri;
    use Jukebox\Search\YoutubeSearch;

    class HandlerFactory extends AbstractFactory
    {
        public function createCommandHandler(): \Jukebox\API\Handlers\CommandHandler
        {
            return new \Jukebox\API\Handlers\CommandHandler;
        }

        public function createPostHandler(): \Jukebox\API\Handlers\PostHandler
        {
            return new \Jukebox\API\Handlers\PostHandler;
        }

        public function createPreHandler(): \Jukebox\API\Handlers\PreHandler
        {
            return new \Jukebox\API\Handlers\PreHandler;
        }

        public function createQueryHandler(): \Jukebox\API\Handlers\QueryHandler
        {
            return new \Jukebox\API\Handlers\QueryHandler;
        }

        public function createResponseHandler(): \Jukebox\API\Handlers\ResponseHandler
        {
            return new \Jukebox\API\Handlers\ResponseHandler;
        }

        public function createTransformationHandler(): \Jukebox\API\Handlers\TransformationHandler
        {
            return new \Jukebox\API\Handlers\TransformationHandler;
        }

        public function createIndexTransformationHandler(): \Jukebox\API\Handlers\Get\Index\TransformationHandler
        {
            return new \Jukebox\API\Handlers\Get\Index\TransformationHandler;
        }

        public function createNotFoundTransformationHandler(): \Jukebox\API\Handlers\Get\NotFound\TransformationHandler
        {
            return new \Jukebox\API\Handlers\Get\NotFound\TransformationHandler;
        }

        public function createSearchQueryHandler(): \Jukebox\API\Handlers\Get\Search\QueryHandler
        {
            return new \Jukebox\API\Handlers\Get\Search\QueryHandler(
                new YoutubeSearch(
                    $this->getMasterFactory()->createCurl(),
                    $this->getMasterFactory()->getConfiguration()->get('youtubeDataApiKey'),
                    new Uri('https://www.googleapis.com/youtube/v3/search')
                )
            );
        }
    }
}
