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
<!-- This is your organization's role hierarchy. For more information, please contact our support representative.--->
 </div>
 
  <div class="xcontent"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><span style="padding-right:20px;">
          <input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New Role" onclick="add();" style="margin-left:0px;" />
        </span>        </td>
        
        <?php if($addpermission==1){ ?>
        <td style="padding-right:20px;"><a href="javascript:Territory.expandAllTerritories();" data-zcqa="security_expandterritories"> </a><a href="javascript:Territory.collapseAllTerritories()" data-zcqa="security_collapseterritories"></a></td>
        <?php } ?>
      </tr>
      
    </table>
  </div>
  
  <div class="xcontent">
  <div class="roletophr">
    <div class="namein"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="hminus" id="tabdivc"  onclick="opencloserolltabs('c');"></div></td>
        <td class="nametd"><?php echo $companynamerole['company']; ?></td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <input name="dids" type="hidden" id="dids" />
    </div>
	<div class="nameinin"  id="rdivc" >
	
	<div class="roletophr">
    
	<div class="namein"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="hminus" id="tabdiv1"  onclick="opencloserolltabs('1');"></div></td>
        <td class="nametd"><div  onclick="view('<?php echo encode('1'); ?>');" style="cursor:pointer;">CEO</div></td>
        <td><div class="roption"><div class="roption">
		<table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><a href="setupsetting.crm?module=role&add=yes&sid=<?php echo encode('1'); ?>" onclick="startloading();"><img src="images/addr.png" width="16" height="16" border="0" /></a></td> 
  </tr>
</table>

		</div></div></td>
      </tr>
    </table></div>
	
  </div>
  <div class="nameinin"  id="rdiv1">Loading...</div>
  
	
	</div>
  <script>
  loadroleinner('1');
  </script>
  </div>
  
  
  </div>
  
 </div></div></form>
<script> 
 


comtabopenclose('linkbox','op2');
</script>