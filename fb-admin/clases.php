<?php
require_once 'facebook.php';

/**
 * BASADO EN EL CÓDIGO PUBLICADO EN EL SIGUIENTE ARTÍCULO: http://mundogeek.net/archivos/2011/03/08/api-de-facebook-con-php/
 * Modificado por @Marcianisto al 08/12/2011
 * Clase para facilitar el trabajo con Facebook. Proporciona métodos para
 * publicar imágenes en un álbum, notas en el muro, y eventos
 *
 * Ejemplos de uso:
 * $fb = new Fb();
 * $fb->publicarNota('Prueba');
 * $fb->publicarImagen('/home/zootropo/html/imagenes/mi-imagen.jpg');
 * $fb-gt;publicarEvento('Prueba de evento', 'Descripción del evento', '2011-03-08');
 */
class Fb {
    const ID_APP = 'INSERT APP ID HERE';
    const SECRETO = 'INSERT APP SECRET HERE';
    const ACCESS_TOKEN = 'INSERT PAGE/PROFILE ACCESS TOKEN HERE';
    const ID_PAGINA = 'INSERT PAGE/PROFILE ID HERE';
    private $fb;

    /**
     * Constructor de la clase. Crea el objeto Facebook que utilizaremos
     * en los métodos que interactúan con la red social
     */
    function __construct() {
        $this->fb = new Facebook(array(
          'appId'  => self::ID_APP,
          'secret' => self::SECRETO,
          'cookie' => true
        ));
    }

    /**
     * Publica un evento
     * @param string $titulo Título del evento
     * @param string $descripcion Descripción del evento
     * @param string $inicio Fecha o fecha y hora de inicio del evento, en formato ISO-8601 o timestamp UNIX
     * @return bool Indica si la acción se llevó a cabo con éxito
     */
    function publicarEvento($titulo, $descripcion, $inicio) {
        $params = array(
            'access_token' => self::ACCESS_TOKEN,
            'name' => $titulo,
            'description' => $descripcion,
            'start_time' => $inicio,
        );
        $res = $this->fb->api('/'.self::ID_PAGINA.'/events', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    /**
     * Publica una nota en el muro de la página
     * @param string $mensaje
     * @return bool Indica si la acción se llevó a cabo con éxito
     */
    function estado($mensaje) {
        $params = array(
            'access_token' => self::ACCESS_TOKEN,
            'message' => $mensaje
        );
        $res = $this->fb->api('/'.self::ID_PAGINA.'/feed', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    function borrarestado($id) {
        $params = array(
            'access_token' => self::ACCESS_TOKEN
        );
        $res = $this->fb->api('/'.self::ID_PAGINA.'_'.$id, 'DELETE', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    function delpost($id) {
        $params = array(
            'access_token' => self::ACCESS_TOKEN
        );
        $res = $this->fb->api('/'.$id, 'DELETE', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }

    function getposts() {
	  // Formato: getposts()[0]['message'];
        $res = $this->fb->api('/'.self::ID_PAGINA.'/feed?&access_token='.self::ACCESS_TOKEN);
        if(!$res or $res->error) return "Error.";

        return $res['data'];
    }

    function getinfo() {
	  // Formato: getposts()[0]['message'];
        $res = $this->fb->api('/'.self::ID_PAGINA.'/?&access_token='.self::ACCESS_TOKEN);
        if(!$res or $res->error) return "Error.";

        return $res;
    }

    function getalbums() {
	  // Formato: getposts()[0]['message'];
        $res = $this->fb->api('/'.self::ID_PAGINA.'/albums?&access_token='.self::ACCESS_TOKEN);
        if(!$res or $res->error) return "Error.";

        return $res['data'];
    }

    function ultimopost() {
        $res = $this->fb->api('/'.self::ID_PAGINA.'/feed?limit=1&access_token='.self::ACCESS_TOKEN);
        if(!$res or $res->error) return "Error.";

        return $res['data'][0]['message'];
    }

    /**
     * Publica una imagen en el álbum de la página
     * @param string $ruta Ruta absoluta a la imagen en nuestro servidor
     * @param string $mensaje Mensaje a mostrar en el muro, si queremos avisar
     * de la subida de la imagen
     * @return bool Indica si la acción se llevó a cabo con éxito
     */

    function nuevoalbum($name,$message='') {
        $params = array(
            'access_token' => self::ACCESS_TOKEN,
	    'name' => $name
        );
        if($mensaje) $params['message'] = $mensaje;
        $res = $this->fb->api('/'.self::ID_PAGINA.'/albums', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }


    function publicarImagen($ruta, $mensaje='', $album) {
        $this->fb->setFileUploadSupport(true);

        $params = array(
            'access_token' => self::ACCESS_TOKEN,
            'source' => "@$ruta"
        );
        if($mensaje) $params['message'] = $mensaje;

        $res = $this->fb->api('/'.$album.'/photos', 'POST', $params);
        if(!$res or $res->error)
            return false;

        return true;
    }
} 
?>