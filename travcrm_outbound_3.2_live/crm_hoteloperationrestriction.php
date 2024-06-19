

<link href="css/main.css" rel="stylesheet" type="text/css" />
<?php if($_REQUEST['supplier']=='1' && $_REQUEST['page']==''){ ?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
  <form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><a href="showpage.crm?module=packagehotelmaster"><img src="images/backicon.png" width="20" style=" cursor:pointer;" /></a> Hotel Suppliers</span>
  <div id="deactivatebtn" style="display:none;">
   <?php if($deletepermission==1){ ?> 
  
  <!--<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=Extra&nbsp;Quotation','600px','auto');" />-->
  <?php } ?>
  </div>
  
  </div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="" size="100" maxlength="100" placeholder="Keyword"></td>
        <td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        <td>        </td>
        <?php if($importpermission==1){ ?><td style="display:none;"><input type="button" name="Submit" value="Import" class="whitembutton" /></td><?php } ?>
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add Supplier" onclick="masters_alertspopupopen('action=addeditpackagesupplier_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>&hotelid=<?php echo $_GET['hotelid'];?>','400px','auto');" /></td> <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<input name="supplier" id="supplier" type="hidden" value="1" />
<input name="hotelid" id="hotelid" type="hidden" value="<?php echo clean($_GET['hotelid']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
      <th width="14%" align="left" class="header" >Supplier</th>
     <th width="12%" align="left" class="header" >Destination</th>
     <th width="16%" align="left" class="header">Contact&nbsp;Person</th>
     <th width="12%" align="left" class="header">Located  </th>

     <th width="13%" align="left" class="header">Contact No.</th>
     <th width="13%" align="left" class="header"> Email Id</th>
     <th width="10%" align="center" class="header">Status</th>
     <th width="10%" align="center" class="header">Rate List </th>
   </tr>
   </thead>

 


 

  <tbody>
  <?php
  
if($_REQUEST['status']!=""){
$id=decode($_REQUEST['id']);
$status=$_REQUEST['status'];

$sql_ins="update "._PACKAGE_HOTEL_SUPPLIER_MASTER_." set deletestatus='$status' where id = '".$id."'";
mysqli_query(db(),$sql_ins) or die(mysqli_error(db()));
}

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);
$searchField=$_REQUEST['keyword'];
$mainwhere='';
if($searchField!=''){
  $mainwhere=' and ( name like "%'.$searchField.'%" or cityId in  ( select id from  '._CITY_MASTER_.' where name like "%'.$searchField.'%"  ) or stateId in ( select id from  '._STATE_MASTER_.' where name like "%'.$searchField.'%"  ) or id in ( select corporateId from  suppliercontactPersonMaster where contactPerson like "%'.$searchField.'%" or phone like "%'.encode($searchField).'%"  or email like "%'.encode($searchField).'%"  ) ) ';
}
 
$hotelId=decode($_GET['hotelid']);

$page=$_GET['page'];
 

$query1 = "SELECT * FROM "._PACKAGE_HOTEL_SUPPLIER_MASTER_." where  hotelId='".$hotelId."'";
$result = mysqli_query(db(),$query1);

/*$select='*';
//$where='where id="" '.$hotelId.''; 
$targetpage=$fullurl.'showpage.crm?module=suppliers&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$result=GetRecordList($select,_PACKAGE_HOTEL_SUPPLIER_MASTER_,$where,$limit,$page,$targetpage);*/

//echo mysqli_num_rows($result);

