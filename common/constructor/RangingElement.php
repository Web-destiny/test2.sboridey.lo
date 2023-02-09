<?php


namespace common\constructor;

class RangingElement extends BaseElement
{
    protected array $inputPoint = [];

    public function fillData(array $data = []) : void
    {
        $this->inputPoint = [];

        $n = 1;
        foreach ($data as $name => $value) {
            if (strpos($name, 'inputpoint_') === false) continue;

            $name = 'inputpoint_' . $this->groupData['number'] . '_' . $this->elementOrder . '_' . $n;

            array_push($this->inputPoint, compact('name', 'value'));

            $n++;
        }
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'ranging.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'inputPoint' => $this->inputPoint,
        ]);
    }
}