<?php
namespace tests\units;

require_once __DIR__ . '/../bootstrap.php';

use mageekguy\atoum;

class Mat2aParser extends atoum\test
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

    $mat2a = new \Mat2aParser($connection);
    $this->assert->variable($mat2a->getConnection())->isEqualTo($connection);
    $this->assert->variable($mat2a->getField())->isNull();
    $this->assert->variable($mat2a->getPeriod())->isNull();
    $this->assert->variable($mat2a->getYear())->isNull();
  }

  /**
   * testGetStatus
   *
   * @return void
   */
  public function testParse()
  {
    $this->mockGenerator->generate('\AutoihConnection');
    $connection = new \mock\AutoihConnection('http://localhost/autoih/api.php');

    $mat2aParser = new \Mat2aParser($connection);
    $mat2aParser->setField('had');
    $mat2aParser->setPeriod('M0');
    $mat2aParser->setYear('2012');
    $connection->getMockController()->post = function () {
      return false;
    };
    $this->assert
      ->exception(function() use ($mat2aParser) {
         $mat2aParser->parse('fichier');
      })
      ->isInstanceOf('\RuntimeException')
      ->hasMessage('Error getting /epmsi/parser/had/2012/M0/parse')
    ;
    $connection->getMockController()->post = function () {
      return '{"status":0,"message":"OK","content":{"1b":{"valorisation_brute":42}}}';
    };
    $this->assert->array($mat2aParser->parse('file'))->isEqualTo(array('1b' => array('valorisation_brute' => 42)));
  }

}
