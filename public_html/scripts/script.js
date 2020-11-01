// document.addEventListener("DOMContentLoaded", function (e) {
//    window.location.hash = '';
//    var url = window.location.toString();
//    url = url.replace(/#anchor/,'');
//    window.location = url;
// });
window.addEventListener("load",function()  {

   history.pushState("", document.title, window.location.pathname);

});
