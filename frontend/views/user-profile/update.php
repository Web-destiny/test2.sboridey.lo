<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */

$this->title = 'Update User Profile: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-profile-update">

    <h1><h1>Расширенный профиль</h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'carMarkArray' => $carMarkArray,
        'carModelArray' => $carModelArray,
        'carTypeArray' => $carTypeArray,
        'incomeLevelArray' => $incomeLevelArray,
        'monthlyIncomePerMemberArray' => $monthlyIncomePerMemberArray,
        'personalIncomeLevelArray' => $personalIncomeLevelArray,
        'banksArray' => $banksArray,
        'bankServicesArray' => $bankServicesArray,
        'purchasesArray' => $purchasesArray,
        'WhichOfTheFollowingDoYouHaveArray' => $WhichOfTheFollowingDoYouHaveArray,
        'operatorsArray' => $operatorsArray,
        'whatDidYouDoArray' => $whatDidYouDoArray,
        'providerArray' => $providerArray,
        'whatSmokingArray' => $whatSmokingArray,
    ]) ?>

</div>
