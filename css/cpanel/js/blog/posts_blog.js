function position_tp(e){
  let options
  let array_options = []
  if(e.value == 1){
    for(let i = 1 ; i <= 4 ; i++){
      number = `<option value="${i}">${i}</option>`
      array_options.push(number)
    }
  }else{
    for(let j = 3 ; j <= 6 ; j++){
      number = `<option value="${j}">${j}</option>`
      array_options.push(number)
    }
  }

  options = `
    <label for="" class="form-label" data-section="form-post" data-value="num-img">Número de imágenes:</label>
        <select class="form-select" name="top_select" onchange="selected_top(this);" id="">
          <option value="" data-section="form-post" data-value="selection">seleccione</option>
          ${array_options.join("")}
    </select>`

    document.querySelector(".select_1").innerHTML = options
}

function selected_top(e){
  let contenido = []
  let estructura 
  let numero 

 /*  ckeditor_photo(e.options[e.selectedIndex].value) */

  for(let i = 1 ; i<=e.options[e.selectedIndex].value ; i++){
    estructura = `
        <label for="titulo_top${i}" class="form-label" ><span data-section="form-post" data-value="t-post">Titulo de la imagen</span> ${i}</label>
        <input type="text" name="titulo_top${i}" class="form-control titulo_top" id="titulo_top${i}" aria-describedby="" required>
        <div class="imagen-top" style="margin-bottom:16px">
            <div class="grid-imagen-top">
                <div class="imagen-top-element">
                    <input type="file" id="file-top${i}" name="photo_top${i}" accept="image/*" onclick="file_position_photo(this)" required>
                    <label for="file-top${i}" id="file-top${i}-preview">
                    <img src="../images/upload-icon/upload-image.png" alt="">
                    <div style="cursor:pointer">
                        <span>+</span>
                    </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label for="" class="form-label"> <span data-section="form-post" data-value="desk-post">Descripción para escritorio imagen</span> ${i}</label>
          <textarea name="description_desktop${i}" class="description_desktop" id="editor${i}">
          </textarea>
          <input type="hidden" name="ckeditor_hidden_top${i}" value="">
        </div>
        <div class="mb-3" style="display:none">
            <label for="" class="form-label">Descripción para móvil imagen ${i}</label>
            <textarea name="description_movil${i}" id="" class="form-control description_movil${i}" rows="8"></textarea>
        </div>
        <hr>
    `
    numero = i
    contenido.push(estructura)
    show_photo_top(contenido)
  }
  ckditor_photo(numero)
}
function show_photo_top(content){
  document.querySelector('.collection_top').innerHTML = content.join("")
}

function position_bt(e){
  let options
  let array_options = []
  if(e.value == "1"){
    for(let i = 1 ; i <= 4 ; i++){
      number = `<option value="${i}">${i}</option>`
      array_options.push(number)
    }
  }else{
    for(let i = 3 ; i <= 6 ; i++){
      number = `<option value="${i}">${i}</option>`
      array_options.push(number)
    }
  }

  options = `
    <label for="" class="form-label" data-section="form-post" data-value="num-img">Número de imágenes:</label>
        <select class="form-select" name="bottom_select" onchange="selected_bottom(this);" id="">
          <option value="" data-section="form-post" data-value="selection">seleccione</option>
          ${array_options.join("")}
    </select>`

    document.querySelector(".select_2").innerHTML = options
}

