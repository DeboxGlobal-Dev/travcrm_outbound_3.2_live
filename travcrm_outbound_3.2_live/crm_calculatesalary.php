<?php
include "inc.php"; 
$ctcAnnual = 0;
if($_REQUEST['ctcAnnual']!=''){
$ctcAnnual =  $_REQUEST['ctcAnnual']; 
$lastId1 =  $_REQUEST['lastId'];
}
?>  
 <table>
 <tr> 
    <td width="33%" align="left" valign="top" style="padding-right:20px;">
	<div class="griddiv" style=""><label>
	<div class="gridlable">CTC (Annual)<span class="redmind"></span>  </div>
	<input name="ctcAnnual" type="text" class="gridfield" id="ctcAnnual" value="<?php echo $_REQUEST['ctcAnnual'];?>" 
	displayname="Enter CTC" maxlength="100" autocomplete="off"/>
	</label>
	</div>
	</td>
	
	<td width="33%" align="left" valign="" style="padding-right:20px;">
	<div class="griddiv" style="border-bottom:0px;"><label>
	<div class="gridlable"></div>
	<input name="submit" type="button" class="bluembutton submitbtn" id="" value="Calculate" onClick="addCalculation();"/>
	<label/>
	</div>
	</td>
	
	<td width="33%" align="left" valign="top" style="padding-right:20px;">
	
	</td>
</tr>	
</table>
<script>

<?php

$where12 ='empId="'.$lastId1.'"';
$delete = deleteRecord(_EMPLOYEE_SALARY_,$where12);

$select='*';
$where='1 order by name asc';
$rs=GetPageRecord($select,_SALARY_COMPONENT_,$where);
while($resultlists=mysqli_fetch_array($rs)){ 
$calculationType = clean($resultlists['calculationType']);
$componentId = clean($resultlists['id']);
$valueFormula = clean($resultlists['valueFormula']);

?>
var ctcAnnual = '<?php echo $ctcAnnual; ?>';
var totalCount = '<?php echo $_REQUEST['totalCount']; ?>';
var valueFormula = '<?php echo $valueFormula ?>';
//alert(valueFormula);
for(i=0; i<totalCount; i++){

$('#a'+i).val('<?php echo $ctcAnnual; ?>');

if('#a'+i == '#a'+i){
	
	var ab1 =  Number(ctcAnnual/valueFormula);
	var ab1 = Number(ab1.toFixed(2));
	
	$('#a'+i).val(ab1);
}

}
<?php

if($_REQUEST['ctcAnnual']!=''){
$namevalue ='empId="'.$lastId1.'",componentId="'.$componentId.'",calculationType="'.$calculationType.'",valueFormula="'.$valueFormula.'",ctcAnnual="'.$_REQUEST['ctcAnnual'].'"';
$add = addlisting(_EMPLOYEE_SALARY_,$namevalue);
}
}
?>

</script>

