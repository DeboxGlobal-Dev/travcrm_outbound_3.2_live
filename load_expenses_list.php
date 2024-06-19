<?php  
include "inc.php";  
?>	
 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th align="left" class="header" >Destination</th>
     <th align="left" class="header" >Name</th>

     <th align="left" class="header">Contact&nbsp;Person</th>
     <th align="left" class="header">Located  </th>

     <th align="left" class="header">Contact No.</th>
     <th align="left" class="header">	Email Id</th>
     <th align="left" class="header sortingbg" style="display:none;">assign To </th>
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
$mainwhere=' and ( name like "%'.$searchField.'%" or contactPerson like "%'.$searchField.'%" or id in (select masterId from  '._PHONE_MASTER_.' where phoneNo like "%'.$searchField.'%"  ) or id in  (select masterId from  '._EMAIL_MASTER_.' where email like "%'.$searchField.'%"  ) or cityId in  (select id from  '._CITY_MASTER_.' where name like "%'.$searchField.'%"  )  or destinationId in  (select id from  '._DESTINATION_MASTER_.' where name like "%'.$searchField.'%"  )  or stateId in  (select id from  '._STATE_MASTER_.' where name like "%'.$searchField.'%"  ) ) ';
}

$assignto='';
if($_GET['assignto']!=''){
$assignto=' and	assignTo='.$_GET['assignto'].'';
}
 
$suppliertype='';
if($_GET['suppliertype']!=''){
$assignto=' and	companyTypeId='.$_GET['suppliertype'].'';
}
 
   
  
  
if($loginuserprofileId==1){  
$wheresearch=' 1 '.$mainwhere.''; 
} else {
$wheresearch=' 1 '.$mainwhere.''; 
//$wheresearch=' ( addedBy = '.$_SESSION['userid'].') '.$mainwhere.''; 
}
 
 
 
$where='where '.$wheresearch.' and name!="" '.$assignto.' and deletestatus=0 order by dateAdded desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];

/*$sql5="select * from ad_courses ";
$res5 = mysqli_query($sql5);
$countRoom = $num5=mysqli_num_rows($res5); */
?>
  <tr>
    <td align="left"><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left"><div class="bluelink" onclick="view('<?php echo encode($resultlists['id']); ?>');"><?php echo strip($resultlists['name']); ?> </div></td>

    <td align="left"><?php echo strip($resultlists['contactPerson']); ?></td>
    <!-- <td align="left"><?php //echo getCityName($resultlists['cityId']); ?>, <?php //echo getStateName($resultlists['stateId']); ?>, <?php //echo getCountryName($resultlists['countryId']); ?></td> -->
    <td align="left">
      <?php if(!empty($resultlists['cityId'])){ echo getCityName($resultlists['cityId']);} else {echo getcity($supplr_id); } ?>,
       <?php if(!empty($resultlists['stateId'])){ echo getStateName($resultlists['stateId']);} else{echo getstate($supplr_id); } ?>,
        <?php if(!empty($resultlists['countryId'])){ echo getCountryName($resultlists['countryId']);} else {echo getcountry($supplr_id); } ?>    </td>

    <td align="left"><?php echo getPrimaryPhone($resultlists['id'],'suppliers'); ?></td>
    <td align="left"><a href="mailto:<?php echo getPrimaryEmail($resultlists['id']); ?>"><?php echo getPrimaryEmail($resultlists['id'],'suppliers'); ?></a></td>
    <td align="left" style="display:none;"><?php echo getUserName($resultlists['assignTo']); ?></td>
    </tr> 
	
	<?php $no++; } ?>
</tbody></table>
