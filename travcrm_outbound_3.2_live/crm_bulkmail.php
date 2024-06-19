<?php

$searchField=clean($_GET['searchField']);

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

	

	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Company','600px','auto');" />

	<?php } ?>

	</div>

	

	</div></td>

    <td align="right"> </td>

  </tr>

  

</table>

</div>

</form>
<style>
.mainlistofmaster{overflow:hidden;}
 

</style>
<form id="listform" name="listform" method="get">

<div id="pagelisterouter" style="padding-left:30px;padding-right:30px; overflow:hidden;">
<div style="width:78%; float:left;">
<div class="mainlistofmaster"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">



   <thead>



   <tr>

     <th width="51%" align="left" class="header" >Name</th>

      <th width="26%" align="center" class="header" >Subscribers</th>
      <th width="23%" align="left" class="header" >Last Mail </th>
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
$mainwhere='';
$where='where 1 order by sr asc'; 
$page=$_GET['page']; 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,'bulkEmailCategory',$where,$limit,$page,$targetpage); 

$totalentry=$rs[1];  
$paging=$rs[2];  
while($resultlists=mysqli_fetch_array($rs[0])){  
$supplr_id = $resultlists['id'];
?>
  <tr>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['displayId']); ?>');" style="font-weight:500; color:#45b558 !important;"><?php echo strip($resultlists['name']); ?> </div></td>

    <td align="center"><?php if($resultlists['displayId']=='200'){ echo countlisting('id','corporateMaster','where deletestatus=0'); } if($resultlists['displayId']=='201'){ echo countlisting('id','contactsMaster','where deletestatus=0'); } if($resultlists['displayId']!='201' && $resultlists['displayId']!='200'){ echo countlisting('id','queryMaster','where queryStatus='.$resultlists['displayId'].' and deletestatus=0'); } ?></td>

    <td align="left"><?php if($resultlists['lastMailDate']!='0000-00-00 00:00:00'){ echo date('d/m/Y - h:i a',$resultlists['lastMailDate']); } else { echo 'No mail sent'; }  ?></td>
     
    </tr> 

	

	<?php $no++; } ?>
</tbody></table>
</div>
</div>

<div style="width:20%; float:right;">
<a href="#"></a>
</div>

 

</div></form>	</td>

  </tr>

</table>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">

 <input name="importsupplierexcel" id="importsupplierexcel" type="hidden" value="Y" /> 

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

</script>