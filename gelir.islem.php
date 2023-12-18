<?php
require_once ('./db/connection.php');
?>
LEVEL 1
<select name="odeme_kasasi">
  <?php
  $SORGU = $DB->prepare("SELECT * FROM ref_gelir_kategoriler");
  $SORGU->execute();
  $ref_kasalar = $SORGU->fetchAll(PDO::FETCH_ASSOC);
  foreach ($ref_kasalar as $ref_kasa) {
    echo "<option value='{$ref_kasa['id']}'>{$ref_kasa['ad']}</option>";
  }
  ?>
</select>

LEVEL 2
<?php
$SORGU = $DB->prepare("SELECT * FROM ref_gider_kategoriler");
$SORGU->execute();
$ref_kasalar = $SORGU->fetchAll(PDO::FETCH_ASSOC);
?>

<select name="odeme_kasasi">
  <?php
  foreach ($ref_kasalar as $ref_kasa) {
    echo "<option value='{$ref_kasa['id']}'>{$ref_kasa['ad']}</option>";
  }
  ?>
</select>

LEVEL 3
<?php
$SORGU = $DB->prepare("SELECT * FROM ref_odeme_kategoriler");
$SORGU->execute();
$ref_kasalar = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$optionsKasalar = "";
foreach ($ref_kasalar as $ref_kasa) {
  $optionsKasalar .= "<option value='{$ref_kasa['id']}'>{$ref_kasa['ad']}</option>";
}

?>

<select name="odeme_kasasi">
  <?php echo $optionsKasalar; ?>
</select>



LEVEL 4
<?php
$editSatisID = 1;
$SORGU = $DB->prepare("SELECT * FROM giderler WHERE id='{$editSatisID}'");
$SORGU->execute();
$SATIS = $SORGU->fetchAll(PDO::FETCH_ASSOC);

$SORGU = $DB->prepare("SELECT * FROM ref_gelir_kategoriler");
$SORGU->execute();
$ref_kasalar = $SORGU->fetchAll(PDO::FETCH_ASSOC);
$optionsKasalar = "";
foreach ($ref_kasalar as $ref_kasa) {
  $secili = "";
  if ($SATIS['kasa_id'] == $ref_kasa['id']) $secili = "selected";
  $optionsKasalar .= "<option value='{$ref_kasa['id']}' {$secili}>{$ref_kasa['ad']}</option>";
}

?>

<select name="odeme_kasasi">
  <?php echo $optionsKasalar; ?>
  
</select>






LEVEL 5
<?php


function selectTag($NAME, $SQL, $ilkID = "", $ilkLABEL = "", $MevcutID = "-99999", $ID = "id", $LABEL = "ad")
{
  global $DB;
 
  $SORGU = $DB->prepare($SQL);
  $SORGU->execute();
  $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);

DD($rows);
  $myOptions = "";
  if ($ilkLABEL <> "") $myOptions = "<option '{$ilkID}'>{$ilkLABEL}</option>";

  foreach ($rows as $row) {
    $secili = "";
    if ($MevcutID == $row['{$ID}']) $secili = "selected";
    $myOptions .= "<option value='{$row['$ID']}' {$secili}>{$row['$LABEL']}</option>";
  }
  DD ($myOptions);
  echo "<select name='$NAME'>";
  echo $myOptions;
  echo "</select>";
}


?>

<?php echo selectTag("odeme_kasasi", "SELECT * FROM ref_odeme_kategoriler", 0, "** Seçiniz **"); ?>
<?php echo selectTag("gelir_kat", "SELECT * FROM ref_gelir_kategoriler"); ?>
<?php echo selectTag("gider_kat", "SELECT * FROM ref_gider_kategoriler"); ?>


LEVEL 6
OOP