<?php
// Initialize the session
session_start();
// access DB through $link
require_once 'db.php';
// If session variable is not set it will redirect to login page
if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: index.php");
  exit;
}
if(!isset($_SESSION['pid']) || empty($_SESSION['pid'])){
  header("location: index.php");
  exit;
}
//get user and pid
$user= $_SESSION['user'];
$user= $_SESSION['pid'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--BootStrap-->
    <title>WOOBS Editor</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <style>
    button{
      text-align: center;
      background-color: white;
      color: black;
      font-weight: bold;
    }
    body{
      font: 14px sans-serif;
      text-align: center;
      width: 100%;
    }
    .roww {
      height: 32px;
      margin-top: 32px;
      float: left;
      width: 100%;
      text-align: center;
    }
    .task {
      float: left;
      text-align: center;
    }
    .dispT {
      position: relative;
      width: 100%;
      height: 475px;
      padding-left: 10px;
      border:1px solid #000000;
      text-align: center;
      padding-top: 50px;
      display: inline-block;
      border: 1px solid #dfecdf;
      border-radius: 4px;
      box-sizing: border-box;
      background-color:	#dfecdf;
      color: #383838;
    }
    .dispT:hover {
      background-color: #c4cec4;
      box-shadow: 0 0 6px rgba(35,173,278,1);
    }
    .btn{
      margin-bottom:5px;
      align: center;
    }
    #editTButt{
      margin-top:20px;
    }
    #tree {

    }
    #canvas-wrap {
      position:relative;
      width: 100%;
      height:100%;
    }
    #canvas-wrap canvas {
      position:absolute;
      width: 100%;
      height: auto;
      top:0;
      left:0;
      border:1px solid #000000;
    }
    #content0 {
      margin-top: 25px;
      margin-left: 0;
      padding-left:0;
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
    input[type=number], select{
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
    </style>
</head>
<body onresize="<script>location.reload();</script>">
  <!--Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">WOOBS Pro</a> 
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

    <!--Main-->
    <main role="main" class="container-fluid" id="content0">
      <div class="row" style="height: 800px">
        <div class="col-sm-9 col-md-9">
          <div id="canvas-wrap">
              <canvas id="myCanvas"></canvas>
              <div id="tree"></div>
          </div>
        </div>




  <aside class="col-sm-3 col-md-3">
  <div id="displayTask" class="dispT">
    <div id="taskInfo" style="display:block">
      <div id="name" class="lead"><br />Name: </div>
      <div id="desc" class="lead"><br />Description: </div>
      <div id="dueD" class="lead"><br />Due Date: </div>
      <div id="prog" class="lead"><br />Progress: </div>
    </div>
    <!--
    <div id="taskForm" style="display:none">
      <form name="taskEditForm" action="" onsubmit="return taskFormSend()">
        Task Name: <input type="text" name="nameF"><br />
        Description: <input type="text" name="descriptionF"><br />
        <div id="curD"></div>
        Due Date: <input type="date" name="dueDateF"><br />
        Progress: <input type="number" name="progF"><br />
        <input type="submit" name="Submit"><br />
      </form>
    </div>
    -->
    
    <!--<div id="addTaskForm" style="display:none">
      <form name="addTaskFormF" action="" onsubmit="return addTaskFormSend()">
        Task Name: <input type="text" name="nameF"><br />
        <input type="submit" name="Submit"><br />
      </form>
    </div>-->
    <div id="taskCancel" style="display:none">
      <br />
      <button id="editCancel" onclick="editCancelFunc()">Cancel</button>
    </div>
    <div id="editTask" style="display:block">
      <br />
      <button class="btn btn-success " id="editTButt" data-toggle="modal" data-target="#editTaskMod">Edit Task</button>
      <!--<button class="btn btn-success btn-sm" id="editTButt" onclick="editTaskFunc()">Edit Task</button>-->
    </div>
    <div id="addChild" style="display:block">
      <button class="btn btn-success "id="addChildButt" data-toggle="modal" data-target="#addChildMod">Add Child</button>
      <!--<button class="btn btn-success btn-sm"id="addChildButt" onclick="addChildFunc()">Add Child</button>-->
    </div>
    <div id="delTask" style="display:block">
      <button class="btn btn-success " id="delTaskB" data-toggle="modal" data-target="#deleteTaskModal">Delete Task</button>
      <!--<button class="btn btn-success " id="delTaskB" onclick="delTaskFunc()">Delete Task</button>-->
    </div>
  </div>
</aside>

  </div>
</main>



<!--Add Child Modal-->
<div class="modal fade" id="addChildMod">
    <div class="modal-dialog">
        <div class="modal-content p-3 mb-2 bg-light text-dark">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Add Child Node!</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form name="addTaskFormF" action="" onsubmit="return addTaskFormSend()">
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Task Name</h4>
              <input type="text" placeholder="What do you want to accomplish next?" name="nameF"><br/>
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

<!--Edit Task Modal-->

<div class="modal fade" id="editTaskMod">
    <div class="modal-dialog">
        <div class="modal-content p-3 mb-2 bg-light text-dark">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Edit Task!</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <form name="taskEditForm" action="" onsubmit="return taskFormSend()">
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Task Name</h4>
              <input type="text" name="nameF"><br />
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Description</h4>
              <input type="text" name="descriptionF"><br />
              <div id="curD"></div>
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Due Date</h4>
              <input type="date" name="dueDateF"><br />
              <h4 class="display-7" style="text-align:center;margin-top:20px;">Progress (zero to a hunnid)</h4>
              <input type="number" name="progF"><br />
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

<!--Delete Task Modal-->
<div class="modal fade" id="deleteTaskModal">
    <div class="modal-dialog">
        <div class="modal-content p-3 mb-2 bg-light text-dark">
        
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Delete Task</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            
          <div id="delSingleTask" style="display:block">
            <button id="delSingleTaskB" class="btn btn-warning" onclick="delSingleTaskFunc()">Delete Single Task</button>
          </div>
          <div id="delAllTask" style="display:block">
            <button id="delAllTaskB" class="btn btn-danger" onclick="delAllTaskFunc()">Delete Sub-Tree</button>
          </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        
        </div>
    </div>
    </div>
<!--End Of Modal-->

  <script>



    //finds absolute position of object > used to draw lines
    function findPos(obj) {
      var curLeft = curTop = 0;
      if (obj.offsetParent) {
        do {
          curLeft += obj.offsetLeft;
          curTop += obj.offsetTop;
        } while (obj = obj.offsetParent);
      }
      return {x:curLeft, y:curTop};
    }

    //displays tree
    function displayTree(){
        //extract object
        var pid = "<?php echo $_SESSION['pid'] ?>";
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {

            var obj = JSON.parse(this.responseText);
            //calculate width % of each node
            //calculate #children for each node
            var allChi = [];

            //initialize allChi to 0
            var i = 0;
            while (obj[i] != null){
                allChi[obj[i].t_id] = 0;
              i++;
            }

            //add +1 of allChi each time a task is a child of that node
            i=0;
            while (obj[i] != null){
                allChi[obj[i].parent_id] += 1;
              i++;
            }

            //calculate width of each node according to # of siblings and width of parent
            //initialize to 0
            i=0;
            var allWidth = [];
            while (obj[i] != null){
                allWidth[obj[i].t_id] = 0;
              i++;
            }
            i=1;
            allWidth[obj[0].t_id] = 100;
            while (obj[i] != null){
              allWidth[obj[i].t_id] = allWidth[obj[i].parent_id] / allChi[obj[i].parent_id];
              i++;
            }

            //initialize absolute_left_position of div containing each node
            i=0;
            var absL = [];
            while (obj[i] != null){
                absL[obj[i].t_id] = 0;
              i++;
            }
            //absL[0] = 15;

            //find width of canvas
            var element = document.getElementById("myCanvas");
            var propertiess = window.getComputedStyle(element, null);
            var widthCa = parseFloat(propertiess.width);
            console.log(widthCa);
            document.getElementById('myCanvas').setAttribute("width", widthCa);
            document.getElementById('myCanvas').setAttribute("height",widthCa);
            // var x = document.getElementById("myCanvas");
            // x.style.width = 'widthCa';
            // x.style.height = 'widthCa';


            var offLCa = findPos(document.getElementById("myCanvas"))
            console.log(offLCa);


            //dynamically display tree
            var tree = document.getElementById("tree");
            var prevDepth = 0;
            i= 0;
            //a level is row (depth = x)
            var level = document.createElement("div");
            level.className = "roww";
            level.style.width = '100%';
            //element.style.property = new style
            while (obj[i] != null){
              if (obj[i].depth > prevDepth){  //if new row, appen previous level to tree and create a new one
                tree.appendChild(level);
                prevDepth = obj[i].depth;
                var level = document.createElement("div");
                level.className = "roww";
                level.style.width = '100%';
              }
              //node is div representing a task, containing the button
              var node = document.createElement("div");
              node.className = "task";
              //set width of node according to precalculated width
              node.style.width = allWidth[obj[i].t_id] + "%";
              node.style.position= "absolute";
              if (i != 0){
                absL[obj[i].t_id] = absL[obj[i].parent_id];
                absL[obj[i].parent_id] += allWidth[obj[i].t_id] * (widthCa/100);
              }
              node.style.left= absL[obj[i].t_id] + "px";
              //butt is the button element that adds functionality to the task
              var butt = document.createElement("button");
              butt.innerHTML = obj[i].t_name;
              butt.className = "taskbutton";
              //set button id to t_id to locate later on
              butt.id= obj[i].t_id;
              node.appendChild(butt);
              butt.onclick = showTask;
              level.appendChild(node);
              i++;
            }
            tree.appendChild(level);

            //draw lines using Canvas
            i = 0;
            var posT = [];  //Top position
            var posB = [];  //Bottom position

            //initialize to 0
            while (obj[i] != null){
                posT[obj[i].t_id] = 0;
              i++;
            }
            i=0;
            while (obj[i] != null){
                posB[obj[i].t_id] = 0;
              i++;
            }


            //set top and bottom position of each button(task) using findPos function which returns [x,y] coordinates
            i=0;
            while (obj[i] != null){
              posT[obj[i].t_id] = findPos(document.getElementById(obj[i].t_id));
              posB[obj[i].t_id] = findPos(document.getElementById(obj[i].t_id));
              //we have not set the width of the button (only the div it is in) and therefore must extract it as such
              var elem = document.getElementById(obj[i].t_id);
              var properties = window.getComputedStyle(elem, null);
              var width1 = parseFloat(properties.width);
              //now we add half of the width to the x-coordinates
              console.log(posT[obj[i].t_id].x);
              console.log(posT[obj[i].t_id].y);
              console.log(width1/2);
              posT[obj[i].t_id].x += (width1/2);
              posT[obj[i].t_id].y -= 86;
              posB[obj[i].t_id].x += (width1/2);
              posB[obj[i].t_id].y += -63;
              i++;
            }

            //now we use canvas to draw all the lines using the top and bottom positions
            i= 1;
            while (obj[i] != null){
              var canvas = document.getElementById("myCanvas");
              var ctx = canvas.getContext("2d");
              ctx.moveTo(posB[obj[i].parent_id].x,posB[obj[i].parent_id].y);
              ctx.lineTo(posT[obj[i].t_id].x ,posT[obj[i].t_id].y);
              ctx.stroke();
              i++;
            }
          }
        }
        xhttp.open("GET", "displayTree.php?q="+pid, true);
        xhttp.send();
        //for testing purposes
        // var dem = document.getElementById("demo");
        // var elem = document.getElementById(obj[i].t_id);
        // var properties = window.getComputedStyle(elem, null);
        // var width1 = properties.width;
        // var width2 = parseFloat(width1)/2;
        // dem.innerHTML = width2;
    }
    displayTree();

    //display task when clicked on
    //current variables
    var p_idC;
    var t_idC;
    var parent_idC;
    var depthC;
    var nameC;
    var descriptionC;
    var dueDateC;
    var progC;
    var widthC;
    function showTask() {
        t_idC= this.id;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            p_idC = obj[0];
            parent_idC= obj[2];
            widthC = obj[4];
            depthC = parseInt(obj[3]);
            var temp = document.getElementById("name");
            temp.innerHTML = "<br />Name: " + obj[5];
            nameC = obj[5];
            var temp = document.getElementById("desc");
            temp.innerHTML = "<br />Description: " + obj[6];
            descriptionC = obj[6];
            var temp = document.getElementById("dueD");
            temp.innerHTML = "<br />Due Date: " + obj[7];
            dueDateC = obj[7];
            var temp = document.getElementById("prog");
            temp.innerHTML = "<br />Progress: " + obj[8] + "<br />";
            progC = obj[8];
            var x = document.getElementById("taskForm");
            x.style.display = "none";
            var x = document.getElementById("taskCancel");
            x.style.display = "none";
            var x = document.getElementById("taskInfo");
            x.style.display = "block";
            var x = document.getElementById("editTask");
            x.style.display = "block";
            var x = document.getElementById("addChild");
            x.style.display = "block";
            var x = document.getElementById("addTaskForm");
            x.style.display = "none";
            var x = document.getElementById("delTask");
            x.style.display = "block";
            var x = document.getElementById("delSingleTask");
            x.style.display = "none";
            var x = document.getElementById("delAllTask");
            x.style.display = "none";

          }
        }
        xhttp.open("GET", "displayTask.php?q="+this.id, true);
        xhttp.send();
    }

    function editTaskFunc() {
      var x = document.getElementById("taskForm");
      x.style.display = "block";
      var x = document.getElementById("taskCancel");
      x.style.display = "block";
      var x = document.getElementById("taskInfo");
      x.style.display = "none";
      var x = document.getElementById("editTask");
      x.style.display = "none";
      var x = document.getElementById("addChild");
      x.style.display = "none";
      var x = document.getElementById("addTaskForm");
      x.style.display = "none";
      document.forms["taskEditForm"]["nameF"].placeholder = nameC;
      document.forms["taskEditForm"]["descriptionF"].placeholder = descriptionC;
      var x = document.getElementById("curD");
      x.innerHTML = "Current Due Date: " + dueDateC;
      //document.forms["taskEditForm"]["dueDateF"].placeholder = dueDateC;
      document.forms["taskEditForm"]["progF"].placeholder = progC;
    }

    function editCancelFunc() {
      var x = document.getElementById("taskForm");
      x.style.display = "none";
      var x = document.getElementById("taskCancel");
      x.style.display = "none";
      var x = document.getElementById("taskInfo");
      x.style.display = "block";
      var x = document.getElementById("editTask");
      x.style.display = "block";
      var x = document.getElementById("addChild");
      x.style.display = "block";
      var x = document.getElementById("addTaskForm");
      x.style.display = "none";
      var x = document.getElementById("delTask");
      x.style.display = "block";
      var x = document.getElementById("delSingleTask");
      x.style.display = "none";
      var x = document.getElementById("delAllTask");
      x.style.display = "none";
    }

    function taskFormSend() {
      var a = t_idC;
      var b = document.forms["taskEditForm"]["nameF"].value;
      var c = document.forms["taskEditForm"]["descriptionF"].value;
      var d = document.forms["taskEditForm"]["dueDateF"].value;
      var e = document.forms["taskEditForm"]["progF"].value;
      var xhttp;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {

        }
      }
      xhttp.open("GET", "editTask.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e, true);
      xhttp.send();

    }

    function addChildFunc() {
      var x = document.getElementById("taskForm");
      x.style.display = "none";
      var x = document.getElementById("taskCancel");
      x.style.display = "block";
      var x = document.getElementById("taskInfo");
      x.style.display = "none";
      var x = document.getElementById("editTask");
      x.style.display = "none";
      var x = document.getElementById("addChild");
      x.style.display = "none";
      var x = document.getElementById("addTaskForm");
      x.style.display = "block";
    }

    function addTaskFormSend() {
      var a = p_idC;                //p_id of new node
      var b = t_idC;                //parent_id of new node = current t_id
      var c = depthC + 1;           //depth of new node
      var d = document.forms["addTaskFormF"]["nameF"].value;
      var xhttp;
      xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          
        }
      }
      xhttp.open("GET", "addTaskTest.php?a="+a+"&b="+b+"&c="+c+"&d="+d, true);
      xhttp.send();
    }

    function delTaskFunc() {
      var x = document.getElementById("taskForm");
      x.style.display = "none";
      var x = document.getElementById("taskCancel");
      x.style.display = "block";
      var x = document.getElementById("taskInfo");
      x.style.display = "block";
      var x = document.getElementById("editTask");
      x.style.display = "none";
      var x = document.getElementById("addChild");
      x.style.display = "none";
      var x = document.getElementById("addTaskForm");
      x.style.display = "none";
      var x = document.getElementById("delTask");
      x.style.display = "none";
      var x = document.getElementById("delSingleTask");
      x.style.display = "block";
      var x = document.getElementById("delAllTask");
      x.style.display = "block";

    }

    function delSingleTaskFunc() {
      var x = document.getElementById("delSingleTask");
      x.style.display = "none";
      var x = document.getElementById("delAllTask");
      x.style.display = "none";
      var accept = confirm("Are you sure you want to delete this task? All of its children will be maintained.");
      if (accept == true) {
        var a = t_idC;
        var b = parent_idC;
        var c = depthC;
        var d = widthC;
        var e = p_idC;
        var f = 0;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            location.reload();
          }
        }
        xhttp.open("GET", "deleteTaskTest.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f, true);
        xhttp.send();
      }else{
        delTaskFunc();
      }

    }

    function delAllTaskFunc() {
      var x = document.getElementById("delSingleTask");
      x.style.display = "none";
      var x = document.getElementById("delAllTask");
      x.style.display = "none";
      var accept = confirm("Are you sure you want to delete the sub-tree rooted at this task? All of its children will NOT be maintained.");
      if (accept == true) {
        var a = t_idC;
        var b = parent_idC;
        var c = depthC;
        var d = widthC;
        var e = p_idC;
        var f = 1;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            location.reload();
          }
        }
        xhttp.open("GET", "deleteTaskTest.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f, true);
        xhttp.send();

      }else{
        delTaskFunc();
      }
    }

  </script>

</body>
</html>
