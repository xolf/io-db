<?php

require_once __DIR__ . '/autoload.php';

class DirectoryTest extends PHPUnit_Framework_TestCase
{

    private $dir = __DIR__ . '/io';

    public function testExists()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $this->assertFalse($directory->exists());
    }

    public function testGetSetPath()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $directory->setPath(__DIR__ . '/io-2');
        $this->assertEquals(__DIR__ . '/io-2', $directory->getPath());
    }

    public function testGetSetMode1()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $this->assertEquals(0755, $directory->getMode());
    }

    public function testGetSetMode2()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $directory->setMode(0600);
        $this->assertEquals(0600, $directory->getMode());
    }

    public function testCreate()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $this->assertTrue(false !== $directory->create());
    }

    public function testFlush()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $this->assertTrue(false !== $directory->flush());
    }

    public function testFollow()
    {
        $directory = new \Xolf\io\Directory($this->dir);
        $this->assertTrue(false !== $directory->create()->flush());
    }

}
