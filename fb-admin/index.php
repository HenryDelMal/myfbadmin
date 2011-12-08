<?php
include "clases.php";
header("Content-Type: text/html;charset=utf-8");

echo '<form action="'.$_PHP_SELF.'" method="post" enctype="multipart/form-data">';
$fb = new Fb(); // Inicializa clase de Facebook
$info = $fb->getinfo();
$pagename = $info['name'];
$pagelink = $info['link'];
$pageid = $info['id'];
echo "<title>Administrador de Facebook para ".$pagename." </title>";

$contra="PASSWORD"// Contraseña de Seguridad
?>

<div id="blueBar" class=" fixed_elem">
<div class="clearfix slimHeader" id="pageHead" role="banner">
<center>
<font color="white"><b>Contraseña de Servicio: </font>
<input type="password" name ="clave" size="15" maxlength="500" >
<font color="silver"><b>   <<< Panel de control de <? echo $pagename;?> <<< <small><small>Versión 0.0001 Beta</small></small></b> </font>
</center>
</div>
</div>

</br>
</br>
<div id="globalContainer" style="border: #AAAAAA; left: 4px; top: 0px">
<div id="content" class="fb_content clearfix" style="visibility: visible; min-height: 100px; " data-referrer="content">
<div id="mainContainer">
<div id="contentCol" class="homeFixedLayout homeWiderContent homeFixedLayout hasRightCol" style="min-height: 100px; " data-referrer="contentCol">
<div id="contentArea" role="main" style="width:90%; margin-left:10%; margin-right:10%; width:auto"
>

<!--_______________INICIA LO DEL CENTRO__________________-->

<!--ESTILOS DE FACEBOOK-->
<link type="text/css" rel="stylesheet" href="https://s-static.ak.facebook.com/rsrc.php/v1/yn/r/0djKvZb1rfe.css" />
<link type="text/css" rel="stylesheet" href="https://s-static.ak.facebook.com/rsrc.php/v1/yh/r/KIZm4WpygYy.css" />
<link type="text/css" rel="stylesheet" href="https://s-static.ak.facebook.com/rsrc.php/v1/y3/r/L5RXLkSAYft.css" />
<link type="text/css" rel="stylesheet" href="https://s-static.ak.facebook.com/rsrc.php/v1/yP/r/4zdtwYTaPy4.css" />
<!--CRAP-->
<a href="?mode="><img src="img/wall.png"> Compartir Estado</a> | 
<a href="?mode=link"><img src="img/link.gif"> Compartir Link</a> | 
<a href="?mode=new_album"><img src="img/photo.gif"> Crear Album</a> | 
<a href="?mode=photo_express"><img src="img/new_photo.gif"> Compartir Foto Express</a>


