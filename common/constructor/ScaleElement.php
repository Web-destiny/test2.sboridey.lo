<?php


namespace common\constructor;

class ScaleElement extends BaseElement
{
    protected string $scaleType = '';
    protected int $scale = 0;
    protected int $scaleAmount = 0;
    protected bool $rateLabels = false;
    protected array $inputPoint = [];

    public function fillData(array $data = []) : void
    {
        $this->scale = intval($data['scale']);
        $this->scaleType = $data['scaleType'];
        $this->scaleAmount = intval($data['scaleAmount']);
        $this->rateLabels = !empty($data['rateLabels']);

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
        return $this->renderFile(self::VIEW_PATH . 'scale.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'scaleType' => $this->scaleType,
            'scaleAmount' => $this->scaleAmount,
            'rateLabels' => $this->rateLabels,
            'inputPoint' => $this->inputPoint,
        ]);
    }
}