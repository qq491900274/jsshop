
$(function(){


	//==================================二维码页面 ewm ===================================================
		/*弹窗*/
		$('.hxTop div').click(function(){
			$('.bg').show();
		});
		$('.cancel').click(function(){
			$('.bg').hide();
		});
		$('.sure').click(function(){

		});
		/*选择校区*/
		$('.selectLI ul li').each(function(){
			var val=$(this).find('span').html();
			$(this).find('input').change(function(){
				$('#area').val(val);
				$('.bg').hide();
			})
		});
		//==================================首页 index ===================================================
		$('.ticket ul li.on').find('p').html('已领取票券');
		$('.ticket ul li.on').find('i').hide();

		//==================================个人信息 information ===================================================
		$(".maInput ul li input").each(function(){
			$(this).focus(function(){
				$(this).css('background-color','#fafafa');
			});
			$(this).blur(function(){
		    	$(this).css("background-color","#FFF");
			});
		});
		// 性别
		$('#sex').click(function(){
			$('.sex').animate({'height':'10.88rem'},200);
		});
		$('#grade').click(function(){
			$('.grade').animate({'height':'26.453333rem'},200);
		});
		
		$('.selectInfor input').change(function(){
			$('.selectInfor').animate({height:'0px'},200);
		});
		$('.ensure').click(function(){
			$('.selectInfor').animate({height:'0px'},200);
		})
		// 选择性别
		$('.sex ul li').each(function(){
			var val=$(this).find('span').html();
			$(this).find('input').change(function(){
				$('#sex').val(val);
			})
		});
		//选择年级
		$('.grade ul li').each(function(){
			var val=$(this).find('span').html();
			$(this).find('input').change(function(){
				$('#grade').val(val);
			})
		})

		//==================================支付 payment ===================================================
		$(".payForm input").each(function(){
			$(this).focus(function(){
				$(this).css('background-color','#fafafa');
			});
			$(".payForm input").blur(function(){
		    $("input").css("background-color","#FFF");
			});
		})

		//================================== 商品 shangpin ===================================================
		/*领券*/
		$('.sp_quan .quan_box ul li .on').find('.right').html('已领取票券');

		/*加入购物车弹出框*/
		$('.guige').click(function(){
			$('.bg').show();
		});
		$('.choTop .right').click(function(){
			$('.bg').hide();
		});
		$('.flaseShop a').click(function(){
			$('.bg').show();

		});
		/*商品券弹出框*/
		$('.quan').click(function(){
			$('.sp_quan').show();
		});
		$('.sp_quan .back').click(function(){
			$('.sp_quan').hide();
		})

//**************************************** 购物车 shopping shopping_xiajia **********************************************************
		$('#sc').on('click',function(){
			var arr = new Array();
			//询问框
			 layer.open({
			    content: '确定要删除吗？'
			    ,btn: ['确认', '取消']
			    ,yes: function(index){
					//删除选中的
					$(".cartBox input[type='checkbox']").each(function(i){
						if(this.checked){ //如果选中了就保存复选框的值  
					    arr[i] = $(this).val();
						 $(this).parents('li').remove();
						 };
						if(arr.length==0)
						{
							alert("还没有选择要删除的");
							//$('#qx').checked==false;
						}else{
				        var vals = arr.join(",");//这里是复选框最后要删除的所有id ，一般ajax异步传给后台去删除
					    //重新计算价格
					  	cilci_all_money();
						};
					});
					layer.close(index);
			    }
			  });
		});



		//================================== 订单详情 order_detail ===================================================
		
			var allOrderMoney=0;
			$('.pay ul li').each(function(){
				var priceOrder=$(this).find('.botLi h3 span').html();
				var numOrder=$(this).find('.botLi .right span').html();
				//console.log(priceOrder);
				allOrderMoney+=parseFloat(priceOrder*numOrder);
				//console.log(allOrderMoney);

			})
			$('#allMoney').find('span').html("￥"+allOrderMoney.toFixed(2));
			var yh=$('#yh').html();
			parseFloat(yh);
			//console.log(yh);
			$('#allPrice').html("￥"+(allOrderMoney-yh).toFixed(2));

		//================================== 支付成功 success ===================================================
		$(".payForm input").each(function(){
			$(this).focus(function(){
				$(this).css('background-color','#fafafa');
			});
			$(".payForm input").blur(function(){
		    $("input").css("background-color","#FFF");
			});
		})

		//================================== 测试 test2 ===================================================
		$('#textList>li').each(function(){
			$(this).find('input[type=radio]').change(function() {
				$(this).parent('li').children('p').addClass('on');
				$(this).parent('li').siblings('li').children('p').removeClass('on')
			});
		});
		$('#textList li .main').each(function(){
			$(this).click(function(){
				$(this).siblings('ul').slideToggle();
				$(this).parent('li').siblings('li').children('ul').slideUp();
			})
		})

		//==================================优惠券 youhuiquan ===================================================
		$('.yhq_box ul li .on').find('.right').children('span').hide()
		$('.yhq_box ul li .on').find('.right').children('i').css('display','block');

})


			//===============================加减的实现===================================//
			$('.num').click(function(){
				//a.preventDefault();
				var num=$(this).siblings('span').html();
				if($(this).attr('val')=='1'){
					num--;
					if(num<=1){
						num=1;
					}
					// if(num==1){
					// 	num=1;
					// }else{
					// 	num--;
					// }
				}else{
					num++;
				}
				var count=$(this).siblings('span').html(num);
				//重新计算价格
				cilci_all_money();
			});

		
	//===============================勾选时========================================//
		$('.son_check').click(function (){
			//选中课时计算价格
			cilci_all_money();
		});
		//计算所选课时价格
		function cilci_all_money(){
			var money=0;//总价
			 $('.son_check').each(function(){
				if($(this).is(':checked')){
					var price=$(this).parents('li').find('.price1').html();
					var num=$(this).parents('li').find('.right').children('span').html();
					//console.log(num);
					money+=parseFloat(price*num);
				}
			});
			$('.result').find('#allmoney').html(money.toFixed(2));
			$('.result').find('#allmoney2').html(money.toFixed(2));
		}

//==================================全选与取消全选===============================================
//找到id为qx的input,为其绑定单击事件为function：
		
		/*window.onload=function(){
			var chbAll=document.getElementById('qx');
			chbAll.onclick=function(){
				//获得cartBox下ul下所有第一个li中的input,保存在chbs
				var chbs=document.querySelectorAll(".cartBox ul li input");
				//console.log(chbs);
				//遍历chbs中每个chb
				for(var i=0;i<chbs.length;i++){
				  //chbs数组中当前chb的checked等于事件中当前chb的checked
				  chbs[i].checked=this.checked;
				}
				cilci_all_money();
			}
		

			//找到cartBox下ul下所有第一个li中的input,保存在chbs
			var chbs=document.querySelectorAll(".cartBox ul li input");
			//遍历chbs
			for(var i=0;i<chbs.length;i++){
				chbs[i].onclick=check;//为当前chb绑定点击事件为check
			}
			//定义函数check
			function check(){
				//如果当前chb未选中
				if(!this.checked){
					chbAll.checked=false;//chbAll也改为未选中
				}else{
					//获得cartBox下ul下所有第一个li中的input,保存在chbs
					var chbs=document.querySelectorAll(".cartBox ul li input:not(:checked)");
					//如果chbs的length等于0
					if(chbs.length==0){chbAll.checked=true;}//chbAll也改为选中
					//否则chbAll改为未选中
					else{chbAll.checked=false;}
				}
			}
		}*/
		

//**************************************** 购物车 end **********************************************************
 	



