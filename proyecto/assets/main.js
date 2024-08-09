const linksBackoff = document.querySelectorAll(".nav-option");

linksBackoff.forEach(link => {
    link.addEventListener('click',(e) => {
        e.preventDefault()
        linksBackoff.forEach(liActive => liActive.classList.remove('active')) 
        link.classList.add('active')
        });
})

