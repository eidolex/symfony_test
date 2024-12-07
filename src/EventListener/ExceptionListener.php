<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request = $event->getRequest();

        if ("application/json" === $request->headers->get("Accept")) {
            $statusCode =
                $exception instanceof HttpExceptionInterface
                    ? $exception->getStatusCode()
                    : Response::HTTP_INTERNAL_SERVER_ERROR;

            $data = [
                "status" => $statusCode,
                "message" => $exception->getMessage(),
                "code" => $exception->getCode(),
            ];

            $previous = $exception->getPrevious();

            if (
                $exception instanceof UnprocessableEntityHttpException &&
                $previous instanceof ValidationFailedException
            ) {
                $data["errors"] = [];
                $violations = $previous->getViolations();
                foreach ($violations as $violation) {
                    $data["errors"][
                        $violation->getPropertyPath()
                    ] = $violation->getMessage();
                }
            }

            $response = new JsonResponse($data);

            if ($exception instanceof HttpExceptionInterface) {
                $response->setStatusCode($exception->getStatusCode());
                // $response->headers->replace($exception->getHeaders());
            } else {
                $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // sends the modified response object to the event
            $event->setResponse($response);
        }
    }
}
