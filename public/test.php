<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
}

th, td {
  padding: 5px;
}
</style>

<?

//				 Middle 
// LAT:  24.91 - 24.92 - 24.93
$x_start = '24.9100'; 

$x_start_no = explode('.',$x_start);

$x_start_no_1 = $x_start_no[0];
$x_start_no_2 = $x_start_no[1];
$x_start_no_3 = $x_start_no_2 + 200;

// LNG:	 

$y_start = '67.1000'; 

$y_start_no = explode('.',$y_start);

$y_start_no_1 = $y_start_no[0];
$y_start_no_2 = $y_start_no[1];
$y_start_no_3 = $y_start_no_2 + 500;

echo '<table>';
for($i=$x_start_no_2; $i<=$x_start_no_3; $i++)
{
	echo '<tr>';
	for($j=$y_start_no_2; $j<=$y_start_no_3; $j=$j+10)
	{
		echo '<td>'.$x_start_no_1.'.'.$i.','.$y_start_no_1.'.'.$j.'</td>';	
	}	
	echo '</tr>';
}	
echo '</table>';

// explain user_moving_requests;
// select * from user_moving_requests
// where prefer_date = '2019-11-21'
// and(s_lat >= 24.9188 and s_lat <= 24.9588)
// and(s_lng >= 67.0700 and s_lng <= 67.1100);

// #24.930359, 67.103003



?>