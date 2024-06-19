<?php
include "inc.php"; 
include "config/logincheck.php"; 
$id=$_REQUEST['id'];
?>

<div class="roletophr">
    
	<div class="namein"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="hplus">s</div></td>
        <td class="nametd"><?php echo $companynamerole['company']; ?></td>
        <td>&nbsp;</td>
      </tr>
    </table></div>
	
  </div>
  <div class="nameinin"  id="rdivc">Loading...</div>
  <script>
  loadcrminner('');
  </script>