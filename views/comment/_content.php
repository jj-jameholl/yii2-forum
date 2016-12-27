<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii\helpers\Url;
use app\models\Comment;
use app\models\User;
/* @var $this yii\web\View */
/* @var $model app\models\Comment */
/* @var $form yii\widgets\ActiveForm */
?>
<?php

$this->registerJs(
    '$("document").ready(function(){
//        $("#commentone").on("pjax:end", function() {
//             //$.pjax.reload({container:"#comments"});  //Reload GridView
//        });
            $("#submit").click(function(){
            if($(this).parent().find("input").filter(".input1").val()==""){
                var data = {"kind":"reponse1","content":$(this).parent().find("textarea").val(),"article_id":'.$id.',"writer_id":$("#writer").val(),"user_id":'.Yii::$app->user->identity->id.',"photo":"'.User::findimgbyid(Yii::$app->user->identity->id).'"}
                ws.send(JSON.stringify(data));
            }
		var my = $(this);
            $.ajax({
                url:"'.Url::toRoute(["/comment/createson"]).'",
                data:{"content":$(this).parent().find("textarea").val(),"article_id":'.$id.',"id":$(this).parent().find("input").filter(".input2").val(),"towho":$(this).parent().find("input").filter(".input1").val()},
               	beforeSend:function(){
		$(".loading").removeClass("hidden");
		$(".loading").prependTo(my.parent());
		},
		 success:function(data){
                    if(data==1){
                    $.pjax.reload({container:"#comments"});
                    }
                    else{
                    alert("error");
                    }
                }
            });
            });
    });'
);
?>
<?php $form = ActiveForm::begin([
    'id'=>'tryit',
    'action' => ['comment/createson','article_id'=>$id],
    'method'=>'post',
    'options'=>['data-pjax'=>'true'],
]); ?>
<?=$form->field($model,'content')->textarea(['rows'=>2])->label("");?>
<input type="hidden" class="input1" name="towho">
<input type="hidden" class="input2" name="id">
<input type="hidden" class="input3" id="writer">
<input type="button" class="btn btn-success" id="submit" value="提交">
<?php ActiveForm::end()?>

