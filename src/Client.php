<?php

namespace Xolf\io;

class Client
{

    /**
     * @var int
     */
    private $mode;

    /**
     * @var Directory
     */
    private $dir;

    /**
     * @var Table
     */
    private $table;

    /**
     * Client constructor.
     * @param string $dir
     */
    public function __construct($dir = false)
    {
        if(!$dir) $dir = __DIR__ . '/../../../io-db';
        $this->dir = new Directory($dir);
    }

    /**
     * @return Directory
     */
    public function getDir()
    {
        return $this->dir;
    }

    /**
     * @param Directory $dir
     */
    public function setDir($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
        $this->getDir()->setMode($mode);
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param Table $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * Flushes all the directory
     *
     * @throws Exception
     */
    public function flush()
    {
        $this->getDir()->flush();
    }

    /**
     * @param $name
     * @return Table
     */
    public function table($name)
    {
        if(null !== $this->getTable())
        {
            if ($name == $this->getTable()->getName())
            {
                return $this->getTable();
            }
        }
        $this->setTable(new Table(new Directory($this->getDir()->getPath() . DIRECTORY_SEPARATOR . $name, $this->getMode())));
        return $this->getTable();
    }

}
