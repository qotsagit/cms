//var myVar = setInterval(showTime, 1000);
//var myVar = setInterval(myTimer, 1000);

function _(el)
{
    return document.getElementById(el);
}

function handleFiles(files,img) 
{
  for (var i = 0; i < files.length; i++) 
  {
    var file = files[i];
    var imageType = /^image\//;
    
    if (!imageType.test(file.type)) 
    {
      continue;
    }
    
    /*
    var img = document.createElement("img");
    img.height = 80;
    img.classList.add("obj");
    img.file = file;
    preview.appendChild(img); // Assuming that "preview" is the div output where the content will be displayed.
    */
    img.file = file;
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}

function uploadFile(input,img)
{
    //alert(input.files);
    handleFiles(input.files);
    files = input.files; 
    for (var i = 0; i < files.length; i++)
    {
        // get item
        file = files.item(i);
        //or
        file = files[i];
        //alert(file.name);

        var formdata = new FormData();
        formdata.append('image',file);

        var ajax = new XMLHttpRequest();

        ajax.upload.addEventListener("progress",progressHandler,false);
        ajax.addEventListener("load", completeHandler, false);
	    ajax.addEventListener("error", errorHandler, false);
	    ajax.addEventListener("abort", abortHandler, false);
        ajax.open("POST", 'ajax', true);
        ajax.send(formdata);

    }
    
    //alert(file.name + ' ' + file.size);
    
    //var reader = new FileReader();
    // reader.onload = function()
    // {
    //  var dataURL = reader.result;
    //  img.src = dataURL;
    //};
    
    //reader.readAsDataURL(input.files[0]);
    
}

function progressHandler(event)
{
	_("progressBar").style.display = 'inline';
    _("loaded_n_total").innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar").value = Math.round(percent);
	_("status").innerHTML = Math.round(percent);
}

function completeHandler(event)
{
    alert(event.target.responseText);
	_("avatar").src = event.target.responseText;
    _("status").innerHTML = event.target.responseText;
	_("progressBar").value = 0;
    _("inputfile").value = null;
    _("progressBar").style.display = 'none';
}

function errorHandler(event)
{
	_("status").innerHTML = "Upload Failed";
}

function abortHandler(event)
{
	_("status").innerHTML = "Upload Aborted";
}

function myTimer() 
{
    var d = new Date();
    _("demo").innerHTML = d.toLocaleTimeString();
}

function showPage(id,url,form)
{
    var ajax = new XMLHttpRequest();

    ajax.upload.addEventListener("progress",progressHandler,false);
    ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
    /*
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            _(id).innerHTML = xmlhttp.responseText;
        }
        
        if(xmlhttp.readyState == 1)
        {
            _(id).innerHTML = 'Loading ...';
        }
        
    };
    */
    ajax.open("POST", url, true);
    ajax.send(form);
    
}
