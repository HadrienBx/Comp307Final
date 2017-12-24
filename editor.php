<?php
// Initialize the session launched by welcome.php
session_start();
// access DB through $link
require_once 'db.php';
// If session variables are not set it will redirect to login page
if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
  header("location: index.php");
  exit;
}
if(!isset($_SESSION['pid']) || empty($_SESSION['pid'])){
  header("location: index.php");
  exit;
}
//get username (unique and used to get key unique u_id) and p_id (unique project id)
$user= $_SESSION['user'];
$user= $_SESSION['pid'];
?>

<!-- HTML5 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!--BootStrap-->
    <title>WOOBS Editor</title>
    <!-- Link BOOTSTRAP CSS/JS  -->
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

<body>
    <!--Nav Bar-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">WOOBS Pro</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Home/Logout Button -->
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="welcome.php"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
          </li>
        </ul>
            <a class="nav-link" href="index.php"><i style="color: black" class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
      </div>
    </nav>
    <!--Main-->
    <main role="main" class="container-fluid" id="content0">
      <div class="row" style="height: 800px">
        <div class="col-sm-9 col-md-9">
          <!-- Tree Display -->
          <div id="canvas-wrap">
              <!-- Canvas used to draw lines connecting tasks-->
              <canvas id="myCanvas"></canvas>
              <!-- Tasks buttons are appended to tree div -->
              <div id="tree"></div>
          </div>
        </div>
        <!-- SideBar -->
        <aside class="col-sm-3 col-md-3">
          <div id="displayTask" class="dispT">
            <div id="taskInfo" style="display:block">
              <div id="name" class="lead"><br />Name: </div>
              <div id="desc" class="lead"><br />Description: </div>
              <div id="dueD" class="lead"><br />Due Date: </div>
              <div id="prog" class="lead"><br />Progress: </div>
            </div>
            <div id="taskCancel" style="display:none">
              <br />
              <button id="editCancel" onclick="editCancelFunc()">Cancel</button>
            </div>
            <div id="editTask" style="display:block">
              <br />
              <button class="btn btn-success " id="editTButt" data-toggle="modal" data-target="#editTaskMod">Edit Task</button>
            </div>
            <div id="addChild" style="display:block">
              <button class="btn btn-success "id="addChildButt" data-toggle="modal" data-target="#addChildMod">Add Child</button>
            </div>
            <div id="delTask" style="display:block">
              <button class="btn btn-success " id="delTaskB" data-toggle="modal" data-target="#deleteTaskModal">Delete Task</button>
            </div>
          </div>
        </aside>
      </div>
    </main>
    <!-- Modals to display forms -->
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

