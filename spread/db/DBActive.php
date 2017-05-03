<?php
namespace spread\db;
/**
 * Class DBActive
 * @package frame\db
 * @author:清风送月
 * @时间：2016年9月6日10:04:23
 * @邮箱：lanshiqingfeng@163.com
 * @简介：此类主要用于数据库增删查改的简化操作其中查询流程可如下例所示：
 * $db = new DBActive();
 * $db->select()               如果是查询所有字段该项可以省去；
 *    ->table('数据表名称')     如果在申请类时，初始化了表名称，此项也可以省去；
 *
 *    ->where($arr,$type)      其中$arr为条件，$type为表达式，如
 *                             where(["id"=>1,"name"=>"lan"],['>','=']) 表示当id>1 and name="lan"时，
 *                             如果$type为空，则默认为'=',
 *                             注意:count($arr)=count($type) 即两数组中元素要一一对应
 *
 *   ->order($param,$type)     按照$param字段以$type排序，其中$type默认为 desc
 *   ->group($param,$having)   按照$param字段，以$having条件进行分组,$having默认为空.
 *   ->limit($start,$size)     以$start为起始点,取$size条数据
 *   ->all()                   查询所有的数据
 *   ->one()                   只从结果集中取一条数据
 *  其中还有修改，插入，删除等功能。此处不再详解
 */
class DBActive{
    /**
     * @var string
     * select查询字符串
     */
	 private $gcommand='';
    private $parm = 'select * ';
    /**
     * @var
     * 查询表名称
     */
    private $table;
    /**
     * @var null
     * 条件查询 条件
     */
    private $where=null;
    /**
     * @var
     * 分组查询时需要用到的字符串
     */
    private $group;
    /**
     * @var order by
     *
     */
    private $order;
    /**
     * @var
     * 联合查询
     *
     */
    private $inner;
    /**
     * @var
     * 联合查询类型
     * 其中分为 inner，left，right，cross四种类型
     */
    private $innertype;
    /**
     * @var
     * 模糊查询
     */
    private $like;
    /**
     * @var
     * 用于保存where条件需要用到的数组
     */
    private $value;
    /**
     * @var
     * 联合查询中涉及的表；
     *
     */
    private $innertable;
    /**
     * @var int
     * 限制的起始点
     */
    private $start=0;
    /**
     * @var int
     * 取多少条输数据
     */
    private $size=0;
    /**
     * @var string
     * 模糊查询所涉及的匹配方式
     */
    private $select_mate_type='';
    /**
     * @var
     * 限制查询
     */
    private $limit;
    /**
     * @var Db
     * 操作数据库的对象
     */
    private $db;
    /**
     * @var string
     * sql语句
     */
    private $command='';
    /**
     * @var string
     * 数据表名称
     */
	private $tablename='';

    /**
     * @var array
     * 表中所有的字段名称
     */
	private $fields=array();
    /**
     * @var array
     * 插入数据时可能会用到的一个数组
     */
    private $insertFields=array();
    /**
     * @var array
     * 条件数组
     */
    private $wherearr=array();
    /**
     * @var array
     * 表达式数组
     * 与$wherearr一一对应
     */
    private $typearr=array();
    /**
     * @var
     * 表的主键
     */
    private $primarykey;
	private $tempval=array();
    /*
     * 常量，内查询
     */
    const  INNER_TYPE_INNER = 0;
    /*
     * 左联合查询
     */
    const  INNER_TYPE_LEFT  = 1;
    /**
     * 右联合查询
     */
    const  INNER_TYPE_RIGHT = 2;
    /**
     * 笛卡尔集
     */
    const  INNER_TYPE_CROSS = 3;

    /*
     * 模糊查询左匹配
     */
    const  LEFT_MATE = 1;
    /*
     * 模糊查询右匹配
     */
    const  RIGHT_MATE = 2;
    /**
     * 模糊查询左右匹配
     */
    const  ALL_MATE  = 3;

    const DBACTIVE_EQUAL=1;
    const DBACTIVE_BETWWN=2;
    const DBACTIVE_MORE=3;
    const DBACTIVE_LESS=4;
    const DBACTIVE_OVER=5;

