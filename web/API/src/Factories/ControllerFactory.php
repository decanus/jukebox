<?php

namespace Jukebox\API\Factories
{

    use Jukebox\Framework\Controllers\GetController;
    use Jukebox\Framework\Controllers\PostController;
    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\Http\Response\JsonResponse;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

    class ControllerFactory extends AbstractFactory
    {
        public function createIndexController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createIndexTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createSearchController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createSearchQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createNotFoundController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createNotFoundTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetArtistController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetArtistQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetArtistTracksController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetArtistTracksQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetTrackController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetTrackQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetArtistWebProfilesController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetArtistWebProfilesQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetArtistImagesController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetArtistImagesQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createAuthenticationController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createAuthenticationCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createRegistrationController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createRegistrationCommandHandler(),
                $this->getMasterFactory()->createRegistrationQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetMeController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetMeQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createCreatePlaylistController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCreatePlaylistCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetUserPlaylistsController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetUserPlaylistsQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetUserPlaylistController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetUserPlaylistQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetNewReleasesController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\API\Models\APIModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetNewReleasesQueryHandler(),
                $this->getMasterFactory()->createTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }
    }
}
