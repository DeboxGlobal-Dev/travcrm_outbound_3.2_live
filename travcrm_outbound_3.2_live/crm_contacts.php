<?php

$searchField=clean($_GET['searchField']); 


 if($loginuserprofileId==1){ 

$wheresearchassign=' 1 and ';

} else { 

 $wheresearchassign=' assignTo in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].' ) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager='.$_SESSION['userid'].'  ))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where  reportingManager ='.$_SESSION['userid'].')))  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager ='.$_SESSION['userid'].'))))
 
  or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'   where reportingManager ='.$_SESSION['userid'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in (select id from '._USER_MASTER_.' where reportingManager in  (select id from '._USER_MASTER_.'  where reportingManager ='.$_SESSION['userid'].'))))))';

$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') and ';

}



$queryRecord = GetPageRecord('*','queryMaster','id="'.decode($_REQUEST['queryId']).'"');
$queryData = mysqli_fetch_assoc($queryRecord);
$querytourId = makeQueryTourId($queryData['id']);
$referanceNumber = $queryData['referanceNumber'];
$displayId = makeQueryId($queryData['id']);
$agentName = showClientTypeUserName($queryData['clientType'],$queryData['companyId']);



  // samay validation for guest should not added more than totalpax
  $totalPax = ($queryData['adult']+$queryData['child']+$queryData['infant']); 
  $addPax = countlisting('id',_CONTACT_MASTER_,' where queryId2="'.decode($_REQUEST['queryId']).'" and tourId="'.$querytourId.'"');
  $rmPax = ($totalPax-$addPax);


?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 

<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<style>
.col-md-6 {  display: none !important;}
#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}
body{overflow-x:hidden !important;}
.header{font-weight: 500 !important; font-size: 13px !important;}
#mainsectiontable .fa-pencil-square{cursor: pointer;
    font-size: 20px;
    color: #ff5c00;
  }

</style>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<style>
.col-md-6 {  display: none !important;}
#pagelisterouter{ padding:10px !important; padding-top: 130px !important;}
body{overflow-x:hidden !important;}
.header{font-weight: 500 !important; font-size: 13px !important;}
#mainsectiontable .fa-pencil-square{cursor: pointer;
    font-size: 20px;
    color: #ff5c00;
  }
