<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19.03.2017
 * Time: 16:25
 */

namespace app\models;
use yii\db\ActiveRecord;

class Cart extends ActiveRecord
{
 public function addToCart($product, $qty=1){
    if(isset($_SESSION['cart'][$product->id])){
        $_SESSION['cart'][$product->id]['qty'] +=$qty;
    }
     else{
         $_SESSION['cart'][$product->id]=[
             'qty'=>$qty,
             'name'=>$product->name,
             'price'=>$product->price,
             'img'=>$product->img,
         ];
     }
     $_SESSION['cart.qty']=isset($_SESSION['cart.qty'])? $_SESSION['cart.qty'] +$qty : $qty;
     $_SESSION['cart.sum']=isset($_SESSION['cart.sum'])? $_SESSION['cart.sum'] +$qty*$product->price: $qty*$product->price;

 }
    public function recalc($id){
        if(!isset($_SESSION['cart'][$id])) return false;
        $qtyminus = $_SESSION['cart'][$id]['qty'];
        $summinus = $_SESSION['cart'][$id]['qty']*$_SESSION['cart'][$id]['price'] ;
        $_SESSION['cart.qty']-=$qtyminus;
        $_SESSION['cart.sum']-=$summinus;
        unset($_SESSION['cart'][$id]);

    }
}