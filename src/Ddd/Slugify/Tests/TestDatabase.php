<?php

namespace Ddd\Slugify\Tests;

class TestDatabase
{
    private $databasePath;
    private $backupPath;

    public function __construct()
    {
        $this->databasePath = __DIR__.'/Resources/db.sqlite';
        $this->backupPath = __DIR__.'/Resources/db.backup';
    }

    public static function backup()
    {
        $database = new self();
        copy($database->databasePath, $database->backupPath);
    }

    public static function restore()
    {
        $database = new self();
        rename($database->backupPath, $database->databasePath);
    }
}
