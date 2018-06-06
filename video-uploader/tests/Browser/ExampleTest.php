<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;


use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Foundation\Testing\DatabaseTransactions;


use Laravel\Dusk\TestCase as AbstractDuskTestCase;



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

    public function testBasicLogin(){
        $this->browse(function (Browser $browser) {
            $browser->visit( '/login' )
			->type('email', 'kschipul@yahoo.com')
			->type('password', 'abc123')
			->press('login_submit')
			->assertPathIs('/home')
	        ->pause(10000);
        });
    }
}
