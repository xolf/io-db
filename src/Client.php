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


    private $table;

    /**
     * Client constructor.
     * @param string $dir
     */
    public function __construct($dir = __DIR__ . '/../../../io-db')
    {
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
     * Flushes all the directory
     *
     * @throws Exception
     */
    public function flush()
    {
        $this->getDir()->flush();
    }

}
