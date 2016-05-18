<?php

namespace Xolf\io;

class Directory
{

    /**
     * @var string
     */
    private $path;

    /**
     * Standard value: 0755
     * @var int
     */
    private $mode;

    /**
     * Directory constructor.
     * @param null $path Directory path
     * @param null $mode Directory mode
     */
    public function __construct($path = null, $mode = null)
    {
        $this->setPath($path);
        $this->setMode($mode);
        $this->exists();
        return $this;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getMode()
    {
        if(null === $this->mode) $this->setMode(0755);
        return $this->mode;
    }

    /**
     * @param int $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * If the directory exists
     *
     * @return mixed
     * @throws Exception
     */
    public function exists()
    {
        if(!$this->getPath())
        {
            throw new Exception("Directory is not set");
        }

        return is_dir($this->getPath());
    }

    /**
     * Creates a directory
     *
     * @return bool
     * @throws Exception
     */
    public function create($touch = false)
    {
        if(!$this->exists())
        {
            if(!mkdir($this->getPath(), $this->getMode(), true))
            {
                throw new Exception("Directory could not be created: " . $this->getPath());
            }
            else
            {
                return $this;
            }
        }
        else if(!$touch)
        {
            throw new Exception("Directory already exists: " . $this->getPath());
        }
        return $this;
    }

    /**
     * Deletes directory
     *
     * @return bool
     * @throws Exception
     */
    public function flush()
    {
        if($this->exists())
        {
            $it = new \RecursiveDirectoryIterator($this->getPath(), \RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($this->getPath());
            return $this;
        }
        return false;
    }

}
