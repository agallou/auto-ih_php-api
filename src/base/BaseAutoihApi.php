<?php

abstract class BaseAutoihApi
{

  protected $connection;

  protected $id = null;
  protected $year = null;
  protected $period = null;
  protected $files = array();

  public function __construct(AutoihConnection $connection)
  {
    $this->connection = $connection;
  }

  /**
   *
   * @return AutoihConnection
   */
  public function getConnection()
  {
    return $this->connection;
  }

  abstract protected function getNameSpace();

  /**
   * setYear
   *
   * @param string $year
   *
   * @return BaseAutoihApi
   */
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

  public function addFile($type, $filepath)
  {
    $this->files[$type] = $filepath;

    return $this;
  }

  public function launch()
  {
    $ressourceUri = '/' . implode('/', array($this->getNamespace(), $this->year, $this->period, 'send'));

    $content = $this->connection->post($ressourceUri, $this->files);
    $json = json_decode($content);

    if (null === $json)
    {
      throw new RuntimeException(sprintf('Error during POST (%s) : "%s"', $ressourceUri, var_export($content, true)));
    }

    if ($json->status != 0)
    {
      throw new RuntimeException($json->message, $json->status);
    }

    $this->id = $json->content->id;

    return $this;
  }

  /**
   * Envoie les fichiers à l'API et attend qu'ils aient été traités
   *
   * @return BaseAutoihApi
   */
  public function launchAndWaitEnd()
  {
    $this->launch();
    $this->waitEnd();

    return $this;
  }

  /**
   * Attend que le traitement ait l'un des status passés en paramètre
   *
   * @param array $statuses tableau des status
   * @param int   $timeout
   *
   * @return BaseAutoihApi
   */
  public function waitForStatus(array $statuses, $timeout = 5000)
  {
    while (!in_array($this->getStatus(), $statuses))
    {
      sleep(5);
    }
    return $this;
  }

  /**
   * waitEnd
   *
   * @return BaseAutoihApi
   */
  public function waitEnd()
  {
    return $this->waitForStatus(array('SUCCESS', 'FAILURE'));
  }

  public function getStatus()
  {
    $ressourceUri = '/' . implode('/', array($this->getNamespace(), $this->year, $this->period, $this->getId(), 'status'));
    $content = $this->connection->get($ressourceUri);
    if (false === $content)
    {
      throw new \RuntimeException(sprintf('Error getting %s', $ressourceUri));
    }
    $json = json_decode($content);
    return $json->content->status;
  }

  public function getFile($type)
  {
    $ressourceUri = '/' . implode('/', array($this->getNamespace(), $this->year, $this->period, $this->getId(), 'file', $type));
    return $this->connection->get($ressourceUri);
  }

  public function getId()
  {
    return $this->id;
  }

  public function setId($id)
  {
    $this->id = $id;

    return $this;
  }

  /**
   * getApiUrl
   *
   * @return string
   */
  public function getApiUrl()
  {
    return $this->apiUrl;
  }

  /**
   * writeFile
   *
   * @param string $type
   * @param string $path
   *
   * @return BaseAutoihApi
   */
  public function writeFile($type, $path)
  {
    file_put_contents($path, $this->getFile($type));

    return $this;
  }

}
