<?php

namespace Xolf\io;

class Table
{

    /**
     * @var Directory
     */
    private $dir;

    /**
     * Ending for the files
     */
    const ENDING = '.json';

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
     * Gets the Path for documents
     *
     * @param $document
     * @return string
     */
    public function getDocumentPath($document)
    {
        return $this->dir->getPath() . DIRECTORY_SEPARATOR . $document . self::ENDING;
    }

    /**
     * Gets document
     *
     * @param $name
     * @return Document
     */
    public function document($name)
    {
        return new Document($name, $this);
    }

    /**
     * Gives the table name
     *
     * @return string
     */
    public function getName()
    {
        $name = $this->dir->getPath();
        $name = explode(DIRECTORY_SEPARATOR, $name);
        $name = $name[count($name) - 1];
        return $name;
    }

    /**
     * Returns some Information
     *
     * @return mixed
     */
    public function info()
    {
        return json_decode(json_encode([
            'name' => $this->getName()
        ]));
    }

}
