<?php

class Genrsa extends BaseAutoihApi
{


  /**
   * @var string
   */
  protected $temporaryFile = null;

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
   * Crée une instance de Mat2a préparamétrée
   *
   * @param boolean $withFile Ajoute directement aux fichiers envoyés à Mat2a le fichier en sortie de GENRSA
   *
   * @return Mat2a L'instance de M2t2a préparamétrée
   */
  public function createMat2a($withFile = false)
  {
    $mat2a = new Mat2a($this->getConnection());
    $mat2a->setPeriod($this->getPeriod());
    $mat2a->setYear($this->getYear());
    $mat2a->setField('mco_stc');

    if ($withFile)
    {
      $this->temporaryFile = tempnam(sys_get_temp_dir(), 'genrsa');
      $this->writeFile('exported_zip', $this->temporaryFile);
      $mat2a->addFile('export_genrsa', $this->temporaryFile);
    }

    return $mat2a;
  }

  /**
   * __destruct
   *
   * @return void
   */
  public function __destruct()
  {
    if (is_file($this->temporaryFile))
    {
      unlink($this->temporaryFile);
    }
  }

}
