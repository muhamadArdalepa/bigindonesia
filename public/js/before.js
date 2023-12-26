function setAttributes(el, options) {
    Object.keys(options).forEach(function (attr) {
        el.setAttribute(attr, options[attr]);
    });
}
