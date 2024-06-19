if (isset($_FILES['importfield']['name']) && trim($_POST['importpackagehotel']) == 'Y') {
    date_default_timezone_set('Asia/Kolkata');
    $importpackagesightseeingModule = $_REQUEST['importpackagehotelModule'];
    if (!empty($_FILES['importfield']['name'])) {
        $file_name = $_FILES['importfield']['name'];
        $newfilez = formatUrl($file_name);
        $file_name = trim($newfilez) . '.csv'; // Change file extension to CSV
        $msg = '';
        $msg = $newfilez;
        errorlog($msg, $newfilez);
        $msg = '';
        $msg = $fullurl . "importfile/" . $file_name . " Copy this link to download file ";
        errorlog($msg, $newfilez);

        copy($_FILES['importfield']['tmp_name'], "importfile/" . $file_name);

        // Parse CSV file
        $csvFile = fopen("importfile/" . $file_name, "r");
        $line = 0;

        // Check if CSV file was opened successfully
        if ($csvFile !== false) {
            while (($data = fgetcsv($csvFile, 1000, ",")) !== false) {
                ++$line; // Increment line number
  
				$showErrorName = '';
	            $showErrorType = '';
	            $hotelName = cleanNonAsciiCharactersInString($data[1]);
	            $hotelDestination = cleanNonAsciiCharactersInString($data[2]);
	            $SelfSupplier = cleanNonAsciiCharactersInString($data[3]);
	            $supplierName = cleanNonAsciiCharactersInString($data[4]);
	            $paymentTerm = cleanNonAsciiCharactersInString($data[5]);
	            $hotelCountry = cleanNonAsciiCharactersInString($data[6]);
	            $hotelState = cleanNonAsciiCharactersInString($data[7]);
	            $hotelCity = cleanNonAsciiCharactersInString($data[8]);
	            $hotelAddress = cleanNonAsciiCharactersInString($data[9]);
	            $pinCode = cleanNonAsciiCharactersInString($data[10]);
	            $gstn = cleanNonAsciiCharactersInString($data[11]);
	            $divisionName = cleanNonAsciiCharactersInString($data[12]);
	            $contactPerson = cleanNonAsciiCharactersInString($data[13]);
	            $designation = cleanNonAsciiCharactersInString($data[14]);
	            $supplierPhone = cleanNonAsciiCharactersInString($data[15]);
				$supplierEmail = explode(',',cleanNonAsciiCharactersInString($data[16]))[0];
	            $marketTypename = cleanNonAsciiCharactersInString($data[17]);
	            $paxTypeN = cleanNonAsciiCharactersInString($data[18]);
	            $tarifTypeN = cleanNonAsciiCharactersInString($data[19]);
	            $seasonTypeN = cleanNonAsciiCharactersInString($data[20]);
	            $roomType = cleanNonAsciiCharactersInString($data[21]);
	            $mealPlan = cleanNonAsciiCharactersInString($data[22]);
	 			$fromDates = cleanNonAsciiCharactersInString($data[23]);
	            $toDates = cleanNonAsciiCharactersInString($data[24]);
	           	$fromDates = date("Y-m-d", strtotime($fromDates));
	            $toDates = date("Y-m-d", strtotime($toDates));
	            $currency = cleanNonAsciiCharactersInString($data[25]);
	            $single = cleanNonAsciiCharactersInString($data[26]);
	            $double = cleanNonAsciiCharactersInString($data[27]);
	            $extraBedA = cleanNonAsciiCharactersInString($data[28]);
	            $childwithbed = cleanNonAsciiCharactersInString($data[29]);
	            $childwithoutbed = cleanNonAsciiCharactersInString($data[30]);
	            $breakfastA = cleanNonAsciiCharactersInString($data[31]);
	            $lunchA = cleanNonAsciiCharactersInString($data[32]);
	            $dinnerA = cleanNonAsciiCharactersInString($data[33]);
	            $breakfastC = cleanNonAsciiCharactersInString($data[34]);
	            $lunchC = cleanNonAsciiCharactersInString($data[35]);
	            $dinnerC = cleanNonAsciiCharactersInString($data[36]);
	            $roomGST = getGstIdBySlab(cleanNonAsciiCharactersInString($data[37]),"Hotel");
	            $mealGST =getGstIdBySlab(cleanNonAsciiCharactersInString($data[38]),"Restaurant");
	            $roomTAC = preg_replace('/[^A-Za-z0-9\-]/', '', cleanNonAsciiCharactersInString($data[39]));
	            $remarks = cleanNonAsciiCharactersInString($data[40]);
	            $hotelType = cleanNonAsciiCharactersInString($data[41]);
	            $hotelCategory = cleanNonAsciiCharactersInString($data[42]);
	            $url = cleanNonAsciiCharactersInString($data[43]);
	            $hotelChain = cleanNonAsciiCharactersInString($data[44]);
	            $weekendName = cleanNonAsciiCharactersInString($data[45]);
	            $hoteldetail = cleanNonAsciiCharactersInString($data[46]);
	            $hotelpolicy = cleanNonAsciiCharactersInString($data[47]);
	            $hoteltermandcondition = cleanNonAsciiCharactersInString($data[48]);

                // Rest of your code here for processing CSV data
            }

            fclose($csvFile);
        } else {
            // Handle error if CSV file couldn't be opened
            echo "Error opening CSV file.";
        }
    }
}
