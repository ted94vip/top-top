<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 02.03.2017
 * Time: 23:50
 */


namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;
use yii\web\HttpException;


class SearchController extends AppController
{
    public function actionView()
    {$q=trim(yii::$app->request->get('q'));
        $this->setMeta('TOP-TOP| Поиск: '. $q);
        if(!$q)
            return $this->render('search');
        $query = Product::find()->where(['like','name',$q]);
        $pages= new Pagination(['totalCount'=>$query->count(),'pageSize'=>6,'forcePageParam'=>false,'pageSizeParam'=>false]);
        $products =$query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search',compact('products','pages','q'));
    }
}