<?php

class BaseAutoihApi
{

  protected $apiUrl;

  protected $id = null;
  protected $year = null;
  protected $period = null;
  protected $files = array();

  public function __construct($apiUrl)
  {
    $this->apiUrl = $apiUrl;
  }

  public function setYear($year)
  {
    $this->year = $year;

    return $this;
  }

  public function setPeriod($period)
  {
    $this->period = $period;

    return $this;
  }

  public function addFile($type, $filepath)
  {
    $this->files[$type] = $filepath;

    return $this;
  }

  public function launch()
  {
    $url = sprintf('%s/%s/%s/send', $this->apiUrl, $this->getNamespace(), $this->year);
    $postFields = array();
    foreach ($this->files as $type => $field)
    {
      $postFields[$type] = '@' . $field;
    }
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $content = curl_exec($ch);
    $json = json_decode($content);
    $this->id = $json->content->id;

    return $this;
  }

  public function waitForStatus(array $statuses, $timeout = 5000)
  {
    while (!in_array($this->getStatus(), $statuses))
    {
      sleep(5);
    }
    return $this;
  }

  public function getStatus()
  {
    $url = sprintf('%s/%s/%s/%s/status', $this->apiUrl, $this->getNamespace(), $this->year, $this->getId());
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec($ch);
    $json = json_decode($content);
    return $json->content->status;
  }

  public function getFile($type)
  {
    $url = sprintf('%s/%s/%s/%s/file/%s', $this->apiUrl, $this->getNamespace(), $this->year, $this->getId(), $type);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($ch);
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


}