<?
if ($_GET['mode']=="new_album"){
?>
<!--_______________INICIO DE LA CAJA DE NUEVO ALBUM_________________-->

<div class="uiComposerMessageBox uiComposerMessageBoxMentions">
<h1><b>Crear Álbum</b></h1>
<div class="pas inputContainer"></div>
<div class="clearfix showOnceInteracted uiComposerMessageBoxControls">
Nombre:  
<input type="text" name ="nombre" size="20" maxlength="40" >
</br>
Descripción:
<input type="text" name ="descripcion" size="20" maxlength="420" height="3" >
</br>
<label class="submitBtn uiButton uiButtonConfirm uiButtonLarge " for="u3iluc_27"><input value="Crear Album" type="submit" name="send"></label><div>


<?
//Actualiza Estado con Función "estado" y muestra "estado actual"
if ($_POST['send']){
  if($_POST['clave']==$contra){
    $fb->nuevoalbum($_POST['nombre'],$_POST['descripcion']);
    if ($fb==True) echo "<br>Álbum creado perfectamente.";
    else if ($fb==False) echo "Ha habido un error creando el álbum.";
    else echo "Error desconocido";
    echo '<meta http-equiv="Refresh" content="3 ; URL=?mode=new_album">';
  }
  else echo "<b>Contraseña Inválida.<b>";
}
else echo "Listo para crear álbum.";
?>

<div class="textBlurb fsm fwn fcg">

</div></div></div></div>




<!--_______________________FIN DE LA CAJA DE NUEVO ALBUM _________________________-->

<!--_______________INICIO DE LA CAJA PARA SUBIR FOTO_________________-->

<?}else if ($_GET['mode']=="photo_express"){?>

<div class="uiComposerMessageBox uiComposerMessageBoxMentions">
<h1><b>Subir Foto Express</b></h1>
<div class="pas inputContainer">
<div style="width: 30px; "><span class="highlighterContent"></span></div></div><div class="uiTypeahead composerTypeahead mentionsTypeahead" id="u3iluc_26" style="height: auto; "><div class="wrap"><input type="hidden" autocomplete="off" class="hiddenInput"><div class="innerWrap">
<!--CAMPO DE TEXTO-->
<textarea class="uiTextareaAutogrow input mentionsTextarea textInput    " title="Descripción de la Foto" name="descripcion" placeholder="Descripción de la Foto" onfocus="return wait_for_load(this, event, function() {if (!this._has_control) {  new TextAreaControl(this).setAutogrow(true);  this._has_control = true; } return wait_for_load(this, event, function() {;JSCC.get('j4ed5ee60e42de99836573835').init([&quot;buildBestAvailableNames&quot;,&quot;hoistFriends&quot;]);JSCC.get('j4ed5ee60e42de99836573834').init({&quot;max&quot;:10}, null);;;});});" autocomplete="off" style="height: 100px; "></textarea></div></div><div class="uiTypeaheadView    hidden_elem"></div></div>

</br>
<?
//Muestra albumes
$asdf=$fb->getalbums();

$n=0;
$d=sizeof($asdf);
echo 'Álbum: <select name="albumid">';
while ($n<$d){
$nombre=$asdf[$n]['name'];
$id=$asdf[$n]['id'];
echo '<option value="'.$id.'">'.$nombre.'</option>';
$n=$n+1;
}
echo '</select>';

?>

</br> Archivo:
  <input name="archivo" type="file" size="5" />
 

</br>
<label class="submitBtn uiButton uiButtonConfirm uiButtonLarge " for="u3iluc_27"><input value="Subir" type="submit" name="subir"></label><div>
<input name="action" type="hidden" value="upload" />    
</form>

<?

     if ($_POST["action"] == "upload") {
    // obtenemos los datos del archivo
    $tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
    $archivo = $_FILES["archivo"]['name'];
    $prefijo = substr(md5(uniqid(rand())),0,6);
   


  if($_POST['clave']==$contra){
    if ($_POST['subir']){
      if ($archivo != "") {
	  // guardamos el archivo a la carpeta files
	  $destino =  "temp/".$prefijo."_".$archivo;
	  if (copy($_FILES['archivo']['tmp_name'],$destino)) {
	      $status = "Archivo subido: <b>".$archivo."</b>";
	      $fb->publicarImagen($destino, $_POST['descripcion'], $_POST['albumid']);
	      unlink($destino);
	  } else {
	      $status = "Error al subir el archivo";
	  }
      } else {
	  $status = "Error al subir archivo";
      }
    }
    echo '<meta http-equiv="Refresh" content="3 ; URL=?mode=photo_express">';
  }
  else echo "<b>Contraseña Inválida.<b>";

}

else  echo "Listo para subir.";
?>
<div class="textBlurb fsm fwn fcg">
<div class="clearfix showOnceInteracted uiComposerMessageBoxControls">
</div></div></div></div>




<!--_______________________FIN DE LA CAJA DE NUEVO ALBUM _________________________-->



<?}else{?>
<div class="uiComposerMessageBox uiComposerMessageBoxMentions">
<h1><b>Compartir Estado</b></h1></br>
<div class="pas inputContainer">
<div class="highlighter" style="direction: ltr; text-align: left; ">
<div style="width: 481px; "><span class="highlighterContent"></span></div></div><div class="uiTypeahead composerTypeahead mentionsTypeahead" id="u3iluc_26" style="height: auto; "><div class="wrap"><input type="hidden" autocomplete="off" class="hiddenInput"><div class="innerWrap">
<!--CAMPO DE TEXTO-->
<textarea class="uiTextareaAutogrow input mentionsTextarea textInput    " title="Escribe acá el estado para <? echo $pagename;?>" name="estado" placeholder="Escribe acá el estado para <? echo $pagename;?>" onfocus="return wait_for_load(this, event, function() {if (!this._has_control) {  new TextAreaControl(this).setAutogrow(true);  this._has_control = true; } return wait_for_load(this, event, function() {;JSCC.get('j4ed5ee60e42de99836573835').init([&quot;buildBestAvailableNames&quot;,&quot;hoistFriends&quot;]);JSCC.get('j4ed5ee60e42de99836573834').init({&quot;max&quot;:10}, null);;;});});" autocomplete="off" style="height: 100px; "></textarea></div></div><div class="uiTypeaheadView    hidden_elem"></div></div></div><div class="clearfix showOnceInteracted uiComposerMessageBoxControls">

<?
//Actualiza Estado con Función "estado" y muestra "estado actual"
if ($_POST['send']){
  if($_POST['clave']==$contra){
    $fb->estado($_POST['estado']);
    if ($fb==True) echo "Estado actualizado sin dificultades";
    else if ($fb==False) echo "¡Ha ocurrido un error actualizando el estado!</br>Contacte al administrador.";
    else echo "Error desconocido D:!";
    echo '<meta http-equiv="Refresh" content="3 ; URL=?">';
  }
  else echo "<b>Contraseña Inválida.<b>";
}
else echo "Listo para enviar.";
?>
<ul class="uiList uiListHorizontal clearfix rfloat"><li class="privacyWidget uiListItem  uiListHorizontalItemBorder uiListHorizontalItem"><label class="submitBtn uiButton uiButtonConfirm uiButtonLarge " for="u3iluc_27">

<!--BOTÓN SUBMIT-->
<input value="Publicar" type="submit" name="send"></label></li></ul><div><div class="textBlurb fsm fwn fcg"></div></div></div></div>


<!--_______________________FIN DE LA CAJA DE ESTADO _________________________-->

<? } ?>

