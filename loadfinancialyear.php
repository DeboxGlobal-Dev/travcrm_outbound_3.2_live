            
            <?php 
            include "inc.php"; 
            include "config/logincheck.php";  

            if($_REQUEST['action']=='AddFinanceYear'){

                $financeY = $_REQUEST['financialyear'];
                $daterange = $_REQUEST['daterange'];
            
                $namevalue = 'financeYear="'.$financeY.'", daterange="'.$daterange.'", status=1, deletestatus=0';
                addlisting('financeYearMaster',$namevalue);
            
            }
            
            if($_REQUEST['action']=='loadfinanceyear'){
            $output='';
            $result = GetPageRecord('*','financeYearMaster','status=1 and deletestatus=0 order by id desc');
            if(mysqli_num_rows($result)>0){
                while($financeresult = mysqli_fetch_assoc($result)){
                  $output .= "<tr>
					<th width='10%' align='left'>Financial Year</th>
					<td align='center'> {$financeresult["financeYear"]} </td>
					<td >{$financeresult["daterange"]}</td></tr>";
                }
                echo $output;
            }else{
                echo "No Record Found";
            }
          
        }

      

?>
<!-- Load financial years -->