<?php
include 'tableSorting.php';
$searchField=clean($_GET['searchField']);
$invoiceid=clean($_GET['invoiceid']);
if($loginuserprofileId==1){ 
  $wheresearchassign=' 1   ';
} else { 
  $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';

  $wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';
}
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
  <form method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <div class="headingm" style="margin-left:30px;">
      <span id="topheadingmain"><?php echo $pageName; ?></span>
      <div id="deactivatebtn" style="display:none;">
        <?php if($deletepermission==1){ ?> 
          <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Invoice','600px','auto');" />
        <?php } ?>
      </div>
      </div>
    </td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
       <td >
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
           <td>
              <select name="invoiceType" id="invoiceType" class="topsearchfiledmain"> 
                <option value="2" <?php if($_REQUEST['invoiceType']==2){ ?>selected<?php }?>>Proforma Invoice</option>
                <option value="1" <?php if($_REQUEST['invoiceType']==1){ ?>selected<?php }?>>Tax Invoice</option>
              </select>
            </td>
            <td>
                <input name="searchField" type="text"  class="topsearchfiledmain" id="searchField" style="width:80px;" value="<?php echo $searchField; ?>" placeholder="Query Id"  />
            </td>
            <td style="padding:0px 0px 0px 5px;" > 
                <input name="invoiceNo" type="text"  class="topsearchfiledmain" id="invoiceNo" style="width:80px;" value="<?php echo $invoiceNo; ?>" placeholder="Invoice Id" />
            </td>
            <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
            <td style="padding-right:20px;">&nbsp;</td>
          </tr>
        </table>
        </td>
        <?php if($addpermission==1){ ?>
        <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="alertspopupopen('action=invoicequeryid','400px','auto');" /></td> 
        <?php } ?>
      </tr>
    </table>
    </td>
  </tr>
</table>
</div>
</form>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="invoicedelete" id="action" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter table table-striped table-bordered" id="mainsectiontable">
   <thead>
   <tr>
     <th width="3%" align="left" class="header">&nbsp;</th>
      <th width="27%" align="left" class="header">Invoice No.</th>
     <th width="14%" align="left" class="header"> Query ID </th>
     <th width="15%" align="left" class="header"  >Invoice Date </th>
     <th width="18%" align="left" class="header"  >Client </th>
     <th width="10%" align="left" class="header"  >Invoice Type </th>
     <th width="13%" align="center" class="header">Action </th>
     </tr>
   </thead>
<tbody>
<?php

// $wheresetting = 'panInformation!="" ';
$compnysetting=GetPageRecord('*','companySettingsMaster',' id=1 ');
$companyPAN = mysqli_fetch_assoc($compnysetting);
$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

$searchField=clean(trim(ltrim($_GET['searchField'], '0')));

$mainwhere='';
if($searchField!=''){
$mainwhere=' and  queryId="'.$searchField.'"';
}
   
$invoiceid=clean(trim(ltrim($_GET['invoiceid'], '0')));
 
if($invoiceid!=''){
$invoiceid=' and  id='.$invoiceid.'';
}
$profileiddata='';   
if($loginuserprofileId=='48'){
  $profileiddata=' and  queryId in (select id from miceMaster where companyId in ( select companyId from userMaster where id='.$_SESSION['userid'].'))';
}
     
if($_REQUEST['invoiceType']!=''){
    $invoiceTypeWhere = 'and invoiceType="'.$_REQUEST['invoiceType'].'"';
}

// invoice template select
$rs = GetPageRecord('setDefaultTemplate','invoiceSettingMaster','id=1');
$invoiceTempvoucherData = mysqli_fetch_assoc($rs);
$setDefaultTemplate = $invoiceTempvoucherData['setDefaultTemplate']; 


