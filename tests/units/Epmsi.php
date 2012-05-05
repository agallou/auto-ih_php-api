<?php
namespace tests\units;

require_once __DIR__ . '/../../mageekguy.atoum.phar';
require_once __DIR__ . '/../../Epmsi.php';

use mageekguy\atoum;

class Epmsi extends atoum\test
{

  /**
   * testConstruct
   *
   * @return void
   */
  public function testConstruct()
  {
    $epmsi = new \Epmsi('http://localhost/autoih/api.php');
    $this->assert->string($epmsi->getApiUrl())->isEqualTo('http://localhost/autoih/api.php');
  }

}
