 <?php
/**
 * @param $get 传递需要获取的值
 * @return null
 * 使用例子:g('get') 等价于 传统的 $_GET['get'];
 */
function g($get){
    if($_GET){
        return isset($_GET[$get])?$_GET[$get]:NULL;
    }else{
        return NULL;
    }
}

/**
 * @param $post 传递需要获取的值
 * @return null
 * 使用例子:p('post') 等价于 传统的 $_POST['post'];
 */
function p($post){
    if($_POST){
        return isset($_GET[$post])?$_GET[$post]:NULL;
    }else{
        return NULL;
    }
}

/**
 * @param $sname
 * @return null
 * 使用例子:s('sname') 等价于 传统的 $_SESSION['sname'];
 */
function s($sname){
    if($_SESSION){
        return isset($_GET[$post])?$_GET[$post]:NULL;
    }else{
        return NULL;
    }
}

/**
 * @param $code
 * @param $msg
 * @param array $data
 */
function returnMsg($code, $msg, $data=array())
{
    $message = array(
        "code" => $code,
        "msg"  => $msg
    );
    if(is_array($data)){
        foreach($data as $infos){
            $message['data'][] = $infos;
        }
    }
    echo json_encode($message);
}

/**
 * @param $url
 * @param null $path
 * @return bool|string
 */
function getUrlContent($url, $path=null){
    $content = file_get_contents($url);
    if($path==null){
        return $content;
    }
    return saveContent($path,$content);
}

/**
 * @param $path
 * @return bool
 */
function saveContent($path,$content){
    if (file_put_contents($path,$content)) {
        return true;
    }else{
        return false;
    }
}

/**
 * @return float
 * 生成带毫秒数的时间，其中以浮点数的方式返回
 */
function getMTime(){
    list($msec,$sec) = microtime();
    return ((float)$msec + ($sec));
}

/**
 * @param string $tag
 * @param null $MTime
 * @return bool|string
 * //格式化带毫秒的时间
 */
function formatMTime($tag='u', $MTime=null){
    if(is_null($MTime)){
        $MTime = microtime(true);
    }
    $inttime = floor($MTime);
    $militime = round(($MTime - $inttime) * 1000000);
    return date(str_replace('u',$militime,$tag));
}

/**
 * @param $start
 * @param $end
 * @param $size
 * @return array
 * //得到在以start为起点，end为中点，产生size个互不相同的随机数，start必须小于end，size<(start+end)
 */
function getRandArr($start, $end, $size){
    $count = 0;
    $return = array();
    if(($end-$start+1) < $size)
        return $return;
    while ($count < $size) {
        $return[] = mt_rand($start, $end);
        $return = array_flip(array_flip($return));  //将数组键名与键值相互调换
        $count = count($return);
    }
    return $return;
}
//产生十个互不相同的随机数
function getRand($num,$start,$end){        
    if($start-$end>0 || $num ==0 || $end-$start<$num){            
        return false;            
    }        
    $rs = $boolarr =  array();        
    //$boolarr初始初始化        
    for( $i = 0; $i < $num; $i++ ) {            
        $boolarr[$i] = false;           
    }        
    $temp = 0;
    //chans产生产生不同随机数产生不同随机数不同；
    for( $i = 0; $i < $num; $i++ ) {		   
         $temp = mt_rand($start,$end);         
         do{               
             $temp = mt_rand($start,$end);
         }while($boolarr[$temp]);             
        $rs[$i] = $temp;         
        $boolarr[$temp] = true;
    }
	return $rs;        
}   
function isadmin(){
	//echo $_SESSION['userid'];
	if(isset($_SESSION['userid']) && !empty($_SESSION['userid'])){
		if($_SESSION['usertype'] == 0){
			return 0;
		}else if($_SESSION['usertype'] == 1){
			return 1;
		}else if($_SESSION['usertype'] == 2){
			return 2;
		}else{
			return 3;
		}
	}else{
		return 4;
	}
} 
function getPageStart(){
	return isset($_GET['page'])?($_GET['page']-1)*10:0;
}
function pageSize(){
	return 10;
}
function download($path){
    $arr = explode('/',$path);
    $filename = $arr[count($arr)-1];
    if(!file_exists($path)){
    	echo '下载失败！';
    	exit();
    }
    $filesize = filesize($path);
    $fp = fopen($path,"r");
    header("Content-type: application/octet-stream");
    header("Accept-Ranges: bytes");
    header("Accept-Length:".$filesize);
    header("Content-Disposition: attachment; filename=".$filename);
    $buffer = 1024;
    $file_count=0;
    //向浏览器返回数据
    while(!feof($fp) && $file_count<$filesize){
    	$file_con = fread($fp,$buffer);
    	$file_count += $buffer;
    	echo $file_con;
    }
    fclose($fp);
}
function returnjson($code,$msg){
	exit(json_encode(array("code"=>$code,"msg"=>$msg)));
}
function timeup($arr,$parm){
	date_default_timezone_set('Etc/GMT-8');
	foreach($arr as $key=>$val){
		
		$arr[$key][$parm] = date("Y-m-d H:i:s",$val[$parm]);
	}
	return $arr;
}

