<?php
if($addpermission!=1 && $_GET['id']==''){
header('location:'.$fullurl.'');
}

if($editpermission!=1 && $_GET['id']!=''){
header('location:'.$fullurl.'');
}
 
if(trim($_POST['editedityes'])=='1' && trim($_POST['companyname'])!='' && trim($_POST['editId'])!=''){ 
 
  $companyname=addslashes($_POST['companyname']);
  $readdress=addslashes($_POST['readdress']);
  $repolicies=addslashes($_POST['repolicies']);
  $recompanyname=addslashes($_POST['recompanyname']);
  $phone=addslashes($_POST['phone']);
  $email=addslashes($_POST['email']);
  $website=addslashes($_POST['website']); 
  $termscondition=addslashes($_POST['policies']); 
  $oldlogo=addslashes($_POST['oldlogo']); 

  if($_FILES['logo']['name']!=''){
    $file_name=time().str_replace(' ', '', $_FILES['logo']['name']); 
    copy($_FILES['logo']['tmp_name'],"dirfiles/".$file_name);
    $oldlogo=$file_name;
  }

  $dateAdded=time();
   
  $where='id=1'; 
  $namevalue ='companyname="'.$companyname.'",phone="'.$phone.'",email="'.$email.'",website="'.$website.'",termscondition="'.$termscondition.'",logo="'.$oldlogo.'",recompanyname="'.$recompanyname.'",repolicies="'.$repolicies.'",readdress="'.$readdress.'"';
  $update = updatelisting(_INVOICE_SETTING_MASTER_,$namevalue,$where); 
  if($update=='yes'){
    generateLogs('invoicesetting','update',$where);
    ?>
    <script>
    parent.window.location.href='showpage.crm?module=invoicesetting&alt=2';
    </script> 
    <?php
    exit();
  }
}


$select1='*';   
$where1='id=1'; 
$rs1=GetPageRecord($select1,_INVOICE_SETTING_MASTER_,$where1); 
$editresult=mysqli_fetch_array($rs1);

$repolicies=addslashes($editresult['repolicies']); 
$readdress=addslashes($editresult['readdress']); 
$recompanyname=addslashes($editresult['recompanyname']); 
$editcompanyname=addslashes($editresult['companyname']); 
$editphone=stripslashes($editresult['phone']); 
$editemail=stripslashes($editresult['email']);  
$editwebsite=stripslashes($editresult['website']); 
$editpolicies=stripslashes($editresult['termscondition']);   
$logo=stripslashes($editresult['logo']);  


// from inc.php $editresultcsm['id']
$select2='*';   
$where2='companySettingId="'.$editresultcsm['id'].'"'; 
$rs1=GetPageRecord($select2,'componyFinanceSetting',$where2); 
$editresultfs=mysqli_fetch_array($rs1);

$repolicies=addslashes($editresult['repolicies']); 
$readdress=addslashes($editresult['readdress']); 
$recompanyname=addslashes($editresult['recompanyname']); 
$editcompanyname=addslashes($editresult['companyname']); 
$editphone=stripslashes($editresult['phone']); 
$editemail=stripslashes($editresult['email']);  
$editwebsite=stripslashes($editresult['website']); 
// $editpolicies=stripslashes($editresult['termscondition']);   
$logo=stripslashes($editresult['logo']);  



?>

<script src="tinymce/tinymce.min.js"></script>

<script type="text/javascript">

    tinymce.init({

        selector: "#policies",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });


tinymce.init({

        selector: "#repolicies",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });



  tinymce.init({

        selector: "#pointsRememberText",

        themes: "modern",   

        plugins: [

            "advlist autolink lists link image charmap print preview anchor",

            "searchreplace visualblocks code fullscreen" 

        ],

        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"   

    });

    </script>
	
	
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><div class="headingm" style="margin-left:295px;"><span id="topheadingmain">Update <?php echo $pageName; ?> </span></div></td>
      <td align="right"><table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td></td>
            <td><input name="addnewuserbtn2" type="button" class="bluembutton submitbtn" id="addnewuserbtn2" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        
            <td style="padding-right:20px;">&nbsp; </td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="pagelisterouter" >
