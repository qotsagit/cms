
//var myVar = setInterval(showTime, 1000);
//var myVar = setInterval(myTimer, 1000);


function myTimer() 
{
    var d = new Date();
    document.getElementById("demo").innerHTML = d.toLocaleTimeString();
}

function showPage(url)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById('demo').innerHTML = xmlhttp.responseText;
        }
        
        if(xmlhttp.readyState == 1)
        {
            document.getElementById('demo').innerHTML = 'Working...';
        }
    };
    xmlhttp.open("GET",url , true);
    xmlhttp.send();
    
    
}
