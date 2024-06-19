<?php
include "inc.php"; 
include "config/logincheck.php"; 

if($_GET['dltid']!='' && $_GET['id']!=''){ 

$select='*'; 
$where5='id='.$_GET['dltid'].''; 
$rs=GetPageRecord($select,_CHECK_TODOLIST_MASTER_,$where5); 
$exe=mysqli_fetch_array($rs); 
$queryid = $exe['queryId'];
$times = $exe['follow_upTime']; 
$dates = $exe['follow_upDate']; 

$where1='serviceId='.$queryid.' and taskId="todo-List" and toDoDate="'.$dates.'" and toDotime="'.$times.'"  ';
deleteRecord(_TO_DO_TIMELINE_,$where1); 
$where=' id='.$_GET['dltid'].' '; 
deleteRecord(_CHECK_TODOLIST_MASTER_,$where);
}

 

if($_GET['editidstaus']!='' && $_GET['id']!='' && $_GET['status']!=''){ 
$namevalue ='statusId="'.$_GET['status'].'"';  

$where='id="'.$_GET['editidstaus'].'" and queryId="'.$_GET['id'].'"';  
$update = updatelisting(_CHECK_TODOLIST_MASTER_,$namevalue,$where); 
} 
 
$id=$_GET['id'];
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=$id; 
$where='queryId='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$queryId=mysqli_fetch_array($rs);  
?>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script>
 $(document).ready(function() {  

 $('#fromDate').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});

$('#actionDated').Zebra_DatePicker({ 
  format: 'd-m-Y',  
});    
  });
  
</script>
<div style="padding:15px;">
  <style>
.gridlable{width:100% !important;}
.gridfield{width:100% !important;}
.Zebra_DatePicker_Icon_Wrapper{width:100% !important;}
.selectbox{
 border-radius:2px;
 height:28px;
 padding:3px 10px;
 border-color: #ccc;
}
.inputbox{

    border-radius: 2px;
    height: 23px;
    width: 94%!important;
    border: 1px solid #ccc;

}
.maintable th {
	    padding-left: 0px;
}
.maintable  td {
    padding: 1px!important;
} 
.maintable .header {
    padding-bottom: 15px;
    padding-left: 0px;
}

</style>
  <div style="margin-top: 10px; padding: 10px !important; border: 1px solid #80808038; <?php if($_REQUEST['editid']!=''){ ?>padding:5px; border-bottom:2px #FF9900 solid;<?php } ?>">
    <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addflight2222" target="actoinfrm"  id="addflight2222">
      <div style="margin-bottom:50px;">
        <h2 style="margin-top: 20px; color: #233a49;">Final Quotation</h2>
        <table width="100%" border="0" cellpadding="2" cellspacing="0" class="tablesorter gridtable">
          <thead>
            <tr width="100%">
              <th width="10%" align="left" class="header" style="padding-left: 0px;">&nbsp;
                <div align="left">Quotation&nbsp;Id.</div></th>
              <th width="10%" align="left" class="header" style="padding-left: 0px;">&nbsp;
                <div align="left">From&nbsp;Travel</div></th>
              <th width="10%" align="left" class="header" style="padding-left: 0px;">&nbsp;
                <div align="left">To&nbsp;Travel </div></th>
              <th width="8%" align="left" class="header" style="padding-left: 0px;"><div align="left">Duration</div></th>
              <th align="center" class="header" style="padding-left: 0px;"><div align="left">Action</div></th>
            </tr>
          </thead>
          <tbody>
            <?php 
$rs=GetPageRecord('*',_QUERY_MASTER_,'id='.$id.'');  
    $resultpage=mysqli_fetch_array($rs); 
	 
