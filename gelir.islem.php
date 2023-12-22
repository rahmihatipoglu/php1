
<?php
require_once ('./db/connection.php');
?>
<h3>LEVEL 1</h3>
<select name="odeme_kasasi">
  <?php
  $SQL="SELECT * FROM ref_gelir_kategoriler";
  $SORGU = $DB->prepare($SQL);
  $SORGU->execute();
  $ref_kasalar = $SORGU->fetchAll(PDO::FETCH_ASSOC);
  foreach ($ref_kasalar as $ref_kasa) {
    echo "<option value='{$ref_kasa['id']}'>{$ref_kasa['ad']}</option>";
  }
  ?>
</select>

<h3>LEVEL 2</h3>
<?php
$SQL="SELECT * FROM ref_gider_kategoriler";
$SORGU = $DB->prepare($SQL);
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

<h3>LEVEL 3</h3>
<?php
$SQL="SELECT * FROM ref_odeme_kategoriler";
$SORGU = $DB->prepare($SQL);
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



<h3>LEVEL 4</h3>
<?php
$editSatisID = 1;
$SQL="SELECT * FROM giderler WHERE id='{$editSatisID}'";
$SORGU = $DB->prepare($SQL);
$SORGU->execute();
$SATIS = $SORGU->fetchAll(PDO::FETCH_ASSOC);

$SQL="SELECT * FROM ref_gelir_kategoriler";
$SORGU = $DB->prepare($SQL);
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





<h3>LEVEL 5</h3>
<?php


function selectTag($NAME, $SQL, $MevcutID = "-99999", $ilkID = "", $ilkLABEL = "", $ID = "id", $LABEL = "ad")
{
  global $DB;
  $SORGU = $DB->prepare($SQL);
  $SORGU->execute();
  $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);

  $myOptions = "";
  
  if ($ilkLABEL <> "") $myOptions = "<option '{$ilkID}'>{$ilkLABEL}</option>";
  
  foreach ($rows as $row) {
    $secili = "";
    if ($MevcutID == $row['{$ID}']) $secili = "selected";
    $myOptions .= "<option value='{$row[$ID]}' {$secili}>{$row[$LABEL]}</option>\n";
  }

  return "<select name='$NAME'>\n
            {$myOptions}
          </select>\n";

}


?>

<?php echo selectTag("odeme_kasasi", "SELECT * FROM ref_odeme_kategoriler", 0, "** Seçiniz **"); ?>
<?php echo selectTag("gelir_kat", "SELECT * FROM ref_gelir_kategoriler"); ?>
<?php echo selectTag("gider_kat", "SELECT * FROM ref_gider_kategoriler"); ?>


