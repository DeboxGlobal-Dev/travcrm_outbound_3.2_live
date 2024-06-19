<?php
include "inc.php"; 
include "config/logincheck.php";
if($_REQUEST['nights']!=''){
$nights=$_REQUEST['nights'];
} else { 
$nights=0;
}


if($_REQUEST['action']=='addhotel'){
$selectedNights = addslashes($_REQUEST['selectedNights']);
$hotelName = addslashes($_REQUEST['hotelName']);
$hotelId = addslashes($_REQUEST['hotelId']);
$cityName = addslashes($_REQUEST['cityName']);
$cityIdhotel = addslashes($_REQUEST['cityIdhotel']);
$hotelCategoryMaster = addslashes($_REQUEST['hotelCategoryMaster']);
$roomType = addslashes($_REQUEST['roomType']);
$comments = addslashes($_REQUEST['comments']);
$editId = decode($_REQUEST['editId']);

$namevalue ='hotelNights="'.$selectedNights.'",hotelName="'.$hotelName.'",hotelId="'.$hotelId.'",cityName="'.$cityName.'",cityId="'.$cityIdhotel.'",categoryId="'.$hotelCategoryMaster.'",roomType="'.$roomType.'",remarks="'.$comments.'",packageId="'.$editId.'"'; 

addlisting('packageBuilderHotel',$namevalue); 
}



if($_REQUEST['deleteid']!='' && $_REQUEST['action']=='deletehotel'){ 
$sql_del="delete from packageBuilderHotel  where id='".$_REQUEST['deleteid']."'";   
mysqli_query(db(),$sql_del) or die(mysqli_error(db()));
}



?>


 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where='  packageId='.$_REQUEST['packageId'].' order by id asc';  
$rs=GetPageRecord($select,'packageBuilderHotel',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?><div  class="hotellistmain" style="position:relative;">
<i class="fa fa-trash dicon" onclick="deletehotelmain('<?php echo strip($resListing['id']); ?>');"></i>
<table width="100%" border="0" cellpadding="5" cellspacing="0"  >
      <tr>
        <td colspan="4" align="left" valign="top" style="font-size:16px; font-weight:500;"><?php echo strip($resListing['hotelName']); ?></td>
      </tr>
      <tr>
        <td width="25%" align="left" valign="top"><strong>Nights:</strong> <?php echo $resListing['hotelNights']; ?> </td>
        <td width="25%" align="left" valign="top"><strong>City:</strong> <?php echo strip($resListing['cityName']); ?> </td>
        <td width="20%" align="left" valign="top"><strong>Category:</strong>          <?php
$select1='*';   
$where1='id='.$resListing['categoryId'].'';  
$rs1=GetPageRecord($select1,'hotelCategoryMaster',$where1);  
$data=mysqli_fetch_array($rs1);
  echo strip($data['hotelCategory']); ?>&nbsp;Star        </td>
        <td width="30%" align="left" valign="top"><strong>Room Type:</strong>          <?php
$select1='*';   
$where1='id='.$resListing['roomType'].'';  
$rs1=GetPageRecord($select1,_ROOM_TYPE_MASTER_,$where1);  
$data=mysqli_fetch_array($rs1);
  echo strip($data['name']); ?>      </td>
      </tr>
     
    <?php if($resListing['remarks']!=''){ ?> <tr>
        <td colspan="4" align="left" valign="top"><strong>Comments:</strong> <?php echo strip($resListing['remarks']); ?></td>
    </tr>
      <?php } ?>
   </table>

</div>
<?php } ?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" style="padding: 10px; background-color: #cccccc26; border: 1px #cccccc80 solid;">
      <tr>
        <td align="left" valign="top"><div class="griddiv"><label>

	<div class="gridlable" style="margin-bottom: 7px;">Nights  <span class="redmind"></span>  </div>
<select name="selectedNights[]" size="1" multiple="multiple" class="select2" id="selectedNights" displayname="Nights" autocomplete="off" style="width:200px;"   >
 
