<!doctype html>
<html>
    <head>
        <title>Dashboard SLPA</title>
        <!-- Datatable CSS -->
        <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
        <link href='https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
        <link href='https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'>

        <!-- jQuery Library -->
        <script src="jquery-3.3.1.min.js"></script>
        
        <!-- Datatable JS -->
        <script src="DataTables/datatables.min.js"></script>
        <meta name="description" content="Export with customisable file name" />
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>


    <link href="https://nightly.datatables.net/css/jquery.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://nightly.datatables.net/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.js"></script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    
    <link href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    
    <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script>

    <style type="text/css">
      @keyframes bgcolor {
    0% {
        background-color: #ffffff
    }

    20% {
        background-color: #ededed
    }

    40% {
        background-color: #e3e3e3
    }

    60% {
        background-color: #e3e3e3
    }

    800% {
        background-color: #ededed
    }
    100% {
        background-color: #ffffff
    }
}

body {
    -webkit-animation: bgcolor 10s infinite;
    animation: bgcolor 10s infinite;
    -webkit-animation-direction: alternate;
    animation-direction: alternate;
}
    </style>
        
    </head>
    <body style=" font-family: Arial, Helvetica, sans-serif;" >

        <div class="container-fluid">
  <h2><u>Next Sailing Vessels</u></h2>
  <div class="row">


            <!-- Table -->
            <font size="2" style=" font-family: Arial, Helvetica, sans-serif;" >
            <table id='empTable' class='display dataTable' >
                <thead>
                <tr>

                          
                         <td bgcolor="lightgray"> <font face="Arial"><b>Vessel Ref No</b></font> </td> 
                          <td bgcolor="lightgray"> <font face="Arial"><b>Vessel Name</b></font> </td>
                           <td bgcolor="lightgray"> <font face="Arial"><b>Terminal</b></font> </td>
                           <td bgcolor="lightgray"> <font face="Arial"><b>Berth No</b></font> </td>
                           <td bgcolor="lightgray"> <font face="Arial"><b>Status</b></font> </td>

                           <td bgcolor="lightgray"> <font face="Arial"><b>ETC </b></font> </td> 
                           <td bgcolor="lightgray"> <font face="Arial"><b>ATC </b></font> </td> 
                           <td bgcolor="lightgray"> <font face="Arial"><b>VCP </b></font> </td> 
                          <td bgcolor="lightgray"> <font face="Arial"><b>POB</b></font> </td>
                           <td style="display:none;" bgcolor="lightgray"> <font face="Arial"><b>ETCDate</b></font> </td>
                            <td bgcolor="lightgray"> <font face="Arial"><b>Last Line Cast Off</b></font> </td>
                </tr>
                </thead>

                <?php 
            $username = "slpauser";
            $password = "abc@123!";
            $database = "berth_info";
            $mysqli = new mysqli("10.70.4.37", $username, $password, $database); 
         //   $query = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate,naviup_ETCTime, terminal_i, pier_i from tbl_navigationupdateinfo , pier, vessel_info WHERE (pier_i = pier AND visibility_i ='Active' AND vesselstatusinfo_i ='Berth' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id )";

                $query = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate, naviup_ETCTime, naviup_ATCDate,naviup_ATCTime, terminal_i, pier_i,vesselstatusinfo_i,naviup_VlsReadyTime, naviup_PilotONBoardTime ,naviup_lastlinecastoff, naviup_VCPOUT from tbl_navigationupdateinfo , pier, vessel_info WHERE visibility_i ='Active' AND (vesselstatusinfo_i ='AtBerth' OR vesselstatusinfo_i ='At Berth'  OR vesselstatusinfo_i ='Completed' OR vesselstatusinfo_i ='AtBerth(VR)') AND tbl_navigationupdateinfo.vessel_id = vessel_info.id  ORDER BY naviup_ETCTime ASC";

                $freel =0;
                if ($result = $mysqli->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $field1name = $row["vessel_Ref_No"];
                        $field2name = $row["vname"];
                        $field5name = $row["terminal_i"];
                        $field6name = $row["pier_i"];
                        if($row["vesselstatusinfo_i"]=="AtBerth"){
                        $field7name = "At Berth"; 
                        } elseif($row["vesselstatusinfo_i"]=="AtBerth(VR)"){
                        $field7name = "At Berth(VR)"; 
                        }
                        else{
                          $field7name =$row["vesselstatusinfo_i"];
                        }

                        $field3name = $row["naviup_ETCDate"];
                        $datenewetc = substr($field3name,8);
                        $field4name = $row["naviup_ETCTime"];
                        $newETCTime=substr($field4name,0,-3);

                       

                        if($row["naviup_ATCDate"]!="0000-00-00"){
                        $field9name = $row["naviup_ATCDate"];
                        $dateatc= " /".substr($field9name,8); 
                        $field10name = $row["naviup_ATCTime"];

                        $newATCTime=substr($field10name,0,-3);
                        }else{
                          $dateatc="";
                          $newATCTime="-";
                        }
                        
                      //  $field12name = $row["naviup_VlsReadyTime"];   
                     //   $datenewVCP = substr($field12name,8,-8);
                      //  $newVCPTime=substr($field12name,11,-3);

                        /*if($row["naviup_VlsReadyTime"]!="0000-00-00 00:00:00"){
                        $field12name = $row["naviup_PilotONBoardTime"];
                        $datenewVCP = " /".substr($field12name,8,-8);
                        $newVCPTime=substr($field12name,11,-3);
                        }else{
                          $datenewVCP = "-";
                          $newVCPTime = "";
                        }*/
                        if($row["naviup_VCPOUT"]!="0000-00-00 00:00:00"){
                        $field12name = $row["naviup_VCPOUT"];
                        $datenewVCP = " /".substr($field12name,8,-8);
                        $newVCPTime=substr($field12name,11,-3);
                        }else{
                          $datenewVCP = "-";
                          $newVCPTime = "";
                        }


                        if($row["naviup_PilotONBoardTime"]!=""){
                        $field11name = $row["naviup_PilotONBoardTime"];
                        $datenewpob = " /".substr($field11name,8,-8);
                        $newPOBTime=substr($field11name,11,-3);
                        }else{
                          $datenewpob = "-";
                          $newPOBTime = "";
                        }

                        $field20name = $row["naviup_ETCDate"];


                        if($row["naviup_lastlinecastoff"]!=""){
                        $field11name1 = $row["naviup_lastlinecastoff"];
                        $datenewpob1 = " /".substr($field11name1,8,-8);
                        $newPOBTime1=substr($field11name1,11,-3);
                        }else{
                          $datenewpob1 = "-";
                          $newPOBTime1 = "";
                        }
                     //   $field1010name = $row["naviup_lastlinecastoff"];

                       
                        echo '<tr> 
                                  <td style="padding-right:10px">'.$field1name.'</td> 
                                  <td style="padding-right:10px">'.$field2name.'</td> 
                                  <td style="padding-right:10px">'.$field5name.'</td>';
                                 echo '<td style="padding-right:10px">'.$field6name.'</td>'; 

                                 if($field7name =="Completed"){

                                 echo    ' <td style="padding-right:10px;   color: red; background-color:yellow; "><b>'.$field7name.'</b></td>';
                               } elseif($field7name =="At Berth(VR)"){
                                 echo    ' <td style="padding-right:10px;   color: green; background-color:lightblue; "><b>'.$field7name.'</b></td>';
                               }else{
                                 echo    ' <td style="padding-right:10px;   color: green; background-color:lightyellow; "><b>'.$field7name.'</b></td>';
                               }


                  echo  '<td style="padding-right:10px">'.str_replace(":","",$newETCTime)." /<b>".$datenewetc.'</b></td>                                 

                     <td style="padding-right:10px">'.str_replace(":","",$newATCTime)." <b>".$dateatc.'</b></td>';                          

                     echo    '  <td style="padding-right:10px">'.str_replace(":","",$newVCPTime)."<b>".$datenewVCP.'</b></td>'; 


                     echo    '  <td style="padding-right:10px">'.str_replace(":","",$newPOBTime)."<b>".$datenewpob.'</b></td>';

                     echo     '<td  style="padding-right:10px; display:none;">'.$field20name.'</td>';

                     echo    '  <td style="padding-right:10px">'.str_replace(":","",$newPOBTime1)."<b>".$datenewpob1.'</b></td>';
                   
                         echo    '</tr>';
                    }
                    $result->free();
                } 
                
            ?>

                
            </table>
        </font>
     
  </div>

  <h2><u>Next Arriving Vessel</u></h2>
  <div class="row">
 <!-- Table -->
            <font size="2" style=" font-family: Arial, Helvetica, sans-serif;" >
            <table id='empTable2' class='display dataTable'>
                <thead>
                <tr>

                          <td bgcolor="lightgray"> <font face="Arial"><b>Vessel Ref No</b></font> </td> 
                          <td bgcolor="lightgray"> <font face="Arial"><b>Vessel Name</b></font> </td>
                          <td bgcolor="lightgray"> <font face="Arial"><b>Terminal</b></font> </td>
                          <td bgcolor="lightgray"> <font face="Arial"><b>Berth No</b></font> </td>

                          <td bgcolor="lightgray"> <font face="Arial"><b>Status</b></font> </td>

                           <td bgcolor="lightgray"> <font face="Arial"><b>Remark</b></font> </td>

                          <td bgcolor="lightgray"> <font face="Arial"><b>ETA</b></font> </td>
                        <td bgcolor="lightgray"> <font face="Arial"><b>ATA</b></font> </td>
                          
                         
                           <td style="display:none;" bgcolor="lightgray"> <font face="Arial"><b>ETA Date</b></font> </td>
                            <td style="display:none;" bgcolor="lightgray"> <font face="Arial"><b>ETA Time</b></font> </td>  
                        <td bgcolor="lightgray"> <font face="Arial"><b>ETB</b></font> </td>
                        <td bgcolor="lightgray"> <font face="Arial"><b>POB</b></font> </td>
                        <td bgcolor="lightgray"> <font face="Arial"><b>First Ashore Arrival</b></font> </td>
                </tr>
                </thead>

                <?php 
            $username = "slpauser";
            $password = "abc@123!";
            $database = "berth_info";
            $mysqli = new mysqli("10.70.4.37", $username, $password, $database); 
         //   $query = "SELECT DISTINCT vessel_Ref_No, vname, naviup_ETCDate,naviup_ETCTime, terminal_i, pier_i from tbl_navigationupdateinfo , pier, vessel_info WHERE (pier_i = pier AND visibility_i ='Active' AND vesselstatusinfo_i ='Berth' AND tbl_navigationupdateinfo.vessel_id = vessel_info.id )";

                $query = "SELECT DISTINCT vessel_Ref_No, vname, ETA_Date,ETA_Time, terminal_i, pier_i,vesselstatusinfo_i,naviup_ATADate ,naviup_ATATime, naviup_ETBDate, naviup_ETBTime ,naviup_PilotONBoardTime,FirstAshore_Arrival from tbl_navigationupdateinfo , pier, vessel_info WHERE visibility_i ='Active' AND (vesselstatusinfo_i ='Arriving' OR vesselstatusinfo_i ='Arrived')  AND tbl_navigationupdateinfo.vessel_id = vessel_info.id  ORDER BY naviup_ETCTime ASC";

                $freel =0;
                if ($result = $mysqli->query($query)) {
                    while ($row = $result->fetch_assoc()) {
                        $field1name = $row["vessel_Ref_No"];
                        $field2name = $row["vname"];
                        $field5name = $row["terminal_i"];
                        $field6name = $row["pier_i"];

                        $field50name = $row["vesselstatusinfo_i"];
                      
                     
                        if($row["ETA_Date"]!="0000-00-00"){
                        $field3name = $row["ETA_Date"];
                        $dateeta= " /".substr($field3name,8); 
                        $field4name = $row["ETA_Time"];
                        $newETAime=substr($field4name,0,-3);

                        } else{
                          $dateeta="";
                          $newETAime="-";
                        }
                     

                   
                        
                        if($row["naviup_ATADate"]!="0000-00-00"){
                        $field8name = $row["naviup_ATADate"];
                        $dateata= " /".substr($field8name,8); 
                        $field9name = $row["naviup_ATATime"];
                        $newATAime=substr($field9name,0,-3);
                        }else{
                          $dateata ="";
                          $newATAime ="-";
                        }

                        $field30name = $row["ETA_Date"];
                        $field31name = $row["ETA_Time"];
                        
                       $field100name = $row["ETA_Date"];

                       if(strpos($field100name, "0") == false) {
                        
                        $field100name = $row["ETA_Date"];
                          }
                       else{
                        $field100name ="-";
                        
                       }

                          if($row["naviup_ETBDate"]!="0000-00-00"){
                        $field3nameetb = $row["naviup_ETBDate"];
                        $dateetaetb= " /".substr($field3nameetb,8); 
                        $field4nameetb = $row["naviup_ETBTime"];
                        $newETAimeetb=substr($field4nameetb,0,-3);

                        } else{
                          $dateetaetb="";
                          $newETAimeetb="-";
                        }


                        if($row["naviup_PilotONBoardTime"]!=""){
                        $field11name = $row["naviup_PilotONBoardTime"];
                        $datenewpob = " /".substr($field11name,8,-8);
                        $newPOBTime=substr($field11name,11,-3);
                        }else{
                          $datenewpob = "-";
                          $newPOBTime = "";
                        }

                        if($row["FirstAshore_Arrival"]!=""){
                        $field11name1 = $row["FirstAshore_Arrival"];
                        $datenewpob1 = " /".substr($field11name1,8,-8);
                        $newPOBTime1=substr($field11name1,11,-3);
                        }else{
                          $datenewpob1 = "-";
                          $newPOBTime1 = "";
                        }

                       
                        echo '<tr> 
                                  <td style="padding-right:10px">'.$field1name.'</td> 
                                  <td style="padding-right:10px">'.$field2name.'</td> 
                                  <td style="padding-right:10px">'.$field5name.'</td> 
                                  <td style="padding-right:10px">'.$field6name.'</td>' ;

                        if($row["vesselstatusinfo_i"]=="Arrived"){
                           echo   ' <td style="padding-right:10px; color:blue;background-color:yellow; "><b>'.$field50name.'<b></td>'; 
                        }else{
                           echo   ' <td style="padding-right:10px; color:#9e2fa8;background-color:lightyellow; "><b>'.$field50name.'</b></td>'; 
                        }

                        echo '<td style=" padding-right:10px">'.$field100name.'</td> ';
                         
                               


                           echo       '<td style="padding-right:10px">'.str_replace(":","",$newETAime)." <b>".$dateeta.'</b></td> 
                                     <td style="padding-right:10px">'.str_replace(":","",$newATAime)." <b>".$dateata.'</b></td>'; 

               

               echo '<td style="display:none; padding-right:10px">'.$field30name.'</td> ';
               echo '<td style="display:none; padding-right:10px">'.$field31name.'</td> ';
                 

                 echo       '<td style="padding-right:10px">'.str_replace(":","",$newETAimeetb)." <b>".$dateetaetb.'</b></td>'; 

                  echo    '  <td style="padding-right:10px">'.str_replace(":","",$newPOBTime)."<b>".$datenewpob.'</b></td>';

                  echo    '  <td style="padding-right:10px">'.str_replace(":","",$newPOBTime1)."<b>".$datenewpob1.'</b></td>';

                         echo    '</tr>';
                    }
                    $result->free();
                } 
                
            ?>

                
            </table>
        </font>
  <br>

