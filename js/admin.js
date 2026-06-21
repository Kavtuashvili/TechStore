/* =========================
   HAMBURGER MENU
========================= */

function toggleMenu(){
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("overlay");

    sidebar.classList.toggle("active");

    // overlay toggle (if exists)
    if(overlay){
        overlay.classList.toggle("active");
    }
}

/* =========================
   CLOSE MENU ON OUTSIDE CLICK
========================= */

document.addEventListener("click", function(e){

    const sidebar = document.getElementById("sidebar");
    const hamburger = document.querySelector(".hamburger");

    if(!sidebar || !hamburger) return;

    const clickedInsideSidebar = sidebar.contains(e.target);
    const clickedHamburger = hamburger.contains(e.target);

    if(!clickedInsideSidebar && !clickedHamburger){
        sidebar.classList.remove("active");

        const overlay = document.getElementById("overlay");
        if(overlay){
            overlay.classList.remove("active");
        }
    }
});

/* =========================
   ESC KEY CLOSE
========================= */

document.addEventListener("keydown", function(e){
    if(e.key === "Escape"){
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        if(sidebar){
            sidebar.classList.remove("active");
        }

        if(overlay){
            overlay.classList.remove("active");
        }
    }
});