<div id="pagelet_home_stream" data-referrer="pagelet_home_stream" data-gt="{&quot;ref&quot;:&quot;nf&quot;}">
</br><h1><b>Muro de <a href="<? echo $pagelink;?>"><? echo $pagename;?></a></b></h1></br></br>
<hr>

<?
//INICIA MURO !

$asdf=$fb->getposts();

$n=0;

if ($_GET['delete_post']){ ?> <center> <?
    echo "<b>¿Está seguro de eliminar el post?</b></br>Recuerde ingresar la contraseña arriba</br>";
    echo '<input type = "submit" value="Sí, estoy seguro" name="eliminarpost">';
    echo '  <A HREF="?">No, no estoy seguro</a>';
    echo '</br></br>';
    if ($_POST['eliminarpost']){
    if ($_POST['clave']==$contra){
      $fb->delpost($_GET['delete_post']);
      if ($fb==True) echo "<b>Entrada eliminada sin dificultades.</b>";
      else if ($fb==False) echo "<b>Error: </b>Ha ocurrido un error borrando la entrada.</br> Revise la ID o contacte al administrador";
      else echo "<b>Error</b> desconocido D:!";
      echo "<br/><br/>";
      echo '<meta http-equiv="Refresh" content="3 ; URL=?">';
      }
      else echo "<b>Contraseña Incorrecta. Intente nuevamente</b></br></br>";
    }
}
?> </center> <?

while ($n<=10){
$usuario=$asdf[$n]['from']['name'];
$userid=$asdf[$n]['from']['id'];
$mensaje=$asdf[$n]['message'];
$post_id=$asdf[$n]['id'];
$type=$asdf[$n]['type'];
$picture=$asdf[$n]['picture'];
$link=$asdf[$n]['link'];
$application_name=$asdf[$n]['application']['name'];

echo "</br>";
echo '<A HREF="http://www.facebook.com/profile.php?id='.$userid.'" TARGET="_new"><b>'.$usuario.'</a></b>';
echo "</br>";
echo $mensaje;
if ($type=='photo' or $type=="link") echo '</br></br><a href="'.$link.'" TARGET="_new"><img src="'.$picture.'"></a>';
echo "</br></br>";
if ($asdf[$n]['icon']) echo '<img src="'.$asdf[$n]['icon'].'"> ';
if ($application_name) echo "<small>Vía ".$application_name." - </small>";
else echo "<small>Vía web - </small>";
echo '<small><A HREF="?delete_post='.$post_id.'">Eliminar Post</small></a>';
echo "<hr>";
$n=$n+1;

}
?>
</div>

<!--_______________________INICIA CAJA PARA ELIMINAR CUALQUIER POST__________-->

<div class="uiComposerMessageBox uiComposerMessageBoxMentions">
<h1><b>Eliminar Entrada por ID</b></h1></br>
<div class="pas inputContainer"><div class="highlighter" style="direction: ltr; text-align: left; "><div style="width: 481px; "><span class="highlighterContent"></span></div></div><div class="uiTypeahead composerTypeahead mentionsTypeahead" id="u3iluc_26" style="height: auto; "><div class="wrap"><div class="innerWrap">
<!--CAMPO DE TEXTO-->
Ingrese ID del Post a eliminar: 
<input type="text" name ="delete_id" size="15" maxlength="15" >
</br>Ejemplo: <font color="silver"> http://www.facebook.com/<? echo $pageid;?>/posts/</font>xxxxxxxxxxxxxxx
</div></div><div class="uiTypeaheadView    hidden_elem"></div></div></div><div class="clearfix showOnceInteracted uiComposerMessageBoxControls">

<?
//Elimina 
if ($_POST['delete']){
  if($_POST['clave']==$contra){
    if (strlen($_POST['delete_id'])==15){
      $fb->borrarestado($_POST['delete_id']);
      if ($fb==True) echo "Entrada eliminada sin dificultades.";
      else if ($fb==False) echo "<b>Error: </b>Ha ocurrido un error borrando la entrada.</br> Revise la ID o contacte al administrador";
      else echo "<b>Error</b> desconocido D:!";
    }
    else echo "<b>Error: </b>ID Inválido.";
    }
    else echo "<b>Contraseña Inválida.</b>";
}
else echo "Listo para eliminar entrada.";
?>
<ul class="uiList uiListHorizontal clearfix rfloat"><li class="privacyWidget uiListItem  uiListHorizontalItemBorder uiListHorizontalItem"><label class="submitBtn uiButton uiButtonConfirm uiButtonLarge " for="u3iluc_27">

<!--BOTÓN SUBMIT-->
<input value="Eliminar" type="submit" name="delete"></label></li></ul><div><div class="textBlurb fsm fwn fcg"></div></div></div></div>







<!--MUERTE AL GLOBAL CONTAINER!!!-->
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>