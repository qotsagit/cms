// all functions here

function getPage(id,url)
{
	$('#content').html('Loading ... ');
	jQuery.ajax
    ({
		url: url,
		data:'id='+id,
		type: "POST",
		success:function(data){ $('#content').html(data);}
	});
}


