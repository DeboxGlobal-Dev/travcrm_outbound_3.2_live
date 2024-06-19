<?php 
    $pageName='CONTACT ENQUIRY DETAILS'; 
    $id=$_REQUEST['cid'];
    $select1='*';  
    $where1='id="'.$id.'"'; 
    $rs1=GetPageRecord($select1,_POST_LIST_MASTER_,$where1); 
    $editresult=mysqli_fetch_array($rs1);
?>
  <link href="css/main.css" rel="stylesheet" type="text/css" />
  <style type="text/css">
    .review_detail{
      padding: 30px 10px;
      width: 100%;
      position: relative;
      display: inline-block;
    }
    .package_name{
      padding: 10px 10px;
      height: 82px;
      width: 100%;
      position: relative;
      display: inline-block;
    }
    .wecare_review_img{
      padding: 10px 10px;
      height: auto;
      width: 100%;
      position: relative;
      overflow: hidden;
      display: inline-block;
    }
    .review_img{
      width: 100px;
        height: 80px;
        border: 1px solid #eee;
    }
    .gradiantbtn {
      border: 1px #3b3e48 solid;
      padding: 5px 10px;
      outline: 0px;
      background-color: #3b3e48;
      color: #fff;
      border-radius: 4px;
    }
  </style>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="91%" align="left" valign="top">
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm" style="margin-left:30px;"><span id="topheadingmain"><?php echo $pageName; ?></span>
  </div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td>        </td>
        <?php if($addpermission==1){ ?>
        <td style="padding-right:20px;"><a href="showpage.crm?module=cms&page=cont_enquiry">
      <input type="button" name="Submit2" value="Back To List" class="gradiantbtn" />
    </a></td>
        <?php } ?>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>
<div id="pagelisterouter" style="padding-left:30px;">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
    <th colspan="8" align="left" class="header" >
      <table width="100%" border="0" cellpadding="8" cellspacing="0">
        <tr>
          <td width="5%" align="left" valign="top"><span class="fa fa-angle-right"></span></td>
          <td width="20%" align="left" valign="top">Name</td>
          <td width="75%" align="left" valign="top"><?php  echo stripslashes($editresult['title']); ?></td>
        </tr>     
        <tr>
          <td width="5%" align="left" valign="top"><span class="fa fa-angle-right"></span></td>
          <td width="20%" align="left" valign="top">Mobile No. </td>
          <td width="75%" align="left" valign="top"><?php  echo stripslashes($editresult['home_text']); ?></td>
        </tr>
        <tr>
          <td width="5%" align="left" valign="top"><span class="fa fa-angle-right"></span></td>
          <td width="20%" align="left" valign="top">Email</td>
          <td width="75%" align="left" valign="top"><?php  echo stripslashes($editresult['email']); ?></td>
        </tr>
        <tr> 
          <td width="5%" align="left" valign="top"><span class="fa fa-angle-right"></span></td>
          <td width="20%" align="left" valign="top">Enquiry Date </td>
          <td width="75%" align="left" valign="top"><?php  echo date("d-m-Y", strtotime($editresult['adddate'])); ?></td>
        </tr>
        <tr>
          <td width="5%" align="left" valign="top"><span class="fa fa-angle-right"></span></td>
          <td width="20%" align="left" valign="top">Comment</td>
          <td width="75%" align="left" valign="top" style="text-transform: initial;letter-spacing: 0.4px;font-weight: 400;">
              <?php  
              echo stripslashes($editresult['description']); 
              ?>
          </td>
        </tr>
    <!-- <tr>
          <td width="24%" align="left" valign="top">City</td>
          <td width="76%" align="left" valign="top"><?php  //echo stripslashes($editresult['city']); ?></td>
        </tr>
        <tr>
          <td width="24%" align="left" valign="top">Country</td>
          <td width="76%" align="left" valign="top"><?php  //echo stripslashes($editresult['country']); ?></td>
        </tr>
        <tr>
          <td width="24%" align="left" valign="top">Address</td>
          <td width="76%" align="left" valign="top"><?php  //echo stripslashes($editresult['address']); ?></td>
        </tr>
        <tr>
          <td width="24%" align="left" valign="top">Pickup Address</td>
          <td width="76%" align="left" valign="top"><?php  //echo stripslashes($editresult['pickup_address']); ?></td>
        </tr>
      -->
      </table>
      </th>
      </tr>
   </thead>
  </table>
</div>
</td>
  </tr>
</table>

<script> 
window.setInterval(function(){ 
      checked = $("#listform .gridtable td input[type=checkbox]:checked").length;
    
      if(!checked) { 
    $("#deactivatebtn").hide();
    $("#topheadingmain").show();
      } else {
    $("#deactivatebtn").show();
    $("#topheadingmain").hide();
    } 
}, 100);




comtabopenclose('linkbox','op2');
</script>