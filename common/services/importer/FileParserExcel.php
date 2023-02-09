<?php

namespace common\services\importer;

use common\exception\FileNotSupportedException;
use common\services\importer\excel\SimpleXLSX;

/**
 * @package common\services\importer
 */
class FileParserExcel extends FileImportAdapter
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
    public function parse(): void
    {
        $xlsx = new SimpleXLSX($this->file);

        $this->attributes = $xlsx->rows();

        if (empty($this->attributes) || count($this->attributes) < 1) return;

        $this->columns = $this->attributes[0];
        array_shift($this->attributes);
    }

    /**
     * @return array
     * @throws FileNotSupportedException
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array
     * @throws FileNotSupportedException
     */
    public function toArray() : array
    {
        $translateAttributes = func_get_args()[0] ?? [];

        return $this->findAttributes($translateAttributes);
    }
}