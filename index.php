<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GELİR GİDER HESABI</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        
        <div class="row mt-3 mb-3">
            <div class="col-md-6">
                <h2>GELİR GİDER</h2>
            </div>
            <div class="col-md-6 text-end">
                <a href="gelir.php" class="btn btn-success"> (+) Gelir</a>
            
                         <a href="gider.php" class="btn btn-danger"> Gider (-)</a>
            </div>
        </div>

        <div>
            <h1>Ayarlar </h1>
            <ul>

        <li> <a href="tanim.gider.kategorileri.php" >Gider Kategorileri</a></li>
        <li><a href="tanim.gelir.kategorileri.php" >Gelir Kategorileri</a></li>
        <li><a href="tanim.odeme.kategorileri.php" >Ödeme Kategorileri</a></li>
        <li><a href="tanim.hesaplar.php" >Hesap Tanımları</a>
        <li><a href="rapor.gelirler.php" >Gelir Raporu</a>
            </ul>
<br/>
       </div>

        <table class='table table-striped table-light table-hover'>
            <tr>
                <th> ID </th>
                <th> Adı </th>
                <th> Miktar </th>
                <th> Telefon </th>
                <th> E-posta </th>
                <th class='text-end'> Actions </th>
            </tr>

    <?php
        include('./db/connection.php');
        $SORGU = $DB->prepare("SELECT h.id, h.ad, sum(g.miktar) miktar,h.telefon,h.eposta
            FROM ref_hesaplar h,gelirler g where h.id=g.hesap_id GROUP BY h.id");
        $SORGU->execute();
        $users = $SORGU->fetchAll(PDO::FETCH_ASSOC);
        //echo '<pre>'; print_r($users);

        foreach($users as $user) { ?>
            <tr>
                <td> <?= $user['id'] ?> </td>
                <td> <?= $user['ad'] ?> </td>
                <td style="text-align:right"> <?= $user['miktar'] ?> </td>
                <td> <?= $user['telefon'] ?> </td>
                <td> <?= $user['eposta'] ?> </td>
                <td class='text-end'>
                    <a href='update.php?id=<?= $user['id'] ?>' class='btn btn-success'>Update</a>
                    <form action='db/action.php' method='post' class='d-inline'>
                         <button class='btn btn-danger' type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ?>

    </table>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

