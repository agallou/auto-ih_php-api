<?php
class AutoihConnection
{

  protected $apiEndpoint;

  public function __construct($apiEndpoint)
  {
    $this->apiEndpoint = $apiEndpoint;
  }

  public function post($ressourceUri, array $files)
  {
    $url = $this->apiEndpoint . $ressourceUri;
    $postFields = array();
    foreach ($files as $type => $field)
    {
      $postFields[$type] = '@' . $field;
    }
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    return curl_exec($ch);
  }

  public function get($ressourceUri)
  {
    $url = $this->apiEndpoint . $ressourceUri;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    return curl_exec($ch);
  }

}
