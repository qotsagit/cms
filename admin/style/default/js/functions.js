// all functions here

function getPage(div,id,url)
{
	$(div).html('Loading ... ');
	
	jQuery.ajax
    ({
		url: url,
		data:'id='+id,
		type: "GET",
		success:function(data){ $(div).html(data);}
	});
}