<form action="" method="post" enctype="multipart/form-data" name="addeditfrm"  id="addeditfrm">
 
<div class="addeditpagebox">
  <input name="action" type="hidden" id="action" value="editvouchersetting" />
  <input name="savenew" type="hidden" id="savenew" value="0" /> 
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      
      <td width="50%">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
          <td colspan="2" align="left" valign="top" ><div class="innerbox">
          <h2>Invoice Information</h2>
          </div></td>
          </tr>
          <tr>
          <td colspan="2" align="left" valign="top"  >


          <div class="griddiv"> 
          <label>
          <div class="gridlable">Company Name <span class="redmind"></span></div>

          <input name="companyname" type="text" class="gridfield" id="companyname" displayname="Company Name" value="<?php echo $editcompanyname; ?>" maxlength="50" />
          </label>
          </div>



          <div class="griddiv"> 
          <label>
          <div class="gridlable">Email <span class="redmind"></span></div>

          <input name="email" type="email" class="gridfield" id="email" displayname="Email" value="<?php echo $editemail; ?>" maxlength="50" />
          </label>
          </div>  

          <div class="griddiv"> 
          <label>
          <div class="gridlable">Change Company Logo   
          <input name="oldlogo" type="hidden" id="oldlogo" value="<?php echo $logo; ?>" />
          </div>


          <input name="logo" type="file" id="logo" style="margin-top:5px; width:100%;" />
          </label>
          </div> <div class="griddiv"> 
          <label>

          <img src="dirfiles/<?php echo $logo; ?>" height="70" />  </label>
          </div>  <div class="griddiv"> 
          <label>
          <div class="gridlable">Phone <span class="redmind"></span></div>

          <input name="phone" type="text" class="gridfield" id="phone" onkeyup="numericFilter(this);" displayname="Phone" value="<?php echo $editphone; ?>" maxlength="120" />
          </label>
          </div>      <div class="griddiv"> 
          <label>
          <div class="gridlable">Website <span class="redmind"></span></div>

          <input name="website" type="text" class="gridfield" id="website" displayname="Website" value="<?php echo $editwebsite; ?>" maxlength="100" />
          </label>
          </div>  
          </td>
          
          </tr>
          <tr>
            <td colspan="2" align="left" valign="top" style="padding:10px;border:1px solid #ddd;"><div style=" overflow:hidden;">
              <div style="margin-bottom:10px; font-size:13px; color:#8a8a8a; position:relative;">Address<strong style="position:absolute; right:0px;"><a onclick="alertspopupopen('action=addsupaddress&supid=1&addressType=invoicesetting','700px','auto');">+ Add Address</a></strong></div>
              <div id="loadaddress"></div>
              <script>
              function loadaddress(dltid){
              $('#loadaddress').load('loadaddress.php?addressParent=1&addressType=invoicesetting&dltid='+dltid);
              }
              loadaddress('0');
              </script>
              </div>           
            </td>
          </tr>
          <tr>
          <td colspan="2" align="left" valign="top"  >

          <div class="griddiv"><label>
          <div class="gridlable">TERMS & CONDITIONS </div>
          <textarea name="policies" rows="10" class="gridfield" id="policies"><?php echo stripslashes($editpolicies); ?></textarea>
          </label>
          </div></td>
          </tr>
          <tr>
          <td colspan="2" align="left" valign="top"  >&nbsp;</td>
          </tr>
          <tr>
          <td align="left" valign="top"  ><div class="griddiv"> 
          <label>
          <div class="gridlable">Remittance Company Name <span class="redmind"></span></div>

          <input name="recompanyname" type="text" class="gridfield" id="recompanyname" displayname="Company Name" value="<?php echo $recompanyname; ?>" maxlength="50" />
          </label>
          </div></td>
          <td align="left" valign="top"  >&nbsp;</td>
          </tr>
          <tr>
          <td colspan="2" align="left" valign="top"  ><div class="griddiv"> 
          <label>
          <div class="gridlable">Remittance Address <span class="redmind"></span></div>

          <textarea name="readdress" rows="5" class="gridfield" id="readdress" displayname="Company Name"><?php echo $readdress; ?></textarea>
          </label>
          </div></td>
          </tr>
          <tr>
          <td colspan="2" align="left" valign="top"  ><div class="griddiv"><label>
          <div class="gridlable">Remittance Terms </div>
          <textarea name="repolicies" rows="10" class="gridfield" id="repolicies"><?php echo stripslashes($repolicies); ?></textarea>
          </label>
          </div></td>
          </tr>
          <tr>
          <td align="left" valign="top"  >&nbsp;</td>
          <td align="left" valign="top"  >&nbsp;</td>
          </tr>
        </table>
      </td>
      <td width="50%" style="padding-left: 20px;" valign="top">
        <style>
          .f-year{
            font-size: 15px;
            font-weight: 500;
          }
        </style>
        <!-- FINANCE SETTINGS --> 
        <div style="color: #8a8a8a;margin-bottom: 7px;font-size: 13px;">
          <div class="innerbox">
            <h2>Finance Setting</h2>
          </div>
          <span id="successmessage" style="color: #4CAF50;font-size: 15px;display:none;">Finance Setting Updated Successfully</span>
        </div>
  
          <table width="100%" border="1" cellspacing="0" cellpadding="10" bordercolor="#eee">
            <tr>
       
              <td align="center" class="f-year">Financial Year</td>
              <td align="center" class="f-year">From Date</td>
              <td align="center" class="f-year">To Date</td>
              <td align="center" class="f-year">Action</td>
            </tr>
            <?php 
            $output='';
            $result = GetPageRecord('*','financeYearMaster','status=1 and deletestatus=0 order by fromDate desc limit 1');
            if(mysqli_num_rows($result)>0){
              $fyData = mysqli_fetch_assoc($result);
              $nfromDate = date('d-m-Y',strtotime($fyData["fromDate"]. ' + 1 years'));
              $ntoDate = date('d-m-Y',strtotime($fyData["toDate"]. ' + 1 years'));
            }else{
              $nfromDate = date('01-04-Y');
              $ntoDate = date('31-03-Y',strtotime(' + 1 years'));
            }
            $nfinanceYear = date('y',strtotime($nfromDate)).'-'.date('y',strtotime($ntoDate));
            ?>
  
            <tr>
              <!-- <td align="left" class="f-year">Financial Year</td> -->
              <td align="center">
                <div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;width:100px;">
                  <label>
                    <select id="financeYear" name="financeYear" class="gridfield" style="width:100px;" >
                      <option value="20-21" <?php if($nfinanceYear=='20-21'){?> selected="selected" <?php } ?> > <?php echo '2020-21' ?> </option>
                      <option value="21-22" <?php if($nfinanceYear=='21-22'){?> selected="selected" <?php } ?> > <?php echo '2021-22' ?> </option>
                      <option value="22-23" <?php if($nfinanceYear=='22-23'){?> selected="selected" <?php } ?> > <?php echo '2022-23' ?> </option>
                      <option value="23-24" <?php if($nfinanceYear=='23-24'){?> selected="selected" <?php } ?> > <?php echo '2023-24' ?> </option>
                      <option value="24-25" <?php if($nfinanceYear=='24-25'){?> selected="selected" <?php } ?> > <?php echo '2024-25' ?> </option>
                      <option value="25-26" <?php if($nfinanceYear=='25-26'){?> selected="selected" <?php } ?>> <?php echo '2025-26' ?> </option>
                      <option value="26-27" <?php if($nfinanceYear=='26-27'){?> selected="selected" <?php } ?>> <?php echo '2026-27' ?> </option>
                      <option value="27-28" <?php if($nfinanceYear=='27-28'){?> selected="selected" <?php } ?>> <?php echo '2027-28' ?> </option>
                      <option value="28-29" <?php if($nfinanceYear=='28-29'){?> selected="selected" <?php } ?>> <?php echo '2028-29' ?> </option>
                      <option value="29-30" <?php if($nfinanceYear=='29-30'){?> selected="selected" <?php } ?>> <?php echo '2029-30' ?> </option>
                      <option value="30-31" <?php if($nfinanceYear=='30-31'){?> selected="selected" <?php } ?> > <?php echo '2030-31' ?> </option>
                    </select>
                  </label>
                </div>
              </td>
              <td style="padding:0px 0px 0px 5px;" align="left" width="25%">
                <div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;width: 140px;"> 
                  <label> 
                    <input name="fy_fromDate" type="text" readonly=""  class="gridfield" id="fy_fromDate" value="<?php echo $nfromDate; ?>" />
                  </label> 
                </div>
              </td>
              <td style="padding:0px 0px 0px 5px;" align="left" width="15%">
                <div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;width: 140px;"> 
                  <label> 
                    <input name="fy_toDate" type="text" readonly=""  class="gridfield" id="fy_toDate" value="<?php echo $ntoDate; ?>"  />
                  </label> 
                </div>
                <script src="js/zebra_datepicker.js?id=<?php echo time() ?>"></script>
                <script>
                  $(document).ready(function() {
                    $('#fy_toDate').Zebra_DatePicker({
                      format: 'd-m-Y',
                    });
                    
                    $('#fy_fromDate').Zebra_DatePicker({
                      format: 'd-m-Y',
                      pair: $('#fy_toDate')
                    });
                  });
                </script>
              </td>
              <td align="center">
                <input class="savebutton" type="button" onclick="addfinanceYear();" value="Save" style="border: 1px solid #afafaf;cursor:pointer;background-color: white;border-radius: 4px;width: 100px;padding: 6px;font-size: 15px;">
              </td>
            </tr>
            <!-- loading finance year file -->
            <tr><td id="loadFinanceYeaDIv" colspan="4"></td></tr>
          </table>
          <br>
          <br>
          <!-- FINANCE SETTINGS --> 
          <div style="color: #8a8a8a;margin-bottom: 7px;font-size: 13px;">
            <div class="innerbox">
              <h2>Default MarkUp & GST</h2>
            </div>
            <span id="successmessage2" style="color: #4CAF50;font-size: 15px;display:none;">Finance Setting Updated Successfully</span>
          </div>

          <table width="100%" border="1" cellspacing="0" cellpadding="10" bordercolor="#eee">
            <tr>
              <td align="left" colspan="2" class="f-year">Markup</td>
              <td align="center">
                <div class="griddiv" style="margin-bottom: 7px;border-bottom: 0; width: 170px;">
                <label><select id="selectMarkupType" name="selectMarkupType" class="gridfield" style="width: 150px;"  >
                  <option value="1" <?php if($editresultfs['markupSerType']=='1'){ ?>selected="selected"<?php } ?>>Markup</option>
                  <option value="2" <?php if($editresultfs['markupSerType']=='2'){ ?>selected="selected"<?php } ?>>Service Charge</option>
                </select></label>
              </div></td>

              <td align="center">
                <div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;">
                  <label>
                    <input name="sermarprice" type="text" class="gridfield " style="width: 120px;" id="sermarprice" value="<?php echo $editresultfs['marSerAmount']; ?>"  autocomplete="off" >
                  </label>
                </div>
              </td>
            </tr>
            <tr>
              <td align="left" colspan="2" class="f-year">GST</td>
              <td align="center"><div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;">
              <label><select id="taxType" name="taxType" class="gridfield" style="width: 150px;" >
                <option value="1" <?php if($editresultfs['taxType']=='1'){ ?>selected="selected"<?php } ?>>GST</option>
                <option value="2" <?php if($editresultfs['taxType']=='2'){ ?>selected="selected"<?php } ?>>VAT</option>
              </select></label>
              </div></td>
              <td align="center"  width="25%" ><div class="griddiv" style="margin-bottom: 7px;border-bottom: 0;    width: 130px;">
              <label>
                <select id="taxprice" name="taxprice" class="gridfield" style="width: 120px;" >
                <?php 
                $rs2="";
                $rs2=GetPageRecord('*','gstMaster',' 1 and serviceType="Invoice" and status=1 order by gstSlabName asc'); 
                while($gstSlabData=mysqli_fetch_array($rs2)){
                ?>
                <option value="<?php echo $gstSlabData['gstValue'];?>" <?php if($editresultfs['taxAcmount']==$gstSlabData['id']){ ?> selected="selected" <?php } ?>><?php echo $gstSlabData['gstSlabName'];?>&nbsp;(<?php echo $gstSlabData['gstValue'];?>)</option>
                <?php
                } 
                ?>
                </select>
                <input name="editid1" type="hidden" class="gridfield " id="editid1" value="<?php echo $editresultfs['id']; ?>" >
              </label>
              </div></td> 
            </tr> 
            <tr>
              <td colspan="4" align="right"><input name="addnewuserbtn2" type="button" class="savebutton" id="addnewuserbtn2" value="Save" onclick="addfinancesetting('<?php echo $editresultfs['id']; ?>')" style="border-radius: 3px; cursor:pointer; width: 100px; display: block; padding: 6px; font-size: 16px;"></td>
            </tr>
          </table> 
          <div id="loadfinance"></div>
          <div id="addfinanceyearmultiple"></div>
          <script type="text/javascript">
            
            function addfinanceYear(){
              var financeYear = $('#financeYear').val();
              var fromDate = $("#fy_fromDate").val();
              var toDate = $("#fy_toDate").val();
              $('#addfinanceyearmultiple').load('load_financemultipleyear.php?action=AddFinanceYear&financeYear='+financeYear+'&fromDate='+fromDate+'&toDate='+toDate);
              $('#loadFinanceYeaDIv').load('load_financemultipleyear.php?action=loadFinanceYear');
            }
      
            function loadFinanceYear(){
              $('#loadFinanceYeaDIv').load('load_financemultipleyear.php?action=loadFinanceYear');
            }
            loadFinanceYear();
    
            function addfinancesetting(id){
              var sermartype = $('#sermartype').val();
              var selectMarkupType = $('#selectMarkupType').val();
              var sermarprice = $('#sermarprice').val();
              var taxType = $('#taxType').val();
              var taxprice = $('#taxprice').val();
              var editid1 = $('#editid1').val();
              $("#loadfinance").load('loadCompanyExtraactivuty.php?action=financeSetting&sermartype='+sermartype+'&selectMarkupType='+selectMarkupType+'&sermarprice='+sermarprice+'&taxType='+taxType+'&taxprice='+taxprice+'&id='+id+'&editid='+editid1);
            }
          </script>  
      </td>
    </tr>
  </table>


