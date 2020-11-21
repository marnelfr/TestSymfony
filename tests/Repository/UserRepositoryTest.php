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
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FixturesTrait;

    public function testCount(): void
    {
        self::bootKernel();
        $this->loadFixtureFiles([
            __DIR__ . '\UserRepositoryFixtures.yaml'
        ]);
        $repository = self::$container->get(UserRepository::class); //utiliser le container par defaut ne permet pas de recuperer les services privés
        $totalUser = $repository->count([]);
        self::assertEquals(10, $totalUser);
    }

}