$where='1 and queryId='.$id.' and status=1 and deletestatus=0'; 
$quotationDataq=GetPageRecord('*',_QUOTATION_MASTER_,$where); 
while($resultlists=mysqli_fetch_array($quotationDataq)) {

$makeQueryId = makeQuotationId($resultlists['id']);
 
?>
            <tr style="background-color: #deffe0; border: 3px solid #6cc791;">
              <td align="left"><div align="left"><a 
	<?php if($resultlists['lostStatus']==1){ ?> 
	style="color: #ffffff;" 
	<?php }else{ 
	if($resultlists['saveQuotaiton']==1 || $resultlists['saveQuotaiton']==0){ ?> 
	href="showpage.crm?module=quotations&view=yes&id=<?php echo encode($resultlists['id']); ?>" 
	<?php }else{ ?> 
	onclick="alert('Edit is not allowed...!');" 
	<?php } 
	} ?> 
	><?php echo $makeQueryId;  if($resultlists['status']==1){ echo " | Final"; }?></a> </div></td>
              <td width="10%" align="left"><div align="left">
                  <?php if($resultpage['dayWise']==1){ ?>
                  <?php echo date('d-m-Y',strtotime($resultlists['fromDate'])); ?>
                  <?php } ?>
                </div></td>
              <td width="10%" align="left"><div align="left">
                  <?php if($resultpage['dayWise']==1){ ?>
                  <?php echo date('d-m-Y',strtotime($resultlists['toDate'])); ?>
                  <?php } ?>
                </div></td>
              <td width="8%" align="left"><div align="left">
                  <?php  if($resultpage['dayWise']!=2){  ?>
                  <?php echo $resultlists['night']; ?>&nbsp;N/&nbsp;<?php echo $resultlists['night']+1; ?>&nbsp;D
                  <?php } else{ ?>
                  <?php echo ($resultlists['night']+1); ?>&nbsp;Days
                  <?php }  ?>
                </div></td>
              <td width="9%" align="center"><div class="saveasbtn"  style=" color: #fff !important; border: 1px #e17c00 solid !important; background-color: #e17c00 !important;" onclick="alertspopupopen('action=finalquotetodo&queryId=<?php echo encode($_REQUEST['id']); ?>&quotationId=<?php echo $resultlists['id']; ?>','1000px','auto');" >
                  <div align="left">Add&nbsp;Task</div>
                </div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <table width="100%" border="0" cellpadding="10" cellspacing="0" class="tablesorter gridtable maintable" id="listmainlist">
        <thead>
          <tr>
            <th width="12%" align="left" class="header">Task&nbsp;Title</th>
            <th width="12%" align="left" class="header">Assign&nbsp;To</th>
            <th width="11%" align="left" class="header">Action&nbsp;Date</th>
            <th width="11%" align="left" class="header">Action&nbsp;Time</th>
            <th width="11%" align="left" class="header">Completed&nbsp;Date</th>
            <th width="11%" align="left" class="header">Completed&nbsp;Time</th>
            <th width="7%" align="left" class="header">Remarks</th>
            <th width="5%" align="left" class="header">Status</th>
            <th width="9%" align="left" class="header">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
	$s=1;
	$select1=''; 
	$wher1=''; 
	$rs1='';  
	$select1='*';    
	$where1='  queryId="'.$id.'"  order by actionDate asc';  
	$rs1=GetPageRecord($select1,_CHECK_TODOLIST_MASTER_,$where1); 
	while($dmcroommastermain=mysqli_fetch_array($rs1)){   
	?>
          <tr>
            <td align="left" style="border-left:5px solid #<?php if($dmcroommastermain['statusId']==1){ echo 'CC3300'; } if($dmcroommastermain['statusId']==2){ echo 'FF6600'; }if($dmcroommastermain['statusId']==3){ echo '82b767'; }  ?>;"><div style="margin-left:5px;"><?php echo $dmcroommastermain['taskTitle']; ?></div></td>
            <td align="left"><?php 
	
	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$where='id='.$dmcroommastermain['assignTo'].''; 
	$rs=GetPageRecord($select,_USER_MASTER_,$where); 
	$assignTo=mysqli_fetch_array($rs);
	
	echo $assignTo['firstName'].'   '.$assignTo['lastName'];
	 
		 ?></td>
            <td align="left"><?php echo date('d-m-Y',strtotime($dmcroommastermain['actionDate']));?></td>
            <td align="left"><?php echo $dmcroommastermain['actionTime'];?></td>
            <td align="left"><?php if($dmcroommastermain['completionDate']!="" && $dmcroommastermain['completionDate']!="0000-00-00" && $dmcroommastermain['completionDate']!="1970-01-01"){ echo date('d-m-Y',strtotime($dmcroommastermain['completionDate'])); }?></td>
            <td align="left"><?php echo $dmcroommastermain['completedTime'];?></td>
            <td align="left"><div style="width:50px;"><?php echo $dmcroommastermain['remark'];?></div></td>
            <td align="left" style="cursor:pointer;" onClick="alertspopupopen('action=changetodolidtstatus&queryId=<?php echo $_GET['id']; ?>&editstatusid=<?php echo $dmcroommastermain['id']; ?>','450px','auto');"><?php if($dmcroommastermain['statusId']==2){ echo '<div class="revertquery" style="color: #FFFFFF; padding: 5px 8px; float: left; border-radius: 4PX; text-align: center; width: 50px; font-size: 10px;">In Process</div>'; }  ?>
              <?php if($dmcroommastermain['statusId']==1){ echo '<div class="wonquery" style="background-color:#CC3300;color: #FFFFFF; padding: 5px 8px; float: left; border-radius: 4PX; text-align: center; width: 50px; font-size: 10px;">Pending</div>'; }  ?>
              <?php if($dmcroommastermain['statusId']==3){ echo '<div class="wonquery" style="background-color:#82b767;color: #FFFFFF; padding: 5px 8px; float: left; border-radius: 4PX; text-align: center; width: 50px; font-size: 10px;">Done</div>'; }  ?></td>
            <td align="left"><a onClick="editloadtodolistfun('<?php echo $dmcroommastermain['id']; ?>');">Edit</a> | <a style="color:#FF0000 !important;  font-size:12px;" onClick="if(confirm('Are you sure you want delete this entry?')) deltloadtodolistfun('<?php echo $dmcroommastermain['id']; ?>');" >Delete</a></td>
          </tr>
          <?php  $s++; } ?>
        </tbody>
        <tfoot>
          <?php 
if($_REQUEST['editid']!=''){
	$fromDate='';
	$select=''; 
	$where=''; 
	$rs='';   
	$select='*'; 
	$id=$id; 
	$where='id='.$_REQUEST['editid'].''; 
	$rs=GetPageRecord($select,_CHECK_TODOLIST_MASTER_,$where); 
	$editchecklist=mysqli_fetch_array($rs); 
	$actionDate=date('Y-m-d',strtotime($editchecklist['actionDate']));
	$completionDate=date('Y-m-d',strtotime($editchecklist['completionDate']));
	$contactPersan=strip($editchecklist['contactPersan']);
	$contactPersanno=strip($editchecklist['contactPersanno']);
	$statusId=strip($editchecklist['statusId']);
	$remark=strip($editchecklist['remark']);  
	$editassignTo = strip($editchecklist['assignTo']);
}
?>
          <tr>
            <td height="91" width="200px"><div class="griddiv" style="width: 100% !important;">
                <input name="taskTitle" type="text" class="gridfield  validate inputbox" id="taskTitle" value="<?php echo $editchecklist['taskTitle']; ?>" displayname="Task Title"/>
                <select id="tourType2" name="tourType2" class="gridfield inputbox" autocomplete="off" style="width: 100% !important; display:none;">
                  <option value="0">Select</option>
                  <?php 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$where='1'; 
$rs=GetPageRecord($select,_TASK_MASTER_,$where); 
while($taskmaster=mysqli_fetch_array($rs)) {
 ?>
                  <option value="<?php echo $taskmaster['id']; ?>" <?php if($editchecklist['taskId']==$taskmaster['id']){ ?>selected="selected"<?php } ?>><?php echo $taskmaster['taskName']; ?></option>
                  <?php }  ?>
                </select>
              </div></td>
            <td><div class="griddiv"><img src="images/userrole.png" onclick="function_assignTo();" style="position: absolute; cursor: pointer; right: 6px; top: 44px; width: 18px;"  />
                <label>
                <div id="selectOpsPerson">
                  <input name="ownerName" type="text" class="gridfield  validate inputbox" id="ownerName" value="<?php echo getUserName($editassignTo); ?>" readonly="true" displayname="Assign To" autocomplete="off" onclick="function_assignTo();" />
                  <input name="assignTo" type="hidden" id="assignTo" value="<?php echo encode($editassignTo); ?>" />
                </div>
                </label>
              </div>
              <script type="text/javascript">
		function function_assignTo(){
			var lang = $('#language').val(); 
			alertspopupopen('action=selectParent&userType=1','600px','auto');
		}
	   </script>
            </td>
            <td><div class="griddiv">
                <input name="actionDate" type="date" class="gridfield  validate inputbox" id="actionDate"   value="<?php echo $actionDate; ?>" displayname="Followup Date" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" autocomplete="off"  />
              </div></td>
            <td width="90px"><div class="griddiv">
                <select name="actionTime" id="actionTime" class="gridfield validate inputbox" displayname="Followup Time">
                  <?php 
	 $start=strtotime('00:00'); 
	 $end=strtotime('23:59'); 
	for ($i=$start;$i<=$end;$i = $i + 15*60){ ?>
                  <option value="<?php echo date('g:i A',$i); ?>" <?php if(date('g:i A',strtotime($editchecklist['actionTime']))==date('g:i A',$i)){ ?> selected="selected" <?php } ?>><?php echo date('g:i A',$i); ?></option>
                  <?php } ?>
                </select>
              </div></td>
            <td width="130px"><div class="griddiv">
                <input name="completionDate" type="date" class="gridfield inputbox" value="<?php echo $completionDate; ?>" maxlength="200"   displayname="Completed&nbsp;Date" min="<?php echo date('Y');?>-01-01" max="<?php echo date('Y',strtotime("+1 years"));?>-12-31" autocomplete="off" />
              </div></td>
            <td width="90px"><div class="griddiv">
                <select name="completionTime" id="completionTime" class="gridfield inputbox">
				<option value="">Time</option>
                  <?php 
	 $start=strtotime('00:00'); 
	 $end=strtotime('23:59'); 
	for ($i=$start;$i<=$end;$i = $i + 15*60){ ?>
                  <option value="<?php echo date('g:i A',$i); ?>" <?php if($editchecklist['completedTime']!=""){ if(date('g:i A',strtotime($editchecklist['completedTime']))==date('g:i A',$i)){ ?> selected="selected" <?php } } ?>><?php echo date('g:i A',$i); ?></option>
                  <?php } ?>
                </select>
              </div></td>
            <td width="90px"><div class="griddiv">
                <input name="remark" type="text" class="gridfield inputbox" id="remark"  maxlength="200" displayname="Description"  autocomplete="off"  value="<?php echo $remark; ?>" />
              </div></td>
            <td width="130px"><div class="griddiv" >
                <select id="statusId" name="statusId" class="gridfield validate inputbox" displayname="Status" autocomplete="off" style="width: 90px !important; margin-left: 10px;">
                  <option value="0"<?php if($editchecklist['statusId']==0){ ?>selected="selected"<?php } ?>>Select</option>
                  <option value="1" <?php if($editchecklist['statusId']==1){ ?>selected="selected"<?php } ?>>Pending</option>
                  <option value="2" <?php if($editchecklist['statusId']==2){ ?>selected="selected"<?php } ?>>In Process</option>
                  <option value="3" <?php if($editchecklist['statusId']==3){ ?>selected="selected"<?php } ?>>Done</option>
                </select>
              </div></td>
            <td><input name="action" id="action" type="hidden" value="addtodolist" />
              <input name="queryId" id="queryId" type="hidden" value="<?php echo $_GET['id']; ?>" />
              <input name="editid" id="editid" type="hidden" value="<?php echo $_REQUEST['editid']; ?>" />
              <?php if($_REQUEST['editid']!=''){ ?>
              <input name="addnewuserbtn2" type="button" class="greenbuttonx2" id="addnewuserbtn2" value="Update" style="margin-right: 0px; padding: 2px 10px; border-radius: 4px;" onclick="formValidation('addflight2222','submitbtn','0');"></td>
            <?php } ?>
          </tr>
        </tfoot>
      </table>
      <div style="padding:15px;">
        <style>
	.btnstatus{ 
	border-radius: 7px;
    background-color: #4CAF50;
    border: solid 0px;
	color: #fff;
    padding: 4px 10px;
	outline: 0px;
	width: 63px;
	} 
	.saveasbtn2 {
    border: 1px #17651a solid !important;
    padding: 5px !important;
    border-radius: 2px !important;
    color: #17651a !important;
    background-color: #d3fdc9 !important;
    cursor: pointer;
    font-weight: 500;
    float: left;
    width: auto !important;
    font-size: 12px;
}
   .saveasbtn {
                border: 1px #cecece solid !important;
                padding: 5px !important;
                border-radius: 2px !important;
                color: #3c3c3c !important;
                background-color: #dcdcdc !important;
                cursor: pointer;
                font-weight: 500;
                float: left;
                width: auto !important;
                font-size: 12px;
            } 
.gridtable td {
    padding: 7px 2px !important; 
}
</style>
      </div>
    </form>
  </div>
</div>  
<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper{width:100% !IMPORTANT;}
.gridtable .header {
    padding-bottom: 15px;
}
.inputbox {
    border-radius: 2px;
    height: 23px;
    width: 94%!important;
    border: 1px solid #ccc;
    padding: 0px 2px;
} 
</style>