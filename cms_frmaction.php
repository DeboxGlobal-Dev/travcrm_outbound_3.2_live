<?php
ob_start();
include "inc.php"; 
include "config/logincheck.php"; 
include 'smart_resize_image.function.php';
// autocrop the
?>
<script src="js/jquery-1.11.3.min.js"></script>  
<?php
if(trim($_POST['action'])=='addedit_amenities'){ 
	$name=clean($_POST['name']);   
	$status=clean($_POST['status']); 
	$editId=clean($_POST['editId']); 
	if(!empty($_FILES['hotelImage']['name'])){  
		$file_name=str_replace(' ', '_',time().$_FILES['hotelImage']['name']);  
		copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
	}
	else{
		$file_name=str_replace(' ', '_',$_REQUEST['hotelImage2']);
	}
	$dateAdded=time();
	$namevalue ='name="'.$name.'",image="'.$file_name.'",status="'.$status.'"';   
	$where='id='.$_POST['editId'].''; 
	if($editId!='') {
		$update = updatelisting(_AMENITIES_MASTER_,$namevalue,$where); 
	}
	else {
		$adds = addlisting(_AMENITIES_MASTER_,$namevalue);
	}

	?>
	<script>
		parent.setupbox('showpage.crm?module=amenities&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
	</script> 
	<?php  
}
?>

<?php
if(trim($_POST['action'])=='addedit_inclusion' && trim($_POST['module'])!=''){ 
		$name=clean($_POST['name']); 
		$editId=clean($_POST['editId']); 
		if(!empty($_FILES['hotelImage']['name'])){  
			$file_name=str_replace(' ', '_',time().$_FILES['hotelImage']['name']);  
			copy($_FILES['hotelImage']['tmp_name'],"packageimages/".$file_name); 
		}
		else{
			$file_name=str_replace(' ', '_',$_REQUEST['hotelImage2']);
		}
		$dateAdded=time();
		$modifyDate=time();
		$where='id='.$_POST['editId'].''; 

		if($editId!='') {
			$namevalue ='name="'.$name.'",image="'.$file_name.'",modifyDate="'.$modifyDate.'",modifyBy="'.$_SESSION['userid'].'"';  
			$update = updatelisting(_PACKAGE_INCLUSION_MASTER_,$namevalue,$where); 
		}
		else {
			$namevalue ='name="'.$name.'",image="'.$file_name.'",dateAdded="'.$dateAdded.'",addedBy="'.$_SESSION['userid'].'"';  
			$adds = addlisting(_PACKAGE_INCLUSION_MASTER_,$namevalue);
		}
		?>
		<script>
		parent.setupbox('showpage.crm?module=<?php echo $_POST['module']; ?>&alt=<?php if($editId!=''){echo '2';}else {echo '1';}?>');
	</script> 
	<?php 
} 
?>

<?php
if(trim($_POST['action'])=='cms_add_gallery' && trim($_POST['title'])!=''){ 

	if($_FILES['file1']['name']!=''){ 
		echo $file_name=$_FILES['file1']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

	 	$image=$file_name;
	} 
	else {
		$image=$_REQUEST['feature_img'];
	}

	$type='memoriesGallery';
	$title=clean($_POST['title']);
	// multipale package theme for gallery Images
	$package_themeData=$_POST['package_theme'];
	$package_theme = implode(",", $package_themeData);

	// multipale package Destiation for gallery Images
	$package_destination=$_POST['destination'];
	$destination = implode(",", $package_destination);
	// End of multiple package Destiation image gallery 

	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		parent.setupbox('showpage.crm?module=cms&page=gallery&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$package_theme.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
			parent.setupbox('showpage.crm?module=cms&page=gallery&alt=2');
		</script> 
		<?php 
	}
}
?>

<?php
if(trim($_POST['action'])=='cms_add_images' && trim($_POST['title'])!=''){ 

	if($_FILES['file1']['name']!=''){ 
		echo $file_name=$_FILES['file1']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['file1']['tmp_name'],"upload/".$file_name);

	 	$image=$file_name;
	} 
	else {
		$image=$_REQUEST['feature_img'];
	}
	$type='memoriesImages';
	$title=clean($_POST['title']);
	    // multipale package theme for gallery Images
	    $package_themeData=$_POST['package_theme'];
	    $package_theme = implode(",", $package_themeData);

	    // multipale package Destiation for gallery Images
	    $package_destination=$_POST['destination'];
	    $destination = implode(",", $package_destination);
	    // End of multiple package Destiation image gallery 
		
	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$cid=$_POST['cid'];
	$add_date=time();

	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
			parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=1');
		</script> 
	<?php 
	} 
	else {
		$cid=$_POST['cid'];
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",subcategory="'.$destination.'",category="'.$cid.'",type="'.$type.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
			parent.setupbox('showpage.crm?module=cms&page=add-images&cid=<?php echo $cid;?>&alt=2');
		</script> 
		<?php 
	}
} 
?>