</div>
</div>


       <footer class="navbar navbar-bottom" >
                <div>
                    <div  class="row" style="background-color: black; opacity: 0.6; ">
                        <img style="width: 100%" src="../footer/bg4.png">
                        <svg width="100%"  >

                        <image id="blue-rectangle10" xlink:href="../footer/jetskey.png" height="5%" width="20%"/>

                        <animate 
                            xlink:href="#blue-rectangle10"
                            attributeName="x" 
                            from="-80%"
                            to="100%" 
                            dur="150s"          
                            repeatCount="indefinite"
                            fill="freeze" 
                            id="rect-anim"/>


                        <image id="blue-rectanglemm" xlink:href="../footer/4.png" height="10%" width="30%"/>
                        <animate
                            xlink:href="#blue-rectanglemm"
                            attributeName="x"
                            from="100%"
                            to="-30%"
                            dur="100s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>

                        <image id="blue-rectangle" xlink:href="../footer/4.png" height="25%" width="45%"/>
                        <animate
                            xlink:href="#blue-rectangle"
                            attributeName="x"
                            from="100%"
                            to="-30%"
                            dur="25s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>

                        <image id="blue-rectangle5" xlink:href="../footer/1.png" height="35%" width="25%"/>
                        <animate
                            xlink:href="#blue-rectangle5"
                            attributeName="x"
                            from="-180%"
                            to="100%"
                            dur="50s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>

                        <image id="blue-rectangle1" xlink:href="../footer/2.png" height="35%" width="55%"/>
                        <animate
                            xlink:href="#blue-rectangle1"
                            attributeName="x"
                            from="120%"
                            to="-50%"
                            dur="45s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>

                        <image id="blue-rectangle4" xlink:href="../footer/55.png" height="30%" width="45%"/>
                        <animate
                            xlink:href="#blue-rectangle4"
                            attributeName="x"
                            from="100%"
                            to="-180%"
                            dur="80s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>

                        <image id="blue-rectangle11" xlink:href="../footer/test.png" height="50%" width="70%"/>


                        <animate 
                            xlink:href="#blue-rectangle11"
                            attributeName="x" 
                            from="100%"
                            to="-150%" 
                            dur="60s"          
                            repeatCount="indefinite"
                            fill="freeze" 
                            id="rect-anim"/>


                        <image id="blue-rectangle3" xlink:href="../footer/moter.png" height="100%" width="120%"/>
                        <animate
                            xlink:href="#blue-rectangle3"
                            attributeName="x"
                            from="-150%"
                            to="100%"
                            dur="60s"
                            repeatCount="indefinite"
                            fill="freeze"
                            id="rect-anim"/>
                        </svg>
                    </div>
                </div>

            </footer>

