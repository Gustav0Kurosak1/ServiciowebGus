<?

class TrabajaCache
{
 /* configure as opcoes abaixo */
 public static $dir_cache = "_Cache/";
 public static $tempo_cache = 43200;
 public static $editar_via_url = false; 
 public static $string_separatoria = "&cache_debug="; 
 public static $extensao_padrao = "html";
 
 function __construct()
 {
    $this->pagina_atual = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $this->md5_pg = md5($this->pagina_atual).".".self::$extensao_padrao;
    $this->arquivo = self::$dir_cache.$this->md5_pg;
    $this->opcoes = "basico";
    $this->acao = false;
	$this->retorno = true;
	
    $this->arr_debug = array("atualizar","limpar","matar");

	@mkdir(self::$dir_cache,0777,true); 
	@chmod(self::$dir_cache,0777);

    if(self::$editar_via_url != false && self::$string_separatoria != false)
    { 

       $arr_url = explode(self::$string_separatoria,$this->pagina_atual);   

	   $this->acao = $arr_url[count($arr_url)-1];     
    }elseif(self::$editar_via_url != false && isset($_GET['cache_debug'])){

	   $this->acao = $_GET['cache_debug'];
	}

 }
  
  public function CreaCache()
  {

     if($_SERVER['REQUEST_METHOD'] != "POST")
     {

		  if($this->acao != false && in_array($this->acao,$this->arr_debug))
	      {
			  
			  switch($this->acao)
		      { 
		       case "atualizar":
		       default:
	           $this->retorno = false;
	           break;

			   case "limpar":
			   @unlink($this->arquivo);
			   break;

			   case "matar": 
			   
			     if($dir = opendir(self::$dir_cache)) 
			     {
			          while(false !== ($file = readdir($dir)))   
		              {
					      if($file != "." and $file != "..")
					      {
						    @unlink(self::$dir_cache.$file);
					      }
				      }
			          closedir($dir);
			      }
			  }

		  }
		  
		  elseif(file_exists($this->arquivo) && (time() - self::$tempo_cache < filemtime($this->arquivo)))
		  {
           include($this->arquivo); exit;
          }

         if($this->retorno != false)
		 {
		 ob_start("ob_gzhandler");
		 }
     }
  
   }
  
  public function CierraCache($opcoes="")
  {

     if($_SERVER['REQUEST_METHOD'] != "POST" || $this->retorno != false)
     {

         $fp = fopen($this->arquivo,"w");

	     if($opcoes == "")
	     {
	       $opcoes = $this->opcoes;
	     }
	  

	     switch($opcoes)
	     {
	       case "basico":
		   default:
		   $buffer = ob_get_contents();
		   break;
		 
		   case "normal":
		   $buffer = str_replace(array("\r\n", "\r", "\n", "\t"), '', ob_get_contents());
		   break;
		 
		   case "agressivo":
		   $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', ob_get_contents());
		   break;
	     }
	
      fwrite($fp,$buffer); 
      fclose($fp); ob_end_flush();
    }
	  
 }
  
  
  

}

?>