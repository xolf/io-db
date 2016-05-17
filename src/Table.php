<?php

namespace Xolf\io;

class Table
{

    /**
     * @var Directory
     */
    private $dir;

    public function __construct($directory)
    {
        $this->dir = $directory;
        $this->touch();
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
     * Touches a table
     *
     * @throws Exception
     */
    public function touch()
    {
        $this->dir->create(true);
    }

    /**
     * Flushes a table
     *
     * @throws Exception
     */
    public function flush()
    {
        $this->dir->flush();
    }

    /**
     * Returns some Information
     *
     * @return mixed
     */
    public function info()
    {
        $info['name'] = $this->dir->getPath();
        $info['name'] = explode(DIRECTORY_SEPARATOR, $info['name']);
        $info['name'] = $info['name'][count($info['name']) - 1];

        return json_decode(json_encode($info));
    }

}
