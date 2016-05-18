<?php

namespace Xolf\io;

class Document
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $path;

    private $handler;

    /**
     * Document constructor.
     * @param string $name
     * @param Table $table
     */
    public function __construct($name, Table $table)
    {
        $this->setName($name);
        $this->setPath($table->getDocumentPath($name));
        $this->read();
        return $this;
    }

    /**
     * @return mixed
     */
    private function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    private function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    private function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    private function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    private function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param mixed $handler
     */
    private function setHandler($handler)
    {
        $this->handler = $handler;
    }

    /**
     * Flushes a document
     */
    public function flush()
    {
        if(file_exists($this->getPath()))
        {
            unlink($this->getPath());
        }
    }

    /**
     * Opens a document
     */
    public function open()
    {
        $this->setHandler(fopen($this->getPath(), "w"));
    }

    /**
     * Reads a document
     *
     * @return null
     */
    public function read()
    {
        if(file_exists($this->getPath()) && filesize($this->getPath()) > 0)
        {
            $this->open();
            $data = fread($this->getHandler(), filesize($this->getPath()));
            if(trim($data) == "") $data = "{}";
            $data = json_decode($data);
            foreach ($data as $key => $value)
            {
                $this->$key = $value;
            }
        }
        return null;
    }

    /**
     * Writes a document
     *
     * @param $content
     */
    public function write($content)
    {

        var_dump((array) $this);

        if(!is_string($content))
        {
            $content = json_encode($content);
        }

        var_dump($content);

        $this->flush();
        $this->open();
        fwrite($this->getHandler(), $content);
        $this->close();
    }

    /**
     * Close the handler
     */
    public function close()
    {
        if(null !== $this->getHandler())
        {
            fclose($this->getHandler());
        }
    }

}
