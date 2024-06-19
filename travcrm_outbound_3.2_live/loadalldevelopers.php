<?php 
include "inc.php"; 

$rs=GetPageRecord('*','companyDeveloperRemark',' developerName!="" '); 
$resultlist=mysqli_fetch_array($rs);
$count = mysqli_num_rows($rs);
if($count>0){
?>
<style>
.status{
    background-color: #e40c0c;
    padding: 5px;
    width: 61px;
    color: white;
    border: 1px solid #e40c0c;
    border-radius: 3px;
}
.status1{
    background-color: #008000;
    padding: 5px;
    width: 55px;
    color: white;
    border: 1px solid #008000;
    border-radius: 3px;
}
</style>
<table width="100%" border="1" cellspacing="0" cellpadding="10" bordercolor="#eee">
		   <thead>
		      <tr>
                 <th style="background-color: #4caf502e;border: 1px solid #4caf502e;">Developer Name</th>
                 <th style="background-color: #4caf502e;border: 1px solid #4caf502e;">Remark</th>
                 <th style="background-color: #4caf502e;border: 1px solid #4caf502e;">Action</th>
              </tr>
		   </thead>
		   <tbody>
<?php
while($resultlist=mysqli_fetch_array($rs)){
?>		   
		   
		        <tr>
                  <td style="background-color: #4caf5005;border: 1px solid #4caf502e;"><?php echo $resultlist['developerName']; ?></td>
                  <td style="background-color: #4caf5005;border: 1px solid #4caf502e;"><?php echo $resultlist['remarks']; ?></td>
                  <td align="center" style="background-color: #4caf5005;border: 1px solid #4caf502e;"><?php if($resultlist['status']=='0'){?><input id="status1<?php echo $resultlist['id']; ?>" class="status1" value="Accept" type="button" onclick="changestatus('0','<?php echo $resultlist['id']; ?>')"><?php }?><?php if($resultlist['status']=='1'){?><input id="status<?php echo $resultlist['id']; ?>" type="button" class="status" value="Rejected" onclick="changestatus('1','<?php echo $resultlist['id']; ?>')"><?php }?><div id="changestatus<?php echo $resultlist['id']; ?>"></div></td>
                </tr>
<?php } ?>				
		   </tbody>
</table>
<?php }?>
<div id="loadastaus"></div>
<script>
  function changestatus(status,id){
     if(status==0){
	    var statusd = 1;
	 }
	 if(status==1){
	    var statusd = 0;
	 }
	 $("#loadastaus").load('loadCompanyExtraactivuty.php?action=devstatus&status='+statusd+'&id='+id);
  }
</script>
