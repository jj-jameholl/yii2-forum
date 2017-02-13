<?php
class test{
private $name;
private $sex;
function __construct(){
$this->aaa= 1;
}
}

$test=new test(1);

$reflect=new ReflectionClass('test');
$pro=$reflect->getConstructor();
foreach ($pro->getParameters() as $hh){
    if ($hh->isDefaultValueAvailable()) {
        echo "1";
  //      echo $hh->getDefaultValue();
    } else {
      echo   $c = $hh->getClass();
        //echo "2";
    //    echo $c;
    }
}
print_r($pro);//打印结果：Array ( [name] => [sex] => )
