<?php

namespace Jukebox\Frontend\Handlers\Post\Registration
{

    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Username;
    use Jukebox\Frontend\Commands\RegistrationCommand;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var RegistrationCommand
         */
        private $registrationCommand;

        public function __construct(RegistrationCommand $registrationCommand)
        {
            $this->registrationCommand = $registrationCommand;
        }

        public function execute(RequestInterface $request, AbstractModel $model)
        {
            try {
                $email = new Email($request->getParameter('email'));
            } catch (\Throwable $e) {
                $model->setData(['error' => 'invalid_email']);
                return;
            }

            try {
                $username = new Username($request->getParameter('username'));
            } catch (\Throwable $e) {
                $model->setData(['error' => 'invalid_username']);
                return;
            }

            try {
                $password = new Password($request->getParameter('password'));
            } catch (\Throwable $e) {
                $model->setData(['error' => 'invalid_password']);
                return;
            }

            try {
                $result = $this->registrationCommand->execute($email, $username, $password);
            } catch (\InvalidArgumentException $e) {
                if ($e->getMessage() === 'User already exists with username') {
                    $model->setData(['error' => 'username_in_use']);
                }

                if ($e->getMessage() === 'User already exists with email') {
                    $model->setData(['error' => 'email_in_use']);
                }

                return;
            } catch (\Throwable $e) {
                $model->setData(['error' => 'something_went_wrong']);
                return;
            }

            if (!$result) {
                $model->setData(['error' => 'something_went_wrong']);
                return;
            }

            $model->setData(['message' => 'success']);
        }
    }
}
