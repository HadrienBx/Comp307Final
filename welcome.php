<?php
// Initialize the session
session_start();

require_once 'db.php';

// If session variable is not set it will redirect to login page
if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
  header("location: login.php");
  exit;
}
$color= "red";
$username1= $_SESSION['username'];
$sql = "SELECT color FROM users WHERE username='$username1'";
$result = mysqli_query($link, $sql);
$color1 = mysqli_fetch_assoc($result);
$color = $color1["color"];


$sql= "SELECT u_id FROM users WHERE username='$username1'";
$result = mysqli_query($link, $sql);
$userid = mysqli_fetch_row($result);
$uid = $userid[0];
$sql1= "SELECT * FROM projects WHERE p_id = ANY (SELECT p_id FROM project_user WHERE u_id ='$uid')";
$result1 = mysqli_query($link, $sql1);
$projects = mysqli_fetch_all($result1,MYSQLI_ASSOC);
$WBSPROJ = json_encode($projects);
//echo $WBSPROJ;

if($_SERVER["REQUEST_METHOD"] == "POST"){
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
  header("location: login.php");
  exit;
  mysqli_stmt_close($stmt);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: left; }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <style>
    img {
      width: 100%;
      margin-bottom: 5px;
    } 
    #content0 {
      margin-top: 25px;
    }
    #EditProject{
      margin-left: 5px;
      margin-right: 5px;
    }
    input[type=text], select {
      text-align: center;
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #dfecdf;
      border-radius: 4px;
      box-sizing: border-box;
      background-color:	#dfecdf;
      color: #383838;
      margin-bottom: 20px;
    }
    input[type=date], select{
      text-align: center;
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #dfecdf;
      border-radius: 4px;
      box-sizing: border-box;
      background-color:	#dfecdf;
      color: #383838;
      margin-bottom: 20px;
    }
    textarea{
      text-align: center;
      width:99%;
      height: 90px;
      padding: 12px 20px;
      display: inline-block;
      border: 1px solid #dfecdf;
      border-radius: 4px;
      box-sizing: border-box;
      background-color:	#dfecdf;
      color: #383838;
      margin-bottom: 20px;
    }
    </style>
