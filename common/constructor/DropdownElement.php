<?php


namespace common\constructor;

class DropdownElement extends BaseElement
{
    protected bool $addOther = false;
    protected bool $addNeither = false;
    protected bool $addComment = false;
    protected bool $multiple = false;
    protected bool $isSkipAll = false;
    protected ?string $skipItem = null;
    protected array $inputPoint = [];
    protected array $inputPointRelated = [];

    public function fillData(array $data = []) : void
    {
        $this->addOther = !empty($data['addOther']);
        $this->addNeither = !empty($data['addNeither']);
        $this->addComment = !empty($data['addComment']);
        $this->multiple = !empty($data['multiple']);
        $this->isSkipAll = !empty($data['isSkipAll']);
        $this->skipItem = $data['skipItem'] ?? '';

        $this->inputPoint = [];
        $this->inputPointRelated = [];

        $n = 1;
        foreach ($data as $name => $value) {
            if (strpos($name, 'inputpoint_') === false) continue;

            $valueRelated = $data["related_$n"] ?? '';

            $name = 'inputpoint_' . $this->elementOrder . '_' . $n;
            $nameRelated = 'related_' . $this->elementOrder . '_' . $n;

            array_push($this->inputPoint, compact('name', 'value'));
            array_push($this->inputPointRelated, compact('nameRelated', 'valueRelated'));

            $n++;
        }
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'dropdown.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'id' => $this->id,
            'addOther' => $this->addOther,
            'addNeither' => $this->addNeither,
            'addComment' => $this->addComment,
            'multiple' => $this->multiple,
            'isSkipAll' => $this->isSkipAll,
            'skipItem' => $this->skipItem,
            'inputPoint' => $this->inputPoint,
            'inputPointRelated' => $this->inputPointRelated,
        ]);
    }
}