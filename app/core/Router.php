<?php 

namespace App\Core;

class Router 
{

  /**
   * Registro de rutas disponibles
   * @var array
   */
  private static $routes = Array();

  /**
   * Acción a realizar en caso de no existir el path
   * @var callable
   */
  private static $pathNotFound = null;
  
  /**
   * Acción a realizar en caso de recibir un tipo de petición incorrecto
   * @var callable
   */
  private static $methodNotAllowed = null;

  /**
    * Añade una nueva ruta
    
    * @param string $params    Cadena de la ruta o parámetros
    * @param callable $action    Acción a la que llamar si la ruta existe
    * @param string|array $method  Cadena con los tipos de petición permitidos o array con parámetros
    *
    */
  public static function add($params, $action, $method = 'get')
  {
    array_push(self::$routes,
    [
      'params' => $params,
      'action' => $action,
      'method' => $method
    ]);
  }   

  /**
   * Devuelve todas las rutas
   *
   * @return array
   */
  public static function getAll()
  {
    return self::$routes;
  }

  /**
   * Asigna la función pasada como argumento
   * a $pathNotFound
   *
   * @param callable $action
   * 
   * @return void
   */
  public static function pathNotFound($action) 
  {
    self::$pathNotFound = $action;
  }
  
  /**
   * Asigna la función pasada como argumento
   * a $methodNotAllowed
   *
   * @param callable $action
   * @return void
   */
  public static function methodNotAllowed($action)
  {
    self::$methodNotAllowed = $action;
  }

  public static function run($basepath = '/')
  {

    $path_match_found = false;
    $route_match_found = false;

    // Descompone la URI
    $parsed_url = parse_url($_SERVER['REQUEST_URI']);//Parse Uri

    //Si encuentra el path lo almacena, si no establece un path por defecto.
    if(isset($parsed_url['path']))
    {
      $path = $parsed_url['path'];
    }
    else
    {
      $path = '/';
    }

    // Obtiene el tipo de petición
    $method = $_SERVER['REQUEST_METHOD'];


    foreach(self::$routes as $route)
    {

      // Si el basepath está establecido y es distinto a '/',
      if($basepath != '' && $basepath != '/')
      {
        // Añade el path a los parámetros de búsqueda
        $route['params'] = '('.$basepath.')'.$route['params'];
      }

      // Indicamos el principio y el final de la cadena mediante expresiones regulares
      $route['params'] = '^'.$route['params'];
      $route['params'] = $route['params'].'$';

      // Mediante expresiones regulares comprobamos si los parámetros en params coinciden	 
      // con la cadena pasada en la petición
      if(preg_match('#'.$route['params'].'#', $path, $matches))
      {

        $path_match_found = true;

        // Si el tipo de petición conincide con alguno de los permitidos...
        if(strtolower($method) == strtolower($route['method']))
        {
          //...eliminamos el primer elemento, ya que contiene la cadena entera.
          array_shift($matches);

          // Si el basepath está establecido y es distinto a '/'...
          if($basepath !='' && $basepath != '/')
          {
            //...lo eliminamos, dejando únicamente los parámetros correspondientes a action
            array_shift($matches);
          }

          //Llamamos a la función correspondiente almacenada en 'action' y le pasamos los parámetros correspondientes
          call_user_func_array($route['action'], $matches);

          $route_match_found = true;

          // Al obtener una ruta coincidente, dejamos de comparar las otras rutas
          break;
        }
      }
    }

    // Si ninguna ruta coincide con los parámetros recibidos en la petición
    if(!$route_match_found)
    {
      // Pero el path sí coincide
      if($path_match_found)
      {
        //lanza un error 405
        header("HTTP/1.0 405 Method Not Allowed");

        //Si $methodNotAllowed contiene alguna instrucción
        if(self::$methodNotAllowed)
        {
          //Se ejecuta la acción correspondiente al path y tipo de petición recibidos
          call_user_func_array(self::$methodNotAllowed, Array($path,$method));
        }
      }
      // Si el path tampoco coincide
      else
      {
        //lanza un error 404
        header("HTTP/1.0 404 Not Found");

        // Si $pathNotFound contiene alguna instrucción
        if(self::$pathNotFound)
        {
          // Se ejecuta la acción correspondiente al path recibido
          call_user_func_array(self::$pathNotFound, Array($path));
        }
      }
    }
  }
}
 ?>