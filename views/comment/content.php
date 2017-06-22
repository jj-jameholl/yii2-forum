<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$this->registerJs(
    '$("document").ready(function(){ 
        $("#new_comment").on("pjax:end", function() {
           $.pjax.reload({container:"#comments"});  //Reload GridView
        });
    });'
);
?>
<input type="hidden" value="<?=$user_id?>" id="writer_id">
<input type="hidden" value="<?=$title?>" id="article_title">
<input type="hidden" value="<?=$id?>" id="article_id">
<?php Pjax::begin(['id'=>'new_comment','enablePushState' => false,'linkSelector'=>false,'options'=>['data-pjax'=>true]])?>
<?php $form = ActiveForm::begin([
    'action' => ['comment/create','id' => $id,'author'=>$user_id],
    'method'=>'post',
    'options'=>['data-pjax'=>true],
]); ?>
<?= $form->field($model,'content')->widget('yidashi\markdown\Markdown',['language' => 'zh'])->label(""); ?>
<?= Html::submitButton('提交',['class'=>'btn btn-success','id'=>'reponse'])?>
<!--<button type="submit" class="btn btn-success" id="try">提交</button>-->
<hr>
<script>
    $("document").ready(function() {

    });
    </script>
<?php ActiveForm::end()?>
<?php Pjax::end()?>

