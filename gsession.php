<?php

	$path = dirname(__FILE__)."/variables/";		

	
	if(!isset($_COOKIE["PHPGSESSID"])){
		$gsessid = genGSessid(26);
		setcookie("PHPGSESSID", $gsessid, time()+7776000);
	}else{
		$gsessid = $_COOKIE["PHPGSESSID"];
	}


	function genGSessid($length = 8){
		$chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
		//$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		$numChars = strlen($chars);
		$string = '';
	  
		for ($i = 0; $i < $length; $i++) {
			$string .= substr($chars, rand(1, $numChars) - 1, 1);
		}
		
		return $string;
	}

	
	
	function get_gsession($name){
		
		global $path;
		global $gsessid;
		
		_expired_gsession();
		
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				$exp = explode("-", $var);
				if($name == $exp[0] && $gsessid == $exp[3]){
										
					return file_get_contents($path.$var);
					break;

				}
			}
		}		
	}

	function clear_gsession(){
		
		global $path;
		global $gsessid;
		
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				if($gsessid == explode("-", $var)[3]){
					unlink($path.$var);
				}
			}
		}
		
	}
	
	function lifetime_gsession($name){
		
		global $path;
		global $gsessid;

		_expired_gsession();
		
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				
				$exp = explode("-", $var);
				
				if($name == $exp[0] && $gsessid == $exp[3]){
					
					$time = time();
					$dtime = $exp[2];
					
					if($time > $dtime){
						return 0;
					}else{
						return $dtime - $time;
					}

					break;
				}

			}
		}
		
	}
	
	function list_gsession(){
		
		global $path;
		global $gsessid;
		
		_expired_gsession();
		
		$array = Array();
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				$exp = explode("-", $var);
				if($gsessid == $exp[3]){
					array_push($array, $exp[0]);
				}
			}
		}
		
		return $array;
		
	}
		
	function unset_gsession($name){
		
		global $path;
		global $gsessid;
		
		_expired_gsession();
		
		if($full_name = isset_gsession($name, true)){
			unlink($path.$full_name);
			return true;
		}
		
	}

	function set_gsession($name, $value, $life_time=1800){
		
		global $path;
		global $gsessid;
		
		_expired_gsession();
		
		$time = time();
		$dead_time = time() + $life_time;
		$var_name = $name."-".$time."-".$dead_time."-".$gsessid;
		
		if(!(stristr($name, "-"))){
			
			$old_name = isset_gsession($name, true);
			
			if($old_name && rename($path.$old_name, $path.$var_name)){
				
				//Old variable
				
				$fp = fopen($path.$var_name, "w");
				fwrite($fp, $value);
				fclose($fp);

				$result = true;				
				
			}else{
				
				//New variable
				
				$fp = fopen($path.$var_name, "w");
				fwrite($fp, $value);
				fclose($fp);
				
				$result = true;				
				
			}
			
		}else{
			
			$result = "Ошибка GSESSION: В имени переменной присутствуют запрещенные знаки \"-\"!";
			
		}

		return $result;
		
	}
	
	
	function isset_gsession($name, $arg=false){
		
		global $path;
		global $gsessid;
		
		_expired_gsession();
		
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				$exp = explode("-", $var);
				if($name == $exp[0] && $gsessid == $exp[3]){
					if($arg){
						return $var;
					}else{
						return true;
					}
					break;
				}
			}
		}
				
	}
	
	function _expired_gsession(){
		
		global $path;
		
		$time = time();
		
		foreach(scandir($path) as $var){
			if($var != ".." && $var != "."){
				
				$exp = explode("-", $var);
				$start_time = $exp[1];
				$death_time = $exp[2];
				
				if($time > $death_time){
					unlink($path.$var);
				}
				
			}
		}
		
	}

?>