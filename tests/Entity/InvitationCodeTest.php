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

class InvitationCodeTest extends WebTestCase {

    public function testValidEntity() {
        $code = (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Test description')
            ->setExpireAt(new \DateTime())
        ;

        $errors = (self::bootKernel())
            ->getContainer()
            ->get('validator')
            ->validate($code);

        self::assertCount(0, $errors);
    }

    public function testInvalidCode() {
        $code = (new InvitationCode())
            ->setCode('1d545')
            ->setDescription('Test description')
            ->setExpireAt(new \DateTime())
        ;

        $errors = (self::bootKernel())
            ->getContainer()
            ->get('validator')
            ->validate($code)
        ;

        self::assertCount(1, $errors);
    }


}