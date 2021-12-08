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

function submitDogs() {
  var elements=document.getElementsByClassName('selected'); 
  var id = elements[0].cells[7].innerHTML;
  // alert(id);
  document.getElementsByClassName('search-id')[0].setAttribute('value', id);
  document.getElementById('dog-form').submit();
  return true;
}


$(document).ready(function(){
  $("#dog-table tr:not(:first)").click(function(){
      $(this).addClass('selected').siblings().removeClass('selected'); 
      submitDogs();
  })
});

function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// function showUser(str) {
//   if (str=="") {
//     document.getElementById("txtHint").innerHTML="";
//     return;
//   }
//   var xmlhttp=new XMLHttpRequest();
//   xmlhttp.onreadystatechange=function() {
//     if (this.readyState==4 && this.status==200) {
//       document.getElementById("txtHint").innerHTML=this.responseText;
//     }
//   }
//   xmlhttp.open("GET","getuser.php?q="+str,true);
//   xmlhttp.send();
// }