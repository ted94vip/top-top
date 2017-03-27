<?php

namespace app\models;

use Yii;
use yii\base\Model;

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
    public $login;
    public $email;
    public $password;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'email', 'login',  'password' ], 'required'],
            [['login','email'], 'trim'],
            [['login'], 'string', 'min' => 2, 'max' => 255],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['name', 'email', 'address'], 'string', 'max' => 255],
            [['email'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'Этот адрес электронной почты уже используется!!!.'],
            [['email'], 'email'],
            [['password'], 'string', 'length' => [6,12],'message' => 'Пароль должен быть от 6 до 12 символов'],
            [['login'], 'unique', 'targetClass' => '\app\models\User', 'message' => 'Это имя уже используется!!!'],
                    ];
    }
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
    /**
     * @inheritdoc
     */
   /* public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'login' => 'Login',
            'address' => 'Address',
            'auth_key' => 'Auth Key',
            'password' => 'Password',
            'status' => 'Status',
            'paassword_reset_token' => 'Paassword Reset Token',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }*/
}
