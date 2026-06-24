//
const panelPath = "/admin";
if (!window.location.pathname.startsWith(panelPath)) {
    import("alpinejs").then(({ default: Alpine }) => {
        window.Alpine = Alpine;
        Alpine.start();
    });
}
