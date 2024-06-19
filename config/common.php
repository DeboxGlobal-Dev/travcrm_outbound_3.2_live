<?php
include_once "dbclass.php";
class Common extends DBClass {

   // used only common function
   
   // menu detail function
	   
	function getMenu($userId,$desigId,$adminType,$privType)
	{
	    if($adminType==0)
		{
		   $sql="select * from  menu order by sort asc";
		}
		 else 
		{
		   
		   if($privType==0)  
		   {
		      // designation wise
			   $sql="select  mn.name,mn.link,mn.parent_id,mn.imgicon,mn.sort from  privilege_designation as desigmenu inner join menu as mn on desigmenu.menuId=mn.id where desigmenu.desigId='".$desigId."' ";	  
		   } else {
		   
		   // for user wise privileges
		    $sql="select  mn.name,mn.link,mn.parent_id,mn.imgicon,mn.sort from  privilege_user as usermenu inner join menu as mn on usermenu.menuId=mn.id where usermenu.userId='".$userId."' ";	
		   
		   }
		   
					
		}
	  
		//echo $sql;
		
		$result=$this->conn->query_result( $sql);
		return $result;	
	}
	
	

	// Clean function remove special character and addslashes
	
	function clean($string)
	{
	      $string=trim($string); 
	     // $string = preg_replace('/[^A-Za-z0-9\'-]/', '', $string); // Removes special chars.
	     // $string= preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one
		  $string=mysql_real_escape_string($string);  // remove sql injection error
		  return addslashes($string);
		  
	}

	// Strip function for slashes strip in string
	
	function strip($string)
	{
		  return stripslashes($string);
		  
	}

	// function encode string value
	
	function encode($string)
	{
		 $string = base64_encode($string);
		 $string = base64_encode($string);
		 $encoded = base64_encode($string);
		 return  $encoded;
		  
	}

	function decode($string)
	{
		 $string = base64_decode($string);
		 $string = base64_decode($string);
		 $decoded = base64_decode($string);
		 return  $decoded;
		  
	}


 // Pagenation using 
 function genPagination($total,$currentPage,$baseLink,$nextPrev=true,$limit=50)
 {

        //$total = Number of rows
		//$currentPage = $pn
		/*
		if (isset($_REQUEST['pn'])) { // Get pn from URL vars if it is present
			$pn = preg_replace('#[^0-9]#i', '', $_REQUEST['pn']); // filter everything but numbers for security(new)
			//$pn = ereg_replace("[^0-9]", "", $_GET['pn']); // filter everything but numbers for security(deprecated)
		} else { // If the pn URL variable is not present force it to be value of page number 1
			$pn = 1;
		}
		*/
		
		// $baseLink =$_SERVER['PHP_SELF'].'?pn=';
		
		    
		if(!$total OR !$currentPage OR !$baseLink)
		{
			return false;
		}
		 
		 $page= $currentPage;  
		//Total Number of pages
		$totalPages = ceil($total/$limit);
		
		//Text to use after number of pages
		$txtPagesAfter = ($totalPages==1)? " page": " pages";
		
		//Start off the list.
		$txtPageList = $page.' of '.$totalPages.$txtPagesAfter.' : &nbsp;';
		
		//Show only 3 pages before current page(so that we don't have too many pages)
		
		$min = ($page - 3 < $totalPages && $currentPage-3 > 0) ? $currentPage-3 : 1;
		
		//Show only 3 pages after current page(so that we don't have too many pages)
	   $max = ($page + 3 > $totalPages) ? $totalPages : $currentPage+3;
		
		//Variable for the actual page links
		$pageLinks = "";
		
		//Loop to generate the page links
		for($i=$min;$i<=$max;$i++)
		{
			if($currentPage==$i)
			{
				//Current Page
				$pageLinks .= '&nbsp; <span class="pagNumActive">'.$i.'</span>';
			}
			else
			{
				$pageLinks .= '&nbsp;<span class="paginationNumbers"><a href="javascript:void(0)" onclick="gotopage('.$i.')" class="page">'.$i.'</a></span>';
			}
		}
		
		if($nextPrev)
		{
			//Next and previous links
			
			$curnext=$currentPage + 1;
			$curprev=$currentPage - 1;
			
			$next = ($currentPage + 1 > $totalPages) ? false : '&nbsp;<a  href="javascript:void(0)" onclick="gotopage('.$curnext.')">Next</a>';
			
			$prev = ($currentPage - 1 <= 0 ) ? false : '&nbsp;<a href="javascript:void(0)" onclick="gotopage('.$curprev.')">Previous</a>';
		}
		
		return $txtPageList.$prev.$pageLinks.$next;
		
 }  
	 
  
 //  
   
   
   
	
}	




function GetPageRecord($select,$tablename,$where){		
$sql3="select ".$select." from ".$tablename." where ".$where."";
$rs3=mysql_query($sql3) or die(mysql_error());
return $rs3;
}
?>