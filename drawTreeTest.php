<?php
//require_once 'db.php';
//assume have p_id == 1 for testing
//my project w/ p_id=1 in tasks looks as such
//          root
//       /     \          \
//  chi1.0    chi1.1     chi1.2
//     /        /   \
//  chi 2.0  chi2.1  chi2.2
//$pid = 1;
//$sql= "SELECT * FROM tasks WHERE p_id ='$pid' ORDER BY depth, width";
//$result = mysqli_query($link, $sql);
//$tasks = mysqli_fetch_all($result,MYSQLI_ASSOC);
//$WBStasks = json_encode($tasks);
//echo $WBStasks;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{
          font: 14px sans-serif;
          text-align: center;
          width: 100%;
        }
        div{

        }
        .row {
          height: 32px;
          margin-top: 32px;
          float: left;
          width: 100%;
        }
        .task {
          float: left;

        }
        .dispT {
          position: absolute;
          top: 0px;
          left: 1005px;
          width: 250px;
          height: 300px;
          padding-left: 10px;
          border:1px solid #000000;
          text-align: left;
        }
        #canvas-wrap {
          position:relative;
          width:1000px;
          height:800px;
        }
        #canvas-wrap canvas {
          position:absolute;
          top:0;
          left:0;
          z-index: -1;
          border:1px solid #000000;
        }
    </style>
</head>
<body>

  <div id="canvas-wrap">
  <canvas id="myCanvas"  width="1000px" height="800px"></canvas>
  <div id="tree"></div>
  </div>
  <div id="displayTask" class="dispT">
    <div id="taskInfo" style="display:block">
      <div id="name"><br />Name: </div>
      <div id="desc"><br />Description: </div>
      <div id="dueD"><br />Due Date: </div>
      <div id="prog"><br />Progress: </div>
    </div>
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
    <div id="addTaskForm" style="display:none">
      <form name="addTaskFormF" action="" onsubmit="return addTaskFormSend()">
        Task Name: <input type="text" name="nameF"><br />
        <input type="submit" name="Submit"><br />
      </form>
    </div>
    <div id="taskCancel" style="display:none">
      <br />
      <button id="editCancel" onclick="editCancelFunc()">Cancel</button>
    </div>
    <div id="editTask" style="display:none">
      <br />
      <button id="editTButt" onclick="editTaskFunc()">Edit Task</button>
    </div>
    <div id="addChild" style="display:none">
      <button id="addChildButt" onclick="addChildFunc()">Add Child</button>
    </div>
  </div>
  <div id="demo">

  </div>


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
        var projID= 1;
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

            //dynamically display tree
            var tree = document.getElementById("tree");
            var prevDepth = 0;
            i= 0;
            //a level is row (depth = x)
            var level = document.createElement("div");
            level.className = "row";
            level.style.width = '100%';
            //element.style.property = new style
            while (obj[i] != null){
              if (obj[i].depth > prevDepth){  //if new row, appen previous level to tree and create a new one
                tree.appendChild(level);
                prevDepth = obj[i].depth;
                var level = document.createElement("div");
                level.className = "row";
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
                absL[obj[i].parent_id] += allWidth[obj[i].t_id] * 10;
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
              posT[obj[i].t_id].x += width1 / 2;
              posT[obj[i].t_id].y -= 2;
              posB[obj[i].t_id].x += width1 / 2;
              posB[obj[i].t_id].y += 21;
              i++;
            }

            //now we use canvas to draw all the lines using the top and bottom positions
            i= 1;
            while (obj[i] != null){
              var canvas = document.getElementById("myCanvas");
              var ctx = canvas.getContext("2d");
              ctx.moveTo(posB[obj[i].parent_id].x,posB[obj[i].parent_id].y);
              ctx.lineTo(posT[obj[i].t_id].x,posT[obj[i].t_id].y);
              ctx.stroke();
              i++;
            }
          }
        }
        xhttp.open("GET", "displayTree.php?q="+projID, true);
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
    function showTask() {
        t_idC= this.id;
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            p_idC = obj[0];
            parent_idC= obj[2];
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
      xhttp.open("GET", "addTask.php?a="+a+"&b="+b+"&c="+c+"&d="+d, true);
      xhttp.send();
    }

  </script>

</body>
</html>
