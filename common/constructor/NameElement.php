<?php


namespace common\constructor;

class NameElement extends BaseElement
{
    public function fillData(array $data = []) : void
    {

    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'name.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [

        ]);
    }
}