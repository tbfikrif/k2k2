<?php
/**
 * simple method to encrypt or decrypt a plain text string
 * initialization vector(IV) has to be the same when encrypting and decrypting
 * 
 * @param string $action: can be 'encrypt' or 'decrypt'
 * @param string $string: string to encrypt or decrypt
 *
 * @return string
 */
 /*
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = '"#k@KaTu_1nT3rNEt_$3H@t"';
    $secret_iv = '"#k1N3sH_kR3at1F_iDe@tA"';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
$plain_txt = "1";
echo "Plain Text =" .$plain_txt."<br>";
$encrypted_txt = encrypt_decrypt('encrypt', $plain_txt);
echo "Encrypted Text = ".$encrypted_txt."<br>";
$decrypted_txt = encrypt_decrypt('decrypt', $encrypted_txt);
echo "Decrypted Text =".$decrypted_txt."<br>";
*/
include "fungsi_kakatu.php"; 
$tes = "kakatu";
echo $tes."<br>";
$enkripsi=encodeData($tes);
echo "Enkripsi: ".$enkripsi."<br>";
$dekripsi = decodeData("UXJ4YlVMNm53NXRXckVocCtGSm5idz09");
echo "Dekripsi: ".$dekripsi."<br>";
session_start();
$isAdmin = strpos($_SESSION['jabatan'], 'Admin')!==false;
echo "<br>";
echo "Nilai : ".$isAdmin;
echo "<br>";
$ukuran = intval(getLastConfig("batas_ukuran_upload"));
var_dump($ukuran);
?>