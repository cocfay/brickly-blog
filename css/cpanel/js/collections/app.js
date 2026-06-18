/* const sesion = 0 */

addEventListener('DOMContentLoaded', () => {
    const sesion = document.querySelector('[name=isActive]').value
    const check = document.querySelectorAll('.checkboxAcesoriosFigura [type=checkbox]')
    check.forEach(e => {
        if(sesion!=1){
            e.addEventListener('click', function(event){
                event.preventDefault()
            })
            e.setAttribute('data-bs-toggle', 'modal')
            e.setAttribute('data-bs-target', '#exampleModal')
        }
    })
})