function selected_bottom(e){
  let numero 
  let contenido = []
  let estructura 
  for(i = 1 ; i<=e.options[e.selectedIndex].value ; i++){
    estructura = `
        <label for="titulo_bottom${i}" class="form-label"><span data-section="form-post" data-value="t-post">Titulo de la imagen</span> ${i}</label>
        <input type="text" name="titulo_bottom${i}" class="form-control" id="titulo_bottom${i}" aria-describedby="" onkeyup="" required>
        <div class="imagen-top" style="margin-bottom:16px">
            <div class="grid-imagen-top">
                <div class="imagen-top-element">
                    <input type="file" id="file-bottom${i}" name="photo_bottom${i}" accept="image/*" onclick="file_position_photo(this)" required>
                    <label for="file-bottom${i}" id="file-bottom${i}-preview">
                    <img src="../images/upload-icon/upload-image.png" alt="">
                    <div style="cursor:pointer">
                        <span>+</span>
                    </div>
                    </label>
                </div>
            </div>
        </div>
        <div class="mb-3">
          <label for="" class="form-label"><span data-section="form-post" data-value="desk-post">Descripción para escritorio</span> ${i}</label>
          <textarea name="description_desktop_bottom${i}" class="description_desktop" id="editor_bottom${i}">
          </textarea>
          <input type="hidden" name="ckeditor_hidden_bt${i}" value="">
        </div>
        <div class="mb-3" style="display:none">
            <label for="" class="form-label">Descripción para móvil ${i}</label>
            <textarea name="description_movil_bottom${i}" id="" class="form-control description_movil_bottom${i}" rows="8"></textarea>
        </div>
      <hr>
    `
    numero = i
    contenido.push(estructura)
    show_photo_bottom(contenido)
  }
  ckditor_photo_bottom(numero)
}

function show_photo_bottom(content){
  document.querySelector('.collection_bottom').innerHTML = content.join("")
}


function removeTags(str) {
    if ((str===null) || (str===''))
        return false;
    else
        str = str.toString();
        
    // Regular expression to identify HTML tags in 
    // the input string. Replacing the identified 
    // HTML tag with a null string.
    const regex1 = /&nbsp;/ig;
    const regex2 = /&nbsp/ig;

    return str.replace( /(<([^>]+)>)/ig, '').replaceAll(regex1, '').replaceAll(regex2, '').trim();
}

let editor;
const des_movil = document.querySelector('.description_movil')
ClassicEditor.create( document.querySelector( '#editor' ), {
    language: 'es',
  }).then( editor => {
    editor.model.document.on( 'change:data', () => {
        let contentck = editor.getData()
        if(contentck != ""){
            console.log(contentck)
            des_movil.value = removeTags(contentck)
           /*  preview(editor.getData()) */
           document.querySelector("[name=ckeditor_hidden]").value = contentck
          }
        else{
            des_movil.value = ""
            /* preview("") */
            document.querySelector("[name=ckeditor_hidden]").value = ""
        }
    });
}).catch( error => {
    console.error( error );
});

function ckditor_photo(number){
  for(let i = 1 ; i<=number ; i++){
    const des_movil = document.querySelector('[name=description_movil'+i+']')
      ClassicEditor.create( document.querySelector( '#editor'+i ), {
          language: 'es',
        }).then( editor => {
          editor.model.document.on( 'change:data', () => {
              if(editor.getData() != ""){
                  des_movil.value = removeTags(editor.getData())
                  document.querySelector("[name=ckeditor_hidden_top"+i+"]").value = editor.getData()
                }
              else{
                  des_movil.value = ""
                  document.querySelector("[name=ckeditor_hidden_top"+i+"]").value = ""
              }
          });
      }).catch( error => {
          console.error( error );
      });
  }
}

/* #################################################################################### */

function ckditor_photo_bottom(number){
  for(let i = 1 ; i<=number ; i++){
    const des_movil = document.querySelector('[name=description_movil_bottom'+i+']')
    ClassicEditor.create( document.querySelector( '#editor_bottom'+i ), {
        language: 'es',
      }).then( editor => {
        editor.model.document.on( 'change:data', () => {
            if(editor.getData() != ""){
                des_movil.value = removeTags(editor.getData())
                document.querySelector("[name=ckeditor_hidden_bt"+i+"]").value = editor.getData()
              }
            else{
                des_movil.value = ""
                document.querySelector("[name=ckeditor_hidden_bt"+i+"]").value = ""
            }
        });
    }).catch( error => {
        console.error( error );
    });
  }
}

/* #################################################################################### */

