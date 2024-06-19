<?php
include "inc.php";
if($_REQUEST['bankId']!='' && $_REQUEST['action'] == 'loadbankDetails'){
        $getdetail = GetPageRecord('*','bankMaster', 'id="'.$_REQUEST['bankId'].'" and deletestatus=0'); 
        $getbankdetail=mysqli_fetch_array($getdetail);
        $bankid=addslashes($getbankdetail['id']);
        $bankName=addslashes($getbankdetail['bankName']);
        $accountType=addslashes($getbankdetail['accountType']);
        $beneficiaryName=addslashes($getbankdetail['beneficiaryName']);
        $accountNumber=addslashes($getbankdetail['accountNumber']);
        $branchAddress=addslashes($getbankdetail['branchAddress']);
        $branchIFSC=addslashes($getbankdetail['branchIFSC']);
        $branchSwiftCode=addslashes($getbankdetail['branchSwiftCode']);
        
        if($getbankdetail['title']!=''){
            $title= addslashes($getbankdetail['title']);
        }else{
            $title= 'Branch&nbsp;IFSC';
        }

      
        ?>
        <script type="text/javascript">
            $('#accountType').val('<?php echo $accountType; ?>');
            $('#beneficiaryName').val('<?php echo $beneficiaryName; ?>');
            $('#accountNumber').val('<?php echo $accountNumber; ?>');
            $('#branchIfsc').val('<?php echo $branchIFSC; ?>');
            $('#branchSwiftCode').val('<?php echo $branchSwiftCode; ?>');
            $('#branchAddress').val('<?php echo $branchAddress; ?>');
            $('#branchchange').html('<?php echo $title; ?>');
        </script>
        <?php
    }
// }

    if($_REQUEST['action']=="updatInvoiceFormat" && $_REQUEST['invoiceId']!=''){
        $formatType  = $_REQUEST['formatType'];
        updatelisting('invoiceMaster','invoiceFormat="'.$formatType.'"','id="'.$_REQUEST['invoiceId'].'"');
        
        ?>
     <script>
        parent.location.reload();
     </script>
        <?php
    }





    // agent payment info started 

if($_REQUEST['bankId']!='' && $_REQUEST['action'] == 'loadbankDetailsPay'){
    $getdetail = GetPageRecord('*','bankMaster', 'id="'.$_REQUEST['bankId'].'" and deletestatus=0'); 
    $getbankdetail=mysqli_fetch_array($getdetail);
    $bankid=addslashes($getbankdetail['id']);
    $bankName=addslashes($getbankdetail['bankName']);
    // $accountType=addslashes($getbankdetail['accountType']);
    // $beneficiaryName=addslashes($getbankdetail['beneficiaryName']);
    $accountNumber=addslashes($getbankdetail['accountNumber']);
    // $branchAddress=addslashes($getbankdetail['branchAddress']);
    // $branchIFSC=addslashes($getbankdetail['branchIFSC']);
    // $branchSwiftCode=addslashes($getbankdetail['branchSwiftCode']);
    
    $getcur = GetPageRecord('currencyCode','queryCurrencyMaster','1 and id="'.$getbankdetail['currencyId'].'"');
    $curName = mysqli_fetch_array($getcur);
    if($getbankdetail['currencyId'] != 0){ 
    
        $currencyCode =  $curName['currencyCode']; 
        
    }
    else{
    
        $currencyCode =  "All"; 
        
    }

  
    ?>
    <script type="text/javascript">
        // var id = '<?php echo $_REQUEST['id']; ?>';
        // $('#accountType'+id).val('<?php echo $accountType; ?>');
        // $('#beneficiaryName'+id).val('<?php echo $beneficiaryName; ?>');
        $('#accountNo').val('<?php echo $accountNumber; ?>');
        // $('#branchIfsc'+id).val('<?php echo $branchIFSC; ?>');
        // $('#branchSwiftCode'+id).val('<?php echo $branchSwiftCode; ?>');
        // $('#branchAddress'+id).val('<?php echo $branchAddress; ?>');
        // $('#currencyType'+id).val('<?php echo $currencyCode; ?>');
    </script>
    <?php
}
// agent payment info ended






// Supplier payment info started 

if($_REQUEST['bankId']!='' && $_REQUEST['action'] == 'loadbankDetailsPaySupp'){
    $getdetail = GetPageRecord('*','bankMaster', 'id="'.$_REQUEST['bankId'].'" and deletestatus=0'); 
    $getbankdetail=mysqli_fetch_array($getdetail);
    $bankid=addslashes($getbankdetail['id']);
    $bankName=addslashes($getbankdetail['bankName']);
    // $accountType=addslashes($getbankdetail['accountType']);
    // $beneficiaryName=addslashes($getbankdetail['beneficiaryName']);
    $accountNumber=addslashes($getbankdetail['accountNumber']);
    // $branchAddress=addslashes($getbankdetail['branchAddress']);
    // $branchIFSC=addslashes($getbankdetail['branchIFSC']);
    // $branchSwiftCode=addslashes($getbankdetail['branchSwiftCode']);
    
    $getcur = GetPageRecord('currencyCode','queryCurrencyMaster','1 and id="'.$getbankdetail['currencyId'].'"');
    $curName = mysqli_fetch_array($getcur);
    if($getbankdetail['currencyId'] != 0){ 
    
        $currencyCode =  $curName['currencyCode']; 
        
    }
    else{
    
        $currencyCode =  "All"; 
        
    }

  
    ?>
    <script type="text/javascript">
        // var id = '<?php echo $_REQUEST['id']; ?>';
        // $('#accountType'+id).val('<?php echo $accountType; ?>');
        // $('#beneficiaryName'+id).val('<?php echo $beneficiaryName; ?>');
        $('#accountNo').val('<?php echo $accountNumber; ?>');
        // $('#branchIfsc'+id).val('<?php echo $branchIFSC; ?>');
        // $('#branchSwiftCode'+id).val('<?php echo $branchSwiftCode; ?>');
        // $('#branchAddress'+id).val('<?php echo $branchAddress; ?>');
        // $('#currencyType'+id).val('<?php echo $currencyCode; ?>');
    </script>
    <?php
}
// Supplier payment info ended







   ?>