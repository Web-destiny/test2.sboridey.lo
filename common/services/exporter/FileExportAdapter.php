<?php

namespace common\services\exporter;

use common\exception\FileNotSupportedException;
use common\services\importer\FileParserCSV;
use yii\base\BaseObject;

/**
 * @package common\services\exporter
 */
abstract class FileExportAdapter extends BaseObject
{
    protected array $options = [];
    protected array $header = [];
    protected array $exportData = [];
    protected string $filename = '';

    public const TYPE_EXCEL = 'EXCEL';

    /**
     * All supported types
     */
    public const SUPPORTED = [
        self::TYPE_EXCEL,
    ];

    /**
     * @param bool $exportEmptyOnError
     * @return mixed
     */
    public abstract function export(bool $exportEmptyOnError = true);

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param array $header
     * @return $this
     */
    public function setHeader(array $header): self
    {
        $this->header = $header;

        return $this;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @param array $exportData
     * @return $this
     */
    public function setExportData(array $exportData): self
    {
        $this->exportData = $exportData;

        return $this;
    }

    /**
     * @param string $key
     * @param array $default
     * @return array|mixed
     */
    public function getOption(string $key, array $default = [])
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * @return string
     */
    public static function getSupportedExts() : string
    {
        return strtolower(implode(',', self::SUPPORTED));
    }

    /**
     * @param string $type
     * @param array $config
     * @throws FileNotSupportedException
     * @return self|FileParserCSV
     */
    public static function instance(string $type, array $config = []) : self
    {
        switch (strtoupper($type)) {
            case self::TYPE_EXCEL:
                return new FileExportExcel($config);
                break;
            default:
                throw new FileNotSupxportedException(__CLASS__ . ':' . __FUNCTION__ . 'No exists in list - ' . self::getSupportedExts());
                break;
        }
    }
}