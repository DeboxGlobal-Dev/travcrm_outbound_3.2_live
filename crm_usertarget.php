<?php
if($loginuserprofileId==1){ 

$wheresearchassign=' 1   ';

} else { 

$wheresearchassign=' ( id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].') ) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))  or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))  or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].'))))))) or id in (select id from '._USER_MASTER_.' where  roleId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in (select id from roleMaster where parentId in  (select id from roleMaster where parentId in ( select id from roleMaster where parentId in ( select id from roleMaster where parentId ='.$LoginUserDetails['roleId'].')))))))))  '; 

$wheresearchassign='( '.$wheresearchassign.'  or id = '.$_SESSION['userid'].' or addedBy = '.$_SESSION['userid'].') ';

} 









if($_GET['year']!='' && $_GET['assignto']!=''){  
$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$where='assign_to='.decode($_GET['assignto']).''; 
$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
$resultpage=mysqli_fetch_array($rs);  
}
if($_REQUEST['year']!=''){
$year=$_REQUEST['year'];
} else { 
$year=date('Y');
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
	<form action="" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
        
    <td><div class="headingm" style="margin-left:10px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
	<div id="deactivatebtn" style="display:none;">
	 <?php if($deletepermission==1){ ?> 
	
	<input name="deactivate" type="button" class="redmbutton" id="deactivate" value="Delete" onclick="alertspopupopen('action=corportatedelete&name=Query','600px','auto');" />
	<?php } ?>
	</div>
	
	</div></td>
    <td align="right">
	<table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
         <td >
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding:0px 0px 0px 5px;" > 
          <select name="assignto" id="assignto" class="topsearchfiledmainselect" style="width:200px; " >
            <option value="">Select User</option>
			 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';    
$where=' '.$wheresearchassign.' and deletestatus=0 and status=1 order by firstName asc';  
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
while($resListing=mysqli_fetch_array($rs)){  

?>
			<option value="<?php echo encode($resListing['id']); ?>" <?php if(decode($_GET['assignto'])==$resListing['id']){ ?>selected="selected"<?php  } ?>><?php echo $resListing['firstName']; ?> <?php echo $resListing['lastName']; ?></option>
			<?php } ?>
          </select> </td>
		  
	 
		  
		  
        <td style="padding-left:10px;"><select id="year" name="year"   displayname="Assign To"  class="topsearchfiledmainselect"  autocomplete="off"  style="width:120px; " >

 

<?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where='id!="" group by year desc'; 
$rs=GetPageRecord($select,_TARGET_MASTER_,$where); 
while($assignlist=mysqli_fetch_array($rs)){  
?>

<option value="<?php echo strip($assignlist['year']); ?>" <?php if($assignlist['year']==$_REQUEST['year']){ ?>selected="selected"<?php } ?>><?php echo strip($assignlist['year']); ?></option>

<?php } ?>

</select></td>
        <td ><input name="module" id="module" type="hidden" value="<?php echo $_REQUEST['module']; ?>" /><input type="submit" name="Submit" value="Search" class="searchbtnmain" /></td>
  </tr>
</table>

		</td>        <?php if($resultpage['id']!=''){ ?><td  >
		<a href="showpage.crm?module=usertarget&add=yes&id=<?php echo encode($resultpage['id']); ?>"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Edit This Target" style="background-color: #3273b5 !important;border: 1px #ccc solid !important;"/></a></td> <?php } ?>
		
        <?php if($addpermission==1){ ?><td style="padding-right:20px;"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New <?php echo $pageName; ?>" onclick="add();" /></td> <?php } ?>
      </tr>
      
    </table>
	
	</td>
  </tr>
  
</table>
</div>

</form>

<form id="listform" name="listform" method="get">
<div id="pagelisterouter" style="padding-left:10px; padding-right:0px; padding-left:0px;">
 <div style=" margin-top: -10px; padding:20px;">
	 <?php if($_GET['assignto']!='' && $_GET['year']!='') {?>

<table width="100%" border="0" cellspacing="0" cellpadding="5" class="tablesorter">

             <tr>

               <td width="12%" align="left" valign="top" class="grayheader header">Month</td>

               <td width="13%" align="left" valign="top" class="grayheader header"></td>

               <td width="24%" align="center" valign="top" class="grayheader header">Qtr.</td>

               <td width="31%" align="center" valign="top" class="grayheader header">Half Yearly</td>

               <td width="20%" align="center" valign="top" class="grayheader header">Yearly</td>
             </tr>

             <tr>

               <td align="left" valign="middle" class="borderbottomsec">January</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="January" type="number" id="January" style="width:100px;pointer-events: none;"  value="<?php echo strip($resultpage['January']); ?>"  onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);" class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr1"></div></td>

               <td rowspan="6" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:20px; font-weight:bold;" id="hy1"></div></td>

               <td rowspan="12" align="center" valign="middle"  class="borderleftsec borderbottomsec"><div style="font-size:22px; font-weight:bold;" id="y"></div></td>
             </tr>

             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">February</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="February" type="number" id="February" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['February']); ?>"  class="topsearchfiledmainselect" /></td>
             </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">March</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="March" type="number" id="March" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['March']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">April</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="April" type="number" id="April" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['April']); ?>" class="topsearchfiledmainselect"  /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr2"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">May</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="May" type="number" id="May" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['May']); ?>" class="topsearchfiledmainselect"  /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">June</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="June" type="number" id="June" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['June']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">July</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="July" type="number" id="July" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['July']); ?>"  class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr3"></div></td>

               <td rowspan="6" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:20px; font-weight:bold;" id="hy2"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">August</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="August" type="number" id="August" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['August']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">September</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="September" type="number" id="September" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['September']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr>

               <td align="left" valign="middle" class="borderbottomsec">October</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="October" type="number" id="October" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['October']); ?>"  class="topsearchfiledmainselect" /></td>

               <td rowspan="3" align="center" valign="middle" class="borderleftsec borderbottomsec"><div style="font-size:18px; font-weight:bold;" id="qtr4"></div></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">November</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="November" type="number" id="November" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['November']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>             <tr class="borderbottomsec">

               <td align="left" valign="middle" class="borderbottomsec">December</td>

               <td align="left" valign="middle" class="borderbottomsec"><input name="December" type="number" id="December" style="width:100px;pointer-events: none;"   onblur="calculatetarget();" onkeypress="calculatetarget();numericFilter(this);"  value="<?php echo strip($resultpage['December']); ?>"  class="topsearchfiledmainselect" /></td>

               </tr>
           </table>

		   <?php } else {?>

		   <div style="padding:20px; text-align:center;">Select User and Year</div>

		   <?php }?>

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