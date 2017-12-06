<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
</head>
<body>

    <div id="proj"></div>
    <p id="demo1"></p>
    <p id="demo2"></p>


      <form name="myForm" action="" onsubmit="return addP()">
      Project Name: <input type="text" name="projName">
      Type: <input type="text" name="projType">
      <input type="submit" name="Submit">
      </form>

  <span id="result"></span>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>

	function addP() {
          var pname = document.forms["myForm"]["projName"].value;
          var ptype = document.forms["myForm"]["projType"].value;
          if (pname == "") {
              alert("Project Name must be filled out");
              return false;
          }else{
          	alert(" filled out");
          	var xhttp=new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        alert(this.readyState);
	        alert(this.status);
	        if (this.readyState == 4 && this.status == 200) {
	          document.getElementById("result").innerHTML = this.responseText;  
	          alert("Im in");
	          }
	          alert("Failed in the ELSE statement");
	        }
	        alert("Failed outside");
	        xhttp.open("GET", "addProject.php?q="+pname+"&y="+ptype, true);
	        xhttp.send();
        	//xmlhttp.open("GET", "addProject.php?q="+pname+"&y="+ptype, true);
        	//xmlhttp.send();
          }
      }

      
    </script>
</body>
</html>
