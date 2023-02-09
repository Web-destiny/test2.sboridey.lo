<?php


namespace common\constructor;

use common\constructor\traits\ElementSession;
use yii\base\Widget;
use yii\web\UploadedFile;

/**
 * Class BaseElement
 * @package common\constructor
 *
 * Example Single:
 * -----------------------------------------------------
 * [type] => single
 * [element_order] => 1
 * [file] => ['', ''] | null
 * [question] => voproc1
 * [elements] => Array
 * (
     * [required_1] => on
     * [inputpoint_1_1] => aaa
     * [addOther_1] => on
     * [addNeither_1] => on
     * [addComment_1] => on
     * [multiple_1] => on
     * [inputpoint_1_2] => bbbbbbbbbb
     * [inputpoint_1_3] => Другое
     * [inputpoint_1_4] => Ничего из вышеперечисленного
 * )
 * -----------------------------------------------------
 */
abstract class BaseElement extends Widget
{
    use ElementSession;

    public const VIEW_PATH = '@common/constructor/view/';

    public const PUBLIC_STORAGE = '@backend/web/constructor';
    public const PUBLIC_STORAGE_URL = 'constructor';

    private array $data = [];

    protected array $groupData = [];

    protected array $elementDetails = [];

    protected ?string $type = null;

    protected ?bool $hasFile = null;

    /**
     * @var null|string|UploadedFile
     */
    protected $file = null;

    protected ?string $fileOriginalType = null;

    protected ?string $fileType = null;

    protected ?string $fileBase64 = null;

    protected array $fileAttribute = [];

    protected int $elementOrder = 0;

    protected ?string $uniqueKey = null;

    protected ?string $question = null;

    protected bool $required = false;

    public function __construct(array $data = [], array $groupData = [])
    {
        $this->data = $data;
        $this->groupData = $groupData;

        $this->setType();
        $this->setElementOrder();
        $this->setUniqueKey();
        $this->setQuestion();
        $this->setRequired();
        $this->setElementDetails();

        $this->setHasFile();

        $this->setFile();

        $this->fillData($this->elementDetails);

        parent::__construct([]);
    }

    abstract public function fillData(array $data) : void;

    abstract public function getElementHTML() : string;

    abstract protected function toArray() : array;

    protected function getFileKey() : string
    {
        $prefix = empty($this->groupData['number'])
            ? $this->elementOrder
            : $this->groupData['number'] . '_' . $this->elementOrder;

        return Constructor::getId() . "_constructor_file_{$prefix}_{$this->type}_{$this->elementOrder}";
    }

    protected function setType(): void
    {
        $this->type = (string) $this->data['type'];
    }

    protected function setHasFile(): void
    {
        $this->hasFile = boolval($this->data['hasFile'] ?? false);
    }

    protected function isElementGeneratedFromSession() : bool
    {
        return false;
    }

    private function setFile() : void
    {
        if ($this->isElementGeneratedFromSession()) {
            $this->updateFileInfoFromSession();
            return;
        }

        if ($this->isElementGeneratedFromPost()) {
            $this->savePostFile();
            return;
        }

        // checking in DB
        if (!empty($this->data['file'])) {
            $fileObject = json_decode($this->data['file'], true);
            if (!empty($fileObject)) {
                $this->file = $fileObject['file'];
                $this->fileType = $fileObject['fileType'];
                $this->fileOriginalType = $fileObject['fileOriginalType'];
            }

        }
    }

    protected function savePostFile(): void
    {
        if (empty($this->hasFile)) {
            $this->deleteFileFromSession(); // for any cases
        }

        $this->file = !empty($this->data['file'][0]) && $this->data['file'][0] instanceof UploadedFile ? $this->data['file'][0] : null;

        if (empty($this->file)) {
            return;
        }

        if (!is_dir(\Yii::getAlias(self::PUBLIC_STORAGE))) {
            mkdir(\Yii::getAlias(self::PUBLIC_STORAGE));
        }

        $this->fileType = $this->data['file'][1] ?? null;

        $this->fileOriginalType = $this->file->type;

        $fileName = $this->getFileKey() . '.' . $this->file->getExtension();

        $this->file->saveAs(self::PUBLIC_STORAGE . '/'. $fileName);

        $this->file = $fileName;
    }

    protected function setUniqueKey(): void
    {
        $this->uniqueKey = $this->data['unique_key'] ?? '';
    }

    public function getUniqueKey(): string
    {
        return $this->uniqueKey;
    }

    protected function setElementOrder(): void
    {
        $this->elementOrder = intval($this->data['element_order'] ?? 0);
    }

    protected function setQuestion(): void
    {
        $this->question = (string) $this->data['question'];
    }

    protected function setRequired(): void
    {
        $this->required = !empty($this->data['elements']['required']);
    }

    protected function setElementDetails(): void
    {
        $this->elementDetails = $this->data['elements'] ?? [];

        if (!empty($this->elementDetails['required'])) {
            unset($this->elementDetails['required']);
        }
    }

    protected function isElementGeneratedFromPost() : bool
    {
        $prefix = empty($this->groupData['number'])
            ? $this->elementOrder
            : $this->groupData['number'] . '_' . $this->elementOrder;

        return !empty(\Yii::$app->request->post('type_' . $prefix));
    }

    public function getOptions() : array
    {
        return array_merge([
            'groupNamePrefix' => empty($this->groupData['number'])
                ? $this->elementOrder
                : $this->groupData['number'] . '_' . $this->elementOrder,
            'groupData' => $this->groupData,
            'required' => $this->required,
            'question' => $this->question,
            'elementOrder' => $this->elementOrder,
            'hasFile' => (bool)$this->hasFile,
            'file' => $this->file,
            'fileType' => $this->fileType,
            'fileOriginalType' => $this->fileOriginalType,
        ], \Yii::$app->session->get($this->getFileKey(), []));
    }
}