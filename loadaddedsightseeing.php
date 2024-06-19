<?php
include "inc.php"; 
include "config/logincheck.php";
if($_REQUEST['nights']!=''){
$nights=$_REQUEST['nights'];
} else { 
$nights=0;
}
if($_REQUEST['action']=='addsinghtseeing'){
$selectedNights = addslashes($_REQUEST['selectedNights']);
$sightseeingName = addslashes($_REQUEST['sightseeingName']);
$sightseeingCost = addslashes($_REQUEST['sightseeingCost']);
$sightseeingId = addslashes($_REQUEST['sightseeingId']); 
$sightseeingstartTime = strtotime(date('d-m-Y').' '.$_REQUEST['sightseeingstartTime']); 
$sightseeingendTime = strtotime(date('d-m-Y').' '.$_REQUEST['sightseeingendTime']); 
$sightseeingType = addslashes($_REQUEST['sightseeingType']);
$sightseeingComments = addslashes($_REQUEST['sightseeingComments']);
$duration = addslashes($_REQUEST['duration']);
$editId = decode($_REQUEST['editId']);

$namevalue ='sightseeingNights="'.$selectedNights.'",sightseeingName="'.$sightseeingName.'",sightseeingCost="'.$sightseeingCost.'",sightseeingId="'.$sightseeingId.'",startTime="'.$sightseeingstartTime.'",endTime="'.$sightseeingendTime.'",sightseeingType="'.$sightseeingType.'",remarks="'.$sightseeingComments.'",packageId="'.$editId.'",duration="'.$duration.'"'; 
addlisting('packageBuilderSightseeing',$namevalue); 
}
if($_REQUEST['deleteid']!='' && $_REQUEST['action']=='deletesinghtseeing'){ 
$sql_del="delete from packageBuilderSightseeing  where id='".$_REQUEST['deleteid']."'";   
mysqli_query(db(),$sql_del) or die(mysqli_error());
}
?>

<?php 
$selects=''; 
$wheres=''; 
$rss='';  
$selects='*';    
$wheres=' packageId='.$_REQUEST['packageId'].' order by id asc';  
$rss=GetPageRecord($selects,'packageBuilderSightseeing',$wheres); 
while($resListingSight=mysqli_fetch_array($rss)){  
?><div  class="hotellistmain" style="position:relative;">
<i class="fa fa-trash dicon" onclick="deletesightseeingmain('<?php echo strip($resListingSight['id']); ?>');"></i>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
      <tr>
        <td colspan="4" align="left" valign="top" style="font-size:16px; font-weight:500;"><?php echo strip($resListingSight['sightseeingName']); ?></td>
      </tr>
      <tr>
        <td width="25%" align="left" valign="top"><strong>Nights:</strong> <?php echo $resListingSight['sightseeingNights']; ?> </td>
        <td width="25%" align="left" valign="top"><strong>Sightseeing Type:</strong> <?php  if($resListingSight['sightseeingType']==1){ echo 'SIC'; } if($resListingSight['sightseeingType']==2){ echo 'Private'; } ?> </td>
        <!--<td width="20%" align="left" valign="top"><strong>Start Time:</strong><?php echo date('g:i A',$resListingSight['startTime']);  ?> </td>
        <td width="30%" align="left" valign="top"><strong>End Time:</strong> <?php echo date('g:i A',$resListingSight['endTime']); ?> </td>-->
		  <td width="30%" align="left" valign="top"><strong>Duration:</strong> <?php echo $resListingSight['duration']; ?> </td>
		  <td width="30%" align="left" valign="top">&nbsp;</td>
      </tr>
     
    <?php if($resListingSight['remarks']!=''){ ?> <tr>
        <td colspan="4" align="left" valign="top"><strong>Comments:</strong> <?php echo strip($resListingSight['remarks']); ?></td>
    </tr>
      <?php } ?>
  </table>
</div>
<?php  } ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" style="padding: 10px; background-color: #cccccc26; border: 1px #cccccc80 solid;">
      <tr>
        <td width="14%" align="left" valign="top"><div class="griddiv"><label>
	<div class="gridlable">Days  <span class="redmind"></span>  </div>
<select name="selectedsightseeingNights[]" size="1" multiple="multiple" class="select2" id="selectedsightseeingNights" displayname="Nights" autocomplete="off" style="width:200px;"  >
 
<?php 
$havenight='';
$select='*';      
$where='  packageId='.$_REQUEST['packageId'].' order by id asc';   
$rs=GetPageRecord($select,'packageBuilderSightseeing',$where); 
while($resListing=mysqli_fetch_array($rs)){
$havenight.=$resListing['sightseeingNights'];
}
for ($x = 1; $x <= $nights; $x++) {
  
if (strpos($havenight, ''.$x.'') !== false) { 
} else  {
?>
<option value="<?php echo $x; ?>"><?php echo $x; ?></option>
<?php } } ?>
 
