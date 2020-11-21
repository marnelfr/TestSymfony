<?php

namespace App\EventSubscriber;

use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionSubscriber implements EventSubscriberInterface
{

    /**
     * @var Swift_Mailer
     */
    private $mailer;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;

    public function __construct(string $from, string $to, Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;
    }

    public static function getSubscribedEvents()
    {
        return [
            ExceptionEvent::class => [
                ['onKernelException', 15],
                ['onKernelException2', 25]
            ],
        ];
    }


    public function onKernelException2(ExceptionEvent $event) {

    }


    public function onKernelException(ExceptionEvent $event)
    {
        $body = $event->getRequest()->getRequestUri() . "\n\n";
        $body .= $event->getException()->getMessage() . "\n\n";
        $body .= $event->getException()->getTraceAsString();

        $message = (new \Swift_Message())
            ->setTo($this->to)
            ->setFrom($this->from)
            ->setBody($body)
        ;
        $this->mailer->send($message);
    }
}
