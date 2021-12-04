<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'mchristopherraoul1');
define('DB_PASSWORD', 'mchristopherraoul1');
define('DB_NAME', 'mchristopherraoul1');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$ids = array();
$i = 0;
$sql = "SELECT upc FROM product";
$result = mysqli_query($conn, $sql);
$jsondata = file_get_contents('MOCK_DATA.json');
$data = json_decode($jsondata, true);
$arr = array_values($data);
$val = array();
// print_r($arr);
while($row = mysqli_fetch_array($result))
{
    $ids[] = $row['upc'];
}
foreach($arr as $value){
    $val[] = $value['name'];
    // print($value['name'] . ' ' . "\n");
}
// print($ids[1]);
for($j = 0; $j < 70; $j++){
    // updateProductName($id[j], $data[j]['name']);
    $a = $ids[$j];
    $b = $val[$j];
    print($a);
    print($b);
    // print($val[0]);
    // print($val[$j]);
    $sql = "Update product set name = '$b' where upc = $a";
    $result = mysqli_query($conn, $sql);
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
      } else {
        echo "Error updating record: " . $conn->error;
      }
}
mysqli_close($conn);
?>
