<?php
include 'inc.php';

if($_REQUEST['clientType']!=2){
?>
    <option value="">Select Agent</option>
<?php
    $a12=GetPageRecord('*',_CORPORATE_MASTER_,' 1 and name!="" and deletestatus=0  order by name asc');
    while($agentData=mysqli_fetch_array($a12)){
    ?>
    <option <?php echo "value='".strip($agentData['id'])."'"; if(isset($_REQUEST['agentCode']) && $_REQUEST['agentCode']==strip($agentData['id'])){echo 'selected';} ?> ><?php echo $agentData['name'];?></option>
    <?php
    }

}elseif($_REQUEST['clientType']==2){
    ?>
    <option value="">Select Client/B2C</option>
<?php
    $a12=GetPageRecord('*',_CONTACT_MASTER_,' 1 and contactType=2 and deletestatus=0 ');
    while($clientData=mysqli_fetch_array($a12)){
    ?>
    <option value="<?php echo $clientData['id']; ?>"><?php echo $clientData['firstName'].' '.$clientData['lastName'];?></option>
    <?php
    }
}



?>