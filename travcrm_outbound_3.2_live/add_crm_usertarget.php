<?php
if($_GET['id']!=''){  
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=decode($_GET['id']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  
}
?>

<link href="css/main.css" rel="stylesheet" type="text/css" />
 <style>
 .pipeborderright{border-right: 1px #ccc5c56b solid;}
 body{ background-color:#f8f8f8 !important;}
.pipeheadingbox {
    padding: 10px;
    color: #FFFFFF;
    font-weight: 500;
    width: 100%;
    box-sizing: border-box;
    font-size: 14px;
} 
.pipequerybox:hover{background-color:#F8F8F8;}
.pipequerybox{padding:10px; background-color:#FFFFFF; border-bottom:1px #ccc5c56b solid;}
.pipequerybox .qtitle{font-size:13px; font-weight:500; color:#333333; margin-bottom:5px;text-overflow: ellipsis; overflow:hidden;white-space: nowrap; max-width:150px;}
.pipequerybox .qouter{overflow:hidden;}
.pipequerybox .qamount{max-width:30%; padding-right:5px; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}
.pipequerybox .qcompanyname{max-width:65%; font-size:12px; color:#999999; float:left;text-overflow: ellipsis; overflow:hidden;white-space: nowrap;}



</style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
 
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="7%" align="left"> <a name="addnewuserbtn" href="showpage.crm?module=<?php echo $_REQUEST['module'];?>" /><input type="button" name="Submit22" value="Back" class="whitembutton" ></a> </td>
    <td><div class="headingm" style="margin-left:0px;"><span id="topheadingmain"><?php if($_GET['id']!=''){ ?>Update<?php } else { ?>Add<?php } ?> <?php echo $pageName; ?> </span></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <td><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
 
        <td style="padding-right:20px;"><a href="showpage.crm?module=usertarget"><input type="button" name="Submit2" value="Cancel" class="whitembutton" /></a></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 

<form action="frm_action.crm" method="post" enctype="multipart/form-data" name="addeditfrm" target="actoinfrm" id="addeditfrm">
<div id="pagelisterouter" style="padding-left:30px; padding-right:0px; padding-left:0px;    padding-top: 106px;">
 <div class="formsection" style="    border-bottom: 2px solid #ccc;background-color: #eaeaea;">
   <table width="200" border="0" cellpadding="5" cellspacing="0">
     <tr>
       <td>User</td>
       <td><select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:200px; <?php if($_GET['id']!=''){ ?>pointer-events: none;<?php } ?> " >
	   <?php if($_GET['id']==''){ ?>
           <option value="">Select User</option>
		   <?php } ?>
           <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' id!=1 and deletestatus=0 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){ 
 

?>
           <option value="<?php echo $resListing['id']; ?>" <?php if($resultpage['assign_to']==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
           <?php }   ?>
       </select></td>
       <td>Year</td>
       <td><input type="text" name="year" id="year" class="topsearchfiledmainselect validate"  style="width:100px;"  displayname="Year" field_min_length='4' maxlength="4" value="<?php echo strip($resultpage['year']); ?>"  onkeyup="numericFilter(this);"/><input name="action" type="hidden" id="action" value="<?php if($_REQUEST['id']!=''){ echo 'edittarget'; }else{ echo 'addtarget'; } ?>" /><input name="editId" type="hidden" id="editId" value="<?php echo $resultpage['id']; ?>" /><input name="listid" type="hidden" id="listid" value="<?php echo encode($resultpage['id']); ?>" /></td>
     </tr>
   </table>
    

		  
		 </div>

		 

		 <div class="formsection" style="    box-sizing: border-box; background-color:#FFFFFF;">

		   <table width="100%" border="0" cellpadding="5" cellspacing="0" class="tablesorter">

             <tr>

               <td width="12%" align="left" valign="top" class="grayheader header">Month</td>

               <td width="13%" align="left" valign="top" class="grayheader header"></td>

               <td width="24%" align="center" valign="top" class="grayheader header">Qtr.</td>

               <td width="31%" align="center" valign="top" class="grayheader header">Half Yearly</td>

               <td width="20%" align="center" valign="top" class="grayheader header">Yearly</td>
             </tr>

             <tr>

               <td align="left" valign="middle" class="borderbottomsec">January</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="January" type="number" id="January" style="width:100px;"  value="<?php echo strip($resultpage['January']); ?>"  onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);" class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr1"></div></td>

               <td rowspan="6" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:20px; font-weight:bold;" id="hy1"></div></td>

               <td rowspan="12" align="center" valign="middle"  class="borderleftsec borderbottomsec"><div style="font-size:22px; font-weight:bold;" id="y"></div></td>
             </tr>

             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">February</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="February" type="number" id="February" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['February']); ?>"  class="topsearchfiledmainselect" /></td>
             </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">March</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="March" type="number" id="March" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['March']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">April</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="April" type="number" id="April" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['April']); ?>" class="topsearchfiledmainselect"  /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr2"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">May</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="May" type="number" id="May" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['May']); ?>" class="topsearchfiledmainselect"  /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">June</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="June" type="number" id="June" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['June']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">July</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="July" type="number" id="July" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['July']); ?>"  class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr3"></div></td>

               <td rowspan="6" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:20px; font-weight:bold;" id="hy2"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">August</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="August" type="number" id="August" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['August']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">September</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="September" type="number" id="September" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['September']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">October</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="October" type="number" id="October" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['October']); ?>"  class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr4"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">November</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="November" type="number" id="November" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['November']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">December</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="December" type="number" id="December" style="width:100px;" onkeyup="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['December']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>
           </table>
		 </div>
</div></form>	</td>
  </tr>
</table>

 <script>

function calculatetarget(){

var January=Number($("#January").val());

var February=Number($("#February").val());

var March=Number($("#March").val());

var April=Number($("#April").val());

var May=Number($("#May").val());

var June=Number($("#June").val());

var July=Number($("#July").val());

var August=Number($("#August").val());

var September=Number($("#September").val());

var October=Number($("#October").val());

var November=Number($("#November").val());

var December=Number($("#December").val());



$("#qtr1").text(Number(January+February+March));

$("#qtr2").text(Number(April+May+June));

$("#qtr3").text(Number(July+August+September));

$("#qtr4").text(Number(October+November+December));



$("#hy1").text(Number(January+February+March+April+May+June));

$("#hy2").text(Number(July+August+September+October+November+December));



$("#y").text(Number(January+February+March+April+May+June+July+August+September+October+November+December));







}

calculatetarget();

</script>

<style>
.header {
    border-bottom: 2px #e8e8e8 solid;
    background-color: #ffffff;
    padding: 13px;
    border-top: 0px #e8e8e8 solid;
    text-transform: uppercase;
    font-size: 13px;
    font-family: 'Roboto', sans-serif;
    font-weight: 500;
}

 .borderbottomsec{border-bottom:1px #e2e2e2 solid;}
 .borderleftsec{border-left:1px #e2e2e2 solid;}
</style>