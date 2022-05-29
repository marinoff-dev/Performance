function myFunction() {
    var x = document.getElementById("mySidebar");
    if (x.className === "sidebar") {
      x.className += " responsive";
    } else {
      x.className = "sidebar";
    }
  } 