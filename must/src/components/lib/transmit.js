function loadXMLDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("haha").innerHTML =
        this.responseText;
      }
    };
    xhttp.open("GET", "./nantest.php", true);
    xhttp.send();
  }
