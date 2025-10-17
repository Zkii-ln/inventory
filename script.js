const menu = document.querySelector("#toggle-btn");

menu.addEventListener("click", function(){
  document.querySelector("#sidebar").classList.toggle("expand");
});