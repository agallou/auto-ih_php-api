<?php

require_once(dirname(__FILE__) . '/BaseAutoihApi.php');

class Paprica extends BaseAutoihApi
{

  /**
   * getNamespace
   *
   * @return string
   */
  protected function getNamespace()
  {
    return 'paprica';
  }

}
