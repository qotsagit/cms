
var counter = 0;
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
    
    
    /*<?php print $this->RenderImage(200,200); ?>
    var img = document.createElement("img");
    img.height = 80;
    img.classList.add("obj");
    img.file = file;
    preview.appendChild(img); // Assuming that "preview" is the div output where the content will be displayed.
    */
    //var img = _('image'); 
    img.file = file;
    var reader = new FileReader();
    reader.onload = (function(aImg) { return function(e) { aImg.src = e.target.result; }; })(img);
    reader.readAsDataURL(file);
  }
}

function uploadFiles(input,id)
{

    //handleFiles(input.files,img);
    files = input.files; 
    for (var i = 0; i < files.length; i++)
    {
        // get item
        file = files.item(i);
        //or
        file = files[i];
        //alert(file.name);

        formdata.append('image'+i,file);

        var input = document.createElement( 'input' );
        input.type = 'hidden';
        input.name = 'image'+counter++;
        input.value = file;
        var avatar = _('avatar'+id);
        avatar.appendChild(input);
    
        var ajax = new XMLHttpRequest();

        ajax.upload.addEventListener("progress",progressHandler.bind(event,id),false);
        ajax.addEventListener("load", completeHandler.bind(event,id), false);
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

function uploadFile(file,id)
{
    //handleFiles(input.files,img);
    var formdata = new FormData();
    formdata.append('image',file);
    
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", function (evt) {  progressHandler(evt, id);}, false); 
    ajax.addEventListener("load", function(evt) { completeHandler(evt,id);}, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", 'image/upload', true);
    ajax.send(formdata);

}

// dziwactwa javascriptu
function progressHandler(event,id)
{
	_("progressBar"+id).style.display = 'inline';
    //_("loaded_n_total"+id).innerHTML = "Uploaded " + event.loaded + " bytes of " + event.total;
	var percent = (event.loaded / event.total) * 100;
	_("progressBar"+id).value = Math.round(percent);
	_("status"+id).innerHTML = Math.round(percent) + '%';
}

function completeHandler(event,id)
{
    //alert(event.target.responseText);
	_("avatar"+id).src = event.target.responseText;
    //$("#upload"+id).fadeIn(500);
	//$("#upload"+id).delay( 3000 ).fadeOut(2500);
    //_("status"+id).innerHTML = event.target.responseText;
	//_("progressBar"+id).value = 0;
    //_("progressBar"+id).style.display = 'none';

}

function errorHandler(id,event)
{
	_("status"+id).innerHTML = "Upload Failed";
}

function abortHandler(id,event)
{
	_("status"+id).innerHTML = "Upload Aborted";
}
