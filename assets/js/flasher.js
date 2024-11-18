

const flashCRUD = document.getElementById("flash-crud");
if (flashCRUD != null) {
  const Title = flashCRUD.getAttribute("data-title");
  const Text = flashCRUD.getAttribute("data-text");
  const Icon = flashCRUD.getAttribute("data-icon");

  let text = Text.replace(/-/g, " ");
  
  Swal.fire({
    icon: Icon,
    text : text,
    title: Title
  });
}


const btnHapus = document.querySelectorAll(".btn-hapus");
if(btnHapus != null){
  btnHapus.forEach(function(el){
    el.addEventListener("click", function(e){
        e.preventDefault();
        const url = el.getAttribute("href");
        Swal.fire({
        title: 'Kamu yakin??',
        text: "Data ini akan terhapus!!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya Hapus ini'
      }).then((result) => {
        if (result.isConfirmed) {
          document.location.href = url;
        }
      })
     });
  });
}