<?php
if(trim($_POST['action'])=='cms_add_blog' && trim($_POST['title'])!=''){
    // blogs images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		$image1 = getfilename($post_img); // rename the file befor upload
		// get the full size image
		if(makeDir('upload/blogs/') === true){
			$directoryName ='upload/blogs/';
			$targetedFile = $directoryName.$image1; // save custom name and full path after upload/ foldeer to database
			$width      = 750; //$_POST['width'];
			$height     = 490; //$_POST['height'];
			$quality    = 60; //$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , true , false ,$quality ); //excute the code to resize image
		}
        // get the thumb image 
        if(makeDir('upload/blogs/_thumb/') === true){
            $directoryName ='upload/blogs/_thumb/';
            $targetedFile = $directoryName.$image1; // uploaded file path with customize name
            $width      = 90; //$_POST['width'];
            $height     = 70; //$_POST['height'];
            $quality    = 60;//$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $targetedFile , true , false ,$quality ); //excute the code to resize image
        }
	} 
	else {
		$image1=$_REQUEST['image2'];
	}

	if($_FILES['image3']['name']!=''){
	    $post_img = $_FILES['image3']['name'];
		$temp_img = $_FILES['image3']['tmp_name'];//full path of the image of OR temp path of the file
		$fileName = getfilename($post_img); // rename the file befor upload
	    // get the thumb image 
        if(makeDir('upload/users/') === true){
            $directoryName ='upload/users/';
            $image3 = $directoryName.$fileName; // uploaded file path with customize name
            $width      = 200; //$_POST['width'];
            $height     = 200; //$_POST['height'];
            $quality    = 80;//$_POST['quality'];
            smart_resize_image($temp_img , null, $width , $height , false , $image3 , false , false ,$quality ); //excute the code to resize image
        }
	} 
	else {
		$image3=$_REQUEST['image4'];
	}
	// image code **************************************************************************

	$type='blog';
	$post_date=clean($_POST['post_date']);
	$post_date=date("Y-m-d", strtotime($post_date));
	$title=clean($_POST['title']);
	$home_text=clean($_POST['home_text']);
	$description=clean($_POST['description']);

	// multipale package theme for gallery Images
	$detail1Data=$_POST['detail1'];
	$category = implode(",", $detail1Data);
	// multipale package theme for gallery Images
	// $tagsData=$_POST['detail2'];
	// $tags = implode(",", $tagsData);
	$tags=$_POST['detail2'];


	// 	$feature_img2=clean($_POST['image2']);
	$designation=clean($_POST['designation']);
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		echo $namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",detail1="'.$category.'",detail2="'.$tags.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",type="'.$type.'",image3="'.$image3.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue);
		?>
		<script>
			parent.setupbox('showpage.crm?module=cms&page=blog&alt=1');
		</script>

		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].'';
		echo $namevalue ='title="'.$title.'",description="'.$description.'",designation="'.$designation.'",detail1="'.$category.'",detail2="'.$tags.'",home_text="'.$home_text.'",post_date="'.$post_date.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",type="'.$type.'",image3="'.$image3.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
			parent.setupbox('showpage.crm?module=cms&page=blog&alt=2');
		</script>
		<?php 
	}
}
?>

<?php
if(trim($_POST['action'])=='cms_add_banner' && trim($_POST['title'])!=''){ 
	// banner images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/banners/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/banners/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 900; //$_POST['width'];
			$height     = 450; //$_POST['height'];
			$quality    = 60;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image12'];
	}
	// image code **************************************************************************
	
	$type='banner';


	$title=clean($_POST['title']);

	// multipale package theme for gallery Images
	$package_themeData=$_POST['package_theme'];
	$package_theme = implode(",", $package_themeData);
	// multipale package Destiation for gallery Images
	$package_destination=$_POST['destination'];
	$destination = implode(",", $package_destination);
	// End of multiple package Destiation image gallery 
	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	
	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);

	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=banner&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=banner&alt=2');
		</script> 
		<?php 
	} 
}
?> 



<!--hote deals staretd -->


<?php
if(trim($_POST['action'])=='cms_add_hotdeal' && trim($_POST['title'])!=''){ 
	// banner images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/banners/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/banners/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 337; //$_POST['width'];
			$height     = 650; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image12'];
	}
	// image code **************************************************************************
	
	$type='hotdeal';


	$title=clean($_POST['title']);
	// multipale package theme for gallery Images
	$package_themeData=$_POST['package_theme'];
	$package_theme = implode(",", $package_themeData);
	// multipale package Destiation for gallery Images
	$package_destination=$_POST['destination'];
	$destination = implode(",", $package_destination);
	// End of multiple package Destiation image gallery 
	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	
	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);

	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=hotdeal&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=hotdeal&alt=2');
		</script> 
		<?php 
	} 
}
?> 

