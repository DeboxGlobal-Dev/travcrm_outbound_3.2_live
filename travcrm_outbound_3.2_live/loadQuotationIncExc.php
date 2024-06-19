<?php
include "inc.php";  
$rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.($_REQUEST['quotationId']).'" '); 
$quotationData=mysqli_fetch_array($rs2); 

$fitGitId =$quotationData['fitGitId'];

// if($fitGitId!='')
// {
//   $fitGitId =$quotationData['fitGitId'];
// }

$overviewText='';
$highlightsText='';
$itineraryintrText='';
$itinerarysummText='';
$tncText='';
$specialText='';
$inclusion = '';
$exclusion = '';
$paymentpolicy = '';
$remarks = '';

// edit part of quotation fit and git
$editinclusion = $quotationData['inclusion'];
$editpaymentpolicy = $quotationData['paymentpolicy'];
$editremarks = $quotationData['remarks'];
$editexclusion = $quotationData['exclusion'];
$edittncText = $quotationData['tncText'];
$editspecialText = $quotationData['specialText'];




// fit new variable declared
// inclusion , exclusion,termscondition,cancelation,paymentpolicy,remarks,serviceupgradationText,optionaltourText

$inclusionText='';
$exclusionText='';
$termsconditionText='';
$cancelationText='';
$paymentpolicyText='';
$remarksText='';
$serviceupgradationText='';
$optionaltourText='';

if($quotationData['queryType'] == 1){
  $fitGit = " and id = 1";
  // $fitGit1 = "GIT";
}elseif($quotationData['queryType'] == 2){
  $fitGit = " and id = 2";
  // $fitGit1 = "FIT";
}

$rs22=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" '); 
$queryData=mysqli_fetch_array($rs22); 

if($queryData['paxType'] == 1){
  $fitGit1 ="GIT";
}elseif($queryData['paxType'] == 2){
  $fitGit1="FIT";
}

// $rs22=GetPageRecord('*',_QUERY_MASTER_,' id="'.$quotationData['queryId'].'" '); 
// $queryData=mysqli_fetch_array($rs22); 

// if($queryData['paxType'] == 1){
//   $fitGit1 = 'and fit_git = "GIT"';
// }elseif($queryData['paxType'] == 2){
//   $fitGit1 = 'and fit_git = "FIT"';
// }


//inclusion
if($quotationData['inclusion']=='' || $quotationData['inclusion']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $inclusion=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['inclusion']))); 
}else{
  $inclusion=preg_replace('/\\\\/', '',clean($quotationData['inclusion']));
}

// exclusion
if($quotationData['exclusion']=='' || $quotationData['exclusion']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $exclusion=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['exclusion']))); 
}else{ 
  $exclusion=preg_replace('/\\\\/', '',clean($quotationData['exclusion']));
}

//termscondition
if($quotationData['tncText']=='' || $quotationData['tncText']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $tncText=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['termscondition']))); 
}else{ 
  $tncText=preg_replace('/\\\\/', '',clean($quotationData['tncText']));
}

//cancelation
if($quotationData['specialText']=='' || $quotationData['specialText']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $specialText=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['cancelation']))); 
}else{ 
  $specialText=preg_replace('/\\\\/', '',clean($quotationData['specialText']));
}

// payment policy
if($quotationData['paymentpolicy']=='' || $quotationData['paymentpolicy']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $paymentpolicy=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['paymentpolicy']))); 
}else{
  $paymentpolicy=preg_replace('/\\\\/', '',clean($quotationData['paymentpolicy']));
}


// remarks
if($quotationData['remarks']=='' || $quotationData['remarks']=='undefined'){
  $rs11=GetPageRecord('*',_PACKAGE_TERMS_CONDITIONS_MASTER,'1 '.$fitGit.''); 
  $incExcData=mysqli_fetch_array($rs11);
  $remarks=preg_replace('/\\\\/', '',clean(htmlspecialchars_decode($incExcData['remarks']))); 
}else{
  $remarks=preg_replace('/\\\\/', '',clean($quotationData['remarks']));
}


//overviewText
$overviewText=preg_replace('/\\\\/', '',clean($quotationData['overviewText']));
$highlightsText=preg_replace('/\\\\/', '',clean($quotationData['highlightsText']));
$itineraryintrText=preg_replace('/\\\\/', '',clean($quotationData['itineraryintrText']));
$itinerarysummText=preg_replace('/\\\\/', '',clean($quotationData['itinerarysummText']));