.tablecostom td{
  padding: 10px 5px;
}
.back_querycls{
  font-size: 15px;
    font-weight: 400;
    box-shadow: 0px 0px 3px 0px grey;
    padding: 5px 13px;
    margin-left: -17px !important;
    color: #505050 !important;
    border-radius: 13px;
}
.formcontrol{
  padding: 5px;
    border-color: #ccc;
    border-radius: 4px;
}
#deactivatebtn {
    top: 25px!important;
    left: 70px!important;
}
</style> 
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
  <form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
   <td>
      <div class="headingm" style="margin-left:30px;"> 
        <?php if($_REQUEST['guestList']==3){ ?> 
          <a class="back_querycls" href="<?php $fullurl; ?>showpage.crm?module=query&view=yes&id=<?php echo $_REQUEST['queryId']; ?>&b2bquotation=1#">Back</a>  <span id="topheadingmain"><?php echo $pageName = 'Guest List'; ?> </span> 
        <?php }else{ ?>
          <span id="topheadingmain"><?php echo $pageName; ?></span> 
        <?php } ?>

        <div id="deactivatebtn" style="display:none;">
          <?php if($deletepermission==1){ ?> 
          <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=contactsdelete&name=<?php echo urlencode($pageName); ?>','600px','auto');" />
          <?php } ?>
        </div>
      
      </div>
    </td>

    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td >
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
      <select name="contactType" id="contactType" class="topsearchfiledmain" style="width: 100px;">
            <option value="">Select</option>
            <option value="2" <?php if($_REQUEST['contactType']==2){ echo 'selected="selected"';} ?>>B2C</option>
            <option value="3" <?php if($_REQUEST['contactType']==3){ echo 'selected="selected"';} ?>>Guest</option>
            <option value="1" <?php if($_REQUEST['contactType']==1){ echo 'selected="selected"';} ?>>Employee</option>
      </select>
    </td>
    <td><input name="searchField" type="text" value="<?php echo $searchField; ?>"  class="topsearchfiledmain" id="searchField" placeholder="Enter TourId, Name, Contact, Email" style="width:200px;" /></td>
      <td style="padding:0px 0px 0px 5px;" > 
          <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:160px; " >
            <option value="">All Assigned Users</option>
            <?php 
    
    
            $select2='*';    
            $where2='  '.$wheresearchassign.' 1 group by assignTo order by assignTo asc';  
            $rs2=GetPageRecord($select2,_CONTACT_MASTER_,$where2); 
            while($resListingQuery=mysqli_fetch_array($rs2)){ 
 
            $select='*';    
            $where=' id='.$resListingQuery['assignTo'].' and status=1 order by firstName asc';  
            $rs=GetPageRecord($select,_USER_MASTER_,$where); 
            while($resListing=mysqli_fetch_array($rs)){ 
             
              ?>
              <option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
              <?php } 
            }		 ?>
          </select> </td>
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
     <td  ><a href="<?php echo $fullurl; ?>travrmimports/b2c-Import-format.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>
      <?php if($rmPax>0 || $_REQUEST['guestList']!=3){ ?>
      <td><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
      <?php } ?>
       <td style="padding-right:20px;">
             <style>
              .dropbtn {
                  background-color: #67b069;
                    color: white;
                    padding: 11px;
                    font-size: 14px;
                    border: none;
                    margin-left: 7px;
                    border-radius: 30px;
                    cursor: pointer;
              }

              .dropdown {
                position: relative;
                display: inline-block;
                float: right; 
                cursor: pointer;
              }

              .dropdown-content {
                  display: none;
                  position: absolute;
                  background-color: #f1f1f1;
                  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                  z-index: 1;
                  font-size: 12px;
                  right: 0; 
                  overflow: visible;
                  text-align: left;
                  width: fit-content;
              }

              .dropdown-content a {
                color: black;
                padding: 10px 26px 10px 10px;
                text-decoration: none;
                display: block;
                float: left;
                text-align: left;
                width: 200px;
                background-color: #FFFFFF;
                border-bottom: 1px solid #cccccc30;


              }

              .dropdown-content a:hover {background-color: #ddd;}

              .dropdown:hover .dropdown-content {display: block;overflow: auto;
                  height: 200px;}

              .dropdown:hover .dropbtn {background-color: #3e8e41;}
              </style>
            
              <div class="dropdown">
                  <button class="dropbtn" type="button"><i class="fa fa-bug" aria-hidden="true"></i> View Logs</button>
                  <div class="dropdown-content"> 
                    <?php   $dirname =  'log_contacts/'; 
                    $images = scandir($dirname);
                    krsort($images);
                    foreach (array_slice($images, 0, 20) as $file) {
                        if (substr($file, -4) == ".log" ) {
                            ?>
                        <a href="<?php echo $fullurl; ?>log_contacts/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                        <?php  
                        }
                    }
                    ?>
                  </div>
              </div>
            </td>
    <!-- <td  >&nbsp;</td> -->
        </tr>
</table>

    </td>
        <?php 
          if($_REQUEST['guestList']==3 ){ 
            // if($rmPax>0){ 
                ?>
                <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Guest" onclick="addGuest('<?php echo $_REQUEST['queryId']; ?>','<?php echo $_REQUEST['guestList']; ?>');" /></td>
                <?php
            // }
          }elseif($addpermission==1){ 
            ?>
            <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="add();" /></td> 
          <?php 
        } 
      ?> 
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
</form>
<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:30px;">
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="action" type="hidden" value="contactsdelete" id="action" />
<?php

if($_REQUEST['guestList']==3){
  ?>
  <link href="css/main.css" rel="stylesheet" type="text/css" />
<table>
  <tr>
          <td style="padding-left: 10px;" id="QueryreferenceNo">
              <div class="griddiv">
                <label>
                  <div class="gridlable">Type<span class="redmind"></span> </div>
                  <select id="contactType" name="contactType" class="gridfield formcontrol" displayname="Contact Type" autocomplete="off" onchange="selectContactType(this.value);">
                      <option value="1" <?php if (1 == $contactType || $_REQUEST['BToCIdedit']==1 ) { ?> selected="selected" <?php } ?> >B2C</option>
                      <option value="2" <?php if (2 == $contactType) { ?>selected="selected" <?php } ?>>Employee</option>
                      <option value="3" <?php if (3 == $contactType || $_REQUEST['guestList']==3 ) { ?>selected="selected" <?php } ?>>Guest List</option>
                  </select>
                </label>
              </div>
          </td>
          <td style="padding-left: 10px;" id="tourIdquery">
              <div class="griddiv"><label>
                  <div class="gridlable">Tour Id</div>
                  <input type="text" name="tourId" id="tourId" class="gridfield formcontrol" value="<?php if($_REQUEST['queryTourId']!=''){ echo $_REQUEST['queryTourId']; }else{ echo $querytourId ;} ?> " diplayname="Tour Id">
                </label></div>
              </td>
              
              <td style="padding-left: 10px; display:none;" id="QueryIdquery">
              <div class="griddiv"><label>
                  <div class="gridlable">Query Id</div>
                  <input type="text" name="QueryId" id="QueryId" class="gridfield formcontrol" value="<?php echo $displayId; ?> " diplayname="Tour Id">
                </label></div>
                <input type="hidden" name="QueryId2" id="QueryId2" value="<?php echo $queryData['id']; ?>">
              </td>
            
              <td style="padding-left: 10px;" id="QueryAgentName">
              <div class="griddiv"><label>
                  <div class="gridlable">Agent Name</div>
                  <input type="text" name="AgentName" id="AgentName" class="gridfield formcontrol" value=" <?php echo $agentName; ?> " diplayname="Agent Name">
                </label></div>
              </td>
  </tr>
</table>
<?php } ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="mainsectiontable" class="table table-striped table-bordered tablecostom" >

   <thead>

   <tr>
    <th width="2%" align="center" valign="middle" class="header" >
      <?php if($editpermission==1){ ?> 
        <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" />
      <?php } ?>
      <label for="checkAll"><span></span>&nbsp;</label>
    </th>
    <th align="center" class="header" style="padding-left:0px; padding-right:0px;">&nbsp;</th>  
    <th align="left" class="header" style="min-width: 100px;">Name</th>
    <th align="left" class="header">Type</th>
     <th align="left" class="header" style="min-width: 180px;">Address</th>
     <th align="left" class="header" style="min-width:170px;">Contact Information</th>
     <th align="left" class="header" >	Address&nbsp;Proof</th>
     <th align="left" class="header" >Passport </th>
     <th align="left" class="header" >VISA </th>
     <th align="left" class="header" >Driver&nbsp;License</th>
     <th align="left" class="header" >Covid &nbsp;Certificate</th>
     <th align="left" class="header">Other </th>
     <th align="left" class="header"  >&nbsp;</th>
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
if($searchField!=''){
$mainwhere=' and ( tourId like "%'.$searchField.'%" or firstName like "%'.$searchField.'%" or lastName like "%'.$searchField.'%" or id in (select masterId from  '._PHONE_MASTER_.' where phoneNo like "%'.$searchField.'%"  ) or id in  (select masterId from  '._EMAIL_MASTER_.' where email like "%'.$searchField.'%"  ) ) ';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
  
//$wheresearch=' 1 '.$mainwhere.''; 
  // if($_REQUEST['queryId']!='' && $_REQUEST['guestList']==3){
  //    $guestsqueryId = decode($_REQUEST['queryId']);
  //    $whereGuest = ' and queryId2= "'.$guestsqueryId.'"';
  // }
  
  if($_REQUEST['queryTourId']!=''){
    $whereTourId = ' and tourId= "'.trim($_REQUEST['queryTourId']).'"';
  }
  if($querytourId!=''){
    $whereTourId = ' and tourId= "'.trim($querytourId).'"';
  }
  if($_REQUEST['contactType']>0){
    $contactType = $_REQUEST['contactType'];
    $whereType = 'and contactType="'.$contactType.'"';
  }
 
$where='where '.$wheresearchassign.' '.$wheresearch.' '.$whereTourId.' '.$whereType.' and firstName!="" '.$assignto.' and deletestatus=0 order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=contacts&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 

$rs=GetRecordList($select,_CONTACT_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 

  $resemail = GetPageRecord('*','emailMaster','masterId="'.$resultlists['id'].'" and sectionType="contacts" order by primaryvalue desc');
  $emailRes = mysqli_fetch_assoc($resemail);

  $resphone = GetPageRecord('*','phoneMaster','masterId="'.$resultlists['id'].'" and sectionType="contacts"  order by primaryvalue desc ');
  $phoneRes = mysqli_fetch_assoc($resphone);

   $resultproof = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=1');
   $addressProof = mysqli_fetch_assoc($resultproof);

   $resultpass = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=2');
   $passport = mysqli_fetch_assoc($resultpass);

   $resultvisa = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=3');
   $VISAproof = mysqli_fetch_assoc($resultvisa);

   $license = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=4');
   $driverLC = mysqli_fetch_assoc($license);

   $resultcoc = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=5');
   $covidVecCer = mysqli_fetch_assoc($resultcoc);

   $other = GetPageRecord('*','documentMaster','masterId="'.$resultlists['id'].'"and docType=6');
   $otherdoc = mysqli_fetch_assoc($other);
?>
  <tr>
    <td width="1%" align="center" valign="middle">
        <?php if($editpermission==1){ ?>
        <input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
        <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label>
        <?php } ?>
    </td>

    <td align="center" style="padding-left:0px;padding-right:0px; width:40px;">
      <?php if($_REQUEST['guestList']==3){ ?> 
        <i class="fa fa-pencil-square" aria-hidden="true" onclick="editGuest('<?php echo encode($resultlists['id']); ?>','<?php echo $_REQUEST['guestList']; ?>','<?php echo $_REQUEST['queryId']; ?>');"  style="cursor:pointer;"></i> 
      <?php }else{ ?>
      <?php if($editpermission==1){ ?>
      <i class="fa fa-pencil-square" aria-hidden="true" onclick="edit('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>
      <?php } }?>
    </td>
   
   <td align="left">
   <?php if($_REQUEST['guestList']==3){ ?>
     <div class="bluelink" onclick="viewGuest('<?php echo encode($resultlists['id']); ?>','<?php echo $_REQUEST['guestList']; ?>','<?php echo $_REQUEST['queryId']; ?>');" style="font-weight:500; color:#269038 !important;"><?php echo getNameTitle($resultlists['contacttitleId']).' '.clean($resultlists['firstName'].' '.$resultlists['lastName']); ?></div>
      <?php }else{ ?>
   <div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#269038 !important;"><?php echo getNameTitle($resultlists['contacttitleId']).' '.clean($resultlists['firstName'].' '.$resultlists['middleName'].' '.$resultlists['lastName']); ?></div>
  
   <?php } ?>
  </td>

  <td>
    <?php if($resultlists['contactType']==2){
            echo 'B2C';
        }elseif($resultlists['contactType']==1){
          echo 'Employee';
         }elseif($resultlists['contactType']==3){
          echo 'Guest';
         }
          ?>
  </td>

    <td align="left"><?php echo $resultlists['address1']; ?></td>
     
    <td align="left"><strong>Phone:&nbsp;</strong> 
    <?php if($phoneRes['phoneNo']!=''){ ?>
      <span id="shownumber<?php echo $resultlists['id']; ?>" style=" display:none;" class="shownum"><?php echo $phoneRes['phoneNo'].'<br>'; ?></span>
      <span id="showxxxr<?php echo $resultlists['id']; ?>" class="showxx"><?php echo maskPhone($phoneRes['phoneNo']).'<br>';?></span>
      <?php } ?>
    <strong>Email:&nbsp;</strong><?php if($emailRes['email']!=''){ ?>
      <span id="shownumbere<?php echo $resultlists['id']; ?>" style=" display:none;" class="shownum"><?php echo $emailRes['email'].'<br>'; ?></span>
      <span id="showxxxre<?php echo $resultlists['id']; ?>" class="showxx"><?php echo maskEmail($emailRes['email']).'<br>'; ?></span>
      <?php } ?>
    </td>
    

    <td align="left">
      <?php if($addressProof['documentAttachment']!=''){ ?>
        <a target="_blank" href="dirfiles/<?php echo $addressProof['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span></a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?>
    </td>

    <td align="left" ><?php if($passport['documentAttachment']!=''){ ?>
      <a target="_blank" href="dirfiles/<?php echo $passport['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span> </a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?></td>
    
       <td align="left" ><?php if($VISAproof['documentAttachment']!=''){ ?>
        <a target="_blank" href="dirfiles/<?php echo $VISAproof['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span> </a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?></td>

       <td align="left" ><?php if($driverLC['documentAttachment']!=''){ ?>
        <a target="_blank" href="dirfiles/<?php echo $driverLC['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span> </a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?></td>
       <td align="left" ><?php if($covidVecCer['documentAttachment']!=''){ ?>
        <a target="_blank" href="dirfiles/<?php echo $covidVecCer['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span> </a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?></td>
       <td align="left" ><?php if($otherdoc['documentAttachment']!=''){ ?>
        <a target="_blank" href="dirfiles/<?php echo $otherdoc['documentAttachment']; ?>">
       <span style="color: #1fc277; font-size:13px;"><?php echo 'View'; ?></span> </a>
       <?php }else{ ?>  <span style="color: red; font-size:14px;">No Attachment</span> <?php } ?></td>

    
       <td align="left"style="width:50px;"><a onClick="
      // $('.shownum').hide();
      // $('.showxx').show();
      $('#shownumber<?php echo $resultlists['id'];?>').toggle();
      $('#showxxxr<?php echo $resultlists['id'];?>').toggle();
      $('#shownumbere<?php echo $resultlists['id'];?>').toggle();
      $('#showxxxre<?php echo $resultlists['id'];?>').toggle();
      ">view</a></td>
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
</div></form>

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">
   <input name="importB2CExcel" id="importB2CExcel" type="hidden" value="Y" />
   <input name="importContactModule" id="importContactModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
   <input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onchange="submitimportfrom();" /> 
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
  </td>
  </tr>
</table>

<script> 
window.setInterval(function(){ 
  checked = $("#listform td input[type=checkbox]:checked").length;
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
        "info":     true
    } );
} );
</script>

<script>
function addGuest(queryId,guestlist){
    setupbox('showpage.crm?module=contacts&add=yes&queryId='+queryId+'&guestList='+guestlist);
}

function editGuest(guestId,contactType,queryId){
  setupbox('showpage.crm?module=contacts&add=yes&id='+guestId+'&guestList='+contactType+'&queryId='+queryId);
}

function viewGuest(guestId,contactType,queryId){
  setupbox('showpage.crm?module=contacts&view=yes&id='+guestId+'&guestList='+contactType+'&queryId='+queryId);
}
</script>