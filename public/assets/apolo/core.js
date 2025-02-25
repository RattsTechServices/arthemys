/**
 * Arthemys Core Plugin
 * Version: 1.0.0
 * LICENSE: MIT
 * Developer: Victor Ratts (Ratts - Tecnologia & Serviços)
 */

var hostUrl = `${window.location.protocol}://${window.location.host}`;

console.log("Default Host: ", hostUrl);

var defaultThemeMode = "light";
var themeMode;

// Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
if (window.top != window.self) {
    window.top.location.replace(window.self.location.href);
}

if (document.documentElement) {
    if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
        themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
    } else {
        if (localStorage.getItem("data-bs-theme") !== null) {
            themeMode = localStorage.getItem("data-bs-theme");
        } else {
            themeMode = defaultThemeMode;
        }
    }

    if (themeMode === "system") {
        themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches
            ? "dark"
            : "light";
    }

    document.documentElement.setAttribute("data-bs-theme", themeMode);
}
