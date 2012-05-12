<?php

class Genrsa extends BaseAutoihApi
{

  /**
   * getNamespace
   *
   * @return string
   */
  protected function getNamespace()
  {
    return 'genrsa';
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
    $mat2a->setField('mco_stc');
    return $mat2a;
  }

}
