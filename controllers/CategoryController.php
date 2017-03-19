<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 28.02.2017
 * Time: 0:12
 */

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;


class CategoryController extends AppController
{
    public function actionIndex(){
       $hits = Product::find()->where(['hit'=>'1'])->limit(6)->all();
       $this->setMeta('TOP-TOP');
        return $this -> render('index', compact('hits'));
}

    public function actionView($id)
    {
         $category = Category::findOne($id);
        if(empty($category)){
            throw new HttpException (404,'Такой категории нет... ');}
       // $products = Product::find()->where(['category_id'=>$id])->all();
        $query = Product::find()->where(['category_id'=>$id]);
        $pages= new Pagination(['totalCount'=>$query->count(),'pageSize'=>3,'forcePageParam'=>false,'pageSizeParam'=>false]);
        $products =$query->offset($pages->offset)->limit($pages->limit)->all();

        $this->setMeta('TOP-TOP| '. $category->name , $category ->keywords, $category->description);
        return $this->render('view',compact('products','pages','category'));
    }


}