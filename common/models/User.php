<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use Carbon\Carbon;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\rbac\Assignment;
use yii\rbac\DbManager;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status *
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $region
 * @property integer $profession
 * @property integer $department
 * @property integer $fieldofactivity
 * @property integer $education
 * @property integer $count_of_children
 * @property integer $age_of_children
 * @property integer $company_size
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public $userRole;
    public $agreement;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],

            [['username', 'email'], 'required'],
            [['password', 'region', 'education', 'company_size', 'count_of_children', 'age_of_children', 'profession', 'department', 'fieldofactivity', 'city', 'first_name', 'last_name', 'phone', 'birth_day', 'gender'], 'required'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class, 'message' => 'This email address has already been taken.'],
            ['username', 'unique', 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            [['username', 'email', 'first_name', 'last_name', 'phone', 'birth_day'], 'trim'],
            [['username', 'email', 'first_name', 'last_name'], 'string', 'min' => 2, 'max' => 255],
            [['phone'], 'string', 'min' => 2, 'max' => 60],
            ['gender', 'number', 'min' => 1, 'max' => 2],
            [['region', 'profession', 'department', 'fieldofactivity', 'city', 'education'], 'integer'],
            ['count_of_children', 'integer', 'message' => 'Количество может быть только число!'],
//            ['age_of_children', 'integer', 'message' => 'Количество может быть только число!'],
//            ['age_of_children', 'string', 'min' => 1],

            [['profession_comment'], 'string', 'max' => 500],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength'], 'max' => 255],
        ];
    }

    public function beforeSave($insert)
    {
        $this->birth_day = Carbon::parse($this->birth_day)->format('Y-m-d');

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        $this->password = md5(md5($password));
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Generates new token for email verification
     */
    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Assign a new role
     *
     * [[Usage `` assignRole('admin', 1)  ``]]
     *
     * @param string $name
     * @param array $children
     * @return Assignment
     * @throws \yii\base\Exception
     */
    public function assignRole(string $name, array $children = []) : ?Assignment
    {
        $manager = new DbManager();

        if (empty($role = $manager->getRole($name))) {
            $role = $manager->createRole($name);
            $manager->add($role);
        }

        foreach ($children as $child) {
            $permission = $this->createPermission($child);

            if ($manager->hasChild($role, $permission)) {
                continue;
            }

            $manager->addChild($role, $this->createPermission($child));
        }

        if ($assignment = $manager->getAssignment($role->name, $this->getId())) {
            return $assignment;
        }

        return $manager->assign($role, $this->getId());
    }

    public function createPermission($permission)
    {
        $manager = new DbManager();

        $permissionObject = $manager->getPermission(ArrayHelper::getValue($permission, 'title'));

        if (empty($permissionObject)) {
            $permissionObject = $manager->createPermission(ArrayHelper::getValue($permission, 'title'));

            $manager->add($permissionObject);
        }

        return $permissionObject;
    }

    public function deletePermission($permission)
    {
        $manager = new DbManager();

        $permissionObject = $manager->getPermission($permission);

        if (!empty($permissionObject)) {
            $manager->remove($permissionObject);
        }

    }

    public static function sendEmailforConsultation($model) {
        $emailParams = [];
        $emailParams = ArrayHelper::merge($emailParams, [
            'name' => $model->name,
            'email' => $model->email,
            'phone' => $model->phone,
            'comment' => $model->comment,
        ]);

        $emailsCeo = (Yii::$app->params['SEOUsersEmails'] ?? []);

        Yii::$app->mailer
            ->compose('@common/mail/consultation', ArrayHelper::merge($emailParams, [
                'model' => $model,
            ]))
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setTo($model->email)
            ->setBcc($emailsCeo)
            ->setSubject('Сбор идей: Инструкция по работе с платформой')
            ->send();
    }

    public function getUserProfiles()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

}