<!--Hote Deals ended-->


<?php
if(trim($_POST['action'])=='cms_add_Destbanner' && trim($_POST['title'])!=''){ 
	// banner images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/banners/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/banners/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 337; //$_POST['width'];
			$height     = 650; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image12'];
	}
	// image code **************************************************************************
	
	$type='Destbanner';


	$title=clean($_POST['title']);
	// multipale package theme for gallery Images
	$package_themeData=$_POST['package_theme'];
	$package_theme = implode(",", $package_themeData);
	// multipale package Destiation for gallery Images
	$package_destination=$_POST['destination'];
	$destination = implode(",", $package_destination);
	// End of multiple package Destiation image gallery 
	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	
	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);

	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=Destbanner&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=Destbanner&alt=2');
		</script> 
		<?php 
	} 
}
?> 





<?php
if(trim($_POST['action'])=='cms_ourvideo' && trim($_POST['title'])!=''){ 
	
	if($_FILES['file1']['name']!=''){ 
		$datef = time();
		$file_name=$_FILES['file1']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
		$image=$file_name;
	} 
	else{
		$image=$_REQUEST['feature_img'];
	}

	$type='ourvideo';
	$title=clean($_POST['title']);
	$description=clean($_POST['description']);
	$status=clean($_POST['status']);
	$summer_video=clean($_POST['summer_video']);
	$winter_video=clean($_POST['winter_video']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",summer_video="'.$summer_video.'",winter_video="'.$winter_video.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=ourvideo&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",summer_video="'.$summer_video.'",winter_video="'.$winter_video.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  	parent.setupbox('showpage.crm?module=cms&page=ourvideo&alt=2');
		</script> 
		<?php 
	} 
} 
?>

<?php
if(trim($_POST['action'])=='cms_addedit_review' && trim($_POST['title'])!=''){ 
	if($_FILES['file1']['name']!=''){ 
		echo $file_name=$_FILES['file1']['name']; 
		$ext=$file_name;
		$file_name=str_replace (" ", "",$datef.$ext);
		copy($_FILES['file1']['tmp_name'],"upload/".$file_name);
		$image=$file_name;
	} else {
		$image=$_REQUEST['feature_img'];
	}
	$type='banner';
	$title=clean($_POST['title']);
	// multipale package theme for gallery Images
	$package_themeData=$_POST['package_theme'];
	$package_theme = implode(",", $package_themeData);
	// multipale package Destiation for gallery Images
	$package_destination=$_POST['destination'];
	$destination = implode(",", $package_destination);
	// End of multiple package Destiation image gallery 
	$home_text=clean($_POST['home_text']); 
	$description=clean($_POST['description']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=banner&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",feature_img="'.$image.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=banner&alt=2');
		</script> 
	<?php 
	}
} 
?>

<?php
if(trim($_POST['action'])=='cms_add_client' && trim($_POST['title'])!=''){ 
	// our clients
	// company images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/sponsors/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/sponsors/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 120; //$_POST['width'];
			$height     = 80; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image11'];
	}
    // 	*********************************************************
	$type='clients';
	$title=clean($_POST['title']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();

	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);



	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=clients&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=clients&alt=2');
		</script> 
		<?php 
	}
}
?>	 


<?php
if(trim($_POST['action'])=='cms_add_awards' && trim($_POST['title'])!=''){ 
// our award and affiliations
	// awards images upload *************************************************************************
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/awards/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/awards/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 189; //$_POST['width'];
			$height     = 102; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , false , false ,$quality ); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image11'];
	}
    // 	*********************************************************
	$type='awards';
	$title=clean($_POST['title']);
	$category=clean($_POST['category']);
	$status=clean($_POST['status']);
	$adduser=$_SESSION['userid'];
	$edituser=$_SESSION['userid'];
	$edit_date=date("Y-m-d H:i:s");
	$lastip=$_SERVER['REMOTE_ADDR'];
	$id=$_POST['id'];
	$add_date=time();
	
	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);

	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",category="'.$category.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$adduser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=awards&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",category="'.$category.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$adduser.'"';
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=awards&alt=2');
		</script> 
		<?php 
	}
}
?>	 


