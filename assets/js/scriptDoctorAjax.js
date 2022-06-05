//Ambil elemen"
var keyword = document.getElementById("keyword");
var search = document.getElementById("search");
var tableDoctor = document.getElementById("table-doctor");

//Event
keyword.addEventListener("keyup", function () {
  //Buat objek ajax
  var xhr = new XMLHttpRequest();

  //Cek kesiapan ajax
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      tableDoctor.innerHTML = xhr.responseText;
    }
  };
  //Eksekusi ajax
  xhr.open("GET", "./doctor_ajax.php?keyword=" + keyword.value, true);
  xhr.send();
});