    /**
     * DBActive constructor.
     * @param null $tablename
     * 初始化一些数据
     */
    public function  __construct($tablename=null){
        $this->tablename = $tablename;
        $this->db = new Db();
    }
    /*
     * 查询头
     */
    public function select($parm=null){
		//$this->pram
        if($parm){
            $this->parm = $parm;
        }
        $this->parm = 'SELECT '.'*';
        return $this;
    }

    /**
     * @param $table
     * @return $this
     * 汇聚表名
     */
    public function table($table){
		$this->tablename = '';
        $this->table = ' FROM '.$table;
		$this->tablename = $table;
        $this->fields();
        return $this;
    }


    /**
     * @param $arr
     * @param array $type
     * @return $this
     */
    public function where($arr, $type=array()){
        $status =false;
        $i =0;
		if($type==null){
			$opchar = '=';
		}else{
		    $opchar = $type;
        }		
        $this->wherearr = $arr;
        $this->typearr = $type;
        if(is_array($opchar)){
            $status = true;
        }
		$keyname = array_keys($arr);
        if(is_array($arr)){
            foreach($arr as $key=>$val){
                if($status){
                    $op = $opchar[$i];
                }else{
                    $op = $opchar;
                }
				if($key=='$1'){
					$key = $keyname[$i-1];
				}
                $this->where .= 'and '.$key.$op.'? ';			
                $this->value[] = $val;
                $i++;
            }
        }
        $this->where = ' where '.ltrim($this->where,'and');
        return $this;
    }

    /**
     * @param null $order
     * @param string $type
     * @return $this
     * 按照什么字段排序
     */
    public function order($order=null,$type = ' DESC'){
        if($order==null){
            $this->order = null;
        }else{
            $this->order = ' ORDER BY '.$order.' '. $type;
        }
        return $this;
    }
    /**
     *
     * 按照什么字段分组
     */
    public function group($group,$having=null){
        if($having!=null){
            $having = ' HAVING '.$having;
        }
        $this->group = ' GROUP BY '.$group.$having;
        return $this;
    }

    /**
     * @param $table
     * @param array $where
     * @param int $innertype
     * @return $this
     * 联合查询
     */
    public function inner($table,$where=null,$innertype=self::INNER_TYPE_INNER){
        switch($innertype){
            case self::INNER_TYPE_INNER:
                $this->innertype = ' INNER ';break;
            case self::INNER_TYPE_LEFT:
                $this->innertype = ' LEFT ';break;
            case self::INNER_TYPE_RIGHT:
                $this->innertype = ' RIGHT ';break;
            case self::INNER_TYPE_CROSS:
                $this->innertype = ' CROSS ';break;
        }
        if(!$where){
            $on = null;
        }else{
            $on = ' ON'.$where;
        }
        $this->inner .= $this->innertype.' JOIN '.$table.$on;
        return $this;
    }

    /**
     * @param $parm
     * @param $like
     * @param int $type
     * @return $this
     * 模糊查询
     */
    public function like($parm,$like,$type=self::ALL_MATE){
    	$this->like='';
        switch($type){
            case self::ALL_MATE:$this->select_mate_type = '%'.$like.'%';break;
            case self::LEFT_MATE:$this->select_mate_type = '%'.$like;break;
            case self::RIGHT_MATE:$this->select_mate_type = $like.'%';break;
        }
        if($this->where){
            $this->like = ' AND '.$parm.' LIKE '.'"'.$this->select_mate_type.'"';
        }else{
        	$this->like = ' WHERE '.$parm.' LIKE '.'"'.$this->select_mate_type.'"';
        }
        return $this;
    }

    /**
     * @param $start
     * @param $size
     * @return $this
     * 限制语句
     */
    public function limit($start,$size){
        $this->start = $start;
        $this->size  = $size;
        $this->limit = " LIMIT $this->start,$this->size ";
        return $this;
    }

    /**
     * 执行函数
     */
    public function all(){
        $this->gcommand = $this->parm.
                         $this->table.
                         $this->inner.
                         $this->where.
                         $this->like.
                         $this->group.
                         $this->order;                        
        $this->command = $this->gcommand.$this->limit;
        //echo 
		echo $this->command;
        //print_r($this->value);
		$this->tempval = $this->value;
		$this->param = $this->table = $this->inner = $this->where = $this->group =$this->order=$this->limit = $this->like = null;
        $rs = $this->db->exec($this->command,$this->value,1);
		$this->value = null;
		return $rs;
    }
	
