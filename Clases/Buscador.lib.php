<?php
class BuscadorMp3 {

    var $Descarga = 1;
    
    var $defectoBusqueda = false;

    var $palabrasAleatorias = array();

    var $busqueda;

    var $web;
	
	function __construct($getQ = "",$getP = "") {
        ($getQ == "" ? $this->busqueda = "" : $this->busqueda = $getQ);
        ($getP == "" ? $this->pagina   = "" : $this->pagina = $getP );
	}
    
    function limpiar($variable){
        $this->alimpiar = $variable;
        $this->alimpiar = str_replace(" ","+",strtolower(strip_tags($this->alimpiar)));
            return $this->alimpiar;
    }
    
    function get_curl($url){
        $this->url = $url;
        $this->ch = curl_init();
        $this->UA = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5";
        
        curl_setopt($this->ch, CURLOPT_HEADER,         0);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_REFERER,        $this->url);
        curl_setopt($this->ch, CURLOPT_USERAGENT,      $this->UA);
        curl_setopt($this->ch, CURLOPT_URL,            $this->url);

        $this->dataCurl = curl_exec($this->ch);
        curl_close($this->ch);

            return $this->dataCurl;
    }

    function expresion($expreE,$datoE){
        $this->expreE = $expreE;
        $this->datoE = $datoE;
        preg_match("#".$this->expreE."#",$this->datoE,$this->expreS);
            return $this->expreS;
    }
    
    function expresion_todo($expreE,$datoE){
        $this->expreE = $expreE;
        $this->datoE = $datoE;
        preg_match_all("#".$this->expreE."#",$this->datoE,$this->expreS);
            return $this->expreS;
    }
    
    function extraerContenido($fu,$uno,$dos){
        $fu = explode($uno,$fu);
        $fu = explode($dos,$fu[1]);
        return $fu[0];
    }
    
    function agregarBusqueda(){
        $this->busqueda = $this->limpiar($this->busqueda);
        $this->pagina   = $this->limpiar($this->pagina  );
        $this->urlbusuqeda = "http://search.4shared.com/q/BBQD". ($this->pagina>1 ? "/".(($this->pagina-1).'0') : "/1") ."/mp3/".$this->busqueda;
        $this->datos = $this->get_curl($this->urlbusuqeda);
        $this->datosArray = $this->expresion_todo("<h1><a href=\"http:\/\/www.4shared.com\/audio\/(.*?)\/(.*?).htm\" target=\"_blank\">(.*?).mp3<\/a><\/h1>",
                                                                                                    $this->datos);
        $this->datosNo = $this->expresion("No hay archivo\(s\)",$this->datos);
                                                
            return ($this->datosNo[0] != "" ? false : $this->datosArray);
    }

    function nuevoSong($id,$link,$nombre){
        $this->idSong     = $id;
        $this->linkSong   = $link;
        $this->nombreSong = $nombre;
        $this->ClinkSong  = $this->web.'musica-'.$this->linkSong.'/';
        
        $this->song = "
        				  <div class=\"song\">
                              <div class=\"song-title\">
                              <a href=\"". $this->ClinkSong ."\" title=\"SpanisBR\" onclick=\"play('". $this->idSong ."'); return false;\">". $this->nombreSong ."</a>
                              </div>
                             
                          </div>";
              return $this->song;
    }
    
    function datosSong($id4){
        $this->id4 = $id4;
        $this->urlInfo = "http://www.4shared.com/audio/". $this->id4 ."/zentido.htm";
        $this->datosInfo = $this->get_curl($this->urlInfo);
        
        $this->tamano = $this->expresion("><b>(.*?)<\/b><\/span> \|",      $this->datosInfo);
        $this->fecha  = $this->expresion("-(.*?)>(.*?)<\/span> \|",        $this->datosInfo); 
        
        $this->mp3url = $this->expresion("getAudioHtml5Player\('(.*?)'", $this->datosInfo);
        $this->mp3nom = $this->expresion("NameTextSpan\">(.*?).mp3",     $this->datosInfo);

        $this->arrayInfo = array(
                    "tamano" => $this->tamano[1],
                    "fecha"  => $this->fecha[2],
                    "nombre" => $this->mp3nom[1],
                    "url"    => $this->mp3url[1],
        );

            return $this->arrayInfo;
    }
    
    function totalResultados(){
        $this->urlbusqueda = "http://search.4shared.com/q/BBQD/1/mp3/".$this->busqueda;
        $this->resultadosTotal = $this->get_curl($this->urlbusqueda);

        $this->resultadoExpre = $this->extraerContenido($this->resultadosTotal,'&nbsp;(',' en total');
        
            return str_replace('total) ','',$this->resultadoExpre);
    }


}


?>