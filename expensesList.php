<?php 
include "inc.php"; 

if($_REQUEST['action']=="loadExpenseList" ){
    $queryId = decode($_REQUEST['queryId']);
?>

<style>
    .expIn{    
        width: 72%;
        height: 30px;
    }
</style>
<?php 
    $no=1;
    $res = GetPageRecord('*','quotationExpensesMaster','queryId="'.$queryId.'" and status=1 and deletestatus=0');
    if(mysqli_num_rows($res)>0){
?>
<table width="100%" border="1" cellpadding="10" cellspacing="0" bordercolor="#ccc">
    <thead>
        <tr>
            <th align="center" class="header">SN</th>
            <th width="15%" align="left" class="header">Expense Date</th>
            <th width="15%" align="left" class="header">Expense Type</th>
            <th width="15%" align="left" class="header">Amount</th>
            <th width="35%" align="left" class="header" >Narration</th>
            <th width="15%" align="left" class="header" >Paid To</th>
            <th width="10%" align="left" class="header" >Edit</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while($resListing=mysqli_fetch_assoc($res)){  
            $res2 = GetPageRecord('*','expenseTypeMaster','id="'.$resListing['expenseTypeId'].'"');
            $expenseType = mysqli_fetch_assoc($res2);

            $res3 = GetPageRecord('*','queryCurrencyMaster','id="'.$resListing['currencyId'].'"');
            $curr = mysqli_fetch_assoc($res3);
        ?>
        <tr>
        <td align="center"><?php echo $no; ?></td>
        <td align="left"><?php echo date("d-m-Y",strtotime($resListing['expenseDate'])); ?></td>
        <td align="left"><?php echo $expenseType['name']; ?></td>
        <td align="left"><?php echo $curr['name'].' '.$resListing['expenseAmount']; ?></td>
        <td align="left"><?php echo $resListing['remarks']?></td>
        <td align="left"><?php echo $resListing['paidTo']?></td>
        <td align="left"><a href="#" style="padding: 5px;" onClick="alertspopupopen('action=updateExpesesList&queryId=<?php echo $resListing['queryId']; ?>&expenseId=<?php echo $resListing['id']; ?>','1030px','auto');">Edit</a></td>
        
        </tr>
        <?php $no++; } ?>
    </tbody>
</table>
<?php 
}else{
    echo "<div style='font-weight:500; color:#adadad; font-size:16px;padding:15px;'>No Expense</div>";
}

 }
?>

 <!-- <script>
  $("#checkAll").click(function () {
     $('input:checkbox').not(this).prop('checked', this.checked);
 });
 </script> -->