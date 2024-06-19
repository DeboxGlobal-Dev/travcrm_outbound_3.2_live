<?php $statuswise = $_GET['statuswise']; ?>

<?php include 'tableSorting.php'; ?>



<link href="css/main.css" rel="stylesheet" type="text/css" />

 

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top">

	<form id="listform" name="listform" method="get">

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="7%">

       <a name="addnewuserbtn" href="showpage.crm?module=dmcmaster" /><input type="button" name="Submit22" value="Back" class="whitembutton" > </a>    

     </td>

    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>

	<div id="deactivatebtn" style="display:none;">

	 <?php if($deletepermission==1){ ?>  

	 	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Deactivate" onclick="masters_alertspopupopen('action=mastersdelete&name=Restaurant&nbsp;Name','600px','auto');" /> 

	<?php } ?>

	</div>

	

	</div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

	   <td><a href="<?php echo $fullurl; ?>showpage.crm?module=<?php echo clean($_GET['module']); ?>" style="padding: 0 10px;font-size: 12px;">Reset</a></td>

	   <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td>

	   

	   <td>

            <!--<i class="fa fa-angle-down" style="font-size:50px"></i>-->

        <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">



          <option value=""> Select  Status &nbsp;</option>

    

          <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>

    

          <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>

    

        </select>

        </td>

        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>

        <td  ><!--<a href="<?php echo $fullurl; ?>travrmimports/mealPlan-import.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a>--></td>

		<td  ><!--<div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div>--></td>

		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','800px','auto');" /></td>  

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



<div id="pagelisterouter" style="padding-left:30px;">

<input name="action" id="action" type="hidden" value="delete_<?php echo clean($_GET['module']); ?>" />

<input name="table" id="table" type="hidden" value="<?php echo _INBOUND_MEALPLAN_MASTER_;?>" />

<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" id="mainsectiontable" class="table table-striped table-bordered gridtable"> 

	  <thead> 

		<tr >

		    <th align="left" class="header" style="padding-bottom: 11px;">Sr.</th> 

			<th width="4%" align="center" valign="middle" class="header" style="padding-bottom: 11px;">

				<?php if($editpermission==1){ ?> 

				<input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" />

				<?php } ?>

				<label for="checkAll"><span></span>&nbsp;</label>

			</th> 
			<th align="left" class="header sorting" width="12%" style="padding-bottom: 11px;">Restaurant Code</th>
            <th width="2%" align="center" class="header" style="padding-bottom: 11px;">Image</th>
			<th width="10%" align="left" class="header" style="padding-bottom: 11px;">Restaurant&nbsp;Name</th>

			<th width="7%"  align="left" class="header" style="padding-bottom: 11px;">Destination</th>
			<th width="8%"  align="left" class="header" style="padding-bottom: 11px;">Address</th>

			<th width="8%"  align="center" class="header" style="padding-bottom: 11px;">Rate Sheet </th>


			<th width="8%"  align="center" class="header" style="padding-bottom: 11px;">Status</th>

		</tr>

   </thead>

  <tbody>

  <?php 
  


$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

$searchMain='';
$wheresearch2='';
if($_GET['keyword']!=''){

$searchMain ='and ( mealPlanName like "%'.$_GET['keyword'].'%" or mealPlanCity like "%'.$_GET['keyword'].'%" )'; 
}


if($_REQUEST['status']!=''){
	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
}

$where='where mealPlanName!="" '.$searchMain.' '.$wheresearch2.' and deletestatus=0 order by id desc'; 

//$where='where 1 order by id desc'; 
$page=$_GET['page'];
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 



// if($_GET['keyword']!=''){
// $searchMain='mealPlanName like "%'.trim($_GET['keyword']).'%" or mealPlanCity like "%'.trim($_GET['keyword']).'%" ';
// if($_REQUEST['status']!=''){
// 	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
// }
// $where='where  name!=""  '.$searchMain.''.$wheresearch2.' and deletestatus=0 order by name asc'; 
// $page=$_GET['page'];
// $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&'; 



$rs=GetRecordList($select,_INBOUND_MEALPLAN_MASTER_,$where,$limit,$page,$targetpage); 

$totalentry=$rs[1]; 

$paging=$rs[2]; 

