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

  /**
   * testId
   *
   * @return void
   */
  public function testId()
  {
    $genrsa = new \Genrsa('http://localhost/autoih/api.php');
    $this->assert->variable($genrsa->getId())->isNull();
    $this->assert->object($genrsa->setId('42'))->isInstanceOf('Genrsa');
    $this->assert->string($genrsa->getId())->isEqualTo('42');
  }

}