	public function getCount(){
		if(!$this->gcommand){
			$this->gcommand = $this->parm.$this->table.$this->inner.$this->where.$this->like.$this->group.$this->order;
		}
		$count = $this->db->exec($this->gcommand,$this->tempval,2);
		$this->tempval = '';
		return $count;
	}

    /**
     * @return array|bool|int|mixed
     * 此函数只从结果集中取一条数据，并且通过数组形式返回
     */
    public function one(){
        $this->command = $this->parm.
                         $this->table.
                         $this->inner.
                         $this->where.
                         $this->order.
                         $this->group.
                         $this->limit;
		$this->param = $this->table = $this->inner = $this->where = $this->group =$this->order=$this->limit = null;
        $rs = $this->db->exec($this->command,$this->value,3);
		$this->command = $this->value = null;
		return $rs;
    }

    /**
     * @return array
     * 得到表中的所有字段
     */
    public function getFiled(){
		$this->command = 'SHOW COLUMNS '.$this->table;
		$fields = $this->db->exec($this->command,[],1);		
		return $fields;
	}

    /**
     *组合函数getfield()中得到的表中所有字段，并且将其存在变量fields中
     */
    public function fields(){
		$fields = $this->getFiled();
		foreach($fields as $val) {
		    if($val['Key'] == 'PRI')
		        $this->primarykey = $val['Field'];
            $this->fields[] = $val['Field'];
        }
	}

    /**
     * @param array $insertarr
     * @return int
     * 此函数用于向表中插入一条数据
     */
    public function save($insertarr=array()){
		if($insertarr==null){
			return $this->db->add($this->tablename,$this->insertFields);
		}else{
			return $this->db->add($this->tablename,$insertarr);
		}						
	}
	
	public function lastInsertId(){
		return $this->db->lastInsertId();
	}

    /**
     * @param $array
     * @param $where
     * @return bool
     * 根据#where的数据，修改表中的一条数据
     */
    public function update($array, $where=null){
		return $this->db->update(
		                         $this->tablename,
                                 $array,
                                 $this->wherearr,
                                 $this->typearr
								 );
	}
    public function upone($id,$array,$tablename){
		if(!empty($tbname)){
			$this->table = $tablename;
		}
        return $this->db->update($this->tablename,$array,array($this->primarykey=>$id));
    }
    /**
     * @param null $where
     * @param null $type
     * @return bool
     *
     */
	public function delete($where=null,$type=null,$tablename=null){
		if(!empty($tbname)){
			$this->tablename = $tablename;
		}
	    if($where && $type){
	        $this->wherearr = $where;
            $this->typearr  = $type;
        }
        return $this->db->del($this->tablename,$this->wherearr,$this->typearr);
    }

    /**
     * @param $idkey
     * @return array|bool|int|mixed
     * 删除指定表中，以主键为条件，删除相应对象的一条数据
     * 其中idkey的值是该表主键所对应的值；
     */
    public function delone($idkey,$tbname=null){
		$tempvalue = $this->table;
		if(!empty($tbname)){
			$this->table = ' FROM '.$tbname;
			$this->fields();
		}
	
        $this->command = 'DELETE '.$this->table.' WHERE '.$this->primarykey.'='.$idkey;
        $rt = $this->db->exec($this->command,[],4);
		$this->table = $tempvalue;
        return $rt;

    }

    /**
     * 开启事务处理
	 *innodb
     */
    public function beginTransaction(){
        $this->db->_beginTran();
    }

    /**
     * 提交处理
     */
    public function commit(){
        $this->db->_commit();
    }

    /**
     * 事务回滚
     */
    public function rollback(){
        $this->db->_rollback();
    }
	//
	public function dump($val){
        if(is_array($val)){
            var_dump($val);
        }else{
            print($val);
        }
	}
	public function __set($name,$val){
		$this->$name = $val;
		$this->insertFields[$name]=$val;
	}
	public function __get($name){
		return $this->$name;
	}
}

?>