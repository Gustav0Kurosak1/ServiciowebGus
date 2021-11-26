<?php

if($_POST){
	$url = htmlentities($_POST['url']);
    if($_GET['op']){
        require_once 'Clases/Buscador.lib.php';
        $infoS = new BuscadorMp3();
        $info = $infoS->datosSong($url);
        
        echo "<center>Nombre: ".$info['nombre']."<br>
                      Fecha de Subida: ".$info['fecha']."<br>
                      Tama".utf8_encode("ñ")."o del mp3: ".$info['tamano']."<br>
                      <br><a href='".$info['url']."' target='_blank'>DESCARGAR</a>
             </center>";
        
    }else{
        require_once 'Clases/Buscador.lib.php';
        $infoS = new BuscadorMp3();
        $info = $infoS->datosSong($url);

                echo "
                        <LEGEND><h3>Estas escuchando: <br />".$info['nombre']."</h3></LEGEND>
                        <p></p>
                    ";        
        if($_POST['browser'] == "ie"){
            echo "
                    <object id=\"MediaPlayer1\" width=\"250\" height=\"50\" type=\"application/x-oleobject\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715\" classid=\"CLSID:22D6f312-B0F6-11D0-94AB-0080C74C7E95\"> 
                      <param value=\"1\" name=\"AutoRewind\"/> 
                      <param value=\"1\" name=\"Autostart\"/> 
                      <param value=\"1\" name=\"ShowControls\"/> 
                      <param value=\"1\" name=\"ShowStatusBar\"/> 
                      <param value=\"0\" name=\"ShowPositionControls\"/> 
                      <param value=\"0\" name=\"ShowTracker\"/> 
                      <param value=\"0\" name=\"showdisplay\"/> 
                      <param value=\"0\" name=\"ControlType\"/> 
                      <param value=\"".$info['url']."\" name=\"FileName\"/> 
                      <embed width=\"250\" height=\"50\"  align=\"middle\" filename=\"".$info['url']."\" showtracker=\"0\" showpositioncontrols=\"0\" showdisplay=\"0\" autorewind=\"0\" showstatusbar=\"1\" showcontrols=\"1\" autostart=\"1\" pluginspage=\"http://www.microsoft.com/windows/mediaplayer/download/default.asp\" type=\"video/x-ms-asf-plugin\" src=\"".$info['url']."\"/>    
                    </object>
                    ";
        }else{
            echo "
                    <object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\"260\" height=\"30\" id=\"single1\" name=\"single1\">
                    <param name=\"movie\" value=\"http://static.4shared.com/flash/player.swf\">
                    <param name=\"allowfullscreen\" value=\"true\">
                    <param name=\"allowscriptaccess\" value=\"always\">
                    <param name=\"wmode\" value=\"transparent\">
                    <param name=\"flashvars\" value=\"file=".$info['url']."&autostart=true&repeat=always&amp;skin=http://images.mp3raid.com/skin.swf\">
                    <embed type=\"application/x-shockwave-flash\" id=\"single2\" name=\"single2\" src=\"http://static.4shared.com/flash/player.swf\" width=\"260\"
                    height=\"30\" bgcolor=\"undefined\" allowscriptaccess=\"always\" allowfullscreen=\"true\" wmode=\"transparent\" flashvars=\"file=".$info['url']."&autostart=true&repeat=always&amp;skin=http://images.mp3raid.com/skin.swf\" />
                    </object>
					<p align=\"center\">
					<a href=\"http://fuckill.tk\" onclick=\"javascript:window.open('http://musicasenlinea.info/baja.php?fox=".$info['url']."&name=".$info['nombre']."','',		'width=20 ,height=20,  resizable=0 status=0'); return false\">
					<img src=\"http://portablesdelfuk.tk/host/images/bajar.gif\" border=\"0\" alt=\"Descargar\"></a> </p>
                    ";
        }
    }
}
 
?>