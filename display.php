<!-- <?php
/* COMMENTS HERE AND ABOVE
session_start();

require_once 'db.php';

// We are given the "p_id" and the "u_id"
// We want to display all the tasks who belong to the "p_id"
$pid = 1;
$sql_pid = "SELECT * FROM tasks WHERE p_id=$pid";
$allResults = mysqli_query($link, $sql_pid);
$allRowsInt = mysqli_num_rows($allResults);
//echo(mysqli_num_rows($result) . "<br>");


$prevDepth = (-1);
while($row = mysqli_fetch_array($allResults)){
	$depth = $row['depth'];
	$width = $row['width'];
	//echo "Depth is: " .$depth. " ";
	//echo "prevDepth is: " .$prevDepth. " ";
	// Create a variable [ [,], [,], [,] ]
/*
	if ($depth != $prevDepth) {
		echo "<br><br>"; 
		//echo $row['t_name'] . " ";
		getData($row);
		$prevDepth = $depth;
	}else{
		//echo $row['t_name'] . " ";
		getData($row);
	}	
*/
}

/*
function getData($row){
	$taskName = $row['t_name'];
	$taskDescription = $row['description'];
	$taskDueDate = $row['due_date'];
	//echo $taskName;
	//echo $taskDescription;
	//echo $taskDueDate;	
}
*/


?>
-->

<!DOCTYPE html>
<html>
<body>
  <head>  
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages:["orgchart"]});
      google.charts.setOnLoadCallback(drawChart);

      



	    function drawChart() {  
	     var data = new google.visualization.DataTable();  
	     data.addColumn('string', 'Node');  
	     data.addColumn('string', 'Parent');  

	     // get the number of tasks corresponding to the p_id 
	     
	     // from i = 0 to th number of tree levels (How??)
	     	// for j = 0 to the number of width at the current tree level
	     		// current_parent = node [i,j]
	     		// $tasks = get the total tasks with parent = current_parent
	     			// while (row exists in $tasks){
	     				// addRow([ ['$row'],['current_parent'] ])
	     			// }
	     	// }	
	     // }

	     data.addRows([  
	      ['description',''],  
	      ['1.1', 'description'],  
	      ['1.2', 'description'],   
	     ]); 



	     var test = [['mine','description'],['yours','description']];
	     data.addRows(test); 

	     //var data = new google.visualization.DataTable(jsonData);

	     var chart = new google.visualization.OrgChart(document.getElementById('chart_div'));  
	     chart.draw(data);  
	    }  
   </script>  
  </head>  
  <body>  
   <div id='chart_div'></div>  
  </body>  
 </html>  
</html>




