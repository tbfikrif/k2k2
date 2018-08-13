<?php  
 //fetch.php 
    $sql4 = "SELECT cuti_used,cuti_qty FROM tb_cuti_anggota WHERE id_anggota ='$_SESSION[id_anggota]' ";
    $result4=mysqli_query($koneksi, $sql4);
    $values4=mysqli_fetch_assoc($result4);
    $sisacuti= $values4['cuti_qty'] - $values4['cuti_used'];
    echo $sisacuti;
?>