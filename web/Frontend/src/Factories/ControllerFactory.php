<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Controllers\GetController;
    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\Http\Response\HtmlResponse;
    use Jukebox\Framework\Http\Response\JsonResponse;
    use Jukebox\Framework\Models\PageModel;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;
    use Jukebox\Frontend\Models\AjaxModel;

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
            return new GetController(
                new PageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createNotFoundTransformationHandler(),
                $this->getMasterFactory()->createResponseHandler(),
                $this->getMasterFactory()->createPostHandler(),
                new HtmlResponse
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
    }
}
