<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 26.02.2017
 * Time: 21:12
 */

namespace app\models;
use yii\db\ActiveRecord;

class Product extends ActiveRecord
{
    public static function  tableName()
    {
        return 'product';
    }
    public function  getCategory()
    {return $this->hasOne(Category::className(),['id' => 'category_id']);}
}