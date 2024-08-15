
function viewBuyer(sid) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "view_buyer.php?bid=" + sid, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("modal-body").innerHTML = xhr.responseText;
            document.getElementById("myModal").style.display = "block";
        }
    };
  xhr.send();
  }
//Above is an Ajax code which will send bid to the php file, the content from view_buyer.php is now added to modal-body which will be displayed on the page...

function viewUser(){
  var xhr = newXMLHttpRequest();
  xhr.open("GET","seller_profile.php");
  xhr.onreadystatechange = function (){
    document.getElementById("modal-body").innerHTML = xhr.responseText;
    document.getElementById("userModal").style.display = "block";
  }
}

function closeModal() {
      document.getElementById("myModal").style.display = "none";
}

  window.onclick = function(event) {
      if (event.target == document.getElementById("myModal")) {
          closeModal();
      }
  }