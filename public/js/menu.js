const menu = document.getElementById('navbarNav');

function add_collapse() {
    if (!menu) {
        return;
    }

    if (window.innerWidth <= 1000) {
        menu.classList.add('collapse');
    } else {
        menu.classList.remove('collapse');
    }
}

if (menu) {
    add_collapse();
}
