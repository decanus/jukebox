<?php

namespace Jukebox\Frontend\Handlers\Post\Logout
{

    use Jukebox\Framework\Http\Redirect\RedirectToPath;
    use Jukebox\Framework\Http\StatusCodes\MovedTemporarily;
    use Jukebox\Framework\ValueObjects\Cookie;
    use Jukebox\Frontend\Handlers\AbstractResponseHandler;

    class ResponseHandler extends AbstractResponseHandler
    {

        protected function doExecute()
        {
            $this->getModel()->setRedirect(
                new RedirectToPath(
                    $this->getModel()->getRequestUri(),
                    new MovedTemporarily,
                    '/'
                )
            );

            $this->getResponse()->setCookie(
                new Cookie('SID', '', '/', -1)
            );
        }
    }
}
