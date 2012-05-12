<?php
namespace tests\units;

require_once __DIR__ . '/../../mageekguy.atoum.phar';
require_once __DIR__ . '/../../Autoload.php';
\AutoihAutoload::register();

use mageekguy\atoum;

class Paprica extends atoum\test
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

    $paprica = new \Paprica($connection);
    $this->assert->variable($paprica->getId())->isNull();
    $this->assert->variable($paprica->getPeriod())->isNull();
    $this->assert->variable($paprica->getConnection())->isEqualTo($connection);
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

    $paprica = new \Paprica($connection);

    $this->assert->variable($paprica->getId())->isNull();
    $this->assert->object($paprica->setId('42'))->isInstanceOf('Paprica');
    $this->assert->string($paprica->getId())->isEqualTo('42');
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

    $paprica = new \Paprica($connection);
    $paprica->setPeriod('M0');
    $paprica->setId('69a7d9f2c4560159d39731b3c91515a5');
    $paprica->setYear('2012');
    $connection->getMockController()->get = function () {
      return false;
    };
    $this->assert
      ->exception(function() use ($paprica) {
         $paprica->getStatus();
      })
      ->isInstanceOf('\RunTimeException')
      ->hasMessage('Error getting /paprica/2012/M0/69a7d9f2c4560159d39731b3c91515a5/status')
    ;
    $connection->getMockController()->get = function () {
      return '{"status":0,"message":"OK","content":{"status":"RUNNING"}}';
    };
    $this->assert->string($paprica->getStatus())->isEqualTo('RUNNING');
  }

  /**
   * testCreateMat2a
   *
   * @return void
   */
  public function testCreateMat2a()
  {
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $paprica = new \Paprica($connection);
    $paprica->setPeriod('M0');
    $paprica->setId('69a7d9f2c4560159d39731b3c91515a5');
    $paprica->setYear('2012');
    $mat2a = $paprica->createMat2a();
    $this->assert->object($mat2a)->isInstanceOf('\Mat2a');
    $this->assert->string($mat2a->getPeriod())->isEqualTo('M0');
    $this->assert->string($mat2a->getYear())->isEqualTo('2012');
    $this->assert->string($mat2a->getField())->isEqualTo('had');
  }


}
