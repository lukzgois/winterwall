<?php

use App\Domain\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_validates_the_login_form()
    {
        $this->visit('/login')
                ->type('notemail', 'email')
                ->press('Login')
                ->see("O campo E-mail não contém um endereço de email válido.")
                ->see("O campo Senha é obrigatório.");
    }

    /** @test */
    public function it_protect_against_incorrect_login() 
    {
        $this->visit('/login')
                ->type("notregister@winterwall.com", 'email')
                ->type('password', 'password')
                ->press('Login')
                ->see('E-Mail e/ou Senha incorretos.');
    }

    /** @test */
    public function it_allows_registered_users_to_login() 
    {
        $user = factory(User::class)->create(['password'=>'123456']);
        $this->visit('/login')
                ->type($user->email, 'email')
                ->type('123456', 'password')
                ->press('Login')
                ->seePageIs('/');
    }

    /** @test */
    public function it_dont_allow_logged_users_to_login_again() 
    {
        $user = factory(User::class)->create(['password'=>'123456']);
        $this->actingAs($user)
                ->visit('/login')
                ->seePageIs('/');
    }

    /** @test */
    public function it_allows_logged_users_to_logout() 
    {
        $user = factory(User::class)->create(['password'=>'123456']);
        $this->actingAs($user)
                ->visit('/logout')
                ->dontSeeIsAuthenticated();
    }
}
