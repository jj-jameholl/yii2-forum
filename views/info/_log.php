<style>
    .log{
        padding-top: 10px;
        padding-bottom: 10px;

    }
    .image {
        margin-top: -2px;
    }
    .pagination > li > a, .pagination > li:first-child > span, .pagination > li:last-child > a, .pagination > li:last-child > span, .pagination > li:first-child > a{
        margin-left: 8px;
        border-radius: 20px;
        background-color:#eee ;
    }
    .pagination >.active > a {
        background-color: #1abc9c;
    }
    .pagination > .active > a:hover{
        background-color: #16a085;
    }
    .pagination > li > a:hover{
        background-color: #eee;
    }
</style>
<div class="basic-div">
    <img class="image" src="/uploads/avatar/<?=$model->fuser->id?>/<?=$model->fuser->photo?>"><?=$model->fuser->username.' 回复您: '.$model->content;?>
</div>