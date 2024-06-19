<?php
include "inc.php";
include "config/logincheck.php";
$id=$_REQUEST['id'];
?>

<div id="hotelcontactpid<?php echo $id; ?>" style="display: block;width: 100%;">

<div class="griddiv"><label>

		<table width="100%" border="0" cellspacing="2" cellpadding="0">

			<tr>

				<td width="70">
					<div class="griddiv">

						<label>
							<select id="division" name="division<?php echo $id; ?>" class="gridfield" displayname="Division" autocomplete="off" placeholder="Division">
								<?php  
								$selectd='*';    
								$whered=' deletestatus=0 and status=1 order by name asc';  
								$rsd=GetPageRecord($selectd,_DIVISION_MASTER_,$whered); 
								while($resListingd=mysqli_fetch_array($rsd)){  
								?>
								<option value="<?php echo strip($resListingd['id']); ?>"><?php echo strip($resListingd['name']); ?></option>
								<?php } ?>  
							</select>

						</label>

					</div>
				</td>

				<td width="70">
					<div class="griddiv"><label>
							<input name="contactPerson<?php echo $id; ?>" type="text" class="gridfield validate" id="contactPerson" displayname="Contact Person" maxlength="100" placeholder="Contact Person" style="margin-top: 20px;">

						</label>

					</div>
				</td>

				<td width="70">
					<div class="griddiv"><label>
							<input name="designation<?php echo $id; ?>" type="text" class="gridfield validate" id="designation" displayname="Designation" placeholder="Designation" style="margin-top: 20px;">

						</label>

					</div>
				</td>

				<td width="40">
					<div class="griddiv"><label>
							<input name="countryCode<?php echo $id; ?>" type="text" class="gridfield validate" id="countryCode" value="+91" displayname="Country Code" placeholder="+91" style="margin-top: 20px;">

						</label>

					</div>
				</td>

				<td width="80">
					<div class="griddiv"><label>
							<input name="phone<?php echo $id; ?>" type="text" class="gridfield validate" id="phone"  displayname="Phone" placeholder="Phone" style="margin-top: 20px;">

						</label>

					</div>
				</td>

				<td width="120">
					<div class="griddiv"><label>
							<input name="email<?php echo $id; ?>" type="email" class="gridfield validate " id="email" displayname="Email" placeholder="Email" style="margin-top: 20px;" required />

						</label>
					</div>
				<!-- </td>
                <td width="70" align="center">
                <div class="griddiv"><label>
            <input name="primaryvalue" class="gridfield" type="radio" value="<?php echo $id; ?>"  />
        </label>
					</div>
      </td> -->
                <td width="70" align="center">
        <img src="images/deleteicon.png" width="12" height="16" onclick="removecontactperson(<?php echo $id; ?>);" style="cursor:pointer;"/>
      </td>
			</tr>



		</table>
</div> 


