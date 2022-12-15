function post_to_url(path, params, method) {
	method = method || "post";
	let form = document.createElement("form");
	form.setAttribute("method", method);
	form.setAttribute("action", path);
	for(var key in params) {
		var hiddenField = document.createElement("input");
		hiddenField.setAttribute("type", "hidden");
		hiddenField.setAttribute("name", key);
		hiddenField.setAttribute("value", params[key]);
		form.appendChild(hiddenField);
	}
	document.body.appendChild(form);
	form.submit();
}
function filter_list(input_name, show_list){
	let input, filter, ul, li, a, i, txtValue;
	input = document.getElementById(input_name);
	filter = input.value.toUpperCase();
	ul = document.getElementById(show_list);
	li = ul.getElementsByTagName('div');
	for(i=0;i<li.length;++i)
	{
		txtValue = li[i].innerText;
		if(txtValue.toUpperCase().indexOf(filter) > -1) {
			li[i].style.display = "";
		}
		else
		{
			li[i].style.display = "none";
		}
	}
}