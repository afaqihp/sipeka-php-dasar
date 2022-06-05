//Ambil elemen"
var keyword = document.getElementById("keyword");
var search = document.getElementById("search");
var tableClinic = document.getElementById("table-clinic");

//Event
keyword.addEventListener("keyup", function () {
  //Buat objek ajax
  var xhr = new XMLHttpRequest();

  //Cek kesiapan ajax
  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      tableClinic.innerHTML = xhr.responseText;
    }
  };
  //eksekusi ajax
  xhr.open("GET", "./klinik_ajax.php?keyword=" + keyword.value, true);
  xhr.send();
});
