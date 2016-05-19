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
        $io->flush();
        for($i = 1; $i <= 1000; $i++)
        {
            $this->assertFalse(is_dir($this->dir . DIRECTORY_SEPARATOR . 'test' . $o));
        }
    }

    public function testDocument()
    {
        $io = new \Xolf\io\Client($this->dir);
        $io->table('test')->document('test')->write(['test' => true]);
        $this->assertTrue($io->table('test')->document('test')->test);
        $io->table('test')->document('test')->write(['name' => 'Master']);
        $this->assertEquals('Master', $io->table('test')->document('test')->name);
        $io->flush();
    }

    public function testBenchmark()
    {
        $io = new \Xolf\io\Client($this->dir);
        $limit = 100;
        for($t = 1; $t <= $limit; $t++)
        {
            for($d = 1; $d <= $limit; $d++)
            {
                $io->table($t)->document($d)->write(['running_test' => 'test: ' . $d]);
            }
        }
        for($t = 1; $t <= $limit; $t++)
        {
            $this->assertEquals($limit, $io->table($t)->info()->documents);
            $this->assertEquals("5", $io->table($t)->info()->document[4]->name);
            for($d = 1; $d <= $limit; $d++)
            {
                $this->assertEquals('test: ' . $d, $io->table($t)->document($d)->running_test);
            }
        }
        $io->flush();
    }

    public function testWhere()
    {
        $io = new \Xolf\io\Client($this->dir);
        $test_table = $io->table('test');
        $test_table->document('hendrix')->write(['name' => 'Hendrix', 'mail' => 'hendrix@gmail.com']);
        $test_table->document('tourner')->write(['name' => 'Tourner', 'mail' => 'tourner@gmail.com']);
        $this->assertEquals($test_table->document('tourner'), $test_table->documents()->where(['name','=','Tourner']));
    }

}
