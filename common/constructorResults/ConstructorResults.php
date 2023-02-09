<?php

namespace common\constructorResults;

use common\constructor\Constructor;
use Yii;
use yii\helpers\ArrayHelper;

class ConstructorResults
{
    public const SUPPORTED_TYPES = [
        Constructor::SINGLE,
        Constructor::FREE_ANSWER,
        Constructor::DROPDOWN,
        Constructor::SCALE,
        Constructor::NPS,
        Constructor::RANGING,
        Constructor::NAME,
        Constructor::DATE,
        Constructor::EMAIL,
    ];

    protected ConstructorResultsDTO $constructorResultsDTO;

    protected array $htmlPartials = [];

    public function __construct(int $id, array $options = [])
    {
        $this->constructorResultsDTO = new ConstructorResultsDTO($id, self::SUPPORTED_TYPES, $options);

        $this->calculate();

        $this->setHtmlPartials();
    }

    public function getHtmlPartials(): array
    {
        return $this->htmlPartials;
    }

    public function getConstructorResultsDTO(): ConstructorResultsDTO
    {
        return $this->constructorResultsDTO;
    }

    public function calculate(): void
    {
        ArrayHelper::getColumn(self::SUPPORTED_TYPES, function (string $type) {
            if (!empty($this->constructorResultsDTO->factories[$type])) {
                $this->constructorResultsDTO->factories[$type]->calculate();
            }
        });
    }

    protected function setHtmlPartials(): void
    {
        ArrayHelper::getColumn(self::SUPPORTED_TYPES, function (string $type) {
            if (!empty($this->constructorResultsDTO->factories[$type])) {
                $this->htmlPartials = ArrayHelper::merge($this->htmlPartials, $this->constructorResultsDTO->factories[$type]->renderData());
            }
        });
    }

    public function render(): string
    {
        ArrayHelper::multisort($this->htmlPartials, 'order');

        return implode("", ArrayHelper::getColumn($this->htmlPartials, 'html'));
    }
}