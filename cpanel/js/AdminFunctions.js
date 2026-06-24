/* const ST = document.querySelectorAll('.selectorTheme img') 
const MenuImg = document.querySelector('.side-menu .logoMenu img')
 
  $('.select-theme-dark').click(function(e){
      setThemeMode('dark');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  })
  $('.select-theme-light').click(function(e){
      setThemeMode('light');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  });
  $('.select-theme-auto').click(function(e){
      setThemeMode('auto');
      ST.forEach(i => i.classList.remove('themeActive'))
      e.target.classList.add('themeActive')
  })

  let themeUse = window.localStorage.getItem('themeUse');
 
  if(themeUse){
    setThemeMode(themeUse);
  }else{
    setThemeMode('auto');
  } */

  /* function setThemeMode(theme){
    let iconS = $('#light-dark').find('i');
    switch(theme){
      case 'dark':
        document.querySelector('.select-theme-dark img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'dark');
        iconS.removeClass('fa-circle-half-stroke');
        iconS.removeClass('fa-sun');
        iconS.addClass('fa-moon');
        $('body').attr('data-bs-theme','dark');
        var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=dark;' + expires + ';path=/';
          
          MenuImg.src = 'https://www.weclickdigital.com/images/home/logo_white.png'
        break;
      case 'light':
        document.querySelector('.select-theme-light img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'light');
        iconS.removeClass('fa-circle-half-stroke');
        iconS.removeClass('fa-moon');
        iconS.addClass('fa-sun');
        $('body').attr('data-bs-theme','light');
        var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=light;' + expires + ';path=/';

          MenuImg.src = 'https://www.weclickdigital.com/images/logo.png'
        break;
      case 'auto':
        document.querySelector('.select-theme-auto img').classList.add('themeActive')
        window.localStorage.setItem('themeUse', 'auto');
        iconS.removeClass('fa-moon');
        iconS.removeClass('fa-sun');
        iconS.addClass('fa-circle-half-stroke');
         let dt = new Date();
        let isHour = dt.getHours();
        if(isHour < 17){
          $('body').attr('data-bs-theme','light');
          var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=light;' + expires + ';path=/';

          MenuImg.src = 'https://www.weclickdigital.com/images/logo.png'
        }else{
          $('body').attr('data-bs-theme','dark');
          var d = new Date();
          d.setTime(d.getTime() + (1*24*60*60*1000));
          var expires = 'expires='+ d.toUTCString();
          document.cookie = 'styleTheme=dark;' + expires + ';path=/';

          MenuImg.src = 'https://www.weclickdigital.com/images/home/logo_white.png'
        }
        break;
    }

  } */

  /* const themeClose = document.querySelector('.choosetheme-close')
  themeClose.addEventListener('click', () => {
    if(window.location.pathname.endsWith("home")){
      window.location.reload()
    }
  }) */

  $('.nav-item').click(function(e){
       if(!$(this).hasClass('show')){
          $('.nav-item').each((i,el)=>{
            $(el).removeClass('show');
            //console.log(el)
            $(el).find('.dropdown-menu').removeClass('show');
          })

          $(this).addClass('show');
          let subM = $(this).find('.dropdown-menu');
          if(subM.length > 0){
            subM.addClass('show');
          }
       }else{
        $('.nav-item').each((i,el)=>{
            $(el).removeClass('show');
            //console.log(el)
            $(el).find('.dropdown-menu').removeClass('show');
          })
       
       }
  });

  const sideMenu = document.querySelector('.side-menu')
  const navLinks = document.querySelectorAll('.side-menu-nav')

  document.addEventListener('DOMContentLoaded', function() {
    const isPinned = localStorage.getItem('sidebarPinned') === 'true'
    
    if(isPinned){
      //console.log('hola mundo');
      document.querySelector('.side-menu').classList.add('pin')
      document.querySelector('.main-content').classList.add('pin')
      document.querySelector('.pin-background i').classList.remove('fa-angle-right')
      document.querySelector('.pin-background i').classList.add('fa-angle-left')
      document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
        d.style.display = 'block'
      })
    }
  })
  
  document.querySelector('.pin-background i').classList.add('fa-angle-right')
  document.querySelector('.fixed-menu').addEventListener('click', () => {
      if(sideMenu.classList.contains('open')){
        sideMenu.classList.remove('open')
      }

      document.querySelector('.side-menu').classList.toggle('pin')
      document.querySelector('.main-content').classList.toggle('pin')

      if(document.querySelector('.side-menu').classList.contains('pin')){
        document.querySelector('.pin-background i').classList.remove('fa-angle-right')
        document.querySelector('.pin-background i').classList.add('fa-angle-left')
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'block'
        })
        localStorage.setItem('sidebarPinned', 'true')
        //console.log(localStorage.getItem('sidebarPinned'));
      }
      else{
        document.querySelector('.pin-background i').classList.remove('fa-angle-left')
        document.querySelector('.pin-background i').classList.add('fa-angle-right')
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'none'
        })
        localStorage.setItem('sidebarPinned', 'false')
          //console.log(localStorage.getItem('sidebarPinned'));
      }
  })

  document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
      d.style.display = 'none'
  })

  /* navLinks.forEach(i =>{
    i.addEventListener('mouseenter', () =>{
      if(!sideMenu.classList.contains('pin')){
        document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
          d.style.display = 'block'
        })
        sideMenu.classList.add('open')
      }
    })
    i.addEventListener('mouseout', (e) => {
      if(!i.contains(e.relatedTarget)) {
        if(!sideMenu.classList.contains('pin')){
          document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
            d.style.display = 'none'
          })
          sideMenu.classList.remove('open');
        }
      }
    })
  }); */

  sideMenu.addEventListener('mouseenter', () =>{
    if(!sideMenu.classList.contains('pin')){
      document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
        d.style.display = 'block'
      })
      sideMenu.classList.add('open')
    }  
  })

  sideMenu.addEventListener('mouseleave', (e) => {
    if(!sideMenu.classList.contains('pin')){
      document.querySelectorAll('ul.side-menu-nav .label-menu').forEach(d =>{
        d.style.display = 'none'
      })
      sideMenu.classList.remove('open');
    }
  })