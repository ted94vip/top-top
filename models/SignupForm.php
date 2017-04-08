<?php

namespace app\models;

use Yii;
use yii\base\Model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $login
 * @property string $address
 * @property string $auth_key
 * @property string $password
 * @property integer $status
 * @property string $paassword_reset_token
 * @property integer $created_at
 * @property integer $updated_at
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $name;
    /**
     * @inheritdoc
     */
    public static function  tableName()
    {
        return 'user';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот имя уже используется!!!.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['name', 'trim'],
            ['name', 'required'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот адрес электронной почты уже используется!!!'],
            ['password', 'required'],
            ['password', 'string', 'length' => [6,12],'message' => 'Пароль должен быть от 6 до 12 символов'],
            ];
    }
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'name' => 'Имя',
            'email' => 'Email',
            'username' => 'Логин',
            'address' => 'Адрес',
            'password' => 'Пароль',

        ];
    }
}
