<?php

namespace common\constructorResults;

use common\constructor\Constructor;
use LogicException;
use yii\base\StaticInstanceTrait;

class ConstructorResultsFactory
{
    use StaticInstanceTrait;

    /**
     * @param string $type
     * @param array $config
     * @return BaseElementResult
     */
    public function make(string $type, array $config = []) : BaseElementResult
    {
        switch ($type) {
            case Constructor::SINGLE:
                return new SingleElementResult($config);
            case Constructor::FREE_ANSWER:
                return new FreeAnswerElementResult($config);
            case Constructor::DROPDOWN:
                return new DropdownElementResult($config);
            case Constructor::SCALE:
                return new ScaleElementResult($config);
            case Constructor::NPS:
                return new NpsElementResult($config);
            case Constructor::RANGING:
                return new RangingElementResult($config);
            case Constructor::NAME:
                return new NameElementResult($config);
            case Constructor::DATE:
                return new DateElementResult($config);
            case Constructor::EMAIL:
                return new EmailElementResult($config);
            default:
                throw new LogicException("Type `$type` not exist!");
        }
    }
}