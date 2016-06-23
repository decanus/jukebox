<?php

namespace Jukebox\API\Handlers\Post\Authentication
{

    use Jukebox\API\Commands\AuthenticationCommand;
    use Jukebox\API\DataObjects\Accounts\RegisteredAccount;
    use Jukebox\API\Session\SessionData;
    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\Unauthorized;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var AuthenticationCommand
         */
        private $authenticationCommand;

        public function __construct(AuthenticationCommand $authenticationCommand)
        {
            $this->authenticationCommand = $authenticationCommand;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {

                $accessToken = $this->authenticationCommand->execute(
                    new Email($request->getParameter('email')),
                    new Password($request->getParameter('password'))
                );

                $model->setData(['access_token' => (string) $accessToken]);
            } catch (\Throwable $e) {
                $model->setData(['errors' => ['message' => 'Unauthorized']]);
                $model->setStatusCode(new Unauthorized);
                return;
            }
        }
    }
}
