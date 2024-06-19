<?php
include "inc.php"; 


if($_REQUEST['action']=='micemainhall' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){

$Length = $_REQUEST['Length'];
$Breadth = $_REQUEST['Breadth'];
$Height = $_REQUEST['Height'];
$Area = $_REQUEST['Area'];
$Quantity = $_REQUEST['Quantity'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceMainHall',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
addlisting('miceMainHall',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceMainHall',$namevalue,$where);
}


}


if($_REQUEST['action']=='Dining' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){

$Length = $_REQUEST['Length'];
$Breadth = $_REQUEST['Breadth'];
$Height = $_REQUEST['Height'];
$Area = $_REQUEST['Area'];
$Quantity = $_REQUEST['Quantity'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceDiningArea',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
addlisting('miceDiningArea',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceDiningArea',$namevalue,$where);
}


}




if($_REQUEST['action']=='AV' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceaudioVisual',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
addlisting('miceaudioVisual',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceaudioVisual',$namevalue,$where);
}


}







if($_REQUEST['action']=='Photo' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'micePhotography',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
addlisting('micePhotography',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('micePhotography',$namevalue,$where);
}


}







if($_REQUEST['action']=='sign' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceSignage',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",Quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
addlisting('miceSignage',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",Quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceSignage',$namevalue,$where);
}


}



if($_REQUEST['action']=='licence' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
  
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceLicences',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
addlisting('miceLicences',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceLicences',$namevalue,$where);
}


}









if($_REQUEST['action']=='Power' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity'];
$Unit = $_REQUEST['Unit'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'micePowerSupply',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'",unit="'.$Unit.'"'; 
addlisting('micePowerSupply',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'",unit="'.$Unit.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('micePowerSupply',$namevalue,$where);
}


}







if($_REQUEST['action']=='VVIP' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){

$Length = $_REQUEST['Length'];
$Breadth = $_REQUEST['Breadth'];
$Height = $_REQUEST['Height'];
$Area = $_REQUEST['Area'];
$Quantity = $_REQUEST['Quantity'];
$Days = $_REQUEST['Days']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceVvipLounge',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
addlisting('miceVvipLounge',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",Length="'.$Length.'",Breadth="'.$Breadth.'",Height="'.$Height.'",Area="'.$Area.'",Quantity="'.$Quantity.'",Days="'.$Days.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceVvipLounge',$namevalue,$where);
}


}









if($_REQUEST['action']=='HouseKeeping' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 
$Days = $_REQUEST['Days']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceHouseKeeping',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",Quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
addlisting('miceHouseKeeping',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",Quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceHouseKeeping',$namevalue,$where);
}


}







if($_REQUEST['action']=='security' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 
$Days = $_REQUEST['Days']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceSecurity',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
addlisting('miceSecurity',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceSecurity',$namevalue,$where);
}


}









if($_REQUEST['action']=='decor' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
  
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'micedecor',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
addlisting('micedecor',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('micedecor',$namevalue,$where);
}


}



if($_REQUEST['action']=='emergency' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
  
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceEmergencyServices',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
addlisting('miceEmergencyServices',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",dayId="'.$dayid.'",cost="'.$Cost.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceEmergencyServices',$namevalue,$where);
}


}




if($_REQUEST['action']=='utilities' && $_REQUEST['parentId']!='' && $_REQUEST['dayid']!=''){
 
 
$Quantity = $_REQUEST['Quantity']; 
$parentId = $_REQUEST['parentId']; 
$dayid = $_REQUEST['dayid']; 
$Cost = $_REQUEST['Cost']; 
$Days = $_REQUEST['Days']; 

$select1='*';    
$where1='parentId='.$parentId.' and dayId='.$dayid.'';   
$rs1=GetPageRecord($select1,'miceUtilities',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='parentId="'.$parentId.'",quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
addlisting('miceUtilities',$namevalue); 
} else { 
$namevalue ='parentId="'.$parentId.'",quantity="'.$Quantity.'",dayId="'.$dayid.'",cost="'.$Cost.'",days="'.$Days.'"'; 
$where='parentId='.$parentId.' and dayId='.$dayid.'';
updatelisting('miceUtilities',$namevalue,$where);
}


}





  



if($_REQUEST['action']=='addconference' && $_REQUEST['parentId']!='' && $_REQUEST['dayId']!=''){
 
 $queryId = $_REQUEST['queryId']; 
$supplierId = $_REQUEST['supplierId']; 
$dayId = $_REQUEST['dayId']; 
$parentId = $_REQUEST['parentId']; 
$sectionType = $_REQUEST['sectionType']; 
$totalCost = $_REQUEST['totalCost']; 
$addDate = time();;


$select1='*';    
$where1='queryId='.$queryId.' and supplierId='.$supplierId.' and dayId='.$dayId.' and parentId='.$parentId.' and sectionType='.$sectionType.' ';   
$rs1=GetPageRecord($select1,'miceConferenceSupplierQuotation',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='queryId="'.$queryId.'",supplierId="'.$supplierId.'",dayId="'.$dayId.'",parentId="'.$parentId.'",sectionType="'.$sectionType.'",totalCost="'.$totalCost.'",addDate="'.$addDate.'"'; 
addlisting('miceConferenceSupplierQuotation',$namevalue); 
} else { 
$namevalue ='queryId="'.$queryId.'",supplierId="'.$supplierId.'",dayId="'.$dayId.'",parentId="'.$parentId.'",sectionType="'.$sectionType.'",totalCost="'.$totalCost.'",addDate="'.$addDate.'"'; 
$where='queryId='.$queryId.' and supplierId='.$supplierId.' and dayId='.$dayId.' and parentId='.$parentId.' and sectionType='.$sectionType.'';   
updatelisting('miceConferenceSupplierQuotation',$namevalue,$where);
}


}
 
 
if($_REQUEST['action']=='addclientcost' && $_REQUEST['parentId']!='' && $_REQUEST['parentType']!='' && $_REQUEST['queryId']!='' && $_REQUEST['totalCost']!='' && $_REQUEST['parentId']!='undefined'){
 
 $queryId = $_REQUEST['queryId']; 
$parentType = $_REQUEST['parentType'];  
$parentId = $_REQUEST['parentId']; 
$hotelType = $_REQUEST['hotelType']; 
$cost = $_REQUEST['cost']; 
$marginType = $_REQUEST['marginType']; 
$marginValue = $_REQUEST['marginValue']; 
$totalCost = $_REQUEST['totalCost']; 
$addDate = time();;


$select1='*';    
 $where1='queryId='.$queryId.' and parentType="'.$parentType.'" and parentId='.$parentId.'  and hotelType='.$hotelType.' ';   
$rs1=GetPageRecord($select1,'clientMiceQuotation',$where1); 
$data=mysqli_fetch_array($rs1); 

if($data['id']==''){
$namevalue ='queryId="'.$queryId.'",parentType="'.$parentType.'",hotelType="'.$hotelType.'",parentId="'.$parentId.'",cost="'.$cost.'",marginType="'.$marginType.'",marginValue="'.$marginValue.'",totalCost="'.$totalCost.'",addDate="'.$addDate.'"'; 
addlisting('clientMiceQuotation',$namevalue); 
} else { 
$namevalue ='queryId="'.$queryId.'",parentType="'.$parentType.'",hotelType="'.$hotelType.'",parentId="'.$parentId.'",cost="'.$cost.'",marginType="'.$marginType.'",marginValue="'.$marginValue.'",totalCost="'.$totalCost.'",addDate="'.$addDate.'"'; 
$where='queryId='.$queryId.' and parentType="'.$parentType.'" and parentId='.$parentId.'  and hotelType='.$hotelType.'';   
updatelisting('clientMiceQuotation',$namevalue,$where);
}


}







?>


