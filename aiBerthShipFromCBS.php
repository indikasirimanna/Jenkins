<?php

 

define('HOST','10.70.4.37');
define('USER','slpauser');
define('PASS','abc@123!');
define('DB','berth_info');


$con = mysqli_connect(HOST,USER,PASS,DB);

$CBS = $_GET['CBS'];

//$sql = "SELECT name,role,telephone,vBirthCode,mobile,email,section,img_url FROM  site_management_info ORDER BY order_number ASC ";
//$sql = "SELECT * FROM  site_management_info ORDER BY order_number ASC ";
$sql = "SELECT tbl_navigationinfo_has_operators.tbl_navigationinfo_id, tbl_navigationinfo_has_operators.commodity, tbl_navigationinfo_has_operators.ir_nir, tbl_navigationinfo_has_operators.weight, tbl_navigationinfo_has_operators.quantity, tbl_navigationinfo_has_operators.cbm, tbl_navigationinfo_has_operators.agent_id FROM tbl_navigationinfo_has_operators, tbl_navigationupdateinfo WHERE tbl_navigationinfo_has_operators.tbl_navigationinfo_id = tbl_navigationupdateinfo.navID AND tbl_navigationupdateinfo.vessel_Ref_No='$CBS'";


$res = mysqli_query($con,$sql);
 
$result = array();

 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('tbl_navigationinfo_id'=>$row[0],
  'commodity'=>$row[1],
'ir_nir'=>$row[2],
'weight'=>$row[3],
'quantity'=>$row[4],
'cbm'=>$row[5],
'agent_id'=>$row[6]




));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>




