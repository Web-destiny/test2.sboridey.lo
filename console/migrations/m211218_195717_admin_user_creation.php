<?php

use backend\models\User;
use yii\db\Migration;
use yii\helpers\Console;

/**
 * Class m211218_195717_admin_user_creation
 */
class m211218_195717_admin_user_creation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $admin = User::findOne(['email' => $email = 'admin@gmail.com']) ?: new User();
        $admin->generateAuthKey();
        $admin->generatePasswordResetToken();
        $admin->status = User::STATUS_ACTIVE;
        $admin->username = 'admin';
        $admin->email = $email;
        $admin->password = '123';

        if ($admin->save()) {
            $admin->assignRole(User::ROLE_SUPER_ADMIN);

            Console::output("User imported!");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211218_195717_admin_user_creation cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211218_195717_admin_user_creation cannot be reverted.\n";

        return false;
    }
    */
}
