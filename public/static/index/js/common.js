/**
****************1、字体大小***************************************************************
**/
	var html=document.documentElement;
	var hwidth=html.getBoundingClientRect().width;	/*获取屏幕的宽度*/
	//console.log(hwidth);
	html.style.fontSize=hwidth/32+"px";  /*根据屏幕大小的不同设置根节点的字体大小*/

