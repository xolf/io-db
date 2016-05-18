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

    public function testTouch()
    {
        $dir = new \Xolf\io\Directory($this->dir);
        $table = new \Xolf\io\Table($dir);
        $table->touch();
        $this->assertTrue(is_dir($this->dir));
        $table->flush();
        $this->assertFalse($table->getDir()->exists());
    }

    public function testFlush()
    {
        $dir = new \Xolf\io\Directory($this->dir);
        $table = new \Xolf\io\Table($dir);
        $table->flush();
        $this->assertFalse(is_dir($this->dir));
    }

    public function testInfo()
    {
        $dir = new \Xolf\io\Directory($this->dir);
        $table = new \Xolf\io\Table($dir);
        $table->flush();
        $this->assertFalse(is_dir($this->dir));
    }

}
