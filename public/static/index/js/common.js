/**
****************1、字体大小***************************************************************
**/
	var html=document.documentElement;
	var hwidth=html.getBoundingClientRect().width;	/*获取屏幕的宽度*/
	//console.log(hwidth);
	html.style.fontSize=hwidth/32+"px";  /*根据屏幕大小的不同设置根节点的字体大小*/

	//添加cookie
	function setcookie(name,value){
		document.cookie=name+"="+value;
	}

	function getcookie(name){
		var cookie=document.cookie;
		var arrcookie=cookie.split(';');
		var key='';

		for(var i = 0;i<arrcookie.length;i++){
			key=arrcookie[i].split('=');
			if ($.trim(key[0])==$.trim(name)) {
				return key[1];
				break;
			}
		}
	}
	function delCookie(name)
	{
		var exp = new Date();
		exp.setTime(exp.getTime() - 1);
		var cval=getcookie(name);
		if(cval!=null)
		document.cookie= name + "="+cval+";expires="+exp.toGMTString();
	}

