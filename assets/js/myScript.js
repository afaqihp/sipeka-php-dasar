function openNav() {
  document.getElementById("my-side-menu").style.width = "20vw";
  document.getElementById("main").style.width = "80vw";
  document.getElementById("my-header").style.width = "80vw";
  document.getElementById("my-footer").style.width = "80vw";
}

function closeNav() {
  document.getElementById("my-side-menu").style.width = "0";
  document.getElementById("main").style.width = "100vw";
  document.getElementById("my-header").style.width = "100vw";
  document.getElementById("my-footer").style.width = "100vw";
}

function showError(message) {
  var messages = '<div class="alert"> <span class="closebtn" onclick="closeMessage();"> &times;</span> <strong>Danger!</strong>' + message + "</div>";
  document.getElementById("error-message").innerHTML = messages;
}

function closeMessage() {
  document.getElementById("error-message").innerHTML = "";
}

if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
