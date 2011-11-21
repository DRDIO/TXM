var captcha, title, rating, type, validate, form, synopsis, commentary, keywords, file_temp, file_status, icon_temp, icon_status;

window.onload = function()
{
	captcha = document.getElementById("captcha");
	title = document.getElementById("title");
	rating = document.getElementById("id_rating");
	type = document.getElementById("id_type");
	validate = document.getElementById("validate");
	synopsis = document.getElementById("synopsis");
	commentary = document.getElementById("commentary");
	keywords = document.getElementById("keywords");
	icon = document.getElementById("icon_status");	
	form = document.getElementById("form");
	form.onsubmit = upload;
	
	file_temp = document.getElementById("file_temp");
	icon_temp = document.getElementById("icon_temp");
	
	file_status = file_temp.value == "" ? 0 : 1;
	icon_status = icon_temp.value == "" ? 0 : 1;	
};

function captcha_refresh()
{
	captcha.src = "http://www.txm.com/misc/captcha.php?r=" + Math.round(Math.random() * 1000);
};

function show_iframe(obj)
{
	document.getElementById("upload-" + obj + "-iframe").style.display = "block";
	document.getElementById("upload-" + obj + "-status").innerHTML = "";
	return false;
};

function upload()
{
	var error = "";
	if(title.value == "") { error += "Please provide a Title." + "\n"; };
	if(file_status == 0) { error += "Please upload a (.SWF) File." + "\n"; }
	else if(file_status == 2) { error += "Your file is still uploading. Please wait." + "\n"; };
	if(rating.value == "") { error += "Please provide a valid Age Rating" + "\n"; };
	if(type.value == "") { error += "Please provide a valid Game Type" + "\n"; };
	if(validate.value.length != 6) { error += "Please retype the 6 validation letters." + "\n"; };
	if(error != "")
	{
		alert(error);
		return false;
	}
	else
	{
		var ask = "";
		if(synopsis.value == "") { ask += "Are you sure you do not want a synopsis?" + "\n"; };
		if(commentary.value == "") { ask += "Are you sure you do not want commentary?" + "\n"; };
		if(keywords.value == "") { ask += "Are you sure you do not want keywords?" + "\n"; };
		if(icon_status == 0) { ask += "Are you sure you do not want an icon?" + "\n"; }
		else if(icon_status == 2) { ask += "Your icon is still uploading. Continue anyways?" + "\n"; };	
		if(ask != "" && confirm(ask + "Click OK to Upload or Cancel to add more information.") == false)
		{
			return false;
		}
		else
		{
			return true;
		};
	};
};