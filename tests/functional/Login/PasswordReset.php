<?php

use App\Domain\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PasswordReset extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        if (file_exists(storage_path('log/laravel.log'))) {
            unlink(storage_path('log/laravel.log'));
        }
    }

    /** @test */
    public function it_validates_if_the_email_exists() 
    {
        $this->visit('/forgot-password')
            ->type("noemail@test.com", 'email')
            ->press('Enviar recuperação de senha')
            ->see('Não encontramos o email informado em nosso sistema.');
    }

    /** @test */
    public function it_sends_an_email_with_the_recovery_link()
    {
        $user = factory(User::class)->create();

        $this->visit('/forgot-password')
            ->type($user->email, 'email')
            ->press('Enviar recuperação de senha')
            ->see('Um link para redefinição de senha foi enviado para o seu e-mail.');

        $this->seeInFile('Link', storage_path('logs/laravel.log'));
    }
}
