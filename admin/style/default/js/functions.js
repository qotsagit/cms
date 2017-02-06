// all functions here

function getPage(id,url)
{
	$('#output').html('Loading ... ');
	jQuery.ajax
    ({
		url: url,
		data:'id='+id,
		type: "POST",
		success:function(data){ $('#output').html(data);}
	});
}


