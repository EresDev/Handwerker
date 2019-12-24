<?php

declare(strict_types=1);

namespace App\Infrastructure\Event\Listener;

use App\Domain\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Translation\Translator;
use Symfony\Contracts\Translation\TranslatorInterface;

class ExceptionListener
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getException();

        if ($exception instanceof ValidationException) {
            /**
             * @var ValidationException $exception
             */
            if ($exception->isTranslatable()) {
                $messages = $exception->getMessagesForEndUser();
                foreach ($messages[0] as $field => $message) {
                    //TODO: this loop currently expects only one message to be translatable.
                    //Update and improve this code accordingly. Cleanup needed.
                    //Either enforce some constraint in ValidationException that is translatable to
                    //have only one message, or change this into some efficient way to translate any
                    //number of arrays
                    $response[][$field] = $this->translator->trans($message);
                }
            } else {
                $response = $exception->getMessagesForEndUser();
            }

            $json = new JsonResponse($response, 422);
            $event->setResponse($json);
        }

        $response = $event->getResponse();

        return;
    }
}
