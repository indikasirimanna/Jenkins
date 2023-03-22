
            <?php 
           

            define('HOST','10.70.4.37');
            define('USER','slpauser');
            define('PASS','abc@123!');
            define('DB','berth_info');


            $con = mysqli_connect(HOST,USER,PASS,DB);
 
         //   $query = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate,naviup_ETCTime, terminal_i, pier_i from tbl_navigationupdateinfo , pier, vessel_info WHERE (pier_i = pier AND visibility_i ='Active' AND vesselstatusinfo_i ='Berth' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id )";

                $sql = "SELECT DISTINCT vessel_Ref_No, vname, ETA_Date,ETA_Time, terminal_i, pier_i,vesselstatusinfo_i,naviup_ATADate ,naviup_ATATime, naviup_ETBDate, naviup_ETBTime ,naviup_PilotONBoardTime,FirstAshore_Arrival from tbl_navigationupdateinfo , pier, vessel_info WHERE visibility_i ='Active' AND (vesselstatusinfo_i ='Arriving' OR vesselstatusinfo_i ='Arrived')  AND tbl_navigationupdateinfo.vessel_id = vessel_info.id  ORDER BY naviup_ETCTime ASC";



                  $res = mysqli_query($con,$sql);
                   
                  $result = array();
                   
                  while($row = mysqli_fetch_array($res)){
                  array_push($result,
                  array('vessel_Ref_No'=>$row[0],
                  'vname'=>$row[1],
                  'ETA_Date'=>$row[2],
                  'ETA_Time'=>$row[3],         
                  'terminal_i'=>$row[4],
                  'pier_i'=>$row[5],
                  'vesselstatusinfo_i'=>$row[6],
                  'naviup_ATADate'=>$row[7],
                  'naviup_ATATime'=>$row[8],
                  'naviup_ETBDate'=>$row[9],
                  'naviup_ETBTime'=>$row[10],
                  'naviup_PilotONBoardTime'=>$row[11],
                  'FirstAshore_Arrival'=>$row[12]

                  ));
                  }
                   
                  echo json_encode(array("result"=>$result));
                   
                  mysqli_close($con);
                   
                  ?>

                