<script type='text/javascript' src='https://www.freevisitorcounters.com/auth.php?id=84a4c4efc1b40b6e26ff599c2814275059c985e7'></script>
<script type="text/javascript" src="https://www.freevisitorcounters.com/en/home/counter/935461/t/5"></script>
    </body>


</html>
        
    <script type="text/javascript">

    $('#empTable').DataTable({
        dom: 'Bfrtip',

         "order": [[ 4, "desc" ],[ 9, "asc" ]],
        //"order": [[ 6, "asc" ]],
        /*buttons: [
         'copy', 'csv', 'excel', 'pdf', 'print'
         ],*/
        "buttons": [{'extend': 'copy', 'text': 'copy', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'csv', 'text': 'csv', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'excel', 'text': 'excel', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'pdf', 'text': 'pdf', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'print', 'text': 'print', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '}],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });

</script>

    <script type="text/javascript">

    $('#empTable2').DataTable({
        dom: 'Bfrtip',
        "order": [[ 4, "asc" ],[ 8, "asc" ],[ 9, "asc" ]],
        /*buttons: [
         'copy', 'csv', 'excel', 'pdf', 'print'
         ],*/
        "buttons": [{'extend': 'copy', 'text': 'copy', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'csv', 'text': 'csv', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'excel', 'text': 'excel', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'pdf', 'text': 'pdf', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '},
            {'extend': 'print', 'text': 'print', 'filename': 'DepartureVessel', 'title': 'List of Departure Vessel '}],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
    });


</script>

<script>
    window.onload = function() {
        setTimeout(function () {
            location.reload()
        }, 25000);
     };
</script>