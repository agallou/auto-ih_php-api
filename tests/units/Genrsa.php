<?php
namespace tests\units;

require_once __DIR__ . '/../bootstrap.php';

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
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $genrsa = new \Genrsa($connection);
    $this->assert->variable($genrsa->getId())->isNull();
    $this->assert->variable($genrsa->getPeriod())->isNull();
    $this->assert->variable($genrsa->getConnection())->isEqualTo($connection);
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

    $genrsa = new \Genrsa($connection);

    $this->assert->variable($genrsa->getId())->isNull();
    $this->assert->object($genrsa->setId('42'))->isInstanceOf('Genrsa');
    $this->assert->string($genrsa->getId())->isEqualTo('42');
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

    $genrsa = new \Genrsa($connection);
    $genrsa->setPeriod('M0');
    $genrsa->setId('69a7d9f2c4560159d39731b3c91515a5');
    $genrsa->setYear('2012');
    $connection->getMockController()->get = function () {
      return false;
    };
    $this->assert
      ->exception(function() use ($genrsa) {
         $genrsa->getStatus();
      })
      ->isInstanceOf('\RunTimeException')
      ->hasMessage('Error getting /genrsa/2012/M0/69a7d9f2c4560159d39731b3c91515a5/status')
    ;
    $connection->getMockController()->get = function () {
      return '{"status":0,"message":"OK","content":{"status":"RUNNING"}}';
    };
    $this->assert->string($genrsa->getStatus())->isEqualTo('RUNNING');
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

    $genrsa = new \Genrsa($connection);
    $genrsa->setPeriod('M0');
    $genrsa->setId('69a7d9f2c4560159d39731b3c91515a5');
    $genrsa->setYear('2012');
    $mat2a = $genrsa->createMat2a();
    $this->assert->object($mat2a)->isInstanceOf('\Mat2a');
    $this->assert->string($mat2a->getPeriod())->isEqualTo('M0');
    $this->assert->string($mat2a->getYear())->isEqualTo('2012');
    $this->assert->string($mat2a->getField())->isEqualTo('mco_stc');
  }

}
