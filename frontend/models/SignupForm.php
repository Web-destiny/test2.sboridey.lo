<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $birth_day;
    public $gender;
    public $city;
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $region;
    public $profession;
    public $profession_comment;
    public $department;
    public $fieldofactivity;
    public $education;
    public $count_of_children;
    public $age_of_children;
    public $agreement;
    public $company_size;

    const EXCLUDE_PASSWORD = 'exclude_password';

    const SCENARIO_USER_LAST_STEP_REG = 'user-last-step-registration';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'required'],
            [['password', 'password_repeat', 'agreement', 'company_size', 'region', 'education', 'count_of_children', 'age_of_children', 'city', 'profession', 'department', 'fieldofactivity', 'first_name', 'last_name', 'phone', 'birth_day', 'gender'], 'required',  'on' => self::SCENARIO_USER_LAST_STEP_REG],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'birth_day'], 'trim'],
            [['username', 'email', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            [['phone'], 'string', 'min' => 2, 'max' => 60],
            ['gender', 'number', 'min' => 1, 'max' => 2],
            [['profession', 'department', 'fieldofactivity', 'city',], 'integer'],
            ['region', 'integer', 'message' => 'Region cannot be blank.'],
            [['profession_comment'], 'string', 'max' => 500],
            [['education', 'company_size'], 'integer'],
            ['count_of_children', 'integer', 'message' => 'Количество может быть только число!'],

            ['birth_day', 'date', 'format' => 'php:d-m-Y'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=> "Passwords don't match" ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
        if ($this->scenario == self::SCENARIO_USER_LAST_STEP_REG) {
            $this->username = Yii::$app->session->get('username');
        }

        return parent::beforeValidate();
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->setAttributes($this->attributes);
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();

        $user->save() && $this->sendEmail($user);

        return $user->id;
    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => $_SERVER['HTTP_HOST']])
            ->setTo($this->email)
            ->setSubject('Регистрация ' . $_SERVER['HTTP_HOST'])
            ->send();
    }
}
