/* ANIMACION DE CAMBIO DE LETRA */

const words = document.querySelectorAll('.word');
words.forEach(i => {
    if(i !== null){
        let currentIndex = 0;
    
        // Inicializar correctamente las palabras para evitar comportamiento errático
        words.forEach((word, index) => {
            if (index === 0) {
                word.classList.add('current');
            } else {
                word.classList.add('enter');
            }
        });
    
        function changeWord() {
            const currentWord = words[currentIndex];
            const nextIndex = (currentIndex + 1) % words.length;
            const nextWord = words[nextIndex];
    
            // Animar la palabra actual hacia la derecha y desvanecerla
            currentWord.classList.remove('current');
            currentWord.classList.add('exit');
    
            // Preparar la próxima palabra para entrar desde la izquierda
            nextWord.classList.remove('enter');
            nextWord.classList.add('current');
    
            // Reiniciar la posición de la palabra actual después de su animación
            setTimeout(() => {
                currentWord.classList.remove('exit');
                currentWord.classList.add('enter');
            }, 500); // Tiempo sincronizado con la transición en CSS
    
            currentIndex = nextIndex;
        }
    
        // Ejecutar la animación cada 2 segundos
        setInterval(changeWord, 2000);
    }
})

/* ANIMACION DE CORTINA */

// Configuración del Intersection Observer
const options = {
    root: null, // Viewport actual
    threshold: 1.0 // Activar cuando el texto esté completamente visible
};

const callback = (entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        }
    });
};

const observer = new IntersectionObserver(callback, options);




// Seleccionar todos los contenedores de texto
const textContainers = document.querySelectorAll('.animation-curtain');
textContainers.forEach(container => observer.observe(container));

// Configuración del Intersection Observer
const options2 = {
    root: null, // Viewport actual
    threshold: 0.3 // Activar cuando el texto esté completamente visible
};

const callback2 = (entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        }
    });
};

const observer2 = new IntersectionObserver(callback2, options2);




// Seleccionar todos los contenedores de texto
const textContainers2 = document.querySelectorAll('.animation-cur-card');
textContainers2.forEach(container => observer2.observe(container));


/* STICKY CARD SCROLL */

document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll(".sticky");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const currentSection = entry.target;
                const previousSection = currentSection.previousElementSibling;

                if (previousSection && entry.intersectionRatio >= 0.1) {
                    // El siguiente elemento es visible al menos un 10%
                    previousSection.classList.add("shrink");
                } else if (previousSection) {
                    // El siguiente elemento ya no es visible al 10%
                    previousSection.classList.remove("shrink");
                }
            });
        },
        {
            threshold: [0.1], // Detectar cuando el 10% del elemento es visible
        }
    );

    sections.forEach((section) => observer.observe(section));
});
