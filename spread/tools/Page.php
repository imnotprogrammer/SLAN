<?php
namespace spread\tools;
	/**
		file: page.class.php 
		������ҳ�� Page 
	*/
	class Pages {
		private $total;   		 				//���ݱ����ܼ�¼��
		private $listRows; 						//ÿҳ��ʾ����
		private $limit;   		 				//SQL���ʹ��limit�Ӿ�,���ƻ�ȡ��¼����
		private $uri;     		 				//�Զ���ȡurl�������ַ
		private $pageNum; 		 				//��ҳ��
		public $page;							//��ǰҳ	
		private $config = array(
				'head' => "����¼", 
				'prev' => "<", 
				'next' => ">", 
				'first'=> "<<", 
				'last' => ">>"
			); 					
		//�ڷ�ҳ��Ϣ����ʾ���ݣ������Լ�ͨ��set()��������
		public $listNum = 10; 					//Ĭ�Ϸ�ҳ�б���ʾ�ĸ���

		/**
			���췽�����������÷�ҳ�������
			@param	int	$total		�����ҳ���ܼ�¼��
			@param	int	$listRows	��ѡ�ģ�����ÿҳ��Ҫ��ʾ�ļ�¼����Ĭ��Ϊ25��
			@param	mixed	$query	��ѡ�ģ�Ϊ��Ŀ��ҳ�洫�ݲ���,���������飬Ҳ�����ǲ�ѯ�ַ�����ʽ
			@param 	bool	$ord	��ѡ�ģ�Ĭ��ֵΪtrue, ҳ��ӵ�һҳ��ʼ��ʾ��false��Ϊ���һҳ
		 */
		public function __construct($total, $listRows=25, $query="", $ord=true){
			$this->total = $total;
			$this->listRows = $listRows;
			$this->uri = $this->getUri($query);
			$this->pageNum = ceil($this->total / $this->listRows);
			/*�����ж��������õ�ǰ��*/
			if(!empty($_GET["page"])) {
				$page = $_GET["page"];
			}else{
				if($ord)
					$page = 1;
				else
					$page = $this->pageNum;
			}

			if($total > 0) {
				if(preg_match('/\D/', $page) ){
					$this->page = 1;
				}else{
					$this->page = $page;
				}
			}else{
				$this->page = 0;
			}
			
			$this->limit = "LIMIT ".$this->setLimit();
		}

		/**
			����������ʾ��ҳ����Ϣ�����Խ����������
			@param	string	$param	�ǳ�Ա��������config���±�
			@param	string	$value	��������config�±��Ӧ��Ԫ��ֵ
			@return	object			���ر������Լ�$this�� �������߲���
		 */
		function set($param, $value){
			if(array_key_exists($param, $this->config)){
				$this->config[$param] = $value;
			}
			return $this;
		}
		
		/* ����ֱ��ȥ���ã�ͨ���÷���������ʹ���ڶ����ⲿֱ�ӻ�ȡ˽�г�Ա����limit��page��ֵ */
		function __get($args){
			if($args == "limit" || $args == "page")
				return $this->$args;
			else
				return null;
		}
		
		/**
			��ָ���ĸ�ʽ�����ҳ
			@param	int	0-7�����ֱַ���Ϊ�����������Զ��������ҳ�ṹ�͵����ṹ��˳��Ĭ�����ȫ���ṹ
			@return	string	��ҳ��Ϣ����
		 */
		function fpage(){
			$arr = func_get_args();
            
            

			$html[0] = "<span class='page-tip'>��<b> {$this->total} </b>{$this->config["head"]}��";
			$html[1] = "ÿҳ��ʾ�� <b>".$this->disnum()."</b> ��</span>";
			$html[2] = $this->firstprev();
			$html[3] = $this->pageList();
			$html[4] = $this->nextlast();
            $html[5] = '';
			$html[6] = '';
			$html[7] = '';

			$fpage = '<div >';
			if(count($arr) < 1)
				$arr = array(0,1,2,3,4,5,6,7);
				
			for($i = 0; $i < count($arr); $i++)
				$fpage .= $html[$arr[$i]];
		
			$fpage .= '</div><div style="clear:both"></div>';
   
            
			return $fpage;
		}
        function appPage(){
			$arr = func_get_args();
            $html = array();
            $html[] = '<div data-role="controlgroup" data-type="horizontal">';
            if( $this->pageNum > 1 ){
                if( $this->page >1 ){
                    $html[] = sprintf( '<a href="%spage=1" data-ajax="false" class="ui-btn ui-corner-all">��ҳ</a>
                                        <a href="%spage=%d" data-ajax="false" class="ui-btn ui-corner-all">��ҳ</a>',
                                        $this->uri,$this->uri,$this->page-1
                               
                                );
                }
                if( $this->page < $this->pageNum ){
                    $html[] = sprintf('<a href="%spage=%s" data-ajax="false" class="ui-btn ui-corner-all">��ҳ</a>
                                      <a href="%spage=%d" data-ajax="false" class="ui-btn ui-corner-all">βҳ</a>',
                                      $this->uri,$this->page+1,$this->uri,$this->pageNum
                               );
                }
            }
            $html[] = sprintf('</div><p class="app-page-tip" style="padding-left:20px;">��%d����¼��Ŀǰ�ǵ�%dҳ</p>',$this->total,$this->page);
            $str = implode('',$html);
			return $str;
		}
        function spage(){
            $this->config = array(
				'head' => "��", 
				'prev' => "<", 
				'next' => ">", 
				'first'=> "<<", 
				'last' => ">>"
			); 	
            $arr = func_get_args();
			$html[1] = "";
			$html[2] = "";
			$html[3] = "";
			$html[4] = $this->firstprev();
			$html[5] = $this->pageList();
			$html[6] = $this->nextlast();

			$fpage = '<div >';
			if(count($arr) < 1)
				$arr = array(0, 1,2,3,4,5,6,7);
				
			for($i = 0; $i < count($arr); $i++)
				$fpage .= $html[$arr[$i]];
		
			$fpage .= '</div>';
			return $fpage;
        }
		
		/* �ڶ����ڲ�ʹ�õ�˽�з�����*/
		private function setLimit(){
			if($this->page > 0)
				return ($this->page-1)*$this->listRows.", {$this->listRows}";
			else
				return 0;
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з����������Զ���ȡ���ʵĵ�ǰURL */
		private function getUri($query){	
			$request_uri = $_SERVER["REQUEST_URI"];	
			$url = strstr($request_uri,'?') ? $request_uri :  $request_uri.'?';
			
			if(is_array($query))
				$url .= http_build_query($query);
			else if($query != "")
				$url .= "&".trim($query, "?&");
		
			$arr = parse_url($url);

			if(isset($arr["query"])){
				parse_str($arr["query"], $arrs);
				unset($arrs["page"]);
				$url = $arr["path"].'?'.http_build_query($arrs);
			}
			
			if(strstr($url, '?')) {
				if(substr($url, -1)!='?')
					$url = $url.'&';
			}else{
				$url = $url.'?';
			}
			
			return $url;
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ǰҳ��ʼ�ļ�¼�� */
		private function start(){
			if($this->total == 0)
				return 0;
			else
				return ($this->page-1) * $this->listRows+1;
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ǰҳ�����ļ�¼�� */
		private function end(){
			return min($this->page * $this->listRows, $this->total);
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��һҳ����ҳ�Ĳ�����Ϣ */
		private function firstprev(){
			if($this->page > 1 ) {
				$str = "<a class='page-first'  href='{$this->uri}page=1'>{$this->config["first"]}</a>";
				$str .= "<a class='page-last'  href='{$this->uri}page=".($this->page-1)."'>{$this->config["prev"]}</a>";		
				return $str;
			}else{
			     $str = "<a class='page-first' style='cursor:not-allowed' href='javascript:return false;'>{$this->config["first"]}</a>";
				$str .= "<a class='page-last'  style='cursor:not-allowed' href='javascript:return false;".($this->page-1)."'>{$this->config["prev"]}</a>";		
				return $str;
			}

		}
	
		/* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡҳ���б���Ϣ */
		private function pageList(){
			$linkPage = "<b>";
			
			$inum = floor($this->listNum/2);
			/*��ǰҳǰ����б� */
			for($i = $inum; $i >= 1; $i--){
				$page = $this->page-$i;

				if($page >= 1)
					$linkPage .= "<a  href='{$this->uri}page={$page}'>{$page}</a>";
			}
			/*��ǰҳ����Ϣ */
			if($this->pageNum >=1)
				$linkPage .= "<span class='page-active'>{$this->page}</span>";
			
			/*��ǰҳ������б� */
			for($i=1; $i <= $inum; $i++){
				$page = $this->page+$i;
				if($page <= $this->pageNum)
					$linkPage .= "<a  href='{$this->uri}page={$page}'>{$page}</a>";
				else
					break;
			}
			$linkPage .= '</b>';
			return $linkPage;
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з�������ȡ��һҳ��βҳ�Ĳ�����Ϣ */
		private function nextlast(){
			if($this->page != $this->pageNum) {
				$str = "<a class='page-next'  href='{$this->uri}page=".($this->page+1)."'>{$this->config["next"]}</a>";
				$str .= "<a class='page-end'  href='{$this->uri}page=".($this->pageNum)."'>{$this->config["last"]}</a>";
				return $str;
			}else{
			     $str = "<a class='page-next' style='cursor:not-allowed' href='javascript:return false;' >{$this->config["next"]}</a>";
				$str .= "<a class='page-end'  style='cursor:not-allowed' href='javascript:return false;' >{$this->config["last"]}</a>";
				return $str;
			}
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з�����������ʾ�ʹ������תҳ�� */
		private function goPage(){
    			if($this->pageNum > 1) {
				return '&nbsp;<input style="width:30px;height:17px !important;height:18px;border:1px solid #CCCCCC;" type="text" onkeydown="javascript:if(event.keyCode==13){var page=(this.value>'.$this->pageNum.')?'.$this->pageNum.':this.value;location=\''.$this->uri.'page=\'+page+\'\'}" value="'.$this->page.'"><input style="cursor:pointer;height:20px;border:1px solid #CCCCCC;margin-left:3px;" type="button" value="GO" onclick="javascript:var page=(this.previousSibling.value>'.$this->pageNum.')?'.$this->pageNum.':this.previousSibling.value;location=\''.$this->uri.'page=\'+page+\'\'">&nbsp;';
			}
		}

		/* �ڶ����ڲ�ʹ�õ�˽�з��������ڻ�ȡ��ҳ��ʾ�ļ�¼���� */
		private function disnum(){
			if($this->total > 0){
				return $this->end()-$this->start()+1;
			}else{
				return 0;
			}
		}
	}

	
	
	
