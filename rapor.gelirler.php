
<link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

<script src="//code.jquery.com/jquery-3.7.0.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>



    


<?php
require_once('./db/connection.php');
$SORGU = $DB->prepare("SELECT * FROM gelirler ORDER BY id" );
$SORGU->execute();
$rows = $SORGU->fetchAll(PDO::FETCH_ASSOC);
?>

<table border="0" id='myTable' cellpadding="7" cellspacing="0">
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
  foreach ($rows as $key => $row) {
    echo "
    <tr>
    <td>{$row['id']}</td>
    <td>{$row['hesap_id']}</td>
    <td>{$row['kategori_id']}</td>
    <td>{$row['tur']}</td>
    <td>{$row['miktar']}</td>
    <td>{$row['aciklama']}</td>
    <td>{$row['zaman']}</td>
    </tr>
    
    ";
  }
  ?>

</tbody>      
</table>

<script>
  let table = new DataTable('#myTable');
</script>