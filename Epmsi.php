<?php

require_once(dirname(__FILE__) . '/BaseAutoihApi.php');

class Epmsi extends BaseAutoihApi
{

  /**
   * getNamespace
   *
   * @return string
   */
  protected function getNamespace()
  {
    return 'epmsi';
  }

}