<?php 
$havenight='';
$select='*';      
$where='  packageId='.$_REQUEST['packageId'].' order by id asc';   
$rs=GetPageRecord($select,'packageBuilderHotel',$where); 
while($resListing=mysqli_fetch_array($rs)){
$havenight.=$resListing['hotelNights'];
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
        <td align="left" valign="top"><div class="griddiv" style="overflow:visible;"><label>

	 <div class="gridlable" style="position:relative;">Hotel Name    <span class="redmind" style="    top: 53px;"></span> </div>

	<input name="hotelName" type="text" class="gridfield" id="hotelName" maxlength="100" displayname="Hotel Name"   onkeyup="hotelsearchinnerfun();" autocomplete="off"/>
	<div class="elsearchbox" id="hotelsearchinner" style="display:none;">
	
	
	
	
	
	</div>
	<script>
	function hotelsearchinnerfun(){
	var hotelName = encodeURIComponent($('#hotelName').val());
	$('#hotelsearchinner').load('hotelsearchinner.php?hotelName='+hotelName);
	}
	
	function fillhotelname(roomtypeid,name,id){ 
	$('#hotelName').val(name);
	$('#hotelId').val(id);
	
	$('#roomType').load('hotelrooms.php?roomtypeid='+roomtypeid);
	
	$('#hotelsearchinner').hide();
	}
	</script>
	</label>  <input name="hotelId" type="hidden" id="hotelId" value="0" /> 
	</div></td>
         <td align="left" valign="top"><div class="griddiv" style="overflow:visible;"><label>

	<div class="gridlable"style="position:relative;">City   <span class="redmind" style="top: 53px;"></span> </div>

	<input name="cityName" type="text" class="gridfield" id="cityName" maxlength="100" displayname="Pacakage Name"   onkeyup="citysearchinnerfun();" autocomplete="off"/>
	</label>
<div class="elsearchbox" id="citysearchinner" style="display:none; max-height: 190px; overflow: auto;width: 180px;">

<script>
	function citysearchinnerfun(){
	var cityName = encodeURIComponent($('#cityName').val());
	$('#citysearchinner').load('citysearchinner.php?cityName='+cityName);
	}
	
	function fillcityname(name,id){ 
	$('#cityName').val(name);
	$('#cityIdhotel').val(id);
	$('#citysearchinner').hide();
	}
	
	
	</script>
	
	</div>
	<input name="roomTypehotel" type="hidden" class="gridfield" id="roomTypehotel" value="">
	
	
	<input name="cityIdhotel" type="hidden" id="cityIdhotel" value="0" /></div></td>
        <td align="left" valign="top"><div class="griddiv"><label>

	<div class="gridlable">Category  <span class="redmind"></span>  </div>

	<select id="addhotelcat" name="addhotelcat"  class="gridfield" displayname="Hotel Category" autocomplete="off"     >
	 <option value="0">Select</option>
	 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
//$where=' id in (select roomType from '._DMC_ROOM_TARIFF_MASTER_.' where serviceid = '.$hotelId.') and deletestatus=0 and status=1 order by id asc';  
$where=' deletestatus=0 and status=1 order by id asc';  
$rs=GetPageRecord($select,'hotelCategoryMaster',$where); 
while($resListing=mysqli_fetch_array($rs)){  
?>
<option value="<?php echo strip($resListing['id']); ?>"  ><?php echo strip($resListing['hotelCategory']); ?> Star</option>
<?php } ?>
	
</select>
	</label>

	</div></td>
        <td align="left" valign="top"><div class="griddiv"><label>

	<div class="gridlable">Room Type     <span class="redmind"></span> </div>

	<select id="roomType" name="roomType"  class="gridfield" displayname="Room Type" autocomplete="off"     >
	 <option value="">Select</option>
</select>
	</label>

	</div></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top"><div class="griddiv"><label>

	<div class="gridlable">Comments    </div>

	 <textarea name="comments" id="comments" cols="" rows="4" class="gridfield"></textarea>

	</label>

	</div></td>
        <td colspan="2" align="right" valign="bottom"><label>
          <input type="button" name="Submit" id="addhotelbtnmain" value="Add Hotel" style="border-radius: 3px; outline: 0px; cursor:pointer;  background-color: #0ba14e; color: white; outline: 0px; border: 0px; padding: 8px 25px;" onclick="savehotelfun();" />
        </label></td>
  </tr>
      
 </table>
	
	<script>
	function savehotelfun(){
	var selectedNights = encodeURIComponent($('#selectedNights').val());
	var hotelName = encodeURIComponent($('#hotelName').val());
	var hotelId = encodeURIComponent($('#hotelId').val());
	var cityName = encodeURIComponent($('#cityName').val());
	var cityIdhotel = encodeURIComponent($('#cityIdhotel').val());
	var hotelCategoryMaster  = $('#addhotelcat').val();
	var roomType = encodeURIComponent($('#roomType').val());
	var comments = encodeURIComponent($('#comments').val());
	var editId = encodeURIComponent($('#editId').val());
	var nights = $('#nights').val();
	
	var textToAppend = "";
     var selMulti = $("#selectedNights option:selected").each(function(){
           textToAppend += (textToAppend == "") ? "" : ",";
           textToAppend += $(this).text();           
     });
 	 
	if(selectedNights!='' && hotelName!='' && cityName!='' && hotelCategoryMaster!='' && roomType!='' && editId!=''){
	$('#addhotelbtnmain').hide();
	$('#loadaddedhotel').load('loadaddedhotel.php?nights='+nights+'&selectedNights='+selectedNights+'&hotelName='+hotelName+'&hotelId='+hotelId+'&cityName='+cityName+'&cityIdhotel='+cityIdhotel+'&hotelCategoryMaster='+hotelCategoryMaster+'&roomType='+roomType+'&comments='+comments+'&editId='+editId+'&nights='+nights+'&action=addhotel&packageId=<?php echo $_REQUEST['packageId']; ?>');
	} 
	
	}
	
	
function deletehotelmain(id){
var nights = $('#nights').val(); 

  if(confirm("Do you want to delete this hotel?")){

$('#loadaddedhotel').load('loadaddedhotel.php?nights='+nights+'&deleteid='+id+'&action=deletehotel&packageId=<?php echo $_REQUEST['packageId']; ?>');
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


 