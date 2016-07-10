<?php

namespace Xolf\io;

class Finder
{

    /**
     * If the exact value need to be find
     */
    const EXACT_CLAUSE = 'exact';

    /**
     * @var Table
     */
    private $table;

    /**
     * @var string
     */
    private $_clause;

    /**
     * @var object
     */
    private $statement;

    /**
     * @var array
     */
    private $documents = [];

    /**
     * Finder constructor.
     * @param Table $table
     */
    public function __construct(Table $table)
    {
        $this->setTable($table);
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
     * @return string
     */
    public function getClause()
    {
        return $this->_clause;
    }

    /**
     * @param string $clause
     */
    public function setClause($clause)
    {
        $this->_clause = $clause;
    }

    /**
     * @return object
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @param object $statement
     */
    public function setStatement($statement)
    {
        $this->statement = $statement;
    }

    /**
     * @return array
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param array $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @param Document $document
     */
    private function addDocument(Document $document)
    {
        if(!in_array($document, $this->getDocuments())) $this->documents[$document->getName()] = $document;
    }

    public function search($query)
    {

    }

    /**
     * @param array $statement
     */
    private function __polishWhereStatement(array $statement)
    {
        if(count($statement) > 0)
        {
            foreach ($statement as $field => $value)
            {
                if(!is_int($field))
                {

                    $this->setClause(self::EXACT_CLAUSE);

                    if(isset($field) && isset($value))
                    {
                        $state[] = ['field' => $field, 'value' => $value];
                    }
                }
            }
        }
        else
        {
            throw new Exception("Unknow statment structure " . var_export($statement, true));
        }

        return json_decode(json_encode($state));
    }

    /**
     * @param array $statement
     */
    public function where(array $statement)
    {
        $this->setStatement($this->__polishWhereStatement($statement));
        if($this->getClause() == self::EXACT_CLAUSE)
        {
            $documents = $this->getTable()->getAllDocuments();
            foreach ($documents as $document)
            {
                foreach ($this->getStatement() as $i => $statement)
                {
                    $field = $statement->field;
                    if($document->$field == $statement->value)
                    {
                        $this->addDocument($document);
                    }
                }
            }
        }
        return $this->getDocuments();
    }

}
