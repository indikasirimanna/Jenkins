<?php

 

define('HOST','10.70.4.37');
define('USER','slpauser');
define('PASS','abc@123!');
define('DB','berth_info');


$con = mysqli_connect(HOST,USER,PASS,DB);
 

//$sql = "SELECT name,role,telephone,vBirthCode,mobile,email,section,img_url FROM  site_management_info ORDER BY order_number ASC ";
//$sql = "SELECT * FROM  site_management_info ORDER BY order_number ASC ";
$sql = "SELECT DISTINCT vessel_Ref_No AS CBS, vname, agent_id, A_Code ,agentname from tbl_navigationupdateinfo , pier, vessel_info , agent WHERE visibility_i ='Active' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id AND tbl_navigationupdateinfo.agent_id = agent.id ORDER BY naviup_ETCTime ASC LIMIT 100";


$res = mysqli_query($con,$sql);
 
$result = array();

 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('CBS'=>$row[0],
  'vname'=>$row[1],
'agent_id'=>$row[2],
'A_Code'=>$row[3],
'agentname'=>$row[4]



));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>




