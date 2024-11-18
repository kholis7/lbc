
function preview(){
  const fotoProfile = document.getElementById("foto_profile");
  const imgPreview = document.getElementById("img_preview");
  
  const fileFoto = new FileReader();
  fileFoto.readAsDataURL(fotoProfile.files[0]);
  
  fileFoto.onload = function(e){
    imgPreview.src = e.target.result;
  };

}

function preview_edit(){
  const fotoProfile = document.getElementById("foto_profile_2");
  const imgPreview = document.getElementById("img_preview_2");
  
  const fileFoto = new FileReader();
  fileFoto.readAsDataURL(fotoProfile.files[0]);
  
  fileFoto.onload = function(e){
    imgPreview.src = e.target.result;
  };

}

function preview_profile(){
  const fotoProfile = document.getElementById("foto_profile_3");
  const imgPreview = document.getElementById("img_preview_3");
  const btnUpload = document.getElementById("btn_ubah_profile");
  
  const fileFoto = new FileReader();
  fileFoto.readAsDataURL(fotoProfile.files[0]);
  
  fileFoto.onload = function(e){
    imgPreview.src = e.target.result;
    btnUpload.classList.replace("btn-primary", "btn-success");
  };
  
}