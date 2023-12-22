<?php

define(GLOBAL_YENI_KAYIT_SATIR_ADEDI, -3);

$servername = "localhost";
$DBname   = "gelirgider";
$username = "root";
$password = "root";

try {
  $DB = new PDO("mysql:host=$servername;dbname={$DBname}", $username, $password);
  // set the PDO error mode to exception
  $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}

function DD($var, $title=""){
  if($title<>"") echo "<h1>{$title}</h1>";
  echo "<pre>";
  print_r($var);
  echo "</pre>";
}

function DDD($var, $title=""){
  DD($var, $title="");
  die();
}


#################################################
################################################# getOptions
#################################################
function getOptions($SQL, $MevcutID = "-99999", $ilkID = "", $ilkLABEL = "", $ID = "id", $LABEL = "ad")
{
  global $DB;
  
  $SORGU = $DB->prepare($SQL);
  $SORGU->execute();
  $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);

  $myOptions = "";
  
  if ($ilkLABEL <> "") $myOptions = "<option value='{$ilkID}'>{$ilkLABEL}</option>";
  
  foreach ($rows as $row) {
    $secili = "";
    if ($MevcutID == $row[$ID]) $secili = "selected";
    $myOptions .= "<option value='{$row[$ID]}' {$secili}>{$row[$LABEL]}</option>\n";
  }
  return $myOptions;
}
