<?php

require_once __DIR__ . '/autoload.php';

class ClientTest extends PHPUnit_Framework_TestCase
{
    private $dir = __DIR__ . '/io';

    public function testSetGetDir()
    {
        $dir = new \Xolf\io\Directory($this->dir);
        $io = new \Xolf\io\Client();
        $io->setDir($dir);
        $this->assertEquals($dir, $io->getDir());
        $io->getDir()->create();
        $io->flush();
        $this->assertFalse($io->getDir()->exists());
    }

    public function testSetGetMode()
    {
        $io = new \Xolf\io\Client($this->dir);
        $io->setMode(0600);
        $this->assertEquals(0600, $io->getMode());
        $this->assertEquals(0600, $io->getDir()->getMode());
    }

    public function testSetGetTable()
    {
        $directory = new \Xolf\io\Directory($this->dir . DIRECTORY_SEPARATOR . 'test');
        $table = new \Xolf\io\Table($directory);
        $io = new \Xolf\io\Client($this->dir);
        $io->setTable($table);
        $this->assertEquals($table, $io->getTable());
        $this->assertEquals($directory, $io->getTable()->getDir());
        $io->flush();
    }

    public function testTable()
    {
        $io = new \Xolf\io\Client($this->dir);
        for($i = 1; $i <= 1000; $i++)
        {
            $o = round($i / 1);
            $io->table('test' . $o);
            $this->assertTrue(is_dir($this->dir . DIRECTORY_SEPARATOR . 'test' . $o));
        }
        for($i = 1; $i <= 1000; $i++)
        {
            $o = round($i / 1);
            $io->table('test' . $o)->flush();
            $this->assertFalse(is_dir($this->dir . DIRECTORY_SEPARATOR . 'test' . $o));
        }
        $io->flush();
    }

    public function testDocument()
    {
        $io = new \Xolf\io\Client($this->dir);
        //var_dump($io->table('test')->document('test'));
        $io->table('test')->document('test')->write(['test' => true]);
        var_dump($io->table('test')->document('test'));
        die;
        sleep(20);
        $io->flush();
    }

}