//获取文件目录列表,该方法返回数组
function getDir($dir) {
	$dirArray[]=NULL;
	if (false != ($handle = opendir ( $dir ))) {
		$i=0;
		while ( false !== ($file = readdir ( $handle )) ) {
			//去掉"“.”、“..”以及带“.xxx”后缀的文件
			if ($file != "." && $file != ".." && count(explode('.',$file)<2)) {
				$dirArray[$i]='./upload/zip/'.$file;
				$i++;
			}
		}
		//关闭句柄
		closedir ( $handle );
	}
	return $dirArray;
}
//将文件加入压缩包
function create_zip($arrfiles,$filename) {
	$zipName = $filename.'.zip'; //获得文件名
	//dir_create(dirname($zipName)); //建立生成压缩文件的目录
	$zip = new ZipArchive();
	if ($zip->open($zipName, ZIPARCHIVE::CREATE) !== TRUE) {
		return false;
	}
	foreach ($arrfiles as $path) {
		if (is_file($path)) {//判断文件是否存在
			$zip->addFile($path, basename($path)); //把文件加入到压缩包中
		}
	}
	$zip->close();
	return $zipName;
}
function deldir($dir){
	//删除目录下的文件：
	$dh=opendir($dir);
	while ($file=readdir($dh)){
		if($file!="." && $file!=".."){
			$fullpath=$dir."/".$file;
			if(!is_dir($fullpath)){
				unlink($fullpath);
			}else{
				deldir($fullpath);
			}
		}
	}
	closedir($dh);
}
function convert($size) { 
        $unit=array('b','kb','mb','gb','tb','pb'); 
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i]; 
 } 
 function curl($url,$params=false,$ispost=0){
		
		$httpInfo = array();
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
		curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
		curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		if( $ispost ){
			curl_setopt( $ch , CURLOPT_POST , true );
			curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
			curl_setopt( $ch , CURLOPT_URL , $url );
		}else{
			if($params){
				curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
			}else{
				curl_setopt( $ch , CURLOPT_URL , $url);
			}
		}
		$response = curl_exec( $ch );
		if ($response === FALSE) {
			//echo "cURL Error: " . curl_error($ch);
			return false;
		}
		$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		curl_close( $ch );
		return $response;
}
/** 
* @param String $var   要查找的变量 
* @param Array  $scope 要搜寻的范围 
* @param String        变量名称 
*/  
function get_variable_name(&$var, $scope=null){  
  
    $scope = $scope==null? $GLOBALS : $scope; // 如果没有范围则在globals中找寻  
  
    // 因有可能有相同值的变量,因此先将当前变量的值保存到一个临时变量中,然后再对原变量赋唯一值,以便查找出变量的名称,找到名字后,将临时变量的值重新赋值到原变量  
    $tmp = $var;  
      
    $var = 'tmp_value_'.mt_rand();  
    $name = array_search($var, $scope, true); // 根据值查找变量名称  
  
    $var = $tmp;  
    return $name;  
}
function  route($arr){
	$userqq = isset($_GET['QQ'])?$_GET['QQ']:null;
	$jiqiren = isset($_GET['jiqiren'])?$_GET['jiqiren']:null;
	$msg = str_replace(' ', '', isset($_GET['msg'])?$_GET['msg']:null);
	preg_match('/^农场([\x80-\xff]+)/i', $msg,$match_command);
	preg_match('/^农场([\x80-\xff]+)([0-9-\|]+)/i', $msg,$match_params);
	//print_r($match_params);die();
	if(!empty($match_command) && !empty($match_params)){
		$match = $match_params;
	}else{
		$match = $match_command;
	}
	//print_r($match);die();
	if(empty($match[1])){
		echo '你的命令格式不正确';
	}else{
		$msg = $match[1];
		$temp = $msg;
		//echo $temp;
		if($addgoodstr = strstr($temp, '添加商品')){
			$msg = '添加商品';
			$_SESSION['addgood'] = getValue('msg');
			//echo $addgoodstr;die();
		}
		if($adddaoju = strstr($temp,'添加道具')){
			$msg = '添加道具';
			$_SESSION['adddaoju'] = getValue('msg');
		}
		
		if(strstr($temp,'播种') && empty(strpos($temp, '一键播种'))){
			$msg = '播种';
			$_SESSION['bozhong'] = getValue('msg');
		}
		if(strstr($temp,'施肥') && empty(strpos($temp, '一键施肥'))){
			$msg = '施肥';
			$_SESSION['shifei'] = getValue('msg');
		}
		if(strstr($temp, '一键施肥')){
			$msg = '一键施肥';
			$_SESSION['onekeyshifei'] = getValue('msg');
		}
		if(strstr($temp, '一键收获')){
			$msg = '一键收获';
			$_SESSION['onekeyget'] = getValue('msg');
		}
		
		if(isset($match[2])&&!empty($match[2])){
			$_SESSION['code'] = $match[2];
		}
		if(strstr($temp, '一键播种')){
			$msg = '一键播种';
			$_SESSION['onekeyget'] = getValue('msg');
		}
		if(strstr($temp, '卖出')&& empty(strstr($temp, '全部卖出'))){
			$msg = '卖出';
			$_SESSION['sellmsg'] = getValue('msg');
		}
		if(strstr($temp, '摘取')&& empty(strstr($temp, '一键摘取'))){
			$msg = '摘取';
			$_SESSION['zhaiqumsg'] = getValue('msg');
		}
		if(strstr($temp, '送礼')){
			$msg = '送礼';
			$_SESSION['giftmsg'] = getValue('msg');
		}
		//echo $msg;die();
		$route = array_keys($arr,$msg,true);
		//echo $route;die();
		if(empty($route)){
			echo '未知命令或者你的命令格式不正确!';
		}else{
			
			$routepath = $route[0];
			$query = explode('/',$routepath);
			$query[0] = ucfirst($query[0]);
			include './controllers/'.$query[0].'Controller.php';
			$class = $query[0].'Controller';
			$object = new $class;
			$action = $query[1].'Action';
			$object->$action();
		}		
	}    
}
function findstatus($nowstatus, $arr, $startime, $nowtime){
	$temp = $nowstatus;
	for ($i = $temp; $i < count($arr); $i++) {
		$startime = $startime+$arr[$i]*3600;
		if ( $startime < $nowtime){
			$nowstatus++;
		} else {
			$arr = array(
					'status' => $nowstatus,
					'startime' => $startime-$arr[$i]*3600
			);
			return $arr;
		}
	}
}
function getValue($val){
	/* $str = explode('.',phpversion());
	if(7 > intval($str[0])){
		return isset($_GET[$val])??null;
	} */
	return isset($_GET[$val])?$_GET[$val]:null;
}
//从一个数组中查找自己需要值，并返回该值对应的键名索引值，适用于数据库查询返回的值
function findval($daojupack,$str,$keyword='name'){
	foreach ($daojupack as $key=>$dao) {
		if(isset($dao[$keyword])){
			if($dao[$keyword] == $str){
				return $key+1;
				break;
			}
		}
	}
	return false;
}
//得到唯一id 这儿不使用uniqid和MD5生成的唯一值
// 是因为用数字来存储的效果要比长字符串好很多
function getUnid(){
    $time = microtime(true);
    $time = str_replace('.','',$time);
    return substr($time,0,-2);
}
?>
