<?php

namespace Slayer\Config;

class AppTest extends \PHPUnit_Framework_TestCase
{
    public function testAppFile()
    {
        $this->assertContains(config('app.debug'), [
            true,
            false,
        ]);

        $this->assertContains(config()->app->debug, [
            true,
            false,
        ]);
    }
}
