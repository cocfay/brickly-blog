const menutrigger = document.querySelector('.menutrigger')
const closeMenu = document.querySelector(".closeMenu")
const menuLateral = document.querySelector("div.sidebar")
const body = document.querySelector('body')

function menu(){
    if(window.innerWidth <= '956'){
        menuLateral.classList.add('hidemenu')
        menuLateral.style.transform = 'translateX(-270px)';
        if(document.querySelector('.overlay') != null)
            document.querySelector('.overlay').remove()
    }else{
        menuLateral.classList.remove('hidemenu')
        menuLateral.style.transform = 'translateX(0)'; 
        if(document.querySelector('.overlay') != null)
            document.querySelector('.overlay').remove()
    }
}

function OpenCloseMenu(){
    if(menuLateral.classList.contains('hidemenu')){
        menuLateral.classList.remove('hidemenu')
        menuLateral.style.transform = 'translateX(0)';
        const div = '<div class="overlay"></div>'
        body.insertAdjacentHTML('afterbegin', div)
        body.style.overflow = 'hidden'
    }else{
        menuLateral.classList.add('hidemenu')
        menuLateral.style.transform = 'translateX(-270px)';
        document.querySelector('.overlay').remove()
        body.style.overflow = 'unset'
    }
}

document.addEventListener('click', (e) =>{
    if(window.innerWidth <= '956'){
        if(!menuLateral.contains(e.target) && !menutrigger.contains(e.target)){
            menuLateral.classList.add('hidemenu')
            menuLateral.style.transform = 'translateX(-270px)';
            document.querySelector('.overlay').remove()
            body.style.overflow = 'unset'
        }
    }
})

window.addEventListener('resize', menu)
window.addEventListener('load', menu)
menutrigger.addEventListener('click', OpenCloseMenu)
closeMenu.addEventListener('click', OpenCloseMenu)