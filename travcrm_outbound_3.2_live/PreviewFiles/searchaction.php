<?php 
include "inc.php";
if($_REQUEST['action']=="makeDuplicateModule" && $_REQUEST['displayId']!=''){
   $displayId = clean($_REQUEST['displayId']);
   $queryId = clean($_REQUEST['queryId']);

   $displayId = clean($_REQUEST['displayId']);
   $myArray = explode('/',$displayId);
    // echo $myArray['0'];
    // echo $myArray['1'];
    $searchdisplayId = ltrim($myArray['1'],'0');
  
//    $queryId = clean($_REQUEST['queryId']);

//    $myArray = preg_replace('/[^0-9-]/s','',$displayId);
//     $searchdisplayId = trim(ltrim($myArray,'0'));

   $loopN='';
    $where =' deletestatus=0 and queryStatus=3 and displayId = "'.$searchdisplayId.'" order by id desc';
    $res = GetPageRecord('*',_QUERY_MASTER_,$where);
    while($resultlists = mysqli_fetch_assoc($res)){ ?>
    <div class="selectParentList" onclick="MakeDuplicate<?php echo $loopN; ?>('<?php echo $resultlists['id']; ?>');"><?php echo makeQueryId($resultlists['id']); ?></div>
   
<div id="makeDuplicateQuery"></div>
    <script>
        function MakeDuplicate<?php echo $loopN; ?>(main_queryId){
            $("#makeDuplicateQuery").load('makeduplicatequery.php?action=makeDuplicateModule&queryId='+main_queryId+'&updateqId=<?php echo $queryId; ?>');
            $("#selectParentList").hide();
            $("#getQueryDuplicate").hide();
        }
    </script>
    <?php
$loopN++;
    }

}

if($_REQUEST['action']=="selectVisaCost" && $_REQUEST['visaTypeId']!=''){

    $visaNameId = $_REQUEST['visaNameId'];
    $visaTypeId = $_REQUEST['visaTypeId'];
    $rsV1 = GetPageRecord('name','visaCostMaster','id="'.$visaNameId.'" and status=1 && deletestatus=0');
	$visaData1 = mysqli_fetch_assoc($rsV1);

    $Vtrs = GetPageRecord('name','visaTypeMaster',' id="'.$visaTypeId.'" and status=1 and deletestatus=0');
    $typeName = mysqli_fetch_assoc($Vtrs);

    $Vrs = GetPageRecord('*','visaRateMaster','serviceid="'.$visaNameId.'" and visaTypeId="'.$visaTypeId.'" and status=1 and deletestatus=0');
    if(mysqli_num_rows($Vrs)>0){
    $visaData = mysqli_fetch_assoc($Vrs);

    ?>
    <script>
       
        $("#adultCost").val('<?php echo $visaData['adultCost']; ?>');
        $("#childCost").val('<?php echo $visaData['childCost']; ?>');
        $("#infantCost").val('<?php echo $visaData['infantCost']; ?>');
        $("#visaRateId").val('<?php echo $visaData['id']; ?>');
        $("#vcurrencyId").val('<?php echo $visaData['currencyId']; ?>');
        $("#embassyFeev").val('<?php echo $visaData['embassyFee']; ?>');
        $("#vfsChargesv").val('<?php echo $visaData['vfsCharges']; ?>');
        $("#processingFeev").val('<?php echo $visaData['processingFee']; ?>');

    </script>
    <?php
    }else{
        ?>
        <script>
            alert("No Rate Available For <?php echo $typeName['name']; ?>");
            
                $("#adultCost").val('');
                $("#childCost").val('');
                $("#infantCost").val('');
                $("#visaRateId").val('');
                $("#vcurrencyId").val('');
                $("#embassyFeev").val('');
                $("#vfsChargesv").val('');
                $("#processingFeev").val('');
        </script>
        <?php
    }
}


if($_REQUEST['action']=="selectPassCost" && $_REQUEST['passTypeId']!=''){

    $passNameId = $_REQUEST['passportNameId'];
    $passTypeId = $_REQUEST['passTypeId'];

    // $rsP1 = GetPageRecord('name','passportCostMaster','id="'.$passNameId.'" and status=1 && deletestatus=0');
	// $passData1 = mysqli_fetch_assoc($rsP1);

     $Ptrs = GetPageRecord('name','passportTypeMaster',' id="'.$passTypeId.'" and status=1 and deletestatus=0');
    $typeName = mysqli_fetch_assoc($Ptrs);

    $Prs = GetPageRecord('*','passportRateMaster',' serviceid="'.$passNameId.'" and passportTypeId="'.$passTypeId.'" and status=1 and deletestatus=0');
    if(mysqli_num_rows($Prs)>0){
    $passData = mysqli_fetch_assoc($Prs);

    ?>
    <script>
       
        $("#passadultCost").val('<?php echo $passData['adultCost']; ?>');
        $("#passchildCost").val('<?php echo $passData['childCost']; ?>');
        $("#passinfantCost").val('<?php echo $passData['infantCost']; ?>');
        $("#passRateId").val('<?php echo $passData['id']; ?>');
        $("#pcurrencyId").val('<?php echo $passData['currencyId']; ?>');

    </script>
    <?php
    }else{
        ?>
        <script>
            alert("No Rate Available For <?php echo $typeName['name']; ?>");
            
                $("#passadultCost").val('');
                $("#passchildCost").val('');
                $("#passinfantCost").val('');
                $("#passRateId").val('');
                $("#pcurrencyId").val('');
        </script>
        <?php
    }
}

