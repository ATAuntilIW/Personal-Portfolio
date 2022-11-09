var elements = document.getElementsByClassName("column");

// Declare a loop variable
var i;


// Two images side by side
function two() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "50%";  // IE10
    elements[i].style.flex = "50%";
  }
}
//3 images side by side
function three() {
  for (i = 0; i < elements.length; i++) {
  elements[i].style.msFlex = "33%";  // IE10
  elements[i].style.flex = "33%";
}
}

// Four images side by side
function four() {
  for (i = 0; i < elements.length; i++) {
    elements[i].style.msFlex = "25%";  // IE10
    elements[i].style.flex = "25%";
  }
}

// Add active class to the current button (highlight it)
var header = document.getElementById("myHeader");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("activey");
    current[0].className = current[0].className.replace(" activey", "");
    this.className += " activey";
  });
}