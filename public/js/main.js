var user = document.querySelector("#user");
var user_area = document.querySelector("#user-area .user-dropdown");
user.addEventListener('click', function(){
	user_area.classList.toggle('show-user-dropdown');
	
});
