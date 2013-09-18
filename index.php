<?php

$version = "0.0.1";
$url = @$_GET['url'];
$r = preg_match('#https?://(www\.)?([^/]+)/.*#', $url, $m);
$service = $m[2];

if (!$r) {
  $http = "400 Bad Request";
  $error = "Unrecognized URL";
  header("HTTP/1.0 $http");
  require_once('error.tpl.php');
  exit;
}

if (!file_exists("engines/{$service}.php")) {
  $http = "400 Bad Request";
  $error = "Unrecognized service: $service";
  header("HTTP/1.0 $http");
  require_once('error.tpl.php');
  exit;
}

require_once("engines/{$service}.php");

if (empty($tpl)) {
  $http = "400 Bad Request";
  $error = "Unable to parse page";
  header("HTTP/1.0 $http");
  require_once('error.tpl.php');
  exit;
}

header("Content-type: application/rss+xml");
require_once("mediarss.tpl.php");
