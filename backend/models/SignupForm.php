<?php

namespace backend\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $username;
    public $email;
    public $password_hash;
    public $repeat_password;

    public $userRole;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            [['username', 'email', 'first_name', 'last_name', 'phone'], 'trim'],
            [['username', 'email', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            [['phone'], 'string', 'min' => 2, 'max' => 60],
            ['password_hash', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'max' => 255],
            ['repeat_password', 'compare', 'compareAttribute'=>'password_hash', 'message'=> "Passwords don't match" ],
        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate()
    {
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
        $user->userRole = $this->userRole;
        $user->setAttributes($this->attributes);
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password_hash);
        $user->generateAuthKey();

        if ($user->save()) {
            $user->assignDefaultRules();

            return true;
        }

        return false;
    }
}
