function ajaxJquery(url, destiny, formulario)
{
	if(formulario == null)
		$("#" + destiny).load(url);
	else
	{
		var string = null;
		string = formRun(document.getElementById(formulario));
		$("#" + destiny).load(url + "/?JPOST=1", string);
	}
	document.getElementById(destiny).innerHTML='<div class="qr-code-menu"><div class="ajax_loading"><object id="svg" data="/refectory/public/img/layout/loading.svg"></object></div></div>';
}

function ajaxJqueryListing(url, destiny, formulario)
{
	var string = null;
	string = formRun(document.getElementById(formulario));
	$("#" + destiny).load(url, string);
}

function ajaxJqueryFast(url, destiny)
{
  $("#" + destiny).load(url);
}

function formRun(obj)
{
	var string = "";
	var child = obj.firstChild;
	while (child)
	{
		if(child.nodeType == 1)
			if((child.tagName == "INPUT" && (child.type == "text" || child.type == "time" || child.type == "date" || child.type == "number" || child.type == "hidden")) || child.type == "password" ||child.tagName == "TEXTAREA")
				string += child.name + "=" + encodeURIComponent(child.value) + "&";
			else if (child.tagName == "INPUT" && (child.type == "radio" || child.type == "checkbox") && child.checked)
				string += child.name + "=" + encodeURIComponent(child.value) + "&";
			else if (child.tagName == "SELECT")
			{
				for (var i = 0; i < child.selectedOptions.length; i++)
					string += child.name + "=" + encodeURIComponent(child.selectedOptions[i].value) + "&";
			}
		string += formRun(child);
		child = child.nextSibling;
	}
	return string;
}

function formSubmitXls(formulario, url)
{
	action_old = $('#'+formulario).attr('action');
	formulario = document.getElementById(formulario);
	formulario.action = url;
	
	//adiciona o campo AJAX com valor 1
	fieldAjax = document.createElement("input");
	fieldAjax.name = "JPOST";
	fieldAjax.value = "1";
	formulario.appendChild(fieldAjax);
	
	//adiciona o campo XLS com valor 1
	fielXls = document.createElement("input");
	fielXls.name = "XLS";
	fielXls.value = "1";	
	formulario.appendChild(fielXls);
	
	//envia o formulario
	formulario.submit();
		
	//altera o action do formulario para o original
	formulario.action = action_old;
	
	//remove os dois campos do formulario
	formulario.removeChild(fieldAjax);
	formulario.removeChild(fielXls);
}

function formSubmit(formulario, url)
{
	action_old = $("#" + formulario).attr("action");
	formulario = document.getElementById(formulario);
	formulario.action = url;
	formulario.submit();
	formulario.action = action_old;
}

function checkAll(o)
{
	var boxes = document.getElementsByTagName("input");
	for (var x = 0; x < boxes.length; x++)
	{
	    var obj = boxes[x];
	    if (obj.type == "checkbox")
	    {
	    	if (obj.name != "check")
	    		obj.checked = o.checked;
	    }
	}
}

function toggleTreeIn(childBlockEl) {
  $("#" + childBlockEl).fadeToggle("slow");
}