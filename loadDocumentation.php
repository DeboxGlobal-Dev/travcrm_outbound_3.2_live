<?php
	include "inc.php";
	include "config/logincheck.php";
	$id = $_REQUEST['id'];
	?>
 <div id="documentDiv<?php echo $id; ?>">
 	<table width="90%">
 		<tr>
 			<td width="10%" class="tdwidth">
 				<div class="griddiv"><label>
 						<div class="gridlable">Document&nbsp;Type <span class="redmind"></span> </div>
 						<select id="documentType<?php echo $id; ?>" name="documentType<?php echo $id; ?>" class="gridfield validate" displayname="Document Type" autocomplete="off">
 							<option value="">Select</option>
 							<option value="1">Adhar Card</option>
 							<option value="2">Passport</option>
 							<option value="3">VISA</option>
 							<option value="4">Other</option>
 						</select>
 					</label>
 				</div>
 			</td>
 			<td style="width: 9%;">
 				<div class="griddiv"><label>
 						<div class="gridlable">Required <span class="redmind"></span> </div>
 						<select name="documentRequired<?php echo $id; ?>" id="documentRequired<?php echo $id; ?>" class="gridfield validate">
 							<option value="Yes">Yes</option>
 							<option value="No">No</option>
 						</select>
 					</label>
 				</div>
 			</td>
 			<td width="14%" class="tdwidth">
 				<div class="griddiv"><label>
 						<div class="gridlable">Document&nbsp;No. <span class="redmind"></span> </div>
 						<input type="text" id="documentNumber<?php echo $id; ?>" name="documentNumber<?php echo $id; ?>" class="gridfield validate" displayname="Document Number" autocomplete="off">
 					</label>
 				</div>
 			</td>

 			<td width="12%" class="tdwidth">
 				<div class="griddiv"><label>
 						<div class="gridlable">Issue&nbsp;Date <span class="redmind"></span> </div>
 						<input type="text" id="issueDate<?php echo $id; ?>" name="issueDate<?php echo $id; ?>" class="gridfield calfieldicon validate" displayname="Issue Date" autocomplete="off" value="<?php if ($editbirthDate != '') {
																																																				echo date("d-m-Y", strtotime($editbirthDate));
																																																			} ?> ">
 					</label>
 				</div>
 			</td>

 			<td width="12%" class="tdwidth">
 				<div class="griddiv"><label>
 						<div class="gridlable">Expiry&nbsp;Date <span class="redmind"></span> </div>
 						<input type="text" id="expiryDate<?php echo $id; ?>" name="expiryDate<?php echo $id; ?>" class="gridfield calfieldicon validate" displayname="Expiry Date" autocomplete="off" value="<?php if ($editbirthDate != '') {
																																																					echo date("d-m-Y", strtotime($editbirthDate));
																																																				} ?>">
 					</label>
 				</div>
 			</td>

 			<td width="13%" class="tdwidth">
 				<div class="griddiv"><label>
 						<div class="gridlable">Issue&nbsp;Country <span class="redmind"></span></div>
 						<select id="issueCountry<?php echo $id; ?>" name="issueCountry<?php echo $id; ?>" class="gridfield validate" displayname="Issue Country" autocomplete="off">
 							<option value="">Select</option>
 							<?php

								$wherissue = ' deletestatus=0 order by name asc';
								$resiss = GetPageRecord('*', 'countryMaster', $wherissue);
								while ($issueListing = mysqli_fetch_array($resiss)) {
								?>
 								<option value="<?php echo strip($issueListing['id']); ?>" <?php if ($issueListing['id']) { ?>selected="selected" <?php } ?>><?php echo strip($issueListing['name']); ?></option>
 							<?php } ?>
 						</select>
 					</label>
 				</div>
 			</td>

 			<td style="width: 12%;">
 				<div class="griddiv"><label>
 						<div class="gridlable">Document&nbsp;Title</div>

						 <select name="documenttitle<?php echo $id; ?>" id="documenttitle<?php echo $id; ?>" class="gridfield">
						 <option value="1">Both</option>
						<option value="2">Front</option>
						<option value="3">Back</option>										
						</select>

 					</label>
 				</div>
 			</td>
 			<td width="20%" class="tdwidth" colspan="3">
 				<div class="griddiv"><label>
 						<div class="gridlable">Upload Document<span class="redmind"></span></div>
 						<input type="file" id="uploadDocument<?php echo $id; ?>" name="uploadDocument<?php echo $id; ?>" class="gridfield" displayname="Upload Document" autocomplete="off">
 					</label>
 				</div>
 			</td>
 			<td align="center"><img src="images/deleteicon.png" width="12" height="16" onclick="removedocumentation(<?php echo $id; ?>);" style="cursor:pointer;" /></td>
 		</tr>
 	</table>
 </div>


 <script>
 	$(function() {
 		$("#expiryDate<?php echo $id; ?>").Zebra_DatePicker({
 			format: 'd-m-Y', //Ensures format consistency
 			// onSelect: function() {
 			// 	//Call your update function here.
 			// 	}

 		});
 	});

 	$(function() {
 		$("#issueDate<?php echo $id; ?>").Zebra_DatePicker({
 			format: 'd-m-Y', //Ensures format consistency
 			// onSelect: function() {
 			// 	//Call your update function here.
 			// 	}

 		});
 	});
 </script>