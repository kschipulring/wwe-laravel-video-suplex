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
            ->assertSee('Complete');

            //var_dump( $browser );

            //$browser->visit('videosuploaded');
        });
    }

    public function testBasicLogin(){


        $this->browse(function (Browser $browser) {
            /*$browser->visit('videosuploaded')
            ->assertSee('wrestling');*/

            //var_dump( $browser );

            //$browser->visit('videosuploaded');




            //echo "app('env') = " . app('env') . "\n";

            echo 'env("APP_ENV") = ' . env("APP_ENV") . "\n";

            //var_dump( Config::getItems() );

            $browser->visit( '/login' )
			->type('email', 'kschipul@yahoo.com')
			->type('password', 'abc123')
			->press('login_submit')
	        ->pause(10000);

			/*$browser->visit( '/login' )
			->type('email', 'kschipul@yahoo.com')
			->type('password', 'abc123')
			->pause(1000000);*/
        });
    }
}
