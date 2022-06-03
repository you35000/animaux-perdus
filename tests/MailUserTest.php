<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class MailUserTest extends TestCase
{

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User();
    }

    //tester un email
    public function testGetEmail(): void
    {
        // l'email de test
        $value = 'Luce35@sfr.fr';

        $response = $this->user->setEmail($value);


        self::assertInstanceOf(User::class, $response);

        self::assertEquals($value, 'truc');

        self::assertEquals($value, $this->user->getUserIdentifier());
    }
}