// fitText
$inclusionText=preg_replace('/\\\\/', '',clean($quotationData['inclusionText']));
$exclusionText=preg_replace('/\\\\/', '',clean($quotationData['exclusionText']));
$termsconditionText=preg_replace('/\\\\/', '',clean($quotationData['termsconditionText']));
$cancelationText=preg_replace('/\\\\/', '',clean($quotationData['cancelationText']));
$paymentpolicyText=preg_replace('/\\\\/', '',clean($quotationData['paymentpolicyText']));
$remarksText=preg_replace('/\\\\/', '',clean($quotationData['remarksText']));

// new added
$serviceupgradationText=preg_replace('/\\\\/', '',clean($quotationData['serviceupgradationText']));
$optionaltourText=preg_replace('/\\\\/', '',clean($quotationData['optionaltourText']));

?> 
<link rel="stylesheet" href="css/selectize.css">
 <table border="0" cellpadding="6" cellspacing="0"  width="100%">
  <tr>
  <td width="25%" ><div class="griddiv" style="position:static;">
  <label>
    <div>Overview Name</div>  
      <select id="overviewNameId" name="overviewNameId" class=" validate selectBoxDest"  displayname="Overview Name"  >
        <option value="">Select Overview</option>
        <?php 
        $rs=GetPageRecord('*',_OVERVIEW_MASTER_,' deletestatus=0 and status=1 order by overviewname asc'); 
        while($resListing=mysqli_fetch_array($rs)){  
        ?><option value="<?php echo strip($resListing['id']); ?>" <?php if($quotationData['overviewId']==$resListing['id']){ echo "selected"; } ?> ><?php echo strip($resListing['overviewName']); ?></option><?php } ?>
        </select>
    </label> 
    </div></td> 
    <td width="25%" ><div class="griddiv" style="position:static;">
    <label>
    <div>Language Type</div>  
     <select style="width: 100%" id="languageType" name="languageType" class="validate selectBoxDest" displayname="Language Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 160px;"  >
        <option value="0">Default</option>
        <?php 
         $rs=GetPageRecord('*','tbl_languagemaster','1 and status=1 and deletestatus=0');
        $totalrow = mysqli_num_rows($rs);
        while($languageDetails=mysqli_fetch_array($rs)){
          ?>
          <option value="<?php echo $languageDetails['id']; ?>"><?php echo $languageDetails['name']; ?></option>
        <?php } ?>
      </select>
    </label> 
    </div></td> 

    <td width="45%"> 
      <input type="button" value="Select" class="bluembutton" style="background-color: #75c38d !important; margin-left:0px;border: 1px #75c38d solid !important;margin-top: 11px;padding: 3px 15px!important;"  onClick="selectOverviewFun();"/>
      <a id="clickFun" style=" display:none;"></a>
    <div id="loadadditionalIdCost" style="display:none"></div></td>
     </tr>


     


     </table>
