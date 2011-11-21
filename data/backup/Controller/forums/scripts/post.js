var post, mz, ie;
var div_link, div_link_title, div_link_url;
var post_link, post_image, post_flash;

var mask = document.getElementById("fla-body");
var parent = document.getElementById("fla-container");
var child = document.getElementById("fla-object");
var Cwidth = "";
var Cheight = "";

var post_final;

var temp_func = window.onload;
window.onload = function()
{
	temp_func();
	
	mz = window.getSelection ? true : false;
	ie = document.selection && document.selection.createRange ? true : false;

	div_link 				= document.getElementById("div_link");
	div_link_title 	= document.getElementById("div_link_title");
	div_link_url 		= document.getElementById("div_link_url");
	post_final 			= document.getElementById("post_final");
	
	// Hidden elements for complex updates
	post_link 	= "%0A%20%20%3Cdiv%20class=%22dft-hdr-min%20blu-bdr%22%3E%0A%20%20%20%20Insert%20Link%3C/div%3E%0A%0A%20%20%3Ctable%20class=%22blu-bdr%22%20border=%220%22%20cellpadding=%224%22%20cellspacing=%220%22%20width=%22100%25%22%3E%0A%20%20%20%20%3Ctbody%3E%3Ctr%20class=%22blu-alt%22%3E%0A%20%20%20%20%20%20%3Ctd%20width=%22110%22%3E%0A%20%20%20%20%20%20%20%20Title:%3C/td%3E%0A%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%3Cinput%20id=%22post_link_title%22%20style=%22width:%20200px;%22%20type=%22text%22%3E%3C/td%3E%0A%20%20%20%20%3C/tr%3E%0A%20%20%20%20%3Ctr%3E%0A%20%20%20%20%20%20%3Ctd%20width=%22110%22%3E%0A%20%20%20%20%20%20%20%20URL%20Link:%3C/td%3E%0A%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%3Cinput%20id=%22post_link_url%22%20value=%22http://%22%20style=%22width:%20200px;%22%20type=%22text%22%3E%3C/td%3E%0A%20%20%20%20%3C/tr%3E%0A%20%20%20%20%3Ctr%20class=%22blu-alt%22%3E%0A%20%20%20%20%20%20%3Ctd%3E%3C/td%3E%0A%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%3Cinput%20name=%22submit%22%20value=%22Insert%20Link%22%20class=%22inp-btn%22%20style=%22width:%20204px;%22%20onclick=%22post_link_set();%22%20type=%22button%22%3E%3C/td%3E%0A%20%20%20%20%3C/tr%3E%0A%20%20%3C/tbody%3E%3C/table%3E%0A%0A%20%20%3Cdiv%20class=%22dft-cnt%22%3E%0A%20%20%20%20Images%20will%20be%20scaled%20down%20to%20a%20498%20pixel%20width%20and%20centered.%3C/div%3E%0A";
	post_image 	= "%0A%20%20%3Cdiv%20class=%22dft-hdr-min%20blu-bdr%22%3E%0A%20%20%20%20Insert%20Image%3C/div%3E%0A%0A%20%20%3Ctable%20class=%22blu-bdr%22%20border=%220%22%20cellpadding=%224%22%20cellspacing=%220%22%20width=%22100%25%22%3E%0A%20%20%20%20%3Ctbody%3E%3Ctr%20class=%22blu-alt%22%3E%0A%20%20%20%20%20%20%3Ctd%20width=%22110%22%3E%0A%20%20%20%20%20%20%20%20URL%20Link:%3C/td%3E%0A%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%3Cinput%20id=%22post_image_url%22%20value=%22http://%22%20style=%22width:%20200px;%22%20type=%22text%22%3E%3C/td%3E%0A%20%20%20%20%3C/tr%3E%0A%20%20%20%20%3Ctr%3E%0A%20%20%20%20%20%20%3Ctd%3E%3C/td%3E%0A%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%3Cinput%20name=%22submit%22%20value=%22Insert%20Image%22%20class=%22inp-btn%22%20style=%22width:%20204px;%22%20onclick=%22post_image_set();%22%20type=%22button%22%3E%3C/td%3E%0A%20%20%20%20%3C/tr%3E%0A%20%20%3C/tbody%3E%3C/table%3E%0A%0A%20%20%3Cdiv%20class=%22dft-cnt%22%3E%0A%20%20%20%20Images%20will%20be%20scaled%20down%20to%20a%20498%20pixel%20width%20and%20centered.%3C/div%3E%0A";
	post_flash 	= "%0A%20%20%3Cform%20method=%22get%22%20action=%22%22%20enctype=%22multipart/form-data%22%3E%0A%20%20%20%20%3Cdiv%20class=%22dft-hdr-min%20blu-bdr%22%3E%0A%20%20%20%20%20%20Insert%20Flash%20Media%3C/div%3E%0A%0A%20%20%20%20%3Ctable%20class=%22blu-bdr%22%20border=%220%22%20cellpadding=%224%22%20cellspacing=%220%22%20width=%22100%25%22%3E%0A%20%20%20%20%20%20%3Ctbody%3E%3Ctr%20class=%22blu-alt%22%3E%0A%20%20%20%20%20%20%20%20%3Ctd%20width=%22110%22%3E%0A%20%20%20%20%20%20%20%20%20%20Source:%3C/td%3E%0A%20%20%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%20%20%3Cselect%20id=%22post_flash_source%22%20style=%22width:%20204px;%22%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Coption%20value=%22txm%22%3ETXM.com%20Media%20Link%3C/option%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Coption%20value=%22youtube%22%3EYouTube%20Link%3C/option%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Coption%20value=%22google%22%3EGoogle%20Video%20Link%3C/option%3E%0A%20%20%20%20%20%20%20%20%20%20%20%20%3Coption%20value=%22direct%22%3EDirect%20SWF%20URL%3C/option%3E%0A%20%20%20%20%20%20%20%20%20%20%3C/select%3E%3C/td%3E%0A%20%20%20%20%20%20%3C/tr%3E%0A%20%20%20%20%20%20%3Ctr%3E%0A%20%20%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%20%20URL%20Link:%3C/td%3E%0A%20%20%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%20%20%3Cinput%20id=%22post_flash_url%22%20value=%22http://%22%20style=%22width:%20200px;%22%20type=%22text%22%3E%3C/td%3E%0A%20%20%20%20%20%20%3C/tr%3E%0A%20%20%20%20%20%20%3Ctr%20class=%22blu-alt%22%3E%0A%20%20%20%20%20%20%20%20%3Ctd%3E%3C/td%3E%0A%20%20%20%20%20%20%20%20%3Ctd%3E%0A%20%20%20%20%20%20%20%20%20%20%3Cinput%20name=%22submit%22%20value=%22Insert%20Flash%20Media%22%20class=%22inp-btn%22%20style=%22width:%20204px;%22%20onclick=%22post_flash_set();%22%20type=%22submit%22%3E%3C/td%3E%0A%20%20%20%20%20%20%3C/tr%3E%0A%20%20%20%20%3C/tbody%3E%3C/table%3E%0A%0A%20%20%20%20%3Cdiv%20class=%22dft-cnt%22%3E%0A%20%20%20%20%20%20Flash%20Media%20will%20be%20scaled%20down%20to%20a%20498%20pixel%20width%20and%20centered.%3C/div%3E%0A%20%20%3C/form%3E%0A";
	
	post = document.getElementById("post").contentWindow;
	post.document.designMode = "on";
			
	// For each standard design button, add event triggers
	var inputs = document.getElementsByTagName("input");
	for(var i = 0; i < inputs.length; i++)
	{
		if(inputs[i].id.substr(0, 2) == "pb")
		{
			inputs[i].onclick = function()
			{
				post.document.execCommand(this.id.substr(3), false, null);
				post.focus();
				return false;
			};
		}
		else if(inputs[i].id.substr(0, 2) == "ps")
		{
			inputs[i].onclick = function()
			{
				div.change(eval("post_" + this.id.substr(3)), 376, 146);
				return false;
			};
		};
	};
		
	// Set load delay for IE to properly fill Topic
	setTimeout("updatePost()", 50);
	
	// Put data being typed into the hidden field to protect against accidental refresh
	setInterval("submitPost()", 30000);
	
	document.getElementById("post_form").onsubmit = submitPost;
	return true;
};

