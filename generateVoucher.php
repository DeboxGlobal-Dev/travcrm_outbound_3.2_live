<?php 

$sd=GetPageRecord('*','finalquotationItinerary',' quotationId="'.$_REQUEST['qid'].'" and queryId="'.$_REQUEST['queryId'].'"  order by id asc'); 



  while($servicewisedata=mysqli_fetch_array($sd)){

        if($servicewisedata['serviceType']=='hotel'){



          $cv=GetPageRecord('*','finalQuote',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!="" group by  hotelId order by fromDate asc');  

          $finalQuoteDatav=mysqli_fetch_array($cv);

         

          $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$finalQuoteDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$finalQuoteDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$finalQuoteDatav['id'].'",quotationId="'.$finalQuoteDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

        }

        if($servicewisedata['serviceType']=='transfer'){



          $tv=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

          $transferQuotDatav=mysqli_fetch_array($tv);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$transferQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$transferQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$transferQuotDatav['id'].'",quotationId="'.$transferQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

        }

        if($servicewisedata['serviceType']=='transportation'){



          $tvp=GetPageRecord('*','finalQuotetransfer',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

          $transferQuotDatavp=mysqli_fetch_array($tvp);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$transferQuotDatavp['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$transferQuotDatavp['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$transferQuotDatavp['id'].'",quotationId="'.$transferQuotDatavp['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

        }  



      if($servicewisedata['serviceType']=='guide'){

           $gv=GetPageRecord('*','finalQuoteGuides',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

           $guideQuotDatav=mysqli_fetch_array($gv);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$guideQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$guideQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$guideQuotDatav['id'].'",quotationId="'.$guideQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }



      if($servicewisedata['serviceType']=='activity'){

          $gav=GetPageRecord('*','finalQuoteActivity','quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

          $ActivityQuotDatav=mysqli_fetch_array($gav);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$ActivityQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$ActivityQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$ActivityQuotDatav['id'].'",quotationId="'.$ActivityQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

      if($servicewisedata['serviceType']=='flight'){



          $afi=GetPageRecord('*','finalQuoteFlights',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

          $flightQuotDatav=mysqli_fetch_array($afi);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$flightQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$flightQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$flightQuotDatav['id'].'",quotationId="'.$flightQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

      if($servicewisedata['serviceType']=='train'){



           $trainv=GetPageRecord('*','finalQuoteTrains',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

           $trainQuotDatav=mysqli_fetch_array($trainv);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$trainQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$trainQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$trainQuotDatav['id'].'",quotationId="'.$trainQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

      if($servicewisedata['serviceType']=='additional'){



           $aa=GetPageRecord('*','finalQuoteExtra',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

           $additionalQuotDatav=mysqli_fetch_array($aa);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$additionalQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$additionalQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);

          $namevalue ='serviceId="'.$additionalQuotDatav['id'].'",quotationId="'.$additionalQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

      if($servicewisedata['serviceType']=='mealplan'){



           $rm=GetPageRecord('*','finalQuoteMealPlan',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

           $restaurantQuotDatav=mysqli_fetch_array($rm);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$restaurantQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$restaurantQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$restaurantQuotDatav['id'].'",quotationId="'.$restaurantQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

       if($servicewisedata['serviceType']=='entrance'){



           $entrav=GetPageRecord('*','finalQuoteEntrance',' quotationId="'.$servicewisedata['quotationId'].'" and id="'.$servicewisedata['serviceId'].'" and supplierId!=""');  

           $entranceQuotDatav=mysqli_fetch_array($entrav);



           $vsno=GetPageRecord('*','voucherNumberMaster',' quotationId="'.$entranceQuotDatav['quotationId'].'" and itineraryId="'.$servicewisedata['id'].'" and serviceId="'.$entranceQuotDatav['id'].'"'); 

          $counthvn = mysqli_num_rows($vsno); 

          $vaoucherResult=mysqli_fetch_array($vsno);



          $namevalue ='serviceId="'.$entranceQuotDatav['id'].'",quotationId="'.$entranceQuotDatav['quotationId'].'",queryId="'.$_REQUEST['queryId'].'",itineraryId="'.$servicewisedata['id'].'"';

          if($counthvn > 0 ){

            $where='id="'.$vaoucherResult['id'].'"';

            $update = updatelisting('voucherNumberMaster',$namevalue,$where);

          }else{

            $add = addlisting('voucherNumberMaster',$namevalue);

          }

      }

      

  }


 ?>