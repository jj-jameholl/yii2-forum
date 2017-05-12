<html>
<body>
<video id='me' src="video/1.mp4" controls="controls" width="200" height="400">
</video>
<img src="<?=Yii::getAlias('@photo').'/2.jpg'?>">
<!--<embed src="video/1.mp4"></embed>-->
<!--<div class="embed-responsive embed-responsive-16by9">-->
<!--    <iframe class="embed-responsive-item" src="video/1.mp4"></iframe>-->
<!--</div>-->
<!--<div class="embed-responsive embed-responsive-16by9">-->
<!--        <iframe class="embed-responsive-item" src="--><?//=Yii::getAlias('@video').'/test.ogg'?><!--"></iframe>-->
<!---->
<!--<!--  -->--><?php
////  echo Yii::getAlias('@video').'/test.ogg';
////  ?>
<!--</div>-->
</body>
<script type="text/javascript">
    Media = document.getElementById("me");
    $("#me").click(function() {
        if(Media.paused) {
            Media.play();
        }else{
            Media.pause();
        }
       // alert("33");
    });
</script>
</html>