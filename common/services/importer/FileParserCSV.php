<?php

namespace common\services\importer;

/**
 * @package common\services\importer
 */
class FileParserCSV extends FileImportAdapter
{
    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $columns;

    /**
     * @return void
     */
    public function parse() : void
    {
        $this->attributes = array_map('str_getcsv', file($this->file));

        if (empty($this->attributes) || count($this->attributes) < 1) return;

        $this->columns = $this->attributes[0];
        array_shift($this->attributes);
    }

    /**
     * @return array
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @return array
     */
    public function toArray() : array
    {
        return $this->findAttributes();
    }
}