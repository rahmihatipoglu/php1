<?php
require_once ('./db/connection.php');

//LEVEL 5
function selectTag($NAME, $SQL, $ilkID = "", $ilkLABEL = "", $MevcutID = "-99999", $ID = "id", $LABEL = "adi")
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
    $myOptions .= "<option value='{$row['$ID']}' {$secili}>{$row['$LABEL']}</option>";
  }
  echo "<select name='$NAME'>";
  echo $myOptions;
  echo "</select>";
}
/* 
<?php echo selectTag("odeme_kasasi", "SELECT * FROM ref_kategoriler", 0, "** Seçiniz **"); ?>
<?php echo selectTag("gelir_kat", "SELECT * FROM ref_gelirler"); ?>
<?php echo selectTag("gider_kat", "SELECT * FROM ref_giderler"); ?>
 */


 if ($_SERVER["REQUEST_METHOD"] == "POST") {
   //DD($_POST);
   DD($_POST['kategori']);
  foreach ($_POST['ID'] as $ID => $value) {
    if ($ID < 0 and $_POST['kategori'][$ID] <> "") {
    
      // Yeni bir kategori adı yazılmış. Ekleyelim...
      $SQL = "INSERT INTO gelirler SET hesap_id = :hesap, kategori_id = :kategori, miktar = :miktar, tur = :tur, aciklama = :aciklama";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':hesap_id',      $_POST['hesap'][$ID]);
      $SORGU->bindParam(':kategori_id',   $_POST['kategori'][$ID]);
      $SORGU->bindParam(':miktar',        $_POST['miktar'][$ID]);
      $SORGU->bindParam(':tur',           $_POST['tur'][$ID]);
      $SORGU->bindParam(':aciklama',      $_POST['aciklama'][$ID]);
     // DD($SQL);
      $SORGU->execute();
      continue; // Aşağıdaki satırları işleme koyma, döngü devam etsin...
    }
    
    $SQL = "UPDATE gelirler SET hesap_id = :hesap, kategori_id = :kategori, miktar = :miktar, tur = :tur, aciklama = :aciklama WHERE id = :id";
    $SORGU = $DB->prepare($SQL);
    $SORGU->bindParam(':hesap_id',    $_POST['hesap'][$ID]);
    $SORGU->bindParam(':kategori_id', $_POST['kategori'][$ID]);
    $SORGU->bindParam(':miktar', $_POST['miktar'][$ID]);
    $SORGU->bindParam(':tur', $_POST['tur'][$ID]);
    $SORGU->bindParam(':aciklama', $_POST['aciklama'][$ID]);
    $SORGU->bindParam(':id', $_POST['ID'][$ID]);
    //DD($SQL);
    $SORGU->execute();

    if($_POST['kategori'][$ID] == "sil") {
      $SQL = "DELETE FROM gelirler WHERE id = :id";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':id', $_POST['ID'][$ID]);
      $SORGU->execute();
    }
  } // foreach
  
}

?>

<div class='row text-center'>
  <h1 class='alert alert-primary'>Gelir İşlemleri</h1>
</div>

<form method="POST" autocomplete="off">
  <table class="table table-bordered table-hover table-striped table-sm">
    <thead>
      <tr>
        <th>ID</th>
        <th>Hesap</th>
        <th>Kategori</th>
        <th>Miktar</th>
        <th>Tur</th>
        <th>Açıklama</th>
        <th>Tarih</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $SORGU = $DB->prepare("SELECT * FROM gelirler ORDER BY id" );
      $SORGU->execute();
      $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
      // DD($rows);

      foreach ($rows as $row) {
        // DDD($row);
        echo "
          <tr>
            <td>{$row['id']}<input type='hidden' name='ID[{$row['id']}]' value='{$row['id']}'></td>
            <td><input type='text' class='form-control form-control-sm' name='hesap[{$row['id']}]'    value='{$row['hesap_id']}'    style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='kategori[{$row['id']}]' value='{$row['kategori_id']}' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='miktar[{$row['id']}]' value='{$row['miktar']}' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='tur[{$row['id']}]' value='{$row['tur']}' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='aciklama[{$row['id']}]' value='{$row['aciklama']}' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='zaman[{$row['id']}]' value='{$row['zaman']}' style='width:100px;'></td>
          </tr> 
          ";
      } // foreach

      // Yeni kayıt ekleyebilmek için boş bir form oluşturalımtanim.hesaplar.php name='siralama[{$i}]' 
      for ($i = -1; $i >= GLOBAL_YENI_KAYIT_SATIR_ADEDI; $i--) {
        echo "
          <tr>
            <td>Yeni<input type='hidden' name='ID[{$i}]' value='{$i}'></td>
            <td><input type='text' class='form-control form-control-sm' name='hesap[{$i}]'    value=''  style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='kategori[{$i}]' value='' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='miktar[{$i}]' value='' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='tur[{$i}]' value='' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='aciklama[{$i}]' value='' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='zaman[{$i}]' value='' style='width:100px;'></td>
          </tr> 
        ";
      }

      ?>

    </tbody>
  </table>
  <input type="submit" value="Güncelle..." class="btn btn-success btn-lg">
  <br/>
  <br/>
  <a href="index.php" >Ana Sayfa</a>

</form>