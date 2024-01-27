function showPassword(e) {
    let isShow = e.previousElementSibling.getAttribute("type") == "text";
    if (isShow) {
        e.previousElementSibling.setAttribute("type", "password");
        e.innerHTML = '<i class="fa-solid fa-eye"></i>';
    } else {
        e.previousElementSibling.setAttribute("type", "text");
        e.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    }
}

if (document.querySelectorAll(".input-group").length != 0) {
    var allInputs = document.querySelectorAll("input.form-control");
    allInputs.forEach((el) =>
        setAttributes(el, {
            onfocus: "focused(this)",
            onfocusout: "defocused(this)",
        })
    );
}

document.addEventListener("livewire:navigated", () => {
    const Ho = document.getElementById("iconNavbarSidenav"),
        jo = document.getElementById("iconSidenav");
    let Be = document.getElementsByTagName("body")[0],
        cn = "g-sidenav-pinned";
    Ho && Ho.addEventListener("click", Wi);
    jo && jo.addEventListener("click", Wi);
    function Wi() {
        Be.classList.contains(cn)
            ? Be.classList.remove(cn)
            : Be.classList.add(cn);
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

    [...document.querySelectorAll(".dropdown-menu")].map((item) => {
        item.previousElementSibling.addEventListener("click", (e) => {
            item.classList.remove("d-none");
        });
    });
});

function copyText(text, context) {
    navigator.clipboard.writeText(text);
    Success.fire(context + ' berhasil disalin!')
}
