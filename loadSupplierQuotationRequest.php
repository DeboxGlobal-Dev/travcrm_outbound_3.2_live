<?php
  include "inc.php";  

  $rs2=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.($_REQUEST['quotationId']).'" '); 
  $quotationData=mysqli_fetch_array($rs2); 

  if($_GET['quotationId']>0){ 
    // http://localhost/GitHub/outbound1.3/travcrm-dev/PreviewFiles/crm_proposal.php?propNum=3&id=VFZSck1VNUJQVDA9
    $downloadLink='<a style="text-decoration: none;" href="'.$fullurl.'PreviewFiles/crm_proposal.php?propNum=5&id='.encode($quotationId2).'">here</a>';
  }

  $select='emailsignature';
  $where='id="'.$_SESSION['userid'].'" and email="'.$_SESSION['username'].'"';
  $rs=GetPageRecord($select,_USER_MASTER_,$where);
  $LoginUserDetails=mysqli_fetch_array($rs);

  $emailsignature = ' ';
  // $emailsignature = '<br><br>'.stripslashes($LoginUserDetails['emailsignature']);
  if(preg_match('/<img(.*)src(.*)=(.*)"(.*)"/U', stripslashes($LoginUserDetails['emailsignature']), $emailsignatureSRC)){
    if($emailsignatureSRC!='' && file_exists($emailsignatureSRC)==true){
      $emailsignature = '<img src='.array_pop($emailsignatureSRC).' width="100%" height="auto" alt="signature" style="max-width:700px;"/>';
    } 
  }  
  ?>
  <form action="frm_action.crm" method="post" enctype="multipart/form-data" name="getpaymentadd" target="actoinfrm"  id="getpaymentadd">
    <!-- <input name="action" id="action" type="hidden" value="addsupplierquote" /> -->
    <input name="action" id="action" type="hidden" value="sendSupplierQuotationRequest" />
    <input name="quotationId2" id="quotationId2" type="hidden" value="<?php echo $_GET['quotationId']; ?>" />
    <div class="griddiv" style="text-align: left;">
      <label style="text-align: left; width: 100%; display: block; font-size: 13px;">Suppliers</label>
      <select id="supplierId2" name="supplierId2[]" class="validate gridfield" displayname="Supplier Name" multiple="multiple" autocomplete="off" style="width:100%;" >
        <option value="0">Select Supplier</option>
        <?php
        $select='';
        $where='';
        $rs='';
        $select='*';
        $where='1 and name!="" and deletestatus=0 order by name asc';
        $rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where);
        while($resListing=mysqli_fetch_array($rs)){ ?>
          <option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$sightseeing){ ?>selected="selected"<?php } ?>><?php echo strip($resListing['name']).'-'.getPrimaryEmail($resListing['id'],'suppliers'); ?></option>
        <?php } ?>
      </select>
      <style>
        .addeditpagebox .griddiv .gridlable {
        width: 100%;
        }
        .contentclass .select2-container, .select2-container.select2-container--default.select2-container--open {
        box-sizing: border-box;
        display: inline-block;
        z-index: 99999999;
        margin: 0;
        position: relative;
        vertical-align: middle;
        }
      </style>
    </div>
    <div class="griddiv">
      <div style="margin-top:10px;">
        <textarea name="supplier_description" cols="" rows="" id="supplier_description" class="gridfield textEditor5"  style="width:100%; height:150px;">Dear Sir, Please share your quotation of mentioned query below</textarea>
      </div>

      <div style="margin-top:10px;">
        <textarea name="supplier_description_pdf" cols="" rows="" id="supplier_description_pdf" class="gridfield textEditor5"  style="width:100%; height:150px;background-color: #fff;">
          <?php 
          $preview = url_get_contents($fullurl.'PreviewFiles/crm_proposal.php?propNum=5&id='.encode($_GET['quotationId']));
          echo removeTagByClass($preview,'calcostsheet'); 
          ?>
          <?php echo '<br><br>Please click '.$downloadLink.' to preview the proposal in web view. <br><br>'.$emailsignature; ?>
        </textarea>
      </div>
      
      <!-- <script src="tinymce/tinymce.min.js"></script> -->
      <script type="text/javascript"  src="plugins/select2/select2.min.js"></script>
      <script type="text/javascript">
        addTinyMCE_supp();
        function addTinyMCE_supp(){ 
          tinymce.remove(".textEditor5");
          tinymce.init({
            selector: ".textEditor5",
            themes: "modern",
            plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
        }  

        $(document).ready(function() {
          $('#supplierId2').select2();
        });
      </script>
      <!-- 
      <div style="margin-top:10px;">
        <label style="text-align: left; width: 100%; display: block; font-size: 13px;">Add more emails</label>
        <input type="text" name="ccSupplier" id="ccSupplier" placeholder="test@example.com,test@example.com" style="width: 96% !important; margin: 0px !important; padding: 8px 10px !important; box-shadow: inset 0 0 2px #ccc !important; border: 1px solid #ccc !important;"/>
      </div> 
      -->
    </div>
  </form>
  <div id="buttonsbox"  style="text-align:center;margin:10px 0px 10px 0">
    <table border="0" align="right" cellpadding="0" cellspacing="0">
    <tr><td  ><input name="addnewuserbtn" type="button" class="bluembutton submitbtn" id="addnewuserbtn" value="   Save    " onclick="formValidation('getpaymentadd','submitbtn','0');" /></td>
    <td ><input name="Cancel" type="button" class="whitembutton" id="Cancel" value="Cancel" onclick="masters_alertspopupopenClose();" /></td>
    </tr>
    </table>
  </div>