</select>
	 
	</label>
<script>
function calculatemaincost(){
var flightCost = Number($('#flightCost').val());
var visaCost = Number($('#visaCost').val());
var landPackage = Number($('#landPackage').val()); 
var remark = Number($('#remark').val()); 
var remarkType = Number($('#remarkType').val()); 
$('#quotationPrice').val(Number(flightCost+visaCost+landPackage));
var quotationPrice = Number($('#quotationPrice').val()); 
if(remarkType==1){
var quotationPriceremark = Number(quotationPrice*remark/100);
$('#totalPrice').val(Number(quotationPriceremark+quotationPrice));
}
 
if(remarkType==2){
var quotationPriceremark = Number(quotationPrice+remark);
$('#totalPrice').val(Number(quotationPriceremark));
}
}
</script>
	</div></td>
        <td width="17%" align="left" valign="top"><div class="griddiv" style="overflow:visible;"><label>
	<div class="gridlable" style="position:relative;">Sightseeing Name    <span class="redmind" style="    top: 53px;"></span> </div>
	<input name="sightseeingName" type="text" class="gridfield" id="sightseeingName" maxlength="100" displayname="Sightseeing Name" style="width:200px;"  onkeyup="sightseeingsearchinnerfun();" autocomplete="off"/>
	<div class="elsearchbox" id="sightseeingsearchinner" style="display:none;">
	
	</div>
	<script>
	function sightseeingsearchinnerfun(){
	var sightseeingName = encodeURIComponent($('#sightseeingName').val());
	$('#sightseeingsearchinner').load('sightseeingsearchinner.php?sightseeingName='+sightseeingName);
	}
	
	function fillsightseeingName(name,id){ 
	$('#sightseeingName').val(name);
	$('#sightseeingId').val(id);
	$('#sightseeingsearchinner').hide();
	}
	</script>
	</label>  <input name="sightseeingId" type="hidden" id="sightseeingId" value="0" /> 
	</div></td>
         <td width="8%" align="left" valign="top"><div class="griddiv" style="overflow:visible;"> <label>
	<div class="gridlable"style="position:relative;">Sightseeing Type <span class="redmind" style="top: 53px;"></span> </div>
	<select id="sightseeingType" name="sightseeingType"  class="gridfield" displayname="Sightseeing Type" autocomplete="off" style="width:100px;" >
	<option value="0">Select</option> 
	<option value="1">SIC</option> 
	<option value="2">Private</option> 
	</select>
	</label> 
	
        <td width="12%" align="left" valign="top"><div class="griddiv"  style="width: 103px !important;"><label>
	<div class="gridlable">Duration  </div>
		 <input name="duration" id="duration" type="text" class="gridfield" placeholder="Ex: 2 hours" />
	</label>
	</div></td>
	<td width="49%" align="left" valign="top"><div class="griddiv" style="overflow:visible; display:none;"><label>

	<div class="gridlable"style="position:relative;">Sightseeing Cost   <span class="redmind" style="top: 53px;"></span> </div>

	<input name="sightseeingCost" type="text" class="gridfield" id="sightseeingCost" maxlength="100" displayname="sightseeingCost" style="width:130px;" autocomplete="off"/>
	</label>
    </div></td>
	
	<!--<td align="left" valign="top"><div class="griddiv"  style="width: 103px !important;"><label>
	<div class="gridlable">Start Time  <span class="redmind"></span>  </div>
		<select id="sightseeingstartTime<?php echo $dayId; ?>" name="sightseeingstartTime" class="gridfield" autocomplete="off" style="padding:5px; border:1px solid #ccc;"  >  
		<option value="0" >Start Time</option> 
		<?php 
		$start=strtotime('00:00'); 
		$end=strtotime('23:30'); 
		for ($i=$start;$i<=$end;$i = $i + 15*60) 
		{ ?> 
		<option value="<?php echo date('g:i A',$i); ?>" ><?php echo date('g:i A',$i); ?></option>; 
		<?php  }  ?> 
		</select>
	</label>
	</div></td>-->
	
	<!--<td align="left" valign="top"><div class="griddiv" style="width: 103px !important;"><label>
	<div class="gridlable">End Time  <span class="redmind"></span>  </div>
		<select id="sightseeingendTime<?php echo $dayId; ?>" name="sightseeingendTime" class="gridfield" autocomplete="off"   style="padding:5px; border:1px solid #ccc;"   > 
		<option value="0" >End Time</option>
		<?php 
		$start=strtotime('00:00'); 
		$end=strtotime('23:30');  
		for ($i=$start;$i<=$end;$i = $i + 15*60) 
		{ ?> 
		<option value="<?php echo date('g:i A',$i); ?>" ><?php echo date('g:i A',$i); ?></option>
		<?php  }  ?> 
		</select>
	</label>
	</div></td> -->
      </tr>
      <tr>	 
      <!--<script type="text/javascript"> 
        tinymce.init({ 
        selector: "#sightseeingComments",  
        themes: "modern",    
        plugins: [  
        "advlist autolink lists link image charmap print preview anchor", 
        "searchreplace visualblocks code fullscreen"   
        ], 
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"  
        });  
    </script>-->
        <td colspan="3" align="left" valign="top"><div class="griddiv"><label>
	<div class="gridlable">Comments    </div>
	 <textarea name="sightseeingComments" id="sightseeingComments" cols="" rows="4" class="gridfield"></textarea>
	</label>
	</div></td>
        <td colspan="2" align="right" valign="bottom"><label>
          <input type="button" name="Submit" id="addsightseeingbtnmain" value="Add Sightseeing" style="border-radius: 3px; outline: 0px; cursor:pointer;  background-color: #0ba14e; color: white; outline: 0px; border: 0px; padding: 8px 25px;" onclick="savesightseeingfun();" />
        </label></td>
  </tr>
      
