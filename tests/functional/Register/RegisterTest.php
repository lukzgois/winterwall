<?php

use Hash;
use App\Domain\Users\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RegisterTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_validates_the_register_form() 
    {
        $this->visit('/register')
            ->press('Cadastrar')
            ->see('O campo Nome é obrigatório.')
            ->see('O campo E-Mail é obrigatório.')
            ->see('O campo Senha é obrigatório.');

        $this->visit('/register')
                ->type('notemail', 'email')
                ->press('Cadastrar')
                ->see('O campo E-mail não contém um endereço de email válido.');
    }

    /** @test */
    public function it_protects_against_repeated_email()
    {
        $user = factory(User::class)->create();

        $this->visit('/register')
                ->type('name', 'name')
                ->type('password', 'password')
                ->type($user->email, 'email')
                ->press('Cadastrar')
                ->see('O valor indicado para o campo E-mail já se encontra utilizado.');
    }

    /** @test */
    public function it_registers_a_new_user() 
    {
        $this->visit('/register')
                ->type('Gandalf', 'name')
                ->type('gandalf@middleearth.com', 'email')
                ->type('youshallnotpass', 'password')
                ->press('Cadastrar');

        $user = User::where([
            'name' => 'Gandalf',
            'email' => 'gandalf@middleearth.com'
        ])->first();

        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('youshallnotpass', $user->password));
    }
}
