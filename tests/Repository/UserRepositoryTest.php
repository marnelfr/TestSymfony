<?php
/**
 * Created by PhpStorm
 * User: marnel
 * Date: 21/11/2020
 * Time: 08:38
 */

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{

    public function testCount(): void
    {
        $kernel = self::bootKernel();
        $container = $kernel->getContainer();
        $repositoy = $container->get(UserRepository::class); //utiliser le container par defaut ne permet pas de recuperer les services privés
        $totalUser = $repositoy->count([]);
        $this->assertEquals(10, $totalUser);
    }

}