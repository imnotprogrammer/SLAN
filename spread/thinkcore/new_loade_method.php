<?php
class app{
    public static $config;
    public function __construct($config){
        self::$config = $config;
    }
    public function __get($name){
       // $obj =  new $name;
        if(isset(self::$config[$name])){
            $objectConfig = self::$config[$name];
            if (isset($objectConfig['class'])){
               $objectName = $objectConfig['class'];
            } else{
               $objectName = $name;
            }
            //$object = new $objectName;
            $class  = new ReflectionClass($objectName); // 建立 $object类的反射类 
            $properties = $class->getProperties(ReflectionProperty::IS_PRIVATE);
            $private_properties = array();
            foreach ($properties as $t){
                if ($t->isPrivate()){
                    $private_properties[] =  $t->getName();
                }
            }
			$object = $class->newInstance(); 
            foreach ($objectConfig as $key=>$val){
                if (property_exists($objectConfig['class'], $key) && !in_array($key, $private_properties)){
                    $object->$key = $val;
                 }
            }
            return $object; 
        }else{
			throw new Execption('not found Class'.$name);;
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
class slan{
    public $version;
}
class Yii{
   static $app ;
}
class Application{
    public $config;
    public function __construct($config) {
        $this->config = $config;
    }
    public function run(){
         $app =  new app($this->config);
         //var_dump($app);
         return $app;
    }
   
}
$config = [
            'people'=>[
                   'class' => 'people',
                   'name'  => 123,
                   'year'  => 23,
                   'sex'   => 1,
                   'hello' => 2
            ],
            'slan'=>[
                 'class'   => 'slan',
                 'version' => '2.0'
            ]
            
         ];
Yii::$app =  (new Application($config))->run();
//$people = Yii::$app->people;

//$slan = Yii::$app->slan;
$slan = Yii::$app->slans;
