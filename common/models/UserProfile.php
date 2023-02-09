<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $has_car есть машина или нет
 * @property int|null $car_mark модель машины
 * @property int|null $model_car модель машины
 * @property string|null $class_car класс машины
 * @property int|null $income_level уровень дохода
 * @property int|null $monthly_income_per_member месячный доход каждого челна семьи
 * @property int|null $personal_income_level личный месячный доход
 * @property int|null $banks
 * @property int|null $bank_services банковские услуги, продукты
 * @property int|null $purchases покупки
 * @property int|null $operators операторы
 * @property int|null $what_did_you_do what did you do
 * @property int|null $Which_of_the_following_do_you_have
 * @property int|null $provider интернет провайдер
 * @property int|null $smoking Вы курите?
 * @property int|null $what_smoking если курите, то что именно курите
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['user_id'], 'required'],
            [['user_id', 'has_car', 'car_mark', 'model_car', 'income_level', 'monthly_income_per_member', 'personal_income_level', 'banks', 'bank_services', 'purchases', 'operators', 'what_did_you_do', 'Which_of_the_following_do_you_have', 'provider', 'smoking', 'what_smoking'], 'integer'],
            [['class_car'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'has_car' => 'Есть ли у Вас в семье личный автомобиль',
            'car_mark' => 'Укажите марку',
            'model_car' => 'Укажите модель',
            'class_car' => 'Класс автомобиля',
            'income_level' => 'Укажите Ваш уровень дохода',
            'monthly_income_per_member' => 'Какой месячный доход на одного члена Вашей семьи',
            'personal_income_level' => 'Каков Ваш личный месячный доход',
            'banks' => 'Услугами каких банков Вы пользуетесь (не более 5 ответов)',
            'bank_services' => 'Какими банковскими/финансовыми продуктами/услугами вы пользовались за последний год или пользуетесь в настоящие время',
            'purchases' => 'Что из перечисленного Вы покупали в интернет-магазинах онлайн за последние 3 месяца',
            'operators' => 'Услугами какого оператора или операторов связи Вы пользуетесь в настоящий момент(не более 3 ответов)',
            'what_did_you_do' => 'Что из перечисленного вы лично делали',
            'Which_of_the_following_do_you_have' => 'Что из перечисленного есть у Вас',
            'provider' => 'Услугами какого или каких из перечисленных ниже интернет-провайдеров вы пользуетесь?',
            'smoking' => 'Вы курите',
            'what_smoking' => 'Если  Да, то что курите?',
        ];
    }

    public function getUser()
    {
        $user = User::find()->where(['id' => $this->user_id])->one();
        return $user;
    }

}
