function ShowTips(e, msg)
{
    var div=document.getElementById(e);div.style.display="block";
    div.style.left=document.body.scrollLeft+event.clientX+20;div.style.top=document.body.scrollTop+event.clientY;
}

function HideTips(e)
{
    var div=document.getElementById(e);div.style.display="none";
}