if($_REQUEST['action']=="selectInsuranceCost" && $_REQUEST['insuranceTypeId']!=''){

    $insuranceNameId = $_REQUEST['insuranceNameId'];
    $insuranceTypeId = $_REQUEST['insuranceTypeId'];
    $rsI1 = GetPageRecord('name','InsuranceTypeMaster','id="'.$insuranceTypeId.'" and status=1 && deletestatus=0');
	$insuranceData1 = mysqli_fetch_assoc($rsI1);

    $Irs = GetPageRecord('*','insuranceRateMaster',' serviceid="'.$insuranceNameId.'" and insuranceTypeId="'.$insuranceTypeId.'" and status=1 and deletestatus=0');
    if(mysqli_num_rows($Irs)>0){
    $insuranceData = mysqli_fetch_assoc($Irs);

    ?>
    <script>
       
        $("#insadultCost").val('<?php echo $insuranceData['adultCost']; ?>');
        $("#inschildCost").val('<?php echo $insuranceData['childCost']; ?>');
        $("#insinfantCost").val('<?php echo $insuranceData['infantCost']; ?>');
        $("#insuranceRateId").val('<?php echo $insuranceData['id']; ?>');
        $("#IcurrencyId").val('<?php echo $insuranceData['currencyId']; ?>');

    </script>
    <?php
    }else{
        ?>
        <script>
            alert("No Rate Available For <?php echo $insuranceData1['name']; ?>");
            
                $("#insadultCost").val('');
                $("#inschildCost").val('');
                $("#insinfantCost").val('');
                $("#insuranceRateId").val('');
                $("#IcurrencyId").val('');
        </script>
        <?php
    }
}



if($_REQUEST['action']=="commissionPercentage" && $_REQUEST['commissionNameId']!=''){

    $commissionId = $_REQUEST['commissionNameId'];

	$rs = GetPageRecord('*','commissionMaster','id="'.$commissionId.'"');
   $commissionPercent = mysqli_fetch_assoc($rs);
?>
   <script>
    $("#commissionper").val('<?php echo $commissionPercent['percent']; ?>');
   </script>
						
<?php
}

if($_REQUEST['action']=="moduleListAllChecked"){
    $moduleStatus = $_REQUEST['moduleStatus'];
    
    $where = 'url in("VISAtype","visacostmaster","insuranceType","insurancecostmaster","passportTypeMaster","passportCostMaster","cruisemaster","cruisecompanymaster","cruiseNameMaster","cabintypemaster","cabincategorymaster","ferryCompanymaster","ferryMaster","ferryClassmaster","ferryPricemaster","series","package","fixdeparture")';
    if($moduleStatus==1){
    $muduleUpdate = updatelisting('moduleMaster','selectStatus="'.$moduleStatus.'"',$where);
    }else{
        $muduleUpdate = updatelisting('moduleMaster','selectStatus="0",disableStatus="0"',$where);
    }

    ?>
    <script>
        parent.selectModuleList();
    </script>
    <?php
}


