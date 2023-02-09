<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\UserProfile $model */

$this->title = 'Create User Profile';
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-profile-create">

    <h1>Расширенный профиль</h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $user_id,
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
