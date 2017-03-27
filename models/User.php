<?php

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
class User extends ActiveRecord implements IdentityInterface
{
      const STATUS_DELETED=0;
      Const STATUS_ACTIVE=10;

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
       /* return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;*/
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    public static function tableName()
    {
        return '{{%user}}';
    }
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;*/

        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;*/
        return static::find()->where(['login =:login OR email=:email',[":email"=>$email] , 'status' => self::STATUS_ACTIVE]);

    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        /*return $this->id;*/
        return $this->getPrimaryKey();

    }
    public  function  getOrder()
    {
        return $this->hasOne(Order::className(),['id_user'=>'id']);
    }
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        //return $this->authKey;
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
       // return $this->authKey === $authKey;
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
        //return $this->password === $password;
        return Yii::$app->security->validatePassword($password, $this->password);
    }
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

}