// Started Module enable and disable sec
if($_REQUEST['action']=="moduleListToDisable" && $_REQUEST['moduleId']!=''){

        $moduleStatus = $_REQUEST['moduleStatus'];
        $enableStatus = $_REQUEST['enableStatus'];
        $disableStatus = $_REQUEST['disableStatus'];
        $module = $_REQUEST['module'];
        if($enableStatus==='yes'){
            $muduleUpdate = updatelisting('moduleMaster','disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['moduleId'].'"');

            if($module=="visacostmaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('Visa').'"');
            }
            if($module=="passportCostMaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('Passport').'"');
            }
            if($module=="insurancecostmaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('Insurance').'"');
            }
             if($module=="fixdeparture"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('fixdeparture').'"');
             }
            if($module=="package"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('package').'"');
             }
             if($module=="series"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="0"','UPPER(module)="'.strtoupper('series').'"');
            }

        }elseif($disableStatus==="yes"){
            $muduleUpdate = updatelisting('moduleMaster','disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['moduleId'].'"');

            if($module=="visacostmaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('Visa').'"');
            }
            if($module=="passportCostMaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('Passport').'"');
            }
            if($module=="insurancecostmaster"){
                $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('Insurance').'"');
            }
             if($module=="fixdeparture"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('fixdeparture').'"');
             }
            if($module=="package"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('package').'"');
             }
             if($module=="series"){
            $muduleUpdate = updatelisting('moduleTypeMaster','status="1"','UPPER(module)="'.strtoupper('series').'"');
            }

        }else{
            if($moduleStatus==1){
                $muduleUpdate = updatelisting('moduleMaster','selectStatus="'. $moduleStatus.'"','id="'.$_REQUEST['moduleId'].'"');
            }else{
                $muduleUpdate = updatelisting('moduleMaster','selectStatus="'. $moduleStatus.'",disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['moduleId'].'"');
            }
          
        }
        

        ?>
    
        <ul style="margin-top: 0px;">
        <li class="moduleList" style="font-weight: 600; font-size: 14px; color: grey;">Module Name <span style="float: right;">Status</span></li>
           
           <?php
            $resM = GetPageRecord('*','moduleMaster','moduleName!="" and url in ("visacostmaster","insurancecostmaster","passportCostMaster","cruisemaster","ferryMaster","series","package","fixdeparture") order by moduleName asc');
           while($moduleNameD = mysqli_fetch_assoc($resM)){

            $moduleName = $moduleNameD['moduleName'];
                    if($moduleNameD['url']=="visacostmaster"){
                        $moduleName="Visa Master";
                    }elseif($moduleNameD['url']=="passportCostMaster"){
                        $moduleName="Passport Master";
                    }elseif($moduleNameD['url']=="insurancecostmaster"){
                        $moduleName="Insurance Master";
                    }
                   
                ?>
                <li class="moduleList"> <?php echo $moduleName; ?> 
               <?php if($moduleNameD['disableStatus']==1){ ?> 
                <i onclick="hideOnbtn('<?php echo $moduleNameD['id']; ?>','0','<?php echo $moduleNameD['url']; ?>')" id='onbtnId<?php echo $moduleNameD['id']; ?>' class="fa fa-toggle-on onbutton" aria-hidden='true'></i>
                <?php } if($moduleNameD['disableStatus']==0){ ?>
                <i onclick="hideOffbtn('<?php echo $moduleNameD['id']; ?>','1','<?php echo $moduleNameD['url']; ?>')" id='offbtnId<?php echo $moduleNameD['id']; ?>' class="fa fa-toggle-off offbutton" aria-hidden='true'></i></li>
                <?php
                }
            }
            ?>
       
        </ul>
      <?php
}   