const desktop = document.querySelector("#nav-home")
/* console.log(desktop) */

function preview(){
  let contenido = ""
  let array_contenido = []
  let contenido2 = ""
  let array_contenido2 = []
  let photo_cover = "upload-image.png"

  let lorem = '<p style="text-align:justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam justo urna, egestas quis tempus non, malesuada ac metus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.</p><p style="text-align:justify;">Pellentesque sollicitudin tincidunt felis vitae sollicitudin. Sed varius luctus eleifend. Integer leo elit, pharetra vitae sodales eu, accumsan id arcu. Quisque commodo tincidunt congue. Mauris eget dui eu arcu rutrum fermentum non nec dolor. Etiam ultrices interdum pretium. Aenean nunc ligula, luctus et tellus nec, sodales porttitor arcu.</p>'

  const title = document.querySelector('.title_post')
  const descrip = document.querySelector('.preview_escritorio__description')
  const top_img = document.querySelector('.top_imagenes')
  const bt_img = document.querySelector('.bt_imagenes')
  const position_top = document.querySelector('#blog-positiontop')
  const position_bt = document.querySelector('#blog-positiontop')
  const count_top = document.querySelector('[name=top_select]')
  const count_bt = document.querySelector('[name=bottom_select]')
  const img_cover = document.querySelector('#file-portada-preview img').src

  //document.querySelector(".preview_desktop").innerHTML = title+"<br>"+position_top+"<br>"+position_bt+"<br>"+"<br>"+"<br>"+img_cover

  /* console.log(img_cover.match(photo_cover)) */
  if(!img_cover.match(photo_cover))
    document.querySelector('.preview_escritorio__cover').innerHTML = `<img src="${document.querySelector('#file-portada-preview img').src}">` 

  if(position_top.value === "1" && position_top.checked!= false){
    for(let i = 1 ; i <= count_top.value ; i++ ){
      const img_tp = document.querySelector("#file-top"+i+"-preview img").src
      if(img_tp.match(photo_cover))
        imagen_top = ""
      else{
        imagen_top = `<div class="img_tp top_photo">
        <img src="${document.querySelector("#file-top"+i+"-preview img").src}" />
      </div>`
      }
      contenido = `
          <center class="justify-center">
            <div class="text_tp top_title" style="text-align:justify">
                ${document.querySelector('#titulo_top'+i).value}
            </div>
          </center>
            ${imagen_top}
          <center class="justify-center">
            <div class="desc_tp top_description" style="text-align:justify">
              ${document.querySelector("[name=ckeditor_hidden_top"+i+"]").value}
            </div>
          </center>
        `
      array_contenido.push(contenido)
    }
    top_img.innerHTML = array_contenido.join("")
  }
  if(position_bt.value === "1" && position_bt.checked!= false){
    for(let i = 1 ; i <= count_bt.value ; i++ ){
      const img_bt = document.querySelector("#file-bottom"+i+"-preview img").src
      if(img_bt.match(photo_cover))
        img_bottom = ""
      else{
        img_bottom = `<div class="img_tp top_photo">
        <img src="${document.querySelector("#file-bottom"+i+"-preview img").src}" />
      </div>`
      }
      contenido2 = `
          <center class="justify-center">
            <div class="text_tp top_title" style="text-align:justify">
              ${document.querySelector('#titulo_bottom'+i).value}
            </div>
          </center>
            ${img_bottom}
          <center class="justify-center">
            <div class="desc_tp top_description" style="text-align:justify">
              ${document.querySelector("[name=ckeditor_hidden_bt"+i+"]").value}
            </div>
          </center>
        `
      array_contenido2.push(contenido2)
    }
    bt_img.innerHTML = array_contenido2.join("") 
  }
 /*  console.log(position.value+" "+count.value ) */

  document.querySelector('.preview_escritorio__title').innerHTML = title.value

  if(document.querySelector("[name=ckeditor_hidden]").value != "")
    descrip.innerHTML = lorem
  else
    descrip.innerHTML = ""
}
