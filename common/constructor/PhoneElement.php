<?php


namespace common\constructor;

class PhoneElement extends BaseElement
{
    public function fillData(array $data = []) : void
    {

    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'phone.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [

        ]);
    }
}