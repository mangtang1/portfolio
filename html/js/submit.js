function check_all_written(tag)
{
	let checklist = document.querySelectorAll(tag);
	let sw=true;
	checklist.forEach((tar) => {
		console.log(tar);
		console.log(tar.value);
		if(!tar.value) sw=false;
	});
	return sw;
}
function able_but(checktag,but)
{
	
	let sendButton = document.querySelector(but);
	switch(check_all_written(checktag))
	{
		case true :sendButton.classList.add('active'); sendButton.disabled = false; break;
		case false :sendButton.classList.remove('active'); sendButton.disabled = true; break;
	}	
}
window.addEventListener("onload", function(){
	let checklist = document.querySelectorAll('input.inp');
	checklist.forEach((tar) => {
		tar.addEventListener('keyup', function(){able_but('input.inp', 'button.sub')});
	});
});