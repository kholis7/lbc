const btnEdits = document.querySelectorAll(".btn-edit");
const id = document.getElementById("id");
const username = document.getElementById("username");
const email = document.getElementById("email");
const level = document.getElementById("level");
const opt = document.getElementById("opt");


btnEdits.forEach(function(e){
  e.addEventListener("click", function(el){
    const href = e.getAttribute("data-href");
    const xhr = new XMLHttpRequest();
    xhr.onload = function(){
      if (xhr.status == 200) {
        const data = JSON.parse(xhr.responseText);
        id.value = data.id;
        username.value = data.username;
        email.value = data.email;
        opt.innerText = data.level;
        opt.value = data.level;
      } else{
        alert("gagal");
      }
    }
    
    xhr.open("GET", href, true );
    xhr.send();
    
  });
});

