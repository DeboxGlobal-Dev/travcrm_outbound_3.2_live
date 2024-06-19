<?php
$select='company'; 
$where='id="'.$loginusersuperParentId.'"'; 
$rs=GetPageRecord($select,_USER_MASTER_,$where); 
$companynamerole=mysqli_fetch_array($rs); 

?>


<link href="css/main.css" rel="stylesheet" type="text/css" />

<form id="listform" name="listform" method="get">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><span id="topheadingmain"><?php echo $pageName; ?></span>
	 
	
	</div></td>
    </tr>
  
</table>
</div>

<div id="pagelisterouter">
 
 
 <div class="roldouter">
 <div class="xcontent"> 
 Backing up your SQL Server databases  and storing copies of backups in a safe, off-site location protects you from potentially catastrophic data loss.  <br />
 <br />
 <a href="config/exportdb.php" target="_blank"><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="Download Database SQL File" style="margin-left:0px;" ></a></div>
 
   
  
   
  
 </div></div></form>
 