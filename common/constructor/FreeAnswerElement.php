<?php


namespace common\constructor;

class FreeAnswerElement extends BaseElement
{
    protected int $amount = 0;

    public function fillData(array $data = []) : void
    {
        $this->amount = !empty($data['amount']) ? intval($data['amount']) : 0;
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'free-answer.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'amount' => $this->amount
        ]);
    }
}