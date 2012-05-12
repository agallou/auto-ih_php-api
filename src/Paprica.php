<?php

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

  /**
   * createMat2a
   *
   * @return Mat2a
   */
  public function createMat2a()
  {
    $mat2a = new Mat2a($this->getConnection());
    $mat2a->setPeriod($this->getPeriod());
    $mat2a->setYear($this->getYear());
    $mat2a->setField('had');

    return $mat2a;
  }

}
