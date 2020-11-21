<?php

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionSubscriberTest extends TestCase
{
    public function testEventSubscription() {
        self::assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    public function testSendMailOnException() {
        $mailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $subscriber = new ExceptionSubscriber('from@nel.fr', 'to@nel.fr', $mailer);
        $kernel = $this->getMockBuilder(HttpKernelInterface::class)->getMock();
        $event = new ExceptionEvent($kernel, new Request(), 1, new \Exception());
        $mailer->expects(self::once())->method('send');
        $subscriber->onKernelException($event);
    }

}
