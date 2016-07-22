<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Controllers\GetController;
    use Jukebox\Framework\Controllers\PostController;
    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\Http\Response\HtmlResponse;
    use Jukebox\Framework\Http\Response\JsonResponse;
    use Jukebox\Framework\Http\StatusCodes\NotFound;
    use Jukebox\Framework\Models\PageModel;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Frontend\Models\AjaxModel;
    use Jukebox\Frontend\Models\SearchPageModel;

    class ControllerFactory extends AbstractFactory
    {
        public function createHomepageController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new PageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createHomepageTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new HtmlResponse
            );
        }

        public function createTrackPageController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\Frontend\Models\TrackPageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createTrackPageQueryHandler(),
                $this->getMasterFactory()->createTrackPageTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new HtmlResponse
            );
        }

        public function createArtistPageController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new \Jukebox\Frontend\Models\ArtistPageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createArtistPageQueryHandler(),
                $this->getMasterFactory()->createArtistPageTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new HtmlResponse
            );
        }
        
        public function createNotFoundPageController(ControllerParameterObject $parameterObject): GetController
        {
            $response = new HtmlResponse;
            $response->setStatusCode(new NotFound);

            return new GetController(
                new PageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createNotFoundTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                $response
            );
        }

        public function createAjaxSearchController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createAjaxSearchQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createSearchPageController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new SearchPageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createSearchPageQueryHandler(),
                $this->getMasterFactory()->createSearchPageTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new HtmlResponse
            );
        }

        public function createResolveController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createResolveQueryHandler(),
                $this->getMasterFactory()->createResolveTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createArtistTracksController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createArtistTracksQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createArtistWebProfilesController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createArtistWebProfilesQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetArtistController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetArtistQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetTrackController(ControllerParameterObject $parameterObject): GetController
        {
            return new GetController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetTrackQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createLoginRequestController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createLoginCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createRegistrationRequestController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createRegistrationCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createGetMeController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createGetMeQueryHandler(),
                $this->getMasterFactory()->createAjaxTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }

        public function createLogoutRequestController(ControllerParameterObject $parameterObject): PostController
        {
            return new PostController(
                new AjaxModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createLogoutCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createGenericPageTransformationHandler(),
                $this->getMasterFactory()->createLogoutResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new JsonResponse
            );
        }
    }
}
