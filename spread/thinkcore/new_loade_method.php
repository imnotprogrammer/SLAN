<?php
class app{
    public static $config = [
        'people'=>[
               'class'=>'people',
               'name'=>123,
            ]
          ];
    public function __get($name){
       // $obj =  new $name;
        if(isset(self::$config[$name])){
            $objectConfig = self::$config[$name];
            if (isset($objectConfig['class'])){
               $objectName = $objectConfig['class'];
            } else{
               $objectName = $name;
            }
            $object = new $objectName;
            $class  = new ReflectionClass($objectName); // 建立 Person这个类的反射类 
            $temp = $class->getProperties(ReflectionProperty::IS_PRIVATE);
            $private_properties = array();
            foreach ($temp as $t){
                if ($t->isPrivate()){
                    $private_properties[] =  $t->getName();
                }
            }
            foreach ($objectConfig as $key => $val){
                if (property_exists($objectConfig['class'], $key) && !in_array($key, $private_properties)){
                    $object->$key = $val;
                 }
            }
            return $object; 
        }
    }
    public function __set($name,$value){
        $this->$name = $value;
    }
}
class people{
    public $name;
   public $year;
   private $sex;
    public function __construct(){
       // echo "hello world";
    }
}
class SLAN{
   static $app ;
}
function Application() {
    return  new app();
}

SLAN::$app = Application();
//var_dump(Yii::$app);
$people = SLAN::$app->people;
var_dump($people);
var_dump(property_exists('people','sex'));
//echo Yii::$app->name;