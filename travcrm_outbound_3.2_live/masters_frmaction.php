<?php
ob_start();
include "inc.php"; 
include "config/logincheck.php";
include 'smart_resize_image.function.php';
?>
<script src="js/jquery-1.11.3.min.js"></script>   
<?php
if(trim($_POST['action'])=='addedit_countrymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$sortname=clean($_POST['sortname']); 
	$status=clean($_POST['status']);
	$setDefault=clean($_POST['setDefault']);
	$dateAdded=time();
	$where='name="'.$name.'" and deletestatus=0';  
	$addnewyes = checkduplicate(_COUNTRY_MASTER_,$where); 
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This country already exist.');
		</script>
		<?php
	} else{

		if($setDefault==1){
			updatelisting(_COUNTRY_MASTER_,'setDefault=0','setDefault=1');
		}

		$namevalue ='name="'.$name.'",sortname="'.$sortname.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",setDefault="'.$setDefault.'"';  
		$adds = addlisting(_COUNTRY_MASTER_,$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
	<?php } 
}
if(trim($_POST['action'])=='addedit_countrymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$sortname=clean($_POST['sortname']);
	$status=clean($_POST['status']);
	$setDefault=clean($_POST['setDefault']);
	$modifyDate=time();
	 $where='name="'.$name.'" and id!="'.$_POST['editId'].'" and deletestatus=0';  
	$addnewyes = checkduplicate(_COUNTRY_MASTER_,$where); 
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This country already exist.');
		</script>
		<?php
	}else{ 
		if($setDefault==1){
			updatelisting(_COUNTRY_MASTER_,'setDefault=0','setDefault=1');
		}

		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$name.'",sortname="'.$sortname.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'",setDefault="'.$setDefault.'"';  
		$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	}
} 
//add lead source master
if(trim($_POST['action'])=='addedit_leadsource' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	
	$dateAdded=time();
	$where='name="'.$name.'" and deletestatus=0';  
	$addnewyes = checkduplicate('leadssourceMaster',$where); 
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This Lead source already exist.');
		</script>
		<?php
	}else{

		if($_POST['setDefault']==1){
			$setDefault=1;
			$where='setDefault="1"'; 
			$namevalue ='setDefault="0"';
			$update = updatelisting('leadssourceMaster',$namevalue,$where); 
		}else{
		$setDefault=0;	
		}

		$namevalue ='name="'.$name.'",status="1",setDefault="'.$setDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting('leadssourceMaster',$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
	<?php } 
}

if(trim($_POST['action'])=='addedit_leadsource' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$modifyDate=time();
	$where='name="'.$name.'" and id!="'.$_POST['editId'].'" and deletestatus=0';  
	$addnewyes = checkduplicate('leadssourceMaster',$where); 
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This Lead source already exist.');
		</script>
		<?php
	} else {

		if($_POST['setDefault']==1){
			$setDefault=1;
			$where='setDefault="1"'; 
			$namevalue ='setDefault="0"';
			$update = updatelisting('leadssourceMaster',$namevalue,$where); 
		}else{
		$setDefault=0;	
		}

		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$name.'",status="'.$status.'",setDefault="'.$setDefault.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting('leadssourceMaster',$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	}
}
//add lead source masster 
if(trim($_POST['action'])=='addedit_currencymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']);
	$countryId=clean($_POST['countryId']); 
	$currencyValue=clean($_POST['currencyValue']);
	$currencyCode=clean($_POST['currencyCode']);	 
	$dateAdded=time();
	// if($_POST['setDefault']==1){
	// 	$where='1'; 
	// 	$namevalue ='setDefault="0"';
	// 	$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
	// }
	$rs1="";
	$rs1=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' UPPER(name)="'.strtoupper($name).'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){
		$namevalue ='country="'.$countryId.'",name="'.$name.'",status="'.$status.'",currencyValue="'.$currencyValue.'" ,dateAdded="'.$dateAdded.'",currencyCode="'.$currencyCode.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting(_QUERY_CURRENCY_MASTER_,$namevalue); 
		?>
		<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
	}else{
	    ?>
    	<script>
    	parent.alert('Duplicate Currency not allowed.');
    	parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
    	</script> 
    	<?php 
	} 
} 

//add lead source masster 
if(trim($_POST['action'])=='addedit_ratelist' && trim($_POST['editId'])=='' && trim($_POST['currencyValue'])!='' && trim($_POST['module'])!=''){ 
	$fromDate=clean($_POST['fromDate']); 
	$toDate=clean($_POST['toDate']);  
	$status=clean($_POST['status']);
	$currencyValue=clean($_POST['currencyValue']); 
	$dateAdded=date('Y-m-d'); 
	
	$datelist='';
	$isDup=0;
	$begin = new DateTime( $fromDate );
	$end   = new DateTime( $toDate ); 
	$dayId = $startDayId; 
	for($i = $begin; $i <= $end; $i->modify('+1 day')){   
		
		$date = $i->format("Y-m-d");
		$rs1="";
		$rs1=GetPageRecord('*','queryCurrencyRateMaster','currencyId="'.$_POST['currencyId'].'" and date="'.$date.'" and deletestatus=0'); 
		if(mysqli_num_rows($rs1) < 1){
		 
			$namevalue ='currencyId="'.$_POST['currencyId'].'",date="'.$date.'",status="'.$status.'",currencyValue="'.$currencyValue.'" ,dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$adds = addlisting('queryCurrencyRateMaster',$namevalue); 
			
		}else{ 
			$currencyRateData = mysqli_fetch_array($rs1);
			$namevalue ='status="'.$status.'",currencyValue="'.$currencyValue.'" ,modifyDate="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$update = updatelisting('queryCurrencyRateMaster',$namevalue,'id = "'.$currencyRateData['id'].'" and DATE(date) > "'.date('Y-m-d').'" '); 
			/*$isDup = 1;
			$datelist .= $date.',';
			if($isDup > 0){ ?>
			parent.alert('<?php echo $datelist;?>&nbsp; are already exist.');
			<?php } */
		}
		$dayId++;
	}  
	?>
	<script> 
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&submodule=<?php echo $_POST['submodule']; ?>&currencyId=<?php echo $_POST['currencyId']; ?>&alt=1');
	</script> 
	<?php 
} 

//add lead source masster 
if(trim($_POST['action'])=='addedit_ratelist' && trim($_POST['editId'])!='' && trim($_POST['currencyValue'])!='' && trim($_POST['module'])!=''){ 
	$status=clean($_POST['status']);
	$currencyValue=clean($_POST['currencyValue']); 
	$dateAdded=date('Y-m-d');  
	$editId = $_REQUEST['editId'];
	
	$namevalue ='status="'.$status.'",currencyValue="'.$currencyValue.'" ,modifyDate="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting('queryCurrencyRateMaster',$namevalue,'id = "'.$editId.'"'); 
	?>
	<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&submodule=<?php echo $_POST['submodule']; ?>&currencyId=<?php echo $_POST['currencyId']; ?>&alt=1');
	</script> 
	<?php 
} 

if(trim($_POST['action'])=='addedit_mealplan' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=htmlentities($_POST['name']); 
	$mealName = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $name);
	$status=clean($_POST['status']);
	$dateAdded=time();

	if($_POST['defaultMealplan']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where); 
	}else{
	$setDefault=0;	
	}

	$rs3=GetPageRecord('id',_MEAL_PLAN_MASTER_,'name="'.$mealName.'"');
	if(mysqli_num_rows($rs3)<1){
	    $namevalue ='name="'.$mealName.'",setDefault="'.$setDefault.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"'; 
	    $adds = addlisting(_MEAL_PLAN_MASTER_,$namevalue); 
	    ?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
	}else{
		?>
		<script>
		parent.alert('Meal Name already exist !!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}

}
 

if(trim($_POST['action'])=='addedit_HotelChainMaster'  && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

	$name=clean($_POST['name']); 

	$location=clean($_POST['location']); 

	$hotelwebsite=clean($_POST['hotelwebsite']); 

	$selfsupplier=clean($_POST['selfsupplier']); 

	$contactperson=clean($_POST['contactperson']); 

	$phone=clean($_POST['phone']); 
	$countryCode=clean($_POST['countryCode1']); 

	$email=clean($_POST['email']); 

	$division=clean($_POST['division']); 

	$designation=clean($_POST['designation']); 



	$status=clean($_POST['status']); 

	$dateAdded=time();

	// check the otheractivityName and otheractivityCity variable 
    if($_REQUEST['editId'] == ''){
        
        $wherecheck = 'name="'.$name.'"';
    }else{
        $wherecheck = 'name="'.$name.'" and id != "'.$_REQUEST['editId'].'"';
    }	
	$rs3=GetPageRecord('id','chainhotelmaster',$wherecheck);
	
if(mysqli_num_rows($rs3)<1){
    
    $namevalue ='name="'.$name.'",status="'.$status.'", location="'.$location.'", hotelwebsite="'.$hotelwebsite.'",selfsupplier="'.$selfsupplier.'",contactperson="'.$contactperson.'",phone="'.$phone.'",countryCode="'.$countryCode.'",email="'.$email.'",division="'.$division.'",designation="'.$designation.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

if( trim($_POST['editId'])=='' ){

	$adds = addlisting('chainhotelmaster',$namevalue); 

	$msg = 1;

		if($selfsupplier=='1'){ 

		$dateAdded=time();

		$namevalue ='name="'.$name.'",aliasname="'.$name.'",contactPerson="'.$contactperson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',companyTypeId=1,supplierMainType=1,paymentTerm=1,agreement=0'; 

		$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);  

		 

		

		//$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  

		/// addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);

		

		$namevalue=$where="";

		//$namevalue ='supplierId="'.$lastId.'"'; 

		//$where='id="'.$addid.'"'; 

		//$update = updatelisting(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue,$where); 

 		

		if($lastId!=''){ 

			if($email!=''){ 

				$allvaluecontactperson ='contactPerson="'.$contactperson.'",corporateId="'.$lastId.'",designation="contactperson",phone="'.$phone.'",countryCode="'.$countryCode.'",email="'.$email.'",primaryvalue="1",division="2"';

				addlisting('suppliercontactPersonMaster',$allvaluecontactperson);

			} 

			  

			//-----------------------Add Mobile--------------------------- 

		/*	$phone=$_POST['supplierPhone']; 

			$type=1;  

			$phoneprimary=1;  

			if($phone!=''){ 

				$allvaluephone ='phoneNo="'.$phone.'",phoneType="'.$type.'",primaryvalue="'.$phoneprimary.'",sectionType="suppliers", masterId="'.$lastId.'"'; 	

				$add = addlisting(_PHONE_MASTER_,$allvaluephone); 

			} 

		

			//-----------------------Add Email--------------------------- 

			$email=$_POST['supplierEmail'];

			$type=1;  

			$primaryvalue=1;  

			if($email!=''){ 

				$allvaluephone ='email="'.$email.'",emailType="'.$type.'",primaryvalue="'.$primaryvalue.'",sectionType="suppliers",masterId="'.$lastId.'"'; 

				$add = addlisting(_EMAIL_MASTER_,$allvaluephone); 

			} */

		}

	

} 

}else{

	$where='id='.$_POST['editId'].''; 

	$update = updatelisting('chainhotelmaster',$namevalue,$where); 

	$msg =2;

}

?>

<script>

parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');

</script> 

<?php 
    
}else{
    ?>

<script>

parent.alert('Duplicate entry found !!');
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();

</script> 

<?php
}
} 