</div>

<div class="rightfootersectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><input name="editId" type="hidden" id="editId" value="1" />
		 
		<input name="editedityes" type="hidden" id="editedityes" value="1" />		</td>
        <td><input name="addnewuserbtn" type="submit" class="bluembutton submitbtn" id="addnewuserbtn" value="Save" onclick="formValidation('addeditfrm','submitbtn','0');" /></td>
        <td style="padding-right:20px;">&nbsp; </td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

 


</form>
 
</div>
<script>  

comtabopenclose('linkbox','op2');

function toTimestamp(strDate){
   var datum = Date.parse(strDate);
   return datum/1000;
}



function showDays(firstDate,secondDate){ 
                  var startDay = new Date(firstDate);
                  var endDay = new Date(secondDate);
                  var millisecondsPerDay = 1000 * 60 * 60 * 24;

                  var millisBetween = startDay.getTime() - endDay.getTime();
                  var days = millisBetween / millisecondsPerDay;

                  // Round down.
                  return ( Math.floor(days));

              }

 

function changedatefunction(){
  var fromDate = $('#fromDate').val().split("-").reverse().join("-");
  var toDate = $('#toDate').val().split("-").reverse().join("-");
   
  
  var fromDatestamp = toTimestamp(''+fromDate+'');
  var toDatestamp = toTimestamp(''+toDate+''); 
  
 if(fromDate!= '' && fromDate!= '' && fromDatestamp>= toDatestamp)
    {
    alert("Please ensure that the To Travel Date is greater than From Travel Date."); 
    $('#toDate').val(''); 
    }
  var totaldays = showDays(toDate,fromDate);
  if(totaldays!='' || totaldays!='0'){   
  $('#night').val(totaldays);
  } 
} 
</script>

<style>
.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper {
    width: 100% !important;
}
</style>
