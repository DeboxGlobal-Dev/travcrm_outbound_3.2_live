<?php 
include "inc.php";

 if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){
    $datewhere='and fromDate BETWEEN "'.date('Y-m-d', strtotime($_REQUEST['fromDate'])).'" and "'.date('Y-m-d', strtotime($_REQUEST['toDate'])).'"';
  }
  
        $c1=GetPageRecord('*','guideAllocation','GuideId="'.$_REQUEST['guideId'].'"'. $datewhere.'');
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