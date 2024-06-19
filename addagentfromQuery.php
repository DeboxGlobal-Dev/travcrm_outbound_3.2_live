<?php
include "inc.php";    
if($_REQUEST['action']=='addAgentClienttoQuery' && $_REQUEST['actionType']=='addserviceagentclient' && $_REQUEST['clientType']!=''){

?>  
<style>

	.gridtable td { 
	    border-bottom: #f1f1f1 0px solid !important; 
        padding-bottom: 10px !important;
	}
	.gridtable22 td{
			padding-right: 5px;
			padding-bottom: 12px;
	}
	.gridtable2222 td{
		padding-bottom: 12px;
	}
	.addeditpagebox .griddiv .gridlable {
	    color: #8a8a8a;
	    width: 100%;
	    display: inline-block;
	    padding-bottom: 0px;
	    font-size: 11px;text-transform: uppercase;
	}
    .addeditpagebox .griddiv{
        margin-bottom: 0px !important;
    }

	 .addtopaboxlist {
	    border: 2px rgba(186, 228, 193, 0.75) solid;
	    padding: 10px;
	    margin-bottom: 30px;
	    box-sizing: border-box;
	    background: #f2fff7;
	}

</style>
<div class="topaboxlist"  style="background-color: #ffffff; border-radius: 3px; padding: 3px; box-shadow: 0px 10px 35px;"> 
<table width="100%" border="0" cellspacing="0" cellpadding="8">
  <tr>

    <td width="100%" align="left"><strong style="font-size: 18px;"><?php if($_REQUEST['clientType']!=2){ echo "Add Agent "; }else{ echo "Add B2C"; } ?> </strong></td>
    <td width="12%" align="right" valign="top"><i class="fa fa-times" style="cursor:pointer; font-size: 20px; color: #c51d1d;" onclick="parent.$('#addAgentfromquery').hide();"></i></td>
  </tr> 
</table>

<div class="addeditpagebox addtopaboxlist">
<?php if($_REQUEST['clientType']!=2){ ?> 	
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addagentqery" target="actoinfrm"  id="addagentqery"> 
<input type="hidden" name="addTo" id="addTo" value="<?php echo $_REQUEST['addTo'] ?>">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable" style="margin-bottom: 10px;"> 
  		<tbody> 
	  	<tr >
			<td width="20%"  align="left" style="padding-right: 10px;">
			   	<div class="griddiv"><label>
					<div class="gridlable">Company&nbsp;Type<span class="redmind"></span></div>
					<select id="copmanyType" name="copmanyType" class="gridfield validate" displayname="Company Type" autocomplete="off"  > 
                    <option value="0">None</option>
                    <?php 
                    $select=''; 
                    $where=''; 
                    $rs='';  
                    $select='*';    
                    $where=' deletestatus=0 and status=1 order by id asc';  
                    $rs=GetPageRecord($select,_COMPANY_TYPE_MASTER_,$where); 
                    while($resListing=mysqli_fetch_array($rs)){  

                    ?>
                    <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcompanyTypeId){ ?> selected="selected" <?php } ?>><?php echo strip($resListing['name']); ?></option>
                    <?php } ?>
					</select>

					</label>
				</div>
			</td>    
		  	<td width="35%" align="left">
				<div class="griddiv"><label>
				<div class="gridlable">Company Name<span class="redmind"></span></div>
                    <input type="text" id="companyName" name="companyName" class="gridfield validate"  autocomplete="off" displayname="Company Name">
				</label>
				</div>
			</td>
            
			<td width="20%"  align="left" style="padding-right: 10px;">
			   	<div class="griddiv"><label>
					<div class="gridlable">Sales&nbsp;Person<span class="redmind"></span></div>
					<select id="salesPerson" name="salesPerson" class="gridfield validate" displayname="Sales Person" autocomplete="off"  >  
                    <option value="">Select</option>
                    <?php   
                        $select='*';    
                        $where='status="1" and deletestatus=0 order by firstName asc'; 
                        $restypeSalesq=GetPageRecord($select,_USER_MASTER_,$where); 
                        while($restypeSales=mysqli_fetch_array($restypeSalesq)){  ?>
                    <option value="<?php echo $restypeSales['id']; ?>" <?php if($restypeSales['id']==$editassignTo){ ?>selected="selected"<?php } ?>><?php echo strip($restypeSales['firstName']).' '.strip($restypeSales['lastName']); ?></option>
                    <?php } ?>
                    </select>

					</label>
				</div>
			</td>    
		  	<td width="20%" align="left">
				<div class="griddiv"><label>
				<div class="gridlable">Operation Person</div>
                <select name="operationPerson" id="operationPerson" class="gridfield" displayname="Operation Person">
                    <option value=""> Select</option>
                    <?php  
                    $select='*';    
                    $where='status="1" and deletestatus=0 and ( userType=0 or userType=1 or userType=2 ) order by firstName asc'; 
                    $rs=GetPageRecord($select,_USER_MASTER_,$where); 
                    while($restype=mysqli_fetch_array($rs)){  
                    ?>
                <option value="<?php echo strip($restype['id']); ?>" <?php if($restype['id']==$editOpsAassignTo){ ?>selected="selected"<?php } ?>><?php echo strip($restype['firstName']).' '.strip($restype['lastName']); ?></option>
                <?php } ?>
                </select>
				</label>
				</div>
			</td>
            </tr>

           <tr>
			   <!-- <td width="100%" colspan="2"> -->
			  
			<table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 10px;">
            
            <!-- <div class="gridlable"><strong>Contact Details</strong><span class="redmind"></span></div> -->

			<div style="text-align: left;width: 100%;margin: 26px 0px 6px">
				<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;font-size: 18px;color: grey;">Contact Details</span> 
			</div>

			<tr>
				<td width="" align="left" style="padding: 0px 3px 0px 0px;width: 15%;">
                <div class="griddiv"><span>DIVISION</span><label>
				<select id="division" name="division" class="gridfield validate" displayname="Division" autocomplete="off"  placeholder="Division" >
				<option value="">Select</option>
					 <?php  
					$selectd='*';    
					$whered=' deletestatus=0 and status=1 order by name asc';  
					$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
					$sale=1;
					while($resListingd=mysqli_fetch_array($rsd)){  
					?>
					<option value="<?php echo strip($resListingd['id']); ?>" <?php if($resListingd['id'] == '1' ){ ?> selected <?php }; ?>><?php echo strip($resListingd['name']); ?></option>
					<?php } ?>
				</select>
                </label></div>
				</td>
		    <td width="" align="left" style="padding: 15px 3px 0px 0px; width: 16%;"><div class="griddiv"><label><input name="contactPerson" type="text" class="gridfield validate" id="contactPerson" value="" displayname="Contact Person"  maxlength="100" placeholder="Contact Person" /></label></div></td> 
		    <td width="288" align="left" style="padding: 15px 3px 0px 0px;"><div class="griddiv"><label><input name="designation" type="text" class="gridfield" id="designation" value="" displayname="Designation" placeholder="Designation" /></label></div></td> 
		    <td width="100" align="center" style="padding: 15px 3px 0px 0px;width: 7%;"><div class="griddiv"><label>
			<?php 
			$rsn="";
			$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
			$cmpcountryData=mysqli_fetch_array($rs1cmp);
			$compcountryCode = $cmpcountryData['compcountryCode'];
			?>

			<input name="countryCode" type="text" class="gridfield validate" id="countryCode" value="<?php echo '+'. $compcountryCode; ?>" displayname="Country Code" placeholder="+91" />
		
		
		</label></div></td> 
		    <td width="20%" align="center" style="padding: 15px 3px 0px 0px;"><div class="griddiv"><label><input name="phone" type="text" class="gridfield validate" id="phone" value="" displayname="Phone" maxlength="10"  placeholder="Phone" /></label></div></td> 
		    <td width="380" align="center" style="padding: 15px 3px 0px 0px;"><div class="griddiv"><label><input name="email" type="text" class="gridfield validate" id="email" value="" displayname="Email"  placeholder="Email" /></label></div></td> 

		  </tr>
            
         
		</table> 
		
		<!-- </td> -->
		   </tr>

		
		   <!--started add address new sec  -->
		   <tr>
			<table>
				<div style="text-align: left;width: 100%;margin: 26px 0px 6px">
					<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;font-size: 18px;color: grey;">Address Information</span> 
				</div>

				<tr>
				<td width="20%" align="left" style="padding: 0px 3px 0px 0px;">
					<div class="griddiv">
					<label>
					<div class="gridlable">Country<span class=""></span></div>
					<select id="countryId2" name="countryId2" class="gridfield " displayname="Country" autocomplete="off" onchange="selectstate();" >
					<option value="">Select</option>
					<?php
					$select='';
					$where='';
					$rs='';
					$select='*';
					$where=' deletestatus=0 and status=1 order by name asc';
					$rs=GetPageRecord($select,_COUNTRY_MASTER_,$where);
					while($resListing=mysqli_fetch_array($rs)){
					?>
					<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcountryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
					<?php } ?>
					</select></label>
					</div>
				</td> 
				<td width="20%" align="left" style="padding: 0px 3px 0px 0px;">
					<div class="griddiv">
						<label>
						<div class="gridlable">State </div>
						<select id="stateId2" name="stateId2" class="gridfield" displayname="State" autocomplete="off" onchange="selectcity();" >
						</select></label>
					</div>
				</td>

				<td width="20%" align="left" style="padding: 0px 3px 0px 0px;">
					<div class="griddiv">
						<label>
						<div class="gridlable">City  </div>
						<select id="cityId2" name="cityId2" class="gridfield" displayname="City" autocomplete="off" >
						<?php if($_GET['id']!=''){ ?> 
						<option value="0">Select City</option>  
						<?php   
						$whereKKKK=' deletestatus=0 and status=1 and stateId="'.$editstateId.'" order by name asc';  
						$resListingCityq=GetPageRecord('id,name','cityMaster',$whereKKKK); 
						while($resListingCity=mysqli_fetch_array($resListingCityq)){  
						?>
						<option value="<?php echo strip($resListingCity['id']); ?>" <?php if($resListingCity['id']==$editcityId){ ?>selected="selected"<?php } ?>><?php echo strip($resListingCity['name']); ?></option>
						<?php } ?> 
						<?php } ?>
						</select></label>
					</div>
				</td>
				<td width="20%" align="left" style="padding: 0px 3px 0px 0px;">
					<div class="griddiv"><label>
						<div class="gridlable">Pin/ZIP </div>
						<input name="pinCode" type="text" class="gridfield" id="pinCode" value="<?php echo $editpinCode; ?>" maxlength="15" />
						</label>
					</div>
				</td>


				</tr>
				<tr >
					<table>
						<tr>
						<td width="100%" align="left" style="padding: 0px 3px 0px 0px;width: 650px;">
						<div class="griddiv"><label>
							<div class="gridlable">Address</div>
							<input name="address1" type="text" class="gridfield" id="address1" value="<?php echo $editaddress1; ?>" maxlength="250" />
							</label>
						</div>
					</td>
						</tr>
					</table>
				</tr>
			</table>
		   </tr>
		   <!--Ended add address new sec  -->
		<script> 
			function selectstate(){
			var countryId = $('#countryId2').val();
			$('#stateId2').load('loadstate.php?action=loadCorporateState&id='+countryId+'&selectedId=<?php echo $editstateId; ?>');
			}
			function selectcity(){
			var stateId = $('#stateId2').val();
			$('#cityId2').load('loadcity.php?id='+stateId+'&selectId=<?php echo $editcityId; ?>');
			}
			
			<?php
			if($_GET['id']!=''){
			?>
			selectstate(); 
			<?php } ?>
		</script>


            <tr >

			<table>
			<!-- <div class="gridlable" style="margin: 26px 0px 6px"><strong>Add Infromation</strong><span class=""></span></div> -->

			<div style="display: flex;width: 100%;margin: 26px 0px 6px">
				<div style="text-align: left;width: 30%;">
					
					<span style="font-size: 14px;font-weight: 500;position: relative;top: -3px;left: 10px;font-size: 18px;color: grey;">More Infromation</span> 
				</div>
				<div style="text-align: left; width: 70%;">
					<span>
						<img class="moreInfoSecDown errow-drop" style="margin-top: -2px;
" src="images/down-arrow-30.png"  onclick="moreInfoSec()">
						<img class="moreInfoSecUp errow-drop" style="margin-top: -2px;display:none" src="images/collapse-arrow.png"  onclick="moreInfoSec()">
					</span>
				</div>

				</div>	
			



			<tr style="display:none;" id="moreInfo_Hide">


			<td width="25%"  align="left" style="padding-right: 5px;">
				<div class="griddiv"><label>
					<div class="gridlable">Market&nbsp;Type<span class="redmind"></span> </div>
					<?php 
				$marketMaster = GetPageRecord('*','marketMaster', 'deletestatus=0'); 
				if($invmData['name']>0){
				$marketId = $invmData['name'];
				}else{
				$setDefault=1;
				}
				?>
			<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
				<?php while($markettype = mysqli_fetch_array($marketMaster)){ ?>
				<option value="<?php echo strip($markettype['id']); ?>" 
					<?php if($markettype['setDefault']==$setDefault){ ?> selected="selected" 
					<?php }elseif($marketId==$markettype['id']){ echo 'selected="selected"'; }?> >
					<?php echo strip($markettype['name']); ?>
				</option>
				<?php } ?>
			</select>

					</label>
				</div>
			</td> 


		  	<td width="25%" align="left">
				<div class="griddiv"><label>
				<div class="gridlable">Nationality<span class="redmind"></span></div>
                <select name="nationality" id="nationality" class="gridfield validate" displayname="Nationality">
                <option value=""> Select</option>
                <?php   


				
				$rs1Nat=GetPageRecord('*','companySettingsMaster','id=1');
				$editresultNat=mysqli_fetch_array($rs1Nat);


                $rs=GetPageRecord($select,'nationalityMaster',' deletestatus=0 order by name asc');  
                while($resListing=mysqli_fetch_array($rs)){   
                ?> 
                <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editresultNat['nationality']){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
                <?php } ?>
                </select>
				</label>
				</div>
			</td>
            
			<td width="25%"  align="left" style="padding-right: 10px;">
			   	<div class="griddiv"><label>
					<div class="gridlable">Category
						<!-- <span class="redmind"></span>  -->
					</div>
					<select id="categoryid" name="categoryid" class="gridfield " displayname="Category" autocomplete="off"  >
                        <option value="">Select</option>  
                    <option value="1"  >Big</option>
	                 <option value="2" selected>Medium</option>
	                <option value="3" >Small</option>
					</select>

					</label>
				</div>
			</td>    
		  	<td width="25%" align="left">
				<div class="griddiv"><label>
				<div class="gridlable">Tour Type
					<!-- <span class="redmind"></span> -->
				</div>
                <select name="tourType" id="tourType" class="gridfield " displayname="Tour Type">
                <option value=""> Select</option>
                <?php   
                $rs=GetPageRecord($select,'tourTypeMaster',' deletestatus=0 order by name asc');  
                while($resListing=mysqli_fetch_array($rs)){   
                ?> 
                <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$tourType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
                <?php } ?>
                </select>
				</label>
				</div>
			</td>

			</tr>
</table>
            </tr>
            

		<tr>
			
		<table style="position: relative;left: 68%;"><tr>
			<td colspan="2" align="right" valign="middle">
                <input type="button" value="Close" name="Submit" class="greybutton" onclick="closewindow();">
                <input type="button" name="Submit" value="Save" class="bluembutton bluembutton2"  onclick="formValidation('addagentqery','saveflight','0');"> 
			  <input name="action" type="hidden" id="action" value="addagentfromQuery">
			  <input name="businessType" type="hidden" id="businessType" value="<?php echo $_REQUEST['clientType']; ?>">

            </td>
			</tr>
			</table>
			</tr> 
		</tbody>
	</table>

</form>
<?php }elseif($_REQUEST['clientType']==2){ ?> 
	<!-- Add B2C -->

	<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addclienttoquery" target="actoinfrm"  id="addclienttoquery"> 
	<input type="hidden" name="addTo" id="addTo" value="<?php echo $_REQUEST['addTo'] ?>">
	<h2 style="padding-bottom: 15px;">Personal Information</h2>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable22" > 
	  <tbody> 

	  <tr >	   
			<td width="20%" align="left">
				<div class="griddiv"><label>


				
			<?php
			$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
			$editresultcmp=mysqli_fetch_array($rs1cmp);
			$nationalitycmp=clean($editresultcmp['id']);
			$nationalityId=clean($editresultcmp['nationality']);
			
			?>
				<div class="gridlable">Nationality<span class=""></span></div>
				<select name="nationality" id="nationality" class="gridfield" displayname="Nationality">
				<option value=""> Select</option>
				<?php   
				$rs=GetPageRecord('*','nationalityMaster',' deletestatus=0 order by name asc');  
				while($resListing=mysqli_fetch_array($rs)){   
				?> 
				<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id'] == $nationalityId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select>
				</label>
				</div>
			</td>

			<td width="20%">
		<div class="griddiv"><label>
				<div class="gridlable">Title&nbsp;<span class="redmind"></span></div>
				<select id="contacttitleId" name="contacttitleId" class="gridfield validate" displayname="Title" autocomplete="off" >
				<option value="">None</option>
				<?php 

				$select=''; 

				$where=''; 

				$rs='';  

				$select='*';    

				$where=' deletestatus=0 and status=1 order by id asc';  

				$rs=GetPageRecord($select,_NAME_TITLE_MASTER_,$where); 

				while($resListing=mysqli_fetch_array($rs)){  
				?>

				<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editcontacttitleId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>

				<?php } ?>
				</select></label>

				</div></td>
				<td width="20%"><div class="griddiv"><label>

				<div class="gridlable">First Name<span class="redmind"></span>  </div>

				<input name="firstName" type="text" class="gridfield validate" id="firstName" value="<?php echo $editfirstName; ?>" displayname="First Name" maxlength="100" />

				</label>

				</div></td>

				<td width="20%"><div class="griddiv"><label>

				<div class="gridlable">Middle Name</div>

				<input name="middleName" type="text" class="gridfield" id="middleName" displayname="Middle Name" maxlength="100" />

				</label>

				</div>
				</td>

				<td width="20%"><div class="griddiv"><label>

				<div class="gridlable">Last Name<span class=""></span>   </div>

				<input name="lastName" type="text" class="gridfield " id="lastName" value="<?php echo $editlastName; ?>" displayname="Last Name" maxlength="100" />

				</label>

				</div>
				</td>

			<td width="25%"  align="left" style="padding-right: 5px;display: none;">
				<div class="griddiv"><label>
					<div class="gridlable">Market&nbsp;Type<span class="redmind"></span> </div>
					<select id="marketType" name="marketType" class="gridfield validate" displayname="Market Type" autocomplete="off"  >  
						<?php 
						
						$rs=GetPageRecord('*','marketMaster',' deletestatus=0 and status=1 order by name asc');  
						while($resListing=mysqli_fetch_array($rs)){   
						?> 
						<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$editmarketType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option> 
						<?php } ?>
					</select>

					</label>
				</div>
			</td> 

			  
	</tr>
	<tr>
		
		</tr>

		<tr>
		<td>
		<div class="griddiv">

			<label>

			<div class="gridlable">Gender<span class="redmind"></span></div>
			</label>
					<select name="gender" id="gender" class="gridfield validate"  autocomplete="off">
					<option value="">Select</option>
					<option value="Male">Male</option>
					<option value="Female">Female</option>
					<option value="Other">Other</option>
					</select>
			</div></td>
			<td>
		<div class="griddiv">

			<label>

			<div class="gridlable">Date of Birth</div>

			<input name="birthDate" type="text" id="birthDate" class="gridfield calfieldicon"  autocomplete="off" value="<?php echo date("d-m-Y", strtotime('now'));?>" /></label>

			</div></td>

			<td width="25%"  align="left" style="padding-right: 5px;">
				<div class="griddiv"><label>
					<div class="gridlable">Market&nbsp;Type<span class="redmind"></span> </div>
					<?php 
				$marketMaster = GetPageRecord('*','marketMaster', 'deletestatus=0'); 
				if($invmData['name']>0){
				$marketId = $invmData['name'];
				}else{
				$setDefault=1;
				}
				?>
			<select id="marketType" name="marketType" class="gridfield" displayname="Market Type" autocomplete="off" >  
				<?php while($markettype = mysqli_fetch_array($marketMaster)){ ?>
				<option value="<?php echo strip($markettype['id']); ?>" 
					<?php if($markettype['setDefault']==$setDefault){ ?> selected="selected" 
					<?php }elseif($marketId==$markettype['id']){ echo 'selected="selected"'; }?> >
					<?php echo strip($markettype['name']); ?>
				</option>
				<?php } ?>
			</select>

					</label>
				</div>
			</td> 

			<td width="25%"  align="left" style="padding-right: 5px;">
			   <div class="griddiv"><label>
				<div class="gridlable">Sales&nbsp;Person</div>
				<select id="salesPerson" name="salesPerson" class="gridfield " displayname="Sales Person" autocomplete="off"  >  
				<option value="">Select</option>
				<?php   
					$select='*';    
					$where='status="1" and deletestatus=0 order by firstName asc'; 
					$restypeSalesq=GetPageRecord($select,_USER_MASTER_,$where); 
					while($restypeSales=mysqli_fetch_array($restypeSalesq)){  ?>
				<option value="<?php echo $restypeSales['id']; ?>" <?php if($restypeSales['id']==$editassignTo){ ?>selected="selected"<?php } ?>><?php echo strip($restypeSales['firstName']).' '.strip($restypeSales['lastName']); ?></option>
				<?php } ?>
				</select>

				</label>
			</div>
		</td>
		</tr>
		<table width="" border="0" cellpadding="0" cellspacing="0">
									<tr>
									<h2>Contact Information</h2>
									<div class="gridlable" style="width: 12% !important; display:inline-block;    padding: 4px 20px 4px 0px;">Contact No.<span class="redmind"></span></div>

									<label>
									<div class="gridlable" style="width: 38% !important; display:inline-block;    padding: 4px 0px 4px 0px;">Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Number<span class=""></span></div></label>

									<label>
									<div class="gridlable" style="width: 45% !important; display:inline-block;    padding: 4px 0px 4px 0px;">Email<span class=""></span></div></label>
								
										<td width="15%" align="left" >
										<div class="griddiv"><label>
											<select id="PhoneTypeId" name="PhoneTypeId" class="gridfield " displayname="Mobile" autocomplete="off" style="padding: 9px; height: 37px;">

										<?php
										$select = '*';
										$where = ' status=1 order by id asc';
										$rs = GetPageRecord($select, _PHONE_TYPE_MASTER_, $where);
										while ($restype = mysqli_fetch_array($rs)) { ?>
										<option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $reslisting['phonetype']) { ?> selected="selected" <?php } ?> ><?php echo strip($restype['name']); ?></option>
												<?php } ?>
											</select>
										</label></div>
										</td>

												
										<td width="" align="left" style="padding-right: 0px;">
													<div class="griddiv "><label>
													<?php 
												$rsn="";
												$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
												$cmpcountryData=mysqli_fetch_array($rs1cmp);
												$compcountryCode = $cmpcountryData['compcountryCode'];
												?>
													<input style="border-bottom: 2px solid red;width: 50px;" name="countryCode" type="text" class="gridfield validate" displayname="Country Code" id="countryCode" maxlength="5" value="<?php echo '+'. $compcountryCode; ?>" placeholder="+91"/>


													</label></div>
												</td>
													<td width="" align="left" style="padding-right: 10px;">
													<div class="griddiv "><label>
													<input style="border-bottom: 2px solid red;" name="PhoneNo" type="text" class="gridfield validate" displayname="Mobile" id="PhoneNo" maxlength="11" placeholder="Enter Mobile"/>
													</label></div>
												</td>
												
													<td width="15%" align="left" style=""><div class="griddiv"><label>
														<select id="EmailTypeId" name="EmailTypeId" class="gridfield " autocomplete="off" style="padding: 9px; height: 37px;">

															<?php
															$select = '*';
															$where = ' status=1 order by id asc';
															$rs = GetPageRecord($select, _EMAIL_TYPE_MASTER_, $where);
															while ($restype = mysqli_fetch_array($rs)) {
															?>
																<option value="<?php echo strip($restype['id']); ?>" <?php if ($restype['id'] == $reslisting['emailtype']) { ?>selected="selected" <?php } ?>><?php echo strip($restype['name']); ?></option>
															<?php } ?>
														</select>
													</label></div>
													<!-- <hr> -->
													</td>
														
													<td width="" align="left">
													<div class="griddiv"><label>
													<input name="Email" type="email" class="gridfield " displayname="Email" id="Email" maxlength="100" />
													</label></div>
												</td>
													
												</tr>
											</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gridtable2222">
							<tr>
								<h2 class="childinformation">Address Information</h2>
							</tr>
							<tr>
								<td width="20%" style="padding-right:10px;">

								<?php
										$rs1cmp=GetPageRecord('*','companySettingsMaster','id=1');
										$editresultcmp=mysqli_fetch_array($rs1cmp);
										$nationalitycmp=clean($editresultcmp['id']);
										$countryId=clean($editresultcmp['countryId']);
										
										?>
										
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">Country</div>
											<select name="country" id="country" class="gridfield" displayname="Country" onchange="getStateAllStates(this.value);">
				<option value=""> Select</option>
				<?php   
				$rs=GetPageRecord('*','countryMaster',' deletestatus=0 order by name asc');  
				while($resListing=mysqli_fetch_array($rs)){   
				?> 
				<option value="<?php echo $resListing['id']; ?>" <?php if($resListing['id'] == $countryId){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']); ?></option>
				<?php } ?>
				</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>

											<div class="gridlable">State</div>
											<select id="loadstates" name="loadstates" class="gridfield " displayname="State" autocomplete="off" onchange="getStateAllCities(this.value);">
												<option value="">Select</option>
												<?php

												$rstate = "";

												$rstate = GetPageRecord('*', _STATE_MASTER_, ' id="' . $editstateId . '" order by name asc');

												while ($stateData = mysqli_fetch_array($rstate)) {

												?>
													<option value="<?php echo strip($stateData['id']); ?>" selected="selected"><?php echo strip($stateData['name']); ?></option>

												<?php } ?>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">City</div>
											<select id="loadcities" name="loadcities" class="gridfield " displayname="City" autocomplete="off">
												<option value="">Select</option>
												<?php
												$rstatess = "";

												$rstatess = GetPageRecord('*', _STATE_MASTER_, ' id="' . $editcityId . '" order by name asc');

												while ($statesData = mysqli_fetch_array($rstatess)) {

												?>
													<option value="<?php echo strip($statesData['id']); ?>"><?php echo strip($statesData['name']); ?></option>

												<?php } ?>
											</select>
										</label>
									</div>
								</td>

								<td width="20%" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">Pin/Zip</div>
											<input type="number" name="pinzip" id="pinzip" class="gridfield" value="<?php echo $editresult['pinzip']; ?>">
										</label>
									</div>
								</td>

							</tr>
							<tr>
								<td colspan="4" style="padding-right:10px;">
									<div class="griddiv" style="display:noned;"><label>
											<div class="gridlable">Address</div>
											<textarea name="addressInfo" id="addressInfo" rows="" style="width:98%; padding:5px; margin-top:3px;"><?php echo $editresult['addressInfo']; ?></textarea>
										</label>
									</div>
								</td>
							</tr>
						</table>
						<script>
							function defaultsateload(){
								var countryId = $('#country').val();
								if(countryId!=''){
									$('#loadstates').load('loadstatcity.php?action=loadallstates&countryId=' + countryId + '&selectIdst=<?php echo $editstateId; ?>');
								}
							}

							defaultsateload();
							function defualtcities(){
								var stateId = $('#loadstates').val();
								if(stateId!=''){
									$('#loadcities').load('loadstatcity.php?action=loadallCities&stateId=' + stateId + '&selectIdct=<?php echo $editcityId; ?>');
								}
							}
							defualtcities();

							function getStateAllStates(countaryId) {
								var countryId = $('#country').val();

								$('#loadstates').load('loadstatcity.php?action=loadallstates&countryId=' + countryId + '&selectIdst=<?php echo $editstateId; ?>');
							}



							function getStateAllCities(stateId) {
								var stateId = $('#loadstates').val();
								$('#loadcities').load('loadstatcity.php?action=loadallCities&stateId=' + stateId + '&selectIdct=<?php echo $editcityId; ?>');
							}

							<?php
							if ($_GET['id'] != '') {
							?>
								getStateAllStates();
								getStateAllCities();
							<?php } ?>
						</script>

								
		<table width="100%">
		<tr>
		<td width="100%" align="right" valign="middle">
			<input type="button" value="Close" name="Submit" class="greybutton" onclick="closewindow();">
			<input type="button" name="Submit" value="Save" class="bluembutton bluembutton2"  onclick="formValidation('addclienttoquery','saveflight','0');"> 
		  <input name="action" type="hidden" id="action" value="addClientfromQuery">
		  <input name="businessType" type="hidden" id="businessType" value="<?php echo $_REQUEST['clientType']; ?>">

		</td>
		</tr> 
		</table>
		</div>

	</tbody>
</table>

</form>

	
	
	<?php } ?>
</div>
</div>

<script>
    function closewindow(){
        $("#addAgentfromquery").hide();

    }
	$(function() {
	$("#birthDate").Zebra_DatePicker({
	format: 'd-m-Y', 
	});
	});
									

</script>

<script>
function moreInfoSec() {

var x = document.getElementById("moreInfo_Hide");
var upimg = document.getElementsByClassName("moreInfoSecUp");
var downimg = document.getElementsByClassName("moreInfoSecDown");
if (x.style.display === "none") {
	x.style.display = "block";
	$('.moreInfoSecUp').show();
	$('.moreInfoSecDown').hide();
} else {
	x.style.display = "none";
	$('.moreInfoSecDown').hide();
	// $('.QuerySecUp').hide();
}
}
</script>

<?php } ?>

<style>
    
element.style {
}
.greybutton {
    background-color: #efefef;
    padding: 8px 26px !important;
    margin-left: 10px;
    margin-top:10px;
    outline: 0px;
    color: #000000!important;
    font-size: 14px;
    border: 1px #787877 solid;
    border-radius: 27px;
    cursor: pointer;
}
.bluembutton2{
    padding: 8px 26px !important;

}
</style>