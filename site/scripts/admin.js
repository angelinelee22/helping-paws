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

function submitHiddenID() {
  var elements=document.getElementsByClassName('selected'); 
  var id = elements[0].cells[0].innerHTML;
  // alert(id);
  document.getElementsByClassName('search-id')[0].setAttribute('value', id);
  document.getElementById('selectable-form').submit();
  return true;
}

$(document).ready(function(){
  $("#selectable-table tr:not(:first)").click(function(){
      $(this).addClass('selected').siblings().removeClass('selected'); 
      submitHiddenID();
  })
});
