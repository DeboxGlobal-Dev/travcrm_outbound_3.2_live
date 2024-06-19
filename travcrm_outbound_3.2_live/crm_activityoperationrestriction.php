<?php 
$startDate=$_GET['startDate'];
$endDate=$_GET['endDate'];
?> 
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
	<!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        
      <td><input name="startDate" type="text"  class="topsearchfiledmain" id="startDate_r" style="width:80px;" size="6" placeholder="start"  value="<?php if($_GET['startDate']!=''){ echo  date('d-m-Y', strtotime($_GET['startDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>
      <td><input name="endDate" type="text"  class="topsearchfiledmain" id="endDate_r" style="width:80px;" size="6" placeholder="To" value="<?php if($_GET['endDate']!=''){ echo  date('d-m-Y', strtotime($_GET['endDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>      
	    <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php if($_GET['keyword']!=''){ echo $_GET['keyword']; } ?>" size="100" maxlength="100" placeholder="Keyword"></td> 
        <!--<td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td> 
        <td><a href="<?php echo $fullurl; ?>travrmimports/ActivityMaster-import.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>
        <td><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
		<td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" /></td>  -->
        <td><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
		<input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td> 
        <td style="padding-right:20px;">&nbsp;</td>
      </tr>
     
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:30px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable"> 
   	<thead> 
   		<tr>
   		    <th width="12%" align="left" class="header" >Sr.</th>
			<th width="12%" align="left" class="header" >&nbsp;</th>
			<th width="14%" align="left" class="header" >Name </th>
			<th width="9%"  align="left" class="header" >Destination </th>
			<th width="11%"  align="left" class="header" >From&nbsp;Date</th>
        	<th width="9%"  align="left" class="header" >To&nbsp;Date</th>
        	<th width="7%"  align="left" class="header" >Reason</th>
        	<th width="7%"  align="left" class="header" >Operation&nbsp;Restriction</th>
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
$searchMain=1; 
if($_GET['keyword']!=''){
	$searchMain='otherActivityName like "%'.trim($_GET['keyword']).'%" or otherActivityCity like "%'.trim($_GET['keyword']).'%" or otherActivityDetail like "%'.trim($_GET['keyword']).'%"  '; 
} 

$strWhere='';
if($startDate!='' && $endDate!=''){
	  $startDate = date('Y-m-d', strtotime( $startDate ));
	  $endDate = date('Y-m-d', strtotime( $endDate ));
	  $strWhere.='and id in (select otheractivityId from hoteloperationRestriction where 1 and startDate BETWEEN "'.date('Y-m-d',strtotime($startDate)).'" and "'.date('Y-m-d',strtotime($endDate)).'" )';
}

 
$where='where 1 and '.$searchMain.' '.$strWhere.' order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
$rs=GetRecordList($select,_PACKAGE_BUILDER_OTHER_ACTIVITY_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
    
//============get hotel restriction===========//
$select4='*';    
$where4='otheractivityId='.$resultlists['id'].'';
$rs4=GetPageRecord($select4,'hoteloperationRestriction',$where4);
$restrictionNm = mysqli_num_rows($rs4);
$restrictionList=mysqli_fetch_array($rs4);


?>
  <tr><?php echo $subjectNm; ?>
    <td><?=$no?></td>
    <td align="left"><?php if($resultlists['otherActivityImage']!=''){ ?><img src="packageimages/<?php echo $resultlists['otherActivityImage']; ?>" width="75" height="58" /><?php }else{ ?> <div style="border: 1px solid #8d8989; background-color: #8d8989; padding: 20px; text-align: center; border-radius: 3px; color: #fff;">No Image Found...</div> <?php } ?></td>
    <td align="left"><?php echo $resultlists['otherActivityName']; ?></td> 
	<td align="left"><?php echo $resultlists['otherActivityCity']; ?></td>
	<td align="left"><?php if($restrictionList['startDate']!='1970-01-01' && $restrictionList['startDate']!=''){ echo date('d-m-Y',strtotime($restrictionList['startDate'])); } ?></td>
	<td align="left"><?php if($restrictionList['endDate']!='1970-01-01' && $restrictionList['startDate']!=''){ echo date('d-m-Y',strtotime($restrictionList['endDate'])); } ?></td>
    <td align="left"><a href="showpage.crm?module=activityrestrictions&otheractivityId=<?php echo encode($resultlists['id']); ?>"><?php echo $restrictionList['reason']?> (<?php echo $restrictionNm; ?>)</a></td>
	<td align="center"><a  href="#" onclick="masters_alertspopupopen('action=activityrestriction&module=<?php echo $_REQUEST['module'];?>&id=<?php echo $resultlists['id']; ?>','600px','auto');"><input name="addnewuserbtn" type="button" class="bluembutton" value="+&nbsp;Operation&nbsp;Restriction"/></a></td>
	</tr> 
	
	<?php $no++; } ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

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

 <input name="importotherActivity" id="importotherActivity" type="hidden" value="Y" /> <input name="importimportotherActivityModule" id="importimportotherActivityModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

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

$('#importbutton').click(function(){

    $('#importfield').click();

});
</script>

<script>
$('#startDate_r').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#endDate_r'),
   });

$('#endDate_r').Zebra_DatePicker({
format: 'd-m-Y',
});
</script>
