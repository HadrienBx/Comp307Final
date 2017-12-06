<script>
function displayProjects(){ //draws the grid
        var pname1=this.id;
        var a = parseInt(pname1);
        var b = "<?php echo $_SESSION['username'] ?>";     //b = username
        var xhttp;
        xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            // up to here
            var project = document.getElementById("viewdiv");
            var node = document.createElement("div");
            node.innerHTML = "Test";
            project.appendChild(node);
          }
        }
        xhttp.open("GET", "deleteProj.php?a="+a+"&b="+b, true);
        xhttp.send();
      }
      </script>