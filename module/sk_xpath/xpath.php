<?php

function url_curl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $result = curl_exec($ch);
  curl_close($ch);
  $result = str_replace ("\r","",$result);
  $result = str_replace ("\n","",$result);
  return $result;
}

function getXpath($source_code) {
  $source_code = mb_convert_encoding($source_code, 'HTML-ENTITIES', 'UTF-8');
  $doc = new DOMDocument();
  libxml_use_internal_errors(true);
  $doc->loadHTML($source_code);
  libxml_use_internal_errors(false);
  return new DomXPath($doc);
}

