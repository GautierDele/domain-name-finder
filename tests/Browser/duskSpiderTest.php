<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class duskSpiderTest extends DuskTestCase
{
    protected static $url = 'https://feldarkrealms.com/';

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(self::$url)
                ->click('#generate_words')
                ->pause(1000)
                ->screenshot('test');
        });
    }
}
