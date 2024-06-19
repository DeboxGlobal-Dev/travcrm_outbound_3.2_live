<?php
include "inc.php";   
if($_REQUEST['action']=='saveGalleryPhoto'){
	$fileId=$_REQUEST['fileId'];
	$parentId=$_REQUEST['parentId'];
	$galleryType=$_REQUEST['galleryType'];
	$dateAdded=time(); 
	$addedBy = $_SESSION['userid'];

	$wheredel='fileId='.trim($fileId).' and parentId="'.$parentId.'" and galleryType="'.$galleryType.'" ';
	deleteRecord(_IMAGE_GALLERY_MASTER_,$wheredel);

	$rs1="";
	$rs1=GetPageRecord('id',_IMAGE_GALLERY_MASTER_,' fileId= "'.$fileId.'" and parentId="'.$parentId.'" and galleryType="'.$galleryType.'" and deletestatus=0'); 
	if(mysqli_num_rows($rs1) < 1){
		$namevalue ='fileId="'.$fileId.'",addedBy="'.$addedBy.'",dateAdded="'.$dateAdded.'",parentId="'.$parentId.'",galleryType="'.$galleryType.'"';
		$adds = addlisting(_IMAGE_GALLERY_MASTER_,$namevalue);
		?>
		<script type="text/javascript">
			$('#savePhotoText'+<?php echo $fileId; ?>).html('<i class="fa fa-check-circle"></i>&nbsp;&nbsp;Added');
			$('#savePhotoText'+<?php echo $fileId; ?>).removeAttr('onclick');
		</script> 
		<?php 
	}else{
		?>
		<script type="text/javascript">
			$('#savePhotoText'+<?php echo $fileId; ?>).html('<i class="fa fa-check-circle"></i>&nbsp;&nbsp;Already');
			$('#savePhotoText'+<?php echo $fileId; ?>).removeAttr('onclick');
		</script> 
		<?php	
	}
}
 
?>