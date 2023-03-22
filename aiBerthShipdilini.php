<?php

 

define('HOST','10.70.4.37');
define('USER','slpauser');
define('PASS','abc@123!');
define('DB','berth_info');


$con = mysqli_connect(HOST,USER,PASS,DB);
 

//$sql = "SELECT name,role,telephone,vBirthCode,mobile,email,section,img_url FROM  site_management_info ORDER BY order_number ASC ";
//$sql = "SELECT * FROM  site_management_info ORDER BY order_number ASC ";
//$sql = "SELECT DISTINCT vessel_Ref_No AS CBS, vname, agent_id, A_Code ,agentname from tbl_navigationupdateinfo , pier, vessel_info , agent WHERE visibility_i ='Active' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id AND tbl_navigationupdateinfo.agent_id = agent.id ORDER BY naviup_ETCTime ASC";

//$sql = "SELECT DISTINCT vessel_Ref_No AS CBS, vname, agent_id, A_Code ,agentname from tbl_navigationupdateinfo , pier, vessel_info , agent WHERE 
//tbl_navigationupdateinfo.vessel_id = vessel_info.id AND tbl_navigationupdateinfo.agent_id = agent.id ORDER BY naviup_ETCDate DESC";

$sql = "SELECT DISTINCT 
tbl_navigationupdateinfo.vessel_Ref_No AS CBS, 
vessel_info.vname,
 tbl_navigationupdateinfo.agent_id, 
agent.A_Code ,
agent.agentname , 
tbl_navigationupdateinfo.naviup_ATADate, 
tbl_navigationupdateinfo.naviup_ATATime, 
tbl_navigationupdateinfo.arrivaldate ,
tbl_navigationupdateinfo.last_port, 
tbl_navigationupdateinfo.pier_i


from tbl_navigationupdateinfo , pier, vessel_info , agent , tbl_navigationinfo_has_operators AS tbl_navigationinfo_has_operators, tbl_navigationinfo_extend AS tbl_navigationinfo_extend WHERE 
tbl_navigationupdateinfo.vessel_id = vessel_info.id AND tbl_navigationupdateinfo.agent_id = agent.id
AND tbl_navigationupdateinfo.navID = tbl_navigationinfo_has_operators.tbl_navigationinfo_id
AND tbl_navigationinfo_has_operators.tbl_navigationinfo_id = tbl_navigationinfo_extend.tbl_navigationinfo_id
 ORDER BY vessel_Ref_No DESC LIMIT 6000";


$res = mysqli_query($con,$sql);
 
$result = array();

 
while($row = mysqli_fetch_array($res)){
array_push($result,
array('CBS'=>$row[0],
  'vname'=>$row[1],
'agent_id'=>$row[2],
'A_Code'=>$row[3],
'agentname'=>$row[4],
'naviup_ATADate'=>$row[5],
'naviup_ATATime'=>$row[6],
'arrivaldate'=>$row[7],
'last_port'=>$row[8],
'pier_i'=>$row[9]



));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
 
?>




