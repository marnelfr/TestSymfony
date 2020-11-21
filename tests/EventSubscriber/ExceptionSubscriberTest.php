<?php

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use PHPUnit\Framework\TestCase;
use Swift_Mailer;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExceptionSubscriberTest extends TestCase
{
    public function testEventSubscription() {
        self::assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    /**
     * On peut se passer de ce test-ci vu que le test suivant l'inclus
     * et en est une version plus performant.
     */
    public function testSendMailOnException() {
        $mailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mailer->expects(self::once())->method('send');
        $this->dispatch($mailer);
    }

    /**
     * Meilleur version du test précédent
     */
    public function testOnKernelExceptionIsCalled() {
        $mailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mailer->expects($this->once())->method('send');
        $this->dispatch($mailer);
    }

    public function testSendMailToAdminOnException() {
        $mailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mailer->expects(self::once())->method('send')->with(
            self::callback(static function (\Swift_Message $message) {
                return
                    array_key_exists('from@nel.fr', $message->getFrom()) &&
                    array_key_exists('to@nel.fr', $message->getTo())
                ;
            })
        );
        $this->dispatch($mailer);
    }

    public function testMessageBodyContainsExceptionTrace() {
        $mailer = $this->getMockBuilder(Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $mailer->expects(self::once())->method('send')->with(self::callback(
            static function (\Swift_Message $message) {
                return
                    strpos($message->getBody(),'ExceptionSubscriberTest') &&
                    strpos($message->getBody(), 'Hello World')
                ;
            }
        ));
        $this->dispatch($mailer);
    }

    private function dispatch($mailer) {
        $subscriber = new ExceptionSubscriber('from@nel.fr', 'to@nel.fr', $mailer);

        $kernel = $this->getMockBuilder(HttpKernelInterface::class)->getMock();
        $event = new ExceptionEvent($kernel, new Request(), 1, new \Exception('Hello World'));

        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }

}
