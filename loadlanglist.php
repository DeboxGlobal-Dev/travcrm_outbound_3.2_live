<?php
include "inc.php"; 
mysqli_query("SET NAMES 'utf8'");
mysqli_query('SET CHARACTER SET utf8');
include "config/logincheck.php"; 



$select1='*';  
$where1='id='.$_REQUEST['id'].''; 
$rs1=GetPageRecord($select1,'languageMaster',$where1); 
$editresult=mysqli_fetch_array($rs1);

if($_REQUEST['addnew']=='1'){ 
if(trim($_REQUEST['englishword'])!=''){
$namevalue ='english="'.$_REQUEST['englishword'].'",languageWord="'.$_REQUEST['newhword'].'",parentId="'.$_REQUEST['id'].'"'; 
addlisting('languageListMaster',$namevalue); 
}
}


if($_REQUEST['updateid']!=''){   
$where='id='.$_REQUEST['updateid'].'';   
$namevalue ='english="'.$_REQUEST['englishword'].'",languageWord="'.$_REQUEST['newhword'].'",parentId="'.$_REQUEST['id'].'"'; 
$add = updatelisting('languageListMaster',$namevalue,$where); 
}

?>


<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
 
     <th width="582" align="left" class="header" >English</th>

     <th colspan="2" align="left" class="header sortingbg"><?php echo $editresult['name']; ?></th>
    </tr>
   </thead>

 


 

  <tbody>
   

 <?php 
$select=''; 
$where=''; 
$rs='';  
$select='*';   
$where=' parentId='.$_REQUEST['id'].' order by id asc'; 
$rs=GetPageRecord($select,'languageListMaster',$where); 
while($resultlists=mysqli_fetch_array($rs)){  
?>
  <tr> 
    <td align="left"><input name="" type="text" style="padding:10px; width:100%; box-sizing:border-box; border:1px solid #ccc;" id="englishword<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['english']); ?>"></td> 
    <td align="left"><input name="" type="text" style="padding:10px; width:100%; box-sizing:border-box; border:1px solid #ccc;" id="newhword<?php echo strip($resultlists['id']); ?>" value="<?php echo strip($resultlists['languageWord']); ?>"></td>
    <td align="left"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Update" onclick="editnewword(<?php echo strip($resultlists['id']); ?>);"  style="background-color:#0066CC !important;"/></td>
  </tr> 
	
	<?php   } ?>
	 <tr id="addnewwordtr" > 
    <td align="left"><input name="" type="text" style="padding:10px; width:100%; box-sizing:border-box; border:1px solid #ccc;" id="englishword" ></td> 
    <td width="644" align="left"><input name="" type="text" style="padding:10px; width:100%; box-sizing:border-box; border:1px solid #ccc;" id="newhword"></td>
    <td align="left" width="50"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add" onclick="addnewword();" /></td>
    </tr> 
</tbody></table>

 