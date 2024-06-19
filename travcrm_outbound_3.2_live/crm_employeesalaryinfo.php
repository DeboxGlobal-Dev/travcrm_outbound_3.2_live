<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}
?>

<?php 
/*
if($_GET['id']!=''){
$id=clean(decode($_GET['id']));
$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_EMPLOYEE_MANAGEMENT_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$lastId = clean($editresult['id']);
$editctcAnnual=clean($editresult['ctcAnnual']);

}*/
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div class="headingm" style="margin-left:20px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>
	Update<?php } else { ?>Add Employee Salary<?php } ?> </span></div>
	</td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> </td>
        <!--<td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" 
		onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" 
		<?php if($_GET['id']!=''){ ?>onclick="view('<?php echo $_GET['id']; ?>');"<?php } else { ?>onclick="cancel();"<?php } ?>  /></td>-->
      </tr>
      
    </table>
	</td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">

<!--<div style="border-bottom:2px #ffc115 solid; height:43px;">
<?php if($_GET['lastId']!='') { ?>

<a href="showpage.crm?module=employeemanagement&page=add&id=<?php echo encode($_GET['lastId']); ?>" style="padding:10px 20px; float:left;  font-size:15px; background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115; background-color:#fff; color:#000; margin-left:5px;  border:1px solid #fff;"><strong>Employee Details</strong></a>


<a href="showpage.crm?module=employeesalaryinfo&lastId=<?php echo $_GET['lastId']?>" style="padding:10px 20px; float:left;  font-size:15px; background-color:#ffc115; color:#FFFFFF !important; border:1px solid #ffc115; background-color:#fff; color:#000; margin-left:5px;  border:1px solid #fff;"><strong>Salary Info</strong></a>
	<?php }?>
</div>-->
<?php if(encode($_GET['lastId']!='')) { ?>
<div class="tab">
  <a class="tablinks" href="showpage.crm?module=employeemanagement&page=add&id=<?php echo $_GET['lastId']; ?>"><button>Employee Basic Information</button></a>
 <a class="tablinks" href="showpage.crm?module=employeesalaryinfo&lastId=<?php echo $_GET['lastId'];?>"><button>Salary Info</button></a>
</div>
<?php }?>



<form action="crm_employeesalaryinfo.php" method="get" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
<div class="addeditpagebox">
<input name="action" type="hidden" id="action" value="addemployeesalary" />
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
<div id="response"></div>
<script>
function calculateFunc(){
	$('#response').load('crm_calculatesalary.php?ctcAnnual=<?php echo $_REQUEST['ctcAnnual'];?>&lastId=<?php echo decode($_GET['lastId']); ?>');
}

function addCalculation(){
	var ctcAnnual = $('#ctcAnnual').val();
	var totalCount = Number($('#totalCount').val()); 
	var lastId = '<?php echo decode($_GET['lastId']); ?>';
	if(ctcAnnual!=''){
		$('#response').load('crm_calculatesalary.php?ctcAnnual='+ctcAnnual+'&lastId='+lastId+'&totalCount='+totalCount+'');
	}
}
</script>
	
	<td width="33%" align="left" valign="top" style="padding-right:20px;">

	
	</td>
	<td width="33%" align="left" valign="top" style="padding-right:20px;">

	
	</td>
		 
  </tr>
</table>
</div>
<div id="" style="padding-left:30px;">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>
   <tr>
      <th width="93" align="center" valign="middle" class="header" style="display:none;" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
    <label for="checkAll"><span></span>&nbsp;</label></th> 
     <th width="271" align="left" class="header">Component</th>
     <th width="271" align="left" class="header">Calculation Type</th>
     <!--<th width="423" align="left" class="header">Formula</th>-->
     <th width="361" align="left" class="header">Monthly</th>
     <th width="156" align="center" class="header">Annual</th>
   </tr>
   </thead>
   <?php
   $no=0;
$select='*';
$where='1 order by id asc';
$rs=GetPageRecord($select,_SALARY_COMPONENT_,$where);
while($resultlists=mysqli_fetch_array($rs)){ 
?>
		<tr>
			<td><?php echo $resultlists['name']; ?></td>
			<td align="left">

	<?php

	$select1='*';  

$where1='id='.$resultlists['calculationType'].''; 

$rs1=GetPageRecord($select1,_SALARY_CALCULATION_MASTER_,$where1); 

$editresult=mysqli_fetch_array($rs1);

echo $editresult['name'];

?>	</td>
			
			<!--<td><?php echo $resultlists['valueFormula']; ?></td>-->
			<td><input type="text" name="salary" id="a<?php echo $no; ?>" value="" readonly></td>
			<td><input type="text" name="salaryAnnual" id="b<?php echo $no; ?>" value="" readonly></td>
			
			
		</tr>
<?php $no++; } ?>
<input type="hidden" name="totalCount" id="totalCount" value="<?php echo $no; ?>">
	<tbody>
	</tbody>
</table>
</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>
		<!--<input name="editId" type="hidden" id="editId" value="<?php echo encode($lastId); ?>" />-->
			<input name="editId" type="hidden" id="editId" value="<?php echo $id; ?>" />
		<?php
		if($_GET['id']!=''){
		?>
		<input name="editedityes" type="hidden" id="editedityes" value="1" />
		<?php } ?>
		</td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
        <td style="padding-right:20px;"><input type="button" name="Submit2" value="Cancel" class="whitembutton" onclick="cancel();" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>

</div>
<script>  
calculateFunc();
comtabopenclose('linkbox','op2');
</script>
<style>

body {font-family: Arial;}

 

/* Style the tab */

.tab {

  overflow: hidden;

  border: 1px solid #ccc;

  background-color: #f1f1f1;

}

 

/* Style the buttons inside the tab */

.tab button {

  background-color: inherit;

  float: left;

  border: none;

  outline: none;

  cursor: pointer;

  padding: 14px 16px;

  transition: 0.3s;

  font-size: 17px;

}

 

/* Change background color of buttons on hover */

.tab button:hover {

  background-color: #ddd;

}

 

/* Create an active/current tablink class */

.tab button.active {

  background-color: #ccc;

}

 .tab{
	 margin-top:-14px;
 }

/* Style the tab content */

.tabcontent {

  display: none;

  padding: 6px 12px;

  border: 1px solid #ccc;

  border-top: none;

}

</style>

