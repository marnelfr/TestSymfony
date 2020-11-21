<?php
/**
 * Created by PhpStorm
 * User: marnel
 * Date: 21/11/2020
 * Time: 08:38
 */

namespace App\Tests\Repository;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    public function testCount(): void
    {
        self::bootKernel();
        $this->loadFixtures([UserFixtures::class]);
        $repositoy = self::$container->get(UserRepository::class); //utiliser le container par defaut ne permet pas de recuperer les services privés
        $totalUser = $repositoy->count([]);
        $this->assertEquals(10, $totalUser);
    }

}