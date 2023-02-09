<?php


namespace common\constructor;

class MatrixElement extends BaseElement
{
    protected bool $addComment = false;
    protected bool $multiple = false;
    protected array $inputRow = [];
    protected array $inputCol = [];

    public function fillData(array $data = []) : void
    {
        $this->addComment = !empty($data['addComment']);
        $this->multiple = !empty($data['multiple']);

        $this->inputRow = [];
        $this->inputCol = [];

        $n = 1;
        foreach ($data as $name => $value) {
           if( (strpos($name, 'inputRow_') === false)) continue;

            $name = 'inputRow_' . $this->groupData['number'] . '_' . $this->elementOrder . '_' . $n;

            array_push($this->inputRow, compact('name', 'value'));

            $n++;
        }


        $n = 1;
        foreach ($data as $name => $value) {
            if( (strpos($name, 'inputCol_') === false)) continue;

            $name = 'inputCol_' . $this->groupData['number'] . '_' . $this->elementOrder . '_' . $n;

            array_push($this->inputCol, compact('name', 'value'));

            $n++;
        }
    }

    public function getElementHTML() : string
    {
        return $this->renderFile(self::VIEW_PATH . 'matrix.php', $this->toArray());
    }

    public function toArray() : array
    {
        return array_merge($this->getOptions(), [
            'addComment' => $this->addComment,
            'multiple' => $this->multiple,
            'inputRow' => $this->inputRow,
            'inputCol' => $this->inputCol,
        ]);
    }
}