function toggleMobileSidebar() {
    var sidebar = document.getElementById('mobileSidebar');
    var overlay = document.getElementById('sidebarOverlay');
        
    if (sidebar.classList.contains('open')) {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        setTimeout(() => {
            if(!sidebar.classList.contains('open')) overlay.style.display = 'none';
        }, 300);
    } else {
        overlay.style.display = 'block';
        setTimeout(() => {
            sidebar.classList.add('open');
            overlay.classList.add('open');
        }, 10);
    }
}

function toggleSubmenu(element) {
    const submenu = element.nextElementSibling;
    const icon = element.querySelector('i');
        
    if (submenu.classList.contains('open')) {
        submenu.classList.remove('open');
        icon.classList.remove('ti-angle-up');
        icon.classList.add('ti-angle-down');
    } else {
        submenu.classList.add('open');
        icon.classList.remove('ti-angle-down');
        icon.classList.add('ti-angle-up');
    }
}