while($resultlists=mysqli_fetch_array($rs[0])){
	$restaddres= GetPageRecord('address','addressMaster','addressParent="'.$resultlists['id'].'"');
	$address = mysqli_fetch_array($restaddres);

	$restcotactperson= GetPageRecord('contactPerson, phone','restaurantContactPersonMaster','restaurantId="'.$resultlists['id'].'"');
	$contatctperson = mysqli_fetch_array($restcotactperson);
	?>
	
  	<tr>

  	<td width="2%"><?= $no ?></td>    

  	<td align="center" width="2%" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/> <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>
	
	<td align="left" width="12%"><?php  echo $serviceCode = makeServiceCode('RS',$resultlists['displayId']);  ?></td>

	<td align="left" width="5%"><?php if($resultlists['mealPlanImage']!=''){ ?><img src="packageimages/<?php echo $resultlists['mealPlanImage']; ?>" width="75" height="58" /><?php }else{ echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>"; } ?></td>

    <td align="left" width="20%" valign="middle"><div class="bluelink" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&id=<?php echo $resultlists['id']; ?>','800px','auto');" ><?php echo $resultlists['mealPlanName']; ?></div>   </td>

	 <td align="left" width="20%" valign="middle"><?php echo getDestination($resultlists['destinationId']); ?></td>
	 <td align="left" width="20%" valign="middle"><?php
	  if($address['address']=="" && $contatctperson['contactPerson']==""){
		// echo '<div><strong>Address:</strong> </div>';
	 }else{
		echo '<div><strong>Contact:</strong> '.$contatctperson['contactPerson'].' '.$contatctperson['phone'].'</div>';
		echo '<div><strong>Address:</strong> '.$address['address'].'</div>';
		
		
	 }  ?></td>
	
	<td align="center"><a href="showpage.crm?module=<?php echo $_REQUEST['module'];?>&amp;keyword=<?php echo $_REQUEST['keyword'];?>&amp;view=yes&amp;inboundmealplanNameId=<?php echo encode($resultlists['id']);?>"><input name="addnewuserbtn" type="button" value="+ Add/View" class="bluembutton"></a></td>
			


	<td width="5%" align="center"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content;  color: red; "><?php echo 'In Active';?></div><?php }  ?>

	</td>

	</tr>

	<?php $no++; } ?>

</tbody></table>

<?php if($no==1){ ?>

<div class="norec">No <?php echo $pageName; ?></div>

<?php } ?>

	<div class="pagingdiv"> 

	<table width="100%" border="0" cellpadding="0" cellspacing="0"> 

	  <tbody>

	  <tr> 

		<td><table border="0" cellpadding="0" cellspacing="0">

	  <tr>

		<td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>

		<td><select name="records" id="records" onchange="this.form.submit();" class="lightgrayfield" >

			<option value="25" <?php if($_GET['records']=='25'){ ?> selected="selected"<?php } ?>>25 Records Per Page</option>

			<option value="50" <?php if($_GET['records']=='50'){ ?> selected="selected"<?php } ?>>50 Records Per Page</option>

			<option value="100" <?php if($_GET['records']=='100'){ ?> selected="selected"<?php } ?>>100 Records Per Page</option>

			<option value="200" <?php if($_GET['records']=='200'){ ?> selected="selected"<?php } ?>>200 Records Per Page</option>

			<option value="300" <?php if($_GET['records']=='300'){ ?> selected="selected"<?php } ?>>300 Records Per Page</option>

		  </select></td>

	  </tr> 

	</table></td> 

    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>



  </tr>

</tbody></table>

	</div>

</div></form>	</td>

  </tr>

</table>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">

 <input name="importpackagemealPlan" id="importpackagemealPlan" type="hidden" value="Y" /> <input name="importpackagemealPlanModule" id="importpackagemealPlanModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /></div>

 </form>

<script>

	function submitimportfrom(){

		startloading();

		$('#importfrm').submit();

		var filesizes = $("#importfield")[0].files[0].size;

		filesizes=Number(filesizes/1024); 

		if(filesizes>11){

		

		}  

	}

	

	function reloadpagemain(){

		location.reload();

	}

	

	

	 

	$('#importbutton').click(function(){

		$('#importfield').click();

	});

</script> 

<script> 

	window.setInterval(function(){ 

		  checked = $("#listform .gridtable td input[type=checkbox]:checked").length;

			

		  if(!checked) { 

		  $("#deactivatebtn").hide();

		  $("#topheadingmain").show();

		  } else {

		  $("#deactivatebtn").show();

		  $("#topheadingmain").hide();

		  } 

	}, 100);  

	comtabopenclose('linkbox','op2');



	$(document).ready(function() {

     $('#mainsectiontable').DataTable( {

        "paging":   false,

        "ordering": true,

        "info":     true,

        "searching": false,

        "order": [[ 1, 'asc' ]]

    } );

} );

</script>