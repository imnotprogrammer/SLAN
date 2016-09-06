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
?>
