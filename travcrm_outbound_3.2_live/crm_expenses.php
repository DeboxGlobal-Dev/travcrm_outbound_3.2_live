 <?php



 $wheresearch=''; 



$limit=clean($_GET['records']); 







if($_REQUEST['spendingType']!=''){



$wheresearch.=' and spendingType='.$_REQUEST['spendingType'].' ';



}











if($_REQUEST['venderId']!=''){



$wheresearch.=' and venderId='.$_REQUEST['venderId'].' ';



}







if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){



$wheresearch.=' and invoiceDate between  "'.date('Y-m-d',strtotime($_REQUEST['fromDate'])).'" and  "'.date('Y-m-d',strtotime($_REQUEST['toDate'])).'" ';



} else {



$wheresearch.=' and invoiceDate between  "'.date('Y-m').'-01'.'" and  "'.date('Y-m-t').'" ';



}







if($_REQUEST['did']!=''){



$sql_del="delete from expensesMaster  where id='".$_REQUEST['did']."'"; 



mysqli_query($sql_del) or die(mysqli_error(db()));



}



?>



<style>



.mailsectionheader{ margin-top: 55px;/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#e5e5e5+0,d2d2d2+100 */



background: #e5e5e5; /* Old browsers */



background: -moz-linear-gradient(top, #e5e5e5 0%, #d2d2d2 100%); /* FF3.6-15 */



background: -webkit-linear-gradient(top, #e5e5e5 0%,#d2d2d2 100%); /* Chrome10-25,Safari5.1-6 */



background: linear-gradient(to bottom, #e5e5e5 0%,#d2d2d2 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */



filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e5e5', endColorstr='#d2d2d2',GradientType=0 ); /* IE6-9 */ border-bottom:1px #b2b2b2 solid;}



.mailsectionheader .heading{font-size:16px; font-weight:500; padding:13px 20px;   position:relative;}



.mailsectionheader .mailarea{width:501px; overflow:hidden;}



.mailsectionheader .mailarearight {



    overflow: hidden;



    border-left: 1px solid #ffffff;



    height: 45px;



}







.writeclass {



	font-size: 16px;



	width: 18px;



	text-align:center;



	position: absolute;



	right: 10px;



	padding: 10px;



	color: #333333;



	border: 1px solid #9b9b9d;



	/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f2f2f4+0,d6d6d6+100 */



background: #f2f2f4; /* Old browsers */



	background: -moz-linear-gradient(top, #f2f2f4 0%, #d6d6d6 100%); /* FF3.6-15 */



	background: -webkit-linear-gradient(top, #f2f2f4 0%,#d6d6d6 100%); /* Chrome10-25,Safari5.1-6 */



	background: linear-gradient(to bottom, #f2f2f4 0%,#d6d6d6 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */



filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f2f2f4', endColorstr='#d6d6d6',GradientType=0 ); /* IE6-9 */



	top: 7px;



	padding: 7px;



	border-radius: 4px;



	cursor: pointer;



	height: 34px;



}



.mailandinboxbox{width:260px; overflow:auto; height:100%; overflow:hidden;}



.inboxlist{background-color:#eceff4; border-right:#d8d8d8 solid 1px; height:100%; width:100%; float:left;}



.inboxlist .topmailname{padding:15px; color:#63666b; font-size:30px; text-align:center; color:#CC0000; font-weight:500;}



.inboxlist .topmailname .textbox{font-size:12px; margin-top:5px; color:#333333;text-transform: uppercase;}



.inboxlist .topmailname img{width:40px;}



.inboxlist .topmailname .profileimgbox{overflow:hidden; height:40px; width:40px;    border-radius: 40px;}



.inboxlist .listanch {



    margin-top: 0px;



    background-color: #d2e8f3;



    padding: 4px;



    border-top: 1px #3f8c8c47 solid;



    border-bottom: 1px #3f8c8c47 solid;



}



.inboxlist .listanch .pr{padding:10px 0px; font-size:13px; text-align:center; color:#CC0000; font-weight:500;}



.inboxlist .listanch .tx{  font-size:11px; text-align:center; color:#333333;}







.inboxlist .listanch a { }



.inboxlist .listanch .newmailcome {  position: absolute;



    padding: 4px 8px;



    color: #333333;



    right: 9px;



    top: 11px;}



.inboxlist .listanch .selected .newmailcome {



    position: absolute;



    padding: 4px 8px;



    color: #333333;



    right: 9px;



    top: 11px;



    background-color: #3f7baf;



    color: #fff;



    border-radius: 4px;



    border-bottom: 1px solid #ffffff8c;



}







.inboxlist .listanch a:hover{background-color:#d7e4ef;}



.inboxlist .listanch a:hover{background-color:#d7e4ef;}







.inboxlist .listanch .selected{/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#73b7e6+0,458bd1+100 */



background: #73b7e6; /* Old browsers */



background: -moz-linear-gradient(top, #73b7e6 0%, #458bd1 100%); /* FF3.6-15 */



background: -webkit-linear-gradient(top, #73b7e6 0%,#458bd1 100%); /* Chrome10-25,Safari5.1-6 */



background: linear-gradient(to bottom, #73b7e6 0%,#458bd1 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */



filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#73b7e6', endColorstr='#458bd1',GradientType=0 ); /* IE6-9 */ color:#fff !important; border-top:1px solid #789fc8; border-bottom:1px solid #4072a5;}







.mailandinboxbox #shortmail{width:260px; float:left; overflow:auto; max-height:650px;}



.mailandinboxbox #shortmail .list{border-bottom: #d8d8d8 solid 1px; padding:15px; overflow:hidden; position:relative; cursor:pointer;}



.mailandinboxbox #shortmail .list:hover{background-color:#E1F9FF;}



.mailandinboxbox #shortmail .active{background-color:#E1F9FF;}







.mailandinboxbox #shortmail .list .dateright {



    color: #478fd7;



    position: absolute;



    right: 9px;



    top: 11px;



    font-size: 11px;



    font-weight: 500;



    background-color: #fff;



    padding: 3px 4px;



}



.mailandinboxbox #shortmail .list .heading{ font-weight:500; color:#444446; font-size:13px; margin-bottom:5px;}



.mailandinboxbox #shortmail .list .shorttext{color:#666666; font-size:13px;}



.mailandinboxbox #shortmail .new{background-color:#f2f2f4;}







.mailandinboxbox #shortmail .new .dateright {



    color: #478fd7;



    position: absolute;



    right: 9px;



    top: 11px;



    font-size: 11px;



    font-weight: 500;



    background-color: #2fc069;



    padding: 3px 4px;



    color: #fff;



    border-radius: 3px;



}







#readmailbox{padding:15px; overflow:hidden;  }



.readmailboxtop{border-bottom: #d8d8d8 solid 1px; padding: 13px; overflow:hidden; position:relative;}



.maileruser {



    color: #6666668f;



    background-color: #cccccc61;



    padding: 10px;



    font-size: 22px;



    width: 20px;



    border-radius: 60px;



    height: 20px; margin-right:10px;



}







.mailusername{font-size:13px; font-weight:500; margin-bottom:4px;color:#444446; margin-top:4px; }



.mailuseremail{color:#666666; font-size:12px;}



.readmailboxtop .rightdate {



    position: absolute;



    right: 15px;



    top: 27px;



    color: #999999;



    font-size: 11px;



    font-weight: 500;



}



#readmailbox .subjectdiv{margin-bottom:20px; font-size:24px; color:#444446;}



#readmailbox .bodydiv {



    font-family: 13px;



    color: #2c2c2c;



    font-size: 13px;



    line-height: 20px;



}











.mailarearight .heading {



    font-size: 16px;



    font-weight: 500;



    padding: 13px 20px;



    border-right: 1px #a7a5a8 solid;



    position: relative;



}



.filterouter{padding:15px; padding-top:0px;}



.he {



    font-size: 12px;



    font-weight: 500;



    padding:10px 15px;



    border-bottom: 1px #cccccc61 solid;



    background-color: #c0c0c036;



} 



.filterouter .fbox{padding-top:15px;}



.filterouter .fbox .textfi{padding:5px; width:100%; box-sizing:border-box; border:1px #CCCCCC solid; outline:0px;}



.rightboxdd{padding:10px;}



</style>



<body style="height:90% !important;">



<div class="mailsectionheader">



<table width="100%" border="0" cellpadding="0" cellspacing="0">



  <tr>



    <td colspan="2" align="left" valign="top"><div class="mailarea">



<div class="heading"><i class="fa fa-book"></i> Expenses     



   



	</div>



	</div></td>



    <td width="75%" align="right" valign="top"><input name="addnewuserbtn" type="button" class="bluembutton2" id="bluembutton" value="+ Add Expenses" style="width: 200px; margin: 5px;background-color: #19924a; border: 1px #19924a solid;"  onClick="alertspopupopen('action=addexpenses','600px','auto');"></td>



  </tr>



</table>







</div>



<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">



  <tr>



    <td colspan="2" align="left" valign="top" style="border-right:#d8d8d8 solid 1px;">



	<div class="mailandinboxbox">



	<div class="inboxlist">



	<div class="topmailname">



	<?php 



$totalamount=0;



$totalgst=0;



$totalcgst=0;



$totalsgst=0;



$totaligst=0;



$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' 1 '.$wheresearch.' '; 



$rs=GetPageRecord($select,'expensesMaster',$where);  



while($coutlisting=mysqli_fetch_array($rs)){   



$totalamount=$coutlisting['totalAmount']+$totalamount; 



$totalgst=$coutlisting['gst']+$totalgst; 



$totalcgst=$coutlisting['cgst']+$totalcgst; 



$totalsgst=$coutlisting['sgst']+$totalsgst; 



$totaligst=$coutlisting['igst']+$totaligst; 



}



?>



	



	



	 <?php echo $totalamount; ?>	<div class="textbox">Total Spending</div></div>



	



	<div class="listanch"> 



	



	 <table width="100%" border="0" cellpadding="0" cellspacing="0">



  <tr>



    <td width="25%" align="center" class="pr"><?php echo $totalcgst; ?><div class="tx">CGST</div></td>



    <td width="25%" align="center" class="pr"><?php echo $totalsgst; ?>



      <div class="tx">SGST</div></td>



    <td width="25%" align="center" class="pr"><?php echo $totaligst; ?>



      <div class="tx">IGST</div></td>

  </tr>

</table>







	</div>



	<div class="he">FILTER</div> 



	



	<form  method="get" action="" enctype="multipart/form-data"  >



	<div class="filterouter">



	<div class="fbox">



	<?php



	if($_REQUEST['fromDate']!='' && $_REQUEST['toDate']!=''){



	$fromdate=$_REQUEST['fromDate'];



	$todate= $_REQUEST['toDate'];



	} else { 



	$fromdate='1-'.date('m-Y');



	$todate= date("t-m-Y", strtotime(date('Y-m-d')));



	}



	 ?>



	<table width="100%" border="0" cellpadding="5" cellspacing="0">



  <tr>



    <td colspan="2" style="padding:0px;"><input name="fromDate" type="text" class="textfi" id="fromDate" placeholder="From Date" value="<?php echo $fromdate; ?>"></td>



    <td width="53%" style="padding:0px; padding-left:10px;"><input name="toDate" type="text" class="textfi" id="toDate" placeholder="To Date" value="<?php echo $todate; ?>"></td>



  </tr>



</table>







	</div>



	



	<div class="fbox">



	<table width="100%" border="0" cellpadding="5" cellspacing="0">



  <tr>



    <td colspan="2" style="padding:0px;"><select name="venderId"  class="textfi"  id="venderId"   autocomplete="off"  >







	 <option value="">Select All</option>







 <?php 







$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' name!="" and deletestatus=0 and otherType=13 order by name asc';  



$rs=GetPageRecord($select,_SUPPLIERS_MASTER_,$where); 



$newdata = explode(',', $destinationId); 



while($resListing=mysqli_fetch_array($rs)){   







?>







<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['venderId']){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>







<?php } ?>







</select></td>



   </tr>



</table>







	</div>



	



	<div class="fbox">



	<table width="100%" border="0" cellpadding="5" cellspacing="0">



  <tr>



    <td colspan="2" style="padding:0px;"><select name="spendingType" size="1" class="textfi"  id="spendingType"   autocomplete="off"  >







	 <option value="">Select All</option>







 <?php 







$select=''; 



$where=''; 



$rs='';  



$select='*';    



$where=' 1 order by name asc';  



$rs=GetPageRecord($select,'expensesType',$where); 



$newdata = explode(',', $destinationId); 



while($resListing=mysqli_fetch_array($rs)){   







?>







<option value="<?php echo strip($resListing['id']); ?>" <?php if($resListing['id']==$_REQUEST['spendingType']){ ?>selected="selected"<?php } ?> ><?php echo strip($resListing['name']); ?></option>







<?php } ?>







</select></td>



   </tr>



</table>







	<input name="module" type="hidden" id="module" value="<?php echo $_REQUEST['module'];?>">



	</div>



	



	<div class="fbox">



	<input name="addnewuserbtn" type="submit" class="bluembutton2" id="bluembutton2" value="Search" >



	</div>



	



	</div>



	



	</form>



	</div>



	 



	 



	</div>



	</td>



    <td width="86%" align="left" valign="top">



	<div class="rightboxdd">



	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">







   <thead>







   <tr>



      <th align="left" class="header" >Vender</th>



      <th align="left" class="header" >Type</th>







      <th align="left" class="header">Invoice&nbsp;No.</th>
      <th align="left" class="header">Invoice&nbsp;Date</th>



      <th align="left" class="header">Due&nbsp;Date</th>



      <th align="left" class="header">Amount </th>



      <th align="left" class="header">GST</th>







     <th align="left" class="header">CGST</th>



     <th align="left" class="header">SGST</th>



     <th align="left" class="header">IGST</th>



     <th align="left" class="header">Note</th>



     <th align="center" class="header">&nbsp;</th>
     <th align="center" class="header">&nbsp;</th>
   </tr>
   </thead>







 











 







  <tbody>



  <?php







$no=1; 



$select='*'; 



$where=''; 



$rs='';  



















$where='where 1 '.$wheresearch.' order by addDate desc'; 



$page=$_GET['page'];



 



$targetpage=$fullurl.'showpage.crm?module=expenses&records='.$limit.'&searchField='.$searchField.'&assignto='.$_GET['assignto'].'&suppliertype='.$_GET['suppliertype'].'&';



$rs=GetRecordList($select,'expensesMaster',$where,$limit,$page,$targetpage); 



$totalentry=$rs[1]; 



$paging=$rs[2]; 



while($resultlists=mysqli_fetch_array($rs[0])){  







 



?>



  <tr>



				<td align="left"><?php 



					$select1='*';    



					$where1=' id="'.$resultlists['venderId'].'"';  



					$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 



					$data=mysqli_fetch_array($rs1);



					echo $data['name'];



				?></td>



    <td align="left"><?php  

					$select1='*';     

					$where1=' id in (select expensesType from '._SUPPLIERS_MASTER_.' where id='.$resultlists['venderId'].')';  

					$rs1=GetPageRecord($select1,'expensesType',$where1);  

					$data=mysqli_fetch_array($rs1); 

					echo $data['name'];



				?></td>







    <td align="left"><?php echo $resultlists['invoiceNumber']; ?></td>
    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['invoiceDate'])); ?></td>



    <td align="left"><?php echo date('d-m-Y',strtotime($resultlists['dueDate'])); ?></td>



    <td align="left"><?php echo $resultlists['totalAmount']; ?></td>



    



    <td align="left"><?php echo $resultlists['gst']; ?>%</td>







    <td align="left"><?php echo $resultlists['cgst']; ?></td>



    <td align="left"><?php echo $resultlists['sgst']; ?></td>



    <td align="left"  ><?php echo $resultlists['igst']; ?></td>



    <td align="left" ><?php echo stripslashes($resultlists['remark']); ?> <?php if($resultlists['attachment']!=''){ ?><br><a href="<?php echo $fullurl.'upload/'.$resultlists['attachment']; ?>" target="_blank"><strong>Download</strong></a><?php } ?></td>



    <td align="center" ><input name="addnewuserbtn" type="button" class="bluembutton2" id="bluembutton" value="Pay" style="width: 50px; margin: 5px;background-color: #19924a; border: 1px #19924a solid; padding:5px 0px !important; text-align:center;" onclick="alertspopupopen('action=expensespayment&id=<?php echo $resultlists['venderId']; ?>&venderId=<?php echo $resultlists['venderId']; ?>','900px','auto');"></td>
    <td align="center" ><a href="showpage.crm?module=expenses&did=<?php echo $resultlists['id']; ?>" style="color:#CC0000 !important;" onClick="return confirm('Are you sure you want delte this entry?');">Delete</a></td>
  </tr> 



	



	<?php $no++; } ?>
</tbody></table>







<div class="pagingdiv">







		







		<table width="100%" border="0" cellpadding="0" cellspacing="0">







  <tbody><tr>







    <td><table border="0" cellpadding="0" cellspacing="0">



  <tr>



    <td style="padding-right:20px;"><?php echo $totalentry; ?> entries</td>



    <td> </td>



  </tr>



  



</table></td>







    <td align="right"><div class="pagingnumbers"><?php echo $paging; ?></div></td>







  </tr>



</tbody></table>



	</div>



	</div>



 



	



	</td>



  </tr>



</table>







</body>



 







<style>



body{height:80% !Important; }



.fa-mail-forward:before, .fa-share:before { display:none;



    content: "\f064";



}







.bluembutton2 {



    background-color: #ffc115;



    padding: 8px 15px !important;



    margin-left: 10px;



    outline: 0px;



    color: #FFFFFF;



    font-size: 14px;



    border: 1px #ffc115 solid;



    border-radius: 27px;



    cursor: pointer;



    width: 100%;



    box-sizing: border-box;



    margin-left: 0px;



    border-radius: 3px;



}



 



.addeditpagebox .griddiv .Zebra_DatePicker_Icon_Wrapper{width:100% !important;}



</style>