<!-- JAVASCRIPT -->
  <script>

    //finds absolute position of object, used to draw lines between tasks once they have been created and positioned
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

    //displays tree displays the entire tree upon reload
    function displayTree(){
        //extract projectID from php session variable
        var pid = "<?php echo $_SESSION['pid'] ?>";
        //Variables in database used to dynamically create tree
        //t_id = unique task id
        //parent_id = t_id of parent, 0 if task is root
        //depth = distance from root, root = 0
        //width = 0 for left most sibling, width = max(width of all siblings) for right most sibling
        //XML request to obtain all of the tasks associated with PID
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            //receive all tasks as obj[] ordered by increasing depth, width
            var obj = JSON.parse(this.responseText);
            //Now we calculate some values for each task that will help position them
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
            //calculate width of each node dividing width of parent by #of siblings
            //root task = 100% width
            //initialize to 0
            i=0;
            var allWidth = [];
            while (obj[i] != null){
                allWidth[obj[i].t_id] = 0;
              i++;
            }
            i=1;
            //initialize root node to 100% width
            allWidth[obj[0].t_id] = 100;
            while (obj[i] != null){
              allWidth[obj[i].t_id] = allWidth[obj[i].parent_id] / allChi[obj[i].parent_id];
              i++;
            }
            //calculate absolute_left_position of div containing each node
            //initialize to 0
            //this will be set in the coming while loop
            i=0;
            var absL = [];
            while (obj[i] != null){
                absL[obj[i].t_id] = 0;
              i++;
            }
            //calculate width of canvas for rendering and positioning purposes
            var element = document.getElementById("myCanvas");
            var propertiess = window.getComputedStyle(element, null);
            var widthCa = parseFloat(propertiess.width);
            //console.log(widthCa); //for testing purposes
            //set width and height of canvas to calculated width to enable accurate rendering
            document.getElementById('myCanvas').setAttribute("width", widthCa);
            document.getElementById('myCanvas').setAttribute("height",widthCa);
            //
            var offLCa = findPos(document.getElementById("myCanvas"))
            console.log(offLCa);
            //now we are ready to dynamically display the tree
            //obtain tree div that we will append to
            var tree = document.getElementById("tree");
            //initialize variable to keep track of depth of previously considered node so we know when to create a new level
            var prevDepth = 0;
            i= 0;
            //div containing a level of the tree (depth = x)
            //create first row
            var level = document.createElement("div");
            level.className = "roww";
            level.style.width = '100%';
            //loop through every task in project by depth,width starting with root
            while (obj[i] != null){
              //if new row, append previous row to tree
              if (obj[i].depth > prevDepth){
                tree.appendChild(level);
                //update previous depth
                prevDepth = obj[i].depth;
                //create new row
                var level = document.createElement("div");
                level.className = "roww";
                level.style.width = '100%';
              }
              //create div ('node') which will contain a task button
              var node = document.createElement("div");
              node.className = "task";
              //set width of node according to precalculated width
              node.style.width = allWidth[obj[i].t_id] + "%";
              node.style.position= "absolute";
              //calculate the absolute_left_position position of the node by setting it to that of its parent
              //then update the absolute_left_position of its parent to += width of current node * width of canvas / 100(because width is a %)
              //although this will not update the position of the parent as it has already been set, it will let the next right child of the parent position itself
              if (i != 0){
                absL[obj[i].t_id] = absL[obj[i].parent_id];
                absL[obj[i].parent_id] += allWidth[obj[i].t_id] * (widthCa/100);
              }
              node.style.left= absL[obj[i].t_id] + "px";
              //create button element that adds functionality to the task
              var butt = document.createElement("button");
              butt.innerHTML = obj[i].t_name;
              butt.className = "taskbutton";
              //set button id to unique t_id of task so that the id can be passed as 'this.id' to a function when button is clicked
              butt.id= obj[i].t_id;
              //append button to container node
              node.appendChild(butt);
              //add even which calls showTask function to button
              butt.onclick = showTask;
              //append node containing task to level div containing all tasks with depth=x
              level.appendChild(node);
              i++;
            }
            //append last level
            tree.appendChild(level);

            //now we draw lines connecting buttons using Canvas
            //we want to determine the center top and center bottom position for each button
            var posT = [];  //Top position
            var posB = [];  //Bottom position
            i = 0;
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
            //set top and bottom position of each button(task)
            //using findPos function which returns [x,y] coordinates of the top left corner of buttons
            //however this position is not exact when using bootstrap
            i=0;
            while (obj[i] != null){
              posT[obj[i].t_id] = findPos(document.getElementById(obj[i].t_id));
              posB[obj[i].t_id] = findPos(document.getElementById(obj[i].t_id));
              //now calculate width of button, used to find the center of button
              var elem = document.getElementById(obj[i].t_id);
              var properties = window.getComputedStyle(elem, null);
              var width1 = parseFloat(properties.width);
              //console.log(posT[obj[i].t_id].x);
              //console.log(posT[obj[i].t_id].y);
              //console.log(width1/2);
              //now we add half of the width to the x-coordinates
              //we also adjust the y-coordinate to have posB point to bottom, and to account for Bootstrap offsets
              posT[obj[i].t_id].x += (width1/2);
              posT[obj[i].t_id].y -= 86;
              posB[obj[i].t_id].x += (width1/2);
              posB[obj[i].t_id].y -= 63;
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
        //this sends the request for the tasks object to displayTree.php, sending the unique projectID
        xhttp.open("GET", "displayTree.php?q="+pid, true);
        xhttp.send();
    }
    //call function on load
    displayTree();

    //Initialize current variables to be set when clicking on task button and used for tree editing
    var p_idC;
    var t_idC;
    var parent_idC;
    var depthC;
    var nameC;
    var descriptionC;
    var dueDateC;
    var progC;
    var widthC;
    //diplays task info in side bar and sets task info to current vars, called when clicking a task button
    function showTask() {
        //button.id was set to unique taskID
        t_idC= this.id;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            //set current variables
            p_idC = obj[0];
            parent_idC= obj[2];
            widthC = obj[4];
            depthC = parseInt(obj[3]);
            //set innerHTML of display section of sidebar
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
          }
        }
        xhttp.open("GET", "displayTask.php?q="+this.id, true);
        xhttp.send();
    }
    //edit task form > XMLHTTP > editTask.php
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
    //add task form > XMLHTTP > addTask.php
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
      xhttp.open("GET", "addTask.php?a="+a+"&b="+b+"&c="+c+"&d="+d, true);
      xhttp.send();
    }
    //delete single task button > XMLHTTP > deleteTask.php
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
        xhttp.open("GET", "deleteTask.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f, true);
        xhttp.send();
      }else{
        delTaskFunc();
      }

    }
    //delete all task button > XMLHTTP > deleteTask.php
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
        xhttp.open("GET", "deleteTask.php?a="+a+"&b="+b+"&c="+c+"&d="+d+"&e="+e+"&f="+f, true);
        xhttp.send();

      }else{
        delTaskFunc();
      }
    }
  </script>
</body>
</html>
