<h1>İşlem Tamam</h1>

<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">DEVAM ET...</a>

<script>
    window.setTimeout(function(){
        window.location.href = "<?php echo $_SERVER['HTTP_REFERER']; ?>";
    }, 500);
</script>