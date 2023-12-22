<?php
require_once ('./db/connection.php');
 

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
  DDD($_POST);
  foreach ($_POST['ID'] as $ID => $value) {
    if ($ID < 0 and $_POST['miktar'][$ID] > 0) {
    
      // Yeni bir kategori adı yazılmış. Ekleyelim...
      $SQL = "INSERT INTO gelirler SET hesap_id = :hesap, kategori_id = :kategori, miktar = :miktar, tur = :tur, aciklama = :aciklama";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':hesap',      $_POST['hesap'][$ID]);
      $SORGU->bindParam(':kategori',   $_POST['kategori'][$ID]);
      $SORGU->bindParam(':miktar',     $_POST['miktar'][$ID]);
      $SORGU->bindParam(':tur',        $_POST['tur'][$ID]);
      $SORGU->bindParam(':aciklama',   $_POST['aciklama'][$ID]);
      $SORGU->execute();
      continue; // Aşağıdaki satırları işleme koyma, döngü devam etsin...
    }
    
    $SQL = "UPDATE gelirler SET hesap_id = :hesap, kategori_id = :kategori, miktar = :miktar, tur = :tur, aciklama = :aciklama WHERE id = :id";
    $SORGU = $DB->prepare($SQL);
    $SORGU->bindParam(':hesap',    $_POST['hesap'][$ID]);
    $SORGU->bindParam(':kategori', $_POST['kategori'][$ID]);
    $SORGU->bindParam(':miktar',   $_POST['miktar'][$ID]);
    $SORGU->bindParam(':tur',      $_POST['tur'][$ID]);
    $SORGU->bindParam(':aciklama', $_POST['aciklama'][$ID]);
    $SORGU->bindParam(':id',       $_POST['ID'][$ID]);
    
    $SORGU->execute();

    if($_POST['aciklama'][$ID] == "sil") {
      $SQL = "DELETE FROM gelirler WHERE id = :id";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':id', $_POST['ID'][$ID]);

      $SORGU->execute();
    }
  } // foreach
  // post için yapılacaklar bitti...
  header("location: islem.tamam.php");
  die();
} // if ($_SERVER["REQUEST_METHOD"] == "POST") {

?>

<div class='row text-center'>
  <h1 class='alert alert-primary'>Gelir İşlemleri</h1>
</div>

<form method="POST" autocomplete="off">
  <table border="0" cellpadding="7" cellspacing="0">
    <thead>
      <tr>
        <th>ID</th>
        <th>Hesap</th>
        <th>Kategori</th>
        <th>Tur</th>
        <th>Miktar</th>
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
        $TARIH = date("d.m.Y, H:i:s", strtotime($row['zaman']));
        $opsHesap    = getOptions("SELECT * FROM ref_hesaplar",          $row['hesap_id']);
        $opsKategori = getOptions("SELECT * FROM ref_odeme_kategoriler", $row['kategori_id']);
        $opsTur      = getOptions("SELECT * FROM ref_gelir_kategoriler", $row['tur']);
        echo "
          <tr>
            <td>{$row['id']}<input type='hidden' name='ID[{$row['id']}]' value='{$row['id']}'></td>
            <td><select name='hesap[{$row['   $id']}]' style='width:100px;'><?php echo $opsHesap;?></select>{$opsHesap}   </select></td>
            <td><select name='kategori[{$row['$id']}]' style='width:100px;'><?php echo $opsKategori;?></select></td>
            <td><select name='tur[{$row['$id']}]'      style='width:100px;'><?php echo $opsTur;?></select></td>
            <td><input type='text' name='miktar[{$row['id']}]'   value='{$row['miktar']}'   style='width:100px;text-align:right;'></td>
            <td><input type='text' name='aciklama[{$row['id']}]' value='{$row['aciklama']}' style='width:100px;'></td>
            <td>{$TARIH}</td>
          </tr> ";
      } // foreach

      // Yeni kayıt ekleyebilmek için boş bir form oluşturalımtanim.hesaplar.php name='siralama[{$i}]' 
      for ($i = -1; $i >= GLOBAL_YENI_KAYIT_SATIR_ADEDI; $i--) {
        $TARIH = date("d.m.Y, H:i:s", strtotime($row['zaman']));
        $opsHesap    = getOptions("SELECT * FROM ref_hesaplar",          0, 0, "Seç");
        $opsKategori = getOptions("SELECT * FROM ref_odeme_kategoriler", 0, 0, "Seç");
        $opsTur      = getOptions("SELECT * FROM ref_gelir_kategoriler", 0, 0, "Seç");
        echo "
          <tr>
            <td>Yeni<input type='hidden' name='ID[{$i}]' value='{$i}'></td>
            <td><select name='hesap[{$i}]'    style='width:100px;'>{$opsHesap}   </select></td>
            <td><select name='kategori[{$i}]' style='width:100px;'>{$opsKategori}</select></td>
            <td><select name='tur[{$i}]'      style='width:100px;'>{$opsTur}     </select></td>
            <td><input type='text' name='miktar[{$i}]'   value='' style='width:100px;text-align:right;'></td>
            <td><input type='text' name='aciklama[{$i}]' value='' style='width:100px;'></td>
            <td>{$TARIH}</td>
          </tr> ";

      }
?>
    </tbody>
  </table>

  <input type="submit" value="Güncelle..." class="btn btn-success btn-lg">
  <br/>
  <br/>
  <a href="index.php" >Ana Sayfa</a>
</form>