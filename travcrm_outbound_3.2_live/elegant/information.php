 <?php 
$page='information';
include "header.php"; 
?>
<style>
    .info-back-des{
        background: white;
    }

</style>



<div class="page-content info">
    <div class="accordion info-back-des" id="travel-info-accordion">
        <div class="content-block custom_border_colour primary">
            <!-- <div class="accordion-toggle custom_title-bar custom_border_colour primary">
                <h2>Information</h2>
                <div class="collapser open">
                    <span></span>
                </div>
            </div> -->
            <div class="accordion-content default">
                <div class="block-container one-column-layout">
                    <div class="body paragraphs">
                        <?php 

                    $day=1;
                    $QueryDaysQuery=GetPageRecord('*','newQuotationDays',' quotationId="'.$quotationId.'" order by srdate asc'); 
                    while($QueryDaysData=mysqli_fetch_array($QueryDaysQuery)){  
                                    
                        $dayDate = date('Y-m-d', strtotime($QueryDaysData['srdate']));
                        $QueryDaysData['title'];
                        $QueryDaysData['description'];
                 echo '<tr class="heading"><th colspan="9"><div class="custom_title-bar custom_border_colour primary full" style="margin-bottom: 20px !important;"><h2>Day&nbsp;&nbsp; '.$day.'</h2></div></th></tr>';
                    
                        
                    if(strlen($QueryDaysData['title'])>1) {
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;<strong>".trim(urldecode(strip($QueryDaysData['title'])))." - </strong>";
                        echo "<br />";
                        echo "<br />";
                    }
                    ?>
                    <table>
                        <tr>
                            <td style="padding-left: 30px;">
                            <?php
                            $html = trim(urldecode(strip($QueryDaysData['description'])));
                            if($html!=''){
                                // $html = str_replace('<p>&nbsp;</p>', '', $html);
                                $html = str_replace('<p>', '<li>', $html);
                                echo $html = str_replace('</p>', '</li>', $html);
                                echo "<br />";
                            }
                            ?>
                            </td>
                        </tr>
                    
                    </table>
                 <?php
                    $day++;  
                }


                
        $rsp=GetPageRecord('*',_QUOTATION_MASTER_,' id="'.$quotationId.'"');  
        $resultpageQuotation=mysqli_fetch_array($rsp);  

        $select='*';  
        $where='id="'.$resultpageQuotation['queryId'].'"';  
        $rs=GetPageRecord($select,_QUERY_MASTER_,$where);  
        $resultpage=mysqli_fetch_array($rs); 


        $totalPax = $resultpageQuotation['adult']+$resultpageQuotation['child'];
            $quotationId = $resultpageQuotation['id'];  
        $queryId = $resultpage['id']; 	

        $overviewText=$highlightsText=$inclusion=$exclusion=$tncText=$specialText='';
        if($resultpageQuotation['overviewText']!='' || $resultpageQuotation['overviewText']!='undefined'){
            $overviewText=preg_replace('/\\\\/', '',clean($resultpageQuotation['overviewText'])); 
        }
        if($resultpageQuotation['highlightsText']!='' || $resultpageQuotation['highlightsText']!='undefined'){
            $highlightsText=preg_replace('/\\\\/', '',clean($resultpageQuotation['highlightsText']));
        }
        if($resultpageQuotation['inclusion']!='' || $resultpageQuotation['inclusion']!='undefined'){
            $inclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['inclusion']));
        }
        if($resultpageQuotation['exclusion']!='' || $resultpageQuotation['exclusion']!='undefined'){
            $exclusion=preg_replace('/\\\\/', '',clean($resultpageQuotation['exclusion']));  
        }
        if($resultpageQuotation['tncText']!='' || $resultpageQuotation['tncText']!='undefined'){
            $tncText=preg_replace('/\\\\/', '',clean($resultpageQuotation['tncText']));  
        }
        if($resultpageQuotation['specialText']!='' || $resultpageQuotation['specialText']!='undefined'){
            $specialText=preg_replace('/\\\\/', '',clean($resultpageQuotation['specialText']));
        }
            
        ?>

<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		<tr>
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-after: never;font-size: 12px; padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Overview</div><?php echo strip($overviewText); ?></div>
			</td>
		</tr>
	</table>

	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		<tr>
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-inside: auto;font-size: 12px; padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Tour Highlights</div><?php echo strip($highlightsText); ?></div>
			</td>
		</tr>
	</table>
	
	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		
		<tr>
			
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-after: never;font-size: 12px;padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Inclusions</div><?php echo strip($inclusion);  ?></div>
			</td>
		</tr>
	</table>
	
	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px;">
		<tr>
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-after: never;font-size: 12px; padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Exclusions</div><?php echo strip($exclusion); ?></div>
			</td>
		</tr>
	</table>

	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		<tr>
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-after: never;font-size: 12px; padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Terms & Conditions</div><?php echo strip($tncText); ?></div>
			</td>
		</tr>
	</table>

	<table border="0" cellpadding="20" cellspacing="0"  width="100%" style="font-size:12px">
		<tr>
			<td>
			
			<div class="serviceDesc  incl" style="text-align: justify;page-break-after: never;font-size: 12px; padding-bottom: 5px;"><div class="dayTitle" style="line-height: 28px;font-size: 18px;color: white;text-align: left;background-color: #133f6d; padding: 10px;">&nbsp;&nbsp;&nbsp;&nbsp;Cancellation Policies</div><?php echo strip($specialText); ?></div>
			</td>
		</tr>
	</table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
include "footer.php"; 
?>
