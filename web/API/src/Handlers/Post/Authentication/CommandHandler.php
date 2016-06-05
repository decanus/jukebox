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

        /**
         * @var SessionData
         */
        private $sessionData;

        public function __construct(
            AuthenticationCommand $authenticationCommand,
            SessionData $sessionData
        )
        {
            $this->authenticationCommand = $authenticationCommand;
            $this->sessionData = $sessionData;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {

                if (!$this->authenticationCommand->execute(new Email($request->getParameter('email')), new Password($request->getParameter('password')))) {
                    throw new \Exception('Authentication Failed');
                }

                $this->sessionData->setAccount(new RegisteredAccount);
                $model->setData(['access_token' => (string) $this->sessionData->getMap()->getSessionId()]);
            } catch (\Throwable $e) {
                $model->setData(['errors' => ['message' => 'Unauthorized']]);
                $model->setStatusCode(new Unauthorized);
                return;
            }
        }
    }
}
