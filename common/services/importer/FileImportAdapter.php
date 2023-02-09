<?php

namespace common\services\importer;

use common\exception\FileNotSupportedException;
use yii\web\UploadedFile;

/**
 * @package common\services\importer
 */
abstract class FileImportAdapter
{
    public const FILE_STORAGE = '@backend/web/uploads/';

    public const TYPE_CSV = 'CSV';
    public const TYPE_EXCEL = 'EXCEL';

    /**
     * All supported files
     */
    public const SUPPORTED = [
        self::TYPE_CSV,
        self::TYPE_EXCEL,
    ];

    /**
     * @var array
     */
    protected array $attributes;

    /**
     * @var array
     */
    protected array $columns;

    /**
     * Those are the columns in the file we should be taking
     *
     * @var null|array|string[]
     */
    protected ?array $onlyAttributes;

    /**
     * @var string
     */
    protected string $file;

    /**
     * @var array
     */
    protected array $data = [];

    public function __clone()
    {
        $this->file = null;
    }

    public function __isset($name)
    {
        return isset($this->toArray()[$name]);
    }

    /**
     * @param mixed $args
     * @return array
     */
    abstract function toArray() : array;

    abstract function parse() : void;

    abstract function getAttributes() : array;

    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @param array|null $onlyAttributes
     * @return $this
     */
    public function setOnlyAttributes(?array $onlyAttributes = null) : self
    {
        $this->onlyAttributes = $onlyAttributes;

        return $this;
    }

    /**
     * @return string
     */
    public static function getSupportedExts() : string
    {
        return strtolower(implode(',', self::SUPPORTED));
    }

    /**
     * @param $file
     * @param array|null $attributes
     * @return $this
     */
    public function load($file, ?array $attributes = null): self
    {
        if ($file instanceof UploadedFile) {
            if (!is_dir(\Yii::getAlias(self::FILE_STORAGE))) {
                mkdir(\Yii::getAlias(self::FILE_STORAGE));
            }

            $fileName = 'imported.' . $file->getExtension();
            $file->saveAs(self::FILE_STORAGE . $fileName);
            $file = $fileName;
        }

        $this->file = \Yii::getAlias(self::FILE_STORAGE . $file);

        $this->setOnlyAttributes($attributes)->parse();

        return $this;
    }

    public function findAttributes()
    {
        $translateAttributes = func_get_args()[0] ?? [];

        $array = [];

        array_walk($this->attributes, function ($value, $key) use (&$array, $translateAttributes) {
            array_walk($this->columns, function ($name, $index) use (&$array, $translateAttributes, $value, $key) {
                if (is_null($this->onlyAttributes) || in_array($name, $this->onlyAttributes)) {
                    if (empty($array[$key])) $array[$key] = [];

                    $name = $translateAttributes[$name] ?? $name;

                    $array[$key][$name] = $this->attributes[$key][$index];
                }
            });
        });

        return $array;
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
            case self::TYPE_CSV:
                return new FileParserCSV($config);
                break;
            case self::TYPE_EXCEL:
                return new FileParserExcel($config);
                break;
            default:
                throw new FileNotSupportedException(__CLASS__ . ':' . __FUNCTION__ . 'No exists in list - ' . self::getSupportedExts());
                break;
        }
    }
}