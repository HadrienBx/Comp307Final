<?php
// Initialize the session
session_start();
// access DB through $link
require_once 'db.php';
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: index.php");
  exit;
}
//get username
$username1= $_SESSION['username'];


if (!empty($_POST['loggg'])) {
  $sql = "UPDATE users SET login = '0' WHERE username = ?";
  if($stmt = mysqli_prepare($link, $sql)){
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username1;
    mysqli_stmt_execute($stmt);
  }else {
    echo "nope.";
  }

  $_SESSION = array();
  session_destroy();
  header("location: index.php");
  exit;
  mysqli_stmt_close($stmt);
}

if (!empty($_POST['piD']))  {
  $pid = $_POST['piD'];
  session_start();
  $_SESSION['user'] = $username1;
  $_SESSION['pid'] = $pid;  
  header("location: editor.php");
}





mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--BootStrap-->
    <title>WOOBS Pro</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: left; }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <style>
    img {
      width: 100%;
    }
    </style>
</head>
<body>

    <!--Navbar, grey with white text-->
    <nav class="navbar navbar-expand-sm bg-light navbar-light ">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Logout</a>
        </li>
      </ul>
    </nav>
    <!--End of Nav Bar-->
    <!--Not yet functional-->

    <!--JumboTron-->
    <!--Make this smaller-->
    <div class="jumbotron">
        <h1 class="display-5">Welcome to WOOBS Pro, <b><?php echo $_SESSION['username']; ?></b>.</h1>
        <p class="lead">Here are all your projects.</p>
        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#apMod">Add Project</button>
        <!--LogOut-->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="hidden" name="loggg" value="yooo" />
        <input type="submit" class="btn btn-secondary btn-lg" value="Logout"></form>
        <!--End of Logout-->
    </div>

   <!-- The Modal -->
    <div class="modal fade" id="apMod">
    <div class="modal-dialog">
        <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Add Project</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <form name="myForm" action="" onsubmit="return addP()">
            <h4>Create a new project!</h4>
            Project Name: <input type="text" name="projName"><br />
            Type: <input type="text" name="projType"><br />
            Description: <input type="text" name="projDesc"><br />
            <input type="submit" name="Submit"><br />
            </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

        </div>
    </div>
    </div>
    <!--End Of Modal-->

    <!--Displays all Projects in a Grid-->
    <div class="container">
    <div id="proj" class="row">
    </div> <!--function adds to this-->
    </div>
    <!--End of Displaying Projects-->

    <script>

      function displayProjects(){ //draws the grid
        var user = "<?php echo $_SESSION['username'] ?>";
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            var i = 0;
            var project = document.getElementById("proj");
            while (obj[i] != null){
              var node = document.createElement("div");
              node.id = obj[i].p_id;
              node.className = "col-sm-6 col-md-4 col-lg-3"; //for grid
              var thb = document.createElement("div"); //thumbnail
              thb.className = "thumbnail"; //thumbnail
              var image = document.createElement("img");
              image.src = "photo.jpg"; //this links to a photo of hadrien
              var name = document.createElement("h5"); //project name
              name.className = "btn btn-outline-primary btn-block";
              name.innerHTML = obj[i].p_name;
              //name.className = "projName";
              //var type = document.createElement("h6");
              //type.className = "btn btn-outline-secondary";
              //var description = document.createElement("p");
              //description.innerHTML = obj[i].description; //description
              //description.className = "projDescription"; //for css purposes
              //view : needs modal
              //Open editor
              // var view = document.createElement("h6");
              // view.id = obj[i].p_id + "op";
              // view.className = "btn btn-outline-success";
              // view.innerHTML = "Open";
              // view.onclick = loadEditorFunc;
              var view = document.createElement("form"); // form 
              view.method = "post"; // where method = post
              view.action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
              var inp1 = document.createElement("input");
              inp1.type = "hidden"; //hidden input
              inp1.name = "piD"; //that's the input
              inp1.value = obj[i].p_id;
              var inp2 = document.createElement("input"); //this is for open
              inp2.type = "submit";
              inp2.className = "btn btn-outline-success";
              inp2.value = "Open";
              view.appendChild(inp1);
              view.appendChild(inp2);
              //Edit proj details
              var edit = document.createElement("h6");
              edit.id = obj[i].p_id + "ed";
              edit.className = "btn btn-outline-warning";
              edit.innerHTML = "Edit";
              //DeleteProj
              var deleteButton = document.createElement("h5");
              deleteButton.id = obj[i].p_id + "del"; //for JavaScript
              deleteButton.className = "btn btn-outline-danger";
              deleteButton.innerHTML = "Delete";
              deleteButton.onclick = delP;
              //type.innerHTML = obj[i].type;
              node.appendChild(thb);
              thb.appendChild(name);
              thb.appendChild(image);
              //thb.appendChild(type);
              thb.appendChild(view); // THIS APPENDS THE FORM
              thb.appendChild(edit);
              thb.appendChild(deleteButton);
              //thb.appendChild(description);
              project.appendChild(node);
              i++;
            }
          }
        }
        xhttp.open("GET", "displayProjects.php?q="+user, true);
        xhttp.send();
      }
      displayProjects(); //calls function to display projects

      function addP() {

        //Here we get all the variables needed
        var user = "<?php echo $_SESSION['username'] ?>";
        var pname = document.forms["myForm"]["projName"].value;
        var ptype = document.forms["myForm"]["projType"].value;
        var pdesc = document.forms["myForm"]["projDesc"].value;

        //Show an alert if the fields are blank
        if (pname == "" || ptype=="" || pdesc == "") {
          alert("Project Name must be filled out");
          return false;
        //Else run the Script to add
        }else{
          //alert(" filled out");
          var xhttp=new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            //alert(this.readyState);
            //alert(this.status);
          if (this.readyState == 4 && this.status == 0) {
            //document.getElementById("result").innerHTML = this.responseText;
            displayProjects();
          }
        }
        //Pass the variables as q, y, z and x
        xhttp.open("GET", "addProject.php?q="+pname+"&y="+ptype+"&z="+user+"&x="+pdesc, true);
        xhttp.send();
        }
      }

      // Delete Project Function
      function delP() {

        // Use the below line to get input from onclick button
        var pname1 = this.id;
        var a = parseInt(pname1);   //a = p_id

        // Use the below line to get input from form
        //var pname = document.forms["myDelForm"]["projName"].value;
        var b = "<?php echo $_SESSION['username'] ?>";     //b = username

        //Show an alert if the fields are blank
        if (a == "") {
          alert("Please Provide a project name.");
          return false;
        //Else run the Script to delete
        }else{
          //alert(" filled out");
          var xhttp=new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            //alert(this.readyState);
            //alert(this.status);
          if (this.readyState == 4 && this.status == 0) {
          }
        }
        xhttp.open("GET", "deleteProj.php?a="+a+"&b="+b, true);
        xhttp.send();
        location.reload();
        }
      }

      // Launch Project Function
      function loadEditorFunc(){
        var pname1 = this.id;
        var a = parseInt(pname1);  //a = pid
        var b = "<?php echo $_SESSION['username'] ?>";     //b = username
        if (a == "") {
          alert("Error opening project. Try again!");
          return false;
        //Else run the Script to delete
        }else{
          //alert(" filled out");
          var xhttp=new XMLHttpRequest();
          xhttp.onreadystatechange = function() {
            //alert(this.readyState);
            //alert(this.status);
          if (this.readyState == 4 && this.status == 0) {
          }
        }
        xhttp.open("GET", "loadEditor.php?a="+a+"&b="+b, true);
        xhttp.send();
        }
      }

    </script>

</body>
</html>
