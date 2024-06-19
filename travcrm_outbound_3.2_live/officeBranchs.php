<link href="css/main.css" rel="stylesheet" type="text/css" />
<div style="margin-bottom: 30px;">
    <span style="font-size: 15px;font-weight: bold;">Office Address</span>
    <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add <?php echo 'Office'; ?>" onclick="alertspopupopen('action=OfficeAdress&sectiontype=<?php echo clean($_GET['module']); ?>','600px','auto');" />
</div> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="table table-striped table-bordered" id="mainsectiontable">
   <thead>
    
        <tr style="background: #8f8ff2;height: 22px;color: #f0e7e7;">
            <th align="left" class="header" ># </th>
            <th align="left" class="header" >Office Name </th>
            <th align="left" class="header" >country </th>
            <th align="left" class="header" >State</th>
            <th  align="left" class="header" >City </th>
            <th  align="left" class="header" >Postal/Zip</th>
            <th  align="left" class="header" >Branch Address </th>
            <th  align="left" class="header" >GSTN</th>
            <!-- <th  align="left" class="header" >PAN</th> -->
            <th  align="left" class="header " >Action</th>
        </tr>
   </thead>
  <tbody>
    <?php 
$n=1;
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='1 and status=1';  
$rs=GetPageRecord($select,'officeBranches',$where); 
while($resAddress=mysqli_fetch_array($rs)){ 

      
    ?>
    <tr>
        <td width="5%" align="left"><div><div style="width: 30px;height: 30px;background-color: #f9f9f9; <?php if($resAddress['primaryAddress']==1){ ?>background-image:url(images/tick.png); <?php }else{ echo $n; } ?>"></div><?php  if($resAddress['primaryAddress']==1){}else{echo $resAddress['id'];} ?></div></td>
        <td width="15%" align="left"><div><?php echo $resAddress['name']; ?></div></td>
        <td width="10%" align="left"><div><?php echo getCountryName($resAddress['countryId']); ?></div></td>
        <td width="10%" align="left"><div><?php echo getStateName($resAddress['stateId']); ?></div></td>
        <td width="10%" align="left"><div><?php echo getCityName($resAddress['cityId']); ?></div></td>
        <td width="10%" align="left"><div><?php echo $resAddress['pinCode']; ?></div></td>
        <td width="10%" align="left"><div><?php echo $resAddress['address']; ?></div></td>
        
        <td width="10%" align="left"><div><?php echo $resAddress['gstn']; ?></div></td>
        <!-- <td width="3%" align="left"><div><?php echo $resAddress['name']; ?></div></td> -->
        <td width="10%" align="left">
            <div>
            <a onclick="alertspopupopen('action=OfficeAdress&editid=<?php echo $resAddress['id']; ?>&id=<?php echo $resAddress['id']; ?>','700px','auto');"  style="color:#009900 !important; font-size:12px; position:absolute;">Edit</a>

            <a onclick="if(confirm('Are you sure you want delete this address?')) loadaddressw('<?php echo $resAddress['id']; ?>');"  style="color:#FF0000 !important; font-size:12px; right:10px; top:5; position:absolute;">Delete</a>
           
        </div></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<script> 

</script>