// Ended  Module enable and disable sec 





   // Started  proposal enable and disable sec

   if($_REQUEST['action']=="proposalListToDisable"){
    // die("tygvcgvcxc");

    $moduleStatus = $_REQUEST['moduleStatus'];
    $enableStatus = $_REQUEST['enableStatus'];
    $disableStatus = $_REQUEST['disableStatus'];
    $module = $_REQUEST['proposalNum'];
    if($enableStatus==='yes'){
        $muduleUpdate = updatelisting('proposalSettingMaster','disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['id'].'"');

        // if($module=="detailedproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('detailedproposal').'"');
        // }
        // if($module=="detailedproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('detailedproposal').'"');
        // }
        // if($module=="briefproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('briefproposal').'"');
        // }
        //  if($module=="eliteproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('eliteproposal').'"');
        //  }
        // if($module=="vividproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('vividproposal').'"');
        //  }
        //  if($module=="costsheetproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('costsheetproposal').'"');
        // }
        // if($module=="modishproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('modishproposal').'"');
        // }
        // if($module=="modishcostproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('modishcostproposal').'"');
        // }

    }elseif($disableStatus==="yes"){
        $muduleUpdate = updatelisting('proposalSettingMaster','disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['id'].'"');

        // if($module=="detailedproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('detailedproposal').'"');
        // }
        // if($module=="briefproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('briefproposal').'"');
        // }
        // if($module=="eliteproposal"){
        //     $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('eliteproposal').'"');
        // }
        //  if($module=="vividproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('vividproposal').'"');
        //  }
        // if($module=="costsheetproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('costsheetproposal').'"');
        //  }
        //  if($module=="modishproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="1"','UPPER(proposal)="'.strtoupper('modishproposal').'"');
        // }
        // if($module=="modishcostproposal"){
        // $muduleUpdate = updatelisting('proposalTypeMaster','status="0"','UPPER(proposal)="'.strtoupper('modishcostproposal').'"');
        // }

    }else{
        if($moduleStatus==1){
            $muduleUpdate = updatelisting('proposalSettingMaster','selectStatus="'. $moduleStatus.'"','id="'.$_REQUEST['id'].'"');
        }else{
            $muduleUpdate = updatelisting('proposalSettingMaster','selectStatus="'. $moduleStatus.'",disableStatus="'. $moduleStatus.'"','id="'.$_REQUEST['id'].'"');
        }
      
    }
    

    ?>

    <ul style="margin-top: 0px;">
    <li class="proposalList" style="font-weight: 600; font-size: 14px; color: grey;">Proposal Name <span style="float: right;">Status</span></li>
       
       <?php
    //    die("kdfhfdfdndf");
            $resM = GetPageRecord('*','proposalSettingMaster','proposalName!="" and proposalNum in (1,2,3,4,6,7,9,10,11) order by id asc');
        
        while($moduleNameD = mysqli_fetch_assoc($resM)){

            $moduleName = $moduleNameD['proposalName'];
                    // if($moduleNameD['url']=="visacostmaster"){
                    //     $moduleName="Visa Master";
                    // }elseif($moduleNameD['url']=="passportCostMaster"){
                    //     $moduleName="Passport Master";
                    // }elseif($moduleNameD['url']=="insurancecostmaster"){
                    //     $moduleName="Insurance Master";
                    // }
                
                ?>
                <li class="proposalList"> <?php echo $moduleName; ?> 
                    <?php if($moduleNameD['disableStatus']==0){ ?> 
                    <i onclick="proposalhideOnbtn('<?php echo $moduleNameD['id']; ?>','1')" id='onbtnId<?php echo $moduleNameD['id']; ?>' class="fa fa-toggle-on onbutton" aria-hidden='true'></i>
                    <?php } if($moduleNameD['disableStatus']==1){ ?>
                    <i onclick="proposalhideOffbtn('<?php echo $moduleNameD['id']; ?>','0')" id='offbtnId<?php echo $moduleNameD['id']; ?>' class="fa fa-toggle-off offbutton" aria-hidden='true'></i>
                </li>
                <?php
                }
        }
        ?>
   
    </ul>
  <?php
} 


// Ended  proposal enable and disable sec 




if($_REQUEST['action']=='loadChildAgeTable' && $_REQUEST['totalChild']>0){

$totalChild = $_REQUEST['totalChild'];
?>

<table width="100%" border="0" class="griddiv table striped" cellpadding="0" cellspacing="0">
<thead>
<td align="left">No. Of Child</td>
<td align="left">Child Age</td>
</thead>
<tbody>
    <?php
for($i=1; $i<=$totalChild; $i++){
    ?>
     <tr id="childAgeRow">
    <td><input name="noofchild[]" type="text" readonly class="gridfield" id="noofchild" displayname="" value="<?php echo "Child".' '.$i; ?>" /></td>
    <td><input name="childAge[]" type="text" class="gridfield" id="childAge" displayname="Child Age" value="<?php echo $editresult['childAge']; ?>" /></td>
    </tr>
    <?php
}
?>
</tbody>
</table>
<?php
}


if($_REQUEST['action']=="selectSupplierDestinations" && $_REQUEST['countryId']!=''){
    $countryId = $_REQUEST['countryId'];
    $where=' deletestatus=0 and status=1 and countryId="'.trim($_REQUEST['countryId']).'" order by id asc';  
    $rs=GetPageRecord('*',_DESTINATION_MASTER_,$where); 
    while($resListing=mysqli_fetch_array($rs)){ 
        ?>
        <option value="<?php echo $resListing['id']; ?>" <?php if($resListing['countryId']==$countryId){ echo 'selected="selected"'; } ?>><?php echo $resListing['name']; ?> </option>
        <?php
     }
     ?>
     <script>  
comtabopenclose('linkbox','op2'); 
    $('.js-example-basic-multiple').select2();  
	 $('.js-example-basic-multiple').on("select2:select", function (e) { 
      
      }); 
	  
</script>

<?php }




    if($_REQUEST['action']=="selectSupplierDestinations" && $_REQUEST['countryId']==''){
        ?>
         <option value="All">All</option>
	 <?php  
	$select='';  
	$where='';  
	$rs='';   
	$select='*';    
	$where=' deletestatus=0 and status=1 order by name asc';   
	$rs=GetPageRecord($select,_DESTINATION_MASTER_,$where);
	$alldest=explode(',',$editdestinationId);  
	while($resListing=mysqli_fetch_array($rs)){  
	
	 ?> 
	 <option value="<?php echo strip($resListing['id']); ?>" <?php foreach($alldest as $key => $value){ if($resListing['id']==$value){ echo 'selected="selected"'; } } ?> ><?php echo strip($resListing['name']); ?></option> 
	 <?php } 


?>
<script>  
comtabopenclose('linkbox','op2'); 
$('.js-example-basic-multiple').select2();  
$('.js-example-basic-multiple').on("select2:select", function (e) { 
 
 }); 
 
</script>

<?php
    }




// transfer type action
if($_REQUEST['action']=="getTransferNameAction" && $_REQUEST['destinationId']!=''){

    $destinationId=  $_REQUEST['destinationId'];
    $transferTypeId=  $_REQUEST['transferTypeId'];
    $transferType='';
    if($transferTypeId!=''){
       $transferType =  'and transferType="'.$transferTypeId.'"';
    }
    ?>
    <option value="0">Select Transfer</option>
    <?php              
        $rstransfer=GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,' transferCategory="transfer" '.$transferType.' and (FIND_IN_SET("'.$destinationId.'",destinationId) or destinationId=0 )  and status=1 order by transferName asc');
        while($transferD=mysqli_fetch_array($rstransfer)){
        ?>
        <option value="<?php echo $transferD['id']; ?>"><?php echo $transferD['transferName']; ?></option>
        <?php } ?>

    <?php
    }



    if($_REQUEST['action']=="loadVehicleModeltyp" && $_REQUEST['vehicleTypeId']){
        $select='*';    
		$where=' id="'.$_REQUEST['vehicleTypeId'].'" and name!="" order by name asc';  
		$rs=GetPageRecord('capacity','vehicleTypeMaster',$where); 
        $resListing=mysqli_fetch_array($rs);
        ?>
        <script>
            $('#capacity').val('<?php echo $resListing['capacity'] ?>');
        </script>
   <?php
   }


   if($_REQUEST['action']=="loadAppendMultiServices" && $_REQUEST['id']!='' && $_REQUEST['serviceType']!=''){
    $id = $_REQUEST['id'];

        if($_REQUEST['serviceType']=='Flight'){
        ?>

                <div id="loadedservicesFlight<?php echo $id; ?>" class="flight_services">
						
						<div class="griddiv"><label>
						<!-- <div class="gridlable">Date<span class="redmind"></span></div> -->

							<input name="flightDate<?php echo $id; ?>" type="date" class="gridfield" onKeyUp="numericFilter(this);" id="flightDate<?php echo $id; ?>" displayname="Flight Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div> -->

							<select name="flightDestination<?php echo $id; ?>" class="gridfield" id="flightDestination<?php echo $id; ?>" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>"><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div> -->

							<select name="flightToDestination<?php echo $id; ?>" class="gridfield" id="flightToDestination<?php echo $id; ?>" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($toDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $toDest['id']; ?>"><?php echo ucfirst($toDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
						<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('','<?php echo $id; ?>','Flight');"></i></div>
                      
					</div>

        <?php }

        if($_REQUEST['serviceType']=='Visa'){
        ?>
            <div id="loadedservicesVisa<?php echo $id; ?>" class="visa_services">

            <div class="griddiv"><label>
						<!-- <div class="gridlable">Date<span class="redmind"></span></div> -->

							<input name="visaDate<?php echo $id; ?>" type="date" class="gridfield validate" onKeyUp="numericFilter(this);" id="visaDate<?php echo $id; ?>" displayname="Visa Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>
					
						<div class="griddiv"><label>
						<!-- <div class="gridlable">Destination</div> -->

							<select name="visaDestination<?php echo $id; ?>" class="gridfield" id="visaDestination<?php echo $id; ?>" displayname="Visa Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>" ><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

                        <div class="griddiv"><label>
					
						<!-- <div class="gridlable">Visa&nbsp;Name<span class="redmind"></span></div> -->
						
							<select name="visaNameId<?php echo $countNum; ?>" class="gridfield" id="visaNameId<?php echo $countNum; ?>" displayname="Visa Name" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsV = GetPageRecord('name,id','visaCostMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaName = mysqli_fetch_assoc($rsV)){ ?>
								<option value="<?php echo $visaName['id']; ?>" ><?php echo ucfirst($visaName['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Visa&nbsp;Type</div> -->

							<select name="visaTypeId<?php echo $id; ?>" class="gridfield" id="visaTypeId<?php echo $id; ?>" displayname="Visa Type" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','visaTypeMaster','status=1 and deletestatus=0 and name!="" ');
								while($visaType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $visaType['id']; ?>"><?php echo ucfirst($visaType['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Validity</div> -->

							<input name="visaValidity<?php echo $id; ?>" type="text" class="gridfield" id="visaValidity<?php echo $id; ?>" displayname="Validity" value="" placeholder="Validity" style="padding: 9px;" /></label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Entry Type</div> -->
							<select name="entryType<?php echo $id; ?>" class="gridfield" id="entryType<?php echo $id; ?>" displayname="Entry Type" style="padding: 9.5px;">
								<option value="">Select</option>
								<option value="1">Single Entry</option>
								<option value="2">Multiple Entry</option>
	
							</select>
						</label>
						</div>

                        <div class="addbtn" style="margin-top: 7px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('','<?php echo $id; ?>','Visa');"></i></div>
            </div>

        <?php  } 
        
        if($_REQUEST['serviceType']=='Insurance'){
            ?>

            <div id="loadedservicesInsurance<?php echo $id; ?>" class="insurance_services">

                    <div class="griddiv"><label>
						<!-- <div class="gridlable">From&nbsp;Date<span class="redmind"></span></div> -->

							<input name="insuranceFromDate<?php echo $id; ?>" type="date" class="gridfield" id="insuranceFromDate<?php echo $id; ?>" displayname="Insurance From Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
					</div>

					<div class="griddiv"><label>
						<!-- <div class="gridlable">To&nbsp;Date<span class="redmind"></span></div> -->

							<input name="insuranceToDate<?php echo $id; ?>" type="date" class="gridfield" id="insuranceToDate<?php echo $id; ?>" displayname="Insurance To Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
					</div>

						
					<div class="griddiv"><label>
						<!-- <div class="gridlable">Insurance&nbsp;Type<span class="redmind"></span></div> -->

						<select name="insuranceTypeId<?php echo $id; ?>" class="gridfield" id="insuranceTypeId<?php echo $id; ?>" displayname="Insurance Type" style="padding: 9.5px;">
							<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id','InsuranceTypeMaster','status=1 and deletestatus=0 and name!="" order by name asc');
								while($insType = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $insType['id']; ?>"><?php echo ucfirst($insType['name']); ?></option>
								<?php }
								
								?>

						</select>
						</label>
					</div>
					
					<div class="griddiv"><label>
						<!-- <div class="gridlable">Travelling&nbsp;Country<span class="redmind"></span></div> -->

						<select name="insuranceDestination<?php echo $id; ?>" class="gridfield" id="insuranceDestination<?php echo $id; ?>" displayname="Travelling Country" style="padding: 9.5px;">
							<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_COUNTRY_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($countryDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $countryDest['id']; ?>" ><?php echo ucfirst($countryDest['name']); ?></option>
								<?php }
								
								?>
						</select>
						</label>
					</div>

                    <div class="addbtn" style="margin-top: 7px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('','<?php echo $id; ?>','Insurance');"></i></div>

            </div>

            <?php
        }

        if($_REQUEST['serviceType']=='Train'){
        ?>
            <div id="loadedservicesTrain<?php echo $id; ?>" class="train_services">
						
						<div class="griddiv"><label>
						<!-- <div class="gridlable">Date<span class="redmind"></span></div> -->

							<input name="trainDate<?php echo $id; ?>" type="date" class="gridfield" id="trainDate<?php echo $id; ?>" displayname="Train Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">From&nbsp;Destination<span class="redmind"></span></div> -->

							<select name="trainDestination<?php echo $id; ?>" class="gridfield" id="trainDestination<?php echo $id; ?>" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($fromDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $fromDest['id']; ?>"><?php echo ucfirst($fromDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">To&nbsp;Destination<span class="redmind"></span></div> -->

							<select name="trainToDestination<?php echo $id; ?>" class="gridfield" id="trainToDestination<?php echo $id; ?>" style="padding: 9.5px;">
								<option value="">Select</option>
								
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" ');
								while($toDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $toDest['id']; ?>"><?php echo ucfirst($toDest['name']); ?></option>
								<?php }
								
								?>

							</select>
						</label>
						</div>
						<div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('','<?php echo $id; ?>','Train');"></i></div>
                      
					</div>
            
        
        <?php  }
        
        if($_REQUEST['serviceType']=='Transfer'){
            ?>
                <div id="loadedservicesTransfer<?php echo $id; ?>" class="transfer_services">

                <div class="griddiv"><label>
						<!-- <div class="gridlable">Date<span class="redmind"></span></div> -->

							<input name="transferDate<?php echo $id; ?>" type="date" class="gridfield" id="transferDate<?php echo $id; ?>" displayname="Transfer Date" value="<?= date('Y-m-d',strtotime('now')); ?>" /></label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Destination<span class="redmind"></span></div> -->

							<select name="transferDestination<?php echo $id; ?>" class="gridfield" id="transferDestination<?php echo $id; ?>" displayname="Transfer Destination" style="padding: 9.5px;">
								<option value="">Select</option>
								<?php
								$rsA = GetPageRecord('name,id',_DESTINATION_MASTER_,'status=1 and deletestatus=0 and name!="" order by name asc');
								while($countryDest = mysqli_fetch_assoc($rsA)){ ?>
								<option value="<?php echo $countryDest['id']; ?>" ><?php echo ucfirst($countryDest['name']); ?></option>
								<?php }
								
								?>
							</select>
						</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Transfer&nbsp;Type<span class="redmind"></span></div> -->
							<select name="transferTypeId<?php echo $id; ?>" class="gridfield" id="transferTypeId<?php echo $id; ?>" onchange="getDestinationWiseTransfers<?php echo $id; ?>('<?php echo $id; ?>');" displayname="Transfer Type" style="padding: 9.5px;">
                            <option value="">Select</option>
								<?php 
								$rsQ = GetPageRecord('*','transferTypeMaster','status=1 and name!="" order by name asc');
								while($tptTypeData = mysqli_fetch_assoc($rsQ)){
									?>
									<option value="<?php echo $tptTypeData['id']; ?>"> <?php echo $tptTypeData['name']; ?> </option>
									<?php
								}
								?>
							</select>
							</label>
						</div>

						<div class="griddiv"><label>
						<!-- <div class="gridlable">Transfer&nbsp;Name<span class="redmind"></span></div> -->

							<select name="transferNameId<?php echo $id; ?>" class="gridfield" id="transferNameId<?php echo $id; ?>" onchange="getTransferType<?php echo $id; ?>('<?php echo $id; ?>');" displayname="Transfer Name" style="padding: 9.5px;">
								
							</select>
						</label>
						</div>

						<script>
							function getDestinationWiseTransfers<?php echo $id; ?>(){
								var transferDestination = $("#transferDestination<?php echo $id; ?>").val();
								var transferTypeId = $("#transferTypeId<?php echo $id; ?>").val();

								$("#transferNameId<?php echo $id; ?>").load(`searchaction.php?action=getDestinationWiseTransfersforQuery&destinationId=${transferDestination}&transferTypeId=${transferTypeId}`);
							}

						
						</script>

                    <div class="addbtn" style="margin-top: 6px;"><i class="fa fa-trash-o multiservicebtn" aria-hidden="true" onclick="removeMultipleServices('','<?php echo $id; ?>','Transfer');"></i></div>

                </div>

    <?php  } }


        if($_REQUEST['action']=="getDestinationWiseTransfersforQuery" && $_REQUEST['transferTypeId']!=''){
            if($_REQUEST['destinationId']!=''){
            $destinationId = $_REQUEST['destinationId'];
            $transferTypeId = $_REQUEST['transferTypeId'];
            $transferNameId='';
            if($_REQUEST['transferNameId']!=''){
                $transferNameId = $_REQUEST['transferNameId'];
            }
         


            $rsD = GetPageRecord('transferName,id','packageBuilderTransportMaster','status=1 and deletestatus=0 and transferName!="" and transferCategory="transfer" and (FIND_IN_SET("'.$destinationId.'",destinationId) or destinationId=0 ) and transferType="'.$transferTypeId.'" order by transferName asc');
            while($transferData = mysqli_fetch_assoc($rsD)){ ?>
                <option value="<?php echo $transferData['id']; ?>" <?php if($transferNameId==$transferData['id']){ echo 'selected'; } ?>><?php echo ucfirst($transferData['transferName']); ?></option>
                <?php }
            }else{
                ?>
                <script>
                    alert("Please select Destination");
                </script>
                <?php
            }
        }



        if($_REQUEST['action']=="searchGuestEmp" && $_REQUEST['fullName']!='' && $_REQUEST['contactType']!=''){

            $fullName = $_REQUEST['fullName'];
            $contactType = $_REQUEST['contactType'];
            $where = '1 and contactType="'.$contactType.'" and firstName like "%'.$fullName.'%" or middleName like "%'.$fullName.'%" or lastName like "%'.$fullName.'%" or id in ( select masterId from phoneMaster where phoneNo like "%'.$fullName.'%" and sectionType="contacts") order by firstName asc ';
            
            $rs = GetPageRecord('*','contactsMaster',$where);
            if(mysqli_num_rows($rs)>0){
                while($searchData = mysqli_fetch_assoc($rs)){
                    ?>
                        <div class="selectGuestbc" onclick="selectGuest('<?php echo $searchData['contacttitleId']; ?>','<?php echo $searchData['firstName']; ?>','<?php echo $searchData['middleName']; ?>','<?php echo $searchData['lastName']; ?>','<?php echo $searchData['gender']; ?>','<?php if($searchData['birthDate']!='' && $searchData['birthDate']!= '1970-01-01'){ echo date('d-m-Y',strtotime($searchData['birthDate'])); } ?>','<?php if($searchData['anniversaryDate']!='' && $searchData['anniversaryDate']!= '1970-01-01'){ echo date('d-m-Y',strtotime($searchData['anniversaryDate'])); } ?>','<?php echo getPrimaryPhone($searchData['id'],'contacts'); ?>','<?php echo getPrimaryEmail($searchData['id'],'contacts'); ?>','<?php echo $searchData['guestAge']; ?>','<?php echo $searchData['nationality']; ?>','<?php echo $searchData['countryId']; ?>','<?php echo $searchData['stateId']; ?>','<?php echo $searchData['cityId']; ?>','<?php echo $searchData['pinzip']; ?>','<?php echo $searchData['address1']; ?>','<?php echo $searchData['emergencyName']; ?>','<?php echo $searchData['emergencyRelation']; ?>','<?php echo $searchData['emergencyContact']; ?>','<?php echo $searchData['familyCode']; ?>','<?php echo $searchData['familyRelation']; ?>');">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                        <?php echo $searchData['firstName'].' '.$searchData['middleName'].''.$searchData['lastName']; ?>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                    <td> 
                                        <?php echo getPrimaryPhone($searchData['id'],'contacts'); ?><br>
                                        <?php echo getPrimaryEmail($searchData['id'],'contacts'); ?>
                                    </td>
                                    </tr>
                                </table>
                        </div>
                    <?php
                }

            }else{
                echo '<div style="padding: 20px;text-align: center;font-weight: 500;">No Record Found!</div>';
            }
            
        }
       
		
        
    if($_REQUEST['action']=='loadAppendMultiCategoryRates' && $_REQUEST['id']!='' && $_REQUEST['quotationType']!=''){
        $quotationType = $_REQUEST['quotationType'];
        $hotelType = $_REQUEST['hotelType'];
        $hotelCategory = $_REQUEST['hotelCategory'];
        $id = $_REQUEST['id'];
        ?>
        
            <table border="1" cellspacing="0" cellpadding="4" style="position: relative;" id="removeId<?php echo $id; ?>">
                <tr>
					<td>
                        <input type="hidden" name="rateNumloop<?php echo $id; ?>" id="rateNumloop<?php echo $id; ?>" value="<?php echo $_REQUEST['rateNum'] ?>">
						<select name="supplierId<?php echo $id; ?>" id="supplierId<?php echo $id; ?>" class="packageCostDiv_selectbox" style="width:144px">
							<option disabled value="">Select Supplier</option>
							<?php 
                            $supplierQuery1='';
							$supplierQuery1 = GetPageRecord('id,name',_SUPPLIERS_MASTER_,' 1 and CHAR_LENGTH(name)>1 and deletestatus=0 and status=1 order by name asc');
							while($supplierData = mysqli_fetch_array($supplierQuery1)){ ?>
							<option value="<?php echo $supplierData['id']; ?>"><?php echo $supplierData['name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<?php if($quotationType==2 || $quotationType==3){ ?>
					<td>
					<?php if($quotationType==2){ ?>
						<select name="hotelCategoryId<?php echo $id; ?>" id="hotelCategoryId<?php echo $id; ?>" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
                            $HQuery='';
							$hotelCategory = explode(',',$hotelCategory);
							foreach($hotelCategory as $val){
							$HQuery = GetPageRecord('id,hotelCategory',_HOTEL_CATEGORY_MASTER_,' 1 and deletestatus=0 and status=1 and id="'.$val.'" order by hotelCategory asc');
							$hotelCategoryData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelCategoryData['id']; ?>"><?php echo $hotelCategoryData['hotelCategory'].' Star'; ?></option>
							<?php } ?>
						</select>
						<?php } ?>

						<?php if($quotationType==3){ ?>
						<select name="hotelTypeId<?php echo $id; ?>" id="hotelTypeId<?php echo $id; ?>" class="packageCostDiv_selectbox">
							<option value="">Select Category</option>
							<?php 
                            $HQuery='';
							$hotelType = explode(',',$hotelType);
							foreach($hotelType as $val2){
							$HQuery = GetPageRecord('id,name','hotelTypeMaster',' 1 and deletestatus=0 and status=1 and id="'.$val2.'" order by name asc');
							$hotelTypeData = mysqli_fetch_array($HQuery); ?>
							<option value="<?php echo $hotelTypeData['id']; ?>"><?php echo $hotelTypeData['name']; ?></option>
							<?php } ?>
						</select>
						<?php } ?>
					</td>
					<?php } ?>
					<td>
						<select name="currencyId<?php echo $id; ?>" id="currencyId<?php echo $id; ?>" class="packageCostDiv_selectbox">
							<option disabled value="">Select Currency</option>
							<?php 
                            $currencyQuery='';
							$currencyQuery = GetPageRecord('id,name',_CURRENCY_MASTER_,' 1  and name!="" and deletestatus=0 and status=1 order by setDefault desc');
							while($currencyData = mysqli_fetch_array($currencyQuery)){ ?>
							<option value="<?php echo $currencyData['id']; ?>"><?php echo $currencyData['name']; ?></option>
							<?php } ?>
						</select>
					</td>
					<td><input type="number" name="singleBasis<?php echo $id; ?>" id="singleBasis<?php echo $id; ?>" value="" placeholder="Single Basis"></td>
					<td><input type="number" name="doubleBasis<?php echo $id; ?>" id="doubleBasis<?php echo $id; ?>" value="" placeholder="Double Basis"></td>
					<!-- <td><input type="number" name="twinBasis" id="twinBasis" value="<?php echo $edittwinBasis; ?>"></td> -->
					<td><input type="number" name="tripleBasis<?php echo $id; ?>" id="tripleBasis<?php echo $id; ?>" value="" placeholder="Triple Basis"></td>
					<?php if(isRoomActive('quadroom')==true){ ?>
					<td><input type="number" name="quadBasis<?php echo $id; ?>" id="quadBasis<?php echo $id; ?>" value="" placeholder="Quad Basis" ></td>
					<?php } if(isRoomActive('sixbedroom')==true){ ?>
					<td><input type="number" name="sixBedBasis<?php echo $id; ?>" id="sixBedBasis<?php echo $id; ?>" value="" placeholder="Six Basis"></td>
					<?php } if(isRoomActive('eightbedroom')==true){ ?>
					<td><input type="number" name="eightBedBasis<?php echo $id; ?>" id="eightBedBasis<?php echo $id; ?>" value="" placeholder="Eight Basis"></td>
					<?php } if(isRoomActive('tenbedroom')==true){ ?>
					<td><input type="number" name="tenBedBasis<?php echo $id; ?>" id="tenBedBasis<?php echo $id; ?>" value="" placeholder="Ten Basis"></td> 
					<?php } if(isRoomActive('teenbed')==true){ ?>
					<td><input type="number" name="teenBedBasis<?php echo $id; ?>" id="teenBedBasis<?php echo $id; ?>" value="" placeholder="Teen Basis"></td> 
					<?php } ?>
					<td><input type="number" name="extraBedABasis<?php echo $id; ?>" id="extraBedABasis<?php echo $id; ?>" value="" placeholder="Extra Bed(A)"></td>
					<td><input type="number" name="childwithbedBasis<?php echo $id; ?>" id="childwithbedBasis<?php echo $id; ?>" value="" placeholder="Extra Bed(C)"></td>
					<td><input type="number" name="childwithoutbedBasis<?php echo $id; ?>" id="childwithoutbedBasis<?php echo $id; ?>" value="" placeholder="Extra Bed(NC)"></td>
					<td><input type="number" name="infantBasisCost<?php echo $id; ?>" id="infantBasisCost<?php echo $id; ?>" value="" placeholder="Infant Basis"></td>
                    <div id="removeIcon<?php echo $id; ?>" style="position: absolute;right: 140px;"><i class="fa fa-trash" onclick="RemoveRate('<?php echo $id ?>');" aria-hidden="true" style="font-size: 20px;color: #01c901;cursor:pointer;color:red;"></i></div>
				</tr>
                
               
            </table>
          
        <?php

    }    
	?>