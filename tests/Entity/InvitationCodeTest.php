<?php
/**
 * Created by PhpStorm
 * User: marnel
 * Date: 21/11/2020
 * Time: 11:25
 */

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class InvitationCodeTest extends WebTestCase {

    private function getEntity(): InvitationCode {
        return (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Test description')
            ->setExpireAt(new \DateTime())
        ;
    }

    private function assertHasErrors(InvitationCode $code, int $number) {
        self::bootKernel();
        $errors = self::$container->get('validator')->validate($code);

        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = '- ' . $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        self::assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity() {
        $this->assertHasErrors($this->getEntity()->setCode(''), 0);
    }

    public function testInvalidCode() {
        $this->assertHasErrors($this->getEntity()->setCode('1d562'), 1);
        $this->assertHasErrors($this->getEntity()->setCode('1562'), 1);
    }

    public function testInvalidBlankCode() {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    public function testInvalidBlankDescription() {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }


}