<?php 
// ----------------------------- Date Reverse Function Start --------------------------------------------------
function Date_reverse($demo_date)
{
   if($demo_date!='')
      {
        $demo_date=explode('-',$demo_date);
        $demo_date=$demo_date[2]."-".$demo_date[1]."-".$demo_date[0];
        return $demo_date;
      }
}
// ----------------------------- Date Reverse Function End --------------------------------------------------

// ----------------------------- Date Diffrence Function End --------------------------------------------------						
function dateDiff($start, $end) 
		{
           $start_ts = strtotime($start); 
		   $end_ts = strtotime($end);
		   $diff = $end_ts - $start_ts;
		   return round($diff / 86400);
         }
// ----------------------------- Date Diffrence Function End --------------------------------------------------		

// ----------------------------- Alpha Numeric value Generate Function Start --------------------------------------------------		

//  The first function: assign alphanumeric value


function assign_rand_value($num)
{
// accepts 1 - 36
  switch($num)
  {
    case "1":
     $rand_value = "a";
    break;
    case "2":
     $rand_value = "b";
    break;
    case "3":
     $rand_value = "c";
    break;
    case "4":
     $rand_value = "d";
    break;
    case "5":
     $rand_value = "e";
    break;
    case "6":
     $rand_value = "f";
    break;
    case "7":
     $rand_value = "g";
    break;
    case "8":
     $rand_value = "h";
    break;
    case "9":
     $rand_value = "i";
    break;
    case "10":
     $rand_value = "j";
    break;
    case "11":
     $rand_value = "k";
    break;
    case "12":
     $rand_value = "l";
    break;
    case "13":
     $rand_value = "m";
    break;
    case "14":
     $rand_value = "n";
    break;
    case "15":
     $rand_value = "o";
    break;
    case "16":
     $rand_value = "p";
    break;
    case "17":
     $rand_value = "q";
    break;
    case "18":
     $rand_value = "r";
    break;
    case "19":
     $rand_value = "s";
    break;
    case "20":
     $rand_value = "t";
    break;
    case "21":
     $rand_value = "u";
    break;
    case "22":
     $rand_value = "v";
    break;
    case "23":
     $rand_value = "w";
    break;
    case "24":
     $rand_value = "x";
    break;
    case "25":
     $rand_value = "y";
    break;
    case "26":
     $rand_value = "z";
    break;
    case "27":
     $rand_value = "A";
    break;
	case "28":
     $rand_value = "B";
    break;
	case "29":
     $rand_value = "C";
    break;
	case "30":
     $rand_value = "D";
    break;
	case "31":
     $rand_value = "E";
    break;
	case "32":
     $rand_value = "F";
    break;
	case "33":
     $rand_value = "G";
    break;
	case "34":
     $rand_value = "H";
    break;
	case "35":
     $rand_value = "I";
    break;
	case "36":
     $rand_value = "J";
    break;
	case "37":
     $rand_value = "K";
    break;
	case "38":
     $rand_value = "L";
    break;
	case "39":
     $rand_value = "M";
    break;
	case "40":
     $rand_value = "N";
    break;
	case "41":
     $rand_value = "O";
    break;
	case "42":
     $rand_value = "P";
    break;
	case "43":
     $rand_value = "Q";
    break;
	case "44":
     $rand_value = "R";
    break;
	case "45":
     $rand_value = "S";
    break;
	case "46":
     $rand_value = "T";
    break;
	case "47":
     $rand_value = "U";
    break;
	case "48":
     $rand_value = "V";
    break;
	case "49":
     $rand_value = "W";
    break;
	case "50":
     $rand_value = "X";
    break;
	case "51":
     $rand_value = "Y";
    break;
	case "52":
     $rand_value = "Z";
    break;
	case "53":
     $rand_value = "0";
    break;
    case "54":
     $rand_value = "1";
    break;
    case "55":
     $rand_value = "2";
    break;
    case "56":
     $rand_value = "3";
    break;
    case "57":
     $rand_value = "4";
    break;
    case "58":
     $rand_value = "5";
    break;
    case "59":
     $rand_value = "6";
    break;
    case "60":
     $rand_value = "7";
    break;
    case "61":
     $rand_value = "8";
    break;
    case "62":
     $rand_value = "9";
    break;
  }
return $rand_value;
}	

