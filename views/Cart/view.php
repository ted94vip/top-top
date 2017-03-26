<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<div class="container" >
    <?php if(Yii::$app->session->hasFlash('success')):?>
    <div class="alert alert-success alert-dismissable" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
     <?php echo Yii::$app->session->getFlash('success');?>
    </div>
    <?php endif;?>
    <?php if(Yii::$app->session->hasFlash('error')):?>
        <div class="alert alert-danger alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span> </button>
            <?php echo Yii::$app->session->getFlash('error');?>
        </div>
    <?php endif;?>
    <?php if(!empty($session['cart'])):?>
        <div class="table-responsive">
            <table class="table table-hover table-striped"
            <thead>
            <tr>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Сумма</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach($session['cart'] as $id=>$item):?>
                <tr>
                    <td><?=\yii\helpers\Html::img("@web/images/product/{$item['img']}",['alt'=>$item['name'],'height'=>50])?></td>
                    <td><a href="<?=Url::to(['product/view','id'=>$id])?>"><?=$item['name']?></a></td>
                    <td><?=$item['qty']?></td>
                    <td><?=$item['price']?></td>
                    <td><?=$item['qty']*$item['price']?></td>

            <?php endforeach;?>
            <tr>
                <td colspan="4">Итого:</td>
                <td> <?= $session['cart.qty']?></td>
            </tr>
            <tr>
                <td colspan="4">На сумму:</td>
                <td> <?= $session['cart.sum']?></td>
            </tr>
            </tbody>
            </table>
        </div>
        <hr/>
        <?php  $form = ActiveForm::begin()?>
        <?= $form->field($order,'name')?>
        <?= $form->field($order,'email')?>
        <?= $form->field($order,'phone')?>
        <?= $form->field($order,'address')?>
        <?= Html::submitButton('Заказать',['class'=>'btn btn-success'])?>
        <?php  $form = ActiveForm::end()?>
    <?php else:?>
        <h3>Корзина пуста</h3>
    <?php endif;?>


</div>
