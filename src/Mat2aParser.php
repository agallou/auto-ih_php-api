<?php

class Mat2aParser
{

  protected $connection;
  protected $year = null;
  protected $period = null;

  /**
   * @var string
   */
  protected $field;

  public function __construct(AutoihConnection $connection)
  {
    $this->connection = $connection;
  }

  public function getConnection()
  {
    return $this->connection;
  }

  public function setYear($year)
  {
    $this->year = $year;

    return $this;
  }

  public function getYear()
  {
    return $this->year;
  }

  public function setPeriod($period)
  {
    $this->period = $period;

    return $this;
  }

  public function getPeriod()
  {
    return $this->period;
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

  public function parse($file)
  {
    $ressourceUri = sprintf('/epmsi/mat2a/%s/%s/%s/parse', $this->getField(), $this->getYear(), $this->getPeriod());
    $content = $this->connection->post($ressourceUri, array('export_epmsi' => $file));
    if (false === $content)
    {
      throw new \RuntimeException(sprintf('Error getting %s', $ressourceUri));
    }
    $content = json_decode($content, true);
    return $content['content'];
  }

}
