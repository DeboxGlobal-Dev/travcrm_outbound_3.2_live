<?php

$searchField=clean($_GET['searchField']);

$searchFieldcommon=clean($_GET['searchFieldcommon']);

?>





<link href="css/main.css" rel="stylesheet" type="text/css" />

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top">

	<form action="" method="get">

<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>

	<div id="deactivatebtn" style="display:none;">

	 <?php if($deletepermission==1){ ?> 

	

	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Query','600px','auto');" />

	<?php } ?>

	</div>

	

	</div></td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td>        </td>

         <td >

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td><input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php echo $searchField; ?>" size="6" maxlength="12" placeholder="Quotation Id" onkeyup="numericFilter(this);"/></td>

      <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>

         <td ><a href="frm_action.crm?createmultiquotation=1"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Create Quotation" ></a></td>

		<td style="padding-right:20px;">&nbsp;</td>

  </tr>

</table>		</td>

        <?php if($addpermission==1){ ?><?php } ?>

      </tr>

      

    </table></td>

  </tr>

  

</table>

</div>



</form>



<form id="listform" name="listform" method="get">

<div id="pagelisterouter" style="padding-left:30px;">



<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<input name="action" type="hidden" value="querydelete" id="action" />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>

     <th width="15%" align="center" class="header" >Quotation&nbsp;Number </th>

     <th width="25%" align="center" class="header">Client&nbsp;Name</th>

     <th width="20%" align="center" class="header">From&nbsp;Travel&nbsp;Date</th>

     <th width="20%" align="center" class="header">To&nbsp;Travel&nbsp;Date</th>

     <th width="20%" align="center" class="header">Quotation&nbsp;Date </th>

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



$searchField=clean(trim(ltrim($_GET['searchField'], '0')));



$mainwhere='';

if($searchField!=''){

$mainwhere=' and  id='.$searchField.'';

}



$where='where  1 '.$mainwhere.'  and deletestatus=0  order by dateAdded desc'; 

$page=$_GET['page'];

 

$targetpage=$fullurl.'showpage.crm?module=quotations&records='.$limit.'&searchField='.$searchField.'&'; 

$rs=GetRecordList($select,_QUOTATION_MASTER_,$where,$limit,$page,$targetpage); 

$totalentry=$rs[1]; 

$paging=$rs[2]; 

while($resultlists=mysqli_fetch_array($rs[0])){ 

?>

  <tr>

    <td width="15%" align="center"><div class="bluelink"  onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo makeQueryId($resultlists['id']); ?></div></td>

    <td width="25%" align="center"><div  class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo $resultlists['guest1']; ?></div></td>

	<td width="20%" align="center"><?php echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?></td>

    <td width="20%" align="center"><?php echo date('d-m-Y',strtotime($resultlists['toDate'])); ?></td>

    <td width="20%" align="center"><?php echo date('d-m-Y',$resultlists['dateAdded']); ?></td>

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

</script>