<?php
if(trim($_POST['action'])=='cms_add_client_testimonials' && trim($_POST['title'])!=''){ 
	// user photo
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/client_testimonials/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/client_testimonials/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 200; //$_POST['width'];
			$height     = 200; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , true , false ,$quality, false); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image11'];
	}

	// web review testimonial backgorun image 
	if($_FILES['image2']['name']!=''){ 
		$post_img = $_FILES['image2']['name'];
		$temp_img = $_FILES['image2']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/client_testimonials/medium') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/client_testimonials/medium';
			$image2 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 680; //$_POST['width'];
			$height     = 700; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image2 , true , false ,$quality, false ); //excute the code to resize image
		} 
	} 
	else {
		$image2=$_REQUEST['image21'];
	}

    // 	*********************************************************
	$type='client_testimonials';
	$title=trim($_POST['title']); // testimonial subject
	$home_text=trim($_POST['home_text']); // User Name
	$designation=trim($_POST['designation']); // city Name
	$city=trim($_POST['city']); // city Name
	$srn=trim($_POST['srn']); // srn Name
	$category=trim($_POST['category']); // star rating
	$description=trim($_POST['description']); // star rating
	$status=trim($_POST['status']); // revie status
	$adduser=$_SESSION['userid']; // add user 
	$edituser=$_SESSION['userid']; // edit user
	$edit_date=date("Y-m-d H:i:s"); // edit date 
	$lastip=$_SERVER['REMOTE_ADDR']; // last ip
	$id=$_POST['id']; // edit id
	$add_date=date("Y-m-d H:i:s"); 
	
	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);


	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",type="'.$type.'",home_text="'.$home_text.'",designation="'.$designation.'",description="'.$description.'",city="'.$city.'",srn="'.$srn.'",category="'.$category.'",image1="'.$image1.'",image2="'.$image2.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$addusser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=client_testimonials&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",type="'.$type.'",home_text="'.$home_text.'",designation="'.$designation.'",description="'.$description.'",city="'.$city.'",srn="'.$srn.'",category="'.$category.'",image1="'.$image1.'",image2="'.$image2.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$edituser.'"'; 
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=client_testimonials&alt=2');
		</script> 
		<?php 
	}
}
?>	 


<?php
if(trim($_POST['action'])=='cms_add_core_values' && trim($_POST['title'])!=''){ 
	// user photo
	if($_FILES['image1']['name']!=''){ 
		$post_img = $_FILES['image1']['name'];
		$temp_img = $_FILES['image1']['tmp_name'];//full path of the image of OR temp path of the file
		// get the full size image
		if(makeDir('upload/') === true){
			$fileName = getfilename($post_img); // rename the file befor upload
			$directoryName ='upload/';
			$image1 = $directoryName.$fileName; // uploaded file path with customize name
			$width      = 200; //$_POST['width'];
			$height     = 200; //$_POST['height'];
			$quality    = 100;//$_POST['quality'];
			smart_resize_image($temp_img , null, $width , $height , false , $image1 , true , false ,$quality, false); //excute the code to resize image
		} 
	} else {
		$image1=$_REQUEST['image11'];
	}

    // 	*********************************************************
	$type='core_values';
	$srn=trim($_POST['srn']); //serial number 
	$title=trim($_POST['title']); // testimonial subject
	$description=trim($_POST['description']); // star rating
	$status=trim($_POST['status']); // revie status
	$adduser=$_SESSION['userid']; // add user 
	$edituser=$_SESSION['userid']; // edit user
	$edit_date=date("Y-m-d H:i:s"); // edit date 
	$lastip=$_SERVER['REMOTE_ADDR']; // last ip
	$id=$_POST['id']; // edit id
	$add_date=date("Y-m-d H:i:s"); 

	// metas
	$meta_title=clean($_POST['meta_title']);
	$meta_description=clean($_POST['meta_description']);
	$meta_keyword=clean($_POST['meta_keyword']);


	if(trim($_POST['editId'])==''){
		$namevalue ='title="'.$title.'",srn="'.$srn.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",add_date="'.$add_date.'",adduser="'.$addusser.'"';  
		$adds = addlisting(_POST_LIST_MASTER_,$namevalue); 
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=core_values&alt=1');
		</script> 
		<?php 
	} 
	else {
		$where='id='.$_POST['editId'].''; 
		$namevalue ='title="'.$title.'",srn="'.$srn.'",type="'.$type.'",description="'.$description.'",meta_title="'.$meta_title.'",meta_description="'.$meta_description.'",meta_keyword="'.$meta_keyword.'",image1="'.$image1.'",status="'.$status.'",edit_date="'.$edit_date.'",edituser="'.$edituser.'"'; 
		$update = updatelisting(_POST_LIST_MASTER_,$namevalue,$where);
		?>
		<script>
		  parent.setupbox('showpage.crm?module=cms&page=core_values&alt=2');
		</script> 
		<?php 
	}
}
?>	 
