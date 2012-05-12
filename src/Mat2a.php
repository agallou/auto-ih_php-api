<?php

class Mat2a extends BaseAutoihApi
{

  /**
   * @var string
   */
  protected $field;

  /**
   * getNamespace
   *
   * @return string
   */
  protected function getNamespace()
  {
    return sprintf('epmsi/mat2a/%s', $this->getField());
  }

  /**
   * @param string $field
   *
   * @return $this
   */
  public function setField($field)
  {
    $this->field = $field;

    return $this;
  }

  /**
   * @return string
   */
  public function getField()
  {
    return $this->field;
  }

  /**
   * createParser
   *
   * @return Mat2aParser
   */
  public function createParser()
  {
    $parser = new Mat2aParser($this->getConnection());
    $parser->setPeriod($this->getPeriod());
    $parser->setYear($this->getYear());
    $parser->setField($this->getField());

    return $parser;
  }

}
