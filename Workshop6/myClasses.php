 <?php
			
	class DBLink {
		private $link, $lastqry;
		
		public function __construct($dbname){
			$lines = file('/home/int322_163c04/secret/topsecret');
			$dbserver = trim($lines[0]);
			$id       = trim($lines[1]);
			$pwd      = trim($lines[2]);
			$dbname   = trim($lines[3]);	
			
			$link = mysqli_connect ($dbserver, $id, $pwd, $dbname);
			$this -> link = $link;
	    }
	  
		function query($sql_query){
			$result = mysqli_query ($this -> link, $sql_query);
			$this -> lastqry = $result;
			return $result;
		}
	  
	    function __destruct(){
			mysqli_close ($this -> link);
		}
		
		function emptyResult( ){
			if(mysqli_num_rows($this -> lastqry) > 0){
				return false;
			}
			return true;
		}
	}

	class Menu
	{
		private $menu;

		public function __construct($list)
		{
			$this->menu = '<h2>Menu</h2>';
			$this->menu .= '<ul>';
			foreach ($list as $key => $value) {
				$this->menu .= '<li><a href="' . $value . '">' . $key . '</a></li>';
			}
			$this->menu .= '</ul>';
		}

		function display()
		{
			echo $this->menu;
		}
	}

	
	class InputValidator{	
	
		private $arrKey = array();
		private $arrErr = array();
				
		public function __construct($array) {
			$this->arrKey = $array;
		}
		
		public function clear() {
			unset($this->arrKey);
			unset($this->arrErr);
		}
		
		public function exists($key) {  
			if(is_string($key) || is_int($key)) 
			{        	
				return array_key_exists($key, $this->arrKey);
			}
			return true;
		}
	
		public function hasValue($key, $err){		
			if ($this->arrKey[$key] == "")
			{
				$this->arrErr[$key] = $err;
				return false;
			}
			else
			{
				$this->arrErr[$key] = "";
			}
		} 
		
		public function getErr(){
			foreach ($this->arrErr as $err)
			{
				if ($err != "")
					return $err;
			}
		}
		
		public function render() {
			foreach ($this->arrErr as $err)
			{
				if ($err != "")
					return false;
			}
			return true;
		}
		
		public function setVar($key, $value) {
			$this->arrKey[$key] = $value;
		}
		public function getVar($key) {
			return $this->arrKey[$key];    	
		}    		
	}
 ?>