<?php
/**
 * Class Db 数据库操作最原始的基类；
 * 作者：清风送月
 * 时间：2016年8月25日16:24:32
 * 功能：最原始的数据库父类，其后的数据库类皆继承此类；
 */
namespace spread\db;
use PDO;
use PDOException;
use spread\thinkcore\conf;

class Db {
    /**
     * @var 连接字符串
     */
    public   $dsn = '';
    /*
	*数据库地址
	*/
	protected $db_host;
	protected $db_name;
    /**
     * @var 数据库用户名
     */
    protected $db_user;
    /**
     * @var 数据库密码
     */
    protected $db_pass;

    /**
     * @var 数据库默认编码
     */
    protected $db_charset;
    /**
     * @var pdo对象，操作数据库使用
     */
    private    $pdo;
    /**
     * @var 查询的数据
     */
    private    $data;

    /**
     * @var 数据库执行的语句
     */
    private    $command;
    /**
     * stamant对象
     */
    private    $stam;
    /**
     * 查询所有数据
     */
    const RESULT_ALL = 1;
    /**
     *计数
     */
    const RESULT_COUNT = 2;
    /**
     * 执行一条语句
     */
    const RESULT_ONE = 3;
    /**
     * 针对修改，查询。删除等情况，返回bool数据类型
     */
    const RESULT_EXEC = 4;
    /**
     * Db constructor.
     * @param $db_host
     * @param $db_name
     * @param $db_user
     * @param $db_pass
     * @param $db_charsert
     */
    public function __construct($conf=null){
		/* if($conf){
			$this->dsn .= 'mysql:';
			$this->dsn .= 'host='.$conf['db_host'];
			$this->dsn .= ';dbname='.$conf['db_name'];
			$this->dsn .= ';charset='.$conf['db_charset'];
			$this->db_user = $conf['db_user'];
			$this->db_pass = $conf['db_pass'];			
		}else{
			
			
			
		}
        
        try{
            $this->pdo = new PDO($this->dsn,$this->db_user,$this->db_pass);			
        }catch(PDOException $e){
            echo $e->getMessage();
        } */
    }
    public function init($conf=null){
		if($conf){
			$this->dsn .= 'mysql:';
			$this->dsn .= 'host='.$conf['db_host'];
			$this->dsn .= ';dbname='.$conf['db_name'];
			$this->dsn .= ';charset='.$conf['db_charset'];
			$this->db_user = $conf['db_user'];
			$this->db_pass = $conf['db_pass'];			
		}else{
			$this->dsn .= 'mysql:';
			$this->dsn .= 'host='.$this->db_host;
			$this->dsn .= ';dbname='.$this->db_name;
			$this->dsn .= ';charset='.$this->db_charset;
			$this->db_user = $this->db_user;
			$this->db_pass = $this->db_pass;	
		}
			
		try{
			$this->pdo = new PDO($this->dsn,$this->db_user,$this->db_pass);	
        return $this;			
		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}
    /**
     * @param $tbname
     * @param $data
     * @return int
     * 向数据库表增加数据；
     */
    public function add($tbname,$data){
        $datakeys = $datavals = array();$strvals = '';
        $this->command = 'insert into '.$tbname;
        if(is_array($data) && $data != null){
            foreach($data as $key => $val){
                $datakeys[] = $key;
                $datavals[] = $val;
                $strvals .= ',?';
            }
            $keys = implode(',',$datakeys);
            $strvals = trim($strvals,',');
            $this->command = $this->command.'('.$keys.') values(%s)';
            $this->command = sprintf($this->command,$strvals);			
            try{
                $this->stam = $this->pdo->prepare($this->command);
                $this->stam ->execute($datavals);
				return $this->pdo->lastInsertId();
            }catch( PDOException $e){
                echo $e->getMessage();
            }
        }else{
            return false;
        }
    }

    /**
     * @param $tbname
     * @param $wheredata
     * 从数据表中删除数据；
     */
    public function del($tbname,$wheredata,$typearr=null){
        $vals = [];$this->command = $keys =$this->stam =  '';
        $i = 0;
        if($typearr==null){
            $opt = '=';$status = 0;
        }else{
            $opt = $typearr;$status = 1;
        }
        if(is_array($wheredata)){
            foreach($wheredata as $wherekey=>$whereval){
                if($status==1) {
                    if($opt[$i]=='between'){
                        $keys .= 'and '.$wherekey.' between ? and ?';
                        $vals[] =$whereval[0];
                        $vals[] = $whereval[1];
                    }else{
                        $keys .= 'and' . ' ' . $wherekey . $opt[$i] . '? ';
                        $vals[] = $whereval;
                    }
                }else{
                    $keys .= 'and' . ' ' . $wherekey .'=? ';
                    $vals[] = $whereval;
                }
                $i++;
            }
            $keys = trim($keys,'and');
            $this->command = 'delete from '.$tbname.' where '.$keys;
            //echo $this->command;
            $this->stam = $this->pdo->prepare($this->command);
            return $this->stam->execute($vals);
        }else{
            return false;
        }
    }

    /**
     * @param $tbname
     * @param array $select
     * @param array $where
     * 数据表内容的查询
     */
    public function select($tbname,$select = array(),$where = array()){
        $this->command = $keys = '';
        if( is_array($select) && $select == null ){
            $select = '*';
        }elseif( is_array($select) && $select !==null){
            $select = implode(',',$select);
        }
        if(is_array($where)) {
            foreach ($where as $wherekey => $whereval) {
                $keys .= 'and' . ' ' . $wherekey . '=? ';
                $vals[] = $whereval;
            }
        }
        if($keys != null){
            $keys = trim($keys,'and');
            $keys = ' where '.$keys;
        }
        $this->command = 'select '.$select.' from '.$tbname.$keys;
        //echo $this->command;die();
        $this->stam = $this->pdo->prepare($this->command);
        $this->stam->execute($vals);
        $this->data = $this->stam->fetchAll(PDO::FETCH_ASSOC);
        return $this->data;
    }

    /**
     * @param $tbname
     * @param $array 此数组不能为空，为必须变量
     * @param $whree
     * @return bool true表示修改成功，false 失败
     * 数据表的修改
     */

    public function update($tbname,$update,$where =array(),$opt=array()){
        $i = 0;
        if($opt==null){
            $status = 0;
        }else{
            $status =1;
        }
        $vals = $up = [];$this->command = $keys =$this->stam = $upkeys =  '';
        foreach($update as $key => $val){
            $upkeys .= ','.$key.'=? ';
            $up[] = $val;
        }
        $upkeys = trim($upkeys,',');
        if(is_array($where)){
            foreach($where as $wherekey=>$whereval) {
                if ($status == 1) {
                    if ($opt[$i] == 'between') {
                        $str = ' between ? and ? ';
                        $keys .= 'and' . ' ' . $wherekey . $str;
                        $vals[] = $whereval[0];
                        $vals[] = $whereval[1];
                    } else {
                        $vals[] = $whereval;
                        $keys .= 'and' . ' ' . $wherekey . $opt[$i] . '? ';
                    }
                }else{
                    $vals[] = $whereval;
                    $keys .= 'and' . ' ' . $wherekey .'=? ';
                }
                $i++;
            }
            $keys = trim($keys,'and');
        }else{
            return false;
        }
        $this->command = 'update '.$tbname.' set '.$upkeys.' where '.$keys;
        //echo $this->command;
        $this->stam = $this->pdo->prepare($this->command);
		$arrmerge = array_merge($up,$vals);
		//print_r($arrmerge);
        $status = $this->stam->execute($arrmerge);
        return $status;
    }

    /**
     * @param $sql
     * @param $parm
     * @param int $type
     * @return array|bool|int|mixed
     * 执行自定义的sql语句
     */
    public function exec($sql,$parm,$type=self::RESULT_ALL){

        $this->stam = $this->pdo->prepare($sql);
        $status = $this->stam ->execute($parm);
        switch($type){
            case self::RESULT_ALL:return $this->stam->fetchAll();break;
            case self::RESULT_COUNT:return $this->stam->rowCount();break;
            case self::RESULT_ONE:return $this->stam->fetch();break;
            case self::RESULT_EXEC:return $status;break;
            default:
                return false;
        }

    }
    public function _beginTran(){
        $this->pdo->beginTransaction();
    }
    public function _commit(){
        $this->pdo->commit();
    }
    public function _rollback(){
        $this->pdo->rollBack();
    }
	public function close(){
		$this->pdo = null;
	}
	public static function start(){
		return new Db();
	}
	public function __set($key, $val){
		$this->$key = $val;
		
	}
}
?>