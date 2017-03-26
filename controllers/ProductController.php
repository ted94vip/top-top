<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 01.03.2017
 * Time: 23:41
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController
{
public  function actionView($id){
    $product =Product::findOne($id);
    $category = Category::findOne($id);
    if(empty($product)){
        throw new HttpException (404,'Такого товара нет... ');}
    $hits = Product::find()->where(['new'=>'1'])->limit(6)->all();
    $this->setMeta('TOP-TOP| '. $product->name , $product ->keywords, $product->description);
    return $this->render('view',compact('product','hits'));
}

}