$where='where deletestatus=0 '.$invoiceTypeWhere.' '.$mainwhere.' '.$invoiceid.' '.$profileiddata.' order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=invoice&records='.$limit.'&searchField='.$searchField.'&';
$rs=GetRecordList($select,_INVOICE_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
?>
  <tr>
    <td align="left"><a href="showpage.crm?module=invoice&add=yes&id=<?php echo encode($resultlists['id']); ?>"><img src="images/editicon.png" class="editicon"></a></td>
    <td align="left">
	
    <div class="bluelink">
    <?php 
      if($resultlists['docName']!=''){ ?>
        <a href="docFiles/Invoices/<?php echo $resultlists['docName']; ?>" target="_blank"><?php echo makeInvoiceId($resultlists['id']); ?></a>
        <?php 
      } else {  
        if($setDefaultTemplate == 1){?>
          <a href="genrateDOMPdf.php?pageurl=<?php echo $fullurl;  ?>invoicepdf01.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeInvoiceId($resultlists['id']); ?></a><?php
        }elseif($setDefaultTemplate == 3){?>
          <a href="genrateDOMPdf.php?pageurl=<?php echo $fullurl;  ?>invoicepdf02.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeInvoiceId($resultlists['id']); ?></a><?php
        }elseif($setDefaultTemplate == 4){?>
          <a href="genrateDOMPdf.php?pageurl=<?php echo $fullurl;  ?>invoicepdf03.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeInvoiceId($resultlists['id']); ?></a><?php
        }
        elseif($setDefaultTemplate == 5){?>
          <a href="genrateDOMPdf.php?pageurl=<?php echo $fullurl;  ?>invoicepdf05.php?id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo makeInvoiceId($resultlists['id']); ?></a><?php
        }
      } ?>
    </div>
    </td>
    
      <td align="left"><?php echo makeQuotationId($resultlists['quotationId']); ?></td>
    
      <td align="left" ><?php echo date('d-m-Y',strtotime($resultlists['invoicedate'])); ?></td>
      
      <td align="left" ><?php
        $select2='companyId,clientType'; 
        $where2='id="'.$resultlists['queryId'].'"'; 
        $rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2); 
        $queryCompany=mysqli_fetch_array($rs2); 
        echo showClientTypeUserName($queryCompany['clientType'],$queryCompany['companyId']); ?> 
      </td>
      <td align="left" ><?php if($resultlists['invoiceType']=='1'){ echo 'Tax Invoice'; } else { echo 'Proforma'; } ?></td>
        <td align="center" >
      <?php if($resultlists['docName']!=''){ ?>
      <div style="width:162px;">
      <div class="iconlistset" style="background-color:#ff9614;" onclick="setupbox('showpage.crm?module=query&view=yes&id=<?php echo encode($resultlists['queryId']); ?>&invoiceId=<?php echo encode($resultlists['id']); ?>');"><img src="images/emailiconsmall.png"  /></div>

      <a href="<?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

      <a href="<?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;"   /></div></a>


        <?php

        $select2='*';  
        $where2='id='.$resultlists['queryId'].'';  
        $rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
        $queryiddetail=mysqli_fetch_array($rs2);

        if($queryiddetail['clientType']==2){  
        $getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
        } 

        if($queryiddetail['clientType']==1){ 
        $getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
        }  
        ?>

        <a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Invoice: <?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>

      </div> 
    <?php } else { ?>
  <div style="width:162px;">
  <div class="iconlistset" style="background-color:#ff9614;" onclick="alertspopupopen('action=sendinvoiceemail&invoiceid=<?php echo $resultlists['id']; ?>','600px','auto');"><img src="images/emailiconsmall.png"  /></div>

  <a href="<?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#4493cc;"><img src="images/printicon.png"   /></div></a>

  <a href="<?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>&download=1" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e;"><img src="images/downloadicon.png" style="margin-top:4px;" /></div></a>
  <?php
  $select2='*';  
  $where2='id='.$resultlists['queryId'].'';  
  $rs2=GetPageRecord($select2,_QUERY_MASTER_,$where2);  
  $queryiddetail=mysqli_fetch_array($rs2);

  if($queryiddetail['clientType']==2){  
  $getphone =  getPrimaryPhone($queryiddetail['companyId'],'contacts');  
  } 

  if($queryiddetail['clientType']==1){ 
  $getphone = getPrimaryPhone($queryiddetail['companyId'],"corporate");
  }  
  ?>
  <a href="https://api.whatsapp.com/send?phone=91<?php echo $getphone; ?>&text=Download Invoice:<?php echo $fullurl;  if($setDefaultTemplate == 1){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf01.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 3){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf02.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 4){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf03.php?id='.encode($resultlists['id']); }elseif($setDefaultTemplate == 5){ echo 'genrateDOMPdf.php?pageurl='.$fullurl.'invoicepdf05.php?id='.encode($resultlists['id']); } ?>" target="_blank"><div class="iconlistset" style="background-color:#5bbd1e; color:#fff; font-size:25px;"><i class="fa fa-whatsapp"></i></div></a>
  </div>
  <?php } ?>
	  
  
   </td>
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
  </div>
  </form>
  </td>
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