var num=0,current=0;
var slides=new Array();
var interval;
function Put()
{
	if(slides[current].filters.alpha.opacity>67)
		slides[current].filters.alpha.opacity-=1;
	else
	{
		clearInterval(interval);
	}
}
function NextSlide()
{
	interval=setInterval("Put()",50);
	slides[current].style.display="none";
	current++;
	if(current==slides.length)
		current=0;
	slides[current].filters.alpha.opacity=101;
	slides[current].style.display="block";
	setTimeout("NextSlide()",2400);
}
function Makeshllow()
{
	var imgs=document.getElementsByTagName("img");
	for(var i=0;i<imgs.length;i++)
	{
		if(imgs[i].className!="slide")
			continue;
		slides[num]=imgs[i];
		if(num==0)
			imgs[i].style.display="block";
		else
			imgs[i].style.display="none";
		num++;
	}
	NextSlide();
}

