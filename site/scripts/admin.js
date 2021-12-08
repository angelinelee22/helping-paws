// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
// var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// // When the user clicks on the button, open the modal
// btn.onclick = function() {
//   modal.style.display = "block";
// }


$(document).ready(function(){
  $("#dog-table tr:not(:first)").click(function(){
      $(this).addClass('selected').siblings().removeClass('selected');   
  })
});
