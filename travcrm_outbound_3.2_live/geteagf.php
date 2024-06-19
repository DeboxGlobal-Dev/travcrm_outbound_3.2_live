<?php
// Database Connection file
include('config/database.php');
?>
<table border="1">
<thead>
<tr>
<th>Sr.</th>
<th>Name</th>
</tr>
</thead>
<?php
// File name
$filename="Destination";
// Fetching data from data base
$query=mysqli_query(db(),"select * from destinationMaster where id=1");
$cnt=1;
while ($row=mysqli_fetch_array($query)) {

	// print_r($row);


?>
            <tr>
                <td><?php echo $row['id'];  ?></td>
                <td><?php echo $row['name'];?></td>
               
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