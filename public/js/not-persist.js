const Ho = document.getElementById("iconNavbarSidenav"),
    jo = document.getElementById("iconSidenav");
let Be = document.getElementsByTagName("body")[0],
    cn = "g-sidenav-pinned";
Ho && Ho.addEventListener("click", Wi);
jo && jo.addEventListener("click", Wi);
function Wi() {
    Be.classList.contains(cn) ? Be.classList.remove(cn) : Be.classList.add(cn);
}
let _h = document.getElementsByTagName("html")[0];
_h.addEventListener("click", function (o) {
    Be.classList.contains("g-sidenav-pinned") &&
        !o.target.classList.contains("nav-toggler") &&
        !o.target.classList.contains("nav-collapse") &&
        !o.target.classList.contains("nav-item") &&
        !o.target.classList.contains("nav-link") &&
        Be.classList.remove(cn);
});
window.addEventListener("resize", Fi);
window.addEventListener("load", Fi);
function Fi() {
    let o = document.querySelectorAll('[onclick="sidebarType(this)"]');
    window.innerWidth < 992
        ? o.forEach(function (t) {
              t.classList.add("disabled");
          })
        : o.forEach(function (t) {
              t.classList.remove("disabled");
          });
}
