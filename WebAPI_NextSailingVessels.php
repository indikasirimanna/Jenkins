
            <?php 
           

            define('HOST','10.70.4.37');
            define('USER','slpauser');
            define('PASS','abc@123!');
            define('DB','berth_info');


            $con = mysqli_connect(HOST,USER,PASS,DB);
 
         //   $query = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate,naviup_ETCTime, terminal_i, pier_i from tbl_navigationupdateinfo , pier, vessel_info WHERE (pier_i = pier AND visibility_i ='Active' AND vesselstatusinfo_i ='Berth' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id )";

                $sql = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate, naviup_ETCTime, naviup_ATCDate, naviup_ATCTime, terminal_i, pier_i,vesselstatusinfo_i,naviup_VlsReadyTime, naviup_PilotONBoardTime ,naviup_lastlinecastoff, naviup_VCPOUT from tbl_navigationupdateinfo , pier, vessel_info WHERE visibility_i ='Active' AND (vesselstatusinfo_i ='AtBerth' OR vesselstatusinfo_i ='At Berth'  OR vesselstatusinfo_i ='Completed' OR vesselstatusinfo_i ='AtBerth(VR)') AND tbl_navigationupdateinfo.vessel_id = vessel_info.id  ORDER BY naviup_ETCTime ASC";



                  $res = mysqli_query($con,$sql);
                   
                  $result = array();
                   
                  while($row = mysqli_fetch_array($res)){
                  array_push($result,
                  array('vessel_Ref_No'=>$row[0],
                  'vname'=>$row[1],
                  'naviup_ETCDate'=>$row[2],
                  'naviup_ETCTime'=>$row[3],
                  'naviup_ATCDate'=>$row[4],
                  'naviup_ATCTime'=>$row[5],
                  'terminal_i'=>$row[6],
                  'pier_i'=>$row[7],
                  'vesselstatusinfo_i'=>$row[8],
                  'naviup_VlsReadyTime'=>$row[9],
                  'naviup_PilotONBoardTime'=>$row[10],
                  'naviup_lastlinecastoff'=>$row[11],
                  'naviup_VCPOUT'=>$row[12]

                  ));
                  }
                   
                  echo json_encode(array("result"=>$result));
                   
                  mysqli_close($con);
                   
                  ?>

                