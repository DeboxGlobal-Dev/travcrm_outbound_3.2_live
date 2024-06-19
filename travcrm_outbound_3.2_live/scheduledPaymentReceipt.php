<?php 
include "inc.php";

 $quotationId = decode($_REQUEST['quotationId']);
 $agentPaymentId = decode($_REQUEST['agentPaymentId']);
 $id = decode($_REQUEST['queryId']);

 $b = GetPageRecord('fromDate,toDate',_QUERY_MASTER_,'id="'.$id.'"');
    $queryData = mysqli_fetch_assoc($b);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Document</title> -->
</head>
<body>
    <div>
        <p style="font-size: 15px !important;">
        This is in reference to your Tour Id <strong><?php echo makeQueryTourId($id); ?></strong> and travel dated from <strong><?php echo date('d-m-Y',strtotime($queryData['fromDate'])) ?></strong> To <strong><?php echo date('d-m-Y',strtotime($queryData['toDate'])) ?></strong>.
        <br>
        <br>
        Please find the below mentioned payment schedule.
        <br>
        <br>
        </p>
    </div>
    <table border="1" bordercolor="#ccc" width="100%" cellpadding="10" cellspacing="0">
        <thead>
            <tr><th colspan="3" align="center" style="background: #9292e1; color: #fff; font-size: 22px;">Scheduled Amount</th></tr>
            <tr style="background-color: #f4f4f4 !important;">
                <th>SN.</th>
                <th>Due Date</th>
                <th>Scheduled Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no = 1;
            $a = GetPageRecord('*','agentSchedulePaymentMaster','quotationId="'.$quotationId.'" and agentPaymentId="'.$agentPaymentId.'" and scheduleStatus=1');
            while($scheduleData = mysqli_fetch_assoc($a)){
                ?>

                <tr>
                    <td align="center"><?php echo $no; ?></td>
                    <td align="center"><?php echo date('d-m-Y',strtotime($scheduleData['dueDate'])); ?></td>
                    <td align="center"><?php echo round($scheduleData['amount']); ?></td>
                </tr>
                <?php

                    $scheduledAMT =  $scheduledAMT + $scheduleData['amount'];

                $no++;
            }
            
            ?>
            <tr>
                <td></td>
                <td align="center"><strong>Total Scheduled Cost</strong></td>
                <td align="center"><strong><?php echo round($scheduledAMT); ?></strong></td>
            </tr>
      </tbody>
    </table>
</body>
<br>
<table border="1" bordercolor="#ccc" width="100%" cellpadding="10" cellspacing="0">
    <thead>
       <tr style="background-color: #9292e1 !important; color:#ffffff !important">
            <th>Bank Name</th>
            <th>Account Type</th>
            <th>Beneficiary Name</th>
            <th>Account Number</th>
            <th>IFSC Code</th>
            <th>Branch Swift Code</th>
            <th>Branch Address</th>
       </tr>
    </thead>
    <tbody>
        <?php 
        $b = GetPageRecord('*','bankMaster','setDefault="1" and status=1 and deletestatus=0');
            while($bankData = mysqli_fetch_assoc($b)){
           
        ?>
        <tr>
            <td><?php echo $bankData['bankName']; ?></td>
            <td><?php echo $bankData['accountType']; ?></td>
            <td><?php echo $bankData['beneficiaryName']; ?></td>
            <td><?php echo $bankData['accountNumber']; ?></td>
            <td><?php echo $bankData['branchIFSC']; ?></td>
            <td><?php echo $bankData['branchSwiftCode']; ?></td>
            <td><?php echo $bankData['branchAddress']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
<div>
    <p style="font-size: 15px !important;">For any assistance, please get in touch with us.</p>
</div>
<br>
<br>
</html>