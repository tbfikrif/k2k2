   <?php  
      error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
      include "../../../con_db.php";
      date_default_timezone_set('Asia/Jakarta');
      $today1 = date("Y-m-d");
      $query = "SELECT a.id AS id_absen,a.id_anggota AS id_anggota,a.jam_masuk AS jam_masuk,a.jam_keluar AS jam_keluar,b.nama AS nama,c.status AS status,b.foto_profile AS foto FROM tb_detail_absen a JOIN tb_anggota b ON a.id_anggota=b.id_anggota JOIN tb_absen c ON a.status_id = c.status_id WHERE a.tanggal='$today1' ORDER BY a.jam_masuk";  
      $result = mysqli_query($koneksi, $query);
      $jumbaris = mysqli_num_rows($result);
      //echo $jumbaris."<br>";
      if ($jumbaris<4) {
            $jumFotoTampil=$jumbaris;
      } else {
            $jumFotoTampil=4;
      }
      
      $jumBagian = ceil($jumbaris/$jumFotoTampil);
      //echo $jumBagian."<br>";
      $idSlide = "myCarousel";
      $output = '<div id="'.$idSlide.'" class="carousel slide" data-ride="carousel">					  
      <ol class="carousel-indicators">'
      ;
      $inc3 = 0;
      /*
      while($inc3<$jumBagian){
            if ($inc3===0) {              
                  $output.='<li data-target="#'.$idSlide.'" data-slide-to="'.$inc3.'" class="active"></li>
                  ';
            } else {
                  $output.='<li data-target="#'.$idSlide.'" data-slide-to="'.$inc3.'"></li>
                  ';
            }
            $inc3++;
      }
      */
      $output.='
      </ol><div class="carousel-inner">';
      $inc = 1;
      while($inc<=$jumBagian){
            //echo $inc."<br>";
            //echo $jumBagian."<br>";
            if ($inc==1) {
                  $output .=  '<div class="item active">';
            } else {
                  $output .=  '<div class="item">';
            }
            
            
            $output .='<ul class="users-list clearfix">';
            $inc2 = 1;
            while($inc2 <=$jumFotoTampil){
                  //echo $inc2."<br>";
                  $row = mysqli_fetch_assoc($result);
                  $fotomuka = $row["foto"];
                  if ($fotomuka=='-') {
                        $fotomuka="no-profile.jpg";
                  }
                  $statusFoto = $row["status"];
                  $warnaLabel;
                  switch ($statusFoto) {
                        case 'Hadir':
                              $warnaLabel = 'label-info';
                        break;
                        case 'Tugas Kantor':
                              $warnaLabel = 'label-primary';
                        break;
                        case 'Sakit':
                              $warnaLabel = 'label-danger';
                        break;
                        case 'Izin':
                              $warnaLabel = 'label-warning';
                        break;
                        case 'Cuti':
                              $warnaLabel = 'label-success';
                        break;
                        case 'Alpha':
                              $warnaLabel = 'label-default';
                        break;
                        case 'Kerja Remote':
                              $warnaLabel = 'label-default';
                        break;
                  }
                  if ($statusFoto=="Hadir" || $statusFoto=="Tugas Kantor" || $statusFoto=="Kerja Remote") {
                        if (strtotime($row['jam_masuk']) >= strtotime('10:00:00')) {
                              $output.='
                              <li>
                                    <a id="'.$row["id_anggota"].'" class="users-list-name btn view_data_anggota">'.$row["nama"].'</a>
                                    <img style="
                                          width:256px;
                                          margin: 10px;
                                          border:3px solid orange;
                                          border-radius: 500px;
                                          -webkit-border-radius: 500px;
                                          -moz-border-radius: 500px" class="user-image img img-responsive" src="dist/fotoprofile/'.$fotomuka.'" alt="User Image">
                                    <a id="'.$row["id_absen"].'" class="label '.$warnaLabel.' users-list-date detail_kehadiran">'.$statusFoto.'</a>
                              ';
                        } else {
                              $output.='
                              <li>
                                    <a id="'.$row["id_anggota"].'" class="users-list-name btn  view_data_anggota">'.$row["nama"].'</a>
                                    <img style="
                                          width:256px;
                                          margin: 10px;
                                          border:3px solid aqua;
                                          border-radius: 500px;
                                          -webkit-border-radius: 500px;
                                          -moz-border-radius: 500px" class="user-image img img-responsive" src="dist/fotoprofile/'.$fotomuka.'" alt="User Image">
                                    <a id="'.$row["id_absen"].'" class="label '.$warnaLabel.' users-list-date detail_kehadiran">'.$statusFoto.'</a>
                              ';
                        }
                  } else {
                        $output.='
                        <li>
                              <a id="'.$row["id_anggota"].'" class="users-list-name btn  view_data_anggota">'.$row["nama"].'</a>
                              <img style="
                                    width:256px;
                                    margin: 10px;
                                    border:3px solid red;
                                    border-radius: 500px;
                                    -webkit-border-radius: 500px;
                                    -moz-border-radius: 500px" class="user-image img img-responsive" src="dist/fotoprofile/'.$fotomuka.'" alt="User Image">
                              <a id="'.$row["id_absen"].'" class="label '.$warnaLabel.' users-list-date detail_kehadiran">'.$statusFoto.'</a>
                        ';
                  }
                  if ($row['jam_keluar']!==null) {
                        $output.='<a id="'.$row["id_anggota"].'" class="users-list-name">'.$row["jam_masuk"].' - '.$row["jam_keluar"].'</a>
                        </li>';
                  } else {
                        $output.='<a id="'.$row["id_anggota"].'" class="users-list-name">'.$row["jam_masuk"].'</a>
                        </li>';
                  }
                  
                  $inc2++; 
            }
            $output .='</ul></div>';
            if ($inc==($jumBagian-1)) {
                  $modSisaFoto = $jumbaris % $jumFotoTampil;
                  if ($modSisaFoto!=0) {
                        $jumFotoTampil= $jumbaris % $jumFotoTampil;
                  } 
            }
            $inc++;
      }
      $output .='
      </div>
            <a class="left carousel-control" href="#'.$idSlide.'" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                  <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#'.$idSlide.'" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"></span>
                  <span class="sr-only">Next</span>
            </a>
      </div>';
      echo $output;   
 ?>