<?php

namespace Jukebox\API\Handlers\Post\Registration
{

    use Jukebox\API\Commands\RegistrationCommand;
    use Jukebox\API\ValueObjects\Hash;
    use Jukebox\API\ValueObjects\Salt;
    use Jukebox\Framework\Handlers\CommandHandlerInterface;
    use Jukebox\Framework\Http\Request\RequestInterface;
    use Jukebox\Framework\Http\StatusCodes\BadRequest;
    use Jukebox\Framework\Http\StatusCodes\Created;
    use Jukebox\Framework\Http\StatusCodes\StatusCodeInterface;
    use Jukebox\Framework\Models\AbstractModel;
    use Jukebox\Framework\ValueObjects\Email;
    use Jukebox\Framework\ValueObjects\Password;
    use Jukebox\Framework\ValueObjects\Username;

    class CommandHandler implements CommandHandlerInterface
    {
        /**
         * @var AbstractModel
         */
        private $model;

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
            $this->model = $model;

            if ($model->hasStatusCode()) {
                return;
            }

            try {
                $email = new Email($request->getParameter('email'));
            } catch (\Exception $e) {
                $this->setError(new BadRequest, 'Invalid Email');
                return;
            }

            try {
                $password = new Password($request->getParameter('password'));
            } catch (\Exception $e) {
                $this->setError(new BadRequest, 'Invalid Password');
                return;
            }


            try {
                $username = new Username($request->getParameter('username'));
            } catch (\Exception $e) {
                $this->setError(new BadRequest, 'Invalid Username');
                return;
            }

            $salt = new Salt;
            $hash = new Hash((string) $password, $salt);

            $this->registrationCommand->execute($email, $username, $salt, $hash);

            $model->setData(['message' => 'Created']);
            $model->setStatusCode(new Created);
        }

        private function setError(StatusCodeInterface $statusCode, string $message)
        {
            $this->model->setStatusCode($statusCode);
            $this->model->setData(['errors' => ['message' => $message]]);
        }
    }
}
