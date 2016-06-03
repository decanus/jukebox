<?php

namespace Jukebox\Frontend\Factories
{

    use Jukebox\Framework\Controllers\GetController;
    use Jukebox\Framework\Factories\AbstractFactory;
    use Jukebox\Framework\Http\Response\HtmlResponse;
    use Jukebox\Framework\Models\PageModel;
    use Jukebox\Framework\ParamterObjects\ControllerParameterObject;

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
                new PageModel($parameterObject->getUri()),
                $this->getMasterFactory()->createPreHandler(),
                $this->getMasterFactory()->createCommandHandler(),
                $this->getMasterFactory()->createQueryHandler(),
                $this->getMasterFactory()->createTrackPageTransformationHandler(),
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
    }
}
