<!doctype html>
<?php
$servername = "10.70.4.37";
$username = "slpauser";
$password = "abc@123!";
$dbname = "berth_info";
$conn="";

//$password = "";

// Create connection
$conn= new mysqli($servername, $username, $password, $dbname);

$sqlNavigationinfo = "SELECT * FROM `tbl_navigationupdateinfo`
INNER JOIN agent ON tbl_navigationupdateinfo.agent_id = agent.id
INNER JOIN vessel_info ON tbl_navigationupdateinfo.vessel_id = vessel_info.id
WHERE `naviup_flag`='0' AND `visibility_i`='Active' AND `vesselstatusinfo_i`='Departed' ORDER BY `navID` ASC ";
$selectNavigationList = mysqli_query($conn, $sqlNavigationinfo);

?>
<html>
    <head>
        <title>Final Data</title>
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
  <h2><u>Final Data</u></h2>
  <div class="row">


            <!-- Table -->
            <font size="2" style=" font-family: Arial, Helvetica, sans-serif;" >
	            <table id="tblrepEquations" style=" font-family: Arial, Helvetica, sans-serif;" class='display dataTable'>
		            <thead style="color: black ; background: #D3D3D3 ;">
		            <tr>
			            <th style=" vertical-align:top; text-align: center;display: none">Berth Date</th>
			            <th style=" vertical-align:top; text-align: center;">Berth Date</th>
			            <th style=" vertical-align:top; text-align: center;">Ref. No</th>
			            <th style=" vertical-align:top; text-align: center;">Vessel Name</th>
			            <th style=" vertical-align:top; text-align: center;">Agent</th>
			            <th style=" vertical-align:top; text-align: center;">Terminal</th>
			            <th style=" vertical-align:top; text-align: center;">Pier</th>
			            <th style=" vertical-align:top; text-align: center;">Berth Occupying delay (Hrs)</th>
			            <!--<th style=" vertical-align:top; text-align: center;">Occupied Vessel to Clear Channel(Hrs)</th>-->
			            <th style=" vertical-align:top; text-align: center;">POB (Arrival)</th>
			            <th style=" vertical-align:top; text-align: center;">Passing Breakwater of Occupied Vessel</th>
			            <th style=" vertical-align:top; text-align: center;">Pilot Boarding Delay(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Manoeuvring Time In(Hrs)</th>
			            <!--<th style=" vertical-align:top; text-align: center;">ATB</th>
			<th style=" vertical-align:top; text-align: center;">FLA</th>-->
			            <th style=" vertical-align:top; text-align: center;">Mooring Time(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Prediction Error In Hours of Completion Time</th>
			            <th style=" vertical-align:top; text-align: center;">Time Taken to call pilot(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Pilot Boarding Delay(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Unmooring Time(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Manoeuvring Time Out(Hrs)</th>
			            <th style=" vertical-align:top; text-align: center;">Pilot IN</th>
			            <th style=" vertical-align:top; text-align: center;">Pilot OUT</th>
		            </tr>
		            </thead>
		            <tbody>
		            <?php
		            if (mysqli_num_rows($selectNavigationList) > 0)
			            while ($rowNavigation = mysqli_fetch_assoc($selectNavigationList)) {

				            // ---- Berth Occupancy Delay ------------------
				            $lastlinecastoff = $rowNavigation['naviup_previousVessLastLineCastOff'];
				            $ATADateTime = $rowNavigation['naviup_ATADate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATATime']));


				            if($lastlinecastoff != NULL && $ATADateTime != NULL || $lastlinecastoff !="0000-00-00 00:00" && $ATADateTime != "0000-00-00 00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $berthOccupyingDelay = abs(strtotime($lastlinecastoff) - strtotime($ATADateTime));
					            $berthOccupyingDelayhours = round($berthOccupyingDelay / (60 * 60), 2);
					            $berthOccupyingDelayDays = round($berthOccupyingDelay/24);
				            }
				            if($lastlinecastoff == "0000-00-00 00:00:00" || $lastlinecastoff == NULL ){
					            $lastlinecastoff = "-";
					            $berthOccupyingDelay = "-";
					            $berthOccupyingDelayhours = "-";
					            $berthOccupyingDelayDays = "-";
				            }if($ATADateTime == "0000-00-00 00:00") {
					            $ATADateTime = "-";
					            $berthOccupyingDelay = "-";
					            $berthOccupyingDelayhours = "-";
					            $berthOccupyingDelayDays = "-";
				            }

				            //-------- Manoeuvring Time(Out) ----------------
				            $lastlinecastoffprevious = $rowNavigation['naviup_previousVessLastLineCastOff'];
				            $naviup_VCCOUT = $rowNavigation['naviup_VCCOUT'];

				            if($lastlinecastoffprevious != NULL && $naviup_VCCOUT != NULL || $lastlinecastoffprevious !="0000-00-00 00:00" && $naviup_VCCOUT != "0000-00-00 00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $ManoeuvringTimeOut = abs(strtotime($lastlinecastoffprevious) - strtotime($naviup_VCCOUT));
					            $ManoeuvringTimeOuthours = round($ManoeuvringTimeOut / (60 * 60), 2);
					            $ManoeuvringTimeOutDays = round($ManoeuvringTimeOut/24);
				            }
				            if($lastlinecastoffprevious == "0000-00-00 00:00:00" || $lastlinecastoffprevious == NULL ){
					            $lastlinecastoffprevious = "-";
					            $ManoeuvringTimeOut = "-";
					            $ManoeuvringTimeOuthours = "-";
					            $ManoeuvringTimeOutDays = "-";
				            }if($naviup_VCCOUT == "0000-00-00 00:00") {
					            $naviup_VCCOUT = "-";
					            $ManoeuvringTimeOut = "-";
					            $ManoeuvringTimeOuthours = "-";
					            $ManoeuvringTimeOutDays = "-";
				            }

				            // ----------  Pilot Boarding Delay ------
				            //$ATADateTime = $rowNavigation['naviup_ATADate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATATime']));

				            $VCCIN = $rowNavigation['naviup_VCCIN'] ;
				            $POBDateTimeArrival = $rowNavigation['PilotONBoardTimeofArrival'] ;
				            $passingBreakwaterofOccupiedVesselprev = $rowNavigation['passingBreakwaterofOccupiedVesselprev'];
				            $passingBreakwaterofOccupiedVesselprevdt =date('Hi/d',strtotime($passingBreakwaterofOccupiedVesselprev));
				            $shiptypedelay = $rowNavigation['shiptypedelay'] ;

				            /*if($passingBreakwaterofOccupiedVesselprev == NULL || $passingBreakwaterofOccupiedVesselprev == "0000-00-00 00:00:00"|| $passingBreakwaterofOccupiedVesselprev == "") {
					            $passingBreakwaterofOccupiedVesselprev = "-";
					            $passingBreakwaterofOccupiedVesselprevdt = "-";
					        }*/

							// ----------------- Berth Free -----------
		                    if($ATADateTime != "0000-00-00 00:00" && $POBDateTimeArrival != "0000-00-00 00:00:00" || $ATADateTime != NULL && $POBDateTimeArrival != NULL){
			                    $ATADateTime = $rowNavigation['naviup_ATADate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATATime']));
			                    $pilotBoardingDelayBF = abs(strtotime($POBDateTimeArrival) - strtotime($ATADateTime));
			                    $pilotBoardingDelayBFhours = round($pilotBoardingDelayBF / (60 * 60), 2);
			                    $pilotBoardingDelayBFhoursnw = (round($pilotBoardingDelayBF / (60 * 60), 2))-0.20;
		                    }

							// -----------------  Berth Not Free -----------
			            //if($VCCIN != "0000-00-00 00:00:00" && $POBDateTimeArrival != "0000-00-00 00:00:00" || $VCCIN != NULL && $POBDateTimeArrival != NULL  ){
				            if($passingBreakwaterofOccupiedVesselprev != "0000-00-00 00:00:00" && $POBDateTimeArrival != "0000-00-00 00:00:00" || $passingBreakwaterofOccupiedVesselprev != NULL && $POBDateTimeArrival != NULL){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            //$pilotBoardingDelay = abs(strtotime($POBDateTimeArrival) - strtotime($VCCIN));
					           /* $diff = $POBDateTimeArrival->diff($passingBreakwaterofOccupiedVesselprev);
					            $pilotBoardingDelayhoursvv = $diff->format('%H:%I:%S');*/


					            $pilotBoardingDelay = abs(strtotime($POBDateTimeArrival) - strtotime($passingBreakwaterofOccupiedVesselprev));
					            $pilotBoardingDelayhours = round($pilotBoardingDelay / (60 * 60), 2);
					            $shiptypedelay = $rowNavigation['shiptypedelay'];
					            $pilotBoardingDelayminutes = round($pilotBoardingDelay / (60 * 60*60), 2);
					           // $pilotBoardingDelayminutesnwo = $pilotBoardingDelayminutes - 20;
					            //$pilotBoardingDelayhoursnw = (round($pilotBoardingDelay / (60 * 60), 2))-0.10;
					           // $pilotBoardingDelayhoursnw = round(($pilotBoardingDelayminutes-20/60),2);
					            $pilotBoardingDelayhoursnw = round((($pilotBoardingDelayhours*60-20)/60),2);
					            //$pilotBoardingDelayhoursnw = (round($pilotBoardingDelayminutes,2)-0.20);

					           // $pilotBoardingDelayhoursnw = (round($pilotBoardingDelay / (60 * 60), 2))-0.20;

					           // $pilotBoardingDelayhoursnw = (round($pilotBoardingDelayminutes / 60, 2));
					            //$pilotBoardingDelayhoursnw = (round($pilotBoardingDelay / (60 * 60), 2))-$shiptypedelay;
					            $pilotBoardingDelayDays = round($pilotBoardingDelayhours/24);
				            }
				            if($POBDateTimeArrival == NULL || $POBDateTimeArrival == "0000-00-00 00:00:00") {
					            $POBDateTimeArrival = "-";
					            $pilotBoardingDelay = "-";
					            $pilotBoardingDelayhours = "-";
					            $pilotBoardingDelayhoursnw = "-";
					            $pilotBoardingDelayDays = "-";
					            $pilotBoardingDelayBFhours = "-";
				            }
				            if($passingBreakwaterofOccupiedVesselprev == NULL || $passingBreakwaterofOccupiedVesselprev == "0000-00-00 00:00:00"|| $passingBreakwaterofOccupiedVesselprev == "") {
					            $passingBreakwaterofOccupiedVesselprev = "-";
					            $passingBreakwaterofOccupiedVesselprevdt = "-";
					            $pilotBoardingDelay = "-";
					            $pilotBoardingDelayhours = "-";
					            $pilotBoardingDelayDays = "-";
					            $pilotBoardingDelayhoursnw = "-";
				            }
		                    if($ATADateTime == "0000-00-00 00:00") {
			                    $ATADateTime = "-";
			                    $pilotBoardingDelay = "-";
			                    $pilotBoardingDelayhours = "-";
			                    $pilotBoardingDelayhoursnw = "-";
			                    $pilotBoardingDelayDays = "-";
			                    $pilotBoardingDelayBFhours = "-";
		                    }
				            /*if($VCCIN == NULL || $VCCIN == "0000-00-00 00:00:00") {
					            $VCCIN = "-";
					            $pilotBoardingDelay = "-";
					            $pilotBoardingDelayhours = "-";
					            $pilotBoardingDelayDays = "-";
				            }*/

				            // --------------- Manoeuvring Time (In) -------------
				            $FLADateTime = $rowNavigation['FirstAshore_Arrival'];
				            $POBDateTimeArrival = $rowNavigation['PilotONBoardTimeofArrival'] ;
				            //$POBDateTimeArrivaldt = date('d/M/Y H:i:s',strtotime($POBDateTimeArrival));
				            $POBDateTimeArrivaldt = date('Hi/d',strtotime($POBDateTimeArrival));

				            if($FLADateTime != NULL && $POBDateTimeArrival != NULL || $FLADateTime !="0000-00-00 00:00:00" && $POBDateTimeArrival != "0000-00-00 00:00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $manoeuvringInTime = abs(strtotime($FLADateTime) - strtotime($POBDateTimeArrival));
					            $manoeuvringInTimehours = round($manoeuvringInTime / (60 * 60), 2);
					            $manoeuvringInTimeDays = round($manoeuvringInTime/24);
				            }
				            if($FLADateTime == "0000-00-00 00:00:00" || $FLADateTime == NULL ){
					            $FLADateTime = "-";
					            $manoeuvringInTime = "-";
					            $manoeuvringInTimehours = "-";
					            $manoeuvringInTimeDays = "-";
				            }if($POBDateTimeArrival == "0000-00-00 00:00:00" || $POBDateTimeArrival == NULL ) {
					            $POBDateTimeArrival = "-";
					            $manoeuvringInTime = "-";
					            $manoeuvringInTimehours = "-";
					            $manoeuvringInTimeDays = "-";
				            }

				            // ----------- Mooring Time -----------------------
				            $ATBDateTime = $rowNavigation['naviup_ATBDate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATBTime']));
				            $FLADateTime = $rowNavigation['FirstAshore_Arrival'];

				            if($ATBDateTime != "0000-00-00 00:00" && $FLADateTime != NULL ){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $mooringTime = abs(strtotime($ATBDateTime) - strtotime($FLADateTime));
					            $mooringTimehours = round($mooringTime / (60 * 60), 2);
					            $mooringTimeDays = round($mooringTime/24);
					            //	echo $ATBDateTime;
					            //	echo $FLADateTime;
				            }
				            if($ATBDateTime == "0000-00-00 00:00") {
					            $ATBDateTime = "-";
					            $mooringTime = "-";
					            $mooringTimehours = "-";
					            $mooringTimeDays = "-";
				            }if($FLADateTime == "0000-00-00 00:00:00" || $FLADateTime == NULL ) {
					            $FLADateTime = "-";
					            $mooringTime = "-";
					            $mooringTimehours = "-";
					            $mooringTimeDays = "-";
				            }

				            // ----------- Prediction Error In Hours -----------------
				            $ATCDateTime =  $rowNavigation['naviup_ATCDate']." ".date( "H:i", strtotime($rowNavigation['naviup_ATCTime']));
				            $ETCDateTime =  $rowNavigation['naviup_ETCDate']." ".date( "H:i", strtotime($rowNavigation['naviup_ETCTime']));

				            if($ATCDateTime != "0000-00-00 00:00"  && $ETCDateTime != "0000-00-00 00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $predictionError = abs(strtotime($ATCDateTime) - strtotime($ETCDateTime));
					            $predictionErrorhours = round($predictionError / (60 * 60), 2);
					            $predictionErrorDays = round($predictionError/24);
				            }
				            if($ATCDateTime == "0000-00-00 00:00"){
					            $ATCDateTime = "-";
					            $predictionError = "-";
					            $predictionErrorhours = "-";
					            $predictionErrorDays = "-";
				            }if($ETCDateTime == "0000-00-00 00:00") {
					            $ETCDateTime = "-";
					            $predictionError = "-";
					            $predictionErrorhours = "-";
					            $predictionErrorDays = "-";
				            }
				            /*$fieldname1[] = $rowNavigation["vesselupd_vesselrefno"];
				$vesselrefno= $rowNavigation["vesselupd_vesselrefno"];

				$sqlGetFirstETC = "SELECT ETC_Date,ETC_Time FROM tbl_vesselupdateinfo WHERE vesselupd_vesselrefno ='".$vesselrefno."' AND vesselupd_update ='ETC' ORDER BY vesselupd_ID ASC";
				//   echo $sqlGetFirstETC;
				$resultGetFirstETC = mysqli_query($conn, $sqlGetFirstETC);

				if (mysqli_num_rows($resultGetFirstETC) > 0){
					// output data of each row
					while($rowFirstETC = mysqli_fetch_assoc($resultGetFirstETC)) {
						$fieldETCDate[] = $rowFirstETC["ETC_Date"];
						$fieldETCTime[] = $rowFirstETC["ETC_Time"];

					}
				}

				if($fieldETCDate[0]!= null || $fieldETCTime[0] != null){
					$firstHrDate = $fieldETCDate[0];
					$firstHrTime = date( "H:i", strtotime($fieldETCTime[0]));
				}else{
					$firstHrDate = "";
					$firstHrTime = "";
				}

				$ATCDateTime =  $rowNavigation['naviup_ATCDate']." ".date( "H:i", strtotime($rowNavigation['naviup_ATCTime']));

				$ETCDateTimeFirst =  $firstHrDate." ".$firstHrTime;

				$differentOf_ATCETC  = abs( strtotime($ATCDateTime) - strtotime($ETCDateTimeFirst));
				$ATCETC_PeriodOccupiedhours = round($differentOf_ATCETC / (60 * 60), 2);

				if ($ATCDateTime == "0000-00-00 00:00"){
					$ATCDateTime = "-";
					$ATCETC_PeriodOccupiedhours = "-";
				}if($ETCDateTimeFirst == "0000-00-00 00:00") {
					$ATCETC_PeriodOccupiedhours = "-";
				}*/

				            // ---- Time Taken to call pilot(Hrs) -----------------
				            $naviup_VCPOUT = $rowNavigation['naviup_VCPOUT'];
				            $ATCDateTime =  $rowNavigation['naviup_ATCDate']." ".date( "H:i", strtotime($rowNavigation['naviup_ATCTime']));

				            if($naviup_VCPOUT != NULL && $ATCDateTime != "0000-00-00 00:00" || $naviup_VCPOUT !="0000-00-00 00:00:00" && $ATCDateTime != "0000-00-00 00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $timeTakentoCallPilot = abs(strtotime($naviup_VCPOUT) - strtotime($ATCDateTime));
					            $timeTakentoCallPilothours = round($timeTakentoCallPilot / (60 * 60), 2);
					            $timeTakentoCallPilotDays = round($timeTakentoCallPilot/24);
				            }
				            if($naviup_VCPOUT == "0000-00-00 00:00:00" || $naviup_VCPOUT == NULL ){
					            $naviup_VCPOUT = "-";
					            $timeTakentoCallPilot = "-";
					            $timeTakentoCallPilothours = "-";
					            $timeTakentoCallPilotDays = "-";
				            }if($ATCDateTime == "0000-00-00 00:00" ) {
					            $ATCDateTime = "-";
					            $timeTakentoCallPilot = "-";
					            $timeTakentoCallPilothours = "-";
					            $timeTakentoCallPilotDays = "-";
				            }

				            // ---- Pilot Boarding Delay(Departure)-Hrs -----------------
				            $POBDateTimeDeparture = $rowNavigation['naviup_PilotONBoardTime'];
				            $naviup_VCPOUT = $rowNavigation['naviup_VCPOUT'];

				            if($naviup_VCPOUT != NULL && $POBDateTimeDeparture != NULL || $naviup_VCPOUT !="0000-00-00 00:00:00" && $POBDateTimeDeparture != "0000-00-00 00:00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $pilotBoardingDelayDeparture = abs(strtotime($POBDateTimeDeparture) - strtotime($naviup_VCPOUT));
					            $pilotBoardingDelayDeparturehours = round($pilotBoardingDelayDeparture / (60 * 60), 2);
					            $pilotBoardingDelayDepartureDays = round($pilotBoardingDelayDeparture/24);
				            }
				            if($naviup_VCPOUT == "0000-00-00 00:00:00" || $naviup_VCPOUT == NULL ) {
					            $naviup_VCPOUT = "-";
					            $pilotBoardingDelayDeparture = "-";
					            $pilotBoardingDelayDeparturehours = "-";
					            $pilotBoardingDelayDepartureDays = "-";
				            }if($POBDateTimeDeparture == "0000-00-00 00:00:00" || $POBDateTimeDeparture == NULL ){
					            $POBDateTimeDeparture = "-";
					            $pilotBoardingDelayDeparture = "-";
					            $pilotBoardingDelayDeparturehours = "-";
					            $pilotBoardingDelayDepartureDays = "-";
				            }

				            // ------- Unmooring Time --------------------
				            $lastlinecastoff = $rowNavigation['naviup_lastlinecastoff'];
				            $POBDateTimeDeparture = $rowNavigation['naviup_PilotONBoardTime'];


				            if($lastlinecastoff != NULL && $POBDateTimeDeparture != NULL || $lastlinecastoff !="0000-00-00 00:00:00" && $POBDateTimeDeparture != "0000-00-00 00:00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $unmooringTime = abs(strtotime($lastlinecastoff) - strtotime($POBDateTimeDeparture));
					            $unmooringTimehours = round($unmooringTime / (60 * 60), 2);
					            $unmooringTimeDays = round($unmooringTime/24);
				            }
				            if($lastlinecastoff == "0000-00-00 00:00:00" || $lastlinecastoff == NULL ){
					            $lastlinecastoff = "-";
					            $unmooringTime = "-";
					            $unmooringTimehours = "-";
					            $unmooringTimeDays = "-";
				            }if($POBDateTimeDeparture == "0000-00-00 00:00:00" || $POBDateTimeDeparture == NULL) {
					            $POBDateTimeDeparture = "-";
					            $unmooringTime = "-";
					            $unmooringTimehours = "-";
					            $unmooringTimeDays = "-";
				            }

				            // ---- Manoeuvring Time(Out) ----------------------------
				            /*$lastlinecastoff = $rowNavigation['naviup_lastlinecastoff'];
				$ATADateTime = $rowNavigation['naviup_ATADate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATATime']));

				if($lastlinecastoff != NULL && $ATADateTime != NULL || $lastlinecastoff !="0000-00-00 00:00" && $ATADateTime != "0000-00-00 00:00"){
					//	echo $rowNavigation['vessel_Ref_No'] ;
					$manoeuvringTimeOut = abs(strtotime($lastlinecastoff) - strtotime($ATADateTime));
					$manoeuvringTimeOuthours = round($manoeuvringTimeOut / (60 * 60), 2);
					$manoeuvringTimeOutDays = round($manoeuvringTimeOut/24);
				}
				if($lastlinecastoff == "0000-00-00 00:00:00" || $lastlinecastoff == NULL ){
					$lastlinecastoff = "-";
					$manoeuvringTimeOut = "-";
					$manoeuvringTimeOuthours = "-";
					$manoeuvringTimeOutDays = "-";
				}if($ATADateTime == "0000-00-00 00:00") {
					$ATADateTime = "-";
					$manoeuvringTimeOut = "-";
					$manoeuvringTimeOuthours = "-";
					$manoeuvringTimeOutDays = "-";
				}*/

				            // ---- Manoeuvring Time(Out) ----------------------------
				            $lastlinecastoff = $rowNavigation['naviup_lastlinecastoff'];
				            $naviup_PilotOFFTime = $rowNavigation['naviup_PilotOFFTime'];
				            //$ATADateTime = $rowNavigation['naviup_ATADate'] . " " . date("H:i", strtotime($rowNavigation['naviup_ATATime']));

				            if($lastlinecastoff != NULL && $naviup_PilotOFFTime != NULL || $lastlinecastoff !="0000-00-00 00:00:00" && $naviup_PilotOFFTime != "0000-00-00 00:00:00"){
					            //	echo $rowNavigation['vessel_Ref_No'] ;
					            $manoeuvringTimeOutDeparture = abs(strtotime($naviup_PilotOFFTime) - strtotime($lastlinecastoff));
					            $manoeuvringTimeOutDeparturehours = round($manoeuvringTimeOutDeparture / (60 * 60), 2);
					            $manoeuvringTimeOutDepartureDays = round($manoeuvringTimeOutDeparture/24);
				            }
				            if($lastlinecastoff == "0000-00-00 00:00:00" || $lastlinecastoff == NULL ){
					            $lastlinecastoff = "-";
					            $manoeuvringTimeOutDeparture = "-";
					            $manoeuvringTimeOutDeparturehours = "-";
					            $manoeuvringTimeOutDepartureDays = "-";
				            }if($naviup_PilotOFFTime == "0000-00-00 00:00:00" || $naviup_PilotOFFTime == NULL ){
					            $naviup_PilotOFFTime = "-";
					            $manoeuvringTimeOutDeparture = "-";
					            $manoeuvringTimeOutDeparturehours = "-";
					            $manoeuvringTimeOutDepartureDays = "-";
				            }
				            $ATBDate = $rowNavigation['naviup_ATBDate'];
				            /*$ATBDateformat = date('d-m-Y',strtotime($ATBDate));*/
				            $ATBDateformat = date('m-d',strtotime($ATBDate));
				            ?>
				            <tr>
					            <td style="display: none"><center><?php echo $ATBDate; ?></center></td>
					            <td><center><?php echo $ATBDateformat; ?></center></td>
					            <td><center><?php echo $rowNavigation['vessel_Ref_No'] ?></center></td>
					            <td><center><?php echo $rowNavigation['vname']; ?></center></td>
					            <td><center><?php echo $rowNavigation['A_Code'] ?><?php /*echo $rowNavigation['agentname'] */?></center></td>
					            <td><center><?php echo $rowNavigation['terminal_i'] ?></center></td>
					            <td><center><?php echo $rowNavigation['pier_i'] ?></center></td>
					            <td><center><?php echo $berthOccupyingDelayhours;?></center></td>
					            <td><center><?php /*echo $POBDateTimeArrival;*/?><?php echo $POBDateTimeArrivaldt;?></center></td>
					            <td><center><?php /*echo $ManoeuvringTimeOuthours;*/?><?php /*echo $passingBreakwaterofOccupiedVesselprev;*/?><?php echo $passingBreakwaterofOccupiedVesselprevdt;?></center></td>
					            <td><center><?php echo $pilotBoardingDelayhoursnw;?><!--/--><?php /*echo $pilotBoardingDelayminutesnw;*/?></center></td>
					            <td><center><?php echo $manoeuvringInTimehours;?></center></td>
					            <!--<td><?php /*echo $ATBDateTime;*/?></td>
														<td><?php /*echo $FLADateTime;*/?></td>-->
					            <td><center><?php echo $mooringTimehours;?></center></td>
					            <td><center><?php echo $predictionErrorhours;?></center></td>
					            <td><center><?php echo $timeTakentoCallPilothours;?></center></td>
					            <td><center><?php echo $pilotBoardingDelayDeparturehours;?></center></td>
					            <td><center><?php echo $unmooringTimehours;?></center></td>
					            <td><center><?php echo $manoeuvringTimeOutDeparturehours;?></center></td>
					            <td><center><?php echo $rowNavigation['naviup_pilotberthed'] ?></center></td>
					            <td><center><?php echo $rowNavigation['naviup_pilotdeparted'] ?></center></td>
					            <!--<td><?php /*echo $manoeuvringTimeOuthours;*/?></td>-->
				            </tr>
			            <?php
			            }?>
		            </tbody>
	            </table>
	            <h5 style="color: #ff0000;"><b>Note: </b></h5>
	            <h5 style="color: #373957;"><b>
			            * POB - Pilot On Board<br/>
			            * ATA - Actual Time of Arrival<br/>
		            </b></h5>
</font>

</div>

</div>


</body>

</html>

<script type="text/javascript">

	$('#tblrepEquations').DataTable({
		dom: 'Bfrtip',
		"order": [[0, "desc" ]],
		/*buttons: [
		 'copy', 'csv', 'excel', 'pdf', 'print'
		 ],*/
		"buttons": [{'extend': 'copy', 'text': 'copy', 'filename': 'reportEquation', 'title': 'report Equation'},
			{'extend': 'csv', 'text': 'csv', 'filename': 'reportEquation', 'title': 'report Equation'},
			{'extend': 'excel', 'text': 'excel', 'filename': 'reportEquation', 'title': 'report Equation'},
			{'extend': 'pdf', 'text': 'pdf', 'filename': 'reportEquation', 'title': 'report Equation'},
			{'extend': 'print', 'text': 'print', 'filename': 'reportEquation', 'title': 'report Equation'}],
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false
	});


</script>

<script>
	/*window.onload = function() {
		setTimeout(function () {
			location.reload()
		}, 25000);
	};*/
</script>