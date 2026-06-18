//Servicio obtenido de IPDATA

var urllink = window.location.hostname == "dev.mydesk.digital" ? "https://dev.mydesk.digital/NewWeclickUp" : "https://www.weclickdigital.com/"

const ipInfo = async() =>{
    const respuesta = await fetch(urllink+'/home/getdataloc')
    const resJson = await respuesta.json()
    language(resJson.language.LanguageCode);
}

const language = async(lang) => {
    if(lang != 'es'){
        
        //const CLT = window.location.href.split("/")
        const textsToChange = document.querySelectorAll('[data-section]')

        const file = await fetch(urllink+'/lang/'+lang+'.json')
        const result = await file.json()
        //console.log(result);
        
        for(const textToChange of textsToChange){
            const section = textToChange.dataset.section
            const value = textToChange.dataset.value
            textToChange.placeholder = result[section][value]
            textToChange.innerHTML = result[section][value].replace(/\n/g, "<br>");
        } 
    }
}

ipInfo()