while($resultlist2= mysqli_fetch_array($result)){


$no=1; 
 $select='*'; 
$where=''; 
$hotelId=decode($_GET['hotelid']);
$where='where id="'.$resultlist2["supplierId"].'" '.$mainwhere.''; 

$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module=packagehotelmaster&supplier=1&hotelid='.$hotelId.'&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';
$rs=GetRecordList($select,_SUPPLIERS_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$supplr_id = $resultlists['id'];
if($resultlist2['deletestatus']=='1'){ $status='0'; }else{ $status='1'; }
 
?>
  <tr>
    <td align="left"><a href="showpage.crm?module=suppliers&view=yes&id=<?php echo encode($resultlists['id']); ?>" target="_blank"><?php echo strip($resultlists['name']); ?></a> </td>
    <td align="left"><?php echo getDestination($resultlists['destinationId']); ?></td>
    <td align="left"><?php echo strip($resultlists['contactPerson']); ?></td>
    <!-- <td align="left"><?php //echo getCityName($resultlists['cityId']); ?>, <?php //echo getStateName($resultlists['stateId']); ?>, <?php //echo getCountryName($resultlists['countryId']); ?></td> -->
    <td align="left">
      <?php if(!empty($resultlists['cityId'])){ echo getCityName($resultlists['cityId']);} else {echo getcity($supplr_id); } ?>,
       <?php if(!empty($resultlists['stateId'])){ echo getStateName($resultlists['stateId']);} else{echo getstate($supplr_id); } ?>,
        <?php if(!empty($resultlists['countryId'])){ echo getCountryName($resultlists['countryId']);} else {echo getcountry($supplr_id); } ?>    </td>

    <td align="left"><?php echo getPrimaryPhone($resultlists['id'],'suppliers'); ?></td>
    <td align="left"> <?php echo getPrimaryEmail($resultlists['id'],'suppliers'); ?> </td>
    <td align="center"><a href="showpage.crm?module=<?php echo $_GET['module'];?>&supplier=1&hotelid=<?php echo $_GET['hotelid']; ?>&id=<?php echo encode($resultlist2['id']); ?>&status=<?php echo $status; ?>"><?php if($resultlist2['deletestatus']=='0'){ $status2='Active';} else { $status2='Inactive';}?>
      <input name="addnewuserbtn" type="button" class="bluembutton" onclick="return confirm('Do you want to <?php if($resultlist2['deletestatus']=='0'){ echo 'Inactive';} else { echo 'Active';}?> this record?');"  value="<?php echo $status2;?>"/>
  </a></td>
    <td align="center"><a href="showpage.crm?module=<?php echo $_REQUEST['module']; ?>&view=yes&hotelId=<?php echo $_REQUEST['hotelid']; ?>&supplierId=<?php echo encode($resultlists['id']); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" value="View"/></a></td>
  </tr> 
  
  <?php $no++; }
  }
   ?>
</tbody></table>
<?php if($no==1){ ?>
<div class="norec">No <?php echo $pageName; ?></div>
<?php } ?>

<div class="pagingdiv">

    

    <table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;"><?php echo $no; ?> entries</td>
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
</div></form> </td>
  </tr>
