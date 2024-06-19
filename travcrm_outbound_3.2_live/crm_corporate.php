<?php

$searchField=clean($_GET['searchField']);

$wheresearchassign=' 1 and ';

 /*if($loginuserprofileId==1){ 



$wheresearchassign=' 1 and ';



} else { 



$wheresearchassign=' ( assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or assignTo in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 



$wheresearchassign='( '.$wheresearchassign.'  or assignTo = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') and ';



}*/

?>

<script>

corporatevoice=1;

</script>





<link href="css/main.css" rel="stylesheet" type="text/css" />





<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 

<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> 



<link href="css/bootstrap.css" rel="stylesheet" type="text/css" />

<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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



</style>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td width="91%" align="left" valign="top"><div class="rightsectionheader"><form action="" id="innersearchfrm" method="get"><table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
  <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	 <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onClick="alertspopupopen('action=corporatedelete&name=Company','600px','auto');" />
	 <?php } ?>
	</div>
	</div></td>
    <td align="right"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td> </td>
        <td >
		      <table width="100%" border="0" cellpadding="0" cellspacing="0">

      <tr>

        <td width="20%"><input name="searchField" type="text" value="<?php echo $searchField; ?>"  class="topsearchfiledmain" id="searchField" placeholder="Enter Company, Contact, Email" style="width:88%"/></td>


        <td style="padding:0px 0px 0px 5px;" >

            <select id="bussinessType" name="bussinessType" class="topsearchfiledmainselect" style="width:160px; " displayname="Bussiness Type" autocomplete="off"   >
         <option value="">ALL Bussiness Type</option> 
        <?php  
        $rs='';   
        $rs=GetPageRecord('*','businessTypeMaster',' id != 2 and deletestatus=0 and status=1 order by name asc'); 
        while($resListing1=mysqli_fetch_array($rs)){  

        ?>
        <option value="<?php echo strip($resListing1['id']); ?>" <?php if($resListing1['id']==$bussinessType){ ?>selected="selected"<?php } ?>><?php echo strip($resListing1['name']); ?></option>
        <?php } ?> 
        </select></td>

          <td style="padding:0px 0px 0px 5px;" >

            <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:160px; " >

            <option value="">All Assigned Users</option>

            <?php 
            $select2='*';    

            $where2='  '.$wheresearchassign.' 1 group by assignTo order by assignTo asc';  

            $rs2=GetPageRecord($select2,_CORPORATE_MASTER_,$where2); 

            while($resListingQuery=mysqli_fetch_array($rs2)){ 

            $select='*';    

            $where=' id='.$resListingQuery['assignTo'].' and status=1 order by firstName asc';  

            $rs=GetPageRecord($select,_USER_MASTER_,$where); 

            while($resListing=mysqli_fetch_array($rs)){ 
            ?>

            <option value="<?php echo $resListing['id']; ?>" <?php if($_GET['assignto']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>

            <?php } }		 ?>

          </select></td>
          <!-- <td>

            <select name="status" id="status1" value="status" class="fa fa-angle-down bluembutton <?php if($_REQUEST['status']) { ?> selected <?php } ?>" style="background-color:#fff!important;color:#000!important">



              <option value=""> Select  Status &nbsp;</option>



              <option value="1" <?php if($_GET['status']=='1'){ ?>selected="selected"<?php  } ?>>Active</option>



              <option value="0" <?php if($_GET['status']=='0'){ ?>selected="selected"<?php  } ?>>Inactive</option>



            </select>

            </td>
         
          -->
            <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
            <!-- <td><a href="<?php echo $fullurl; ?>downloadAgentData.php?action=download" target="_blank" class="bluembutton" style="background-color: #233a49 !important; border: 1px solid #233a49 !important;"><i class="fa fa-download" aria-hidden="true"></i>Download Data</a></td> -->
            <td  ><a href="<?php echo $fullurl; ?>travrmimports/agent-import-format.xls?t=<?php echo time(); ?>" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i>Download Format</a></td>
            <td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
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
                    <?php   $dirname =  'log_corporate/'; 
                    $images = scandir($dirname);
                    krsort($images);
                    foreach (array_slice($images, 0, 20) as $file) {
                        if (substr($file, -4) == ".log" ) {
                            ?>
                        <a href="<?php echo $fullurl; ?>log_corporate/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                        <?php  
                        }
                    }
                    ?>
                  </div>
              </div>
            </td>
          </tr>
          </table>
        </td>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add  <?php echo $pageName; ?>" onClick="add();" /></td> <?php } ?>
      </tr>
    </table>
  </td>
  </tr>
</table>
  </td>
  </tr>
</table>

</form>

</div>

	<form id="listform" name="listform" method="get">





<div id="pagelisterouter" style="padding-left:30px;">



<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

<input name="action" type="hidden" value="corporatedelete" id="action" />

<table width="100%" border="0" cellpadding="0" cellspacing="0"  id="mainsectiontable" class="table table-striped table-bordered">



   <thead>



   <tr>

      <th width="40" align="center" class="header" style="padding-left:0px;padding-tight:0px;">&nbsp;</th> 



      <th width="356" align="left" class="header" >Company</th>

	 <th width="180" align="left" class="header" >Bussiness Type</th>

     <th width="176" align="left" class="header">Contact&nbsp;Person</th>

     <th width="173" align="left" class="header">Contact No.</th>

     <th width="165" align="left" class="header">	Email Id</th>

     <th width="160" align="left" class="header">Sales&nbsp;Person </th>

    <th width="50" align="left" class="header" style="width:50px;">&nbsp;</th>
    <th width="12%" align="left" class="header " >Status</th>

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

$mainwhere=' and ( name like "%'.$searchField.'%" or id in ( select corporateId from  contactPersonMaster where contactPerson like "%'.$searchField.'%" or phone like "%'.encode($searchField).'%"  or email like "%'.encode($searchField).'%"  ) ) ';

}


