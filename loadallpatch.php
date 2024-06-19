<?php
include "inc.php";  
include "config/logincheck.php"; 



if($_REQUEST['id']!=''){

$select2='*';  
$where2='id='.$_REQUEST['id'].'';  
$rs2=GetPageRecord($select2,'patchMaster',$where2);  
$data=mysqli_fetch_array($rs2); 

$patchNo=$data['patchNo'];
} else {
$patchNo=mt_rand(100000, 999999);;
}
?>
<div class="row" style="margin-bottom:10px;">
						
					 
						<div class="col-md-12" style="margin-bottom:10px;">
					<div style="font-size:11px; text-transform:uppercase; margin-bottom:2px;">Patch Number  <span style="font-size:12px; color:#CC3300;">*</span></div>
					<input type="text" class="form-control" id="patchNo" name="patchNo" value="<?php echo $patchNo; ?>"  readonly="readonly" >
                    </div>
						
                     <div class="col-md-12" style="margin-bottom:10px;">
					<div style="font-size:11px; text-transform:uppercase; margin-bottom:2px;">Delivery Branch   <span style="font-size:12px; color:#CC3300;">*</span></div>
					<select id="branchId" name="branchId" class="form-control"> 
											<?php  
											$select='';  
											$where='';  
											$rs='';   
											$select='*';    
											$where=' 1 order by rname';  
											$rs=GetPageRecord($select,'delivery_branch',$where);  
											while($bank=mysqli_fetch_array($rs)){  
											?>
                                                <option value="<?php echo $bank['id']; ?>" <?php if($data['branchId']==$bank['id']){ ?>selected="selected"<?php } ?>><?php echo $bank['rname']; ?></option>
                                           <?php } ?>

                       </select>
                    </div>
					 
					   <div class="col-md-12" style="margin-bottom:10px;">
					<div style="font-size:11px; text-transform:uppercase; margin-bottom:2px;">Select Orders   <span style="font-size:12px; color:#CC3300;">*</span></div>
					<select name="orders[]" size="1" multiple="multiple" class="form-control select2" id="orders"> 
											<?php  
											$newdata = explode(',', $data['orders']); 
											$select='';  
											$where='';  
											$rs='';   
											$select='*';    
											$where=' status="Warehouse Delivered" order by id desc';  
											$rs=GetPageRecord($select,'sys_orders',$where);  
											while($bank=mysqli_fetch_array($rs)){ 
											 
											?>
                                                <option value="<?php echo $bank['id']; ?>" <?php foreach ($newdata as $key => $value) { if($value == $bank['id']){ echo 'selected="selected"'; } }?> ><?php if($bank['branches']=='13'){ echo 'TL'; } else { echo 'US'; } ?>-<?php echo $bank['ordernum']; ?></option>
                                           <?php } ?>

                       </select>
                    </div>
					
  <div class="col-md-12" style="margin-bottom:10px;">
					<div style="font-size:11px; text-transform:uppercase; margin-bottom:2px;">Notes    </div> 
					  <textarea name="notes" rows="3" class="form-control" id="notes"><?php echo $data['notes']; ?></textarea>
                    </p>
  </div>
					
					 
					
					
					 
					
					 
					  
					</div>
					
	 <input name="id" type="hidden" id="id" value="<?php if($_REQUEST['id']!=''){ echo $_REQUEST['id']; } else { echo '0';} ?>">
	<input name="action" type="hidden" id="action" value="addpatch">
	
	
	<script>
	$(document).ready(function() { 
 $("#orders").select2();
});
	</script>