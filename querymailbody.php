<?php 
header('Content-Type: text/html; charset=ISO-8859-1'); 
include "inc.php"; 
include "config/logincheck.php";

function makehtml($html){
	$html=str_replace('</d=iv>','</div>',$html);
	$html=str_replace('</b=>','</b>',$html);
	$html=str_replace('lang=3DEN-US =','',$html);
	$html=str_replace('</o:p>','</op>',$html);
	$html=str_replace('<di=v>','<div>',$html);
	$html=str_replace('</b=>','</b>',$html);
	$html=str_replace('spa=n','span',$html);
	$html=str_replace('o:p','op',$html);
	$html=str_replace('3D','',$html);
	$html=str_replace('<=a','<a',$html);
	$html=str_replace('blockquote =','blockquote',$html);
	$html=str_replace('span =','span',$html);
	$html=str_replace('s=pan =','span',$html);
	$html=str_replace('tr=','tr',$html);
	$html=str_replace('data-x-src="','src="',$html);
	return $html;
}

$rsw=GetPageRecord('description',_QUERYMAILS_MASTER_,'id="'.($_REQUEST['mailId']).'" order by id desc');  
$querylistingw=mysqli_fetch_array($rsw);
echo stripslashes($querylistingw['description']); 

 //imap_qprint
 ?>