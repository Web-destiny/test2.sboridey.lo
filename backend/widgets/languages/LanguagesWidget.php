<?php

namespace backend\widgets\languages;

use common\models\User;
use Yii;
use yii\base\Widget;

class LanguagesWidget extends Widget
{
    public function run()
    {

        return $this->render('languages', []);
    }
}
