<?php
namespace tests\units;

require_once __DIR__ . '/../../mageekguy.atoum.phar';
require_once __DIR__ . '/../../Mat2a.php';

use mageekguy\atoum;

class Mat2a extends atoum\test
{

  /**
   * testConstruct
   *
   * @return void
   */
  public function testConstruct()
  {
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $mat2a = new \Mat2a($connection);
    $this->assert->variable($mat2a->getId())->isNull();
    $this->assert->variable($mat2a->getPeriod())->isNull();
    $this->assert->variable($mat2a->getConnection())->isEqualTo($connection);
    $this->assert->variable($mat2a->getField())->isNull();
  }

  /**
   * testId
   *
   * @return void
   */
  public function testId()
  {
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $mat2a = new \Mat2a($connection);

    $this->assert->variable($mat2a->getId())->isNull();
    $this->assert->object($mat2a->setId('42'))->isInstanceOf('Mat2a');
    $this->assert->string($mat2a->getId())->isEqualTo('42');
  }

  /**
   * testGetStatus
   *
   * @return void
   */
  public function testGetStatus()
  {
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $mat2a = new \Mat2a($connection);
    $mat2a->setPeriod('M0');
    $mat2a->setId('69a7d9f2c4560159d39731b3c91515a5');
    $mat2a->setField('had');
    $mat2a->setYear('2012');
    $connection->getMockController()->get = function () {
      return false;
    };
    $this->assert
      ->exception(function() use ($mat2a) {
         $mat2a->getStatus();
      })
      ->isInstanceOf('\RunTimeException')
      ->hasMessage('Error getting /epmsi/mat2a/had/2012/M0/69a7d9f2c4560159d39731b3c91515a5/status')
    ;
    $connection->getMockController()->get = function () {
      return '{"status":0,"message":"OK","content":{"status":"RUNNING"}}';
    };
    $this->assert->string($mat2a->getStatus())->isEqualTo('RUNNING');
  }

}
