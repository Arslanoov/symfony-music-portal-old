<?php

declare(strict_types=1);

namespace App\Http\Controller\Api\Auth;

use App\Http\Controller\Api\BaseController;
use App\Model\Exception\ErrorHandler;
use App\Model\User\Entity\User\ConfirmToken;
use App\Model\User\UseCase\User\SignUp\ByEmail;
use App\Model\Music\UseCase\Artist;
use App\Service\Transaction\TransactionInterface;
use DomainException;
use Exception;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SignUpController extends BaseController
{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private ErrorHandler $errorHandler;
    private TransactionInterface $transaction;

    /**
     * SignUpController constructor.
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ErrorHandler $errorHandler
     * @param TransactionInterface $transaction
     */
    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, ErrorHandler $errorHandler, TransactionInterface $transaction)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->errorHandler = $errorHandler;
        $this->transaction = $transaction;
    }

    /**
     * @Route("/api/sign-up", name="api.auth.signup", methods={"POST"})
     * @param Request $request
     * @param ByEmail\Request\Handler $signUpHandler
     * @param Artist\Create\Handler $artistCreateHandler
     * @return JsonResponse
     * @throws Exception
     */
    public function request(
        Request $request,
        ByEmail\Request\Handler $signUpHandler,
        Artist\Create\Handler $artistCreateHandler
    ): JsonResponse
    {
        $body = json_decode($request->getContent(), true);

        $id = Uuid::uuid4()->toString();
        $login = $body['login'] ?? '';
        $email = $body['email'] ?? '';
        $password = $body['password'] ?? '';
        $age = (int) $body['age'] ?? 0;

        $signUpCommand = new ByEmail\Request\Command($id, $login, $email, $password, $age);

        $violations = $this->validator->validate($signUpCommand);
        if (count($violations)) {
            $data = $this->serializer->serialize($violations, 'json');
            return $this->json(json_decode($data, true), 422);
        }

        $this->transaction->begin();

        try {
            $signUpHandler->handle($signUpCommand);

            $artistCreateCommand = new Artist\Create\Command($id, $login);
            $artistCreateHandler->handle($artistCreateCommand);

            $this->transaction->commit();
        } catch (DomainException $e) {
            $this->transaction->rollback();
            $this->errorHandler->handleWarning($e);

            return $this->json([
                'message' => $e->getMessage()
            ], 419);
        }

        return $this->json([
            'email' => $signUpCommand->email
        ], 201);
    }

    /**
     * @Route("/api/sign-up/confirm/{token}", name="api.auth.signup.confirm", methods={"POST"})
     * @param Request $request
     * @param string $token
     * @param ByEmail\Confirm\ByToken\Handler $handler
     * @return JsonResponse
     */
    public function confirm(
        Request $request,
        string $token,
        ByEmail\Confirm\ByToken\Handler $handler
    ): JsonResponse
    {
        $confirmToken = new ConfirmToken($token ?? '');

        $command = new ByEmail\Confirm\ByToken\Command($confirmToken->getValue());

        try {
            $handler->handle($command);
        } catch (DomainException $e) {
            $this->errorHandler->handleWarning($e);
            return $this->json([
                'message' => $e->getMessage()
            ], 419);
        }

        return $this->json([], 204);
    }
}
