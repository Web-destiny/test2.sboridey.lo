<?php

namespace backend\models;

use common\models\User as BaseUser;
use Yii;
use yii\rbac\Assignment;
use yii\rbac\DbManager;

class User extends BaseUser
{
    public const ROLE_SUPER_ADMIN = 'super_admin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_MANAGER_CEMENT = 'manager_cement';
    public const ROLE_MANAGER_DEMO = 'manager_demo';

    public const PERMISSION_VIEW_ALL = 'ViewAll';
    public const PERMISSION_VIEW_RESULTS_ONLY = 'ViewResultOnly';
    public const PERMISSION_DEMO_USER = 'DemoUser';

    public const AUTH_ASSIGNMENTS = [

        self::ROLE_SUPER_ADMIN => [
            self::PERMISSION_VIEW_ALL,
        ],

        self::ROLE_ADMIN => [
            self::PERMISSION_VIEW_ALL,
        ],

        self::ROLE_MANAGER => [
            self::PERMISSION_VIEW_ALL,
        ],

        self::ROLE_MANAGER_CEMENT => [
            self::PERMISSION_VIEW_RESULTS_ONLY,
        ],

        self::ROLE_MANAGER_DEMO => [
            self::PERMISSION_DEMO_USER,
        ],

    ];

    public $repeat_password;
    public $birth_day;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'email', 'first_name', 'last_name', 'phone'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'when' => function($model) {
                return $model->isAttributeChanged('username');
            }, 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => User::class, 'when' => function($model) {
                return $model->isAttributeChanged('username');
            }, 'message' => 'This username has already been taken.'],
            [['username', 'email', 'first_name', 'last_name', 'phone'], 'trim'],
            [['username', 'email', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            [['phone'], 'string', 'min' => 2, 'max' => 60],
            ['password_hash', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->userRole = $this->getUserRole();
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return \common\models\User|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function isAdmin()
    {
        return Yii::$app->user->can(User::ROLE_ADMIN);
    }

    public static function isCementManager()
    {
        return Yii::$app->user->can(User::ROLE_MANAGER_CEMENT);
    }

    public static function isManager()
    {
        return Yii::$app->user->can(User::ROLE_MANAGER);
    }

    public static function isManagerDemo()
    {
        return Yii::$app->user->can(User::ROLE_MANAGER_DEMO);
    }

    public static function isSuperAdmin()
    {
        return Yii::$app->user->can(User::ROLE_SUPER_ADMIN);
    }

    public static function isAdminOrSuperAdmin()
    {
       return self::isSuperAdmin() || self::isAdmin();
    }

    /**
     * Takes only the first role in case there are more.
     *
     * @return string|null
     */
    public function getUserRole() :? string
    {
        return array_key_first(Yii::$app->authManager->getRolesByUser($this->id));
    }

    public function assignDefaultRules() : ?Assignment
    {
        $manager = new DbManager();

        $manager->revokeAll($this->id);

        $permissions = array_map(function ($permission) {
            return ['title' => $permission, 'description' => null];
        }, self::AUTH_ASSIGNMENTS[$this->userRole]);

        return $this->assignRole($this->userRole, $permissions);
    }
}