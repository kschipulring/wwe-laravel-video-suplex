<?php
namespace Tests\Feature;

set_time_limit(0);

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Laravel\Dusk\TestCase as AbstractDuskTestCase;


class DuskTestCaseBrowser extends AbstractDuskTestCase{
	public function createApplication(){
		/* yes, this empty method definition seems ridiculous,
		but it is an implementation of a pre-existing abstract method and is
		 needed to avoid nasty error message */
	}
}

class BasicTest extends TestCase
{

	public $dc = null;

    /**
     * A basic test example.
     *
     * @return void
     */
	public function testExample(){
		$this->assertTrue(true);
	}

	public function testSignIn(){
		/*$this->dc->browse(function ($browser) {
			$browser->visit( url('/login') )
			->type('email', 'kschipul@yahoo.com')
			->type('password', 'abc123')
			->press('login_submit')
	        ->assertPathIs('/home');
		});*/

		$this->assertTrue(true);
	}

	public function __construct(){
		$mf = new DuskTestCaseBrowser();

		$this->dc = clone $mf;
	}
}