<table width="100%" border="0" cellspacing="0" cellpadding="10" >
      <tbody>
        <tr>
          <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
              <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                <thead>
                  <tr>
                    <th align="left" bgcolor="#ddd" id="overviewTitle_1">overview</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                        <textarea name="overviewText" rows="2" id="overviewText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($overviewText); ?></textarea>
                    </div></td>
                  </tr>
                </tbody>
              </table>
          </div></td>
          <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
              <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                <thead>
                  <tr>
                    <th align="left" bgcolor="#ddd" id="overviewTitle_2">Tour Highlights</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                        <textarea name="highlightsText" rows="2" id="highlightsText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($highlightsText); ?></textarea>
                    </div></td>
                  </tr>
                </tbody>
              </table>
          </div></td>
        </tr>


        <!-- Started ---- Itinerary introduction and itinerary Summary sec -->

        <tr>
          <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
              <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                <thead>
                  <tr>
                    <th align="left" bgcolor="#ddd" id="overviewTitle_3">Itinerary introduction</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                        <textarea name="itineraryintrText" rows="2" id="itineraryintrText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($itineraryintrText); ?></textarea>
                    </div></td>
                  </tr>
                </tbody>
              </table>
          </div></td>
          <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
              <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                <thead>
                  <tr>
                    <th align="left" bgcolor="#ddd" id="overviewTitle_4"> Itinerary Summary</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                        <textarea name="itinerarysummText" rows="2" id="itinerarysummText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($itinerarysummText); ?></textarea>
                    </div></td>
                  </tr>
                </tbody>
              </table>
          </div></td>
        </tr>
     
        <!-- Ended ---- Itinerary introduction and itinerary Summary sec -->





        <!-- started select section for fit inclusion an exc policy etc-->

        <!-- started select for fit and git  -->
        <?php

          // if($fitGit == 'GIT'){
          //   $fitGit = "GIT";
          // }elseif($fitGit == 'FIT'){
          //     $fitGit = "FIT";
          // }
        ?> 
        <!-- ended select for fit and git -->


        <?php if($fitGit1 == "FIT"){ ?>
        <!-- started select section for fit inclusion an exc policy etc-->

        <tr>
          <td>
          <link rel="stylesheet" href="css/selectize.css">
          <table border="0" cellpadding="6" cellspacing="0"  width="100%" >
            <tr>
            <td width="25%" ><div class="griddiv" style="position:static;">
            <label>
              <div><?php echo $fitGit1; ?> Name</div>  
              <select id="fitincexNameId" name="fitincexNameId" class=" validate selectBoxDest"  displayname="FIT Name"  >
                <!-- <option value="">Select Inclusion</option> -->
                <?php 
                $rs=GetPageRecord('*','fitIncExcMaster',' deletestatus=0 and status=1 order by fitName desc'); 
                while($resListing=mysqli_fetch_array($rs)){  
                ?>
                


                <option  <?php if ($resListing['byDefault'] == '1') { ?>selected="selected" <?php } ?> value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['fitName']); ?></option>
                
                <?php } ?>
                </select>
              </label> 
              </div></td> 
              <td width="25%" ><div class="griddiv" style="position:static;">
              <label>
              <div>Language Type</div>  
              <select style="width: 100%" id="languageType" name="languageType" class="validate selectBoxDest" displayname="Language Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 160px;"  >
                  <option value="0">Default</option>
                  <?php 
                  $rs=GetPageRecord('*','tbl_languagemaster','1 and status=1 and deletestatus=0');
                  $totalrow = mysqli_num_rows($rs);
                  while($languageDetails=mysqli_fetch_array($rs)){
                    ?>
                    <option value="<?php echo $languageDetails['id']; ?>"><?php echo $languageDetails['name']; ?></option>
                  <?php } ?>
                </select>
              </label> 
              </div></td> 

              <td width="45%"> 
              <input type="button" value="Select" class="bluembutton" style="background-color: #75c38d !important; margin-left:0px;border: 1px #75c38d solid !important;margin-top: 11px;padding: 3px 15px!important;"  onClick="selectFitFun();"/>
              <a id="clickFun" style=" display:none;"></a>
              <div id="loadadditionalIdCost" style="display:none"></div></td>
              </tr>
              </table>
            </td>
        </tr>

      <!-- ended select section for fit inclusion an exc policy etc-->

        <?php }elseif($fitGit1 == "GIT"){ ?>
              <!-- started select section for GIT inclusion an exc policy etc-->
      <tr>
          <td>
          <link rel="stylesheet" href="css/selectize.css">
          <table border="0" cellpadding="6" cellspacing="0"  width="100%" >
            <tr>
            <td width="25%" ><div class="griddiv" style="position:static;">
            <label>
                    
            <div><?php echo $fitGit1; ?> Name</div>  
              <select id="gitincexNameId" name="gitincexNameId" class=" validate selectBoxDest"  displayname="Name"  >
                <!-- <option value="">Select Inclusion </option> -->
                <?php 
                $rs=GetPageRecord('*','gitIncExcMaster',' deletestatus=0 and status=1 order by gitName desc'); 
                while($resListing=mysqli_fetch_array($rs)){  
                ?>

                <option  <?php if ($resListing['byDefault'] == '1') { ?>selected="selected" <?php } ?> value="<?php echo strip($resListing['id']); ?>" ><?php echo strip($resListing['gitName']); ?></option>
                
                <?php } ?>
                </select>
              </label> 
              </div></td> 
              <td width="25%" ><div class="griddiv" style="position:static;">
              <label>
              <div>Language Type</div>  
              <select style="width: 100%" id="languageType" name="languageType" class="validate selectBoxDest" displayname="Language Type" autocomplete="off"  style="padding: 8px; border: 1px #ccc solid; width: 160px;"  >
                  <option value="0">Default</option>
                  <?php 
                  $rs=GetPageRecord('*','tbl_languagemaster','1 and status=1 and deletestatus=0');
                  $totalrow = mysqli_num_rows($rs);
                  while($languageDetails=mysqli_fetch_array($rs)){
                    ?>
                    <option value="<?php echo $languageDetails['id']; ?>"><?php echo $languageDetails['name']; ?></option>
                  <?php } ?>
                </select>
              </label> 
              </div></td> 

              <td width="45%"> 
              <input type="button" value="Select" class="bluembutton" style="background-color: #75c38d !important; margin-left:0px;border: 1px #75c38d solid !important;margin-top: 11px;padding: 3px 15px!important;"  onClick="selectGitFun();"/>
              <a id="clickFun" style=" display:none;"></a>
              <div id="loadadditionalIdCost" style="display:none"></div></td>
              </tr>
              </table>
            </td>
        </tr>
      <!-- started select section for GIT inclusion an exc policy etc-->
        <?php }  ?>

