<?php

namespace App\EventSubscriber;

use App\Services\CoreService;

use AwrProvider\Trait\Hash;
use Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;


class CallSubscriber  implements EventSubscriberInterface
{
	public function __construct()
	{
	}

	public function onKernelResponse(ResponseEvent $event): void
    {
		$response = $event->getResponse();

		$response->headers->set('Access-Control-Allow-Credentials', 'true');
		$response->headers->set('Access-Control-Allow-Headers', 'Origin,authorization,X-Requested-With,Content-Type,Accept,Authorization,X-Custom-Header,Content-Range,Content-Disposition,Content-Description,Addon-Client,Baggage,Sentry-Trace');
		$response->headers->set('Access-Control-Allow-Methods', '*');
		$response->headers->set('Access-Control-Expose-Headers', 'Content-Disposition');
        $response->headers->set('Access-Control-Allow-Origin', 'https://localhost:4200');

		$event->setResponse($response);
	}

	public function onKernelException(ExceptionEvent $event): void
    {
		// You get the exception object from the received event
		$exception = $event->getThrowable();

		$code = $exception->getCode() > 400 ? $exception->getCode() : (str_contains($exception->getMessage(), 'No route found') ? 404 : 400);
		$errorObject = [
			'error' => $code,
			'message' => $exception->getMessage()
		];
		if ($exception->getCode() < 1) {
			$errorObject['file'] = $exception->getFile();
			$errorObject['line'] = $exception->getLine();
		}

		$response = new JsonResponse($errorObject);
		$response->setStatusCode($code);

		$event->setResponse($response);
	}

	public static function getSubscribedEvents(): array
	{
		return [
			KernelEvents::RESPONSE => 'onKernelResponse',
			KernelEvents::EXCEPTION => 'onKernelException'
		];
	}
}
