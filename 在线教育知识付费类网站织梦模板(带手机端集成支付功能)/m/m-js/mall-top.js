var footFn = {
getId: function(id) {
return document.getElementById(id);
},
getElem: function(selectors) {
return document.querySelector(selectors);
},
getElems: function(selectors) {
return document.querySelectorAll(selectors);
},
show: function(obj) {
obj.style.display = "block";
},
hide: function(obj) {
obj.style.display = "none";
}
};
/*回到顶部*/
(function() {
window.addEventListener("scroll", function() {
if (document.documentElement.scrollTop + document.body.scrollTop > 800) {
footFn.show(footFn.getElem(".mall-totop"));
} else {
footFn.hide(footFn.getElem(".mall-totop"));
}
}, false);
})();