if($_REQUEST['status']!=''){



	$wheresearch2 = " and status ='".clean($_REQUEST['status'])."' ";
}



$assignto='';

if($_GET['assignto']!=''){

$assignto=' and	assignTo='.$_GET['assignto'].'';

}


$bussinessType='';

if($_GET['bussinessType']!=''){

$assignto=' and	bussinessType='.$_GET['bussinessType'].'';

}

 

if($loginuserprofileId==1){  

$wheresearch=' 1 '.$mainwhere.''; 

} else {

$wheresearch=' 1 '.$mainwhere.''; 

//$wheresearch=' ( addedBy = '.$_SESSION['userid'].'  or assignTo = '.$_SESSION['userid'].'  ) '.$mainwhere.'';

}

$where='where  '.$wheresearchassign.' '.$wheresearch.' '.$wheresearch2.' and name!="" '.$assignto.''.$bussinessType.' and deletestatus=0 order by dateAdded desc'; 

$page=$_GET['page'];

$targetpage=$fullurl.'showpage.crm?module=corporate&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&'; 

$rs=GetRecordList($select,_CORPORATE_MASTER_,$where,$limit,$page,$targetpage); 

$totalentry=$rs[1]; 

$paging=$rs[2]; 

while($resultlists=mysqli_fetch_array($rs[0])){ 

  $corporate_id = $resultlists['id'];

?>

  <tr>

    <td align="center" style="padding-left:0px;padding-right:0px; width:40px;"><?php if($editpermission==1){ ?><i class="fa fa-pencil-square" aria-hidden="true" onClick="edit('<?php echo encode($resultlists['id']); ?>');"  style="cursor:pointer;"></i>

	<?php } ?></td>

    <td align="left"><div class="bluelink" onClick="view('<?php echo encode($resultlists['id']); ?>');" style="font-weight:500; color:#269038 !important;"><?php echo strip($resultlists['name']); ?></div></td>

	<td align="left"><span class="badge badge-primary" style="background-color:#2bbbad;"><?php 

	$bussinessTypeId = $resultlists['bussinessType'];

	$rs11=GetPageRecord('*','businessTypeMaster','id="'.$bussinessTypeId.'"'); 

	$resListing21=mysqli_fetch_array($rs11);  

	echo $resListing21['name'];

	  ?></span> </td>

    <td align="left">
    <?php
    $selectc='*';    
    $wherec=' corporateId="'.$resultlists['id'].'" and deletestatus=0 order by id asc';  
    $rsc=GetPageRecord($selectc,'contactPersonMaster',$wherec); $resListingc=mysqli_fetch_array($rsc); 
    echo ($resListingc['contactPerson']);
    ?></td>

    <td align="left">
      <?php if($resListingc['phone']!=''){ ?>
      <span id="shownumber<?php echo $resultlists['id']; ?>" style=" display:none;" class="shownum"><?php echo decode($resListingc['phone']); ?></span>
      <span id="showxxxr<?php echo $resultlists['id']; ?>" class="showxx"><?php echo maskPhone(decode($resListingc['phone']));?></span>
      <?php } ?>
    </td>

    <td align="left">
      <?php if($resListingc['email']!=''){ ?>
      <span id="shownumbere<?php echo $resultlists['id']; ?>" style=" display:none;" class="shownum"><?php echo decode($resListingc['email']); ?></span>
      <span id="showxxxre<?php echo $resultlists['id']; ?>" class="showxx"><?php echo maskEmail(decode($resListingc['email'])); ?></span>
      <?php } ?>
    </td>

    <td align="left"><span class="badge badge-primary"><?php echo getUserName($resultlists['assignTo']); ?></span></td>

    <td align="left"style="width:50px;"><a onClick="
      // $('.shownum').hide();
      // $('.showxx').show();
      $('#shownumber<?php echo $resultlists['id'];?>').toggle();
      $('#showxxxr<?php echo $resultlists['id'];?>').toggle();
      $('#shownumbere<?php echo $resultlists['id'];?>').toggle();
      $('#showxxxre<?php echo $resultlists['id'];?>').toggle();
      ">view</a></td>

    <td width="5%" align="left"><?php if($resultlists['status']==1){?><div style=" width: fit-content; color: green; "><?php echo 'Active';?></div><?php } else { ?><div style=" width: fit-content; color: red; "><?php echo 'In Active';?></div><?php }  ?>

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

    <td><select name="records" id="records" onChange="this.form.submit();" class="lightgrayfield" >

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

 <input name="importCorporateExcel" id="importCorporateExcel" type="hidden" value="Y" />  
 <input name="importCorporateModule" id="importCorporateModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

 <div id="filefieldhere"><input name="importfield" type="file" id="importfield" accept="application/vnd.ms-excel" onChange="submitimportfrom();" /></div>

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

        "info":     true

    } );

} );

</script>