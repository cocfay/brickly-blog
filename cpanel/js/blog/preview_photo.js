//FUNCION DE LA IMAGEN DE PORTADA

function file_position_photo(file_photo){
 
  document.querySelector("#"+file_photo.id).addEventListener("change",function(e){
   if(e.target.files.length == 0){
     return;
   }
   let file = e.target.files[0];
   let url = URL.createObjectURL(file);
   console.log(file_photo.id)
   document.querySelector("#"+file_photo.id+"-preview div").innerText = file.name;
   document.querySelector("#"+file_photo.id+"-preview img").src = url;
 }); 
 
}