</head>
<body>
    <!--Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">wbs</a> 
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="welcome.php"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
          </li>
        </ul>
            <a class="nav-link" href="register.php"><i style="color: black" class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
      </div>
    </nav>

    <main role="main" class="container-fluid" id="content0">
      <div class="row">
        <aside class="col-sm-3 blog-sidebar"> 
          <div class="jumbotron">
            <h1 class="display-5">Welcome to WOOBS Pro, <b><?php echo $_SESSION['username']; ?></b>.</h1>
            <p class="lead">Here are all your projects.</p>
            <button type="button" class="btn btn-primary btn-md" data-toggle="modal" data-target="#apMod">Add Project</button>
            <button type="button" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#aboutMod">About</button>
          </div>
        </aside>
        <div class="col-sm-9 blog-main">
          <!--Displays all Projects in a Grid-->
          <div class="container">
            <div id="proj" class="row">
            </div> <!--function adds to this-->
          </div>
          <!--End of Displaying Projects-->
        </div>
    </main>


    <!-- The  About  Modal -->
    <div class="modal fade" id="aboutMod">
    <div class="modal-dialog">
        <div class="modal-content p-3 mb-2 bg-light text-dark">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">About</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form name="myForm" action="" onsubmit="return addP()">
              <p class="lead">
                This is WOOBS Pro, our final project for COMP 307. It is an online work-breakdown structure that allows users to 
                create projects and append tasks to each project. We store the tasks in a tree structure in our SQL database. 
                Our front-end consists of HTML, JS, CSS, JavaScript, jQuery and Bootstrap while our back-end consists of mySQL and PHP.
              <a href="https://www.github.com/hadrienBx/Comp307Final"><i class="fa fa-github-square" aria-hidden="true"></i></a>
              </p>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
        </div>
    </div>
    </div>
    <!--End Of Modal-->


   <!-- The Add Project Modal -->
    <div class="modal fade" id="apMod">
    <div class="modal-dialog">
        <div class="modal-content p-3 mb-2 bg-light text-dark">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Create A New Project!</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form name="myForm" action="" onsubmit="return addP()">
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Project Name</h4>
              <input type="text" placeholder="What are you working on?" name="projName"><br/>
              <h4 class="display-6" style="text-align:center">Type of Project</h4>
              <input type="text" size="40" placeholder="Is this personal or professional?" name="projType"><br/>
              <h4 class="display-6" style="text-align:center">Description</h4>
              <textarea name="projDesc" placeholder="Describe what you wish to accomplish."></textarea><br/>
              <!--Things To Add: Due Date and Image-->
              <h4 class="display-6" style="text-align:center">Due Date</h4>
              <input id="date" type="date" name="projDue"><br/>
              <h4 class="display-6" style="text-align:center">Image Hyperlink</h4>
              <input type="text" placeholder="https://" name="projImg"></br>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" name="Submit"><br/></form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
        </div>
    </div>
    </div>
    <!--End Of Modal-->

    <!-- Footer --> 
    <div class="navbar navbar-default navbar-fixed-bottom">
    <div class="container">
      <p class="navbar-text pull-right"><span class="text-muted"</span>
      © 2016 Hadrien Blampoix, Mathieu Estibals, Sophia Hu
      <a href="https://www.github.com/hadrienBx/Comp307Final"><i class="fa fa-github-square" aria-hidden="true"></i></a>
      </p>
    </div>
    </div>


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
              node.className = "col-sm-6 col-md-4 col-lg-4"; //for grid
              var thb = document.createElement("div"); //thumbnail
              thb.className = "thumbnail"; //thumbnail
              var image = document.createElement("img");
              image.src = obj[i].img;
              if (obj[i].img==null) image.src = "https://www.thephotoargus.com/wp-content/uploads/2017/05/yosemite-3.jpg"; //this links to a photo of hadrien
              var name = document.createElement("p"); //project name
              name.className = "alert alert-info";
              name.innerHTML = obj[i].p_name; 
              //name.className = "projName";
              //var type = document.createElement("h6");
              //type.className = "btn btn-outline-secondary";
              //var description = document.createElement("p");
              //description.innerHTML = obj[i].description; //description
              //description.className = "projDescription"; //for css purposes
              //view : needs modal

              var view = document.createElement("p"); //starts copypasta
              view.method="post";
              view.action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>";
              var inp1 = document.createElement("input");
              inp1.type = "hidden"; //hidden input
              inp1.name = "piD"; //that's the input
              inp1.value = obj[i].p_id; //end of copypasta
              view.id = "ViewProject";
              view.appendChild(inp1); //copypasta
              view.className = "btn btn-primary btn-sm";
              view.innerHTML = "View";
              //edit 
              var edit = document.createElement("p");
              edit.id = "EditProject";
              edit.className = "btn btn-secondary btn-sm";
              edit.innerHTML = "Edit";

              var deleteButton = document.createElement("p");
              deleteButton.id = obj[i].p_id + "del"; //for JavaScript
              deleteButton.className = "btn btn-danger btn-sm";
              deleteButton.innerHTML = "Delete";
              deleteButton.onclick = delP;
              //type.innerHTML = obj[i].type;
              node.appendChild(thb);
              thb.appendChild(name);
              thb.appendChild(image);
              //thb.appendChild(type);
              thb.appendChild(view);
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
        var pdue = document.forms["myForm"]["projDue"].value;
        var pimg = document.forms["myForm"]["projImg"].value;

        //Show an alert if the fields are blank
        if (pname == "") {
          alert("Please fill out the project name.");
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
        //Pass the variables as q, y, z, x, a, and b
        xhttp.open("GET", "addProject.php?q="+pname+"&y="+ptype+"&z="+user+"&x="+pdesc+"&a="+pimg+"&b="+pdue, true);
        xhttp.send();
        }
      }

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

    </script>
</body>
</html>
