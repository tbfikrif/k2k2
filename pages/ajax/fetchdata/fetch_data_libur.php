<?php
//fetch.php
//include "../../../fungsi_kakatu.php";
$connect = createConn();
$columns = array('id', 'nama_libur','tglawal','tglakhir');

$query = "SELECT * FROM tb_tgllibur ";

if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE id = "'.$_POST["search"]["value"].'"
 OR nama_libur LIKE "%'.$_POST["search"]["value"].'%"
 OR tglawal LIKE "%'.$_POST["search"]["value"].'%"
 OR tglakhir LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$number_filter_row = $connect->query($query)->num_rows;

$result = $connect->query($query.$query1);

$data = array();

while($row = $result->fetch_array())
{
 $sub_array = array();
 $sub_array[] = $row["id"];
 $sub_array[] = $row["nama_libur"];
 $sub_array[] = $row["tglawal"];
 $sub_array[] = $row["tglakhir"];
 $sub_array[] = '<button type="button" name="delete" class="btn btn-danger btn-xs delete_libur" id="'.$row["id"].'">Delete</button><button type="button" name="edit" class="btn btn-warning btn-xs edit_libur" id="'.$row["id"].'">Edit</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM tb_tgllibur";
 $result = $connect->query($query);
 return $result->num_rows;
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);

?>