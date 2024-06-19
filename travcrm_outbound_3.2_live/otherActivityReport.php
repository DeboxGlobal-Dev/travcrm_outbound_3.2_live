<?php 
// Database Connection file
include('config/database.php');
?>
<table border="1">
<thead>
<tr>
<th>Sr.No</th>
<th>Name </th>
<th>Destination </th>
<th>Details </th>
<th>Adult Cost</th>
<th>Child Cost</th>
<th>Status</th>
</tr>
</thead>
<?php
// File name
$filename="other Activity Master";
// Fetching data from data base
$query=mysqli_query(db(),"select * from packageBuilderotherActivityMaster");
$cnt=1;
while ($row=mysqli_fetch_array($query)) {

	
    $status = $row['status'];

 if ($status == 1) {
 	
 	$statusc = 'Active';
 }if ($status == 0){
 	$statusc = 'Inactive';
 }

?>
            <tr>
                <td><?php echo $cnt;  ?></td>
                <td><?php echo $row['otherActivityName'];?></td>
                <td><?php echo $row['otherActivityCity'];?></td>
                <td><?php echo $row['otherActivityDetail'];?></td>
                <td><?php echo $row['adultCost'];?></td>
                <td><?php echo $row['childCost'];?></td>
                <td><?php echo $statusc;?></td>
               
            </tr>
<?php
$cnt++;
// Genrating Execel  filess
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$filename."-Report.xls");
header("Pragma: no-cache");
header("Expires: 0");
} ?>
</table>