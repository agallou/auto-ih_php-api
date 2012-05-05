<?php
namespace tests\units;

require_once __DIR__ . '/../../mageekguy.atoum.phar';
require_once __DIR__ . '/../../Genrsa.php';

use mageekguy\atoum;

class Genrsa extends atoum\test
{

  /**
   * testConstruct
   *
   * @return void
   */
  public function testConstruct()
  {
    $genrsa = new \Genrsa('http://localhost/autoih/api.php');
    $this->assert->string($genrsa->getApiUrl())->isEqualTo('http://localhost/autoih/api.php');
  }

}
