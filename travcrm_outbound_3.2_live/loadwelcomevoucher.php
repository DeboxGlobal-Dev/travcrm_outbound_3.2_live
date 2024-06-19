<?php

include "inc.php";  

// include "config/logincheck.php";  


function dateDiffInDays($date1, $date2){ 

	// Calulating the difference in timestamps 

	$diff = strtotime($date2) - strtotime($date1); 

	// 1 day = 24 hours 

	// 24 * 60 * 60 = 86400 seconds 

	return abs(round($diff / 86400)); 

}



$queryId='';

if($_GET['queryId']!=''){

    $queryId =$_GET['queryId'];

}



$select='*';

$where='id="'.$queryId.'"';

$rs=GetPageRecord($select,_QUERY_MASTER_,$where);   

$resultpage=mysqli_fetch_array($rs);


if($resultpage['clientType']=='1'){
  $select4='*';
  $where4='id="'.$resultpage['companyId'].'"';
  $rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4);
  $resultsales=mysqli_fetch_array($rs4);
  $mobilemailtype='corporate';
  }
  if($resultpage['clientType']=='2'){
  $select4='*';
  $where4='id="'.$resultpage['companyId'].'"';
  $rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4);
  $resultsales=mysqli_fetch_array($rs4);
  $mobilemailtype='contacts';
  }



$select1='*';   
$where1='letterType="agentwelcomeLetter"'; 
$rs1=GetPageRecord($select1,'letterMaster',$where1); 
$editresult=mysqli_fetch_array($rs1);

$rs22=GetPageRecord('*','companySettingsMaster','id=1');
$resultCompany=mysqli_fetch_array($rs22);


$selectu='*';    

$whereu=' id="'.$resultsales['assignTo'].'"  ';  

$rsu=GetPageRecord($selectu,_USER_MASTER_,$whereu); 

while($resListingu=mysqli_fetch_array($rsu)){ 

    

$operationPerson=$resListingu['firstName'].' '.$resListingu['lastName'];

$phone=$resListingu['phone'];
$email=$resListingu['email'];

}

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto+Serif:ital,opsz,wght@0,8..144,100;0,8..144,200;0,8..144,300;0,8..144,400;0,8..144,500;0,8..144,600;1,8..144,100;1,8..144,200;1,8..144,300;1,8..144,400;1,8..144,500&display=swap" rel="stylesheet">


<div style="margin-bottom:10px;">

<style>

  .vlist a{ 

      display: block;

      font-size: 15px;

      color: #006633;

      background-color: #F5FFE8;

      border: 1px solid #a7e7c1;

      padding: 10px;

      text-decoration: none;

      border-radius: 3PX;

      font-size: 15px;

  }

  .texteditformat p span{
    font-size:17px !important; 
    font-family: 'Roboto Serif', serif !important;
  }

</style>

<div style="padding:10px;" class="vlist2">

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditquery" target="actoinfrm" id="addeditquery">

<div id="printableArea<?php echo strip($resultpage['id']); ?>">

<div style="padding:10px; background-color:#FFFFFF;   position:relative; margin:10px;" >
<!-- border: 2px dashed #ccc; -->



<div style="padding:10px;">

<table width="" border="0" cellpadding="0" cellspacing="0" 
style="width:750px; border-top: 2px dashed #ccc;border-bottom: 2px dashed #ccc;border-right: 2px dashed #ccc;border-left: 2px dashed #ccc;padding-left: 10px;">

      <tr>

        <td width="100%" align="center"><img src="<?php echo $fullurl; ?>dirfiles/<?php echo clean($resultCompany['proposalLogo']); ?>" style="max-height: 130px; max-width: 750px;height:100pax;" /></td>

      </tr>

      <tr>

        <td width="100%" style="font-size:13px;"><br />Date: <?php if($resultpage['fromDate']!=''){ echo date('j-F-Y',strtotime($resultpage['fromDate'])); }?></td>

      </tr>

      <tr>

        <td width="100%" style="font-size:13px;"><br /><?php echo $editresult['greetingNote'].' '.$resultpage['leadPaxName']; ?></td>

      </tr>

      <tr>

        <td style="font-size:11px;">&nbsp;</td>

        <!-- <td align="right">&nbsp;</td> -->

      </tr>

      <tr>

        <td style="font-size:15px;text-align:center;"><br /></td>

      </tr>

      <tr>

        <td class="texteditformat" style="font-size:17px !important;font-family: 'Roboto Serif', serif !important;">
        <?php 
              $welcomeNote = stripslashes($editresult['welcomeNote']); 
          echo $welcomeNote = str_replace('<p><span>&nbsp;</span></p>','',$welcomeNote);
            // echo $welcomeNote = str_replace('','',$editresult['welcomeNote']);
          // 	$welcomeNote = str_replace('', ' ', $welcomeNote);
          //  $welcomeNote = str_replace('\r\n', '<br>', $welcomeNote);
        
        ?></td>

      </tr>

   <!-- <tr>

    <td style="font-size:15px;"><br /><?php //echo $operationPerson.' - '.$phone.' - '.$email; ?></td>

  </tr> -->

  <!-- <tr>

    <td style="font-size:15px;"><br /> <strong><?php //echo $resultCompany['companyName']; ?></strong></td>

  </tr>

   <tr>

    <td style="font-size:15px;"><br /><strong>Director</strong></td><br>

  </tr> -->

  <!-- <tr>

    <td style="font-size:15px;"><br />P.S.: All contact telephone numbers are in your Travel Documents</td>

  </tr> -->

  <tr>

        <td style="font-size:11px;">&nbsp;</td>

        <!-- <td align="right">&nbsp;</td> -->

  </tr>

</table>

</div>

<style>

	@media print

{    

    button

    {

        display: none !important;

    }
    html, body {
    height:auto; 
    margin: 0 !important; 
    padding: 0 !important;
    overflow: auto;
  }

}

	@page {

    size: auto;  

    margin: 0;

	   

}

	 </style>

</div>

</div>
<?php if($_REQUEST['welcomeLetter']!='yes'){ ?>
<div style="background-color: #F7F7F7; padding: 5px; border: 1px solid #e5e5e5; margin-bottom:10px; margin:10px; margin-top:0px; margin-bottom:20px;    margin-top: -10px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>

  <td colspan="2" align="left"><a style="border:1px solid #ccc; padding:3px 12px; font-size:12px; background-color:#000; color:#FFFFFF !important; cursor: pointer;" href="<?php echo $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo encode($resultpage['id']); ?>&welcomeLetter=yes">Send</a></td>

    <td width="50%" align="right"><input type="button" name="Submit" value="Print"   style=" border:1px solid #ccc; padding:3px; font-size:12px; background-color:#000; color:#FFFFFF; padding-left:5px; padding-right:5px;" onclick="printDiv('printableArea<?php echo strip($resultpage['id']); ?>')" class="a" /></td>

  </tr>

  

</table>

</div>
<?php } ?>

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