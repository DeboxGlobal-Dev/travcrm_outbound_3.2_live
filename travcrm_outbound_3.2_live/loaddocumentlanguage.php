<?php

include "inc.php";  

include "config/logincheck.php";  

$queryId='';

if($_GET['queryId']!=''){

    $queryId .=$_GET['queryId'];
}

$select='*';

$where='id='.$queryId.'';

$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   

$resultpage=mysqli_fetch_array($rs);

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">



<div style="margin-bottom:10px;">

<div style="padding:10px;" class="vlist2">

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea<?php echo strip($resultpage['id']); ?>">

<div style="padding:10px; background-color:#FFFFFF; border:2px dashed #ccc;   position:relative; margin:10px;" >
<?php 
$rs=GetPageRecord('*','letterLinkLanguageMaster','1 and queryId="'.$queryId.'" and type="documentletter"'); 
$resListing=mysqli_fetch_array($rs)
?>
<div><?php echo stripslashes($resListing['description']) ?></div>
<style>
	@media print
{    
    button
    {
        display: none !important;
    }
}
	@page {
    size: auto;  
    margin: 0;
}
	 </style>
</div>
</div>

<div style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin:10px; margin-top:0px; margin-bottom:20px;    margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="printDiv('printableArea<?php echo strip($resultpage['id']); ?>')" class="a" /></td>

  </tr>

</table>

</div>

</form>

<script>

function printDiv(divName) {

     var printContents = document.getElementById(divName).innerHTML;

     var originalContents = document.body.innerHTML;
     
     document.body.innerHTML = printContents;
     
     window.print();
     
     document.body.innerHTML = originalContents;

}
</script>
</div>
</div>