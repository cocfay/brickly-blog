/* console.log(window.navigator.language) */

//Servicio obtenido de IPDATA

const ipInfo = async() =>{
    const respuesta = await fetch('http://dev.mydesk.digital/CheckListToys/site/getdataloc')
    const resJson = await respuesta.json()
    //console.log('Respuesta ip', resJson.language.LanguageCode);
    language(resJson.language.LanguageCode);
}

const language = async(lang) => {
    const CLT = window.location.href.split("/")
    const textsToChange = document.querySelectorAll('[data-section]')

    const file = await fetch(window.location.origin+'/'+CLT[3]+'/lang/'+lang+'.json')
    const result = await file.json()
    /* console.log(result) */

    for(const textToChange of textsToChange){
        /* console.log(textToChange) */
        const section = textToChange.dataset.section
        const value =   textToChange.dataset.value
        /* console.log(section)
        console.log("#######################")
        console.log(value)
        console.log("+++++++++++++++++++++++++++")*/
        //console.log(result[section][value])
        textToChange.placeholder = result[section][value]
        textToChange.innerHTML = result[section][value]
    } 
}

ipInfo()
