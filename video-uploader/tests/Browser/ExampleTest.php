<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;


use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use Laravel\Dusk\TestCase as AbstractDuskTestCase;

use Illuminate\Foundation\Auth\User;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('videosuploaded')
            ->assertSee('Complete List of Uploaded Videos');
        });
    }

    public function testGuiLogin(){
        $this->browse(function (Browser $browser) {
            $browser->visit( '/login' )
            ->type('email', 'kschipul@yahoo.com')
            ->type('password', 'abc123')
            ->press('login_submit')
            ->assertPathIs('/home');
        });
    }

    public function testSimpleLogin(){
        $this->browse(function ($first, $second) {
            $first->loginAs(User::find(1))
                  ->visit('/home')
                  ->logout();
        });
    }

    public function testGuiRegister(){
        $this->browse(function (Browser $browser) {

            $str = 'abcdefghijklmnopqrstuvwxyz1234567890';
            $shuffled = str_shuffle($str);

            $str2 = 'abcdefghijklmnopqrstuvwxyz';
            $shuffled2 = str_shuffle($str2);

            $browser
            ->visit( '/register' )
            ->type('name', 'Random User - ' . str_shuffle($str))
            ->type('email', "{$shuffled}@{$shuffled2}.com")
            ->type('password', 'abc123')
            ->type('password_confirmation', 'abc123')
            ->press('register_submit')
            ->assertPathIs('/registered');
        });
    }
}
