<?php
require_once ('./db/connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //DDD($_POST);
    if ($_POST['miktar'] > 0) {
        $SQL = "INSERT INTO giderler SET hesap_id = 1, kategori_id = 1, miktar = :miktar, tur = :tur, aciklama = :aciklama";
        $SORGU = $DB->prepare($SQL);
        $SORGU->bindParam(':miktar',     $_POST['miktar']);
        $SORGU->bindParam(':tur',        $_POST['tur']);
        $SORGU->bindParam(':aciklama',   $_POST['aciklama']);
        $SORGU->execute();
      }
      header("location: islem.tamam.php");
      die();
    }
    
    // Sayfa başladı
    $opsHesap    = getOptions("SELECT * FROM ref_hesaplar", 0, 0, "** Seç **");

?>


<div class='row text-center'>
  <h1 class='alert alert-primary'>Gider İşlemleri</h1>
</div>



<form method="POST" autocomplete="off">optionsTag
      <tr>
       <th>Hesap</th>
        <th>Kategori</th>
        <th>Tur</th>
        <th>Miktar</th>
        <th>Açıklama</th>
     </tr>
    </thead>
        <tbody>
        <tr>
        <td><select name='hesap' style='width:100px;'><?php echo $opsHesap;?></select></td>
             <td><input type = 'text' name = 'kategori' value = '' style = 'width:100px'></td>
             <td><input type = 'text' name = 'tur' value = '' style = 'width:100px'></td>
            <td><input type = 'text' name = 'miktar' value = '500' style = 'width:100px;text-align:right'></td>
            <td><input type = 'text' name = 'aciklama' value = '' style = 'width:200px'></td>
        </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <input type="submit" value="Kaydet..." style="background-color: green; color: white; padding: 10px; border-radius: 10px; border:1px solid black">
  <p>&nbsp;</p>
  <a href="index.php" >Ana Sayfa</a>
</form>