//  The second function: generate random string
function get_rand_id($length)
{
  if($length>0) 
  { 
  $rand_id="";
   for($i=1; $i<=$length; $i++)
   {
   mt_srand((double)microtime() * 1000000);
   $num = mt_rand(27,62);
   $rand_id .= assign_rand_value($num);
   }
  }
return $rand_id;
} 


//Altering the random string generator
//For strings of only numbers, keep the first function and add this function (the changes have been put in bold)

      function get_rand_numbers($length)
      {
        if($length>0) 
        { 
        $rand_id="";
         for($i=1; $i<=$length; $i++)
         {
         mt_srand((double)microtime() * 1000000);
         $num = mt_rand(53,62);
         $rand_id .= assign_rand_value($num);
         }
        }
      return $rand_id;
      } 

//For only letters, keep the first function and add this function (the changes have been put in bold)

      function get_rand_letters($length)
      {
        if($length>0) 
        { 
        $rand_id="";
         for($i=1; $i<=$length; $i++)
         {
         mt_srand((double)microtime() * 1000000);
         $num = mt_rand(1,26);
         $rand_id .= assign_rand_value($num);
         }
        }
      return $rand_id;
      } 

// ----------------------------- Alpha Numeric value Generate Function End --------------------------------------------------	
// ----------------------------- Alpha Numeric value Generate Function End --------------------------------------------------	

