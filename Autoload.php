<?php


class AutoihAutoload
{

  /**
   * @static
   *
   */
  static public function register()
  {
    ini_set('unserialize_callback_func', 'spl_autoload_call');
    spl_autoload_register(array(new self, 'autoload'));
  }

  /**
   * @static
   *
   * @param string $class
   *
   * @return null
   */
  static public function autoload($class)
  {
    $classes = array(
      'AutoihConnection' => dirname(__FILE__) . '/src/AutoihConnection.php',
      'Paprica'          => dirname(__FILE__) . '/src/Paprica.php',
      'Genrsa'           => dirname(__FILE__) . '/src/Genrsa.php',
      'Mat2a'            => dirname(__FILE__) . '/src/Mat2a.php',
      'BaseAutoihApi'    => dirname(__FILE__) . '/src/base/BaseAutoihApi.php',
    );
    if (!array_key_exists($class, $classes))
    {
      return;
    }
    require $classes[$class];
  }

}
