<?php  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "../../../con_db.php";
        // getting total number records without any search
        $sql = "SELECT * FROM tb_tgllibur";
        $res=mysqli_query($koneksi, $sql);
        $output = '<table class="table" id="data_libur">
        <thead>
           <tr>  
                  <th> ID</th>
                  <th> Nama Libur </th>  
                  <th> Dari </th>
                  <th> Sampai </th>	
                  <th> Action </th>									 
           </tr>
        </thead>
        <tbody>';
        while( $row=mysqli_fetch_array($res) ) {  // preparing an array
            $output.='<tr><td>'.$row["id"].'</td>
            <td>'.$row["nama_libur"].'</td>
            <td>'. $row["tglawal"].'</td>
            <td>'.$row["tglakhir"].'</td>
            <td><a id="'.$row["id"].'" class="btn btn-danger btn-xs delete_libur">HAPUS</a><a id="'.$row["id"].'" class="btn btn-warning btn-xs edit_libur">EDIT</a></td></tr>';
        }
        $output.='</tr>
                </tbody>
            </table>';
        echo  $output;
 ?>