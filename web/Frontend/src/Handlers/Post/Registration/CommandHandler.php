<?php

namespace Jukebox\Frontend\Handlers\Post\Registration
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;

    class CommandHandler implements CommandHandlerInterface
    {

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {
                $email = new Email($request->getParameter('email'));
            } catch (\Throwable $e) {
                $model->setData(['error' => 'invalid_email']);
                return;
            }
        }
    }
}
