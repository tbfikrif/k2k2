   <?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $output = '';
    //include "../../../con_db.php";
    //include "../../../fungsi_kakatu.php";
    $query = "SELECT * FROM tb_detail_absen WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        echo "Error: %s\n", mysqli_error($koneksi);
        exit();
    } else {
        $output .= '
            <div class="table-responsive">
                <table class="table table-bordered" style="position:relative">';
        while ($row = mysqli_fetch_array($result)) {
            $status = $row['status_id'];
            $alamat = getAddress($row["latitude"], $row["longitude"]);
            $alamat = $alamat ? $alamat : 'Tidak Ketemu';
            $output .= '
                    <tr style="display:none">
                        <td width="30%"><label>Lattitude </label></td>
                        <td id="latDetailAbsen" width="70%">' . $row["latitude"] . '</td>
                    </tr>
                    <tr style="display:none">
                        <td width="30%"><label>Longitude </label></td>
                        <td id="lngDetailAbsen" width="70%">' . $row["longitude"] . '</td>
                    </tr>
                    ';
            if ($status == 3) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                            <td width="30%"><label> Alasan </label></td>
                            <td width="70%" style="white-space:normal">' . $row["keterangan"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Dari </label></td>
                            <td width="70%" style="white-space:normal">' . $row["tgl_awal"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Sampai </label></td>
                            <td width="70%" style="white-space:normal">' . $row["tgl_akhir"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Foto Lokasi </label></td>
                            <td width="70%" style="white-space:normal"><img alt="Tidak Ada Foto" src="dist/fotolokasi/' . $row["foto_lokasi"] . '" class="compress thumbnail img-responsive pop" style="height: 100px;width:100px;object-fit:cover;"></td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
            } else if ($status == 4) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                            <td width="30%"><label> Alasan </label></td>
                            <td width="70%" style="white-space:normal">' . $row["keterangan"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Dari </label></td>
                            <td width="70%" style="white-space:normal">' . $row["tgl_awal"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Sampai </label></td>
                            <td width="70%" style="white-space:normal">' . $row["tgl_akhir"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Foto Lokasi </label></td>
                            <td width="70%" style="white-space:normal"><img alt="Tidak Ada Foto" src="dist/fotolokasi/' . $row["foto_lokasi"] . '" class="compress thumbnail img-responsive pop" style="height: 100px;width:100px;object-fit:cover;"></td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
            } else if ($status == 2) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                            <td width="30%"><label> Keterangan </label></td>
                            <td width="70%" style="white-space:normal">' . $row["keterangan"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Foto Lokasi </label></td>
                            <td width="70%" style="white-space:normal"><img alt="Tidak Ada Foto" src="dist/fotolokasi/' . $row["foto_lokasi"] . '" class="compress thumbnail img-responsive pop" style="height: 100px;width:100px;object-fit:cover;"></td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
                $ket = "<span class=\"label label-primary\">HADIR</span>";
            } else if ($status == 1) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
            } else if ($status == 5) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                                <td width="30%"><label> Keterangan </label></td>
                                <td width="70%" style="white-space:normal">' . $row["keterangan"] . '</td>
                        </tr>
                        <tr>
                                <td width="30%"><label> Dari </label></td>
                                <td width="70%" style="white-space:normal">' . $row["tgl_awal"] . '</td>
                        </tr>
                        <tr>
                                <td width="30%"><label> Sampai </label></td>
                                <td width="70%" style="white-space:normal">' . $row["tgl_akhir"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Foto Lokasi </label></td>
                            <td width="70%" style="white-space:normal"><img alt="Tidak Ada Foto" src="dist/fotolokasi/' . $row["foto_lokasi"] . '" class="compress thumbnail img-responsive pop" style="height: 100px;width:100px;object-fit:cover;"></td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
            } else if ($status == 6) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                            <tr>
                                    <td width="30%"><label> Keterangan </label></td>
                                    <td width="70%" style="white-space:normal">Tanpa Keterangan</td>
                            </tr>
                        ';
            } else if ($status == 7) {
                if ($row['foto_lokasi'] == null) {
                    $row['foto_lokasi'] = 'no-photo.png';
                }
                $output .= '
                        <tr>
                            <td width="30%"><label> Keterangan </label></td>
                            <td width="70%" style="white-space:normal">' . $row["keterangan"] . '</td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Foto Lokasi </label></td>
                            <td width="70%" style="white-space:normal"><img alt="Tidak Ada Foto" src="dist/fotolokasi/' . $row["foto_lokasi"] . '" class="compress thumbnail img-responsive pop" style="height: 100px;width:100px;object-fit:cover;"></td>
                        </tr>
                        <tr>
                            <td width="30%"><label> Alamat Lokasi </label></td>
                            <td width="70%" style="white-space:normal">' . $alamat . '</td>
                        </tr>
                        <tr>
                            <td colspan="2" width="70%" tyle="position:relative;"><div id="peta" style="height:300px;
                            overflow: hidden;
                            padding-bottom: 22.25%;
                            padding-top: 30px;
                            position: relative;"></div></td>
                        </tr>
                        ';
                $ket = "<span class=\"label label-primary\">HADIR</span>";
            }
        }
        //$row2 = mysqli_fetch_array($result);

        $output .= '
                </table>
            </div>
            ';
        echo $output;
    }
}
?>