<?php

namespace common\components;

use yii\base\Event;

class LanguageChangedEvent extends Event
{
    /**
     * @var string the new language
     */
    public $language;

    /**
     * @var string|null the old language
     */
    public $oldLanguage;
}