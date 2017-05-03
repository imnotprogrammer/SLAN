<?php  
namespace frame\thinkcore;
use frame\db\Db;
class Session_share {  
      private $db;
      public function __construct(){
		  $this->db = new \frame\db\Db();
	  }
     function open($save_path, $session_name) {  
          return true;  
      }   //end function  
     function close() {  
          if ($this->db) {    //关闭数据库连�? 
              $this->db->close();
              return true;			 
          }  
          return false;  
	 }
     function read($sesskey) {   
		 $data = $this->db->exec('SELECT si_data FROM sess_info WHERE si_key=? AND si_exptime>=?',[$sesskey,time()]);
         if($data){
			 return $data[0]['si_data'];
		 }else{
			 return '';
		 }
      }
     function write($sesskey, $data) {  	 
         $expiry = time() + 3600;    //设置过期时间  
         $arr = array(  
             trim($sesskey),  
              trim($data), 
			  $expiry 
			 );  		  
           $this->db->exec('replace into sess_info(si_key,si_data,si_exptime) values(?,?,?)', $arr);  
          return true;  
      }   //end function  
  
     function destroy($sesskey) {     
        if($this->db->exec('delete from sess_info where si_key=?',[$seskey])){
			return true; 
		} 
        return false;
          
     }   //end function  
  
    function gc($maxlifetime = null) {  
         $sql = 'DELETE FROM sess_info WHERE si_exptime<?' ;  
         $this->db->exec($sql,[time()]);  
         //由于经常性的对表 sess 做删除操作，容易产生碎片�? 
          //所以在垃圾回收中对该表进行优化操作�? 
         $sql = 'OPTIMIZE TABLE sess_info';  
         $this->db->exec($sql);  
          return true;  
      }   //end function  
 }  
?>
