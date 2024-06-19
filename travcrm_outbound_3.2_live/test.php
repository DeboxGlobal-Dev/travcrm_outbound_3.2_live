<?php
// ob_start();
include "inc.php";
// Ferry table name => ferrypricemaster
// Activity table name => packagebuilderotheractivitymaster
// Additional  table name => extraquotation 
// Transfer table name => packagebuildertransportmaster
// Hotel table name => packagebuilderhotelmaster


// $displayId1 = 1;
// $displayIdQuery1 = GetPageRecord('id', 'ferrypricemaster', ' 1  and name!="" order by name asc');
// while ($data1 = mysqli_fetch_array($displayIdQuery1)) {
//     updatelisting('ferrypricemaster', ' displayId="'.$displayId1.'"', 'id="' . $data1['id'] . '"');
//     $displayId1++;
// }


// $displayId2 = 1;
// $displayIdQuery2 = GetPageRecord('id', 'packagebuilderotheractivitymaster', ' 1  and otherActivityName!="" order by otherActivityName asc');
// while ($data2 = mysqli_fetch_array($displayIdQuery2)) {
//     updatelisting('packagebuilderotheractivitymaster', ' displayId="'.$displayId2.'"', 'id="' . $data2['id'] . '"');
//     $displayId2++;
// }


// $displayId3 = 1;
// $displayIdQuery3 = GetPageRecord('id', 'extraquotation', ' 1  and name!="" order by name asc');
// while ($data3 = mysqli_fetch_array($displayIdQuery3)) {
//     updatelisting('extraquotation', ' displayId="'.$displayId3.'"', 'id="' . $data3['id'] . '"');
//     $displayId3++;
// }


// $displayId4 = 1;
// $displayIdQuery4 = GetPageRecord('id', 'packagebuildertransportmaster', ' 1  and transferName!="" order by transferName asc');
// while ($data4 = mysqli_fetch_array($displayIdQuery4)) {
//     updatelisting('packagebuildertransportmaster', ' displayId="'.$displayId4.'"', 'id="' . $data4['id'] . '"');
//     $displayId4++;
// }


$displayId5 = 1;
$displayIdQuery5 = GetPageRecord('id', 'packagebuilderhotelmaster', ' 1  and hotelName!="" order by hotelName asc');
while ($data5 = mysqli_fetch_array($displayIdQuery5)) {
    updatelisting('packagebuilderhotelmaster', ' displayId="'.$displayId5.'"', 'id="' . $data5['id'] . '"');
    $displayId5++;
}

die();