// Vehicle Type Master Starts ========================
if(trim($_POST['action'])=='addedit_vehicleTypeMaster' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){
	$name = $_POST['name'];
	$capacity = $_POST['capacity'];
	$status = $_POST['status'];
	$dateAdded=time();

	//vehicleImage
	if(!empty($_FILES['vehicleImage']['name'])){  
		$image=time().$_FILES['vehicleImage']['name'];  
		copy($_FILES['vehicleImage']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['vehicleImage2'];
	}


	// duplicate vehical type master
	$rsr=GetPageRecord('*','vehicleTypeMaster','name="'.$name.'"');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Vehical Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
    }
    else{
		$namevalue = 'image="'.$image.'",name="'.$name.'",capacity="'.$capacity.'",status="'.$status.'",deletestatus="'.$deletestatus.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
		if($_POST['editId'] < 1){
		addlisting('vehicleTypeMaster',$namevalue);
		$msg=1;
		}else{
		$where = 'id="'.$_POST['editId'].'"';
		$adds = updatelisting('vehicleTypeMaster',$namevalue,$where);
		$msg=2;
	}
	?>
		<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
    	</script> 

	<?php
	}
}
if(trim($_POST['action'])=='addedit_vehicleTypeMaster' && trim($_POST['vehicleType'])!='' && trim($_POST['module'])!=''){
	$vehicleType = $_POST['vehicleType'];
	$capacity = $_POST['capacity'];
	$status = $_POST['status'];
	$dateAdded=time();

	//vehicleImage
	if(!empty($_FILES['vehicleImage']['name'])){  
		$image=time().$_FILES['vehicleImage']['name'];  
		copy($_FILES['vehicleImage']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['vehicleImage2'];
	}

	if($_POST['editId']==''){
	$namevalue = 'image="'.$image.'",name="'.$vehicleType.'",capacity="'.$capacity.'",status="'.$status.'",deletestatus="'.$deletestatus.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	addlisting('vehicleTypeMaster',$namevalue);
	$msg=1;
	}else{
		$namevalue2 = 'image="'.$image.'",name="'.$vehicleType.'",capacity="'.$capacity.'",status="'.$status.'",deletestatus="'.$deletestatus.'",modifyDate="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'"';
		$where = 'id="'.$_POST['editId'].'"';
		updatelisting('vehicleTypeMaster',$namevalue2,$where);
		$msg=2;
	}
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');

    	// parent.alert('Vehicle Type already exist !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
//     	</script> 

<?php
}
// Vehicle Type Master End ========================






// duplicate entry from vehical master code started
// duplicate entry from vehical master code ended
 

if(trim($_POST['action'])=='addedit_vehiclemaster' && trim($_POST['brand'])!='' && trim($_POST['model'])!='' ){ 
 $name=clean($editresult['name']); 
    $brand=clean($_POST['brand']); 
	  $brand=clean($_POST['brand']); 
    $model=clean($_POST['model']); 
    $colourType=clean($_POST['colourType']);
    $vehicleType=clean($_POST['vehicleType']);
    $fuelType=clean($_POST['fuelType']); 
    $capacity=clean($_POST['capacity']); 
    $assignedDriver=clean($_POST['assignedDriver']); 
    $vehicleGroup=clean($_POST['vehicleGroup']); 
    $registrationNo=clean($_POST['registrationNo']); 
    $ownerName=clean($_POST['ownerName']); 
    $registrationDate=date('Y-m-d',strtotime($_POST['registrationDate'])); 
    $chassisNo=clean($_POST['chassisNo']); 
    $engineNo=clean($_POST['engineNo']); 
    $CompanyName=clean($_POST['CompanyName']); 
    $policyNo=clean($_POST['policyNo']); 
	$status=clean($_POST['status']);
    $issueDate=date('Y-m-d',strtotime($_POST['issueDate'])); 
    $dueDate=date('Y-m-d',strtotime($_POST['dueDate'])); 
    $premiumAmount=clean($_POST['premiumAmount']); 
    $coverAmount=clean($_POST['coverAmount']); 
    $address=clean($_POST['address']); 
    $taxEfficiency=clean($_POST['taxEfficiency']); 
    $rtoExpiryDate=date('Y-m-d',strtotime($_POST['rtoExpiryDate']));
    $permitType=clean($_POST['permitType']); 
	//$showCostsheet=clean($_POST['showCostsheet']);
	$showCostsheet = (isset($_POST['showCostsheet'])) ? 1 : 0;
    $permitExpiryDate=date('Y-m-d',strtotime($_POST['permitExpiryDate']));
	$dateAdded=time();
	//vehicleImage
	if(!empty($_FILES['vehicleImage']['name'])){  
		$image=time().$_FILES['vehicleImage']['name'];  
		copy($_FILES['vehicleImage']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['vehicleImage2'];
	}
	
	
	// new added duplicate start

	$rsr=GetPageRecord('*',_VEHICLE_MASTER_MASTER_,'model="'.$model.'" ');
	// $editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('VEHICLE Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
		
    }else{
		$namevalue ='image="'.$image.'",brand="'.$brand.'",model="'.$model.'",colourType="'.$colourType.'",fuelType="'.$fuelType.'",capacity="'.$capacity.'",assignedDriver="'.$assignedDriver.'",vehicleGroup="'.$vehicleGroup.'",registrationNo="'.$registrationNo.'",ownerName="'.$ownerName.'",registrationDate="'.$registrationDate.'",chassisNo="'.$chassisNo.'",engineNo="'.$engineNo.'",CompanyName="'.$CompanyName.'",policyNo="'.$policyNo.'",issueDate="'.$issueDate.'",dueDate="'.$dueDate.'",premiumAmount="'.$premiumAmount.'",coverAmount="'.$coverAmount.'",address="'.$address.'",taxEfficiency="'.$taxEfficiency.'",rtoExpiryDate="'.$rtoExpiryDate.'",showCostsheet="'.$showCostsheet.'",permitType="'.$permitType.'",permitExpiryDate="'.$permitExpiryDate.'",carType="'.$vehicleType.'",dateAdded="'.$dateAdded.'",status="'.$status.'",name="'.$name.'",addedBy="'.$_SESSION['userid'].'"';
	 	
		if(trim($_POST['editId']) < 1){
			$adds = addlisting(_VEHICLE_MASTER_MASTER_,$namevalue); 
			$msg = 1;
		}else{
			$where='id='.$_POST['editId'].''; 
			$adds = updatelisting(_VEHICLE_MASTER_MASTER_,$namevalue,$where); 
			$msg = 2;
		}
		
			?>
	<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
	</script> 
	<?php
	}


	



}
	
	// new added duplicate ended
  
	 


if(trim($_POST['action'])=='addedit_sightseeingmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);  
$dateAdded=time();
$destinationId=clean($_POST['destinationId']);
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_transfermaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$destinationId=clean($_POST['destinationId']);  
$dateAdded=time();
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_TRANSFER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_transfercategory' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$destinationId=clean($_POST['destinationId']);  
$dateAdded=time();
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_TRANSFER_CATEGORY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_extraquotation' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 

	$name=clean($_POST['name']);
	$status=clean($_POST['status']);
	$adultCost=clean($_POST['adultCost']);  
	$childCost=clean($_POST['childCost']);  
	$infantCost=clean($_POST['infantCost']);  
	$groupCost=clean($_POST['groupCost']);  
	$costType=clean($_POST['costType']);  
	$currencyId=clean($_POST['currencyId']);
	$additionalDetail=clean($_POST['additionalDetail']);

	$gstTax=clean($_POST['gstTax']);
	$isMarkupApply=clean($_POST['isMarkupApply']);
	$proposalService=clean($_POST['proposalService']);
	$destinationList = implode(',', $_POST['destinationId']);  
	if(!empty($_FILES['AdditionalImage']['name'])){  
		$file_name=time().$_FILES['AdditionalImage']['name'];  
		copy($_FILES['AdditionalImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
		$file_name=$_REQUEST['AdditionalImage2'];
	}
	$dateAdded=time();

	$rs3=GetPageRecord('id',_EXTRA_QUOTATION_MASTER_,'name="'.$name.'"');
	if(mysqli_num_rows($rs3)<1){

			// Additional Code genrated 
			$A = GetPageRecord('displayId',_EXTRA_QUOTATION_MASTER_,'displayId>0 order by displayId desc');
			$ddata = mysqli_fetch_assoc($A);
			$displayId = $ddata['displayId']+1;

			
			$namevalue ='name="'.$name.'",gstTax="'.$gstTax.'",isMarkupApply="'.$isMarkupApply.'",status="'.$status.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",groupCost="'.$groupCost.'",costType="'.$costType.'",proposalService="'.$proposalService.'",currencyId="'.$currencyId.'",file_extra="'.$file_name.'",destinationId="'.$destinationList.'",otherInfo="'.$additionalDetail.'",displayId="'.$displayId .'"';  
			$adds = addlisting(_EXTRA_QUOTATION_MASTER_,$namevalue);
			?>
			<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
			</script> 
			<?php
	}else{
	   ?>
		<script>
		parent.alert('This name already exists !!');
	    parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php 
	}

} 
if(trim($_POST['action'])=='addedit_extraquotation' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$status=clean($_POST['status']);
	$adultCost=clean($_POST['adultCost']);  
	$childCost=clean($_POST['childCost']);  
	$infantCost=clean($_POST['infantCost']);  
	$groupCost=clean($_POST['groupCost']); 
	$costType=clean($_POST['costType']);
	$currencyId=clean($_POST['currencyId']);

	$gstTax=clean($_POST['gstTax']);
	$isMarkupApply=clean($_POST['isMarkupApply']);

	
	$proposalService=clean($_POST['proposalService']);
	$additionalDetail=clean($_POST['additionalDetail']);


	$destinationList = implode(',', $_POST['destinationId']);  
	if(!empty($_FILES['AdditionalImage']['name'])){  
		$file_name=time().$_FILES['AdditionalImage']['name'];  
		 copy($_FILES['AdditionalImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
		$file_name=$_REQUEST['AdditionalImageold'];
	}
	$modifyDate=time();
	 
	// find duplicate value code
	 $rs3=GetPageRecord('id',_EXTRA_QUOTATION_MASTER_,'name="'.$name.'" and id != "'.$_POST['editId'].'"');
	 
	if(mysqli_num_rows($rs3)<2){
		    
		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$name.'",gstTax="'.$gstTax.'",isMarkupApply="'.$isMarkupApply.'",status="'.$status.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",modifyDate="'.$modifyDate.'",proposalService="'.$proposalService.'",groupCost="'.$groupCost.'",modifyBy="'.$_SESSION['userid'].'",costType="'.$costType.'",currencyId="'.$currencyId.'",file_extra="'.$file_name.'",destinationId="'.$destinationList.'",otherInfo="'.$additionalDetail.'"';  
		$update = updatelisting(_EXTRA_QUOTATION_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php

	}else{
	   ?>
	<script>
	parent.alert('This name already exists !!');
	    parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
	</script> 
	<?php 
	}

 }  


if(trim($_POST['action'])=='addedit_currencymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''  && trim($_POST['module'])!=''){ 

	$name=clean($_POST['name']);
	$status=clean($_POST['status']);
	$countryId=clean($_POST['countryId']);
	$currencyValue=clean($_POST['currencyValue']); 
	$currencyCode=clean($_POST['currencyCode']);	
	$modifyDate=time();
	// if($_POST['setDefault']==1){
	// 	$where='1'; 
	// 	$namevalue ='setDefault="0"';
	// 	$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
	// }
	$rs1="";
	$rs1=GetPageRecord('*',_QUERY_CURRENCY_MASTER_,' id != "'.trim($_POST['editId']).'" and UPPER(name)="'.strtoupper($name).'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){

		$where='id='.trim($_POST['editId']).''; 
		$namevalue ='country="'.$countryId.'",name="'.$name.'",status="'.$status.'",currencyValue="'.$currencyValue.'" ,currencyCode="'.$currencyCode.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php
	} else{ 
		?>
		<script>
		parent.alert('Duplicate Currency not allowed.');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}

}

if(trim($_POST['action'])=='addedit_mealplan' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=($_POST['name']); 
$mealName = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', $name);
$status=clean($_POST['status']);
$modifyDate=time();
if($_POST['defaultMealplan']==1){
	$setDefault=1;
	$where='1'; 
	$namevalue ='setDefault="0"';
	$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where); 
}
else{
$setDefault=0;	
}
$res3 = GetPageRecord('id',_MEAL_PLAN_MASTER_,'name="'.$mealName.'" and id != "'.$_POST['editId'].'"');

if(mysqli_num_rows($res3)<1){
    $where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$mealName.'",setDefault="'.$setDefault.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where); 

?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php
}else{
    ?>
    	<script>
    	parent.alert('Meal Name already exists !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
}

 } 
  
  
  
  
  
if(trim($_POST['action'])=='addedit_sightseeingmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_transfermaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_TRANSFER_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_transfercategory' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$destinationId=clean($_POST['destinationId']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_TRANSFER_CATEGORY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if($_REQUEST['action']=='countrydelete'){  
 echo 'test';
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
 
generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=countrymaster&alt=3');
</script>
<?php
}
/////////////////////////////start state master//////////////////////
if(trim($_POST['action'])=='addedit_statemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['countryId'])!='' && trim($_POST['module'])!=''){ 
$countryId=clean($_POST['countryId']); 
$name=clean($_POST['name']);
$status=clean($_POST['status']); 
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_STATE_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This state already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",status="'.$status.'",countryId="'.$countryId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_STATE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }


if(trim($_REQUEST['action'])=='deletedivision'){  
 
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='deletestatus=1';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_DIVISION_MASTER_,$namevalue,$where); 
				generateLogs('Division','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=divisionmaster&alt=3');
	</script>
	<?php
}
if(trim($_REQUEST['action'])=='countrydelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
 
generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=countrymaster&alt=3');
</script>
<?php
}

if(trim($_POST['action'])=='addedit_statemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''  && trim($_POST['countryId'])!='' && trim($_POST['module'])!=''){ 
$countryId=clean($_POST['countryId']); 
$name=clean($_POST['name']); 
$status=clean($_POST['status']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",status="'.$status.'",countryId="'.$countryId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_REQUEST['action'])=='statedelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
 
generateLogs('state','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=statemaster&alt=3');
</script>
<?php
}
/////////////////////////////start city master//////////////////////
if(trim($_POST['action'])=='addedit_citymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['stateId'])!='' && trim($_POST['module'])!=''){ 
$stateId=clean($_POST['stateId']); 
$countryId=clean($_POST['countryId']);
$name=clean($_POST['name']);
$status=clean($_POST['status']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_CITY_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This city already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",status="'.$status.'",stateId="'.$stateId.'",countryId="'.$countryId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_CITY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_citymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!=''  && trim($_POST['stateId'])!='' && trim($_POST['module'])!=''){ 
$countryId=clean($_POST['countryId']); 
$name=clean($_POST['name']);
$stateId=clean($_POST['stateId']); 

$status=clean($_POST['status']);
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",status="'.$status.'",stateId="'.$stateId.'",countryId="'.$countryId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_REQUEST['action'])=='citydelete'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
 
generateLogs('city','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=citymaster&alt=3');
</script>
<?php
}
 /////////////////start phonetype master///////////////////
if(trim($_POST['action'])=='addedit_phonetype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_PHONE_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_phonetype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_PHONE_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
 /////////////////start emailtype master///////////////////
if(trim($_POST['action'])=='addedit_emailtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_EMAIL_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_emailtype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_EMAIL_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
 /////////////////start attachmenttype master///////////////////
if(trim($_POST['action'])=='addedit_attachmenttype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_ATTACHMENT_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_attachmenttype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_ATTACHMENT_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
 /////////////////start suppliertype master///////////////////
if(trim($_POST['action'])=='addedit_suppliertype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_SUPPLIERS_TYPE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_suppliertype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_SUPPLIERS_TYPE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
 /////////////////start querydestination master///////////////////
if(trim($_POST['action'])=='addedit_querydestination' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){
$name=clean($_POST['name']);
		$status=clean($_POST['status']);
		$description=mysqli_real_escape_string(db(),$_POST['description22']);
		$countryId=clean($_POST['countryId']);
		$stateIddest=clean($_POST['stateIddest']);
		$gradeId=clean($_POST['gradeId']);

		// additionalInfo,weatherinfo
		$additionalInfo=clean($_POST['additionalInfo']);
		$weatherinfo=clean($_POST['weatherinfo']);

		$setDefault=clean($_POST['setDefault']);
		$dateAdded=time();
		

		$where='name="'.$name.'" and deletestatus=0';
		$addnewyes = checkduplicate(_DESTINATION_MASTER_,$where);
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This Destiation already exist.');
		</script>
		<?php
	} else {

		if($setDefault==1){
			updatelisting(_DESTINATION_MASTER_,'setDefault=0','setDefault=1');
		}


		$namevalue ='name="'.$name.'",countryId="'.$countryId.'",stateId="'.$stateIddest.'",gradeId="'.$gradeId.'",otherlocation="'.$otherlocation.'",status="1",dateAdded="'.$dateAdded.'",description="'.$description.'",additionalInfo="'.$additionalInfo.'",weatherinfo="'.$weatherinfo.'",addedBy="'.$_SESSION['userid'].'",destinationImage="'.$file_name.'",setDefault="'.$setDefault.'"';
		$lastid = addlistinggetlastid(_DESTINATION_MASTER_,$namevalue);

		// For Destination Description view information
		$destdescriptionvalue ='lang_01="'.$description.'",destinationId="'.$lastid.'"';
		addlisting('destinationLanguageMaster',$destdescriptionvalue); 
		if($_REQUEST['queryDashboard']==='yes'){
			?>
			<script>
			parent.setupbox('showpage.crm?module=query&add=yes&alt=1');
			</script> 
			<?php
		}else{
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php }
	}
}


if(trim($_POST['action'])=='addedit_querydestination' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){
		$name=clean($_POST['name']);
		$status=clean($_POST['status']);
		$description=mysqli_real_escape_string(db(),$_POST['description22']);
		$countryId=clean($_POST['countryId']);
		$stateIddest=clean($_POST['stateIddest']);
		$gradeId=clean($_POST['gradeId']);
		$setDefault=clean($_POST['setDefault']);
		// additionalInfo,weatherinfo
		$additionalInfo=clean($_POST['additionalInfo']);
		$weatherinfo=clean($_POST['weatherinfo']);
		$modifyDate=time();
	
	
	if($setDefault==1){
		updatelisting(_DESTINATION_MASTER_,'setDefault=0','setDefault=1');
	}

	$where='id="'.$_POST['editId'].'"';
	$namevalue ='name="'.$name.'",countryId="'.$countryId.'",stateId="'.$stateIddest.'",gradeId="'.$gradeId.'",otherlocation="'.$otherlocation.'",status="'.$status.'",modifyDate="'.$modifyDate.'",description="'.$description.'",additionalInfo="'.$additionalInfo.'",weatherinfo="'.$weatherinfo.'",modifyBy="'.$_SESSION['userid'].'",destinationImage="'.$file_name.'",setDefault="'.$setDefault.'"';
	$update = updatelisting(_DESTINATION_MASTER_,$namevalue,$where);
	// for decription linking 
	if($update=='yes'){
		$destdesc = GetPageRecord('*','destinationLanguageMaster','destinationId="'.$_POST['editId'].'"');
		if(mysqli_num_rows($destdesc)>0){
	
			updatelisting('destinationLanguageMaster','lang_01="'.$description.'"','destinationId="'.$_POST['editId'].'"'); 
		}else{
	
			$namedestdsc ='lang_01="'.$description.'",destinationId="'.$_POST['editId'].'"';
			addlisting('destinationLanguageMaster',$namedestdsc); 
		}
	}
	
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script>
	<?php 
}






// started sec query form add destination
if(trim($_REQUEST['action'])=='addedit_querydestinationFromQuery'  && trim($_REQUEST['name'])!=''){ 
	
	echo $name=clean($_REQUEST['name']); 
	
	
	
	
	echo $countryId=clean($_REQUEST['countryId']);
	
	$dateAdded=time();
	
	
	$where='name="'.$name.'" and deletestatus=0';  
	$addnewyes = checkduplicate(_DESTINATION_MASTER_,$where); 
	if($addnewyes=='yes'){
	?>
	<script>
	parent.$('#pageloader').hide();
	parent.$('#pageloading').hide();
	alert('This Destiation already exist.');
	</script>
	<?php
	} else {
	$namevalue ='name="'.$name.'",countryId="'.$countryId.'",status="1",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
	$lastid = addlistinggetlastid(_DESTINATION_MASTER_,$namevalue); 
	
	
		?>
		<script>
			alert("Destination Added..!");
			generateQueryDay_function();
			masters_alertspopupopenClose();
		// parent.setupbox('showpage.crm?module=query&add=yes&alt=1');
		
		</script> 
		<?php

}
}
// Ended sec query form add destination







//Hotel Category Master 
if(trim($_POST['action'])=='addedit_hotelCategory' && trim($_POST['editId'])=='' && trim($_POST['hotelCategory'])!='' && trim($_POST['module'])!=''){ 
 	$status=clean($_POST['status']); 
	$hotelCategory=clean($_POST['hotelCategory']); 
	$uploadKeyword=clean($_POST['uploadKeyword']);
	$proposalCategory=clean($_POST['proposalCategory']);
	$dateAdded=time();
	if(mysqli_num_rows(GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,' 1 and hotelCategory='.$hotelCategory.'  and deletestatus=0')) < 1){ 
		$namevalue ='status="'.$status.'",hotelCategory="'.$hotelCategory.'",uploadKeyword="'.$uploadKeyword.'",proposalCategory="'.$proposalCategory.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting(_HOTEL_CATEGORY_MASTER_,$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}
} 
if(trim($_POST['action'])=='addedit_hotelCategory' && trim($_POST['editId'])!='' && trim($_POST['hotelCategory'])!='' && trim($_POST['module'])!=''){ 
	$hotelCategory=clean($_POST['hotelCategory']); 
	$status=clean($_POST['status']);
	$uploadKeyword=clean($_POST['uploadKeyword']);
	$proposalCategory=clean($_POST['proposalCategory']);
	$modifyDate=time();
	 
	if(mysqli_num_rows(GetPageRecord('*',_HOTEL_CATEGORY_MASTER_,'id!='.$_POST['editId'].' and hotelCategory='.$hotelCategory.'  and deletestatus=0')) < 1){ 

		$where='id='.$_POST['editId'].''; 
		$namevalue ='status="'.$status.'",hotelCategory="'.$hotelCategory.'",uploadKeyword="'.$uploadKeyword.'",proposalCategory="'.$proposalCategory.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting(_HOTEL_CATEGORY_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}
}

// Hotel Type
if(trim($_POST['action'])=='addedit_hotelType' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$uploadKeyword=clean($_POST['uploadKeyword']);
	$proposalPriority=clean($_POST['proposalPriority']);
	
	$status=clean($_POST['status']);  
	$dateAdded=time();
	if(mysqli_num_rows(GetPageRecord('*',_HOTEL_TYPE_MASTER_,' 1 and name="'.$name.'"  and deletestatus=0')) < 1){ 
		$namevalue ='name="'.$name.'",uploadKeyword="'.$uploadKeyword.'",proposalPriority="'.$proposalPriority.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting(_HOTEL_TYPE_MASTER_,$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}

} 
if(trim($_POST['action'])=='addedit_hotelType' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$uploadKeyword=clean($_POST['uploadKeyword']);
	$proposalPriority=clean($_POST['proposalPriority']);
	$status=clean($_POST['status']); 
	$modifyDate=time();
	if(mysqli_num_rows(GetPageRecord('*',_HOTEL_TYPE_MASTER_,'id!='.$_POST['editId'].' and name="'.trim($name).'" and deletestatus=0')) < 1){ 
		$where='id='.$_POST['editId'].''; 
		echo $namevalue ='name="'.$name.'",uploadKeyword="'.$uploadKeyword.'",proposalPriority="'.$proposalPriority.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting(_HOTEL_TYPE_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}
}
// Grade Master 
if(trim($_POST['action'])=='addedit_grademaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$designation=clean($_POST['designation']);
	$tier1=clean($_POST['tier1']);
	$tier2=clean($_POST['tier2']);
	$tier3=clean($_POST['tier3']);
	
	$status=clean($_POST['status']);  
	$dateAdded=time();
	if(mysqli_num_rows(GetPageRecord('*','gradeMaster',' 1 and name="'.$name.'"  and deletestatus=0')) < 1){ 
		$namevalue ='name="'.$name.'",designation="'.$designation.'",tier1="'.$tier1.'",tier2="'.$tier2.'",tier3="'.$tier3.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting('gradeMaster',$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}
	
} 
if(trim($_POST['action'])=='addedit_grademaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$designation=clean($_POST['designation']);
	$tier1=clean($_POST['tier1']);
	$tier2=clean($_POST['tier2']);
	$tier3=clean($_POST['tier3']);
	$status=clean($_POST['status']); 
	$modifyDate=time();
	if(mysqli_num_rows(GetPageRecord('*','gradeMaster','id!='.$_POST['editId'].' and name="'.trim($name).'" and deletestatus=0')) < 1){ 
		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$name.'",designation="'.$designation.'",tier1="'.$tier1.'",tier2="'.$tier2.'",tier3="'.$tier3.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting('gradeMaster',$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.alert('Duplicate entry not allowed!');
		</script> 
		<?php 
	}
}

 /////////////////start tourtype master///////////////////
if(trim($_POST['action'])=='addedit_tourtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();

	// new code added duplicate added
	$rsr=GetPageRecord('*',_TOUR_TYPE_MASTER_,'name="'.$name.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('This Tour Type Name Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }else{
		$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",status="'.$status.'" ,addedBy="'.$_SESSION['userid'].'"';
		if(trim($_POST['editId']) < 1){
            $adds = addlisting(_TOUR_TYPE_MASTER_,$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting(_TOUR_TYPE_MASTER_,$namevalue,$where); 
            $msg = 2;
        }
        ?>
		<script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
		}
	} 

	

	

	if(trim($_POST['action'])=='addedit_tourtype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$modifyDate=time();
	
	
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting(_TOUR_TYPE_MASTER_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php }




//////////////////////started expense head master code //////////////////////

 if(trim($_POST['action'])=='addedit_expenseHead' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();

		 $namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",status="'.$status.'" ,addedBy="'.$_SESSION['userid'].'"';
		// exit;
		if(trim($_POST['editId']) < 1){
            $adds = addlisting('expenseHeadMaster',$namevalue); 
            $msg = 1;
        }
        ?>
		<script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
		// }
	} 


	
	if(trim($_POST['action'])=='addedit_expenseHead' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$modifyDate=time();
	
	
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting('expenseHeadMaster',$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php }


// ///////////////////ended expense head master code ///////////////////////



//////////////////////started expense Type master code //////////////////////

if(trim($_POST['action'])=='addedit_expenseType' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	
	// $countryId=clean($_POST['countryId']); 

	$expenseHeadId=clean($_POST['expenseHeadId']);
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();

		echo $namevalue ='expenseHeadId="'.$expenseHeadId.'",name="'.$name.'",dateAdded="'.$dateAdded.'",status="'.$status.'" ,addedBy="'.$_SESSION['userid'].'"';
	
		if(trim($_POST['editId']) < 1){
            $adds = addlisting('expenseTypeMaster',$namevalue); 
            $msg = 1;
        }
        ?>
		<script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
	} 

	

	

	if(trim($_POST['action'])=='addedit_expenseType' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
		$expenseHeadId=clean($_POST['expenseHeadId']);
		$name=clean($_POST['name']); 
		$status=clean($_POST['status']); 
		$modifyDate=time();
	
	
	$where='id='.$_POST['editId'].''; 
	$namevalue ='expenseHeadId="'.$expenseHeadId.'",name="'.$name.'",modifyDate="'.$modifyDate.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting('expenseTypeMaster',$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php }

if($_REQUEST['action']=='deleteExpenseType'){  
		
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('expenseTypeMaster',$namevalue,$where); 
	 
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=expenseType&alt=3');
	</script>
	<?php
	}

	if($_REQUEST['action']=='deleteExpenseHead'){  
		
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('expenseHeadMaster',$namevalue,$where); 
		 
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=expenseHead&alt=3');
		</script>
		<?php
		}


// ///////////////////ended expense Type master code ///////////////////////


 /////////////////start amenities master///////////////////
 if(trim($_POST['action'])=='addedit_amenities' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();

	


	if(!empty($_FILES['amenityImage']['name'])){  
		$amenityimgName = str_replace(" ","_",trim($_FILES['amenityImage']['name']));
		$file_name=time().$amenityimgName;  
		copy($_FILES['amenityImage']['tmp_name'],"packageimages/".$file_name);
		$AmenityIMGName=$file_name; 
	}
	

	if($_POST['DefaultAmenity']==1){
		$DefaultAmenity=1;
		// $where='1'; 
		// $namevalue ='DefaultAmenity="0"';
		// $update = updatelisting('amenitiesMaster',$namevalue,$where); 
	}

	else{
	$DefaultAmenity=0;	
	}

	//---------------------

	// $duplicateres = GetPageRecord('*','amenitiesMaster','name="'.$name.'"');
	// if(mysqli_num_rows($duplicateres)>0){
	// 	?>
	// 	<script>
	// 		alert("Amenities Name already Exist!");
	// 		parent.$('#pageloader').hide();
	// 	parent.$('#pageloading').hide();
	// 	</script>
		
	// 	<?php
	// 	exit();
	// }else{

	
// ----------------

	$rsr=GetPageRecord('*','amenitiesMaster','name="'.$name.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
		?>
		<script>
		parent.alert('Amenities Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php 
		exit(0);
		
		}else{
			$namevalue ='name="'.$name.'",status="'.$status.'",image="'.$AmenityIMGName.'",defaultAmenity="'.$DefaultAmenity.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$adds = addlisting(_AMENITIES_MASTER_,$namevalue); 
			?>
			<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
			</script> 
			<?php
		}
	
	
	} 

	

	if(trim($_POST['action'])=='addedit_amenities' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);
	$status=clean($_POST['status']);  
	$amenityImage=clean($_POST['amenityImage']);  
	$modifyDate=time();
	
	
		
	if(!empty($_FILES['amenityImage']['name'])){  
		$file_name=time().$_FILES['amenityImage']['name'];  
		copy($_FILES['amenityImage']['tmp_name'],"packageimages/".$file_name);
		$AmenityIMGName=$file_name; 
	}else{ 
		$AmenityIMGName=$_REQUEST['oldamenityImage'];
	}
	if($_POST['DefaultAmenity']==1){
		$DefaultAmenity=1;
		// $where='1'; 
		// $namevalue ='DefaultAmenity="0"';
		// $update = updatelisting('amenitiesMaster',$namevalue,$where); 
	}
	else{
	$DefaultAmenity=0;	
	}
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",status="'.$status.'",image="'.$AmenityIMGName.'",defaultAmenity="'.$DefaultAmenity.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting(_AMENITIES_MASTER_,$namevalue,$where); 
	?>
	
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php }
 /////////////////start roomtype master///////////////////
if(trim($_POST['action'])=='addedit_roomtype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
	$maxoccupancy=clean($_POST['maxoccupancy']); 
	$bedding=clean($_POST['bedding']);
	$size=clean($_POST['size']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();
     
	$rsr=GetPageRecord('*',_ROOM_TYPE_MASTER_,'name="'.$name.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Room Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }
    else{
        $namevalue ='name="'.$name.'",maxoccupancy="'.$maxoccupancy.'",bedding="'.$bedding.'",size="'.$size.'",dateAdded="'.$dateAdded.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId']) < 1){
            $adds = addlisting(_ROOM_TYPE_MASTER_,$namevalue); 
            $msg = 1;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
} 


// Started Duplicate room type and edit 
if(trim($_POST['action'])=='addedit_roomtype'  && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
	$maxoccupancy=clean($_POST['maxoccupancy']); 
	$bedding=clean($_POST['bedding']);
	$size=clean($_POST['size']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();
  
	if(mysqli_num_rows(GetPageRecord('*',_ROOM_TYPE_MASTER_,'id!='.$_POST['editId'].' and name="'.trim($name).'" and deletestatus=0')) < 1){ 
		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$name.'",maxoccupancy="'.$maxoccupancy.'",bedding="'.$bedding.'",size="'.$size.'",dateAdded="'.$dateAdded.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"';   
		$update = updatelisting(_ROOM_TYPE_MASTER_,$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php 
	}else{
		?>
		<script>
		parent.alert('Room Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		
		</script> 
		<?php 
	}
} 

// Ended Duplicate room type and edit 
 
if(trim($_POST['action'])=='addedit_transferType' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();
     
	$rsr=GetPageRecord('*','transferTypeMaster','name="'.$name.'" '); 
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Transfer Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }
    else{
        $namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId']) < 1){
            $adds = addlisting('transferTypeMaster',$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('transferTypeMaster',$namevalue,$where); 
            $msg = 2;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
} 


// start payment type master add sec.
if(trim($_POST['action'])=='addedit_PaymentType' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();
     
	$rsr=GetPageRecord('*','paymentTypeMaster','name="'.$name.'" '); 
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Payment Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }
    else{
        $namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId']) < 1){
            $adds = addlisting('paymentTypeMaster',$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('paymentTypeMaster',$namevalue,$where); 
            $msg = 2;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
} 
// ended payment type master add sec.


// deactive sec satrted payment type master

if($_REQUEST['action']=='deletePaymentType'){ 
 
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('paymentTypeMaster',$namevalue,$where); 
	 
	generateLogs('paymentTypeMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=PaymentType&alt=3');
	</script>
	<?php
	} 
// deactive sec ended payment type master 







//delete trnsfer type
if($_REQUEST['action']=='deletetransfertype'){ 
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('transferTypeMaster',$namevalue,$where); 
 
generateLogs('transferTypeMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=transferType&alt=3');
</script>
<?php
}

//delete lead source
if($_REQUEST['action']=='deleteleadsource'){ 


 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('leadssourceMaster',$namevalue,$where); 
 
generateLogs('leadssourceMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=leadsource&alt=3');
</script>
<?php
}





///////////guidemail

if($_REQUEST['action']=='emailt_master'){ 

$namevalue ='checkstatus="0"';  
$where=' 1 ';  
$update = updatelisting('tbl_guidemaster',$namevalue,$where);
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='checkstatus="1"';  
$where='id="'.$ansval.'"';  
$update = updatelisting('tbl_guidemaster',$namevalue,$where); 
 
} } } 
?>
<script>
parent.alertspopupopen('action=sendmailtoclientguides');
//parent.setupbox('showpage.crm?module=leadsource&alt=3');
</script>
<?php
}
///////////////////////delete state////////////////////
if($_REQUEST['action']=='deletestate'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_STATE_MASTER_,$namevalue,$where); 
 
generateLogs(_STATE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=statemaster&alt=3');
</script>
<?php
}
if($_REQUEST['action']=='deletecity'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_CITY_MASTER_,$namevalue,$where); 
 
generateLogs(_CITY_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=citymaster&alt=3');
</script>
<?php
}
///////////////////////delete phone////////////////////
if($_REQUEST['action']=='deletephone'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PHONE_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs(_PHONE_TYPE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=phonetype&alt=3');
</script>
<?php
}
///////////////////////delete amenities////////////////////
if($_REQUEST['action']=='deleteamenities'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_AMENITIES_MASTER_,$namevalue,$where); 
 
generateLogs(_AMENITIES_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=amenities&alt=3');
</script>
<?php
}
///////////////////////delete amenities////////////////////
if($_REQUEST['action']=='deleteemil'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_EMAIL_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs(_EMAIL_TYPE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=emailtype&alt=3');
</script>
<?php
}
///////////////////////delete attachment////////////////////
if($_REQUEST['action']=='deleteattachment'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_ATTACHMENT_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs(_ATTACHMENT_TYPE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=attachmenttype&alt=3');
</script>
<?php
}
///////////////////////delete supplier////////////////////
if($_REQUEST['action']=='deletesupplier'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_SUPPLIERS_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs(_SUPPLIERS_TYPE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=suppliertype&alt=3');
</script>
<?php
}
///////////////////////delete querydestination////////////////////
if($_REQUEST['action']=='deletequerydestination'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_DESTINATION_MASTER_,$namevalue,$where); 
 
generateLogs(_DESTINATION_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=querydestination&alt=3');
</script>
<?php
}
//Hotel Category
if($_REQUEST['action']=='delete_hotelCategory'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
 		for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
  
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_HOTEL_CATEGORY_MASTER_,$namevalue,$where);  
				generateLogs(_HOTEL_CATEGORY_MASTER_,'delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo trim($_REQUEST['module']);?>&alt=3');
	</script>
	<?php
} 

//Hotel Type
if($_REQUEST['action']=='delete_hotelType'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
 		for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
  
				$namevalue ='deletestatus=1';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_HOTEL_TYPE_MASTER_,$namevalue,$where); 
				 
				generateLogs(_HOTEL_TYPE_MASTER_,'delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo trim($_REQUEST['module']);?>&alt=3');
	</script>
	<?php
} 

//Grade Master
if($_REQUEST['action']=='delete_grademaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
 		for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
  
				$namevalue ='deletestatus=1';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting('gradeMaster',$namevalue,$where); 
				 
				generateLogs('gradeMaster','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo trim($_REQUEST['module']);?>&alt=3');
	</script>
	<?php
} 

///////////////////////delete language////////////////////
if($_REQUEST['action']=='delete_language_'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting('tbl_languagemaster',$namevalue,$where); 
				generateLogs('tbl_languagemaster','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=languagemaster&alt=3');
	</script>
	<?php
} 
///////////////////////delete tourtype////////////////////
if($_REQUEST['action']=='deletetourtype'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_TOUR_TYPE_MASTER_,$namevalue,$where); 
				generateLogs(_TOUR_TYPE_MASTER_,'delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	 parent.setupbox('showpage.crm?module=tourtype&alt=3');
	</script>
	<?php
} 
///////////////////////delete roomtype////////////////////
if($_REQUEST['action']=='deleteroomtype'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_ROOM_TYPE_MASTER_,$namevalue,$where); 
 
generateLogs(_ROOM_TYPE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=roomtype&alt=3');
</script>
	<?php
} 

if($_REQUEST['action']=='deleteroomMaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('roomMaster',$namevalue,$where); 
	 
	generateLogs('roomMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=roomMaster&alt=3');
	</script>
		<?php
	} 
///////////////////////delete GST Masters////////////////////
if($_REQUEST['action']=='deletegstmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('gstMaster',$namevalue,$where); 
 
generateLogs('gstMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=gstmaster&alt=3');
</script>




	<?php
} 
//delete hotel gallery
if($_REQUEST['action']=='deleteGalleryPhoto'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				// $namevalue ='deletestatus=1';  
				$where=' id="'.$ansval.'" ';  
				$update = deleteRecord('imageGallery',$where); 
				generateLogs('imageGallery','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['backpage'];?>&alt=3');
	</script>
	<?php
}  

///////////////////////delete entrance////////////////////
if($_REQUEST['action']=='deleteinterencemaster'){  
$check_list=$_REQUEST['check_list'];
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$namevalue,$where); 
 
generateLogs(_PACKAGE_BUILDER_ENTRANCE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=entrancemaster&alt=3');
</script>

<?php
}

///////////////////////delete hotelchain////////////////////
if($_REQUEST['action']=='deleteHotelChain'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('chainhotelmaster',$namevalue,$where); 
 
generateLogs('chainhotelmaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=HotelChainMaster&alt=3');
</script>

<?php
}
///////////////////////delete Airline////////////////////
if($_REQUEST['action']=='delete_packageairlinemaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_BUILDER_AIRLINES_MASTER_,$namevalue,$where); 
 
generateLogs(_PACKAGE_BUILDER_AIRLINES_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=packageairlinemaster&alt=3');
</script>
<?php
}
///////////////////////delete Train Master////////////////////
if($_REQUEST['action']=='delete_trainmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_BUILDER_TRAINS_MASTER_,$namevalue,$where); 
 
generateLogs(_PACKAGE_BUILDER_TRAINS_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=trainmaster&alt=3');
</script>
<?php
}
///////////////////////delete Other Activity Master////////////////////
if($_REQUEST['action']=='delete_otherActivityMaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$namevalue,$where); 
 
generateLogs(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=otherActivityMaster&alt=3');
</script>
<?php
}
///////////////////////delete Vehicle brand master////////////////////
if($_REQUEST['action']=='deletevehiclebrand'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"'; 
 
$update = updatelisting('vehicleBrand',$namevalue,$where); 
 
generateLogs('vehicleBrand','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=vehiclebrandmaster&alt=3');

</script>
<?php
}
///////////////////////delete Driver Master////////////////////
if($_REQUEST['action']=='deletedrivermaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_DRIVER_MASTER_MASTER_,$namevalue,$where); 
 
generateLogs(_DRIVER_MASTER_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=drivermaster&alt=3');
</script>
<?php
}
///////////////////////delete Fleet Master////////////////////
if($_REQUEST['action']=='deletefleetmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('vehicleFleetMaster',$namevalue,$where); 
 
generateLogs('vehicleFleetMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=fleetmaster&alt=3');
</script>
<?php
}
///////////////////////delete Guide Master////////////////////
if($_REQUEST['action']=='delete_guidemaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_GUIDE_MASTER_,$namevalue,$where); 
 
generateLogs(_GUIDE_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=guidemaster&alt=3');
</script>
<?php
}
///////////////////////delete Guide subcat Master////////////////////
if($_REQUEST['action']=='delete_guidesubcatmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_GUIDE_SUB_CAT_MASTER_,$namevalue,$where); 
 
generateLogs(_GUIDE_SUB_CAT_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=guidesubcatmaster&alt=3');
</script>
<?php
}
///////////////////////delete Guide subcat Master////////////////////
if($_REQUEST['action']=='deletesubjectmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('iti_subjectmaster',$namevalue,$where); 
 
generateLogs('iti_subjectmaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=subjectmaster&alt=3');
</script>

<?php
} 
///////////////////////delete inbound meal plan////////////////////
if($_REQUEST['action']=='delete_inboundmealplanmaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_INBOUND_MEALPLAN_MASTER_,$namevalue,$where); 
				generateLogs(_INBOUND_MEALPLAN_MASTER_,'delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=inboundmealplanmaster&alt=3');
	</script>
	<?php
} 

if($_REQUEST['action']=='deletecurrencymaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) 
		{
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){    
				 $checkAva = " select id from "._QUERY_CURRENCY_MASTER_." where id in ( select currencyId from dmcentranceRate where status=1  and currencyId = '".$ansval."' ) or  id in ( select currencyId from dmcGuidePorterRate where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from dmcotherActivityRate where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from dmcroomTariff where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from dmcRestaurantsMealPlanRate where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from dmctransferRate where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from packageBuilderEnrouteMaster where status=1  and currencyId = '".$ansval."'  ) or  id in ( select currencyId from extraQuotation where status=1  and currencyId = '".$ansval."'  ) ";
				$checkAva2 = mysqli_query (db(),$checkAva) or die(mysqli_error(db()));
 				if( mysqli_num_rows($checkAva2) < 1){
					$namevalue ='status=0';  
					$where='id="'.$ansval.'"';  
					$update = updatelisting(_QUERY_CURRENCY_MASTER_,$namevalue,$where); 
					
					generateLogs(_QUERY_CURRENCY_MASTER_,'delete',$ansval);
				}
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=currencymaster&alt=3');
	</script>
	<?php
}
if($_REQUEST['action']=='delete_mealplan'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting(_MEAL_PLAN_MASTER_,$namevalue,$where);
		generateLogs(_MEAL_PLAN_MASTER_,'delete',$ansval);
	} } } 
?>
<script>
parent.setupbox('showpage.crm?module=mealplan&alt=3');
</script>
<?php
}
if($_REQUEST['action']=='deleterestaurantsmealplan'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('restaurantsMealPlanMaster',$namevalue,$where);
generateLogs('restaurantsMealPlanMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=restaurantsmealplan&alt=3');
</script>
 
<?php
}
if($_REQUEST['action']=='deletevehiclemaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_VEHICLE_MASTER_MASTER_,$namevalue,$where); 
 
generateLogs(_VEHICLE_MASTER_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=vehiclemaster&alt=3');
</script>
<?php
}
// Delete Vehicle Type master
if($_REQUEST['action']=='deletevehicleTypemaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('vehicleTypeMaster',$namevalue,$where); 
	 
	generateLogs('vehicleTypeMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=vehicleTypeMaster&alt=3');
	</script>
	<?php
	}
	
//delete country////////////////////
if($_REQUEST['action']=='deletecountry'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting(_COUNTRY_MASTER_,$namevalue,$where); 
	
	generateLogs(_COUNTRY_MASTER_,'delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=countrymaster&alt=3');
	</script>
	<?php
}

if($_REQUEST['action']=='deletesightseeingmaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_SIGHTSEEING_MASTER_MASTER_,$namevalue,$where); 
 
generateLogs(_SIGHTSEEING_MASTER_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=sightseeingmaster&alt=3');
</script>
<?php
}
if($_REQUEST['action']=='deletetransfermaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_TRANSFER_MASTER_,$namevalue,$where); 
 
generateLogs(_TRANSFER_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=transfermaster&alt=3');
</script>
<?php
}
if($_REQUEST['action']=='deletetransfercategory'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_TRANSFER_CATEGORY_MASTER_,$namevalue,$where); 
 
generateLogs(_TRANSFER_CATEGORY_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=transfercategory&alt=3');
</script>
<?php
}
if($_REQUEST['action']=='deleteextraquotation'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   

$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_EXTRA_QUOTATION_MASTER_,$namevalue,$where); 

generateLogs(_EXTRA_QUOTATION_MASTER_,'delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=extraquotation&alt=3');
</script>
<?php
}

if($_REQUEST['action']=='delete_packageTransportmaster' || $_REQUEST['action']=='delete_packagetransfermaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){    
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue,$where); 
				generateLogs(_PACKAGE_BUILDER_TRANSFER_MASTER,'delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo trim($_REQUEST['module']); ?>&alt=3');
	</script>
	<?php
}

if(trim($_POST['action'])=='currencyconversion' && trim($_POST['editId'])=='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyValue'])!=''){ 
$currencyFrom=clean($_POST['currencyFrom']); 
$currencyTo=clean($_POST['currencyTo']); 
$currencyValue=clean($_POST['currencyValue']);  
$dateAdded=time();
$where='currencyFrom="'.$currencyFrom.'" and currencyTo="'.$currencyTo.'" ';  
$addnewyes = checkduplicate(_CURRENCY_CONVERSION_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This Currency already exist.');
</script>
<?php
} else {
$namevalue ='currencyFrom="'.$currencyFrom.'",currencyTo="'.$currencyTo.'",currencyValue="'.$currencyValue.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_CURRENCY_CONVERSION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='currencyconversion' && trim($_POST['editId'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyFrom'])!='' && trim($_POST['currencyValue'])!=''){  
 $currencyFrom=clean($_POST['currencyFrom']); 
$currencyTo=clean($_POST['currencyTo']); 
$currencyValue=clean($_POST['currencyValue']);  
$dateAdded=time();
  
$namevalue ='currencyFrom="'.$currencyFrom.'",currencyTo="'.$currencyTo.'",currencyValue="'.$currencyValue.'",modifyDate="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'"';  
$where='id="'.$_POST['editId'].'"';  
$update = updatelisting(_CURRENCY_CONVERSION_MASTER_,$namevalue,$where);  
 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php
}
if($_REQUEST['action']=='deletecurrencConversionymaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 
$sql_del="delete from "._CURRENCY_CONVERSION_MASTER_."  where id='".$ansval."'"; 
mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
 
generateLogs('currencconversion','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=3');
</script>
<?php
}
if(trim($_POST['action'])=='addedit_packagetheme' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$dateAdded=time();
	$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
	$adds = addlisting(_PACKAGE_THEME_MASTER_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php 
}
if(trim($_POST['action'])=='addedit_packagetheme' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$modifyDate=time();
	 
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting(_PACKAGE_THEME_MASTER_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
}

// CRUISE MASTER
if(trim($_POST['action'])=='addedit_cruisecompanymaster' && trim($_POST['cruiseName'])!='' && trim($_POST['module'])!=''){ 

	$cruiseName=clean($_POST['cruiseName']);   
	$location = implode(',', $_POST['location']);
	$ferrywebsite=clean($_POST['cruisewebsite']); 
	$selfsupplier=clean($_POST['selfsupplier']); 
	$contactperson=clean($_POST['contactperson']); 
	$phone=clean($_POST['phone']); 
	$email=clean($_POST['email']); 
	$division=clean($_POST['division']); 
	$designation=clean($_POST['designation']); 
	$status=clean($_POST['status']); 

	$gstNumber=clean($_POST['gstNumber']); 
	$fullAddress=clean($_POST['fullAddress']); 
	$pinCodeC=clean($_POST['pinCodeC']); 
	$cityIdC=clean($_POST['cityIdC']); 
	$stateIdC=clean($_POST['stateIdC']); 
	$countryIdC=clean($_POST['countryIdC']); 

	$dateAdded=time();
	// check the otheractivityName and otheractivityCity variable 
    if($_REQUEST['editId'] == ''){
        $wherecheck = 'name="'.$cruiseName.'"';
    }else{
        $wherecheck = 'name="'.$cruiseName.'" and id != "'.$_REQUEST['editId'].'"';
    }	
	$rs3=GetPageRecord('id',_CRUISE_COMPANY_,$wherecheck);
	if(mysqli_num_rows($rs3)<1){
		if( trim($_POST['editId'])=='' ){
	    	
	    	$namevalue ='name="'.$cruiseName.'",gst="'.$gstNumber.'",address="'.$fullAddress.'",pinCode="'.$pinCodeC.'",countryId="'.$countryIdC.'",stateId="'.$stateIdC.'",cityId="'.$cityIdC.'",status="'.$status.'", destinationId="'.$location.'", website="'.$ferrywebsite.'",selfSupplier="'.$selfsupplier.'",contactPerson="'.$contactperson.'",phone="'.$phone.'",email="'.$email.'",division="'.$division.'",designation="'.$designation.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

			$adds = addlisting(_CRUISE_COMPANY_,$namevalue); 
			$msg = 1;
			if($selfsupplier=='1'){ 
				$dateAdded=time();
				$namevalue ='name="'.$cruiseName.'",aliasname="'.$cruiseName.'",destinationId="'.$location.'",contactPerson="'.$contactperson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',ferryType=10,paymentTerm=1,agreement=0'; 
				$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue); 

				$namevalue=$where="";
				if($lastId!=''){ 
					if($email!=''){ 
						$allvaluecontactperson ='contactPerson="'.$contactperson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
						addlisting('suppliercontactPersonMaster',$allvaluecontactperson);
					} 
				}	
			} 
		}else{
			$namevalue2 ='name="'.$cruiseName.'",gst="'.$gstNumber.'",address="'.$fullAddress.'",pinCode="'.$pinCodeC.'",countryId="'.$countryIdC.'",stateId="'.$stateIdC.'",cityId="'.$cityIdC.'",status="'.$status.'", destinationId="'.$location.'", website="'.$ferrywebsite.'",selfSupplier="'.$selfsupplier.'",contactPerson="'.$contactperson.'",phone="'.$phone.'",email="'.$email.'",division="'.$division.'",designation="'.$designation.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';

			$where='id='.$_POST['editId'].''; 
			$update = updatelisting(_CRUISE_COMPANY_,$namevalue2,$where); 
			$msg =2;
		}
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php 
	}else{
	    ?>
		<script>
		parent.alert('Cruise Company already Exist!!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}
} 


if(trim($_POST['action'])=='addedit_cruiseNameMaster' && trim($_POST['module'])!=''){
 
	$cruisecompany=clean($_POST['cruisecompany']); 
	$cruisecompany=clean($_POST['cruisecompany']); 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']); 

	if(!empty($_FILES['cruiseImage']['name'])){  
		$cruiseImage = str_replace(" ","_",trim($_FILES['cruiseImage']['name']));
		$file_name=time().$cruiseImage;  
		copy($_FILES['cruiseImage']['tmp_name'],"packageimages/".$file_name);
		// $cruiseImage=$file_name; 
	}else{
		$file_name = $_REQUEST['oldCruiseImage'];
	}

	$dateAdded=time();

	
	
	$where='id="'.$_POST['editId'].'"'; 
	if($_POST['editId']!=''){
		$namevalue ='name="'.$name.'",cruiseCompanyId="'.$cruisecompany.'",status="'.$status.'",image="'.$file_name.'",dateAdded="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting('cruiseNameMaster',$namevalue,$where); 
	}else{
		$namevalue ='name="'.$name.'",cruiseCompanyId="'.$cruisecompany.'",status="'.$status.'",image="'.$file_name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';  
		$adds = addlisting('cruiseNameMaster',$namevalue); 
	}

	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 


if(trim($_POST['action'])=='addedit_cabintypemaster' && trim($_POST['editId'])!='' && trim($_POST['cabinType'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['cabinType']); 
	$cruiseNameId=clean($_POST['cruiseNameId']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",cruiseNameId="'.$cruiseNameId.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';  
	$update = updatelisting(_CABIN_TYPE_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 

if(trim($_POST['action'])=='addedit_cabintypemaster' && trim($_POST['editId'])=='' && trim($_POST['cabinType'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['cabinType']); 
	$cruiseNameId=clean($_POST['cruiseNameId']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();

	$namevalue ='name="'.$name.'",cruiseNameId="'.$cruiseNameId.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
	$adds = addlisting(_CABIN_TYPE_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php 
} 
 
if(trim($_POST['action'])=='addedit_cruisetypemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!='' && trim($_POST['companyId'])!='0'){ 
	$name=clean($_POST['name']); 
	$companyId=clean($_POST['companyId']); 
	$dateAdded=time();
	$namevalue ='name="'.$name.'",companyId="'.$companyId.'"';  
	$adds = addlisting(_CRUISE_TYPE_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php 
} 


if(trim($_POST['action'])=='addedit_cruisetypemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!='' && trim($_POST['companyId'])!='0'){ 
	$name=clean($_POST['name']); 
	$companyId=clean($_POST['companyId']); 
	$dateAdded=time();
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",companyId="'.$companyId.'"';  
	$update = updatelisting(_CRUISE_TYPE_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 

if(trim($_POST['action'])=='addedit_cabincategorymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$status=clean($_POST['status']);  
	$dateAdded=time();
	$where='id="'.$_POST['editId'].'"'; 
	$namevalue ='name="'.$name.'",status="'.$status.'"';  
	$update = updatelisting(_CABIN_CATEGORY_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 
if(trim($_POST['action'])=='addedit_cabincategorymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$status=clean($_POST['status']);  
	$dateAdded=time();
	$namevalue ='name="'.$name.'",status="'.$status.'"';  
	
	$adds = addlisting(_CABIN_CATEGORY_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php 
} 


// FERRY MASTERS STARTS
// ======================= Ferry Class Master Start ========================
if(trim($_POST['action'])=='addedit_ferryClassmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$ferryStatus=clean($_POST['ferryStatus']);  
	$dateAdded=time();

	$rsr=GetPageRecord('*','ferryClassMaster','name="'.$name.'" ');
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Ferry Seat Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }
    else{
		$namevalue ='name="'.$name.'",status="'.$ferryStatus.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"'; 
		if(trim($_POST['editId']) < 1){
            $adds = addlisting('ferryClassMaster',$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('ferryClassMaster',$namevalue,$where); 
            $msg = 2;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }






	// $namevalue ='name="'.$name.'",status="'.$ferryStatus.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.$dateAdded.'"';  
	// $adds = addlisting('ferryClassMaster',$namevalue); 
	// ?>
	// <script>
	// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	// </script> 
	// <?php 
} 

if(trim($_POST['action'])=='addedit_ferryClassmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$ferryStatus=clean($_POST['ferryStatus']);  
	$dateAdded=time();
	$where='id='.$_POST['editId'].''; 
	$namevalue ='name="'.$name.'",status="'.$ferryStatus.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';  
	$update = updatelisting('ferryClassMaster',$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 

//================== Delete Ferry Class Master start and Ferry Class Master End  ==================
if($_REQUEST['action']=='deleteFerryClass'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){     
				  
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting('ferryClassMaster',$namevalue,$where); 
				 
				generateLogs('ferryClassMaster','delete',$ansval); 
			}
		}
	}
	?>
	<script>
	parent.setupbox('showpage.crm?module=ferryClassmaster&alt=3');
	</script>
	<?php
}

// Additional Hotel Master starts =================
if(trim($_POST['action'])=='addedit_additionalHotelMaster' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
    $otherdetail=clean($_POST['otherdetail']); 
    $imageadd=clean($_POST['imageadd']); 
    $status=clean($_POST['status']); 

	if(!empty($_FILES['imageadd']['name'])){  
		$imageadd = str_replace(" ","_",trim($_FILES['imageadd']['name']));
		$file_name=time().$imageadd;  
		copy($_FILES['imageadd']['tmp_name'],"packageimages/".$file_name);
		$imageaddName=$file_name; 
	}else{
		$imageaddName = $_REQUEST['imageaddold'];
	}

    $dateAdded=time();
     
	$rsr=GetPageRecord('*','additionalHotelMaster','name="'.$name.'" '); 
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Additional Hotel Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
    }
    else{
        $namevalue ='name="'.$name.'",image="'.$imageaddName.'",detail="'.$otherdetail.'",dateAdded="'.$dateAdded.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId']) < 1){
            $adds = addlisting('additionalHotelMaster',$namevalue); 
            $msg = 1;
        }else{
			$namevalue2 ='name="'.$name.'",image="'.$imageaddName.'",detail="'.$otherdetail.'",modifyDate="'.$dateAdded.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'"'; 
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('additionalHotelMaster',$namevalue2,$where); 
            $msg = 2;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
} 

//additional Hotel Master End ================


// ======================= Delete Ferry Class Master End and Ferry Company Master Start ========================

if(trim($_POST['action'])=='addedit_ferryCompanymaster'  && trim($_POST['ferryName'])!='' && trim($_POST['module'])!=''){ 

	$ferryName=clean($_POST['ferryName']);   
	$location = implode(',', $_POST['location']);
	$ferrywebsite=clean($_POST['ferrywebsite']); 
	$selfsupplier=clean($_POST['selfsupplier']); 
	$contactperson=clean($_POST['contactperson']); 
	$phone=clean(encode($_POST['phone'])); 
	$email=clean(encode($_POST['email'])); 
	$division=clean($_POST['division']); 
	$designation=clean($_POST['designation']); 
	$status=clean($_POST['status']); 
	$dateAdded=time();
	// check the otheractivityName and otheractivityCity variable 
    if($_REQUEST['editId'] == ''){
        $wherecheck = 'name="'.$ferryName.'"';
    }else{
        $wherecheck = 'name="'.$ferryName.'" and id != "'.$_REQUEST['editId'].'"';
    }	
	$rs3=GetPageRecord('id','ferryCompanyMaster',$wherecheck);
	if(mysqli_num_rows($rs3)<1){
		if( trim($_POST['editId'])=='' ){
	    	
	    	$namevalue ='name="'.$ferryName.'",status="'.$status.'", location="'.$location.'", website="'.$ferrywebsite.'",selfSupplier="'.$selfsupplier.'",contactPerson="'.$contactperson.'",phone="'.$phone.'",email="'.$email.'",division="'.$division.'",designation="'.$designation.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

			$adds = addlisting('ferryCompanyMaster',$namevalue); 
			$msg = 1;
			if($selfsupplier=='1'){ 
				$dateAdded=time();
				$namevalue ='name="'.$ferryName.'",aliasname="'.$ferryName.'",destinationId="'.$location.'",contactPerson="'.$contactperson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',ferryType=10,paymentTerm=1,agreement=0'; 
				$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue); 

				$namevalue=$where="";
				if($lastId!=''){ 
					if($email!=''){ 
						$allvaluecontactperson ='contactPerson="'.$contactperson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
						addlisting('suppliercontactPersonMaster',$allvaluecontactperson);
					} 
				}	
			} 
		}else{
			$namevalue2 ='name="'.$ferryName.'",status="'.$status.'", location="'.$location.'", website="'.$ferrywebsite.'",selfSupplier="'.$selfsupplier.'",contactPerson="'.$contactperson.'",phone="'.$phone.'",email="'.$email.'",division="'.$division.'",designation="'.$designation.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
			$where='id='.$_POST['editId'].''; 
			$update = updatelisting('ferryCompanyMaster',$namevalue2,$where); 
			$msg =2;
		}
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
		</script> 
		<?php 
	}else{
	    ?>
		<script>
		parent.alert('Ferry Company already Exist!!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}
} 
// ======================= Ferry Company Master End and Delete Ferry Company Master start========================

if($_REQUEST['action']=='deleteFerryCompany'){
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 	for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting('ferryCompanyMaster',$namevalue,$where); 
				generateLogs('ferryCompanyMaster','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=ferryCompanymaster&alt=3');
	</script>
	<?php
}

// ================= delete ferry price master End and Ferry name master start =========================
if(trim($_POST['action'])=='addedit_ferryMaster' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){
    $name=clean($_POST['name']); 
    $ferrycompany=clean($_POST['ferrycompany']); 
    $capacity=clean($_POST['capacity']); 
    $status=clean($_POST['status']); 
    $dateAdded=time();
     
	$rsr=GetPageRecord('*','ferryNameMaster','name="'.$name.'" '); 
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
        	parent.alert('Ferry Name Already Exist!');
        </script> 
        <?php 
    }
    else{

		if(!empty($_FILES['ferryImage']['name'])){  
			$ferryimgName = str_replace(" ","_",trim($_FILES['ferryImage']['name']));
			$file_name=time().$ferryimgName;  
			copy($_FILES['ferryImage']['tmp_name'],"packageimages/".$file_name);
			$FerryIMGName=$file_name; 
		}elseif(clean($_POST['oldferryImage'])!=''){
			$FerryIMGName=clean($_POST['oldferryImage']);
		}else{
			$FerryIMGName='';
		}



        $namevalue ='name="'.$name.'",ferryCompanyId="'.$ferrycompany.'",capacity="'.$capacity.'",dateAdded="'.$dateAdded.'",image="'.$FerryIMGName.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId']) < 1){
            $adds = addlisting('ferryNameMaster',$namevalue); 
            $msg = 1;
        }else{
			$namevalue2 ='name="'.$name.'",ferryCompanyId="'.$ferrycompany.'",capacity="'.$capacity.'",modifyDate="'.$dateAdded.'",image="'.$FerryIMGName.'",status="'.$status.'",modifyBy="'.$_SESSION['userid'].'"'; 
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('ferryNameMaster',$namevalue2,$where); 
            $msg = 1;
        }
        ?>
        <script>
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
} 
// ferry name master end delete ferry name master start ================
if($_REQUEST['action']=='deleteferryName'){
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('ferryNameMaster',$namevalue,$where); 
	 
	generateLogs('ferryNameMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=ferryMaster&alt=3');
	</script>
	<?php
} 



// ======================= Delete Ferry Company Master End and ferry Price Master start ========================
if(trim($_POST['action'])=='addedit_ferryPricemaster'  && $_POST['editId']=='' && trim($_POST['module'])=='ferryPricemaster'){ 

	 
			$ferryName=clean($_POST['ferryName']); 
			// $arrivalTime1=clean($_POST['arrivalTime']); 
			// $departureTime1=clean($_POST['departureTime']); 

			$arrivalTime1=$_POST['arrivalTime']; 
			$departureTime1=$_POST['departureTime']; 
			// $duration=clean($_POST['duration']); 
			
			$destinationList = implode(',', $_POST['destinationId']);
			$todestinationList = implode(',', $_POST['todestinationId']);  
			$ferryInformation=clean($_POST['ferryInformation']); 

			$status=clean($_POST['status']); 


			$dateAdded=time();

			// duplicate check action
			// $rsr=GetPageRecord('*','ferryPriceMaster','name="'.$ferryName.'" ');
			// $editresult=mysqli_num_rows($rsr);
			// if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
			// 	?>
			// 	<script>
			// 	parent.alert('Ferry Transfer Name Already Exist!');
			// 	parent.$('#pageloader').hide();
			// 	parent.$('#pageloading').hide();
			// 	exit();
			// 	</script> 
			// 	<?php 
				
			// }

			// else{

				// ferry Code genrated 
					$A = GetPageRecord('displayId','ferryPriceMaster','displayId>0 order by displayId desc');
					$ddata = mysqli_fetch_assoc($A);
					$displayId = $ddata['displayId']+1;

					$namevalue ='name="'.$ferryName.'",status="'.$status.'", destinationId="'.$destinationList.'", todestinationId="'.$todestinationList.'",information="'.$ferryInformation.'",arrivalTime="'.$arrivalTime.'",departureTime="'.$departureTime.'",image="'.$ferryimageName.'",deletestatus="'.$deletestatus.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",displayId="'.$displayId .'"';

					$lastId = addlistinggetlastid('ferryPriceMaster',$namevalue); 
				
					$msg = 1;
				
					foreach( $arrivalTime1 as $key => $value){
				
						$arrivalTime1 = $value;
						$departureTime2 = $departureTime1[$key];
						$allvalueferryTime ='ferrypriceId="'.$lastId.'",pickupTime="'.$arrivalTime1.'",dropTime="'.$departureTime2.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
						$add = addlisting('ferryServiceTiming',$allvalueferryTime);
					}
				
				?>
				
				<script>
				
				parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
				parent.$('#pageloader').hide();
				parent.$('#pageloading').hide();
				</script> 
				
				<?php
			// }
   
}


if(trim($_POST['action'])=='addedit_ferryPricemaster'  && $_POST['editId']!='' && trim($_POST['module'])=='ferryPricemaster'){ 

	$_REQUEST['editId'];

	$arrivalTime1=$_POST['arrivalTime']; 
	$departureTime1=$_POST['departureTime']; 
	
	$ferryName=clean($_POST['ferryName']); 

	// $arrivalTime=clean($_POST['arrivalTime']); 
	// $departureTime=clean($_POST['departureTime']); 
	$todestinationList = implode(',', $_POST['todestinationId']); 
	$destinationList = implode(',', $_POST['destinationId']); 

	$ferryInformation=clean($_POST['ferryInformation']); 

	$status=clean($_POST['status']); 

	// $ferryimage=clean($_POST['ferryimage']); 
	$dateAdded=time();






	$namevalue ='name="'.$ferryName.'",status="'.$status.'", destinationId="'.$destinationList.'",todestinationId="'.$todestinationList.'",information="'.$ferryInformation.'",arrivalTime="'.$arrivalTime.'",departureTime="'.$departureTime.'",image="'.$ferryimageName.'",deletestatus="'.$deletestatus.'",modifyBy="'.$_SESSION['userid'].'",modifyDate="'.$dateAdded.'"';
	
	$where='id="'.$_REQUEST['editId'].'"'; 

	$update = updatelisting('ferryPriceMaster',$namevalue,$where); 

	$msg = 2;

// $valuecont = '1';
	// 
	while($valuecont <= $_POST['ferryTimeCount']){
		$pickupTime=trim($_POST["pickupTime".$valuecont]);
		$dropTime=trim($_POST["dropTime".$valuecont]);
		$ferrytimeId=trim($_POST["ferrytimeId".$valuecont]);

		if(trim($_POST["ferrytimeId".$valuecont])!=''){
			$selecteee='*';
			$whereeee='id="'.$ferrytimeId.'"';
			$resee=GetPageRecord($selecteee,'ferryServiceTiming',$whereeee);
			$ferrytimecount=mysqli_num_rows($resee);
			if($ferrytimecount>0){
				while($upcpm=mysqli_fetch_array($resee)){
					$allvalueferryTime ='pickupTime="'.$pickupTime.'",dropTime="'.$dropTime.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
					$whereferryTimeid='id="'.$ferrytimeId.'"';
					$updateferrytime = updatelisting('ferryServiceTiming',$allvalueferryTime,$whereferryTimeid);
				}
			}

		}else{
			

			foreach( $arrivalTime1 as $key => $value){

				$arrivalTime1 = $value;
				$departureTime2 = $departureTime1[$key];
				$allvalueferryTime3 ='ferrypriceId="'.$_REQUEST['editId'].'",pickupTime="'.$arrivalTime1.'",dropTime="'.$departureTime2.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
				
				if($arrivalTime1!='' && $departureTime2!=''){
				$add = addlisting('ferryServiceTiming',$allvalueferryTime3);
				}
			}
			 
		}
		$valuecont++;
	}

	?>

	<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');

	</script> 

	<?php
}


// ======================= ferry Price Master End and delete ferry price master start ========================

if($_REQUEST['action']=='deleteFerryPrice'){
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){     
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('ferryPriceMaster',$namevalue,$where); 
		 
		generateLogs('ferryPriceMaster','delete',$ansval); 
	}}}
	?>
	<script>
	parent.setupbox('showpage.crm?module=ferryPricemaster&alt=3');
	</script>
	<?php
}


if($_REQUEST['action']=='deletepackagetheme'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_THEME_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=packagetheme&alt=3');
</script>
<?php
}

if($_REQUEST['action']=='deletepackagecruisecompany'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting(_CRUISE_COMPANY_,$namevalue,$where); 
	 
	// generateLogs('roomtype','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=cruisecompanymaster&alt=3');
	</script>
	<?php
	}
	
	if($_REQUEST['action']=='deleteCruiseName'){  
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('CruiseNameMaster',$namevalue,$where); 
		 
		generateLogs('roomtype','delete',$ansval);
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=cruiseNameMaster&alt=3');
		</script>
		<?php
		}

if($_REQUEST['action']=='deletepackagecruisetype'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 
$sql_del="delete from "._CRUISE_TYPE_."  where id='".$ansval."'"; 
mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cruisetypemaster&alt=3');
</script>
<?php
}

if($_REQUEST['action']=='deletecabintype'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('cabinTypeMaster',$namevalue,$where); 
	 
	generateLogs('roomtype','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=cabintypemaster&alt=3');
	</script>
	<?php
	}

	if($_REQUEST['action']=='deletecabincategory'){  
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting(_CABIN_CATEGORY_,$namevalue,$where); 
		 
		generateLogs('roomtype','delete',$ansval);
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=cabincategorymaster&alt=3');
		</script>
		<?php
	}

	if($_REQUEST['action']=='deletetraincabintype'){  
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting(_TRAIN_CABIN_TYPE_,$namevalue,$where); 
		 
		generateLogs('roomtype','delete',$ansval);
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=traincabintype&alt=3');
		</script>
		<?php
	}

if(trim($_POST['action'])=='addedit_inclusion' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();

$rs3=GetPageRecord('id',_PACKAGE_INCLUSION_MASTER_,'name="'.$name.'"');

if(mysqli_num_rows($rs3)<1){
   $namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_PACKAGE_INCLUSION_MASTER_,$namevalue);  
?>
<script>
 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php
}else{
     ?>
    	<script>
    	parent.alert('Package Name already exists !!');
    	parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
    	</script> 
    	<?php
}

?>
<script>
// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_inclusion' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 $rs3=GetPageRecord('id',_PACKAGE_INCLUSION_MASTER_,'name="'.$name.'" and id !="'.$_POST['editId'].'"');
 if(mysqli_num_rows($rs3)<1){
     $where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_PACKAGE_INCLUSION_MASTER_,$namevalue,$where);
?>
<script>
 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php
 }else{
     ?>
    	<script>
    	parent.alert('Package Name already exists !!');
    	parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
    	</script> 
    	<?php
 }
 
?>
<script>
// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if($_REQUEST['action']=='deleteinclusion'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_PACKAGE_INCLUSION_MASTER_,$namevalue,$where); 
 
generateLogs('roomtype','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=inclusion&alt=3');
</script>
<?php
}

 
// hotel started 1111

if(trim($_POST['action'])=='addedit_packagehotelmaster' && trim($_POST['editId'])=='' && trim($_POST['hotelName'])!=''){ 
	     
		$hotelName=clean($_POST['hotelName']); 
		$url=clean($_POST['url']); 
	
		$hotelCity=clean($_POST['hotelCity']); 

		$locality=clean($_POST['locality']); 
		$hotelChain=clean($_POST['hotelChain']); 
		$hotelchainname=clean($_POST['name']); 
		$showOnHome=clean($_POST['showOnHome']);  
		$hotelAddress=clean($_POST['hotelAddress']);  
		$hotelCategoryId=clean($_POST['hotelCategoryId']); 
		$hotelTypeId=clean($_POST['hotelTypeId']); 
		$hoteldetail=cleanNonAsciiCharactersInString($_POST['hoteldetail']);
		$hotelpolicy=clean($_POST['hotelpolicy']);
		$hoteltermandcondition=clean($_POST['hoteltermandcondition']);
		//$hotelImage=clean($_POST['hotelImage']);
		$gstn=clean($_POST['gstn']);
		$supplier=$_POST['supplier'];
		//add checkin and check out code
		$checkInTime=date('H:i:s', strtotime($_POST['checkInTime']));
		$checkOutTime=date('H:i:s', strtotime($_POST['checkOutTime']));
		
		$weekendid=$_POST['weekend'];
		$hoteldetail=clean($_POST['hoteldetail']);
		$hotel_amenities = implode(',', $_POST['hotel_amenities']);  
		$roomType = implode(',', $_POST['roomType']); 
		$hotelAdditional = implode(',', $_POST['hotelAdditional']); 
		// $weekendDays = implode(',', $_POST['weekendDays']); 
		$status=clean($_POST['status']); 

		$verified=clean($_POST['verified']); 
		$hotelInternalNote=clean($_POST['hotelInternalNote']); 
		
		$countryId=($_POST['countryId2']); 
		$stateId=clean($_POST['stateId2']);
		$cityId=clean($_POST['cityId2']);  
		$pinCode=clean($_POST['pinCode']); 
		
		if(!empty($_FILES['hotelImage']['name'])){  
			$hotelImageN = str_replace(" ","_",trim($_FILES['hotelImage']['name']));
			$file_name=time().$hotelImageN;  
			copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name);
			$hotelIMagName=$file_name; 
		}

		// t&c atteched image 
		if(!empty($_FILES['hoteltcImage']['name'])){  
			$hoteltcImageN = str_replace(" ","_",trim($_FILES['hoteltcImage']['name']));
			$file_name=time().$hoteltcImageN;  
			copy($_FILES['hoteltcImage']['tmp_name'],"packageimages/".$file_name);
			$hoteltcIMagName=$file_name; 
		}
		
		$dateAdded=time();


	$addnewyes = checkduplicate(_PACKAGE_BUILDER_HOTEL_MASTER_,' hotelName="'.$hotelName.'" and hotelCity="'.$hotelCity.'" ');
	if($addnewyes=='yes'){ ?>
		<script>
		alert('Hotel is already exist!!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script>
	 	<?php 
	}else{

		// Hotel Code genrated 
		$A = GetPageRecord('displayId',_PACKAGE_BUILDER_HOTEL_MASTER_,'displayId>0 order by displayId desc');
		$ddata = mysqli_fetch_assoc($A);
		$displayId = $ddata['displayId']+1;


		$namevalue ='hotelName="'.$hotelName.'",locality="'.$locality.'",hotelCity="'.$hotelCity.'",policy="'.$hotelpolicy.'",termAndCondition="'.$hoteltermandcondition.'",hotelChain="'.$hotelChain.'",hotelAddress="'.$hotelAddress.'",hoteldetail="'.$hoteldetail.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",hotelImage="'.$hoteltcIMagName.'",gstn="'.$gstn.'",status="'.$status.'",verified="'.$verified.'",hotelInternalNote="'.$hotelInternalNote.'",url="'.$url.'",roomType="'.$roomType.'",hotelAdditional="'.$hotelAdditional.'",supplier="'.$supplier.'",amenities="'.$hotel_amenities.'",weekendDays="'.$weekendid.'",hotelCategoryName="'.$reCateHot['name'].'",checkInTime="'.$checkInTime.'",checkOutTime="'.$checkOutTime.'",displayId="'.$displayId .'"';  
		$HlastId = addlistinggetlastid(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue); 

		$namevalue ='addressParent="'.$HlastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="hotel"';
	    addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);

	    // email shoud add if already added as an operations and now adding with non-operations
	    // Loop for all contact person details
	    $countCP = 1;
	    while($countCP <= $_POST['countCP']){
				$cp_person=trim($_POST["contactPerson".$countCP]);
				$cp_designation=trim($_POST["designation".$countCP]);
				$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
				$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
				$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
				$cp_email=trim($_POST["email".$countCP]);
				$cp_id=trim($_POST["contactPId".$countCP]);
				$cp_countryCode=trim($_POST["countryCode".$countCP]);
				$cp_division=trim($_POST["division".$countCP]);
			if($cp_division>0 && $cp_email!=''){
				$primaryval=trim($_POST["primaryvalue"]);
				if($countCP==1){
					$cp_primaryvalue=1;
				} else {
					$cp_primaryvalue=0;
				}
				$addnewyes = checkduplicate('hotelContactPersonMaster','email="'.$cp_email.'" and division=3');

				if($addnewyes=='yes' && $cp_division==3){ ?>
					<script>
					alert('Unable to add hotel details, Email is already exist used as an operations.');
					parent.$('#pageloader').hide();
					parent.$('#pageloading').hide();
					</script>
					
				 	<?php 
					exit();
				}else{
					 
					$cp_allvalue ='contactPerson="'.$cp_person.'",corporateId="'.$HlastId.'",designation="'.$cp_designation.'",phone="'.trim($cp_phone).'",phone2="'.trim($cp_phone2).'",phone3="'.trim($cp_phone3).'",email="'.trim($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
					$cp_id2 = addlisting('hotelContactPersonMaster',$cp_allvalue);

				}
			}
			$countCP++;
		} 

		if($supplier=='1'){ 
		
			$select1='*';  
			$where1='name="'.$hotelCity.'"'; 
			$rs1=GetPageRecord($select1,'destinationMaster',$where1); 
			$destD=mysqli_fetch_array($rs1); 
			
			$rs2='';
			$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' name="'.$hotelName.'" and destinationId="'.$destD['id'].'" '); 
			$suppD=mysqli_fetch_array($rs2); 
			if($suppD['id']>0){ 
				$lastId = $suppD['id'];
				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
					$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						}

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3 and corporateId!="'.$lastId.'"');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
							$addnewyes4 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							if($addnewyes4=='yes'){
							 	$allcountCP ='contactPerson="'.$cp_person.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								updatelisting('suppliercontactPersonMaster',$allcountCP,' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							}else{
							 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								addlisting('suppliercontactPersonMaster',$allcountCP);
							}
						}
					}
					$countCP++;
				} 
			}else{

				$agentQuery=GetPageRecord('displayId',_SUPPLIERS_MASTER_,' name!="" and deletestatus=0 and displayId>0 order by displayId desc');
				if(mysqli_num_rows($agentQuery)>0){
				$agentCodeD=mysqli_fetch_array($agentQuery);
				$displayId = $agentCodeD['displayId']+1;
				}else{
				$displayId = 1;
				}

				$dateAdded=time();
				$namevalue ='name="'.$hotelName.'",aliasname="'.$hotelName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',companyTypeId=1,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destD['id'].'",displayId="'.$displayId.'"'; 
				$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);  
				
				$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
				addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
					
				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
					$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						}

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
						 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
							addlisting('suppliercontactPersonMaster',$allcountCP);
						}
					}
					$countCP++;
				}

				$gotohotelprice='';
				if($lastIdSupplier!=''){
					//packagehotelmaster&view=yes&hotelId=VGxFOVBRPT0=&supplierId=VGxFOVBRPT0=
					$gotohotelprice = "&view=yes&hotelId=".encode($addid)."&supplierId=".encode($lastId);
				}
			}
		}
		?>
		<script>
			parent.setupbox('showpage.crm?module=packagehotelmaster<?php echo $gotohotelprice; ?>&alt=1');
		</script> 
		<?php  
	}
}
if(trim($_POST['action'])=='addedit_packagehotelmaster' && trim($_POST['editId'])!='' && trim($_POST['hotelName'])!=''){ 
	
		$hotelName=clean($_POST['hotelName']); 
		$hotelchainname=clean($_POST['name']);
		$url=clean($_POST['url']); 
		$locality=clean($_POST['locality']); 
		$hotelCity=clean($_POST['hotelCity']); 
		$hotelChain=clean($_POST['hotelChain']); 
		$showOnHome=clean($_POST['showOnHome']);  
		$hotelAddress=clean($_POST['hotelAddress']); 
		$hotelCategoryId=clean($_POST['hotelCategoryId']);
		$hotelTypeId=clean($_POST['hotelTypeId']);
		$hotelpolicy=clean($_POST['hotelpolicy']);
		$hoteltermandcondition=clean($_POST['hoteltermandcondition']);
		$gstn=clean($_POST['gstn']);  
		$status=clean($_POST['status']);


		$verified=clean($_POST['verified']); 
		$hotelInternalNote=clean($_POST['hotelInternalNote']); 
		$supplier=$_POST['supplier']; 
		//add checkin and check out code
		$checkInTime=date('H:i:s', strtotime($_POST['checkInTime']));
		$checkOutTime=date('H:i:s', strtotime($_POST['checkOutTime']));
		
		$countryId=clean($_POST['countryId2']); 
		$stateId=clean($_POST['stateId2']);
		$cityId=clean($_POST['cityId2']);  
		$pinCode=clean($_POST['pinCode']);
		
		$editId=clean($_POST['editId']);
		$hoteldetail=clean($_POST['hoteldetail']);
		$hotel_amenities = implode(',', $_POST['hotel_amenities']);  
		$roomType = implode(',', $_POST['roomType']);  
		$hotelAdditional = implode(',', $_POST['hotelAdditional']);  
		// $weekendDays = implode(',', $_POST['weekendDays']);
		$weekendid=$_POST['weekend'];
		if(!empty($_FILES['hotelImage']['name'])){  
			$file_name=time().$_FILES['hotelImage']['name'];  
			copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name);
			$hotelIMagName=$file_name; 
		}else{ 
			$hotelIMagName=$_REQUEST['oldhotleImage'];
		}

	// t&c atteched image 
	if(!empty($_FILES['hoteltcImage']['name'])){  
		$hoteltcImageN = str_replace(" ","_",trim($_FILES['hoteltcImage']['name']));
		$file_name=time().$hoteltcImageN;  
		copy($_FILES['hoteltcImage']['tmp_name'],"packageimages/".$file_name);
		$hoteltcIMagName=$file_name; 
	}else{ 
		$hoteltcIMagName=$_REQUEST['oldhotleImage'];
	}
	 
	$dateAdded=time();
	
	$addnewyes = checkduplicate(_PACKAGE_BUILDER_HOTEL_MASTER_,' hotelName="'.$hotelName.'" and hotelCity="'.$hotelCity.'" and id!="'.$_POST['editId'].'"');
	if($addnewyes=='yes'){ ?>
		<script>
		alert('Hotel Name is already exist!!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script>
	 	<?php 
	}else{
		
		$namevalue ='hotelName="'.$hotelName.'",locality="'.$locality.'",policy="'.$hotelpolicy.'",termAndCondition="'.$hoteltermandcondition.'",hotelCity="'.$hotelCity.'",hotelChain="'.$hotelChain.'",url="'.$url.'",hotelAddress="'.$hotelAddress.'",hotelCategoryId="'.$hotelCategoryId.'",hotelTypeId="'.$hotelTypeId.'",hotelImage="'.$hoteltcIMagName.'",gstn="'.$gstn.'",status="'.$status.'",verified="'.$verified.'",hotelInternalNote="'.$hotelInternalNote.'",hotelAdditional="'.$hotelAdditional.'",roomType="'.$roomType.'",supplier="'.$supplier.'",amenities="'.$hotel_amenities.'",hoteldetail="'.$hoteldetail.'",weekendDays="'.$weekendid.'",checkInTime="'.$checkInTime.'",checkOutTime="'.$checkOutTime.'"';  
		$where='id='.$_POST['editId'].''; 
		$update = updatelisting(_PACKAGE_BUILDER_HOTEL_MASTER_,$namevalue,$where); 


		$rs1="";
		$rs1=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$_POST['editId'].'" and addressType="hotel"');
		if(mysqli_num_rows($rs1) > 0){
			$addrData=mysqli_fetch_array($rs1); 
			$namevalue ='addressParent="'.$_POST['editId'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1';
			updatelisting(_ADDRESS_MASTER_,$namevalue,"id='".$addrData['id']."'");
		}else{
			$namevalue ='addressParent="'.$_POST['editId'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="hotel"';
			addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);

		} 	

	    // Loop for all contact person details
	    $countCP = 1;
	    while($countCP <= $_POST['countCP']){
			$cp_id=trim($_POST["contactPId".$countCP]);
			$cp_person=trim($_POST["contactPerson".$countCP]);
			$cp_designation=trim($_POST["designation".$countCP]);
			$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
			$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
			$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
			$cp_email=trim($_POST["email".$countCP]);
			$cp_countryCode=trim($_POST["countryCode".$countCP]);
			$cp_division=trim($_POST["division".$countCP]);
			if($cp_division>0 && $cp_email!=''){

				$primaryval=trim($_POST["primaryvalue"]);
				if($countCP==1){
					$cp_primaryvalue=1;
				} else {
					$cp_primaryvalue=0;
				}

				$addnewyes3 = checkduplicate('hotelContactPersonMaster',' email="'.trim($cp_email).'" and division=3 and corporateId!="'.$_POST['editId'].'"');
				if($addnewyes3=='yes' && $cp_division==3){ ?>
					<script>
					alert('Unable to add contact detail, Email is already exist used as an operations.');
					parent.$('#pageloader').hide();
					parent.$('#pageloading').hide();
					</script>
				 	<?php 
					exit();
				}else{
					if($cp_id>0){
					 	$allcountCP ='contactPerson="'.$cp_person.'",designation="'.$cp_designation.'",phone="'.trim($cp_phone).'",phone2="'.trim($cp_phone2).'",phone3="'.trim($cp_phone3).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
						updatelisting('hotelContactPersonMaster',$allcountCP,' id="'.$cp_id.'"');
					}else{
					 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$_POST['editId'].'",designation="'.$cp_designation.'",phone="'.trim($cp_phone).'",phone2="'.trim($cp_phone2).'",phone3="'.trim($cp_phone3).'",email="'.trim($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
						addlisting('hotelContactPersonMaster',$allcountCP);
					}
				}
			}else{
				$where=' id="'.$cp_id.'" ';  
				$update = deleteRecord('hotelContactPersonMaster',$where); 
				generateLogs('hotelContactPersonMaster','delete',$cp_id);
			}
			$countCP++;
		} 

		//check for supplier
		if($supplier=='1'){ 
		
			$select1='*';  
			$where1='name="'.$hotelCity.'"'; 
			$rs1=GetPageRecord($select1,'destinationMaster',$where1); 
			$destD=mysqli_fetch_array($rs1); 
			
			$rs2='';
			$rs2=GetPageRecord('*',_SUPPLIERS_MASTER_,' name="'.$hotelName.'" and destinationId="'.$destD['id'].'" '); 
			$suppD=mysqli_fetch_array($rs2); 
			if($suppD['id']>0){ 
				$lastId = $suppD['id'];
				$rs1="";
				$rs1=GetPageRecord('*',_ADDRESS_MASTER_,' addressParent="'.$lastId.'" and addressType="supplier"');
				if(mysqli_num_rows($rs1) > 0){
					$addrData=mysqli_fetch_array($rs1); 
					$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1';
					updatelisting(_ADDRESS_MASTER_,$namevalue,"id='".$addrData['id']."'");
				}else{
					$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress=1,addressType="supplier"';
					addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
				} 	

				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
					$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						} 

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3 and corporateId!="'.$lastId.'"');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
							$addnewyes4 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							if($addnewyes4=='yes'){
							 	$allcountCP ='contactPerson="'.$cp_person.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								updatelisting('suppliercontactPersonMaster',$allcountCP,' email="'.encode($cp_email).'" and corporateId="'.$lastId.'"');
							}else{
							 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
								addlisting('suppliercontactPersonMaster',$allcountCP);
							}
						}
					}
					$countCP++;
				} 
			}else{

				$agentQuery=GetPageRecord('displayId',_SUPPLIERS_MASTER_,' name!="" and deletestatus=0 and displayId>0 order by displayId desc');
				if(mysqli_num_rows($agentQuery)>0){
				$agentCodeD=mysqli_fetch_array($agentQuery);
				$displayId = $agentCodeD['displayId']+1;
				}else{
				$displayId = 1;
				}


				$dateAdded=time();
				$namevalue ='name="'.$hotelName.'",aliasname="'.$hotelName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',companyTypeId=1,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destD['id'].'"'; 
				$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);  
				
				$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",address="'.$hotelAddress.'",pinCode="'.$pinCode.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
				addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
					
				$countCP = 1;
			    while($countCP <= $_POST['countCP']){
					$cp_person=trim($_POST["contactPerson".$countCP]);
					$cp_designation=trim($_POST["designation".$countCP]);
					$cp_phone=str_replace(' ', '', trim($_POST["phone".$countCP]));
					$cp_phone2=str_replace(' ', '', trim($_POST["phone2".$countCP]));
					$cp_phone3=str_replace(' ', '', trim($_POST["phone3".$countCP]));
					$cp_email=trim($_POST["email".$countCP]);
					$cp_id=trim($_POST["contactPId".$countCP]);
					$cp_countryCode=trim($_POST["countryCode".$countCP]);
					$cp_division=trim($_POST["division".$countCP]);
					if($cp_division>0 && $cp_email!=''){
						$primaryval=trim($_POST["primaryvalue"]);
						if($countCP==1){
							$cp_primaryvalue=1;
						} else {
							$cp_primaryvalue=0;
						}

						$addnewyes3 = checkduplicate('suppliercontactPersonMaster',' email="'.encode($cp_email).'" and division=3');
						if($addnewyes3=='yes' && $cp_division==3){ ?>
							<script>
							// alert('Unable to add contact detail, Email is already exist used as an operations.');
							</script>
						 	<?php 
						}else{
						 	$allcountCP ='contactPerson="'.$cp_person.'",corporateId="'.$lastId.'",designation="'.$cp_designation.'",phone="'.encode($cp_phone).'",phone2="'.encode($cp_phone2).'",phone3="'.encode($cp_phone3).'",email="'.encode($cp_email).'",countryCode="'.$cp_countryCode.'",primaryvalue="'.$cp_primaryvalue.'",division="'.$cp_division.'"';
							addlisting('suppliercontactPersonMaster',$allcountCP);
						}
					}
					$countCP++;
				}

				$gotohotelprice='';
				if($lastId!=''){
					//packagehotelmaster&view=yes&hotelId=VGxFOVBRPT0=&supplierId=VGxFOVBRPT0=
					$gotohotelprice = "&view=yes&hotelId=".encode($addid)."&supplierId=".encode($lastId);
				}
			}
		}
		//end supplier
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=packagehotelmaster&alt=2');
	</script> 
	<?php  
}

// hotel ended 111

if(trim($_POST['action'])=='addedit_packagesightseeingmaster' && trim($_POST['editId'])=='' && trim($_POST['sightseeingName'])!=''){ 
$sightseeingName=clean($_POST['sightseeingName']); 
$sightseeingCity=clean($_POST['sightseeingCity']); 
$sightseeingDetail=addslashes($_POST['sightseeingDetail']); 
$sightseeingType=clean($_POST['sightseeingType']);  
$status=clean($_POST['status']);  
if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}
$dateAdded=time();
$namevalue ='sightseeingName="'.$sightseeingName.'",sightseeingCity="'.$sightseeingCity.'",sightseeingDetail="'.$sightseeingDetail.'",sightseeingImage="'.$file_name.'",sightseeingType="'.$sightseeingType.'",status="'.$status.'"';  
$adds = addlisting(_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&alt=1');
</script> 
<?php  }
if(trim($_POST['action'])=='addedit_packagesightseeingmaster' && trim($_POST['editId'])!='' && trim($_POST['sightseeingName'])!=''){ 
$sightseeingName=clean($_POST['sightseeingName']); 
$sightseeingCity=clean($_POST['sightseeingCity']); 
$sightseeingDetail=addslashes($_POST['sightseeingDetail']);
$sightseeingType=clean($_POST['sightseeingType']);    
$status=clean($_POST['status']); 
$editId=clean($_POST['editId']); 
if(!empty($_FILES['hotelImage']['name'])){  
$file_name=time().$_FILES['hotelImage']['name'];  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
$file_name=$_REQUEST['hotelImage2'];
}
$dateAdded=time();
$namevalue ='sightseeingName="'.$sightseeingName.'",sightseeingCity="'.$sightseeingCity.'",sightseeingDetail="'.$sightseeingDetail.'",sightseeingImage="'.$file_name.'",sightseeingType="'.$sightseeingType.'",status="'.$status.'"'; 
$where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_SIGHTSEEING_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&alt=2');
</script> 
<?php  }
// entrance add and edit code below
if(trim($_POST['action'])=='addedit_entrancemaster' && trim($_POST['entranceName'])!=''){
	$entranceName=clean($_POST['entranceName']);  
	$entranceCity=clean($_POST['entranceCity']);   
	$entranceDetail=clean($_POST['entranceDetail']);  
	$status=clean($_POST['status']);
	$tptType=clean($_POST['tptType']);
	$isDefault=clean($_POST['isDefault']); 
	$isOptTours=clean($_POST['isOptTours']); 
	$adultCost=clean($_POST['adultCost']); 
	$childCost=clean($_POST['childCost']); 
	  
	$currencyId=clean($_POST['isOptCurrency']); 
	$nationality=addslashes($_POST['nationalityType']);  
	 
	$daysname=$_POST['daysname'];
	if(count($_POST['daysname'])>0){
		$finaldaysname = implode(",",$daysname);
		$rs=GetPageRecord('name','weekendDaysMaster',' deleteStatus=0 and id in ('.$finaldaysname.') order by name asc'); 
		while($resListing=mysqli_fetch_array($rs)){ 
			$daysFullName.=$resListing['name'].',';
		}
	}else{
		$daysFullName='';
	}
	$weekendId=$_POST['weekendId'];
	
	if(!empty($_FILES['entranceImage']['name'])){  
		$file_name=time().$_FILES['entranceImage']['name'];   
		copy($_FILES['entranceImage']['tmp_name'],"packageimages/".$file_name);  
	}else{  
		$file_name=$_REQUEST['entranceImage2']; 
	} 
	$dateAdded=time();  

	// Monument Code genrated 
	$A = GetPageRecord('displayId',_PACKAGE_BUILDER_ENTRANCE_MASTER_,'displayId>0 order by displayId desc');
	$ddata = mysqli_fetch_assoc($A);
	$displayId = $ddata['displayId']+1;

	$namevalue ='entranceName="'.$entranceName.'",entranceCity="'.$entranceCity.'",entranceDetail="'.$entranceDetail.'",entranceImage="'.$file_name.'",entranceType="'.$entranceType.'",status="'.$status.'",tptType="'.$tptType.'",isDefault="'.$isDefault.'",isOptTours="'.$isOptTours.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",weekendId="'.$weekendId.'",closeDaysname="'.rtrim($daysFullName,',').'",displayId="'.$displayId .'"'; 
  	if(clean($_POST['editId']) !='' ){ 
 		$where='id="'.$_POST['editId'].'"'; 
		$entraceId = $_POST['editId'];
		$update = updatelisting(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$namevalue,$where);
		$msgbox = 2; 

		if($update=='yes'){
			$descvalue = 'lang_01="'.$entranceDetail.'",entranceId="'.$entraceId.'"';

			$ent11 = GetPageRecord('*','entranceLanguageMaster','entranceId="'.$_POST['editId'].'"');
			if(mysqli_num_rows($ent11)>0){
			$entres = mysqli_fetch_assoc($ent11);
			
			$whereentId = 'id="'.$entres['id'].'"';
			updatelisting('entranceLanguageMaster',$descvalue,$whereentId);
			}else{
				addlisting('entranceLanguageMaster',$descvalue);
			}
		}
		
 	}else{  
		$addnewyes = checkduplicate(_PACKAGE_BUILDER_ENTRANCE_MASTER_,'entranceName="'.$entranceName.'" and entranceCity="'.$entranceCity.'" '); 
		if($addnewyes!='yes'){
	
	 		$entraceId = addlistinggetlastid(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$namevalue); 
	 		$msgbox = 1;

			$descvalue = 'lang_01="'.$entranceDetail.'",entranceId="'.$entraceId.'"';
			addlisting('entranceLanguageMaster',$descvalue);
			 
	 	}else{ ?>
			<script> alert('<?php echo $entranceName; ?> is already exist...!'); </script>
	 		<?php 
		}
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=entrancemaster&alt=<?php echo $msgbox; ?>');
	</script> 
	<?php  
}

// entrance supplier 
if(trim($_POST['action'])=='addeditpackagesupplier_entrancemaster' && trim($_POST['supplierId'])!=''){ 
	$entranceid=decode(clean($_POST['entranceid'])); 
	$supplierId=clean($_POST['supplierId']); 
	
	
	$dateAdded=time();
	
	$namevalue ='entranceId="'.$entranceid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
	$adds = addlisting(_PACKAGE_ENTRANCE_SUPPLIER_MASTER_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=entrancemaster&supplier=1&entranceid=<?php echo $_POST['entranceid'];?>&alt=1');
	</script> 
	<?php  
}
if(trim($_POST['action'])=='addedit_packagetransfermaster' && trim($_POST['editId'])=='' && trim($_POST['transferName'])!=''){ 
	// die("test22");
	$newUrl=''; 
	$transferName=clean($_POST['transferName']);  
	$transferCategory=clean($_POST['trnsType']); 
	$isOptTours=clean($_POST['isOptTours']); 
	$adultCost=clean($_POST['adultCost']); 
	$childCost=clean($_POST['childCost']); 
	$currencyId=clean($_POST['isOptCurrencyId']); 

	if($transferCategory=='transportation'){
		$newUrl='packageTransportmaster';
	}else{
		$newUrl='packagetransfermaster';
	}
	$transferDetail=cleanNonAsciiCharactersInString($_POST['transferDetail']);   
 
	$transferType=clean($_POST['transferType']); 

	$status=clean($_POST['status']);  
	$isbrochure=clean($_POST['isbrochure']); 
	if(!empty($_FILES['hotelImage']['name'])){  
		$file_name=time().$_FILES['hotelImage']['name'];   
		copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name);  
	}

	$dateAdded=time();
	// Check if 'all_dest' is in the array and replace it with '0'
	if (in_array('all_dest', $_POST['destinationId'])) {
	    $destinationId = '0';
	}else{
		// Implode the array
		$destinationId = implode(',', $_POST['destinationId']);
	} 
	
	$duplicateres = GetPageRecord('*',_PACKAGE_BUILDER_TRANSFER_MASTER,'transferName="'.$transferName.'"');
	if(mysqli_num_rows($duplicateres)>0){      
		?> 
		<script>
			alert("Transfer Name already Exist!"); 
			parent.$('#pageloader').hide();
        	parent.$('#pageloading').hide();
		</script>
		
		<?php
		exit();
	}else{

		// Transfer Code genrated 
		$A = GetPageRecord('displayId',_PACKAGE_BUILDER_TRANSFER_MASTER,'displayId>0 order by displayId desc');
		$ddata = mysqli_fetch_assoc($A);
		$displayId = $ddata['displayId']+1;

		$namevalue ='transferName="'.$transferName.'",transferCategory="'.$transferCategory.'",transferDetail="'.$transferDetail.'",transferImage="'.$file_name.'",transferType="'.$transferType.'",isbrochure="'.$isbrochure.'",status="'.$status.'",isOptTours="'.$isOptTours.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",destinationId="'.$destinationId.'",displayId="'.$displayId .'"';    
		$adds = addlisting(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue); 
	}  
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $newUrl; ?>&alt=1');
	</script> 
	<?php  
}
if(trim($_POST['action'])=='addedit_packagetransfermaster' && trim($_POST['editId'])!='' && trim($_POST['transferName'])!=''){ 
	// die("test");
	$newUrl='';
	$transferName=clean($_POST['transferName']); 
	$transferCategory=clean($_POST['trnsType']); 
	if($transferCategory=='transportation'){
		$newUrl='packageTransportmaster'; 
	}else{
		$newUrl='packagetransfermaster';
	} 
	$transferDetail=cleanNonAsciiCharactersInString($_POST['transferDetail']); 
	$transferType=clean($_POST['transferType']); 
	$status=clean($_POST['status']); 
	$isOptTours=clean($_POST['isOptTours']); 
	$adultCost=clean($_POST['adultCost']); 
	$childCost=clean($_POST['childCost']); 
	$isbrochure=clean($_POST['isbrochure']); 
	$currencyId=clean($_POST['isOptCurrencyId']); 

	$editId=clean($_POST['editId']); 
	if(!empty($_FILES['hotelImage']['name'])){  
	$file_name=time().$_FILES['hotelImage']['name'];  
	copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
	$file_name=$_REQUEST['hotelImage2'];
	}
	$dateAdded=time();
	
	// Check if 'all_dest' is in the array and replace it with '0'
	if (in_array('all_dest', $_POST['destinationId'])) {
	    $destinationId = '0';
	}else{
		// Implode the array
		$destinationId = implode(',', $_POST['destinationId']);
	} 
	  
	$namevalue ='transferName="'.$transferName.'",transferCategory="'.$transferCategory.'",transferDetail="'.$transferDetail.'",transferImage="'.$file_name.'",transferType="'.$transferType.'",status="'.$status.'",isOptTours="'.$isOptTours.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$currencyId.'",isbrochure="'.$isbrochure.'",destinationId="'.$destinationId.'"'; 
	$where='id='.$_POST['editId'].''; 
	$update = updatelisting(_PACKAGE_BUILDER_TRANSFER_MASTER,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $newUrl; ?>&alt=2');
	</script> 
	<?php  
}

  

if(trim($_POST['action'])=='addedit_packageairlinemaster' && trim($_POST['editId'])=='' && trim($_POST['flightName'])!=''){ 


$flightName=clean($_POST['flightName']); 

$flightCity=clean($_POST['flightCity']); 

$flightNo=clean($_POST['flightNo']);    

$status=clean($_POST['status']);  

if(!empty($_FILES['hotelImage']['name'])){  

$file_name=time().$_FILES['hotelImage']['name'];  

copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 

}






$dateAdded=time();


// check the otheractivityName and otheractivityCity variable 
	$rs3=GetPageRecord('id',_PACKAGE_BUILDER_AIRLINES_MASTER_,'flightName="'.$flightName.'"');
	
	if(mysqli_num_rows($rs3)<1){

		// flightName Code genrated 
		$A = GetPageRecord('displayId',_PACKAGE_BUILDER_AIRLINES_MASTER_,'displayId>0 order by displayId desc');
		$ddata = mysqli_fetch_assoc($A);
		$displayId = $ddata['displayId']+1;

	   echo $namevalue ='flightName="'.$flightName.'",flightCity="'.$flightCity.'",flightNo="'.$flightNo.'",flightImage="'.$file_name.'",status="1",displayId="'.$displayId .'"';   
        $adds = addlisting(_PACKAGE_BUILDER_AIRLINES_MASTER_,$namevalue); 
        ?>
<script>
parent.setupbox('showpage.crm?module=packageairlinemaster&alt=2');
</script> 
<?php
	}else{
	 ?>
    	<script>
    	
    	parent.alert('Airline Name already exists !!');
        parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php   
	}
  }
 
if(trim($_POST['action'])=='addedit_packageairlinemaster' && trim($_POST['editId'])!='' && trim($_POST['flightName'])!=''){ 
	 
		$flightName=clean($_POST['flightName']); 
		
		$flightCity=clean($_POST['flightCity']); 
		
		$flightNo=clean($_POST['flightNo']);    
		
		$status=clean($_POST['status']);  

		$editId=clean($_POST['editId']);  
		
		if(!empty($_FILES['hotelImage']['name'])){  
		
			$file_name=time().$_FILES['hotelImage']['name'];  
		
			copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
			
		}else{

			$file_name=$_REQUEST['hotelImage2'];  

		}
		
	$dateAdded=time();

	$rs3=GetPageRecord('id',_PACKAGE_BUILDER_AIRLINES_MASTER_,'flightName="'.$flightName.'" and id !="'.$_POST['editId'].'"');

	if(mysqli_num_rows($rs3)<1){
	    $namevalue ='flightName="'.$flightName.'",flightCity="'.$flightCity.'",flightNo="'.$flightNo.'",flightImage="'.$file_name.'",status="'.$status.'"';   
	    $where='id='.$_POST['editId'].''; 
	    $adds = updatelisting(_PACKAGE_BUILDER_AIRLINES_MASTER_,$namevalue, $where); //'id="'.$editId.'"'
	    ?>
		<script>
		parent.setupbox('showpage.crm?module=packageairlinemaster&alt=2');
		</script> 
		<?php 
	}else{ ?>
		<script>
		parent.alert('Airline Name already exists !!');
		parent.$('#pageloader').hide();
	    parent.$('#pageloading').hide();
	    // parent.setupbox('showpage.crm?module=packageairlinemaster&alt=2');
		</script> 
		<?php 
	}   

} 
 
if(($_REQUEST['sectiontype'] == 'luxurytrain' || $_REQUEST['sectiontype'] == 'trainmaster' ) && trim($_POST['trainName'])!=''){

	$trainName=clean($_POST['trainName']); 
	$trainCity=clean($_POST['trainCity']); 
	$trainNo=clean($_POST['trainNo']);    
	$status=clean($_POST['status']);  
	$sectiontype=clean($_POST['sectiontype']);  

	if($_REQUEST['sectiontype'] == 'luxurytrain'){
	 	// trainType=0 and
		$trainType=1;
		$alertmsg = 'Luxury Train';
	}else{
		$trainType=0;
		$alertmsg = 'Train';
	}
	
	if(!empty($_FILES['trainImage']['name'])){  
		$file_name=time().$_FILES['trainImage']['name'];  
		copy($_FILES['trainImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
		$file_name=$_REQUEST['trainImage2'];
	}
	$dateAdded=time(); 

	// Train Code genrated 
	$A = GetPageRecord('displayId',_PACKAGE_BUILDER_TRAINS_MASTER_,'displayId>0 order by displayId desc');
	$ddata = mysqli_fetch_assoc($A);
	$displayId = $ddata['displayId']+1;
	

	$namevalue ='trainName="'.$trainName.'",trainType="'.$trainType.'",trainCity="'.$trainCity.'",trainNo="'.$trainNo.'",trainImage="'.$file_name.'",status="'.$status.'",displayId="'.$displayId .'"';   
	// echo '<pre>';
	// print_r($_REQUEST);
	// exit;
		if($_POST['editId']!=''){
			$rs3=GetPageRecord('id',_PACKAGE_BUILDER_TRAINS_MASTER_,'trainName="'.$trainName.'" and trainType="'.$trainType.'" and id !="'.$_POST['editId'].'"');
			if(mysqli_num_rows($rs3)<1){
				$where='id='.$_POST['editId'].''; 
				$update = updatelisting(_PACKAGE_BUILDER_TRAINS_MASTER_,$namevalue,$where); 
				$msg=2;
				?>
				<script>
					parent.setupbox('showpage.crm?module=<?php echo $sectiontype; ?>&alt=<?php echo $msg; ?>');
				</script> 
				<?php 
			}else{
				?>
				<script>
				parent.alert('<?php echo $alertmsg; ?> Name already exist !!');
				parent.$('#pageloader').hide();
				parent.$('#pageloading').hide();
				</script> 
				<?php
			}
		
	}else{ 
	    $rs3=GetPageRecord('id',_PACKAGE_BUILDER_TRAINS_MASTER_,'trainName="'.$trainName.'"');
	    if(mysqli_num_rows($rs3)<1){
	        $adds = addlisting(_PACKAGE_BUILDER_TRAINS_MASTER_,$namevalue); 
			$msg=1; 
			?>
			<script>
				parent.setupbox('showpage.crm?module=<?php echo $sectiontype; ?>&alt=<?php echo $msg; ?>');
			</script> 
			<?php 
	    }else{
		    ?>
	    	<script>
	    	parent.alert('<?php echo $alertmsg; ?> Name already exist !!');
	    	parent.$('#pageloader').hide();
	        parent.$('#pageloading').hide();
	    	</script> 
	    	<?php
	    }
		
	} 
}

if(trim($_POST['action'])=='addedit_traincabintype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$roomoccupancy=clean($_POST['roomoccupancy']);  
	$status=clean($_POST['status']);  
	$dateAdded=time();
	$where='id="'.$_POST['editId'].'"'; 
	$namevalue ='name="'.$name.'",roomoccupancy="'.$roomoccupancy.'",status="'.$status.'"';  
	$update = updatelisting(_TRAIN_CABIN_TYPE_,$namevalue,$where); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
	</script> 
	<?php 
} 
if(trim($_POST['action'])=='addedit_traincabintype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']);  
	$roomoccupancy=clean($_POST['roomoccupancy']);  
	$status=clean($_POST['status']);  
	$dateAdded=time();
	$namevalue ='name="'.$name.'",roomoccupancy="'.$roomoccupancy.'",status="'.$status.'"';  
	$adds = addlisting(_TRAIN_CABIN_TYPE_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php 
} 


if(trim($_POST['action'])=='addeditpackagesupplier_packagehotelmaster' && trim($_POST['supplierId'])!=''){ 
 	$hotelId=decode(clean($_POST['hotelId'])); 
	$supplierId=clean($_POST['supplierId']); 
  	$dateAdded=time();
 	$namevalue ='hotelId="'.$hotelId.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
	$adds = addlisting(_PACKAGE_HOTEL_SUPPLIER_MASTER_,$namevalue); 
	?>
	<script>
	parent.setupbox('showpage.crm?module=packagehotelmaster&supplier=1&hotelid=<?php echo $_POST['hotelId'];?>&alt=1');
	</script> 
	<?php  
}
if(trim($_POST['action'])=='addeditpackagesupplier_packagesightseeingmaster' && trim($_POST['supplierId'])!=''){ 
$sightseeingid=decode(clean($_POST['sightseeingid'])); 
$supplierId=clean($_POST['supplierId']); 
$dateAdded=time();
$namevalue ='sightseeingId="'.$sightseeingid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_SIGHTSEEING_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagesightseeingmaster&supplier=1&sightseeingid=<?php echo $_POST['sightseeingid'];?>&alt=1');
</script> 
<?php  }
if(trim($_POST['action'])=='addeditpackagesupplier_packagetransfermaster' && trim($_POST['supplierId'])!=''){ 
$transferid=decode(clean($_POST['transferid'])); 
$supplierId=clean($_POST['supplierId']); 
$dateAdded=time();
$namevalue ='transferId="'.$transferid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_TRANSFER_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=packagetransfermaster&supplier=1&transferid=<?php echo $_POST['transferid'];?>&alt=1');
</script> 
<?php  }
if(trim($_POST['action'])=='addedit_certificatelogomaster'){ 
$name=clean($_POST['name']);   
$status=clean($_POST['status']); 
$editId=clean($_POST['editId']); 
if(!empty($_FILES['hotelImage']['name'])){  
$file_name=str_replace(' ', '_',time().$_FILES['hotelImage']['name']);  
copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
}else{
$file_name=str_replace(' ', '_',$_REQUEST['hotelImage2']);
}
$dateAdded=time();
$namevalue ='name="'.$name.'",logo="'.$file_name.'",status="'.$status.'"';   
$where='id='.$_POST['editId'].''; 
if($editId!='')
{
$update = updatelisting(_CERTIFICATE_MASTER_,$namevalue,$where); }else
{$adds = addlisting(_CERTIFICATE_MASTER_,$namevalue);}
 ?>
<script>
parent.setupbox('showpage.crm?module=certificatelogomaster&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
</script> 
<?php  }

if(trim($_POST['action'])=='addedit_weekendmaster'){ 

	$name=$_POST['named'];
	$daysname=$_POST['daysname'];
	$finaldaysname = implode(",",$daysname);
	$status=clean($_POST['status']); 
	$editId=clean($_POST['editId']); 
	$dateAdded=time();
	$daysFullName='';
	
	if($daysname!=''){
		$rs="";
		$rs=GetPageRecord('name','weekendDaysMaster',' deleteStatus=0 and id in ( '.$finaldaysname.' ) order by name asc'); 
		while($resListing=mysqli_fetch_array($rs)){ 
			$daysFullName.=$resListing['name'].',';
		}
	}
	
	$namevalue ='name="'.$name.'",weekendDays="'.$finaldaysname.'",status="'.$status.'",daysName="'.rtrim($daysFullName,',').'"';   
	$where='id='.$_POST['editId'].''; 
	if($editId!=''){
	    
	    $rs4=GetPageRecord('id',_WEEKEND_MASTER_,'name="'.$name.'" and weekendDays="'.$finaldaysname.'" and id != "'.$_POST['editId'].'"');
	    if(mysqli_num_rows($rs4)<1){
	        $namevalue ='name="'.$name.'",weekendDays="'.$finaldaysname.'",status="'.$status.'",daysName="'.rtrim($daysFullName,',').'"';   
	    $where='id='.$_POST['editId'].''; 
	    $update = updatelisting(_WEEKEND_MASTER_,$namevalue,$where);
	    	?>
	<script>
 	parent.setupbox('showpage.crm?module=weekendmaster&alt=<?php if($editId!=''){ echo '2'; }else { echo '1'; }?>');
	</script> 
	<?php 
	    }else{
	       ?>
    	<script>
    	parent.alert('Week Name already exist !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
	    }
		
	}else{
	    
	    $rs3=GetPageRecord('id',_WEEKEND_MASTER_,'name="'.$name.'" and weekendDays="'.$finaldaysname.'"');
	    
	    if(mysqli_num_rows($rs3)<1){
	    $namevalue ='name="'.$name.'",weekendDays="'.$finaldaysname.'",status="'.$status.'",daysName="'.rtrim($daysFullName,',').'"'; 
	        $adds = addlisting(_WEEKEND_MASTER_,$namevalue);
	        	?>
	<script>
 	parent.setupbox('showpage.crm?module=weekendmaster&alt=<?php if($editId!=''){ echo '2'; }else { echo '1'; }?>');
	</script> 
	<?php 
	    }else{
	        ?>
    	<script>
    	parent.alert('Week Name already exist !!');
        parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
	    }
		
	}
	
 
}

if($_REQUEST['action']=='deleteweekend'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) { 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$namevalue ='status=0';  
				$where='id="'.$ansval.'"';  
				$update = updatelisting(_WEEKEND_MASTER_,$namevalue,$where); 
				generateLogs('weekend','delete',$ansval);
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=weekendmaster&alt=3');
	</script>
	<?php
}

// ======================= Cruise Price Master start ========================
if(trim($_POST['action'])=='addedit_cruisemaster' && trim($_POST['editId'])=='' && trim($_POST['cruiseName'])!=''){

	$cruiseName=clean($_POST['cruiseName']); 
	$pickupTime=$_POST['arrivalTime']; 
	$dropTime=$_POST['departureTime']; 
	$destinationList = $_POST['destinationId'];  
	$cruiseInformation=clean($_POST['cruiseInformation']); 

	$status=clean($_POST['status']); 
	$departureDateC=date('Y-m-d',strtotime($_POST['departureDateC'])); 
	$reachDateC=date('Y-m-d',strtotime($_POST['reachDateC'])); 
	$cruiseDuration=clean($_POST['cruiseDuration']); 
	

	$dateAdded=time();

	$weekdaysname=$_POST['weekdaysname']; 
	if(count($_POST['weekdaysname'])>0){
		$finaldaysname = implode(",",$weekdaysname);
		$rs=GetPageRecord('name','weekendDaysMaster',' deleteStatus=0 and id in ('.$finaldaysname.') order by name asc'); 
		while($resListing=mysqli_fetch_array($rs)){ 
			$daysFullName.=$resListing['name'].',';
		}
	}else{
		$daysFullName='';
	}
	$weekendId=$_POST['weekendId'];
	

	// duplicate check action
			$rsr=GetPageRecord('*',_CRUISE_MASTER_,'cruiseName="'.$cruiseName.'" ');
			$editresult=mysqli_num_rows($rsr);
			if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
				?>
				<script>
				parent.alert('Cruise Package Name Already Exist!');
				parent.$('#pageloader').hide();
				parent.$('#pageloading').hide();
				exit();
				</script> 
				<?php 
				
			}else{
				$namevalue ='destination="'.$destinationList.'",departureDate="'.$departureDateC.'",toDate="'.$reachDateC.'",duration="'.$cruiseDuration.'",cruiseName="'.$cruiseName.'",otherDetail="'.$cruiseInformation.'",status="'.$status.'",runningDays="'.rtrim($daysFullName,',').'"';  

				$lastId = addlistinggetlastid(_CRUISE_MASTER_,$namevalue);
			
				$msg = 1;
			
				foreach($pickupTime as $key => $value){
			
					$arrivalTime1 = $value;
					$departureTime2 = $dropTime[$key];
					$allTimevalue ='cruiseMasterId="'.$lastId.'",arrivalTime="'.$arrivalTime1.'",departureTime="'.$departureTime2.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
					$add = addlisting('cruiseServiceTiming',$allTimevalue);
				}
			
			?>
			
			<script>
			
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			</script> 
			
			<?php
			}
   
	}


if(trim($_POST['action'])=='addedit_cruisemaster' && trim($_POST['editId'])!='' && trim($_POST['cruiseName'])!=''){

	$_REQUEST['editId'];

	$cruiseName=clean($_POST['cruiseName']); 
	$arrivalTime1=$_POST['arrivalTime']; 
	$departureTime1=$_POST['departureTime']; 

	$destinationList = $_POST['destinationId'];  
	$cruiseInformation=clean($_POST['cruiseInformation']); 
	$status=clean($_POST['status']);

	$departureDateC=date('Y-m-d',strtotime($_POST['departureDateC'])); 
	$reachDateC=date('Y-m-d',strtotime($_POST['reachDateC'])); 
	$cruiseDuration=clean($_POST['cruiseDuration']); 
	
	$weekdaysname=$_POST['weekdaysname']; 
	if(count($_POST['weekdaysname'])>0){
		$finaldaysname = implode(",",$weekdaysname);
		$rs=GetPageRecord('name','weekendDaysMaster',' deleteStatus=0 and id in ('.$finaldaysname.') order by name asc'); 
		while($resListing=mysqli_fetch_array($rs)){ 
			$daysFullName.=$resListing['name'].',';
		}
	}else{
		$daysFullName='';
	}
	$weekendId=$_POST['weekendId'];

	$dateAdded=time();

	$namevalue ='destination="'.$destinationList.'",departureDate="'.$departureDateC.'",toDate="'.$reachDateC.'",duration="'.$cruiseDuration.'",cruiseName="'.$cruiseName.'",otherDetail="'.$cruiseInformation.'",status="'.$status.'",runningDays="'.rtrim($daysFullName,',').'",pickUpTime="'.$departureTime1.'",dropTime="'.$arrivalTime1.'"'; 
	
	$where='id="'.$_REQUEST['editId'].'"'; 

	$update = updatelisting(_CRUISE_MASTER_,$namevalue,$where); 

	$msg = 2;

	// $valuecont = '1';
	// 
	
	while($valuecont <= $_POST['cruiseTimeCount']){
		$pickupTime=trim($_POST["pickupTime".$valuecont]);
		$dropTime=trim($_POST["dropTime".$valuecont]);
		$cruisetimeId=trim($_POST["cruisetimeId".$valuecont]);

		if(trim($_POST["cruisetimeId".$valuecont])!=''){
			$selecteee='*';
			$whereeee='id="'.$cruisetimeId.'"';
			$resee=GetPageRecord($selecteee,'cruiseServiceTiming',$whereeee);
			$ferrytimecount=mysqli_num_rows($resee);
			if($ferrytimecount>0){
				while($upcpm=mysqli_fetch_array($resee)){
					$cruiseVal ='departureTime="'.$pickupTime.'",arrivalTime="'.$dropTime.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
					$wherecruisetimeId='id="'.$cruisetimeId.'"';
					$updatecruisetime = updatelisting('cruiseServiceTiming',$cruiseVal,$wherecruisetimeId);
				}
			}

		}else{
			

			foreach( $arrivalTime1 as $key => $value){

				$arrivalTime1 = $value;
				$departureTime2 = $departureTime1[$key];
				$cruiseVal2 ='cruiseMasterId="'.$_REQUEST['editId'].'",arrivalTime="'.$arrivalTime1.'",departureTime="'.$departureTime2.'",status="'.$status.'",deletestatus="'.$deletestatus.'"';
				
				if($arrivalTime1!='' && $departureTime2!=''){
				$add = addlisting('cruiseServiceTiming',$cruiseVal2);
				}
			}
			 
		}
		$valuecont++;
	}

	?>

	<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');

	</script> 

	<?php
}



// ======================= Cruise Price Master End ========================

if($_REQUEST['action']=='deleteCruiseMaster'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting(_CRUISE_MASTER_,$namevalue,$where); 

} } } 
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&alt=3');
</script>
<?php
}

if(trim($_POST['action'])=='addeditpackageCruisesupplier_cruisemaster' && trim($_POST['supplierId'])!=''){ 
$cruiseid=decode(clean($_POST['cruiseid'])); 
$supplierId=clean($_POST['supplierId']); 
$dateAdded=time();
$namevalue ='cruiseid="'.$cruiseid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';   
$adds = addlisting(_PACKAGE_CRUISE_SUPPLIER_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&supplier=1&cruiseid=<?php echo $_POST['cruiseid'];?>&alt=1');
</script> 
<?php  }
if(trim($_POST['action'])=='addCruiseSupplierRate' && trim($_POST['supplierId'])!='' && trim($_POST['cruiseid'])!=''){ 
$cruiseid=(clean($_POST['cruiseid']));
$supplierId=clean($_POST['supplierId']);
$fromDate=date('Y-m-d',strtotime($_POST['fromDate']));
$toDate=date('Y-m-d',strtotime($_POST['toDate']));
$price=clean($_POST['price']);
$select='';
$where='';
$rs='';  
$select='*'; 
$where=' cruiseid="'.$cruiseid.'" and supplierId="'.$supplierId.'" order by id asc'; 
$rs=GetPageRecord($select,_PACKAGE_CRUISE_RATE_,$where); 
$count = mysqli_num_rows($rs);
$editresult=mysqli_fetch_array($rs);
$dateAdded=time();
$namevalue ='fromDate="'.$fromDate.'",toDate="'.$toDate.'",price="'.$price.'",cruiseid="'.$cruiseid.'",supplierId="'.$supplierId.'",dateAdded="'.$dateAdded.'"';  
if($count > 0){
$where = 'id="'.$editresult['id'].'"';
$update = updatelisting(_PACKAGE_CRUISE_RATE_,$namevalue,$where);
}else{
$adds = addlisting(_PACKAGE_CRUISE_RATE_,$namevalue); 
}
?>
<script>
parent.setupbox('showpage.crm?module=cruisemaster&supplier=1&cruiseid=<?php echo encode($cruiseid); ?>&alt=1');
</script> 
<?php  }
if(trim($_POST['action'])=='cms_add_gallery' && trim($_POST['title'])!=''){ 
if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}
$type='memoriesGallery';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);
    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=gallery&alt=1');
</script> 
<?php } else {
$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=gallery&alt=2');
</script> 
<?php }?>
<?php } 
if(trim($_POST['action'])=='cms_add_images' && trim($_POST['title'])!=''){ 
if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}
$type='memoriesImages';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);
    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$cid=$_POST['cid'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=1');
</script> 
<?php } else {
$cid=$_POST['cid'];
$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=2');
</script> 
<?php }?>
<?php } 
if(trim($_POST['action'])=='cms_add_blog' && trim($_POST['title'])!=''){ 
if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}
if($_FILES['file2']['name']!=''){ 
echo $file_name=$_FILES['file2']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file2']['tmp_name'],"upload/".$file_name);
 $image2=$file_name;
} else {
$image2=$_REQUEST['feature_img2'];
}
$type='blog';
$post_date=clean($_POST['post_date']);
$post_date=date("Y-m-d", strtotime($post_date));
$title=clean($_POST['title']);
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$feature_img2=clean($_POST['image2']);
$designation=clean($_POST['designation']);
$meta_title=clean($_POST['meta_title']);
$meta_description=clean($_POST['meta_description']);
$meta_keyword=clean($_POST['meta_keyword']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image2="'.$image2.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=blog&alt=1');
</script> 
<?php } else {
$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image2="'.$image2.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=blog&alt=2');
</script> 
<?php }?>
<?php } 
if(trim($_POST['action'])=='cms_add_banner' && trim($_POST['title'])!=''){ 
if($_FILES['file1']['name']!=''){ 
echo $file_name=$_FILES['file1']['name']; 
$ext=$file_name;
$file_name=str_replace (" ", "",$datef.$ext);
copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
 $image=$file_name;
} else {
$image=$_REQUEST['feature_img'];
}
$type='banner';
$title=clean($_POST['title']);
    // multipale package theme for gallery Images
    $package_themeData=$_POST['package_theme'];
    $package_theme = implode(",", $package_themeData);
    // multipale package Destiation for gallery Images
    $package_destination=$_POST['destination'];
    $destination = implode(",", $package_destination);
    // End of multiple package Destiation image gallery 
	
$home_text=clean($_POST['home_text']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
$adduser=$_SESSION['userid'];
$edituser=$_SESSION['userid'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$id=$_POST['id'];
$add_date=time();
if(trim($_POST['editId'])==''){
$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=banner&alt=1');
</script> 
<?php } else {
$where='id='.$_POST['editId'].''; 
$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
?>
<script>
parent.setupbox('showpage.crm?module=cms&page=banner&alt=2');
</script> 
<?php }?>
<?php } 
if($_REQUEST['action']=='vehiclebranddelete'){  
 echo 'test';
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting(_VEHICLE_BRAND_MASTER_,$namevalue,$where); 
 
generateLogs('vehiclebrand','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=vehiclebrandmaster&alt=3');
</script>
<?php
} 


if(trim($_REQUEST['action'])=='delete_'.$_REQUEST['module'] && trim($_REQUEST['table'])!=''){    
	$check_list=$_REQUEST['check_list'];  
	$modifyDate = date('Y-m-d');
	if($check_list!=""){  

		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$where='id='.$ansval.''; 
				$namevalue ='status="0",adddate="'.$modifyDate.'",addedBy="'.$_SESSION['userid'].'"';  
				$update = updatelisting($_REQUEST['table'],$namevalue,$where); 
			//	$sql_del="delete from ".$_REQUEST['table']."  where id='".$ansval."'"; 
			//	mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['module'];?>&alt=3');
	</script>
	<?php
}



if(trim($_POST['action'])=='addedit_mainhallmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_MAIN_HALL_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_MAIN_HALL_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_mainhallmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_MAIN_HALL_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_divisionmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_DIVISION_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This division already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_DIVISION_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_divisionmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_DIVISION_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_diningareamaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_DINING_AREA_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_DINING_AREA_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_diningareamaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_DINING_AREA_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_audiovisualmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_AUDIO_VISUAL_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_AUDIO_VISUAL_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_audiovisualmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_AUDIO_VISUAL_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_vviploungemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_VVIP_LAUNGE_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_VVIP_LAUNGE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_vviploungemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_VVIP_LAUNGE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_photographymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_PHOTOGRAPHY_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_PHOTOGRAPHY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_photographymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_PHOTOGRAPHY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_powersupplymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_POWER_SUPPLY_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_POWER_SUPPLY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_powersupplymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_POWER_SUPPLY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_utilitiesmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_UTILITIES_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_UTILITIES_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_utilitiesmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_UTILITIES_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_signagemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_SIGNAGE_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_SIGNAGE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_signagemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_SIGNAGE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_venuemaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_VENUE_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_VENUE_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_venuemaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_VENUE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_housekeepingmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_HOUSE_KEEPING_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_HOUSE_KEEPING_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_housekeepingmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_HOUSE_KEEPING_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_securitymaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_SECURITY_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_SECURITY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_securitymaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_SECURITY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_licencesmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_LICENCES_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_LICENCES_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_licencesmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_LICENCES_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_decormaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_DECOR_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_DECOR_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_decormaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_DECOR_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedit_emergencyservicesmaster' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_EMERGENCY_SERVICES_MASTER_,$where); 
if($addnewyes=='yes'){
	
?>	
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This name already exist.');
</script>
<?php
} else {
	
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
$adds = addlisting(_EMERGENCY_SERVICES_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_emergencyservicesmaster' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$dateAdded=time();
$namevalue ='name="'.$name.'"'; 
$where='id='.$_POST['editId'].'';  
$update = updatelisting(_EMERGENCY_SERVICES_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php }
if(trim($_POST['action'])=='addedithotelGallery'){
	 $title=clean($_POST['title']);
	
	$hotelid=decode($_POST['hotelId']);
	if(!empty($_FILES['galleryImage']['name'])){  
		
		$file_name = $_FILES['galleryImage']['name'];
		$temp_img = $_FILES['galleryImage']['tmp_name'];//full path of the image of OR temp path of the file
        $image1 = getfilename($file_name); // rename the file befor upload
        // get the full size image
        if(makeDir('dirfiles/') === true){
            $directoryName ='dirfiles/';
            $targetedFile = $directoryName.$image1; // save custom name and full path after upload/ foldeer to database
            $width      = 730; //$_POST['width'];
            $height     = 500; //$_POST['height'];
            $quality    = 80; //$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , false , false ,$quality ); //excute the code to resize image
        }
        // get the thumb image 
        if(makeDir('dirfiles/_thumb/') === true){
            $directoryName ='dirfiles/_thumb/';
            $targetedFile = $directoryName.$image1; // uploaded file path with customize name
            $width      = 100; //$_POST['width'];
            $height     = 50; //$_POST['height'];
            $quality    = 80;//$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , false , false ,$quality ); //excute the code to resize image
        }
	}
	// $dateAdded=time();
	$namevalue ='name="'.$image1.'",title="'.$title.'",parentId="'.$hotelid.'",galleryType="packagehotelmaster"';
	$adds = addlisting(_IMAGE_GALLERY_MASTER_,$namevalue);
	?>
	<script>
	parent.setupbox('showpage.crm?module=packagehotelmaster&view_gallery=2&hotelid=<?php echo $hotelId;?>');
	</script> 
<?php }
if(trim($_POST['action'])=='addedit_visacountry' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
if(isset($_POST['documents'])){
foreach($_POST['documents'] as $k1=>$v1){
$documents.= $_POST['documents'][$k1].',';
}
}
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_VISA_COUNTRY_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This country already exist.');
</script>
<?php
} else {
$namevalue ='documents="'.$documents.'",name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_VISA_COUNTRY_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
/////////add visa type
if(trim($_POST['action'])=='addedit_visatype' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate('visaType',$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This Visa Type already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting('visaType',$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
///edit visa type
if(trim($_POST['action'])=='addedit_visatype' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting('visaType',$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_visacountry' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
if(isset($_POST['documents'])){
foreach($_POST['documents'] as $k1=>$v1){
$documents.= $_POST['documents'][$k1].',';
}
}
 
$where='id='.$_POST['editId'].''; 
$namevalue ='documents="'.$documents.'",name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_VISA_COUNTRY_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_visadocument' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_VISA_DOCUMENT_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This country already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_VISA_DOCUMENT_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_visadocument' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_VISA_DOCUMENT_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_visasubdocument' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$docId=clean($_POST['documentsubId']);  
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate(_VISA_DOCUMENT_MASTER_,$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This Document already exist.');
</script>
<?php
} else {
$namevalue ='name="'.$name.'",docId="'.$docId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting(_VISA_DOCUMENT_MASTER_,$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_visasubdocument' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$docId=clean($_POST['documentsubId']); 
$modifyDate=time();
 
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",docId="'.$docId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting(_VISA_DOCUMENT_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 
if(trim($_POST['action'])=='addedit_documentvisacountry' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']); 
$docId=clean($_POST['docId']); 
$countryId=clean($_POST['countryId']); 
if(isset($_POST['documentsub'])){
foreach($_POST['documentsub'] as $k1=>$v1){
$documentsub.= $_POST['documentsub'][$k1].',';
}
}
$dateAdded=time();
$where='name="'.$name.'" and deletestatus=0';  
$addnewyes = checkduplicate('visaDocumentCountry',$where); 
if($addnewyes=='yes'){
?>
<script>
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
alert('This country already exist.');
</script>
<?php
} else {
$namevalue ='countryId="'.$countryId.'",docId="'.$docId.'",subId="'.$documentsub.'"';  
$adds = addlisting('visaDocumentCountry',$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=visacountry&document=1&countryId=<?php echo encode($_POST['countryId']); ?>');
</script> 
<?php } }
if(trim($_POST['action'])=='addedit_documentvisacountry' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
$name=clean($_POST['name']);
$docId=clean($_POST['docId']);
$countryId=$_POST['countryId']; 
$modifyDate=time();
if(isset($_POST['documentsub'])){
foreach($_POST['documentsub'] as $k1=>$v1){
$documentsub.= $_POST['documentsub'][$k1].',';
}
}
$where='id="'.$_POST['editId'].'"';
$namevalue ='countryId="'.$countryId.'",docId="'.$docId.'",subId="'.$documentsub.'"';  
$update = updatelisting('visaDocumentCountry',$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=visacountry&document=1&countryId=<?php echo encode($_POST['countryId']); ?>');
</script> 
<?php } 
 
 
///delte visa document
if($_REQUEST['action']=='deletevisadocument'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('visaDocumentMaster',$namevalue,$where); 
 
generateLogs('Visa Document','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=visadocument&alt=3');
</script>
<?php
}
///delete visa sub documnet///////////////
if($_REQUEST['action']=='deletevisasubdocument'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('visaDocumentMaster',$namevalue,$where); 
 
generateLogs('Visa Sub Document','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=visasubdocument&alt=3');
</script>
<?php
} 
 
 
 
 
 ///delete visa sub documnet///////////////
if($_REQUEST['action']=='deletevisatype'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
 
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('visaType',$namevalue,$where); 
 
generateLogs('Visa Type','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=visatype&alt=3');
</script>
<?php
} 
 
if(trim($_POST['action'])=='addedit_otherActivityMaster' && trim($_POST['editId'])=='' && trim($_POST['otherActivityName'])!=''){ 
	
	$otherActivityName=clean($_POST['otherActivityName']); 
	$otherActivityCity=clean($_POST['otherActivityCity']); 
	$otherActivityDetail=clean($_POST['otherActivityDetail']); 
	$inclExclTim=clean($_POST['inclExclTim']); 
	$impNote=clean($_POST['impNote']); 
	$otherActivityType=clean($_POST['otherActivityType']);
	$isDefault=clean($_POST['isDefault']); 
	// inclExclTim,impNote 
	$transferType=clean($_POST['transferType']);  
	$isOptTours=clean($_POST['isOptTours']);  
	$adultCost=clean($_POST['adultCost']);  
	$childCost=clean($_POST['childCost']);  
	$isOptCurrency=clean($_POST['isOptCurrencyId']);  
 
	$status=clean($_POST['status']);  
	if(!empty($_FILES['otherActivityImage']['name'])){  
		$file_name=time().$_FILES['otherActivityImage']['name'];  
		copy($_FILES['otherActivityImage']['tmp_name'],"packageimages/".$file_name); 
	}
	
	$dateAdded=time();
	
	// check the otheractivityName and otheractivityCity variable 
	$rs3=GetPageRecord('id',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$otherActivityName.'" and otherActivityCity="'.$otherActivityCity.'"');
	
	
	if(mysqli_num_rows($rs3)<1){


	// Activity Code genrated 
	$A = GetPageRecord('displayId',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'displayId>0 order by displayId desc');
	$ddata = mysqli_fetch_assoc($A);
	$displayId = $ddata['displayId']+1;

	$namevalue ='otherActivityName="'.$otherActivityName.'",otherActivityCity="'.$otherActivityCity.'",isDefault="'.$isDefault.'",isOptTours="'.$isOptTours.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$isOptCurrency.'",otherActivityDetail="'.$otherActivityDetail.'",inclExclTim="'.$inclExclTim.'",impNote="'.$impNote.'",otherActivityImage="'.$file_name.'",otherActivityType="'.$otherActivityType.'",status="'.$status.'",transferType="'.$transferType.'",displayId="'.$displayId .'"';  
	$lastId = addlistinggetlastid(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$namevalue); 

	$descValue = 'lang_01="'.$otherActivityDetail.'",ActivityId="'.$lastId.'"';
	addlisting('activityLanguageMaster',$descValue);

	?>
	<script>
	parent.setupbox('showpage.crm?module=otherActivityMaster&alt=1');
	</script> 
<?php 
}else{
	    // else data found greater than 1 alert should show
	    ?>
    	<script>
    	parent.alert('Activity Name and City already exists !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
	}
}





if(trim($_POST['action'])=='addedit_otherActivityMaster' && trim($_POST['editId'])!='' && trim($_POST['otherActivityName'])!=''){ 
$otherActivityName=clean($_POST['otherActivityName']); 
$otherActivityCity=clean($_POST['otherActivityCity']); 
$otherActivityDetail=clean($_POST['otherActivityDetail']); 
$inclExclTim=clean($_POST['inclExclTim']); 
$impNote=clean($_POST['impNote']); 

$otherActivityType=clean($_POST['otherActivityType']);    
$status=clean($_POST['status']); 
$isDefault=clean($_POST['isDefault']); 
$transferType=clean($_POST['transferType']);  
$isOptTours=clean($_POST['isOptTours']); 
$adultCost=clean($_POST['adultCost']);  
$childCost=clean($_POST['childCost']);
$isOptCurrency=clean($_POST['isOptCurrencyId']);   

$editId=clean($_POST['editId']); 
if(!empty($_FILES['otherActivityImage']['name'])){  
	$file_name=time().$_FILES['otherActivityImage']['name'];  
	copy($_FILES['otherActivityImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
	$file_name=$_REQUEST['otherActivityImage2'];
}
$dateAdded=time();
	
	// check the otheractivityName and otheractivityCity variable 
	$rs3=GetPageRecord('id',_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,'otherActivityName="'.$otherActivityName.'" and otherActivityCity="'.$otherActivityCity.'" and id !="'.$_POST['editId'].'"');
	
	
	if(mysqli_num_rows($rs3)<1){  
	    
	    $namevalue ='otherActivityName="'.$otherActivityName.'",otherActivityCity="'.$otherActivityCity.'",otherActivityDetail="'.$otherActivityDetail.'",inclExclTim="'.$inclExclTim.'",impNote="'.$impNote.'",isDefault="'.$isDefault.'",isOptTours="'.$isOptTours.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",currencyId="'.$isOptCurrency.'",otherActivityImage="'.$file_name.'",otherActivityType="'.$otherActivityType.'",status="'.$status.'",transferType="'.$transferType.'"'; 
		$where='id="'.$_POST['editId'].'"'; 
		$update = updatelisting(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$namevalue,$where); 

		if($update=='yes'){

			$descValue = 'lang_01="'.$otherActivityDetail.'",ActivityId="'.$_POST['editId'].'"';
			$resac = GetPageRecord('*','activityLanguageMaster','ActivityId="'.$_POST['editId'].'"');
			if(mysqli_num_rows($resac)>0){
				$resactivitydesc = mysqli_fetch_assoc($resac);
				$whereId = 'id="'.$resactivitydesc['id'].'"';
				updatelisting('activityLanguageMaster',$descValue,$whereId);
			}else{
				addlisting('activityLanguageMaster',$descValue);
			}
		}

?>
<script>
parent.setupbox('showpage.crm?module=otherActivityMaster&alt=2');
</script> 
<?php

	}else{  
	    
	     ?>
    	<script>
    	parent.alert('Activity Name and City already exists !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    // 	parent.setupbox('showpage.crm?module=otherActivityMaster&alt=2');
    	</script> 
    	<?php
	}

  
}





// ENROUTE MASTER
if(trim($_POST['action'])=='addedit_enrouteMaster' && trim($_POST['editId'])=='' && trim($_POST['enrouteName'])!=''){ 
	
	$enrouteName=clean($_POST['enrouteName']); 
	$enrouteCity=clean($_POST['enrouteCity']); 
	$enrouteDetail=cleanNonAsciiCharactersInString($_POST['enrouteDetail']); 
	$enrouteType=clean($_POST['enrouteType']);  
	$adultCost=clean($_POST['adultCost']);  
	$childCost=clean($_POST['childCost']);
	$infantCost=clean($_POST['infantCost']);
	$isDefault=clean($_POST['isDefault']);
	$currencyId=clean($_POST['currencyId']);  
	$status=clean($_POST['status']);  
	if(!empty($_FILES['enrouteImage']['name'])){  
		$file_name=time().$_FILES['enrouteImage']['name'];  
		copy($_FILES['enrouteImage']['tmp_name'],"packageimages/".$file_name); 
	} 
	$dateAdded=time();
	
	// check the enrouteName and enrouteCity variable 
	$rs2=GetPageRecord('id',_PACKAGE_BUILDER_ENROUTE_MASTER_,'enrouteName="'.$enrouteName.'" and enrouteCity="'.$enrouteCity.'"');
	// above query is equale to 
	// $rs2 = mysqli_query(db(), ' Select id from '._PACKAGE_BUILDER_ENROUTE_MASTER_.'enrouteName="'.$enrouteName.'",enrouteCity="'.$enrouteCity.'"');
	
	
	if(mysqli_num_rows($rs2)<1){
	    // if same data found less than one then data should be inserted
	
    	$namevalue ='enrouteName="'.$enrouteName.'",enrouteCity="'.$enrouteCity.'",enrouteDetail="'.$enrouteDetail.'",enrouteImage="'.$file_name.'",isDefault="'.$isDefault.'",enrouteType="'.$enrouteType.'",status="'.$status.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",currencyId="'.$currencyId.'"';  
    	 $adds = addlisting(_PACKAGE_BUILDER_ENROUTE_MASTER_,$namevalue); 
    	?>
    	<script>
    	parent.setupbox('showpage.crm?module=enroutemaster&alt=1');
    	</script> 
    	<?php  
	}else{
	    // else data found greater then 0 alert should show
	    ?>
    	<script>
    	parent.alert('Duplicate data found !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    // 	parent.setupbox('showpage.crm?module=enroutemaster');
    	</script> 
    	<?php
	}
} 

if(trim($_POST['action'])=='addedit_enrouteMaster' && trim($_POST['editId'])!='' && trim($_POST['enrouteName'])!=''){ 
$enrouteName=clean($_POST['enrouteName']); 
$enrouteCity=clean($_POST['enrouteCity']); 
$enrouteDetail=cleanNonAsciiCharactersInString($_POST['enrouteDetail']);
$enrouteType=clean($_POST['enrouteType']); 
$adultCost=clean($_POST['adultCost']);  
$childCost=clean($_POST['childCost']); 
$infantCost=clean($_POST['infantCost']); 
$isDefault=clean($_POST['isDefault']);     
$status=clean($_POST['status']);  
$editId=clean($_POST['editId']); 
$currencyId=clean($_POST['currencyId']);
if(!empty($_FILES['enrouteImage']['name'])){  
	$file_name=time().$_FILES['enrouteImage']['name'];  
	copy($_FILES['enrouteImage']['tmp_name'],"packageimages/".$file_name); 
}else{ 
	$file_name=$_REQUEST['enrouteImage2'];
} 
$dateAdded=time(); 

$rs2=GetPageRecord('id',_PACKAGE_BUILDER_ENROUTE_MASTER_,'enrouteName="'.$enrouteName.'" and enrouteCity="'.$enrouteCity.'" and id != "'.$_POST['editId'].'"');

if(mysqli_num_rows($rs2)<1){
    $namevalue ='enrouteName="'.$enrouteName.'",enrouteCity="'.$enrouteCity.'",enrouteDetail="'.$enrouteDetail.'",enrouteImage="'.$file_name.'",isDefault="'.$isDefault.'",enrouteType="'.$enrouteType.'",status="'.$status.'",adultCost="'.$adultCost.'",childCost="'.$childCost.'",infantCost="'.$infantCost.'",currencyId="'.$currencyId.'"'; 
$where='id='.$_POST['editId'].''; 
$update = updatelisting(_PACKAGE_BUILDER_ENROUTE_MASTER_,$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=enroutemaster&alt=2');
</script> 
<?php  
    
}else{
    	    ?>
    	<script>
    	parent.alert('Duplicate data found !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    // 	parent.setupbox('showpage.crm?module=enroutemaster');

    	</script> 
    	<?php
    
}

}

if(trim($_POST['action'])=='addedit_tourmanager' && trim($_POST['name'])!=''){ 

	$name=clean($_POST['name']); 

	$phone=clean($_POST['phone']); 
	$whatsappphone=clean($_POST['whatsappphone']); 
	$alternatephone=clean($_POST['alternatephone']); 

	$email=addslashes($_POST['email']);  

	$address=clean($_POST['address']);  

 	$destinationList = implode(',', $_POST['destinationList']);  
	$languageList = implode(',', $_POST['languageList']);  
	
	$qualification=clean($_POST['qualification']);  

	$description=cleanNonAsciiCharactersInString($_POST['description']); 

	$birthDate=clean($_POST['birthDate']); 

	$joinDate=clean($_POST['joinDate']); 

	$panNo=clean($_POST['panNo']); 

	$aadharNo=clean($_POST['aadharNo']); 

	$licenseNo=clean($_POST['licenseNo']);  

	$status=clean($_POST['status']);   

	if(!empty($_FILES['image']['name'])){  

		$image=time().$_FILES['image']['name'];  

		copy($_FILES['image']['tmp_name'],"packageimages/".$image); 



	} else{



		$image = clean($_POST['image2']);



	}



	



	$date=time();



	$userId = $_SESSION['userid'];



	$userIp = $_SERVER['REMOTE_ADDR'];



	



	$namevalue ='name="'.$name.'",whatsappphone="'.$whatsappphone.'",alternatephone="'.$alternatephone.'",phone="'.$phone.'",email="'.$email.'",qualification="'.$qualification.'",description="'.$description.'",birthDate="'.$birthDate.'",joinDate="'.$joinDate.'",panNo="'.$panNo.'",licenseNo="'.$licenseNo.'",createdBy="'.$userId.'",userIp="'.$userIp.'",createdOn="'.$date.'",image="'.$image.'",aadharNo="'.$aadharNo.'",address="'.$address.'",status="'.$status.'",languageList="'.$languageList.'",destinationList="'.$destinationList.'"';



	



	if(trim($_POST['editId'])!=''){



		$where='id="'.$_POST['editId'].'"'; 



		$update = updatelisting('tourmanager',$namevalue,$where); 



		$msgbox = 2;



	}else{



		$adds = addlisting('tourmanager',$namevalue); 



		$msgbox = 1;



	}



	?>



	<script>



	parent.setupbox('showpage.crm?module=tourmanager&alt=<?php echo $msgbox; ?>');



	</script> 



	<?php 



}
 
if(trim($_POST['action'])=='addedit_guidemaster' && trim($_POST['name'])!=''){ 
	$name=clean($_POST['name']); 
	$countryId2=clean($_POST['countryId2']); 
	$stateId2=clean($_POST['stateId2']); 
	$cityId2=clean($_POST['cityId2']); 
	$pinCode2=clean($_POST['pinCode2']);
	$phone=clean($_POST['phone']); 
	$whatsappphone=clean($_POST['whatsappphone']); 
	$alternatephone=clean($_POST['alternatephone']); 
	$email=addslashes($_POST['email']);  
	$address=clean($_POST['address']);
	$status = clean($_POST['status']);
	//print_r($_POST['destinationId']);
	if($_POST['destinationId'][0]=='all'){
		$rs=GetPageRecord('id',_DESTINATION_MASTER_,' name!="" and deletestatus=0 order by id asc');  
		while($resListing=mysqli_fetch_array($rs)){  
			$allDestination.=strip($resListing['id']).',';
		}
		$destinationList=rtrim($allDestination,',');
		$destinationType=1;
	}else{ 
 		$destinationList = implode(',', $_POST['destinationId']);   
		$destinationType=0;
	}
	$languageList = implode(',', $_POST['languageList']);  
	
	$qualification=clean($_POST['qualification']);  
	$serviceType=clean($_POST['serviceType']);  
	$description=clean($_POST['description']); 
	$birthDate=clean($_POST['birthDate']); 
	$joinDate=clean($_POST['joinDate']); 
	$panNo=clean($_POST['panNo']); 
	$aadharNo=clean($_POST['aadharNo']); 
	$licenseNo=clean($_POST['licenseNo']);  
	$supplier=clean($_POST['supplier']);   
	$guideLicence=clean($_POST['guideLicence']);   
	if(!empty($_FILES['guideImage']['name'])){  
		$image=time().$_FILES['guideImage']['name'];  
		copy($_FILES['guideImage']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = clean($_POST['guideImage2']);
	}
	
	$date=time();

	// duplicate code added
	$rsr=GetPageRecord('*',_GUIDE_MASTER_,'name="'.$name.'" ');
	// $editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0){
        ?>
        <script>
        parent.alert('This Tour Escort/TOUR MANAGER Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		exit();
    }
    else{
		$userId = $_SESSION['userid'];
		$userIp = $_SERVER['REMOTE_ADDR'];
		$licenceExpiry=date('Y-m-d',strtotime($_POST['licenceExpiry']));
		 echo  $namevalue ='name="'.$name.'",whatsappphone="'.$whatsappphone.'",serviceType="'.$serviceType.'",alternatephone="'.$alternatephone.'",phone="'.$phone.'",email="'.$email.'",qualification="'.$qualification.'",description="'.$description.'",birthDate="'.$birthDate.'",joinDate="'.$joinDate.'",panNo="'.$panNo.'",licenseNo="'.$licenseNo.'",createdBy="'.$userId.'",userIp="'.$userIp.'",createdOn="'.$date.'",image="'.$image.'",aadharNo="'.$aadharNo.'",address="'.$address.'",status="'.$status.'",supplier="'.$supplier.'",languageList="'.$languageList.'",destinationList="'.$destinationList.'",guideLicence="'.$guideLicence.'",licenceExpiry="'.$licenceExpiry.'",destinationType="'.$destinationType.'",countryId="'.$countryId2.'",stateId="'.$stateId2.'",cityId="'.$cityId2.'",pinCode="'.$pinCode2.'"';
		 
		 //-----------------------
		if(trim($_POST['editId'])!=''){
			$where='id="'.$_POST['editId'].'"'; 
			$update = updatelisting(_GUIDE_MASTER_,$namevalue,$where); 
			$msgbox = 2;
		}else{
			$adds = addlisting(_GUIDE_MASTER_,$namevalue); 
			$msgbox = 1;
		}
		
		//-----------------------
		$address=clean($_POST['address']); 
		$phone=$_POST['phone'];
		$email=clean($_POST['email']); 
		$supplier=$_POST['supplier'];
		
		$gstn=clean($_POST['gstn']); 
		$contactPerson=$_POST['contactPerson'];
		$designation=$_POST['designation'];
	
		$countryId=($_POST['countryId2']); 
		$stateId=clean($_POST['stateId2']);
		$cityId=clean($_POST['cityId2']);  
		$pinCode=clean($_POST['pinCode2']);   
		  
		$selects='*';  
		$wheres='name="'.$name.'" and guideType=1'; 
		$rss=GetPageRecord($selects,_SUPPLIERS_MASTER_,$wheres);  
		
		if($supplier=='1' && mysqli_num_rows($rss) < 1){
	
			$dateAdded=time();
			$namevalue ='name="'.$name.'",aliasname="'.$name.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',guideType=1,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destinationList.'"';  
			$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);
			// tour escort master page hanging 
			 
			echo $namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
			addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
			
			$allvaluecontactperson ='contactPerson="'.$contactPerson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.$phone.'",email="'.$email.'",primaryvalue="1",division="2"';
			addlisting('suppliercontactPersonMaster',$allvaluecontactperson);
		  
		} 
		  
		
		?> <script>
		 parent.setupbox('showpage.crm?module=guidemaster&alt=<?php echo $msgbox; ?>');
		</script>  
		<?php

	}





	 
}  

if(trim($_POST['action'])=='addedit_guidesubcatmaster' && trim($_POST['name'])!=''){ 
	
	$name=clean($_POST['name']); 
	$price=clean($_POST['price']); 	
	$serviceType=clean($_POST['serviceType']); 
	$guideRule=clean($_POST['guideRule']); 
	$dayType=clean($_POST['dayType']);
	$isDefault=clean($_POST['isDefault']); 
	$paxRange=clean($_POST['paxRange']); 
	$description=clean($_POST['description']); 
	$guideId=clean($_POST['guideId']); 
	$destinationId=clean($_POST['destinationId']); 
	$status=clean($_POST['status']); 
		
	$date=time();
	$userId = $_SESSION['userid'];
	$userIp = $_SERVER['REMOTE_ADDR'];
	
	$namevalue ='name="'.$name.'",guideId="'.$guideId.'",destinationId="'.$destinationId.'",serviceType="'.$serviceType.'",dayType="'.$dayType.'",price="'.$price.'",paxRange="'.$paxRange.'",isDefault="'.$isDefault.'",createdBy="'.$userId.'",userIp="'.$userIp.'",createdOn="'.$date.'",status="'.$status.'"';
	
	if(trim($_POST['editId'])!=''){
		
		// find the value guide / porter service type 
		$rs3=GetPageRecord('id',_GUIDE_SUB_CAT_MASTER_,'name="'.$name.'" and serviceType="'.$serviceType.'" and id != "'.$_POST['editId'].'"');
	    if(mysqli_num_rows($rs3)<1){
	        $namevalue ='name="'.$name.'",guideId="'.$guideId.'",destinationId="'.$destinationId.'",serviceType="'.$serviceType.'",dayType="'.$dayType.'",price="'.$price.'",paxRange="'.$paxRange.'",isDefault="'.$isDefault.'",createdBy="'.$userId.'",userIp="'.$userIp.'",createdOn="'.$date.'",status="'.$status.'"';
	        $where='id="'.$_POST['editId'].'"'; 
			$update = updatelisting(_GUIDE_SUB_CAT_MASTER_,$namevalue,$where); 
			$msgbox = 2;
		
			?>
			<script>
			parent.setupbox('showpage.crm?module=guidesubcatmaster&alt=<?php echo $msgbox; ?>');
			</script> 
			<?php 
	    }else{
	        ?>
			<script>
			// edit time duplicate Guide porter price code      
			parent.alert('Guide name already exists');
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			</script> 
			<?php 
	    }
		
	}else{
	    
	    $rs3=GetPageRecord('id',_GUIDE_SUB_CAT_MASTER_,'name="'.$name.'" and serviceType="'.$serviceType.'"');
	    if(mysqli_num_rows($rs3)<1){
	        $namevalue ='name="'.$name.'",guideId="'.$guideId.'",destinationId="'.$destinationId.'",serviceType="'.$serviceType.'",dayType="'.$dayType.'",price="'.$price.'",paxRange="'.$paxRange.'",isDefault="'.$isDefault.'",createdBy="'.$userId.'",userIp="'.$userIp.'",createdOn="'.$date.'",status="'.$status.'"';
	        $adds = addlisting(_GUIDE_SUB_CAT_MASTER_,$namevalue); 
			$msgbox = 1;
		
			?>
			<script>
			parent.setupbox('showpage.crm?module=guidesubcatmaster&alt=<?php echo $msgbox; ?>');
			</script> 
			<?php 
	    }else{
	        ?>
			<script>
			// added time find duplicate guide porter price   
			parent.alert('Guide name already exists');
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			</script> 
			<?php 
	    }
		
	}

//this line

}  

//==================================Add Restaurant here====================================

if(trim($_POST['action'])=='addedit_inboundmealplanmaster' && trim($_POST['mealPlanName'])!=''){ 
	
	$mealPlanName=clean($_POST['mealPlanName']); 
	$mealPlanCity=clean($_POST['mealPlanCity']); 
	$destinationId=clean($_POST['destinationId']); 
	$mealPlanDetail=addslashes($_POST['mealPlanDetail']);
	$mealPlanType=clean($_POST['mealPlanType']); 
	$dateMealPlan=date('Y-m-d',strtotime($_POST['dateMealPlan']));   
	$adultCostLunch=clean($_POST['adultCostLunch']);  
	$childCostLunch=clean($_POST['childCostLunch']);   
	$infantCostLunch=clean($_POST['infantCostLunch']);   
	$adultCostDinner=clean($_POST['adultCostDinner']);  
	$childCostDinner=clean($_POST['childCostDinner']);
	$infantCostDinner=clean($_POST['infantCostDinner']);
	$supplierNameId=clean($_POST['supplierNameId']);   
	$status=clean($_POST['status']); 
	$editId=clean($_POST['editId']);
	$gstn=clean($_POST['gstn']); 
	$supplier=$_POST['supplier'];

	$division=$_POST['division1'];
	$contactPerson=$_POST['contactPerson'];
	$designation=$_POST['designation1'];
	$phone=$_POST['phone1'];
	$phone2=$_POST['phone2'];
	$phone3=$_POST['phone3'];
	$countryCode1=$_POST['countryCode1'];
	
	
	$email=clean($_POST['email1']);

	$countryId=($_POST['countryId2']); 
	$stateId=clean($_POST['stateId2']);
	$cityId=clean($_POST['cityId2']);  
	$pinCode=clean($_POST['pinCode']);  
	$hotelAddress=clean($_POST['hotelAddress']);
	
	
	if(!empty($_FILES['mealPlanImage']['name'])){  
		$file_name=time().$_FILES['mealPlanImage']['name'];  
		copy($_FILES['mealPlanImage']['tmp_name'],"packageimages/".$file_name); 
	}else{ 
		$file_name=$_REQUEST['mealPlanImage2'];
	}
	
	
	// add restaurant new duplicated code
	


	$rs2=GetPageRecord('id',_INBOUND_MEALPLAN_MASTER_,'mealPlanName="'.$mealPlanName.'" and mealPlanCity="'.$mealPlanCity.'" and destinationId="'.$destinationId.'" and id!="'.$_POST['editId'].'"');
	if(mysqli_num_rows($rs2)<1){

			// Monument Code genrated 
			$A = GetPageRecord('displayId',_INBOUND_MEALPLAN_MASTER_,'displayId>0 order by displayId desc');
			$ddata = mysqli_fetch_assoc($A);
			$displayId = $ddata['displayId']+1;

	    	$namevalue ='mealPlanName="'.$mealPlanName.'",mealPlanCity="'.$mealPlanCity.'",destinationId="'.$destinationId.'",mealPlanDetail="'.$mealPlanDetail.'",mealPlanImage="'.$file_name.'",mealPlanType="'.$mealPlanType.'",status="'.$status.'",adultCostLunch="'.$adultCostLunch.'",childCostLunch="'.$childCostLunch.'",adultCostDinner="'.$adultCostDinner.'",childCostDinner="'.$childCostDinner.'",supplierNameId="'.$supplierNameId.'",supplier="'.$supplier.'",deletestatus="0",displayId="'.$displayId .'"'; 
	
	
	if(trim($_POST['editId'])!=''){
	   $where='id="'.$_POST['editId'].'"'; 
		$update = updatelisting(_INBOUND_MEALPLAN_MASTER_,$namevalue,$where); 
		$msgbox = 2;
		
		
		if($supplier=='1'){ 

			$selects='*';  
			$wheres='name="'.trim($_POST['mealPlanName']).'"'; 
			$rss=GetPageRecord($selects,_SUPPLIERS_MASTER_,$wheres); 
			if(mysqli_num_rows($rss) > 0){
				$suplierresult=mysqli_fetch_array($rss);
 
	        	$dateAdded=time();
		    	$namevalue ='name="'.$mealPlanName.'",aliasname="'.$mealPlanName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',mealType=6,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destinationId.'",restaurantId="'.$_POST['editId'].'"';
		      if($suplierresult['id']!=''){
	            $where='id="'.$suplierresult['id'].'"'; 
			      $update = updatelisting(_SUPPLIERS_MASTER_,$namevalue,$where); 
			   }else{
			   	$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);
			   }

			   $selecta='*';  
				$wherea='addressParent="'.$suplierresult['id'].'"'; 
				$rsa=GetPageRecord($selecta,_ADDRESS_MASTER_,$wherea); 
				$addressresult=mysqli_fetch_array($rsa);

			   if ($addressresult['id']!='') {
			    	$namevalue ='addressParent="'.$addressresult['addressParent'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
			    	$where='id="'.$addressresult['id'].'"'; 
			        $update = updatelisting(_ADDRESS_MASTER_,$namevalue,$where); 
			   }else{ 
			    	$namevalue ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
			    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
			   }

			   $selectsc='*';  
				$wheresc='corporateId="'.$suplierresult['id'].'"'; 
				$rssc=GetPageRecord($selectsc,'suppliercontactPersonMaster',$wheresc); 
				$scontactresult=mysqli_fetch_array($rssc);

			   if ($scontactresult['id']!='') {
			    	$allvaluecontactperson ='contactPerson="'.$contactPerson.'",corporateId="'.$scontactresult['corporateId'].'",designation="'.$designation.'",phone="'.encode($phone).'",phone2="'.encode($phone2).'",phone3="'.encode($phone3).'",countryCode="'.$countryCode1.'",email="'.encode($email).'",primaryvalue="1",division="'.$division.'"';
			    	$where='id="'.$scontactresult['id'].'"'; 
					
			        $update = updatelisting('suppliercontactPersonMaster',$allvaluecontactperson,$where);
			   }else{
			    	$allvaluecontactperson ='contactPerson="'.$contactPerson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.encode($phone).'",phone2="'.encode($phone2).'",phone3="'.encode($phone3).'",countryCode="'.$countryCode1.'",email="'.encode($email).'",primaryvalue="1",division="'.$division.'"';
				
			    	addlisting('suppliercontactPersonMaster',$allvaluecontactperson);
			   }


			   // restaurant self address 
			   $selecta='*';  
				$wherea='addressParent="'.$_POST['editId'].'"'; 
				$rsa=GetPageRecord($selecta,_ADDRESS_MASTER_,$wherea); 
				$addressresult=mysqli_fetch_array($rsa);

			   if ($addressresult['id']!='') {
			    	$namevalue ='addressParent="'.$addressresult['addressParent'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
			    	$where='id="'.$addressresult['id'].'"'; 
			        $update = updatelisting(_ADDRESS_MASTER_,$namevalue,$where); 
			   }else{ 
			    	$namevalue ='addressParent="'.$_POST['editId'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
			    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue);
			   }

			   // restaurant self contact person 
			   $selectsc='*';  
				$wheresc='restaurantId="'.$_POST['editId'].'"'; 
				$rssc=GetPageRecord($selectsc,'restaurantContactPersonMaster',$wheresc); 
				$scontactresult=mysqli_fetch_array($rssc);

			   if ($scontactresult['id']!='') {
			    	$allvaluecontactperson ='contactPerson="'.$contactPerson.'",restaurantId="'.$scontactresult['restaurantId'].'",designation="'.$designation.'",countryCode="'.$countryCode1.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
		    		$where='id="'.$scontactresult['id'].'"'; 
					
		        $update = updatelisting('restaurantContactPersonMaster',$allvaluecontactperson,$where);
			   }else{
			    	$allvaluecontactperson ='contactPerson="'.$contactPerson.'",restaurantId="'.$_POST['editId'].'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
					
			    	addlisting('restaurantContactPersonMaster',$allvaluecontactperson);
			   }  

			}else{

				$dateAdded=time();
				
		    	$namevalue ='name="'.$mealPlanName.'",aliasname="'.$mealPlanName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',mealType=6,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destinationId.'",restaurantId="'.$_POST['editId'].'"';
			   $lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue);
			  
		    	$namevalue2 ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"';  
		  		addlistinggetlastid(_ADDRESS_MASTER_,$namevalue2);


		    	$allvaluecontactperson ='contactPerson="'.$contactPerson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.encode($phone).'",phone2="'.encode($phone2).'",phone3="'.encode($phone3).'",countryCode="'.$countryCode1.'",email="'.encode($email).'",primaryvalue="1",division="'.$division.'"';
				
		    	addlisting('suppliercontactPersonMaster',$allvaluecontactperson);
			

			   // restaurant self address 
			   $selecta='*';  
				$wherea='addressParent="'.$_POST['editId'].'"'; 
				$rsa=GetPageRecord($selecta,_ADDRESS_MASTER_,$wherea); 
				$addressresult=mysqli_fetch_array($rsa);

			   if ($addressresult['id']!='') {
			    	$namevalue3 ='addressParent="'.$addressresult['addressParent'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
			    	$where='id="'.$addressresult['id'].'"'; 
			        $update = updatelisting(_ADDRESS_MASTER_,$namevalue3,$where); 
			   }else{ 
			    	$namevalue3 ='addressParent="'.$_POST['editId'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
			    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue3);
			   }

			   // restaurant self contact person 
			   $selectsc='*';  
				$wheresc='restaurantId="'.$_POST['editId'].'"'; 
				$rssc=GetPageRecord($selectsc,'restaurantContactPersonMaster',$wheresc); 
				$scontactresult=mysqli_fetch_array($rssc);

			   if ($scontactresult['id']!='') {
			    	$namevalue4 ='contactPerson="'.$contactPerson.'",restaurantId="'.$scontactresult['restaurantId'].'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
		    		$where='id="'.$scontactresult['id'].'"'; 
					
		        $update = updatelisting('restaurantContactPersonMaster',$namevalue4,$where);
			   }else{
			    	$namevalue4 ='contactPerson="'.$contactPerson.'",restaurantId="'.$_POST['editId'].'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
					
			    	addlisting('restaurantContactPersonMaster',$namevalue4);
			   }  

			}
			


		   // restaurant self address 
		   $selecta='*';  
			$wherea='addressParent="'.$_POST['editId'].'"'; 
			$rsa=GetPageRecord($selecta,_ADDRESS_MASTER_,$wherea); 
			$addressresult=mysqli_fetch_array($rsa);

		   if ($addressresult['id']!='') {
		    	$namevalue3 ='addressParent="'.$addressresult['addressParent'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
		    	$where='id="'.$addressresult['id'].'"'; 
		        $update = updatelisting(_ADDRESS_MASTER_,$namevalue3,$where); 
		   }else{ 
		    	$namevalue3 ='addressParent="'.$_POST['editId'].'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
		    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue3);
		   }

		   // restaurant self contact person 
		   $selectsc='*';  
			$wheresc='restaurantId="'.$_POST['editId'].'"'; 
			$rssc=GetPageRecord($selectsc,'restaurantContactPersonMaster',$wheresc); 
			$scontactresult=mysqli_fetch_array($rssc);

		   if ($scontactresult['id']!='') {
		    	$namevalue4 ='contactPerson="'.$contactPerson.'",restaurantId="'.$scontactresult['restaurantId'].'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
	    		$where='id="'.$scontactresult['id'].'"'; 
				
	        $update = updatelisting('restaurantContactPersonMaster',$namevalue4,$where);
		   }else{
		    	$namevalue4 ='contactPerson="'.$contactPerson.'",restaurantId="'.$_POST['editId'].'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
				
		    	addlisting('restaurantContactPersonMaster',$namevalue4);
		   }  
 
		} 

	}else{ 
	
		
		
		$adds = addlistinggetlastid(_INBOUND_MEALPLAN_MASTER_,$namevalue); 
		$msgbox = 1;
		if($supplier=='1'){ 
			
			$dateAdded=time();



	    	$namevalue1 ='name="'.$mealPlanName.'",aliasname="'.$mealPlanName.'",contactPerson="'.$contactPerson.'",addedBy='.$_SESSION['userid'].',dateAdded='.$dateAdded.',mealType=6,supplierMainType=1,paymentTerm=1,agreement=0,destinationId="'.$destinationId.'",restaurantId="'.$adds.'"'; 
	    	$lastId = addlistinggetlastid(_SUPPLIERS_MASTER_,$namevalue1);

	    	$namevalue2 ='addressParent="'.$lastId.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="supplier"'; 
			
	    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue2);

	   
         $namevalue3 ='contactPerson="'.$contactPerson.'",corporateId="'.$lastId.'",designation="'.$designation.'",phone="'.encode($phone).'",phone2="'.encode($phone2).'",phone3="'.encode($phone3).'",countryCode="'.$countryCode1.'",email="'.encode($email).'",primaryvalue="1",division="'.$division.'"';
		
	    	addlisting('suppliercontactPersonMaster',$namevalue3);	
		    	
		} 

		// restaurant self address 
    	$namevalue4 ='addressParent="'.$adds.'",countryId="'.$countryId.'",stateId="'.$stateId.'",cityId="'.$cityId.'",pinCode="'.$pinCode.'",address="'.$hotelAddress.'",gstn="'.$gstn.'",primaryAddress="1",addressType="restaurant"';  
    	 addlistinggetlastid(_ADDRESS_MASTER_,$namevalue4);
	   
	   // restaurant self contact person 
    	$namevalue5 ='contactPerson="'.$contactPerson.'",restaurantId="'.$adds.'",designation="'.$designation.'",phone="'.$phone.'",phone2="'.$phone2.'",phone3="'.$phone3.'",countryCode="'.$countryCode1.'",email="'.$email.'",primaryvalue="1",division="'.$division.'"';
	
    	addlisting('restaurantContactPersonMaster',$namevalue5);
    
	} 
	
	// for quotation inbound meal plan master
	if(trim($_POST['queryId'])!=''){
		$queryId = $_POST['queryId'];
		$namevalue2 ='adultCost="'.$adultCostLunch.'",childCost="'.$childCostLunch.'",infantCost="'.$infantCostLunch.'",mealPlanType="'.$mealPlanType.'",mealPlanName="'.$mealPlanName.'",queryId="'.$queryId.'",dateMealPlan="'.$dateMealPlan.'"'; 
		$addid = addlistinggetlastid(_QUOTATION_INBOUND_MEAL_PLAN_MASTER_,$namevalue2);  
		?>
		<script> 
		parent.setupbox('showpage.crm?module=<?php echo trim($_POST['module']); ?>&view=yes&id=<?php echo encode($_POST['queryId']); ?>&alt=<?php echo $msgbox; ?>');
		</script>  
		<?php   
	} else{
		// for inbound meal plan master 
		?>
		<script> 
		parent.setupbox('showpage.crm?module=<?php echo trim($_POST['module']); ?>&alt=<?php echo $msgbox; ?>');
		</script>  
		<?php 
	}
  
	}else{
	   	?>
		<script> 
		parent.alert('Duplicate data found !!');
		parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
		</script>  
		<?php 
	   
	    
	}

  
}
//not solved ======================================================





  /////////////////start subjectmaster master///////////////////
if(trim($_POST['action'])=='addedit_subjectmaster' && trim($_POST['editId'])=='' && trim($_POST['module'])!=''){ 
$fromDestinationId = urldecode($_POST['fromDestinationId']); 
$toDestinationId = urldecode($_POST['toDestinationId']); 
$description = clean($_POST['description']); 
$status = clean($_POST['status']);

$transferMode = urldecode($_POST['transferMode']); 
$otherTitle = urldecode($_POST['otherTitle']); 
$drivingDistance = urldecode($_POST['drivingDistance']); 

$dateAdded=time();

	$itiinfolang = GetPageRecord('*','tbl_languagemaster','name="English" and status=1 and deletestatus=0');
	$langres = mysqli_fetch_assoc($itiinfolang);
// duplicate added
		$rsr=GetPageRecord('*','iti_subjectmaster','otherTitle="'.$otherTitle.'" ');
			$editresult=mysqli_num_rows($rsr);
			if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
				?>
				<script>
				parent.alert('This Itinerary Title Already Exist!');
				parent.$('#pageloader').hide();
				parent.$('#pageloading').hide();
				</script> 
				<?php 
				
			}else{
				$rs3=GetPageRecord('id','iti_subjectmaster','fromDestinationId="'.$fromDestinationId.'" and toDestinationId="'.$toDestinationId.'" and otherTitle="'.$otherTitle.'"');
		if(mysqli_num_rows($rs3)<1){
			$namevalue ='fromDestinationId="'.$fromDestinationId.'",toDestinationId="'.$toDestinationId.'",description="'.$description.'",status="'.$status.'",transferMode="'.$transferMode.'",otherTitle="'.$otherTitle.'",drivingDistance="'.$drivingDistance.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$lastId = addlistinggetlastid('iti_subjectmaster',$namevalue); 

			$descvalue = 'title="'.$otherTitle.'",description="'.$description.'",languageId="'.$langres['id'].'",subjectId="'.$lastId.'"';
			addlisting('subjectLanguageMaster',$descvalue);

			?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
		}else{
			?>
				<script>
				parent.alert('Duplicate entry not allowed !!');
				parent.$('#pageloader').hide();
				parent.$('#pageloading').hide();
				</script> 
				<?php
		}

		?>
		<script>
		// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
	}

 } 
if(trim($_POST['action'])=='addedit_subjectmaster' && trim($_POST['editId'])!='' && trim($_POST['module'])!=''){ 
 
$fromDestinationId = clean($_POST['fromDestinationId']); 
$toDestinationId = clean($_POST['toDestinationId']); 
$description = clean($_POST['description']); 
$status = clean($_POST['status']);
$transferMode = clean($_POST['transferMode']); 
$otherTitle = clean($_POST['otherTitle']); 
$drivingDistance = urldecode($_POST['drivingDistance']); 
  
$where='id='.$_POST['editId'].''; 
$dateAdded=time();

$rs3=GetPageRecord('id','iti_subjectmaster','fromDestinationId="'.$fromDestinationId.'" and toDestinationId="'.$toDestinationId.'" and otherTitle="'.$otherTitle.'" and id != "'.$_POST['editId'].'"');

if(mysqli_num_rows($rs3)<1){
   $namevalue ='fromDestinationId="'.$fromDestinationId.'",toDestinationId="'.$toDestinationId.'",transferMode="'.$transferMode.'",otherTitle="'.$otherTitle.'",drivingDistance="'.$drivingDistance.'",description="'.$description.'",status="'.$status.'",modifyDate="'.$dateAdded.'",modifyBy="'.$_SESSION['userid'].'"';  
	$update = updatelisting('iti_subjectmaster',$namevalue,$where); 

	if($update=='yes'){

		$itiinfolang = GetPageRecord('*','tbl_languagemaster','name="English" and status=1 and deletestatus=0');
		$langres = mysqli_fetch_assoc($itiinfolang);

		$itiinfo11 = GetPageRecord('*','subjectLanguageMaster','subjectId="'.$_POST['editId'].'" and languageId="'.$langres['id'].'"');
		$descvalue = 'title="'.$otherTitle.'",description="'.$description.'"';

		if(mysqli_num_rows($itiinfo11)>0){
		$itiinfores = mysqli_fetch_assoc($itiinfo11);
		
		$whereentId = 'id="'.$itiinfores['id'].'"';
		updatelisting('subjectLanguageMaster',$descvalue,$whereentId);
		}else{

			$descvalue1 = 'title="'.$otherTitle.'",description="'.$description.'",languageId="'.$langres['id'].'",subjectId="'.$_POST['editId'].'"';
		addlisting('subjectLanguageMaster',$descvalue1);
		}
	}

?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php
}else{
     ?>
    	<script>
    	parent.alert('Duplicate entry not allowed !!');
    	parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
    	</script> 
    	<?php
}

 }
/////////////////start tourtype master///////////////////
/////////////////start hotelcategory master///////////////////
if(trim($_POST['action'])=='addedit_company_type' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 


$name=clean($_POST['name']); 

if($_POST['setDefault']==1){
	$setDefault=1;
	$where='1'; 
	$namevalue ='setDefault="0"';
	$update = updatelisting('marketMaster',$namevalue,$where); 
}
else{
$setDefault=0;	
}



$dateAdded=time();

$rs1=GetPageRecord('id','businessTypeMaster',' UPPER(name)="'.strtoupper($name).'"'); 
$editresult=mysqli_num_rows($rs1);
if($editresult > 0){
?>
<script>
	// adding time duplicate code
parent.alert('Business type name already exists!!');
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=4');
</script> 
<?php }else{
$namevalue ='name="'.$name.'",setDefault="'.$setDefault.'",status=1,dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
$adds = addlisting('businessTypeMaster',$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } }  
if(trim($_POST['action'])=='addedit_company_type' && trim($_POST['editId'])!=''  && trim($_POST['module'])!=''){ 
// $name=clean($_POST['name']); 
$name = trim($_POST['name']);
$status=clean($_POST['status']);


if($_POST['setDefault']==1){
	$setDefault=1;
	$where='1'; 
	$namevalue ='setDefault="0"';
	$update = updatelisting('businessTypeMaster',$namevalue,$where); 
}
else{
$setDefault=0;	
}

$modifyDate=time();
$rs1=GetPageRecord('id','businessTypeMaster',' UPPER(name)="'.strtoupper($name).'" and id != "'.$_POST['editId'].'"'); 
$editresult=mysqli_num_rows($rs1);
if($editresult > 0){
?>
<script>
	// Editing time duplicate code
parent.alert('Business type name already exists !!');
parent.$('#pageloader').hide();
parent.$('#pageloading').hide();
// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=4');
</script> 
<?php }else{
    
$where='id='.$_POST['editId'].''; 
$namevalue ='name="'.$name.'",setDefault="'.$setDefault.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
$update = updatelisting('businessTypeMaster',$namevalue,$where); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } }
 /////////////////start tourtype master///////////////////
//add itenary destination
if(trim($_POST['action'])=='addedit_itinerarydescription' && trim($_POST['editId'])=='' && trim($_POST['module'])!=''){ 
$fromDestinationId=clean($_POST['fromDestinationId']); 
$toDestinationId=clean($_POST['toDestinationId']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
if(!empty($_FILES['image']['name'])){  
		$image=time().$_FILES['image']['name'];  
		copy($_FILES['image']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['image2'];
	}
 
$add_date=date("Y-m-d H:i:s");
$namevalue ='fromDestinationId="'.$fromDestinationId.'",toDestinationId="'.$toDestinationId.'",description="'.$description.'",image="'.$image.'",status="'.$status.'",add_date="'.$add_date.'"';
addlisting('itineraryDescriptionMaster',$namevalue); 
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
</script> 
<?php } 
//edit itenary destination
if(trim($_POST['action'])=='addedit_itinerarydescription' && trim($_POST['editId'])!='' && trim($_POST['module'])!=''){
$fromDestinationId=clean($_POST['fromDestinationId']); 
$toDestinationId=clean($_POST['toDestinationId']); 
$description=clean($_POST['description']);
$status=clean($_POST['status']);
if(!empty($_FILES['image']['name'])){  
		$image=time().$_FILES['image']['name'];  
		copy($_FILES['image']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['image2'];
	}
	
$edit_date=date("Y-m-d H:i:s"); 
$where='id='.$_POST['editId'].''; 
$namevalue ='fromDestinationId="'.$fromDestinationId.'",toDestinationId="'.$toDestinationId.'",description="'.$description.'",image="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'"';
updatelisting('itineraryDescriptionMaster',$namevalue,$where);
?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
</script> 
<?php } 


if(trim($_POST['action'])=='addedit_languagemaster' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
    $name=clean($_POST['name']); 
	$status=clean($_POST['status']);
    $dateAdded=time();
	$rsr=GetPageRecord('*','tbl_languagemaster','name="'.$name.'"'); 
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId']==''){
        ?>
        <script>
        parent.alert('Language Already Exist!');
        </script> 
        <?php 
    }
    else{
        $namevalue ='name="'.$name.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"'; 
        if(trim($_POST['editId'])==''){
            $adds = addlisting('tbl_languagemaster',$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('tbl_languagemaster',$namevalue,$where); 
            $msg = 2;
        }
        ?>
        <script>
        parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
        </script> 
        <?php
    }
}  



//after addedit_languagemaster
if(trim($_POST['action'])=='addeditGallery' && $_REQUEST['parentId']!='' && $_REQUEST['galleryType']!=''){
	$parentId=$_POST['parentId'];
	$galleryType=$_POST['galleryType'];
	$module = $_POST['module'];
	$backpage=( $_POST['page'] !='' )? '&page='.$_POST['page']:'';
	$subpage = ( $_POST['subpage'] !='' )? '&subpage='.$_POST['subpage']:'';
	if(!empty($_FILES['galleryImage']['name'])){  
		
		$file_name = $_FILES['galleryImage']['name'];
		$temp_img = $_FILES['galleryImage']['tmp_name'];//full path of the image of OR temp path of the file
        $image1 = getfilename($file_name); // rename the file befor upload
        // get the full size image
        if(makeDir('dirfiles/') === true){
            $directoryName ='dirfiles/';
            $targetedFile = $directoryName.$image1; // save custom name and full path after upload/ foldeer to database
            $width      = 730; //$_POST['width'];
            $height     = 500; //$_POST['height'];
            $quality    = 80; //$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , false , false ,$quality ); //excute the code to resize image
        }
        // get the thumb image 
        if(makeDir('dirfiles/_thumb/') === true){
            $directoryName ='dirfiles/_thumb/';
            $targetedFile = $directoryName.$image1; // uploaded file path with customize name
            $width      = 100; //$_POST['width'];
            $height     = 50; //$_POST['height'];
            $quality    = 80;//$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , false , false ,$quality ); //excute the code to resize image
        }
	} 


	if ($_REQUEST['editId'] != '') {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='name="'.$image1.'",title="'.$title.'",parentId="'.$parentId.'",galleryType="'.$galleryType.'"';
		$update = updatelisting(_IMAGE_GALLERY_MASTER_,$namevalue,$where);
		?>
			<script>
				parent.setupbox('showpage.crm?module=<?php echo $module.$backpage.$subpage;?>&d_id=<?php echo $parentId;?>&alt=2');
			</script> 
		<?php 
	}else{
		$namevalue ='name="'.$image1.'",title="'.$title.'",parentId="'.$parentId.'",galleryType="'.$galleryType.'"';
		$adds = addlisting(_IMAGE_GALLERY_MASTER_,$namevalue);
		?>
			<script>
				parent.setupbox('showpage.crm?module=<?php echo $module.$backpage.$subpage;?>&d_id=<?php echo $parentId;?>&alt=1');
			</script> 
		<?php 
	}
	
}



if(trim($_POST['action'])=='addedit_nationalitymaster'){ 
$name=$_POST['name'];
$countryName=$_POST['countryName'];
$sortName=$_POST['sortName'];
$deleteStatus=$_POST['deleteStatus'];
 $type=$_POST['type'];
$editId=clean($_POST['editId']); 
$dateAdded=time();
$namevalue ='name="'.$name.'",countryId="'.$countryName.'",sortName="'.$sortName.'",deleteStatus="'.$deleteStatus.'",type="'.$type.'"';   
$where='id='.$_POST['editId'].''; 
if($editId!='')
{
$update = updatelisting('nationalityMaster',$namevalue,$where);
}else
{
 $adds = addlisting('nationalityMaster',$namevalue);
}
?>
<script>
parent.setupbox('showpage.crm?module=nationalitymaster&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
</script> 
<?php  }
?>
<?php 
if(trim($_REQUEST['action'])=='hotelrestriction' && $_REQUEST['hotelId']!=''){
$hotelId=clean($_POST['hotelId']); 
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue ='hotelId="'.$hotelId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';
$adds = addlisting('hoteloperationRestriction',$namevalue);    
?>
<script>
parent.setupbox('showpage.crm?module=hoteloperationrestrictionmaster&alt=1');
</script> 
<?php 
}
?>
<?php 
if(trim($_REQUEST['action'])=='edit_restrictions' && $_REQUEST['editId']!='' && $_REQUEST['hotelId']!=''){
$hotelId=clean($_POST['hotelId']);
$editId=clean($_POST['editId']); 
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue2 ='hotelId="'.$hotelId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';    
$where2='id='.$editId.'';
$update = updatelisting('hoteloperationRestriction',$namevalue2,$where2); 
?>
<script>
parent.setupbox('showpage.crm?module=hoteloperationrestrictionmaster&alt=2');
</script> 
<?php 
}
?>
<?php 
if(trim($_REQUEST['action'])=='activityoperationrestriction' && $_REQUEST['otheractivityId']!=''){
$otheractivityId=clean($_POST['otheractivityId']);
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue1 ='otheractivityId="'.$otheractivityId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';
$adds = addlisting('hoteloperationRestriction',$namevalue1);    
?>
<script>
parent.setupbox('showpage.crm?module=activityoperationrestrictionmaster&alt=1');
</script> 
<?php 
}
?>
<?php 
if(trim($_REQUEST['action'])=='edit_activityrestrictions' && $_REQUEST['editId']!='' && $_REQUEST['otheractivityId']!=''){
$otheractivityId=clean($_POST['otheractivityId']);
$editId=clean($_POST['editId']); 
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue2 ='otheractivityId="'.$otheractivityId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';
$where2='id='.$editId.'';
$update = updatelisting('hoteloperationRestriction',$namevalue2,$where2); 
?>
<script>
parent.setupbox('showpage.crm?module=activityoperationrestrictionmaster&alt=2');
</script> 
<?php 
}
?>
<?php 
if(trim($_REQUEST['action'])=='entranceoperationrestriction' && $_REQUEST['entranceId']!=''){
$entranceId=clean($_POST['entranceId']);
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue1 ='entranceId="'.$entranceId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';
$adds = addlisting('hoteloperationRestriction',$namevalue1);    
?>
<script>
parent.setupbox('showpage.crm?module=entranceoperationrestrictionmaster&alt=1');
</script> 
<?php 
}
?>
<?php 
if(trim($_REQUEST['action'])=='edit_entrancerestrictions' && $_REQUEST['editId']!='' && $_REQUEST['entranceId']!=''){
$entranceId=clean($_POST['entranceId']);
$editId=clean($_POST['editId']); 
$startDate=date("Y-m-d", strtotime($_POST['startDate'])); 
$endDate=date("Y-m-d", strtotime($_POST['endDate']));
$reason=clean($_POST['reason']); 
$namevalue2 ='entranceId="'.$entranceId.'",startDate="'.$startDate.'",endDate="'.$endDate.'",reason="'.$reason.'"';
$where2='id='.$editId.'';
$update = updatelisting('hoteloperationRestriction',$namevalue2,$where2); 
?>
<script>
parent.setupbox('showpage.crm?module=entranceoperationrestrictionmaster&alt=2');
</script> 
<?php 
}

if(trim($_POST['action'])=='addedit_gstmaster' && trim($_POST['module'])!=''){ 
	
		$editId=$_REQUEST['editId'];
		$serviceType=clean($_POST['serviceType']); 
		$gstSlabName=clean($_POST['gstSlabName']);
		$gstValue=clean($_POST['gstValue']); 
		$status=clean($_POST['status']);   
		$dateAdded=time();

		$setDefault=$_POST['setDefault'];
		if($_POST['setDefault']==1){
		$where = 'serviceType="'.$serviceType.'" and setDefault=1';
		$namevalue= 'setDefault="0"';
		$update = updatelisting('gstMaster',$namevalue,$where); 
		}else{
		$setDefault=0;	
		}
		
		$rs2=GetPageRecord('*','gstMaster',' serviceType="'.$serviceType.'" and gstSlabName="'.$gstSlabName.'" and id!="'.$editId.'"'); 
	// $rs2=GetPageRecord('*','gstMaster',' serviceType="'.$serviceType.'" and gstValue="'.$gstValue.'" and id!="'.$editId.'"'); 
	if(mysqli_num_rows($rs2) == 0){
	
		if($editId==''){
			$namevalue ='serviceType="'.$serviceType.'",status="'.$status.'",gstValue="'.$gstValue.'" ,setDefault="'.$setDefault.'",gstSlabName="'.$gstSlabName.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$adds = addlisting('gstMaster',$namevalue); 
			$msg=1;
		}else{
			$where2='id='.$editId.'';
			$namevalue2 ='serviceType="'.$serviceType.'",status="'.$status.'",gstSlabName="'.$gstSlabName.'",gstValue="'.$gstValue.'",setDefault="'.$setDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$update = updatelisting('gstMaster',$namevalue2,$where2);
			$msg=2;
		}
	
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
	<?php 
	}else{
	?>
		<script>
		parent.alert('<?php echo ucfirst($serviceType);?> GST Value is already exist!');
		// parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
		</script> 
	<?php
	}
}  

if(trim($_REQUEST['action'])=='saveEditEntrancePrice' && trim($_REQUEST['entranceId'])!='' && trim($_REQUEST['id'])!=''){  
	
	$adultCost=clean($_REQUEST['adultCost']);  
	$childCost=clean($_REQUEST['childCost']); 
	$infantCost=clean($_REQUEST['infantCost']); 
	$entranceId=clean($_REQUEST['entranceId']);  
	$id=clean($_REQUEST['id']);  
	
	$where2='id="'.$id.'"';
	$namevalue2 ='ticketAdultCost="'.$adultCost.'",ticketchildCost="'.$childCost.'",ticketinfantCost="'.$infantCost.'"';
	$update2 = updatelisting(_DMC_ENTRANCE_RATE_MASTER_,$namevalue2,$where2);
}

if($_REQUEST['action']=='deletecompany_type'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('businessTypeMaster',$namevalue,$where); 	
	generateLogs('businessTypeMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo strip($_REQUEST['module']);?>&alt=3');
	</script>
	<?php
	}

if(trim($_POST['action'])=='addedit_proposalsettings' && trim($_POST['photoDimension'])!=''){  
	$proposalName=clean($_POST['proposalName']);   
	$proposalNum=clean($_POST['proposalNum']); 
	$proposalPhoto=clean($_POST['proposalPhoto']);
	$backgroundColor=clean($_POST['backgroundColor']);
	$textColor=clean($_POST['textColor']);
	$photoDimension=clean($_POST['photoDimension']);

	 
	$dateAdded=time(); 
	$modifyDate=time();  
  	if(clean($_POST['editId']) !='' ){ 
		$namevalue ='photoDimension="'.$photoDimension.'",proposalName="'.$proposalName.'",proposalNum="'.$proposalNum.'",proposalPhoto="'.$proposalPhoto.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'",proposalColor="'.$backgroundColor.'",textColor="'.$textColor.'"';
 		$where='id="'.$_POST['editId'].'"'; 
		$entraceId = $_POST['editId'];
		$update = updatelisting('proposalSettingMaster',$namevalue,$where);
		$msgbox = 2; 
 	}else{  
		$addnewyes = checkduplicate('proposalSettingMaster','proposalName="'.$proposalName.'"'); 
		if($addnewyes!='yes'){
			$namevalue1 ='photoDimension="'.$photoDimension.'",proposalName="'.$proposalName.'",proposalNum="'.$proposalNum.'",proposalPhoto="'.$proposalPhoto.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",proposalColor="'.$backgroundColor.'",textColor="'.$textColor.'"';
	 		$entraceId = addlistinggetlastid('proposalSettingMaster',$namevalue1); 
	 		$msgbox = 1;
	 	}else{ ?>
			<script> alert('<?php echo $proposalName; ?> is already exist...!'); </script>
		 <?php 
		}
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=proposalsettings&alt=<?php echo $msgbox; ?>');
	</script> 
<?php  
}

if(trim($_POST['action'])=='addedit_fleetmaster' && trim($_POST['module'])!=''){ 
 
    $brand=clean($_POST['brand']); 
    $model=clean($_POST['model']); 
    $status = clean($_POST['status']);
    $colourType=clean($_POST['colourType']);
    $vehicleType=clean($_POST['vehicleType']);
    $fuelType=clean($_POST['fuelType']); 
    $capacity=clean($_POST['capacity']); 
    $assignedDriver=clean($_POST['assignedDriver']); 
    $vehicleGroup=clean($_POST['vehicleGroup']); 
    $registrationNo=clean($_POST['registrationNo']); 
    $ownerName=clean($_POST['ownerName']); 
    $registrationDate=date('Y-m-d',strtotime($_POST['registrationDate'])); 
    $chassisNo=clean($_POST['chassisNo']); 
    $engineNo=clean($_POST['engineNo']); 
    $CompanyName=clean($_POST['CompanyName']); 
    $policyNo=clean($_POST['policyNo']); 
    $issueDate=date('Y-m-d',strtotime($_POST['issueDate'])); 
    $dueDate=date('Y-m-d',strtotime($_POST['dueDate'])); 
    $premiumAmount=clean($_POST['premiumAmount']); 
    $coverAmount=clean($_POST['coverAmount']); 
    $address=clean($_POST['address']); 
    $taxEfficiency=clean($_POST['taxEfficiency']); 
    $rtoExpiryDate=date('Y-m-d',strtotime($_POST['rtoExpiryDate']));
    $permitType=clean($_POST['permitType']); 
	 $polutionPermitExpiry=date('Y-m-d',strtotime($_POST['polutionPermitExpiry']));
	$showCostsheet = (isset($_POST['showCostsheet'])) ? 1 : 0;
    $permitExpiryDate=date('Y-m-d',strtotime($_POST['permitExpiryDate']));
	$dateAdded=time();
	//vehicleImage
	if(!empty($_FILES['vehicleImage']['name'])){  
		$image=time().$_FILES['vehicleImage']['name'];  
		copy($_FILES['vehicleImage']['tmp_name'],"packageimages/".$image); 
	} else{
		$image = $_REQUEST['vehicleImage2'];
	}

	if( trim($_POST['editId'])=='' ){
	    
	    $rs2=GetPageRecord('id','vehicleFleetMaster','registrationNo="'.$registrationNo.'" and chassisNo="'.$chassisNo.'" and engineNo="'.$engineNo.'"');

	    if ($model !='' && $brand !='') {
	    
	    if(mysqli_num_rows($rs2)<1){
	        
	        	$namevalue ='image="'.$image.'",brand="'.$brand.'",model="'.$model.'",colourType="'.$colourType.'",fuelType="'.$fuelType.'",capacity="'.$capacity.'",assignedDriver="'.$assignedDriver.'",vehicleGroup="'.$vehicleGroup.'",registrationNo="'.$registrationNo.'",ownerName="'.$ownerName.'",registrationDate="'.$registrationDate.'",chassisNo="'.$chassisNo.'",engineNo="'.$engineNo.'",CompanyName="'.$CompanyName.'",policyNo="'.$policyNo.'",issueDate="'.$issueDate.'",dueDate="'.$dueDate.'",premiumAmount="'.$premiumAmount.'",coverAmount="'.$coverAmount.'",address="'.$address.'",taxEfficiency="'.$taxEfficiency.'",rtoExpiryDate="'.$rtoExpiryDate.'",showCostsheet="'.$showCostsheet.'",permitType="'.$permitType.'",permitExpiryDate="'.$permitExpiryDate.'",carType="'.$vehicleType.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",polutionPermitExpiry="'.$polutionPermitExpiry.'"';  
	        $adds = addlisting('vehicleFleetMaster',$namevalue); 
		$msg = 1;
		?>
			<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
	</script> 
<?php
	    }else{
	         ?>
    	<script>
    	parent.alert('Duplcate entry !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
	    }
	    
		}else{ ?>
	  	<script>
	  	parent.alert('Select Model/Vehicle...');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
	<?php  }

	}else{
	    
	    $rs2=GetPageRecord('id','vehicleFleetMaster','registrationNo="'.$registrationNo.'" and chassisNo="'.$chassisNo.'" and engineNo="'.$engineNo.'" and id != "'.$_POST['editId'].'"');
	    
	    if(mysqli_num_rows($rs2)<1){
	        	$namevalue ='image="'.$image.'",brand="'.$brand.'",model="'.$model.'",colourType="'.$colourType.'",fuelType="'.$fuelType.'",capacity="'.$capacity.'",assignedDriver="'.$assignedDriver.'",vehicleGroup="'.$vehicleGroup.'",registrationNo="'.$registrationNo.'",ownerName="'.$ownerName.'",registrationDate="'.$registrationDate.'",chassisNo="'.$chassisNo.'",engineNo="'.$engineNo.'",CompanyName="'.$CompanyName.'",policyNo="'.$policyNo.'",issueDate="'.$issueDate.'",dueDate="'.$dueDate.'",premiumAmount="'.$premiumAmount.'",coverAmount="'.$coverAmount.'",address="'.$address.'",taxEfficiency="'.$taxEfficiency.'",rtoExpiryDate="'.$rtoExpiryDate.'",showCostsheet="'.$showCostsheet.'",permitType="'.$permitType.'",permitExpiryDate="'.$permitExpiryDate.'",carType="'.$vehicleType.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",polutionPermitExpiry="'.$polutionPermitExpiry.'"';  
	        
	       $where='id='.$_POST['editId'].''; 
		$update = updatelisting('vehicleFleetMaster',$namevalue,$where); 
		$msg =2;
		?>
			<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
	</script> 
<?php
	    }else{
	         ?>
    	<script>
    	parent.alert('Duplcate entry !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
	    }
		
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg;?>');
	</script> 
<?php } 

 

if(trim($_REQUEST['action'])=='addedit_marketTypeMaster' && $_REQUEST['name']!=''){

	$editId=decode($_POST['editId']); 
	$name=clean($_POST['name']); 
	$marketColor=clean($_POST['marketColor']); 
	$status=clean($_POST['status']);

	if($_POST['setDefault']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting('marketMaster',$namevalue,$where); 
	}
	else{
	$setDefault=0;	
	}
	
	if(trim($_POST['name'])!='All' && trim($_POST['name'])!='all' ){
		$namevalue ='name="'.$name.'",marketColor="'.$marketColor.'",status="'.$status.'",setDefault="'.$setDefault.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'"';
			if(trim($_POST['editId'])==''){
				$rs3=GetPageRecord('id','marketMaster','name="'.$name.'"');
				if(mysqli_num_rows($rs3)<1){
					$namevalue ='name="'.$name.'",marketColor="'.$marketColor.'",status="'.$status.'",setDefault="'.$setDefault.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'"';
				$adds = addlisting('marketMaster',$namevalue); 
					?>
			<script>
		parent.setupbox('showpage.crm?module=marketTypeMaster&alt=1');
		</script> 
		<?php 
		    }else{
		          ?>
    	<script>
    	parent.alert('Market Name already exists !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
		    }
		    
		}else{
		    $rs3=GetPageRecord('id','marketMaster','name="'.$name.'" and id != "'.$editId.'"');
			
			if(mysqli_num_rows($rs3)<1){
			    $namevalue ='name="'.$name.'",marketColor="'.$marketColor.'",status="'.$status.'",setDefault="'.$setDefault.'",addedBy="'.$_SESSION['userid'].'",dateAdded="'.time().'"';
			    $where='id="'.$editId.'"'; 
			    $update = updatelisting('marketMaster',$namevalue,$where); 
			    	?>
		<script>
		parent.setupbox('showpage.crm?module=marketTypeMaster&alt=2');
		</script> 
		<?php 
			}else{
			 ?>
    	<script>
    	parent.alert('Market Name already exists !!');
    	parent.$('#pageloader').hide();
        parent.$('#pageloading').hide();
    	</script> 
    	<?php
			}
			
		}
	
	}else{
	?>
	<script>
	parent.alert('Invalid Name');
	parent.$('#pageloader').hide();
	parent.$('#pageloading').hide();
	</script> 
	<?php 
	}

}

// after addedit_marketTypeMaster
if(trim($_POST['action'])=='addedit_seasonTypeMaster' && trim($_POST['editId'])=='' && trim($_POST['sectiontype'])!=''){ 
 	$seasonYear=clean($_POST['seasonYear']);  
	$status=clean($_POST['status']);
	$seasonName=clean($_POST['seasonName']); 
	$fromDate = date('Y-m-d',strtotime($_POST['fromDate']));
    $toDate = date('Y-m-d',strtotime($_POST['toDate']));
	$dateAdded=date('Y-m-d'); 
 	$rs1="";
	$rs1=GetPageRecord('*','seasonMaster',' ( fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" OR "'.$fromDate.'" BETWEEN fromDate and toDate ) and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){
 		$namevalue ='seasonNameId ="'.$seasonName.'", fromDate="'.$fromDate.'", toDate="'.$toDate.'", status="'.$status.'",adddate="'.$dateAdded.'", addedBy="'.$_SESSION['userid'].'"';
		$adds = addlisting('seasonMaster',$namevalue); 
		?>
		<script> 
			parent.setupbox('showpage.crm?module=<?php echo $_POST['sectiontype']; ?>&alt=1');
		</script> 
		<?php 
 	}else{ 
		?>
		<script> 
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.alert('Season is already exist!');
		</script> 
		<?php 
	} 
} 

if(trim($_POST['action'])=='addedit_seasonTypeMaster' && trim($_POST['editId']) !='' && trim($_POST['sectiontype'])!=''){ 
 	$seasonYear=clean($_POST['seasonYear']);  
	$editId=decode($_POST['editId']);
	$status=clean($_POST['status']);
	$seasonName=clean($_POST['seasonName']); 
	$fromDate = date('Y-m-d',strtotime($_POST['fromDate']));
   $toDate = date('Y-m-d',strtotime($_POST['toDate']));
	$dateAdded=date('Y-m-d'); 
 	$rs1="";
	
	$rs1=GetPageRecord('*','seasonMaster',' 1 and ( fromDate BETWEEN "'.$fromDate.'" and "'.$toDate.'" OR "'.$fromDate.'" BETWEEN fromDate and toDate ) and id!="'.$editId.'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){
 	  $namevalue ='seasonNameId ="'.$seasonName.'", fromDate="'.$fromDate.'", toDate="'.$toDate.'", status="'.$status.'",adddate="'.$dateAdded.'", addedBy="'.$_SESSION['userid'].'"';
		$where='id="'.$editId.'"'; 
		$update = updatelisting('seasonMaster',$namevalue,$where); 
		?>
		<script> 
		 parent.setupbox('showpage.crm?module=<?php echo $_POST['sectiontype']; ?>&alt=3');
		 
		</script> 
		<?php 
  	}else{ 
		?>
		<script> 
			parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
			parent.alert('Season is already exist!');
		</script> 
		<?php 
	}
} 
 



if(trim($_POST['action'])=='addedit_restaurantsmealplan' && trim($_POST['editId'])=='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']);
	$dateAdded=time();

	$rsr=GetPageRecord('*','restaurantsMealPlanMaster','name="'.$name.'" ');
	// $editresult=mysqli_num_rows($rsr);


	if(mysqli_num_rows($rsr) > 0){
        ?>
		
        <script>
        parent.alert('Restaurants Meal Plan Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		exit();
        </script> 

        <?php 
	}else {
		$namevalue ='name="'.$name.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"'; 
		if(trim($_POST['editId']) < 1){
            $adds = addlisting('restaurantsMealPlanMaster',$namevalue); 
            $msg = 1;
        }else{
            $where='id='.$_POST['editId'].''; 
            $adds = updatelisting('restaurantsMealPlanMaster',$namevalue,$where); 
            $msg = 2;
		}
		?>
		<script>

			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');

		</script> 
		<?php 
	} 
}

if(trim($_POST['action'])=='addedit_restaurantsmealplan' && trim($_POST['editId'])!='' && trim($_POST['name'])!='' && trim($_POST['module'])!=''){ 
	$name=clean($_POST['name']); 
	$status=clean($_POST['status']);
	$dateAdded=time();
	$editId = $_POST['editId'];

	$where='name="'.$name.'" and deletestatus=0 and id!="'.$editId.'"';  
	$addnewyes = checkduplicate('restaurantsMealPlanMaster',$where); 
	if($addnewyes=='yes'){
		?>
		<script>
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		alert('This Restaurants MealPlan already exist.');
		</script>
		<?php
	} else {
		 
		$namevalue ='name="'.$name.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"'; 
		$where='id="'.$editId.'"'; 
		$update = updatelisting('restaurantsMealPlanMaster',$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php 
	} 
}

if(trim($_POST['action'])=='addedit_overview' && trim($_POST['editId']) ==''){ 
   $highlight = clean($_POST['highlight']);
   $description = clean($_POST['description']);
   $overview = clean($_POST['overview']);

   $itineraryintr = clean($_POST['itineraryintr']);
   $itinerarysumm = clean($_POST['itinerarysumm']);


   $overViewTextBox_1 = clean($_POST['overViewTextBox_1']);
   $overViewTextBox_2 = clean($_POST['overViewTextBox_2']);
   $overViewTextBox_3 = clean($_POST['overViewTextBox_3']);
   $overViewTextBox_4 = clean($_POST['overViewTextBox_4']);
//    itineraryintr,itinerarysumm

   $overviewName = clean($_POST['overviewName']);
   $status = clean($_POST['status']);
   $destinationid = $_POST['destinationId'];
   $overviewdesid = implode(",", $destinationid);
   $dateAdded=time();
   
if ($overviewName!='') {   
	   $rs2=GetPageRecord('*',_OVERVIEW_MASTER_,'overviewName="'.$overviewName.'"');
	   if(mysqli_num_rows($rs2)<1){
	       $namevalue ='destinationId="'.$overviewdesid.'",overviewName="'.$overviewName.'",overview="'.$overview.'",description="'.$description.'",highlight="'.$highlight.'",itineraryintr="'.$itineraryintr.'",itinerarysumm="'.$itinerarysumm.'",overviewTitle_1="'.$overViewTextBox_1.'",overviewTitle_2="'.$overViewTextBox_2.'",overviewTitle_3="'.$overViewTextBox_3.'",overviewTitle_4="'.$overViewTextBox_4.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	   $lastid = addlistinggetlastid(_OVERVIEW_MASTER_,$namevalue); 
	     
	       foreach ($destinationid as $des) {
	   	  $namevalue ='destinationId="'.$des.'",overviewId="'.$lastid.'"';
	      $add = addlisting('overviewDescription',$namevalue);
	   }
	   ?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	</script> 
	<?php  
	   }else{
	         ?>
	    	<script>
	    	parent.alert('Duplicate data found !!');
	    	parent.$('#pageloader').hide();
			parent.$('#pageloading').hide();
	    	</script> 
	    	<?php
	   }
}else{
	    ?>
		<script>
		parent.alert('Please enter Overview Name.. !!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}
   
   
   
  }

if(clean($_POST['action'])=='addedit_overview' && clean($_POST['editId'])!='' && $_POST['module']!=''){ 
   $highlight = clean($_POST['highlight']);
   $description = clean($_POST['description']);
   $overview = clean($_POST['overview']);

   $itineraryintr = clean($_POST['itineraryintr']);
   $itinerarysumm = clean($_POST['itinerarysumm']);
//    itineraryintr,itinerarysumm

	$overViewTextBox_1 = clean($_POST['overViewTextBox_1']);
	$overViewTextBox_2 = clean($_POST['overViewTextBox_2']);
	$overViewTextBox_3 = clean($_POST['overViewTextBox_3']);
	$overViewTextBox_4 = clean($_POST['overViewTextBox_4']);

   $overviewName = clean($_POST['overviewName']);
   $status = clean($_POST['status']);
   $destinationid = $_POST['destinationId'];
   $editId = $_POST['editId'];
   $overviewdesid = implode(",", $destinationid);
   $dateAdded=time();
   echo $_POST['module'];
   $rs2=GetPageRecord('*',_OVERVIEW_MASTER_,'overviewName="'.$overviewName.'" and id!= "'.$editId.'" ');
   if(mysqli_num_rows($rs2)>0){
	?>
	<script>
	parent.alert('Duplicate data found !!');
	parent.$('#pageloader').hide();
	parent.$('#pageloading').hide();
	</script> 

	<?php

   }else{
   $where='id="'.$editId.'"'; 
   echo $namevalue ='destinationId="'.$overviewdesid.'",overviewName="'.$overviewName.'",overview="'.$overview.'",description="'.$description.'",highlight="'.$highlight.'",itineraryintr="'.$itineraryintr.'",itinerarysumm="'.$itinerarysumm.'",overviewTitle_1="'.$overViewTextBox_1.'",overviewTitle_2="'.$overViewTextBox_2.'",overviewTitle_3="'.$overViewTextBox_3.'",overviewTitle_4="'.$overViewTextBox_4.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
   $adds = updatelisting(_OVERVIEW_MASTER_,$namevalue,$where);
   
    //  foreach ($destinationid as $des) {
    //   $rsd=GetPageRecord('*','overviewDescription',' destinationId="'.$des.'"');
    //   $countrow=mysqli_num_rows($rsd);	
    //   if($countrow>0){
    //     $namevalue1 ='destinationId="'.$des.'"';
    //     $add12 = updatelisting('overviewDescription',$namevalue1,$where); 
    //   }else{  
   	//     $namevalue ='destinationId="'.$des.'",overviewId="'.$editId.'"';
    //     $add = addlisting('overviewDescription',$namevalue);
    //   }
//    }
}
   ?>
<script>
parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
    	</script> 

<?php
        
   }
   
// fit inclusion sec started  
if(trim($_POST['action'])=='addedit_FITInculsionsIExculsionsITCICancellationPolicy' && trim($_POST['editId']) ==''){
	
	$fitName = clean($_POST['fitName']);
	$inclusion = clean($_POST['inclusion']);
	$exclusion = clean($_POST['exclusion']);
	$termscondition = clean($_POST['termscondition']);
	$cancelation = clean($_POST['cancelation']);
	// serviceupgradation optionaltour
	$serviceupgradation = clean($_POST['serviceupgradation']);
	$optionaltour = clean($_POST['optionaltour']);
	$paymentpolicy = clean($_POST['paymentpolicy']);
	$remarks = clean($_POST['remarks']);
	$status = clean($_POST['status']);
	$byDefault = clean($_POST['byDefault']);

	$IncFITTextBox_1 = clean($_POST['IncFITTextBox_1']);
	$IncFITTextBox_2 = clean($_POST['IncFITTextBox_2']);
	$IncFITTextBox_3 = clean($_POST['IncFITTextBox_3']);
	$IncFITTextBox_4 = clean($_POST['IncFITTextBox_4']);
	$IncFITTextBox_5 = clean($_POST['IncFITTextBox_5']);
	$IncFITTextBox_6 = clean($_POST['IncFITTextBox_6']);
	$IncFITTextBox_7 = clean($_POST['IncFITTextBox_7']);
	$IncFITTextBox_8 = clean($_POST['IncFITTextBox_8']);
	$IncFITTextBox_9 = clean($_POST['IncFITTextBox_9']);

	// $destinationid = $_POST['destinationId'];
	$destinationList = implode(',', $_POST['destinationId']);

	// $overviewdesid = implode(",", $destinationid);
	$dateAdded=time();
	
 if ($fitName!='') {   
		$rs2=GetPageRecord('*','fitIncExcMaster','fitName="'.$fitName.'"');
		if(mysqli_num_rows($rs2)<1){
			$namevalue ='fitName="'.$fitName.'",inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",paymentpolicy="'.$paymentpolicy.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",remarks="'.$remarks.'",destinationId="'.$destinationList.'",title_1="'.$IncFITTextBox_1.'",title_2="'.$IncFITTextBox_2.'",title_3="'.$IncFITTextBox_3.'",title_4="'.$IncFITTextBox_4.'",title_5="'.$IncFITTextBox_5.'",title_6="'.$IncFITTextBox_6.'",title_7="'.$IncFITTextBox_7.'",title_8="'.$IncFITTextBox_8.'",title_9="'.$IncFITTextBox_9.'",status="'.$status.'",byDefault="'.$byDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
		$lastid = addlistinggetlastid('fitIncExcMaster',$namevalue); 
		  
		// 	foreach ($destinationid as $des) {
		// 	  $namevalue ='destinationId="'.$des.'",overviewId="'.$lastid.'"';
		//    $add = addlisting('overviewDescription',$namevalue);
		// }
		?>
	 <script>
	 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	 </script> 
	 <?php  
		}else{
			  ?>
			 <script>
			 parent.alert('Duplicate data found !!');
			 parent.$('#pageloader').hide();
			 parent.$('#pageloading').hide();
			 </script> 
			 <?php
		}
 }else{
		 ?>
		 <script>
		 parent.alert('Please enter FIT  Name.. !!');
		 parent.$('#pageloader').hide();
		 parent.$('#pageloading').hide();
		 </script> 
		 <?php
	 }
	
	
	
   }
 
 if(clean($_POST['action'])=='addedit_FITInculsionsIExculsionsITCICancellationPolicy' && clean($_POST['editId'])!='' && $_POST['module']!=''){ 

	$fitName = clean($_POST['fitName']);
	$inclusion = clean($_POST['inclusion']);
	$exclusion = clean($_POST['exclusion']);
	$termscondition = clean($_POST['termscondition']);
	$cancelation = clean($_POST['cancelation']);

	$serviceupgradation = clean($_POST['serviceupgradation']);
	$optionaltour = clean($_POST['optionaltour']);
	$paymentpolicy = clean($_POST['paymentpolicy']);
	$remarks = clean($_POST['remarks']);
	$status = clean($_POST['status']);
	$byDefault = clean($_POST['byDefault']);
	$editId = $_POST['editId'];
	$destinationList = implode(',', $_POST['destinationId']);


	$IncFITTextBox_1 = clean($_POST['IncFITTextBox_1']);
	$IncFITTextBox_2 = clean($_POST['IncFITTextBox_2']);
	$IncFITTextBox_3 = clean($_POST['IncFITTextBox_3']);
	$IncFITTextBox_4 = clean($_POST['IncFITTextBox_4']);
	$IncFITTextBox_5 = clean($_POST['IncFITTextBox_5']);
	$IncFITTextBox_6 = clean($_POST['IncFITTextBox_6']);
	$IncFITTextBox_7 = clean($_POST['IncFITTextBox_7']);
	$IncFITTextBox_8 = clean($_POST['IncFITTextBox_8']);
	$IncFITTextBox_9 = clean($_POST['IncFITTextBox_9']);

	// $destinationid = $_POST['destinationId'];
	
	// $overviewdesid = implode(",", $destinationid);
	// $dateAdded=time();
	// echo $_POST['module'];
	$rs2=GetPageRecord('*','fitIncExcMaster','fitName="'.$fitName.'" and id!= "'.$editId.'" ');
	if(mysqli_num_rows($rs2)>0){
	 ?>
	 <script>
	 parent.alert('Duplicate data found !!');
	 parent.$('#pageloader').hide();
	 parent.$('#pageloading').hide();
	 </script> 
 
	 <?php
 
	}else{
	$where='id="'.$editId.'"'; 
	echo $namevalue ='fitName="'.$fitName.'",inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",paymentpolicy="'.$paymentpolicy.'",remarks="'.$remarks.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",destinationId="'.$destinationList.'",title_1="'.$IncFITTextBox_1.'",title_2="'.$IncFITTextBox_2.'",title_3="'.$IncFITTextBox_3.'",title_4="'.$IncFITTextBox_4.'",title_5="'.$IncFITTextBox_5.'",title_6="'.$IncFITTextBox_6.'",title_7="'.$IncFITTextBox_7.'",title_8="'.$IncFITTextBox_8.'",title_9="'.$IncFITTextBox_9.'",status="'.$status.'",byDefault="'.$byDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	$adds = updatelisting('fitIncExcMaster',$namevalue,$where);
	
	 //  foreach ($destinationid as $des) {
	 //   $rsd=GetPageRecord('*','overviewDescription',' destinationId="'.$des.'"');
	 //   $countrow=mysqli_num_rows($rsd);	
	 //   if($countrow>0){
	 //     $namevalue1 ='destinationId="'.$des.'"';
	 //     $add12 = updatelisting('overviewDescription',$namevalue1,$where); 
	 //   }else{  
		//     $namevalue ='destinationId="'.$des.'",overviewId="'.$editId.'"';
	 //     $add = addlisting('overviewDescription',$namevalue);
	 //   }
 //    }
 }
	?>
 <script>
 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
 parent.$('#pageloader').hide();
		 parent.$('#pageloading').hide();
		 </script> 
 
 <?php
		 
	}
	
 
// fit inclusion sec ended
 

// fit inactive and avtive section code started
if(trim($_REQUEST['action'])=='delete_'.$_REQUEST['module']){    
	$check_list=$_REQUEST['check_list'];  
	$modifyDate = time();
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$where='id='.$ansval.''; 
				$namevalue ='status="0",modifyDate="'.$modifyDate.'",addedBy="'.$_SESSION['userid'].'"';  
				$update = updatelisting('fitIncExcMaster',$namevalue,$where); 
			//	$sql_del="delete from ".$_REQUEST['table']."  where id='".$ansval."'"; 
			//	mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['module'];?>&alt=3');
	</script>
	<?php
}
// fit inactive and avtive section code ended 





// GIT inclusion sec started  
if(trim($_POST['action'])=='addedit_GITInculsionsIExculsionsITCICancellationPolicy' && trim($_POST['editId']) ==''){
	
	$gitName = clean($_POST['gitName']);
	$inclusion = clean($_POST['inclusion']);
	$exclusion = clean($_POST['exclusion']);
	$termscondition = clean($_POST['termscondition']);
	$cancelation = clean($_POST['cancelation']);
	$paymentpolicy = clean($_POST['paymentpolicy']);
	$serviceupgradation = clean($_POST['serviceupgradation']);
	$optionaltour = clean($_POST['optionaltour']);
	$remarks = clean($_POST['remarks']);
	$status = clean($_POST['status']);
	$byDefault = clean($_POST['byDefault']);
	// $destinationid = $_POST['destinationId'];
	$destinationList = implode(',', $_POST['destinationId']);

	$IncGITTextBox_1 = clean($_POST['IncGITTextBox_1']);
	$IncGITTextBox_2 = clean($_POST['IncGITTextBox_2']);
	$IncGITTextBox_3 = clean($_POST['IncGITTextBox_3']);
	$IncGITTextBox_4 = clean($_POST['IncGITTextBox_4']);
	$IncGITTextBox_5 = clean($_POST['IncGITTextBox_5']);
	$IncGITTextBox_6 = clean($_POST['IncGITTextBox_6']);
	$IncGITTextBox_7 = clean($_POST['IncGITTextBox_7']);
	$IncGITTextBox_8 = clean($_POST['IncGITTextBox_8']);
	$IncGITTextBox_9 = clean($_POST['IncGITTextBox_9']);


	// $overviewdesid = implode(",", $destinationid);
	$dateAdded=time();
	
 if ($gitName!='') {   
		$rs2=GetPageRecord('*','gitIncExcMaster','gitName="'.$gitName.'"');
		if(mysqli_num_rows($rs2)<1){
			$namevalue ='gitName="'.$gitName.'",inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",paymentpolicy="'.$paymentpolicy.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",remarks="'.$remarks.'",destinationId="'.$destinationList.'",title_1="'.$IncGITTextBox_1.'",title_2="'.$IncGITTextBox_2.'",title_3="'.$IncGITTextBox_3.'",title_4="'.$IncGITTextBox_4.'",title_5="'.$IncGITTextBox_5.'",title_6="'.$IncGITTextBox_6.'",title_7="'.$IncGITTextBox_7.'",title_8="'.$IncGITTextBox_8.'",title_9="'.$IncGITTextBox_9.'",status="'.$status.'",byDefault="'.$byDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
		$lastid = addlistinggetlastid('gitIncExcMaster',$namevalue); 
		  
		// 	foreach ($destinationid as $des) {
		// 	  $namevalue ='destinationId="'.$des.'",overviewId="'.$lastid.'"';
		//    $add = addlisting('overviewDescription',$namevalue);
		// }
		?>
	 <script>
	 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
	 </script> 
	 <?php  
		}else{
			  ?>
			 <script>
			 parent.alert('Duplicate data found !!');
			 parent.$('#pageloader').hide();
			 parent.$('#pageloading').hide();
			 </script> 
			 <?php
		}
 }else{
		 ?>
		 <script>
		 parent.alert('Please enter GIT  Name.. !!');
		 parent.$('#pageloader').hide();
		 parent.$('#pageloading').hide();
		 </script> 
		 <?php
	 }
	
	
	
   }
 
 if(clean($_POST['action'])=='addedit_GITInculsionsIExculsionsITCICancellationPolicy' && clean($_POST['editId'])!='' && $_POST['module']!=''){ 

	$gitName = clean($_POST['gitName']);
	$inclusion = clean($_POST['inclusion']);
	$exclusion = clean($_POST['exclusion']);
	$termscondition = clean($_POST['termscondition']);
	$cancelation = clean($_POST['cancelation']);
	$paymentpolicy = clean($_POST['paymentpolicy']);
	$serviceupgradation = clean($_POST['serviceupgradation']);
	$optionaltour = clean($_POST['optionaltour']);
	$remarks = clean($_POST['remarks']);
	$status = clean($_POST['status']);
	$byDefault = clean($_POST['byDefault']);
	$editId = $_POST['editId'];
	$destinationList = implode(',', $_POST['destinationId']);

	$IncGITTextBox_1 = clean($_POST['IncGITTextBox_1']);
	$IncGITTextBox_2 = clean($_POST['IncGITTextBox_2']);
	$IncGITTextBox_3 = clean($_POST['IncGITTextBox_3']);
	$IncGITTextBox_4 = clean($_POST['IncGITTextBox_4']);
	$IncGITTextBox_5 = clean($_POST['IncGITTextBox_5']);
	$IncGITTextBox_6 = clean($_POST['IncGITTextBox_6']);
	$IncGITTextBox_7 = clean($_POST['IncGITTextBox_7']);
	$IncGITTextBox_8 = clean($_POST['IncGITTextBox_8']);
	$IncGITTextBox_9 = clean($_POST['IncGITTextBox_9']);

	// $destinationid = $_POST['destinationId'];
	
	// $overviewdesid = implode(",", $destinationid);
	// $dateAdded=time();
	// echo $_POST['module'];
	$rs2=GetPageRecord('*','gitIncExcMaster','gitName="'.$gitName.'" and id!= "'.$editId.'" ');
	if(mysqli_num_rows($rs2)>0){
	 ?>
	 <script>
	 parent.alert('Duplicate data found !!');
	 parent.$('#pageloader').hide();
	 parent.$('#pageloading').hide();
	 </script> 
 
	 <?php
 
	}else{
	$where='id="'.$editId.'"'; 
	echo $namevalue ='gitName="'.$gitName.'",inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",paymentpolicy="'.$paymentpolicy.'",remarks="'.$remarks.'",destinationId="'.$destinationList.'",title_1="'.$IncGITTextBox_1.'",title_2="'.$IncGITTextBox_2.'",title_3="'.$IncGITTextBox_3.'",title_4="'.$IncGITTextBox_4.'",title_5="'.$IncGITTextBox_5.'",title_6="'.$IncGITTextBox_6.'",title_7="'.$IncGITTextBox_7.'",title_8="'.$IncGITTextBox_8.'",title_9="'.$IncGITTextBox_9.'",status="'.$status.'",byDefault="'.$byDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	$adds = updatelisting('gitIncExcMaster',$namevalue,$where);
	
	 //  foreach ($destinationid as $des) {
	 //   $rsd=GetPageRecord('*','overviewDescription',' destinationId="'.$des.'"');
	 //   $countrow=mysqli_num_rows($rsd);	
	 //   if($countrow>0){
	 //     $namevalue1 ='destinationId="'.$des.'"';
	 //     $add12 = updatelisting('overviewDescription',$namevalue1,$where); 
	 //   }else{  
		//     $namevalue ='destinationId="'.$des.'",overviewId="'.$editId.'"';
	 //     $add = addlisting('overviewDescription',$namevalue);
	 //   }
 //    }
 }
	?>
 <script>
 parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
 parent.$('#pageloader').hide();
		 parent.$('#pageloading').hide();
		 </script> 
 
 <?php
		 
	}

	// letter language add and edit query
if(trim($_POST['action'])=='saveOverviewLanguage' && isset($_POST['saveOverviewLanguage'])){  

	$count = $_POST['count'];
	$overviewId = $_POST['overviewId'];
	for($k=1; $k <= $count; $k++){
		$editId = $_POST['editId'.$k];
		$languageId = $_POST['languageId'.$k]; 
		$overview =  mysqli_real_escape_string(db(),urldecode($_POST['overview'.$k]));
		$highlight =  mysqli_real_escape_string(db(),urldecode($_POST['highlight'.$k]));
		$itineraryIntro =  mysqli_real_escape_string(db(),urldecode($_POST['itineraryIntro'.$k]));
		$itinerarySummary =  mysqli_real_escape_string(db(),urldecode($_POST['itinerarySummary'.$k]));
		$dateAdded = time();
		$modifyDate = time();
	
		$namevalue1 ='overview="'.$overview.'",highlight="'.$highlight.'",overviewId="'.$overviewId.'",itineraryIntro="'.$itineraryIntro.'",itinerarySummary="'.$itinerarySummary.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	
		$namevalue ='overview="'.$overview.'",overviewId="'.$overviewId.'",highlight="'.$highlight.'",itineraryIntro="'.$itineraryIntro.'",itinerarySummary="'.$itinerarySummary.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
		  
		  if($editId !=''){ 
			 $where='id="'.$editId.'"'; 
			$update = updatelisting('overviewLanguageMaster',$namevalue,$where);
			
		 }else{  
			 $add = addlistinggetlastid('overviewLanguageMaster',$namevalue1); 	 
		 } 
	 }
		?>
		<script>
		parent.setupbox('showpage.crm?module=overview&alt=1');
		</script> 
	<?php  } 
		
	
 
// git inclusion sec ended
 

// git inactive and avtive section code started
if(trim($_REQUEST['action'])=='delete_'.$_REQUEST['module']){    
	$check_list=$_REQUEST['check_list'];  
	$modifyDate = time();
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$where='id='.$ansval.''; 
				$namevalue ='status="0",modifyDate="'.$modifyDate.'",addedBy="'.$_SESSION['userid'].'"';  
				$update = updatelisting('gitIncExcMaster',$namevalue,$where); 
			//	$sql_del="delete from ".$_REQUEST['table']."  where id='".$ansval."'"; 
			//	mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['module'];?>&alt=3');
	</script>
	<?php
}
// git inactive and avtive section code ended 




if(trim($_REQUEST['action'])=='delete_'.$_REQUEST['module']){    
	$check_list=$_REQUEST['check_list'];  
	$modifyDate = time();
	if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++){ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
				$where='id='.$ansval.''; 
				$namevalue ='status="0",modifyDate="'.$modifyDate.'",addedBy="'.$_SESSION['userid'].'"';  
				$update = updatelisting(_OVERVIEW_MASTER_,$namevalue,$where); 
			//	$sql_del="delete from ".$_REQUEST['table']."  where id='".$ansval."'"; 
			//	mysqli_query (db(),$sql_del) or die(mysqli_error(db()));
			} 
		} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['module'];?>&alt=3');
	</script>
	<?php
} 
// letter add and edit query
if(trim($_POST['action'])=='addedit_lettermaster' && trim($_POST['letterName'])!=''){  
	$letterName=clean($_POST['letterName']);   
	$letterType=clean($_POST['letterType']);   
	$greetingNote= clean($_POST['greetingNote']);   
	$welcomeNote=mysqli_real_escape_string(db(),$_POST['welcomeNote']);  
	// $welcomeNote=clean($_POST['welcomeNote']);  
	
	$status=clean($_POST['status']); 
	$dateAdded=time(); 
	$modifyDate=time();  
	$namevalue ='letterName="'.$letterName.'",letterType="'.$letterType.'",greetingNote="'.$greetingNote.'",welcomeNote="'.$welcomeNote.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	$namevalue1 ='letterName="'.$letterName.'",letterType="'.$letterType.'",greetingNote="'.$greetingNote.'",welcomeNote="'.$welcomeNote.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
  	if(clean($_POST['editId']) !='' ){ 
 		$where='id="'.$_POST['editId'].'"'; 
		$entraceId = $_POST['editId'];
		$update = updatelisting('letterMaster',$namevalue,$where);
		$msgbox = 2; 
		
 	}else{  
		$addnewyes = checkduplicate('letterMaster','letterName="'.$letterName.'"'); 
		if($addnewyes!='yes'){
	
 		$entraceId = addlistinggetlastid('letterMaster',$namevalue1); 
 		$msgbox = 1;
		
		 
 	}else{ ?>
		<script> alert('<?php echo $letterName; ?> is already exist...!'); </script>
	 <?php }
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=lettermaster&alt=<?php echo $msgbox; ?>');
	</script> 
<?php  }

if(trim($_POST['action'])=='addedit_guidepaxslabmaster'){ 
	
	$editId=$_REQUEST['editId'];
	$minPax=clean($_POST['minPax']); 
	$maxPax=clean($_POST['maxPax']);
	$guideSlabName= $minPax.'-'.$maxPax.' Pax';
	$status=clean($_POST['status']);   
	$dateAdded=time();
	
	$rs2=GetPageRecord('*','guidePaxSlabMaster','minPax="'.$minPax.'" and maxPax="'.$maxPax.'" and id!="'.$editId.'"'); 
	if(mysqli_num_rows($rs2) == 0){
	
		if($editId==''){
			$namevalue ='minPax="'.$minPax.'",status="'.$status.'",maxPax="'.$maxPax.'" ,guideSlabName="'.$guideSlabName.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$adds = addlisting('guidePaxSlabMaster',$namevalue); 
			$msg=1;
		}else{
			$where2='id='.$editId.'';
			$namevalue2 ='minPax="'.$minPax.'",status="'.$status.'",guideSlabName="'.$guideSlabName.'",maxPax="'.$maxPax.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$update = updatelisting('guidePaxSlabMaster',$namevalue2,$where2);
			$msg=2;
		}
	
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
	<?php 
	}else{
	?>
		<script>
		parent.alert('<?php echo ucfirst($serviceType);?> GST Value is already exist!');
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
	<?php
	}
} 
// letter language add and edit query
if(trim($_POST['action'])=='saveLetterLanguage' && isset($_POST['savelanguage'])){  

	// $count = $_POST['count']; 
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id'];

	    $letterId = $_POST['letterId'.$k];
	    $editId = $_POST['editId'.$k]; 
	    $description =  mysqli_real_escape_string(db(),urldecode($_POST['description'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='description="'.$description.'",letterId="'.$letterId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='letterId="'.$letterId.'",languageId="'.$languageId.'",description="'.$description.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('letterLanguageMaster',$namevalue,$where);
			
	 	}else{  
	 		$add = addlistinggetlastid('letterLanguageMaster',$namevalue1); 	 
	 	} 
	 }
	?>
	<script>
	parent.setupbox('showpage.crm?module=lettermaster&alt=1');
	</script> 
<?php  }
// letter language add and edit query


// inclusion,exclusion,termscondition,cancelation,
// paymentpolicy,serviceupgradation,optionaltour,remarks

// fit inclusion sec started
if(trim($_POST['action'])=='saveFitLanguage' && isset($_POST['saveFitLanguage'])){  

	// $count = $_POST['count'];
	$fitId = $_POST['fitId'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $inclusion =  mysqli_real_escape_string(db(),urldecode($_POST['inclusion'.$k]));
	    $exclusion =  mysqli_real_escape_string(db(),urldecode($_POST['exclusion'.$k]));
		$termscondition =  mysqli_real_escape_string(db(),urldecode($_POST['termscondition'.$k]));
	    $cancelation =  mysqli_real_escape_string(db(),urldecode($_POST['cancelation'.$k]));
		$paymentpolicy =  mysqli_real_escape_string(db(),urldecode($_POST['paymentpolicy'.$k]));
		$serviceupgradation =  mysqli_real_escape_string(db(),urldecode($_POST['serviceupgradation'.$k]));
		$optionaltour =  mysqli_real_escape_string(db(),urldecode($_POST['optionaltour'.$k]));
	    $remarks =  mysqli_real_escape_string(db(),urldecode($_POST['remarks'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",remarks="'.$remarks.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",paymentpolicy="'.$paymentpolicy.'",fitId="'.$fitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='inclusion="'.$inclusion.'",fitId="'.$fitId.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",remarks="'.$remarks.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",paymentpolicy="'.$paymentpolicy.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('fitLanguageMaster',$namevalue,$where);
	 	}else{  
	 		$add = addlistinggetlastid('fitLanguageMaster',$namevalue1); 	 
	 	} 
	}
	?>
	<script>
	parent.setupbox('showpage.crm?module=FITInculsionsIExculsionsITCICancellationPolicy&alt=1');
	</script> 
	<?php  
} 
// fit inclusion sec ended




// git inclusion sec started
if(trim($_POST['action'])=='saveGitLanguage' && isset($_POST['saveGitLanguage'])){  

	// $count = $_POST['count'];
	$fitId = $_POST['fitId'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $inclusion =  mysqli_real_escape_string(db(),urldecode($_POST['inclusion'.$k]));
	    $exclusion =  mysqli_real_escape_string(db(),urldecode($_POST['exclusion'.$k]));
		$termscondition =  mysqli_real_escape_string(db(),urldecode($_POST['termscondition'.$k]));
	    $cancelation =  mysqli_real_escape_string(db(),urldecode($_POST['cancelation'.$k]));
		$serviceupgradation =  mysqli_real_escape_string(db(),urldecode($_POST['serviceupgradation'.$k]));
		$optionaltour =  mysqli_real_escape_string(db(),urldecode($_POST['optionaltour'.$k]));
		$paymentpolicy =  mysqli_real_escape_string(db(),urldecode($_POST['paymentpolicy'.$k]));
	    $remarks =  mysqli_real_escape_string(db(),urldecode($_POST['remarks'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='inclusion="'.$inclusion.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",remarks="'.$remarks.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",paymentpolicy="'.$paymentpolicy.'",gitId="'.$fitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='inclusion="'.$inclusion.'",gitId="'.$fitId.'",exclusion="'.$exclusion.'",termscondition="'.$termscondition.'",cancelation="'.$cancelation.'",remarks="'.$remarks.'",serviceupgradation="'.$serviceupgradation.'",optionaltour="'.$optionaltour.'",paymentpolicy="'.$paymentpolicy.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('gitLanguageMaster',$namevalue,$where);
	 	}else{  
	 		$add = addlistinggetlastid('gitLanguageMaster',$namevalue1); 	 
	 	} 
	}
	?>
	<script>
	parent.setupbox('showpage.crm?module=GITInculsionsIExculsionsITCICancellationPolicy&alt=1');
	</script> 
	<?php  
} 
// git inclusion sec ended

if(trim($_POST['action'])=='saveFitTermsInclusionLanguage' && isset($_POST['saveFitTermsInclusionLanguage'])){  

	// $count = $_POST['count'];

	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id'];

	    $fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $inclusion =  mysqli_real_escape_string(db(),urldecode($_POST['inclusion'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='inclusion="'.$inclusion.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",inclusion="'.$inclusion.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where); 
	 	}else{  
	 		$add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
	 	} 
	}
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	<script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  }  
}

// git payment policy started
if(trim($_POST['action'])=='saveTremFitPaymentLanguage' && isset($_POST['saveTremFitPaymentLanguage'])){  

	// $count = $_POST['count'];
	
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id'];
 
		$fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
		// $languageId = $_POST['languageId'.$k]; 
		$paymentpolicy =  mysqli_real_escape_string(db(),urldecode($_POST['paymentpolicy'.$k]));
		$dateAdded = time();
		$modifyDate = time();
	
		$namevalue1 ='paymentpolicy="'.$paymentpolicy.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	
		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",paymentpolicy="'.$paymentpolicy.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
		  
		  if($editId !=''){ 
			 $where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
		 }else{  
			 $add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
		 } 
	 }
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	 <script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  
	}  
}
// git payment policy ended



// git remarks started
if(trim($_POST['action'])=='saveFitTermsRemarksLanguage' && isset($_POST['saveFitTermsRemarksLanguage'])){  

	// $count = $_POST['count'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 

		$fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
		// $languageId = $_POST['languageId'.$k]; 
		$remarks =  mysqli_real_escape_string(db(),urldecode($_POST['remarks'.$k]));
		$dateAdded = time();
		$modifyDate = time();
	
		$namevalue1 ='remarks="'.$remarks.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	
		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",remarks="'.$remarks.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
		  
		  if($editId !=''){ 
			 $where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
		 }else{  
			 $add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
		 } 
	 }
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	 <script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  
	}  
}
// git remarks ended

if(trim($_POST['action'])=='saveFitTermsExclusionLanguage' && isset($_POST['saveFitTermsExclusionLanguage'])){  

	// $count = $_POST['count'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 

	    $fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $exclusion =  mysqli_real_escape_string(db(),urldecode($_POST['exclusion'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='exclusion="'.$exclusion.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",exclusion="'.$exclusion.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
	 	}else{  
	 		$add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
	 	} 
	 }
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	 <script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  
	}  
}

if(trim($_POST['action'])=='saveFitTermsCancelLanguage' && isset($_POST['saveFitTermsCancelLanguage'])){  

	// $count = $_POST['count'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 
 
	    $fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $cancellation =  mysqli_real_escape_string(db(),urldecode($_POST['cancellation'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='cancellation="'.$cancellation.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",cancellation="'.$cancellation.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
	 	}else{  
	 		$add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
	 	} 
	}
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	<script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  }  
}

if(trim($_POST['action'])=='saveFitTermsConditionLanguage' && isset($_POST['saveFitTermsConditionLanguage'])){  

	// $count = $_POST['count'];

	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 

	    $fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $termscondition =  mysqli_real_escape_string(db(),urldecode($_POST['termscondition'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='termscondition="'.$termscondition.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",termscondition="'.$termscondition.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
	 	}else{  
	 		$add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
	 	} 
	}
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	 <script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  
	}  
} 

// started payment view language
if(trim($_POST['action'])=='saveFitTermsPaymentLanguage' && isset($_POST['saveFitTermsPaymentLanguage'])){  

	// $count = $_POST['count'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 
 
		$fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
		$languageId = $_POST['languageId'.$k]; 
		$paymentpolicy =  mysqli_real_escape_string(db(),urldecode($_POST['paymentpolicy'.$k]));
		$dateAdded = time();
		$modifyDate = time();
	
		$namevalue1 ='paymentpolicy="'.$paymentpolicy.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	
		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",paymentpolicy="'.$paymentpolicy.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
		  
		  if($editId !=''){ 
			 $where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
		 }else{  
			 $add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
		 } 
	}
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	<script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  }  
} 
// ended payment vew language


// started remarks view language
if(trim($_POST['action'])=='saveFitTermsRemarksLanguage' && isset($_POST['saveFitTermsRemarksLanguage'])){  

	// $count = $_POST['count'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id'];  
		$fitgitId = $_POST['fitgitId'.$k];
		$editId = $_POST['editId'.$k];
		// $languageId = $_POST['languageId'.$k]; 
		$remarks =  mysqli_real_escape_string(db(),urldecode($_POST['remarks'.$k]));
		$dateAdded = time();
		$modifyDate = time();
	
		$namevalue1 ='remarks="'.$remarks.'",fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';
	
		$namevalue ='fit_gitId="'.$fitgitId.'",languageId="'.$languageId.'",remarks="'.$remarks.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
		  
		  if($editId !=''){ 
			 $where='id="'.$editId.'"'; 
			$update = updatelisting('termsConditionsLanguageMaster',$namevalue,$where);
			
		 }else{  
			 $add = addlistinggetlastid('termsConditionsLanguageMaster',$namevalue1); 	 
		 } 
	 }
	if($_POST['redirectId'] == '1') { ?>
	<script>
	parent.setupbox('showpage.crm?module=fitterms&edit=yes&type=FIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php } else { ?>
	 <script>
	parent.setupbox('showpage.crm?module=gitterms&edit=yes&type=GIT&id=<?php echo encode($_POST['redirectId']); ?>');
	</script>
	<?php  }  
} 
// ended remarks view language


if(trim($_POST['action'])=='saveSubjectLanguage' && isset($_POST['saveSubjectLanguage'])){  

	// $count = $_POST['count'];
	$subjectId = $_POST['subjectId'];
	$rs = GetPageRecord('*', 'tbl_languagemaster', '1 and status=1 and deletestatus=0'); 
	while ($languageDetails = mysqli_fetch_array($rs)) {
		// for($k=1; $k <= $count; $k++){ 
		$k = $languageId = $languageDetails['id']; 

		$editId = $_POST['editId'.$k];
	    // $languageId = $_POST['languageId'.$k]; 
	    $title =  mysqli_real_escape_string(db(),urldecode($_POST['title'.$k]));
	    $description =  mysqli_real_escape_string(db(),urldecode($_POST['description'.$k]));
	    $dateAdded = time();
	    $modifyDate = time();

		$namevalue1 ='title="'.$title.'",description="'.$description.'",subjectId="'.$subjectId.'",languageId="'.$languageId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

		$namevalue ='title="'.$title.'",subjectId="'.$subjectId.'",description="'.$description.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
	  	
	  	if($editId !=''){ 
	 		$where='id="'.$editId.'"'; 
			$update = updatelisting('subjectLanguageMaster',$namevalue,$where);
			
	 	}else{  
	 		$add = addlistinggetlastid('subjectLanguageMaster',$namevalue1); 	 
	 	} 
	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=subjectmaster&alt=1');
	</script> 
	<?php  
} 

if(trim($_POST['action'])=='addedit_bankMaster' && trim($_POST['editId'])=='' && trim($_POST['bankname'])!='' && trim($_POST['module'])!=''){ 

	$bankName=clean($_POST['bankname']);

	$accountNumber=clean($_POST['accountnumber']);

	$accountType=clean($_POST['accounttype']);
	
	$branchAddress=clean($_POST['branchaddress']);

	$branchIFSC=clean($_POST['branchifsc']);
	
	$branchSwiftCode=clean($_POST['branchswiftcode']);

	$beneficiaryName=clean($_POST['beneficiaryname']);   

	$status=clean($_POST['status']); 
	$bydefshowhide=clean($_POST['bydefshowhide']); 
	$title=clean($_POST['title']); 

	// bankupid,qrcodeimage 

	$bankupid=clean($_POST['bankupid']);

	if(!empty($_FILES['qrcodeimage']['name'])){  
		$qrcodeimage = str_replace(" ","_",trim($_FILES['qrcodeimage']['name']));
		$file_name=time().$qrcodeimage;  
		copy($_FILES['qrcodeimage']['tmp_name'],"packageimages/".$file_name);
		$qrcodeimage=$file_name; 
	}

	$dateAdded=time();

	if($_POST['setDefault']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting('bankMaster',$namevalue,$where); 
	}
	else{
	$setDefault=0;	
	}

	$rs1="";
	$rs1=GetPageRecord('*','bankMaster','bankName="'.$bankName.'" and accountNumber="'.$accountNumber.'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){

		$namevalue ='bankName="'.$bankName.'",accountType="'.$accountType.'",beneficiaryName="'.$beneficiaryName.'",branchIFSC="'.$branchIFSC.'",bankupid="'.$bankupid.'",qrcodeimage="'.$qrcodeimage.'",branchSwiftCode="'.$branchSwiftCode.'",accountNumber="'.$accountNumber.'",status="'.$status.'",bydefshowhide="'.$bydefshowhide.'",branchAddress="'.$branchAddress.'",setDefault="'.$setDefault.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'",title="'.$title.'"';  
		$adds = addlisting('bankMaster',$namevalue); 
		?>
		<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
	}else{ ?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=3');	
		parent.alert('This Account is already exist in <?php echo $bankName; ?> Bank..');
		</script>	
	<?php } 
}

if(trim($_POST['action'])=='addedit_bankMaster' && trim($_POST['editId'])!='' && trim($_POST['bankname'])!='' && trim($_POST['module'])!=''){  

	$bankName=clean($_POST['bankname']);

	$accountNumber=clean($_POST['accountnumber']);

	$accountType=clean($_POST['accounttype']);
	
	$branchAddress=clean($_POST['branchaddress']);

	$branchIFSC=clean($_POST['branchifsc']);
	
	$branchSwiftCode=clean($_POST['branchswiftcode']);

	$beneficiaryName=clean($_POST['beneficiaryname']);   

	$status=clean($_POST['status']); 
	$bydefshowhide=clean($_POST['bydefshowhide']); 
	$title=clean($_POST['title']); 

	// bankupid,qrcodeimage 

	$bankupid=clean($_POST['bankupid']);

	if(!empty($_FILES['qrcodeimage']['name'])){  
		$qrcodeimage = str_replace(" ","_",trim($_FILES['qrcodeimage']['name']));
		$file_name=time().$qrcodeimage;  
		copy($_FILES['qrcodeimage']['tmp_name'],"packageimages/".$file_name);
		$qrcodeimage=$file_name; 
	}

	$modifyDate=time();

	if($_POST['setDefault']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting('bankMaster',$namevalue,$where); 
	}
	else{
	$setDefault=0;	
	}

	$rs1="";
	$rs1=GetPageRecord('*','bankMaster','id!= "'.trim($_POST['editId']).'" and bankName="'.$bankName.'" and accountNumber="'.$accountNumber.'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){

		$where='id='.trim($_POST['editId']).''; 
		$namevalue ='bankName="'.$bankName.'",accountType="'.$accountType.'",beneficiaryName="'.$beneficiaryName.'",branchIFSC="'.$branchIFSC.'",bankupid="'.$bankupid.'",qrcodeimage="'.$qrcodeimage.'",branchSwiftCode="'.$branchSwiftCode.'",accountNumber="'.$accountNumber.'",status="'.$status.'",bydefshowhide="'.$bydefshowhide.'",branchAddress="'.$branchAddress.'",setDefault="'.$setDefault.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'",title="'.$title.'"';  
		$update = updatelisting('bankMaster',$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php
	} else{ 
		?>
		<script>
		parent.alert('Duplicate Bank not allowed.');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
		</script> 
		<?php
	}

}


// SAC Code Master Start========================================================

if(trim($_POST['action'])=='addedit_SACcodeMaster' && trim($_POST['editId'])=='' && trim($_POST['serviceType'])!='' && trim($_POST['module'])!=''){ 

	$serviceType=clean($_POST['serviceType']);

	$sacCode=clean($_POST['sacCode']);

	$status=clean($_POST['status']); 

	$dateAdded=time();
	
	//---------------------

	// $duplicateres = GetPageRecord('*','sacCodeMaster','serviceType="'.$serviceType.'"');
	// if(mysqli_num_rows($duplicateres)>0){
	// 	?>
	 	<script>
	// 		alert("SacCode Name already Exist!");
	// 		parent.$('#pageloader').hide();
	// 	parent.$('#pageloading').hide();
	// 	</script>
		
		<?php
	// 	exit();
	// }else{

	
// ----------------

	if($_POST['defaultSACCode']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting('sacCodeMaster',$namevalue,$where); 
	}
	else{
	$setDefault=0;	
	}

		$namevalue ='serviceType="'.$serviceType.'",sacCode="'.$sacCode.'",setDefault="'.$setDefault.'",status="'.$status.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
		$adds = addlisting('sacCodeMaster',$namevalue); 
		?>
		<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=1');
		</script> 
		<?php
		}
		
// }
// Sac code master
if(trim($_POST['action'])=='addedit_SACcodeMaster' && trim($_POST['editId'])!='' && trim($_POST['serviceType'])!='' && trim($_POST['module'])!=''){  

	$serviceType=clean($_POST['serviceType']);

	$sacCode=clean($_POST['sacCode']);

	$status=clean($_POST['status']); 

	$modifyDate=time();
	

	if($_POST['defaultSACCode']==1){
		$setDefault=1;
		$where='1'; 
		$namevalue ='setDefault="0"';
		$update = updatelisting('sacCodeMaster',$namevalue,$where); 
	}
	else{
	$setDefault=0;	
	}
		$where='id='.trim($_POST['editId']).''; 
		$namevalue ='serviceType="'.$serviceType.'",sacCode="'.$sacCode.'",setDefault="'.$setDefault.'",status="'.$status.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
		$update = updatelisting('sacCodeMaster',$namevalue,$where); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php

}



// islam visa
if($_POST['action']=="addedit_VISAtype" && $_POST['module']=="VISAtype"){
	$VISAtype = $_POST['VISAtype'];
	$status = $_POST['status'];
	$editId = $_POST['editId'];



	$rsr=GetPageRecord('*','visaTypeMaster','name="'.$VISAtype.'" '); 
	$editresult=mysqli_num_rows($rsr);
	if(mysqli_num_rows($rsr) > 0 && $_POST['editId'] < 1){
        ?>
        <script>
        parent.alert('Visa Type Already Exist!');
		parent.$('#pageloader').hide();
		parent.$('#pageloading').hide();
        </script> 
        <?php 
		
    }else{
		
		if($editId==''){
			$namevalue = 'name="'.$VISAtype.'", status="'.$status.'"';
			addlisting('visaTypeMaster',$namevalue);
			$msg = 1;
		}else{
			$namevalue = 'name="'.$VISAtype.'", status="'.$status.'"';
			$where='id="'.$editId.'"';
			updatelisting('visaTypeMaster',$namevalue,$where);
			$msg = 2;
		}
		?>
			<script>
			parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
			</script> 
			<?php
	}
}


if($_POST['action']=="addedit_visacostmaster" && $_POST['module']=="visacostmaster"){
		$VISAtcost = $_POST['VISAtcost'];
		$VISATypeId = $_POST['VISATypeId'];
		$countryId=clean($_POST['countryId']); 
		$entryType=clean($_POST['entryType']); 
		$validity=clean($_POST['validity']); 
		$status = $_POST['status'];
		$editId = $_POST['editId'];

		// Visa Code genrated 
		$A = GetPageRecord('displayId','visaCostMaster','displayId>0 order by displayId desc');
		$ddata = mysqli_fetch_assoc($A);
		$displayId = $ddata['displayId']+1;

		
		
		$namevalue = 'name="'.$VISAtcost.'",countryId="'.$countryId.'",entryType="'.$entryType.'",validity="'.$validity.'",visaType="'.$VISATypeId.'",status="'.$status.'",displayId="'.$displayId .'"';
		if($editId==''){
			addlisting('visaCostMaster',$namevalue);
			$msg = 1;
		}else{
			$where='id="'.$editId.'"';
			updatelisting('visaCostMaster',$namevalue,$where);
			$msg = 2;
		}
	?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php
}

if($_POST['action']=="addedit_insuranceType" && $_POST['module']=="insuranceType"){
	$insuranceType = $_POST['insuranceType'];
	$VISATypeId = $_POST['VISATypeId'];
	$status = $_POST['status'];
	$editId = $_POST['editId'];
	
	
	$namevalue = 'name="'.$insuranceType.'",status="'.$status.'"';
	if($editId==''){
		addlisting('InsuranceTypeMaster',$namevalue);
		$msg = 1;
	}else{
		$where='id="'.$editId.'"';
		updatelisting('InsuranceTypeMaster',$namevalue,$where);
		$msg = 2;
	}
	?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php
}


if($_POST['action']=="addedit_insurancecostmaster" && $_POST['module']=="insurancecostmaster"){
	$insuranceCost = $_POST['insuranceCost'];
	$insuranceTypeId = $_POST['insuranceTypeId'];
	$status = $_POST['status'];
	$editId = $_POST['editId'];

	// insurance Code genrated 
	$A = GetPageRecord('displayId','insuranceCostMaster','displayId>0 order by displayId desc');
	$ddata = mysqli_fetch_assoc($A);
	$displayId = $ddata['displayId']+1;
	
	
	$namevalue = 'name="'.$insuranceCost.'",insuranceType="'.$insuranceTypeId.'",status="'.$status.'",displayId="'.$displayId .'"';
	if($editId==''){
		addlisting('insuranceCostMaster',$namevalue);
		$msg = 1;
	}else{
		$where='id="'.$editId.'"';
		updatelisting('insuranceCostMaster',$namevalue,$where);
		$msg = 2;
	}
	?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php
}


// Passport Type Start ============================================
if($_POST['action']=="addedit_passportTypeMaster" && $_POST['module']=="passportTypeMaster"){
	$passportType = $_POST['passportType'];
	
	$status = $_POST['status'];
	$editId = $_POST['editId'];
	
	
	$namevalue = 'name="'.$passportType.'",status="'.$status.'"';
	if($editId==''){
		addlisting('passportTypeMaster',$namevalue);
		$msg = 1;
	}else{
		$where='id="'.$editId.'"';
		updatelisting('passportTypeMaster',$namevalue,$where);
		$msg = 2;
	}
	?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php
}


if($_POST['action']=="addedit_passportCostMaster" && $_POST['module']=="passportCostMaster"){
	$passportName = $_POST['passportName'];
	$passportTypeId = $_POST['passportTypeId'];
	$status = $_POST['status'];
	$editId = $_POST['editId'];
	
	
	$namevalue = 'name="'.$passportName.'",passportType="'.$passportTypeId.'",status="'.$status.'"';
	if($editId==''){
		addlisting('passportCostMaster',$namevalue);
		$msg = 1;
	}else{
		$where='id="'.$editId.'"';
		updatelisting('passportCostMaster',$namevalue,$where);
		$msg = 2;
	}
	?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php echo $msg; ?>');
		</script> 
		<?php
}


// Deactivate VISA type Master End========================================================

if($_REQUEST['action']=='deletePassportType'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('passportTypeMaster',$namevalue,$where); 
	 generateLogs('Passport','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=passportTypeMaster&alt=3');
	</script>
	<?php
	}

	if($_REQUEST['action']=='deletePassportCost'){  
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('passportCostMaster',$namevalue,$where); 
		 generateLogs('Passport','delete',$ansval);
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=passportCostMaster&alt=3');
		</script>
		<?php
		}

if($_REQUEST['action']=='deleteVisatype'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('visaTypeMaster',$namevalue,$where); 
	 generateLogs('VISA','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=VISAtype&alt=3');
	</script>
	<?php
	}

	if($_REQUEST['action']=='deleteVisaCost'){  
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		 for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		  
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('visaCostMaster',$namevalue,$where); 
		 generateLogs('VISA','delete',$ansval);
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=visacostmaster&alt=3');
		</script>
		<?php
		}
	
		if($_REQUEST['action']=='deleteInsuranceType'){  
			$check_list=$_REQUEST['check_list'];  
			if($check_list!=""){  
			 for($i=0;$i<=count($check_list)-1;$i++) 
			{ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
			  
			$namevalue ='status=0';  
			$where='id="'.$ansval.'"';  
			$update = updatelisting('InsuranceTypeMaster',$namevalue,$where); 
			 generateLogs('Insurance','delete',$ansval);
			} } } 
			?>
			<script>
			parent.setupbox('showpage.crm?module=insuranceType&alt=3');
			</script>
			<?php
			}

		if($_REQUEST['action']=='deleteInsuranceCost'){  
			$check_list=$_REQUEST['check_list'];  
			if($check_list!=""){  
			 for($i=0;$i<=count($check_list)-1;$i++) 
			{ 
			$ansval=trim(decode($check_list[$i])); 
			if(trim($ansval) != ''){   
			  
			$namevalue ='status=0';  
			$where='id="'.$ansval.'"';  
			$update = updatelisting('insuranceCostMaster',$namevalue,$where); 
			 generateLogs('Insurance','delete',$ansval);
			} } } 
			?>
			<script>
			parent.setupbox('showpage.crm?module=insurancecostmaster&alt=3');
			</script>
			<?php
			}

if($_REQUEST['action']=='SACcodedelete'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('sacCodeMaster',$namevalue,$where); 
	 generateLogs('SAC','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=SACcodeMaster&alt=3');
	</script>
	<?php
	}
// delete sac code end==========================


if($_REQUEST['action']=='deleteMarketType'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('marketMaster',$namevalue,$where); 
 
// generateLogs('country','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=marketTypeMaster&alt=3');
</script>
<?php
}


if($_REQUEST['action']=='deleteGredeMaster'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('gradeMaster',$namevalue,$where); 
	 generateLogs('gradeMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=grademaster&alt=3');
	</script>
	<?php
	}




if($_REQUEST['action']=='deleteHotelType'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting(_HOTEL_TYPE_MASTER_,$namevalue,$where); 
	 generateLogs(_HOTEL_TYPE_MASTER_,'delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=hotelType&alt=3');
	</script>
	<?php
	}

if($_REQUEST['action']=='deleteAdditionalHotel'){  
	$check_list=$_REQUEST['check_list'];  
	if($check_list!=""){  
	 for($i=0;$i<=count($check_list)-1;$i++) 
	{ 
	$ansval=trim(decode($check_list[$i])); 
	if(trim($ansval) != ''){   
	  
	$namevalue ='status=0';  
	$where='id="'.$ansval.'"';  
	$update = updatelisting('additionalHotelMaster',$namevalue,$where); 
	 generateLogs('additionalHotelMaster','delete',$ansval);
	} } } 
	?>
	<script>
	parent.setupbox('showpage.crm?module=additionalHotelMaster&alt=3');
	</script>
	<?php
	}

if($_REQUEST['action']=='deletebank'){  
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('bankMaster',$namevalue,$where); 
 generateLogs('bankMaster','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=bankMaster&alt=3');
</script>
<?php
}

if(trim($_REQUEST['action'])=='delete_seasonTypeMaster'){  
 
$check_list=$_REQUEST['check_list'];  
if($check_list!=""){  
 for($i=0;$i<=count($check_list)-1;$i++) 
{ 
$ansval=trim(decode($check_list[$i])); 
if(trim($ansval) != ''){   
  
$namevalue ='status=0';  
$where='id="'.$ansval.'"';  
$update = updatelisting('seasonMaster',$namevalue,$where); 
 
generateLogs('Season','delete',$ansval);
} } } 
?>
<script>
parent.setupbox('showpage.crm?module=seasonTypeMaster&alt=3');
</script>
<?php
}


if(trim($_POST['action'])=='saveEnrouteLanguage' && isset($_POST['saveenroute'])){  
$enrouteId = decode($_POST['enrouteId']);
$editId = $_POST['editId1']; 
$destinationId = $_POST['destinationId']; 
$dateAdded = time();
$modifyDate = time();
$description1 =  $_POST['description1'];
$description2 =  $_POST['description2'];
$description3 =  $_POST['description3'];
$description4 =  $_POST['description4'];
$description5 =  $_POST['description5'];
$description6 =  $_POST['description6'];
$description7 =  $_POST['description7'];
$description8 =  $_POST['description8'];
$description9 =  $_POST['description9'];
$description10 =  $_POST['description10'];    

	$namevalue1 ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",enrouteId="'.$enrouteId.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

$namevalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",enrouteId="'.$enrouteId.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
  	
  	if($editId !=''){ 
 		$where='id="'.$editId.'"'; 
		$update = updatelisting('enrouteLanguageMaster',$namevalue,$where);
		
 	}else{  
 		$add = addlistinggetlastid('enrouteLanguageMaster',$namevalue1); 	 
 	} 

	?>
	<script>
	parent.setupbox('showpage.crm?module=enroutemaster&alt=1');
	</script> 
<?php  } 

if(trim($_POST['action'])=='saveDestinationLanguage' && isset($_POST['saveDestination'])){  
	$destinationId = decode($_POST['destinationId']); 
	$dateAdded = time();
	$modifyDate = time();
	$description1 =  $_POST['description1'];
	$description2 =  $_POST['description2'];
	$description3 =  $_POST['description3'];
	$description4 =  $_POST['description4'];
	$description5 =  $_POST['description5'];
	$description6 =  $_POST['description6'];
	$description7 =  $_POST['description7'];
	$description8 =  $_POST['description8'];
	$description9 =  $_POST['description9'];
	$description10 =  $_POST['description10'];    

	$addvalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

	$updatevalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
  	
  	$mainvalue = 'description="'.$description1.'"';
 	$wheremainQuery='id="'.$destinationId.'"'; 
	$wherequery = 'destinationId="'.$destinationId.'"';

	$rs11 = GetPageRecord('*', 'destinationLanguageMaster', $wherequery);
  	if(mysqli_num_rows($rs11)>0){ 
		$update = updatelisting('destinationLanguageMaster',$updatevalue,$wherequery);
		updatelisting(_DESTINATION_MASTER_,$mainvalue,$wheremainQuery);
 	}else{  
 		$add = addlistinggetlastid('destinationLanguageMaster',$addvalue); 
		updatelisting(_DESTINATION_MASTER_,$mainvalue,$wheremainQuery);	 
 	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['moduleName']; ?>&alt=1');
	</script> 
	<?php  
}

if(trim($_POST['action'])=='saveActivityLanguage' && isset($_POST['saveActivity'])){  
	$ActivityId = decode($_POST['ActivityId']);
	$destinationId = $_POST['destinationId']; 
	$dateAdded = time();
	$modifyDate = time();
	$description1 =  $_POST['description1'];
	$description2 =  $_POST['description2'];
	$description3 =  $_POST['description3'];
	$description4 =  $_POST['description4'];
	$description5 =  $_POST['description5'];
	$description6 =  $_POST['description6'];
	$description7 =  $_POST['description7'];
	$description8 =  $_POST['description8'];
	$description9 =  $_POST['description9'];
	$description10 =  $_POST['description10'];    

	$addvalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",ActivityId="'.$ActivityId.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

	$updatevalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
  	
  	$mainvalue = 'otherActivityDetail="'.$description1.'"';
 	$wheremainQuery='id="'.$ActivityId.'"'; 
	$wherequery = 'ActivityId="'.$ActivityId.'"';

	$rs11 = GetPageRecord('*', 'activityLanguageMaster', $wherequery);
  	if(mysqli_num_rows($rs11)>0){ 
		$update = updatelisting('activityLanguageMaster',$updatevalue,$wherequery);
		updatelisting(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$mainvalue,$wheremainQuery);
 	}else{  
 		$add = addlistinggetlastid('activityLanguageMaster',$addvalue); 
		updatelisting(_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$mainvalue,$wheremainQuery);	 
 	} 
	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['moduleName']; ?>&alt=1');
	</script> 
	<?php  
}

if(trim($_POST['action'])=='saveEntranceLanguage' && isset($_POST['saveentrance'])){  
	$entranceId = decode($_POST['entranceId']);
	$editId = $_POST['editId1']; 
	$destinationId = $_POST['destinationId']; 
	$dateAdded = time();
	$modifyDate = time();
	$description1 =  $_POST['description1'];
	$description2 =  $_POST['description2'];
	$description3 =  $_POST['description3'];
	$description4 =  $_POST['description4'];
	$description5 =  $_POST['description5'];
	$description6 =  $_POST['description6'];
	$description7 =  $_POST['description7'];
	$description8 =  $_POST['description8'];
	$description9 =  $_POST['description9'];
	$description10 =  $_POST['description10'];    

	$namevalue1 ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",entranceId="'.$entranceId.'",destinationId="'.$destinationId.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';

	$namevalue ='lang_01="'.$description1.'",lang_02="'.$description2.'",lang_03="'.$description3.'",lang_04="'.$description4.'",lang_05="'.$description5.'",lang_06="'.$description6.'",lang_07="'.$description7.'",lang_08="'.$description8.'",lang_09="'.$description9.'",lang_10="'.$description10.'",entranceId="'.$entranceId.'",destinationId="'.$destinationId.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';
  	
	// for description linking
	$entDescValue = 'entranceDetail="'.$description1.'"';
	$whereEntranceId = 'id="'.$entranceId.'"';

	if($editId !=''){ 

	$where='id="'.$editId.'"'; 
	$update = updatelisting('entranceLanguageMaster',$namevalue,$where);
	updatelisting(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$entDescValue,$whereEntranceId);

	}else{  
	$add = addlistinggetlastid('entranceLanguageMaster',$namevalue1); 	 
	updatelisting(_PACKAGE_BUILDER_ENTRANCE_MASTER_,$entDescValue,$whereEntranceId);
	} 

	?>
	<script>
	parent.setupbox('showpage.crm?module=<?php echo $_REQUEST['moduleName'] ?>&alt=1');
	</script> 
	<?php  
}


// Add commission master

if(trim($_POST['action'])=='addedit_commissionMaster' && trim($_POST['commissionName'])!='' && trim($_POST['module'])!=''){ 
		$commissionName=clean($_POST['commissionName']);
		$commissionPercent=$_POST['commissionPercent']; 
		$status=clean($_POST['status']); 
		$editId=clean($_POST['editId']); 
		$modifyDate=time();
		$where='id="'.$editId.'"'; 

		$namevalue ='percent="'.$commissionPercent.'",name="'.$commissionName.'",dateAdded="'.$modifyDate.'",status="'.$status.'",addedBy="'.$_SESSION['userid'].'"';  
		if($editId!=''){
			$update = updatelisting('commissionMaster',$namevalue,$where); 
		}else{
			$add = addlisting('commissionMaster',$namevalue);
		}

		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=2');
		</script> 
		<?php }


		if($_REQUEST['action']=='deleteCommissionMaster'){  
			
		$check_list=$_REQUEST['check_list'];  
		if($check_list!=""){  
		for($i=0;$i<=count($check_list)-1;$i++) 
		{ 
		$ansval=trim(decode($check_list[$i])); 
		if(trim($ansval) != ''){   
		$namevalue ='status=0';  
		$where='id="'.$ansval.'"';  
		$update = updatelisting('commissionMaster',$namevalue,$where); 
		
		} } } 
		?>
		<script>
		parent.setupbox('showpage.crm?module=commissionMaster&alt=3');
		</script>
		<?php
		}
?>

