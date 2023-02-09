<?php


namespace common\constructor;

class DateElement extends BaseElement
{
    protected int $amount = 1;

    public function fillData(array $data = []) : void
    {
        $this->amount = (!empty($data['amount']) ? intval($data['amount']) : 1) ?: 1;
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'date.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'amount' => $this->amount
        ]);
    }
}