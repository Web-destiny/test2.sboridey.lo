<?php


namespace common\constructor;

class NpsElement extends BaseElement
{
    protected string $npsType = '';
    protected int $nps = 0;
    protected int $npsAmount = 0;
    protected bool $rateLabels = false;
    protected array $inputPoint = [];
    protected string $addNpsOption = '';
    protected array $npsAction = [];
    protected string $npsDiapasoneStart = '';
    protected string $npsDiapasoneEnd = '';

    public function fillData(array $data = []) : void
    {
        $this->nps = intval($data['nps']);
        $this->npsType = $data['npsType'];
        $this->npsAmount = intval($data['npsAmount']);
        $this->rateLabels = !empty($data['rateLabels']);
//        $this->npsAction = (!empty($data['npsAction'])) ? $data['npsAction'] : '';
        $this->addNpsOption = (!empty($data['addNpsOption'])) ? $data['addNpsOption'] : '';
        $this->npsDiapasoneStart = (!empty($data['npsDiapasoneStart'])) ? $data['npsDiapasoneStart'] : '';
        $this->npsDiapasoneEnd = (!empty($data['npsDiapasoneEnd'])) ? $data['npsDiapasoneEnd'] : '';

        $this->inputPoint = [];
        $this->npsAction = [];

        $n = 1;

       // dd($data);

        foreach ($data as $name => $value) {
            if (strpos($name, 'inputpoint_') === false) continue;

            $name = 'inputpoint_' . $this->groupData['number'] . '_' . $this->elementOrder . '_' . $n;

            array_push($this->inputPoint, compact('name', 'value'));

            $n++;
        }

        $k = 0;
        foreach ($data as $name => $value) {
            if (strpos($name, 'npsAction_') === false) continue;


            $name = 'npsAction_' . $this->elementOrder;
//            $name = 'npsAction_' . $this->elementOrder . '_' . $k;
//            $name = $k > 0 ? 'npsAction' . $this->elementOrder . '_' . $k : 'npsAction' . $this->elementOrder;

            array_push($this->npsAction, compact('name', 'value'));

            $k++;
        }
//        dd($this->npsAction);
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'nps.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'npsType' => $this->npsType,
            'npsAmount' => $this->npsAmount,
            'rateLabels' => $this->rateLabels,
            'inputPoint' => $this->inputPoint,
            'addNpsOption' => $this->addNpsOption,
            'npsAction' => $this->npsAction,
            'npsDiapasoneStart' => $this->npsDiapasoneStart,
            'npsDiapasoneEnd' => $this->npsDiapasoneEnd,
        ]);
    }
}