<!-- ended select section for fit inclusion an exc policy etc-->


            <tr>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="inclusionTitle">Inclusion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="inclusionText" rows="2" id="inclusionText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($editinclusion); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
              </div></td>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="exclusionTitle">Exclusion</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="exclusionText" rows="2" id="exclusionText"  class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($editexclusion); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
              </div></td>
            </tr>
            <tr>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="termsconditionTitle">Terms Condition</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="termsconditionText" rows="2" id="termsconditionText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($edittncText); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
              </div></td>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="cancelationTitle">Cancellation Policies</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="cancelationText" rows="2" id="cancelationText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($editspecialText); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          </td>
            </tr>

            <!-- Started ---- Service upgradation and Optional Tour sec -->
                    <tr>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="serviceupgradeTitle">Service Upgradation</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                  
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="serviceupgradationText" rows="2" id="serviceupgradationText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($serviceupgradationText); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
              </div></td>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="optionaltourTitle">Optional Tour</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="optionaltourText" rows="2" id="optionaltourText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($optionaltourText); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          </td>
            </tr>
              <!-- Ended ---- Service upgradation and Optional Tour sec -->


            <!-- payment policy and Remarks sec started -->
            <tr>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="paymentpolicyTitle">Payment &amp; Policy</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="paymentpolicyText" rows="2" id="paymentpolicyText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php echo stripslashes($editpaymentpolicy); ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
              </div></td>
              <td align="left" valign="top" width="50%"><div style="border:1px solid #ddd; margin-bottom:10px;position:relative; background-color:#FFFFFF;">
                  <table width="100%" border="1" cellpadding="2" cellspacing="0" bordercolor="#CCCCCC" class="tablesorter gridtable">
                    <thead>
                      <tr>
                        <th align="left" bgcolor="#ddd" id="remarksTitle">Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td width="100%" align="left" valign="top" style="padding-left:10px; padding-right:37px; position:relative;"><div class="incBox">
                            <textarea name="remarksText" rows="2" id="remarksText" class="textEditor3" style="width:100%; padding:10px; box-sizing:border-box; border:1px #ccc solid;"><?php 
                      
                              echo $editremarks;
                        
                            ?></textarea>
                        </div></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
          </td>
            </tr>
        <!-- payment policy and Remarks sec ended -->




        
      </tbody>
    </table>
    <div style="display: none;visibility: hidden;" id="loadOverviewFun"></div>
    <div style="display: none;visibility: hidden;" id="loadFitFun"></div>
    <div style="display: none;visibility: hidden;" id="loadGitFun"></div>
    <script type="text/javascript" src="js/selectize.js"></script>
    <script>
     tinymce.remove(".textEditor3");

     function selectOverviewFun(){
        var overviewNameId = $('#overviewNameId').val();
        var languageType = $('#languageType').val();
        var queryId = '<?php echo $resultpage['id']; ?>'; 
        if(overviewNameId!=''){
          $('#loadOverviewFun').load('frmaction.php?overviewNameId=' + overviewNameId + '&languageType=' + languageType + '&action=Itineraryoverview&quotationId=<?php echo $_REQUEST['quotationId']; ?>');
        }
      }



      <?php
      if($quotationData['overviewId']>0){
        ?>
        
        selectOverviewFun();
        
        
        <?php
      }
      if($editinclusion==''){
        if($fitGit1 == "GIT"){?>
          selectGitFun();
          <?php
        }else{?>
          selectFitFun();
          <?php
        }
      }


    // if($editinclusion!=''){
        if($fitGit1 == "GIT"){?>
          selectGitFunEdit();
          <?php
        }else{?>
          selectFitFunEdit();
          <?php
        }
      // }



     


      
   
      ?>

      // Edit part of fit anf git qoutation
      
      // selectFitFunEdit();
      // selectGitFunEdit();



       // FIT Selection Function

       function selectFitFun(){
        var fitincexNameId = $('#fitincexNameId').val();
        var languageTypeId = $('#languageTypeId').val();
        var queryId = '<?php echo $resultpage['id']; ?>'; 
        if(fitincexNameId!=''){
          $('#loadFitFun').load('frmaction.php?action=ItineraryFITANDGIT&fitincexNameId='+fitincexNameId+'&languageId='+languageTypeId+'&quotationId=<?php echo $_REQUEST['quotationId']; ?>&serviceType=FIT');
        }
      }

      // GIT Selection Function
      
      function selectGitFun(){
        var gitincexNameId = $('#gitincexNameId').val();
        var languageType = $('#languageTypeId').val();
        var queryId = '<?php echo $resultpage['id']; ?>'; 
        if(gitincexNameId!=''){
          $('#loadGitFun').load('frmaction.php?action=ItineraryFITANDGIT&fitincexNameId='+gitincexNameId+'&languageId='+languageType+'&quotationId=<?php echo $_REQUEST['quotationId']; ?>&serviceType=GIT');
        }
      }
      





      // Hading Dynamic Code Started 
      function selectFitFunEdit(){
        // var fitincexNameId = $('#fitincexNameId').val();
        var fitincexNameId = '<?php echo $fitGitId; ?>';
        // alert(fitincexNameId);
        var languageTypeId = $('#languageTypeId').val();
        var queryId = '<?php echo $resultpage['id']; ?>'; 
        if(fitincexNameId!=''){
          $('#loadFitFun').load('frmaction.php?action=ItineraryFITANDGITTEXT&fitincexNameId='+fitincexNameId+'&languageId='+languageTypeId+'&quotationId=<?php echo $_REQUEST['quotationId']; ?>&serviceType=FIT');
        }
      }

      // GIT Selection Function
      
      function selectGitFunEdit(){
        // var gitincexNameId = $('#gitincexNameId').val();
        var gitincexNameId = '<?php echo $fitGitId; ?>';
        var languageType = $('#languageTypeId').val();
        var queryId = '<?php echo $resultpage['id']; ?>'; 
        if(gitincexNameId!=''){
          $('#loadGitFun').load('frmaction.php?action=ItineraryFITANDGITTEXT&fitincexNameId='+gitincexNameId+'&languageId='+languageType+'&quotationId=<?php echo $_REQUEST['quotationId']; ?>&serviceType=GIT');
        }
      }
// Hading Dynamic Code Ended 



     // function searchoverviewfun(){
     //    var queryType = "<?php echo $quotationData['queryType']; ?>";
     //    var languageType = $('#languageType').val();
     //    var overviewNameId = $('#overviewNameId').val();
     //    if(overviewNameId!=''){
     //      var url = '&queryType='+queryType+'&languageType='+languageType+'&overviewNameId='+overviewNameId+'&quotationId=<?php echo $_REQUEST['quotationId']; ?>';  
     //      $('#clickFun').attr('onclick', "openinboundpop('action=Itineraryoverview"+url+"','400px');");
     //      $('#clickFun').trigger('click'); 
     //      }else{
     //      alert('Please Select Overview Name');
     //    }
     // }


      
     addTinyMCE();
     function addTinyMCE(){ 
        tinymce.remove(".textEditor3");
        $('.selectBoxDest').selectize();
        tinymce.init({
          selector: ".textEditor3",
          themes: "modern",
          plugins: [
          "advlist autolink lists link image charmap print preview anchor",
          "searchreplace visualblocks code fullscreen"
          ],
          toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });
      }  

      

     

  </script>   

