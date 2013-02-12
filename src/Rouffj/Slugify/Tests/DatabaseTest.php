<?php

namespace Rouffj\Slugify\Tests;

abstract class DatabaseTest extends \PhpUnit_Framework_TestCase
{
    protected function setUp()
    {
        // backups empty database
        copy(__DIR__.'/Resources/db.sqlite', __DIR__.'/Resources/db.backup');
    }

    protected function tearDown()
    {
        // restores empty database
        rename(__DIR__.'/Resources/db.backup', __DIR__.'/Resources/db.sqlite');
    }
}
