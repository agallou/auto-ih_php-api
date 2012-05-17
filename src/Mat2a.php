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

  /**
   * Renvoie les tableaux mat2a parsés
   *
   * Raccourci évitant de devoir créer un instance de Mat2a et de lui
   * passer le fichier ZIP en sortie de MAT2A.
   *
   * @return array
   */
  public function parse()
  {
    $tempFile = tempnam(sys_get_temp_dir(), 'mat2a');
    $this->writeFile('exported_zip', $tempFile);
    $values = $this->createParser()->parse($tempFile);
    unlink($tempFile);

    return $values;
  }

}
