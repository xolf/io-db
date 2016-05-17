<?php

require_once __DIR__ . '/autoload.php';

class TableTest extends PHPUnit_Framework_TestCase
{
    private $dir = __DIR__ . '/io';

    public function testSetGetDir()
    {
        $dir = new \Xolf\io\Directory($this->dir);
        $table = new \Xolf\io\Table($dir);
        $this->assertEquals($dir, $table->getDir());
        $table->flush();
        $this->assertFalse($table->getDir()->exists());
    }

}
