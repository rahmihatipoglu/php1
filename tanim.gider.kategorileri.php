<?php
require_once ('./db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   //DD($_POST);
  foreach ($_POST['ID'] as $ID => $value) {
    if ($ID < 0 and $_POST['kategori_adi'][$ID] <> "") {
      // Yeni bir kategori adı yazılmış. Ekleyelim...
      $SQL = "INSERT INTO ref_gider_kategoriler SET siralama = :siralama, ad = :kategori_adi";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':siralama',    $_POST['siralama'][$ID]);
      $SORGU->bindParam(':kategori_adi', $_POST['kategori_adi'][$ID]);
      $SORGU->execute();
      continue; // Aşağıdaki satırları işleme koyma, döngü devam etsin...
    }
    
    $SQL = "UPDATE ref_gider_kategoriler SET siralama = :siralama, ad = :kategori_adi WHERE id = :id";
    $SORGU = $DB->prepare($SQL);
    $SORGU->bindParam(':siralama',    $_POST['siralama'][$ID]);
    $SORGU->bindParam(':kategori_adi', $_POST['kategori_adi'][$ID]);
    $SORGU->bindParam(':id',          $_POST['ID'][$ID]);
    $SORGU->execute();

    if( $_POST['kategori_adi'][$ID] == "sil") {
      $SQL = "DELETE FROM ref_gider_kategoriler WHERE id = :id";
      $SORGU = $DB->prepare($SQL);
      $SORGU->bindParam(':id',          $_POST['ID'][$ID]);
      $SORGU->execute();
    }
  } // foreach
  
}

?>

<div class='row text-center'>
  <h1 class='alert alert-primary'>Gider Kategorileri</h1>
</div>

<form method="POST" autocomplete="off">
  <table class="table table-bordered table-hover table-striped table-sm">
    <thead>
      <tr>
        <th>ID</th>
        <th>Sıralama</th>
        <th>Ürün Kategorisi</th>
      </tr>
    </thead>
    <tbody>

      <?php

      $SORGU = $DB->prepare("SELECT * FROM ref_gider_kategoriler ORDER BY siralama");
      $SORGU->execute();
      $rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
      // DD($rows);

      foreach ($rows as $row) {
        // DDD($row);
        echo "
          <tr>
            <td>{$row['id']}<input type='hidden' name='ID[{$row['id']}]' value='{$row['id']}'></td>
            <td><input type='text' class='form-control form-control-sm' name='siralama[{$row['id']}]'    value='{$row['siralama']}'    style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='kategori_adi[{$row['id']}]' value='{$row['ad']}' style='width:300px;'></td>
          </tr> 
          ";
      } // foreach

      // Yeni kayıt ekleyebilmek için boş bir form oluşturalım
      for ($i = -1; $i >= GLOBAL_YENI_KAYIT_SATIR_ADEDI; $i--) {
        echo "
          <tr>
            <td>Yeni<input type='hidden' name='ID[{$i}]' value='{$i}'></td>
            <td><input type='text' class='form-control form-control-sm' name='siralama[{$i}]'    value='' style='width:100px;'></td>
            <td><input type='text' class='form-control form-control-sm' name='kategori_adi[{$i}]' value='' style='width:300px;'></td>
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