</table>
	
	<script>
	function savesightseeingfun(){ 
	var selectedNights = encodeURIComponent($('#selectedsightseeingNights').val());
	var sightseeingName = encodeURIComponent($('#sightseeingName').val());
	var sightseeingId = encodeURIComponent($('#sightseeingId').val()); 
	var sightseeingType = encodeURIComponent($('#sightseeingType').val());
	var duration = encodeURIComponent($('#duration').val());
	var sightseeingstartTime = encodeURIComponent($('#sightseeingstartTime').val());
	var sightseeingendTime = encodeURIComponent($('#sightseeingendTime').val());
	var sightseeingCost = encodeURIComponent($('#sightseeingCost').val());
	var sightseeingComments = encodeURIComponent($('#sightseeingComments').val());
	var editId = encodeURIComponent($('#editId').val());
	var nights = $('#nights').val(); 
	var textToAppend = "";
     var selMulti = $("#selectedNights option:selected").each(function(){
           textToAppend += (textToAppend == "") ? "" : ",";
           textToAppend += $(this).text();           
     });
 	 
	if(selectedNights!='' && sightseeingName!='' && sightseeingType!='' && editId!=''){
	$('#addsightseeingbtnmain').hide();
	$('#loadaddedsightseeing').load('loadaddedsightseeing.php?nights='+nights+'&selectedNights='+selectedNights+'&sightseeingCost='+sightseeingCost+'&sightseeingName='+sightseeingName+'&sightseeingId='+sightseeingId+'&sightseeingType='+sightseeingType+'&duration='+duration+'&sightseeingstartTime='+sightseeingstartTime+'&sightseeingendTime='+sightseeingendTime+'&sightseeingComments='+sightseeingComments+'&editId='+editId+'&nights='+nights+'&action=addsinghtseeing&packageId=<?php echo $_REQUEST['packageId']; ?>'); 
	}  
	}
	
	
function deletesightseeingmain(id){
var nights = $('#nights').val(); 
  if(confirm("Do you want to delete this sightseeing?")){
$('#loadaddedsightseeing').load('loadaddedsightseeing.php?nights='+nights+'&deleteid='+id+'&action=deletesinghtseeing&packageId=<?php echo $_REQUEST['packageId']; ?>');
} 
}	
	</script>
	<style>
	.elsearchbox {
    position: absolute;
    left: 0px;
    top: 54px;
    background-color: #FFFFFF;
    width: 100%;
    border: 1px #cccccc7d solid;
    padding: 10px;
    z-index: 9999;
    box-shadow: 2px 2px 5px #ccc;
}
 .elsearchbox a {
    display: block;
    padding: 10px 10px;
    border-bottom: 1px #cccccc7d solid;
    text-decoration: none;
    border-bottom: 1px #cccccc7d solid;
}
 .elsearchbox a:hover{    background-color: #cccccc24;}
.hotellistmain{    margin-bottom: 15px;
    border: 1px solid #daecf9;
    padding: 10px;
    width: 840px;
    background-color: #f6fdff;
    border-bottom: 2px #b8d7ff solid;}
	
	
.hotellistmain .dicon {
    position: absolute;
    right: 5px;
    top: 5px;
    padding: 10px;
    color: #CC0000;
    cursor: pointer;
    font-size: 20px;
}
	</style>
	
<script>
 $('.select2').select2();
</script>