</table>
<?php } 
else if($_REQUEST['supplier']=='' && $_REQUEST['page']=='addGallery' && $_REQUEST['d_id']!='' ) {
  ?>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
          
        <td width="91%" align="left" valign="top">
          <form id="listform" name="listform" method="get">
            <div class="rightsectionheader">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <div class="headingm" style="margin-left:30px;">
                      <a href="showpage.crm?module=packagehotelmaster"><i class="fa fa-arrow-left"></i></a>
                      Hotel Gallery
                      <div id="deactivatebtn" style="display:none;">
                        <?php if($deletepermission==1){ ?>
                        <input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="masters_alertspopupopen('action=mastersdelete&name=deleteGallery','600px','auto');" />
                        <?php } ?>
                      </div>
                    </div>
                  </td>
                  <td align="right">
                    <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td></td>
                      <?php if($addpermission==1){ ?>
                      <td style="padding-right:20px;">
                        <a href=""></a>
                      </td>
                      <?php } ?>
                      <?php if($importpermission==1){ ?>
                      <input type="button" name="Submit" value="Import" class="whitembutton" style="display: none;" />
                      <?php } ?>
                      <td >
                        
                      </td>
                      <!-- load alert box for destination -->
                      <?php if($addpermission==1){ ?>
                      <td style="padding-right:20px;">
                        <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Gallery"
                        onclick="masters_alertspopupopen('action=addeditGallery&galleryType=hotel&parentId=<?php echo $_REQUEST['d_id'];?>&module=<?php echo $_REQUEST['module'];?><?php echo ($_REQUEST['page']!='')? '&page='.$_REQUEST['page']:'';?>','800px','auto');" />
                      </td>
                      <?php } ?>
                    </tr>
                    
                  </table></td>
                </tr>
                
              </table>
            </div>
            <div id="pagelisterouter" style="padding-left:20px;">
              <input name="action" id="action" type="hidden" value="deleteGallery" />
              <input name="backpage" id="backpage" type="hidden" 
              value="<?php echo $_GET['module'];echo ($_GET['d_id'] !='')?'&page=addGallery&d_id='.$_GET['d_id']:''; ?>" />
              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
              <thead>
                <tr>
                  <th width="2%" align="center" valign="middle" class="header" ><?php if($editpermission==1){ ?> <input type="checkbox" id="checkAll"  name="checkedAll" onclick="checkallbox();" /><?php } ?>
                  <label for="checkAll"><span></span>&nbsp;</label></th>
                  <th align="left" class="header" >Name </th>
                  <th  align="left" class="header" >Image</th>
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
                 
                $where='where parentId = "'.$_REQUEST['d_id'].'" and galleryType="hotel" order by name desc';
                $page=$_GET['page'];
                
                $targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&';
                $rs=GetRecordList($select,'imageGallery',$where,$limit,$page,$targetpage);
                $totalentry=$rs[1];
                $paging=$rs[2];
                while($resultlists=mysqli_fetch_array($rs[0])){
                ?>
                <tr>
                 
                  <td width="6%" align="center" valign="middle"><?php if($editpermission==1){ ?><input type="checkbox" id="c<?php echo $no; ?>" name="check_list[]" class="chk"  value="<?php echo encode($resultlists['id']); ?>"/>
                  <label for="c<?php echo $no; ?>"><span></span>&nbsp;</label><?php } ?></td>

                  <td width="30%" align="left">
                    <div class="bluelink" onclick="masters_alertspopupopen('action=hotelrestriction&module=<?php echo $_REQUEST['module'];?><?php echo ($_REQUEST['page']!='')? '&page='.$_REQUEST['page']: '' ;?>&id=<?php echo $resultlists['id']; ?>&galleryType=hotel','800px','auto');" >
                      <?php echo $resultlists['title']; ?>
                      
                    </div>   
                  </td>
                  
                  <td width="40%" align="left">
                     <?php if($resultlists['name']!=''){ ?>
                      <img src="<?php echo $fullurl; ?>packageimages/_thumb/<?php echo $resultlists['name']; ?>" style="width: auto;"/>
                    <?php }else{ 
          echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>";
          } 
          ?>
                  </td>
                </tr>
                
                
                <?php $no++; } ?>
              </tbody>
            </table>
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
                </tbody>
                </table>
              </div>
            </div>
          </form>
        </td>
      </tr>
    </table>
 <?php 
} else { ?>
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
        <td><input name="keyword" type="text" class="topsearchfiledmain" id="keyword" style="width:150px;" value="<?php echo $_GET['keyword']; ?>" size="100" maxlength="100" placeholder="Enter Hotel Name"></td>
        <!--<td><input type="submit" name="Submit" value="Search" class="searchbtnmain"></td>
        <td  ><a href="<?php echo $fullurl; ?>travrmimports/hotel-import.xls" class="bluembutton"  style="background-color: #1fc277 !important; border: 1px solid #1fc277 !important;"><i class="fa fa-download" aria-hidden="true"></i> Download Format</a></td>
    <td  ><div class="bluembutton" id="importbutton"><i class="fa fa-upload" aria-hidden="true"></i> Import Excel</div></td>
    <td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="masters_alertspopupopen('action=addedit_<?php echo clean($_GET['module']); ?>&sectiontype=<?php echo clean($_GET['module']); ?>','800px','auto');" /></td>-->
      <td><input name="startDate" type="text"  class="topsearchfiledmain" id="startDate_r" style="width:80px;" size="6" placeholder="start"  value="<?php if($_GET['startDate']!=''){ echo  date('d-m-Y', strtotime($_GET['startDate'])); }else{ echo date('d-m-Y'); } ?>" /></td>
      <td><input name="endDate" type="text"  class="topsearchfiledmain" id="endDate_r" style="width:80px;" size="6" placeholder="To" value="<?php if($_GET['endDate']!=''){ echo  date('d-m-Y', strtotime($_GET['endDate'])); }else{ echo date('d-m-Y', strtotime('+2 year')); } ?>" /></td>      
      <td><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" />
    <input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td> 
      <td style="padding-right:20px;">&nbsp;</td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter" style="padding-left:0px;">
<input name="action" id="action" type="hidden" value="deleteextraquotation" />
<input name="module" id="module" type="hidden" value="<?php echo clean($_GET['module']); ?>" />
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
       <td class="header" align="left">Sr.</td>
      <th width="9%" align="left" class="header" >Image</th>
      <th width="12%" align="left" class="header" >Hotel Chain Name</th>
      <th width="12%" align="left" class="header" >Name&nbsp;</th>
    <!--<th align="left" class="header" >GSTN </th>-->
   <th width="8%"  align="left" class="header" >Location </th>
  <!-- <th width="11%"  align="left" class="header" >Cont.&nbsp;Person</th>
   <th width="9%"  align="left" class="header" >Phone </th>
   <th width="9%"  align="left" class="header" >Email </th>
   <th width="11%"  align="left" class="header" >Address </th>-->
   <th width="9%"  align="left" class="header" >Category</th>
   <th width="11%"  align="left" class="header" >From&nbsp;Date</th>
   <th width="9%"  align="left" class="header" >To&nbsp;Date</th>
   <th width="7%"  align="left" class="header" >Reason</th>
   <th width="7%"  align="left" class="header" >Operation&nbsp;Restriction</th>
     <!--<th width="8%"  align="center" class="header" >Supplier</th>-->
   </tr>
   </thead>

 


 

  <tbody>
<?php 
$startDate=$_GET['startDate'];
$endDate=$_GET['endDate'];
?>      
  <?php

$no=1; 
$select='*'; 
$where=''; 
$rs='';  
$wheresearch=''; 
$limit=clean($_GET['records']);

// hotel opration restriction search related code
if($_GET['keyword']!=''){
$wheresearch=' and hotelName like "%'.$_GET['keyword'].'%" or  hotelCity like "%'.$_GET['keyword'].'%" or  hotelAddress like "%'.$_GET['keyword'].'%" or  hotelCategoryName like "%'.$_GET['keyword'].'%" '; 
}else{
$wheresearch=' and hotelName!="" ';
}

$whereFromDate='';
if($startDate!='' && $endDate!=''){
$startDate = date('Y-m-d', strtotime( $startDate ));
$endDate = date('Y-m-d', strtotime( $endDate ));
$whereFromDate=' and id in (select hotelId from hoteloperationRestriction where 1 and startDate BETWEEN "'.date('Y-m-d',strtotime($startDate)).'" and "'.date('Y-m-d',strtotime($endDate)).'" )';

    
}    


$where='where 1  '.$whereFromDate.'  '.$wheresearch.' order by id desc'; 
$page=$_GET['page'];
 
$targetpage=$fullurl.'showpage.crm?module='.$_GET['module'].'&records='.$limit.'&keyword='.$_GET['keyword'].'&'; 
$rs=GetRecordList($select,_PACKAGE_BUILDER_HOTEL_MASTER_,$where,$limit,$page,$targetpage); 
$totalentry=$rs[1]; 
$paging=$rs[2]; 
while($resultlists=mysqli_fetch_array($rs[0])){ 
$dateAdded=clean($resultlists['dateAdded']);
$modifyDate=clean($resultlists['modifyDate']);

//============get hotel restriction===========//
$select4='*';    
$where4='hotelId="'.$resultlists['id'].'"';
$rs4=GetPageRecord($select4,'hoteloperationRestriction',$where4); 
$rowNum = mysqli_num_rows($rs4);
$restrictionList=mysqli_fetch_array($rs4);

$rsHotel=GetPageRecord('*','chainhotelmaster',' id="'.$resultlists['hotelChain'].'" order by id asc '); 
$hotelData=mysqli_fetch_array($rsHotel);
?>
  <tr>
       <td><?=$no?></td>
    <td align="left"><?php if($resultlists['hotelImage']!=''){ ?><img src="packageimages/<?php echo $resultlists['hotelImage']; ?>" width="75" height="58" /><?php }else{ echo "<img src='".$fullurl."images/hotelthumbpackage.png' width='75' height='58'>"; } ?></td>
    <td align="left"><?php echo $hotelData['name']; ?></td>
    <td align="left"> <?php echo $resultlists['hotelName']; ?>  </td>
<!--  <td align="left"><?php echo $resultlists['gstn']; ?></td>
--> <td align="left"><?php echo $resultlists['hotelCity']; ?>,&nbsp;<?php echo $resultlists['hotelCountry']; ?></td>
<!--  <td align="left"><?php echo $resultlists['contactPerson']; ?></td>
  <td align="left"><?php echo $resultlists['supplierPhone']; ?></td>
  <td align="left"><?php echo $resultlists['supplierEmail']; ?></td>
  <td align="left"><?php echo $resultlists['hotelAddress']; ?></td>-->
  <td align="left"><?php 
        $rs3=GetPageRecord('*','hotelCategoryMaster',' id="'.$resultlists['categoryId'].'" order by id desc'); 
        $resListing3=mysqli_fetch_array($rs3);
        echo $hotelRoomsType=$resListing3['name'];
  ?></td>
  <td align="left"><?php if($restrictionList['startDate']!='1970-01-01' && $restrictionList['startDate']!=''){ echo date('d-m-Y',strtotime($restrictionList['startDate'])); } ?></td>
  <td align="left"><?php if($restrictionList['endDate']!='1970-01-01' && $restrictionList['startDate']!=''){ echo date('d-m-Y',strtotime($restrictionList['endDate'])); } ?></td>
    <td align="left"><a href="showpage.crm?module=operationrestrictions&hotelid=<?php echo encode($resultlists['id']); ?>"><?php echo '('.$rowNum.')'.$restrictionList['reason']; ?></a></td>
  <td align="center"><a  href="#" onclick="masters_alertspopupopen('action=hotelrestriction&module=<?php echo $_REQUEST['module'];?>&id=<?php echo $resultlists['id']; ?>','600px','auto');"><input name="addnewuserbtn" type="button" class="bluembutton" value="+&nbsp;Operation&nbsp;Restriction"/></a></td>


<!--<td align="center"><a href="showpage.crm?module=packagehotelmaster&supplier=1&hotelid=<?php echo encode($resultlists['id']); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" value="View"/></a></td>-->
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
</div></form> </td>
  </tr>
</table>
<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="importfrm" id="importfrm"  target="actoinfrm" style="display:none;">

 <input name="importpackagehotel" id="importpackagehotel" type="hidden" value="Y" /> <input name="importpackagehotelModule" id="importpackagehotelModule" type="hidden" value="<?php echo clean($_GET['module']); ?>" />

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
<?php }?>

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
<script>
$('#startDate_r').Zebra_DatePicker({
      format: 'd-m-Y',  
      pair: $('#endDate_r'),
   });

$('#endDate_r').Zebra_DatePicker({
format: 'd-m-Y',
});
</script>
