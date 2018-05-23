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
            ->assertSee('wrestling');

            //var_dump( $browser );

            //$browser->visit('videosuploaded');
        });
    }
}
