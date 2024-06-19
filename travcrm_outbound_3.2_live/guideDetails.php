<?php 
  include "inc.php";

  if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
 ?>
  <div style="border: 1px solid #80808069;">
  <div style="background-color: #57a0a4;color: #ffffff;border: 1px solid #57a0a4;text-align: center;margin-bottom: 12px;padding: 5px;"><strong>Booking Details&nbsp;-&nbsp;<?php if($_REQUEST['fromDate']!=''){ echo date('d-m-Y',strtotime($_REQUEST['fromDate'])); } ?></strong></div>
  <div style="margin-bottom: 12px;">
   <form> 
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
               <tr>
                 <td width="58%"></td>
                 <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="fromDate12" name="fromDate12" style="text-align:left;width: 122px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['fromDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['fromDate'])); }?>"></td>
                <td width="1%"></td>
                 
                  <td width="15%" style="padding:0px 0px 0px 10px;"><input type="date" class="gridfield" id="toDate12" name="toDate12" style="text-align:left;width: 122px;
    border: 1px solid #ccc;padding: 3px!important;border-radius: 2px;" value="<?php if($_REQUEST['toDate']!=''){ echo date('Y-m-d',strtotime($_REQUEST['toDate'])); } ?>"></td>
                <td width="1%"></td>
                 <td width="10%" style="padding:0px 0px 0px 10px;"><input type="button" name="Submit2" value="Search" class="inptSearcpd" onclick="bookingdes()" style="width: 100px !important; background-color: #57a0a4; border: 1px solid #57a0a4; color: #fff; padding: 5px; text-align: center; border-radius: 2px;margin-right: 7px;cursor:pointer;"></td>
               </tr>
           </table>
    </form>       
  </div>
  <div style="margin-bottom: 0px;">        
  <table width="100%"  border="1" cellpadding="4" cellspacing="0" bordercolor="#ccc"  class="tablesorter gridtable">
     <thead>
        <tr>
        <th width="20%" align="left" style="background-color: #80808029;">Guide Name</th>
        <th width="15%" align="left" style="background-color: #80808029;">Contact No</th>
        <th width="15%" align="left" style="background-color: #80808029;">Email Address</th>
        <th width="20%" align="left" style="background-color: #80808029;">Service</th>
        <th width="15%" align="left" style="background-color: #80808029;">Day Type</th>
        <th width="20%" align="left" style="background-color: #80808029;">Booking Date</th>
      </tr>
     </thead>
     <tbody id="bookingDetails">
      <?php 
        $c1=GetPageRecord('*','guideAllocation','GuideId="'.$_REQUEST['guideId'].'" and GuideId!=""'.$datewhere.'');
        $countno = mysqli_num_rows($c1);
        if($countno>0){
          while ($guideQuotData=mysqli_fetch_array($c1)) {
            $rsg = GetPageRecord('*',_GUIDE_MASTER_,' id = "'.$guideQuotData['GuideId'].'"'); 
            $guidedata = mysqli_fetch_array($rsg);

            $rs=GetPageRecord('*',_QUOTATION_GUIDE_MASTER_,'id="'.$guideQuotData['guideQuoteId'].'" order by id desc '); 
            $resultlists=mysqli_fetch_array($rs);

            $selectd = '*';   
            $whered= 'id="'.$resultlists['tariffId'].'"'; 
            $rsd = GetPageRecord($selectd,'dmcGuidePorterRate',$whered); 
            $guideDate = mysqli_fetch_array($rsd);

            $rs11 = GetPageRecord('*','tbl_guidesubcatmaster',' id = "'.$resultlists['guideId'].'"'); 
            $guideCat = mysqli_fetch_array($rs11); 

       ?>
        <tr>
          <td align="left"><?php echo $guidedata['name']; ?></td>
          <td align="left"><?php echo $guidedata['phone']; ?></td>
          <td align="left"><?php echo $guidedata['email']; ?></td>
          <td align="left"><?php echo $guideCat['name']; ?></td>
          <td align="left"><?php echo $guideDate['dayType']; ?></td>
          <td align="left"><?php echo date('d-m-Y',strtotime($guideQuotData['fromDate'])); ?></td>
        </tr>
      <?php }}else{?>

   <tr>
          <td align="center" colspan="6">No Record Found..</td>
    </tr>

<?php } ?>
 
   
     </tbody>

  <style>
  .selectParentList2{
  border: 1px solid;
    padding: 3px 15px;
    text-align: center;
    font-size: 13px;
    border-radius: 3px;
    background-color:#4caf50;
    cursor: pointer;
    color: #fff;

  }
  </style>
<script type="text/javascript">
  function bookingdes() {
    var fromDate = $('#fromDate12').val();
    var toDate = $('#toDate12').val();
    var guideId = '<?php echo $_REQUEST['guideId']; ?>';
    $('#bookingDetails').load('loadguidedetailsv.php?fromDate='+fromDate+'&toDate='+toDate+'&guideId='+guideId);
  }  

</script>
  </table>
  </div>
  </div> 