function Country($country_code)
  {
    
    switch($country_code)
      {
    case "AF":
     $country_name = "Afghanistan";
    break;
	case "AL":
     $country_name = "Albania";
    break;
	case "DZ":
     $country_name = "Algeria";
    break;
	case "AS":
     $country_name = "American Samoa";
    break;
	case "AD":
     $country_name = "Andorra";
    break;
	case "AO":
     $country_name = "Angola";
    break;
	case "AI":
     $country_name = "Anguilla";
    break;
	case "AQ":
     $country_name = "Antarctica";
    break;
	case "AG":
     $country_name = "Antigua and Barbuda";
    break;   
	case "AR":
     $country_name = "Argentina";
    break;
	case "AM":
     $country_name = "Armenia";
    break;
	case "AW":
     $country_name = "Aruba";
    break;
	case "AU":
     $country_name = "Australia";
    break;
	case "AT":
     $country_name = "Austria";
    break;
	case "AZ":
     $country_name = "Azerbaijan";
    break;
	case "BS":
     $country_name = "Bahamas";
    break;
	case "BH":
     $country_name = "Bahrain";
    break;
	case "BD":
     $country_name = "Bangladesh";
    break;
	case "BB":
     $country_name = "Barbados";
    break;
	case "BY":
     $country_name = "Belarus";
    break;
	case "BE":
     $country_name = "Belgium";
    break;
	case "BZ":
     $country_name = "Belize";
    break;
	case "BJ":
     $country_name = "Benin";
    break;
	case "BM":
     $country_name = "Bermuda";
    break;
	case "BT":
     $country_name = "Bhutan";
    break;
	case "BO":
     $country_name = "Bolivia";
    break;
	case "BA":
     $country_name = "Bosnia and Herzegovina";
    break;
	case "BW":
     $country_name = "Botswana";
    break;
	case "BV":
     $country_name = "Bouvet Island";
    break;
	case "BR":
     $country_name = "Brazil";
    break;
	case "BN":
     $country_name = "Brunei";
    break;
	case "BG":
     $country_name = "Bulgaria";
    break;
	case "BF":
     $country_name = "Burkina Faso";
    break;
	case "BI":
     $country_name = "Burundi";
    break;   
    case "KH":
     $country_name = "Cambodia";
    break;   
    case "CM":
     $country_name = "Cameroon";
    break;   
    case "CA":
     $country_name = "Canada";
    break;   
    case "CV":
     $country_name = "Cape Verde";
    break;   
    case "KY":
     $country_name = "Cayman Islands";
    break;   
    case "CF":
     $country_name = "Central African Republic";
    break;   
    case "TD":
     $country_name = "Chad";
    break;   
    case "CL":
     $country_name = "Chile";
    break;   
    case "CN":
     $country_name = "China";
    break;   
    case "CX":
     $country_name = "Christmas Island";
    break;   
    case "CC":
     $country_name = "Cocos (Keeling) Islands";
    break;   
    case "CO":
     $country_name = "Colombia";
    break;   
    case "KM":
     $country_name = "Comoros";
    break;   
    case "CG":
     $country_name = "Congo";
    break;   
    case "CK":
     $country_name = "Cook Islands";
    break;   
    case "CR":
     $country_name = "Costa Rica";
    break;   
    case "CS":
     $country_name = "Czechoslovakia, Former";
    break;   
    case "CI":
     $country_name = "Ivory Coast";
    break;   
    case "HR":
     $country_name = "Croatia Hrvatska";
    break;   
    case "CU":
     $country_name = "Cuba";
    break;   
    case "CY":
     $country_name = "Cyprus";
    break;   
    case "CZ":
     $country_name = "Czech Republic";
    break;   
    case "DK":
     $country_name = "Denmark";
    break;   
    case "DJ":
     $country_name = "Djibouti";
    break;   
    case "DM":
     $country_name = "Dominica";
    break;   
    case "DO":
     $country_name = "Dominican Republic";
    break;   
    case "TP":
     $country_name = "EastTimor";
    break;   
    case "EC":
     $country_name = "Ecuador";
    break;   
    case "EG":
     $country_name = "Egypt";
    break;   
    case "SV":
     $country_name = "El Salvador";
    break;   
    case "GQ":
     $country_name = "Equatorial Guinea";
    break;   
    case "ER":
     $country_name = "Eritrea";
    break;   
    case "EE":
     $country_name = "Estonia";
    break;   
    case "ET":
     $country_name = "Ethiopia";
    break;   
    case "FK":
     $country_name = "Falkland Islands";
    break;   
    case "FO":
     $country_name = "Faroe Islands";
    break;   
    case "FJ":
     $country_name = "Fiji Islands";
    break;   
    case "FI":
     $country_name = "Finland";
    break;   
    case "FR":
     $country_name = "France";
    break;   
    case "GF":
     $country_name = "French Guiana";
    break;   
    case "PF":
     $country_name = "French Polynesia";
    break;   
    case "TF":
     $country_name = "French Southern Territories";
    break;   
    case "GA":
     $country_name = "Gabon";
    break;   
    case "GM":
     $country_name = "Gambia";
    break;   
    case "GE":
     $country_name = "Georgia";
    break;   
    case "DE":
     $country_name = "Germany";
    break;   
    case "GH":
     $country_name = "Ghana";
    break;   
    case "GI":
     $country_name = "Gibraltar";
    break;   
    case "GR":
     $country_name = "Greece";
    break;   
    case "GL":
     $country_name = "Greenland";
    break;   
    case "GD":
     $country_name = "Grenada";
    break;   
    case "GP":
     $country_name = "Guadeloupe";
    break;   
    case "GU":
     $country_name = "Guam";
    break;   
    case "GT":
     $country_name = "Guatemala";
    break;   
    case "GG":
     $country_name = "Guernsey";
    break;   
    case "GN":
     $country_name = "Guinea";
    break;   
    case "GW":
     $country_name = "Guinea-Bissau";
    break;   
    case "GY":
     $country_name = "Guyana";
    break;   
    case "HT":
     $country_name = "Haiti";
    break;   
    case "HM":
     $country_name = "Heardand McDonald Islands";
    break;   
    case "HN":
     $country_name = "Honduras";
    break;   
    case "HK":
     $country_name = "Hong Kong S.A.R.";
    break;   
    case "HU":
     $country_name = "Hungary";
    break;   
    case "IS":
     $country_name = "Iceland";
    break;   
    case "IN":
     $country_name = "India";
    break;   
    case "ID":
     $country_name = "Indonesia";
    break;   
    case "IR":
     $country_name = "Iran";
    break;   
    case "IQ":
     $country_name = "Iraq";
    break;   
    case "IE":
     $country_name = "Ireland";
    break;   
    case "IL":
     $country_name = "Israel";
    break;   
    case "IT":
     $country_name = "Italy";
    break;   
    case "JM":
     $country_name = "Jamaica";
    break;   
    case "JP":
     $country_name = "Japan";
    break;   
    case "JO":
     $country_name = "Jordan";
    break;   
    case "KZ":
     $country_name = "Kazakhstan";
    break;   
    case "KE":
     $country_name = "Kenya";
    break;   
    case "KI":
     $country_name = "Kiribati";
    break;   
    case "KR":
     $country_name = "Korea, South";
    break;   
    case "KP":
     $country_name = "Korea, North";
    break;   
    case "KW":
     $country_name = "Kuwait";
    break;   
    case "KG":
     $country_name = "Kyrgyzstan";
    break;   
    case "LA":
     $country_name = "Laos";
    break;   
    case "LV":
     $country_name = "Latvia";
    break;   
    case "LB":
     $country_name = "Lebanon";
    break;   
    case "LS":
     $country_name = "Lesotho";
    break;   
    case "LR":
     $country_name = "Liberia";
    break;   
    case "LY":
     $country_name = "Libya";
    break;   
    case "LI":
     $country_name = "Liechtenstein";
    break;   
    case "LT":
     $country_name = "Lithuania";
    break;   
    case "LU":
     $country_name = "Luxembourg";
    break;   
    case "MO":
     $country_name = "Macau S.A.R.";
    break;   
    case "MG":
     $country_name = "Madagascar";
    break;   
    case "MW":
     $country_name = "Malawi";
    break;   
    case "MY":
     $country_name = "Malaysia";
    break;   
    case "MV":
     $country_name = "Maldives";
    break;   
    case "ML":
     $country_name = "Mali";
    break;   
    case "MT":
     $country_name = "Malta";
    break;   
    case "MH":
     $country_name = "Marshall Islands";
    break;   
    case "MQ":
     $country_name = "Martinique";
    break;   
    case "MR":
     $country_name = "Mauritania";
    break;   
    case "MU":
     $country_name = "Mauritius";
    break;   
    case "YT":
     $country_name = "Mayotte";
    break;   
    case "MX":
     $country_name = "Mexico";
    break;   
    case "FM":
     $country_name = "Micronesia";
    break;   
    case "MD":
     $country_name = "Moldova";
    break;   
    case "MC":
     $country_name = "Monaco";
    break;   
    case "MN":
     $country_name = "Mongolia";
    break;   
    case "MS":
     $country_name = "Montserrat";
    break;   
    case "MA":
     $country_name = "Morocco";
    break;   
    case "MZ":
     $country_name = "Mozambique";
    break;   
    case "MM":
     $country_name = "Myanmar";
    break;   
    case "NA":
     $country_name = "Namibia";
    break;   
    case "NR":
     $country_name = "Nauru";
    break;   
    case "NP":
     $country_name = "Nepal";
    break;   
    case "AN":
     $country_name = "Netherlands Antilles";
    break;   
    case "NL":
     $country_name = "Netherlands";
    break;   
    case "NC":
     $country_name = "New Caledonia";
    break;   
    case "NZ":
     $country_name = "New Zealand";
    break;   
    case "NI":
     $country_name = "Nicaragua";
    break;   
    case "NE":
     $country_name = "Niger";
    break;   
    case "NG":
     $country_name = "Nigeria";
    break;   
    case "NU":
     $country_name = "Niue";
    break;   
    case "NF":
     $country_name = "Norfolk Island";
    break;   
    case "MP":
     $country_name = "Northern Mariana Islands";
    break;   
    case "NO":
     $country_name = "Norway";
    break;   
    case "OM":
     $country_name = "Oman";
    break;   
    case "PK":
     $country_name = "Pakistan";
    break;   
    case "PW":
     $country_name = "Palau";
    break;   
    case "PA":
     $country_name = "Panama";
    break;   
    case "PG":
     $country_name = "Papua New Guinea";
    break;   
    case "PY":
     $country_name = "Paraguay";
    break;   
    case "PE":
     $country_name = "Peru";
    break;   
    case "PH":
     $country_name = "Philippines";
    break;   
    case "PN":
     $country_name = "Pitcairn Island";
    break;   
    case "PL":
     $country_name = "Poland";
    break;   
    case "PT":
     $country_name = "Portugal";
    break;   
    case "PR":
     $country_name = "Puerto Rico";
    break;   
    case "QA":
     $country_name = "Qatar";
    break;   
    case "RE":
     $country_name = "Reunion";
    break;   
    case "RO":
     $country_name = "Romania";
    break;   
    case "RU":
     $country_name = "Russia";
    break;   
    case "RW":
     $country_name = "Rwanda";
    break;   
    case "SH":
     $country_name = "Saint Helena";
    break;   
    case "KN":
     $country_name = "Saint Kitts And Nevis";
    break;   
    case "LC":
     $country_name = "Saint Lucia";
    break;   
    case "PM":
     $country_name = "Saint Pierre and Miquelon";
    break;   
    case "WS":
     $country_name = "Samoa";
    break;   
    case "SM":
     $country_name = "San Marino";
    break;   
    case "ST":
     $country_name = "Sao Tome and Principe";
    break;   
    case "SA":
     $country_name = "Saudi Arabia";
    break;   
    case "SN":
     $country_name = "Senegal";
    break;   
    case "SC":
     $country_name = "Seychelles";
    break;   
    case "SL":
     $country_name = "Sierra Leone";
    break;   
    case "SG":
     $country_name = "Singapore";
    break;   
    case "SK":
     $country_name = "Slovakia";
    break;   
    case "SI":
     $country_name = "Slovenia";
    break;   
    case "SB":
     $country_name = "Solomon Islands";
    break;   
    case "SO":
     $country_name = "Somalia";
    break;   
    case "ZA":
     $country_name = "South Africa";
    break;   
    case "ES":
     $country_name = "Spain";
    break;   
    case "LK":
     $country_name = "Sri Lanka";
    break;   
    case "SD":
     $country_name = "Sudan";
    break;   
    case "SR":
     $country_name = "Suriname";
    break;   
    case "SZ":
     $country_name = "Swaziland";
    break;   
    case "SE":
     $country_name = "Sweden";
    break;   
    case "CH":
     $country_name = "Switzerland";
    break;   
    case "SY":
     $country_name = "Syria";
    break;   
    case "TW":
     $country_name = "Taiwan";
    break;   
    case "TJ":
     $country_name = "Tajikistan";
    break;   
    case "TZ":
     $country_name = "Tanzania";
    break;   
    case "TH":
     $country_name = "Thailand";
    break;   
    case "TG":
     $country_name = "Togo";
    break;   
    case "TK":
     $country_name = "Tokelau";
    break;   
    case "TO":
     $country_name = "Tonga";
    break;   
    case "TT":
     $country_name = "Trinidad And Tobago";
    break;   
    case "TN":
     $country_name = "Tunisia";
    break;   
    case "TR":
     $country_name = "Turkey";
    break;   
    case "TM":
     $country_name = "Turkmenistan";
    break;   
    case "TC":
     $country_name = "Turks And Caicos Islands";
    break;   
    case "TV":
     $country_name = "Tuvalu";
    break;   
    case "UG":
     $country_name = "Uganda";
    break;   
    case "UA":
     $country_name = "Ukraine";
    break;   
    case "AE":
     $country_name = "United Arab Emirates";
    break;   
    case "UK":
     $country_name = "United Kingdom";
    break;   
    case "US":
     $country_name = "United States";
    break;   
    case "UM":
     $country_name = "United States Minor Outlying Islands";
    break;   
    case "UY":
     $country_name = "Uruguay";
    break;   
    case "UZ":
     $country_name = "Uzbekistan";
    break;   
    case "VU":
     $country_name = "Vanuatu";
    break;   
    case "VA":
     $country_name = "Vatican City State (HolySee)";
    break;   
    case "VE":
     $country_name = "Venezuela";
    break;   
    case "VN":
     $country_name = "Vietnam";
    break;   
    case "VG":
     $country_name = "Virgin Islands (British)";
    break;   
    case "VI":
     $country_name = "Virgin Islands (US)";
    break;   
    case "WF":
     $country_name = "Wallis And Futuna Islands";
    break;   
    case "YE":
     $country_name = "Yemen";
    break;   
    case "YU":
     $country_name = "Yugoslavia";
    break;   
    case "ZM":
     $country_name = "Zambia";
    break;   
    case "ZW":
     $country_name = "Zimbabwe";
    break;   
   }
return $country_name;

}		

?>