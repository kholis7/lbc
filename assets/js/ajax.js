
const btnEdits = document.querySelectorAll(".btn-edit");
const kode = document.getElementById("EditKode");
const keterangan = document.getElementById("EditKeterangan");
const tanggal = document.getElementById("EditTanggal");
const jumlah = document.getElementById("EditJumlah");
const listIdKategori = document.querySelectorAll('.EditIdKategori');


btnEdits.forEach(function(e){
  e.addEventListener("click", function(el){
    const href = e.getAttribute("data-href");
   
    const xhr = new XMLHttpRequest();
    
    xhr.onload = function(){
      if (xhr.status == 200) {
        const data = JSON.parse(xhr.responseText);
        kode.value = data.kode;
        keterangan.value = data.keterangan;
        tanggal.value = data.tanggal;
        jumlah.value = data.jumlah;
        listIdKategori.forEach((e) => {
          if(e.value == data.id_kategori) {
            e.setAttribute("selected", "");
          } else {
            e.removeAttribute("selected");
          }
        })
      } else{
        alert("gagal");
      }
    }
    
    xhr.open("GET", href, true );
    xhr.send();
    
  });
});

