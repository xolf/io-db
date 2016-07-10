<?php

namespace Xolf\io;

class Document
{
    /**
     * @var string
     */
    private $_name;

    /**
     * @var string
     */
    private $_path;

    /**
     * @var array
     */
    private $_data = [];

    /**
     * Document constructor.
     * @param string $name
     * @param Table $table
     */
    public function __construct($name, Table $table)
    {
        $this->setName($name);
        $this->setPath($table->getDocumentPath($this->getName()));
        $this->read();
        return $this;
    }

    /**
     * @return mixed
     */
    private function getPath()
    {
        return $this->_path;
    }

    /**
     * @param mixed $path
     */
    private function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    private function setName($name)
    {
        $this->_name = $name;
        $this->_name = str_replace('/', '', $this->_name);
        $this->_name = str_replace('?', '', $this->_name);
        $this->_name = str_replace('<', '', $this->_name);
        $this->_name = str_replace('>', '', $this->_name);
        $this->_name = str_replace(';', '', $this->_name);
        $this->_name = str_replace('}', '', $this->_name);
        $this->_name = str_replace('{', '', $this->_name);
        $this->_name = str_replace("\n", '', $this->_name);
        $this->_name = str_replace(':', '-', $this->_name);
        $this->_name = str_replace('.', '-', $this->_name);
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        if(null === $data)
        {
            $data = [];
        }
        if(is_object($data))
        {
            $data = json_decode(json_encode($data), true);
        }
        $this->_data = $data;
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
     * Reads a document
     *
     * @return null
     */
    public function read()
    {
        if(file_exists($this->getPath()) && filesize($this->getPath()) > 0)
        {
            $data = file_get_contents($this->getPath());
            if(trim($data) == "") $data = "{}";
            $data = json_decode($data);
            $this->setData($data);
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
     * @param $content array
     */
    public function write(array $content)
    {
        if(!is_string($content))
        {
            $content = json_encode($content);
        }
        $content = json_decode($content, true);
        $this->setData(array_merge($this->getData(), $content));

        $this->flush();
        file_put_contents($this->getPath(), json_encode($this->getData()));
    }

    /**
     * Moves a document to a table
     *
     * @param Table $table
     * @return $this
     */
    public function moveTo(Table $table)
    {
        $this->read();
        $this->flush();
        $this->setPath($table->getDocumentPath($this->getName()));
        $this->write([]);
        return $this;
    }

}