function updatePost()
{
	var url = "http://www.txm.com/forums/styles/content.css";	
	if(post.document.createStyleSheet) 
	{
		post.document.createStyleSheet(url);	
	}	
	else 
	{
		var styles = "@import url(' " + url + " ');";
		var newSS = post.document.createElement("link");
		newHead = post.document.createElement("head");
		newSS.rel = "stylesheet";
		newSS.href = "data:text/css," + escape(styles);
		newHead.appendChild(newSS);
		post.document.appendChild(newHead);
	}
	
	post.document.body.innerHTML = post_final.value;
}

function submitPost()
{
	post_final.value = post.document.body.innerHTML;
	return true;
};

function post_link_set()
{
	var title = document.getElementById("post_link_title");
	var url 	= document.getElementById("post_link_url");
	add_html("<a href=\"" + url.value + "\">" + title.value + "</a>");
	div.hide();
};

function post_image_set()
{
	var url 	= document.getElementById("post_image_url");
	add_html("<img src=\"" + url.value + "\" />");
	div.hide();
};

function post_flash_set()
{
	var source 	= document.getElementById("post_flash_source");
	var url 		= document.getElementById("post_flash_url");
	
	if(source.selectedIndex == 0)
	{	
		url.value = "http://www.txm.com/media/player.swf?id=" + url.value;
	}
	
	add_html("<img src=\"http://www.txm.com/media/assets/flash-dummy.gif\" width=\"425\" height=\"350\" data=\"" + url.value + "\" />");
	div.hide();
};

function add_html(html)
{
	if(mz) 
	{		
		var random_string = "insert_html_" + Math.round(Math.random()*100);
		post.document.execCommand("insertimage", false, random_string);
		var pat = new RegExp("<[^<]*" + random_string + "[^>]*>");
		post.document.body.innerHTML = post.document.body.innerHTML.replace(pat, html);
	}
	else if(ie)
	{
		post.document.selection.createRange().pasteHTML(html);
	};
};

function getCurrentSelection()
{
	if(mz) 
	{
		return post.window.getSelection().toString();
	} 
	else if(ie)
	{
		return post.document.selection.createRange().text;
	}
	else
	{
		return false;
	};	
};