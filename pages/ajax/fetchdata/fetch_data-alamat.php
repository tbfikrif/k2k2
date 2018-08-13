<?php
    include "../../../fungsi_kakatu.php";
    $latitude = isset($_POST['latitude']) ? $_POST['latitude'] : null;
    $longitude = isset($_POST['longitude']) ? $_POST['longitude'] : null;
    $address = getAddress($latitude, $longitude);
    echo $address;
?>