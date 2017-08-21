var ua = navigator.userAgent.toLowerCase();
var isWeixin = ua.indexOf('micromessenger') != -1;

if (isWeixin) {
	document.addEventListener("WeixinJSBridgeReady", init, false);
}else{
	$(init)
}


function init(){
	
	var timerFlash = null;

	//老虎机闪灯
	clearInterval(timerFlash)
	timerFlash = setInterval(function(){
		$(".decoration").toggleClass("flash");
	}, 800);

	//解决 手机 click事件 300ms延迟
	FastClick.attach(document.body);

	//弹窗背景层
	var $alertBg = $('.alert-box');
	var timer = null;
	//老虎机滚动元素
	var $scroll = $('.j-scroll');

	//点击活动说明
	$('.j-activity-desc').click(function(){
		$alertBg.addClass('flex')
		$('.activity-desc').addClass('flex')
	})

	//点击关注千锋教育
	$('.j-aboutQF').click(function(){
		$alertBg.addClass('flex')
		$('.aboutQF').addClass('flex')
	})

	//点击关闭按钮
	$('.close').click(function(){
		$(this).parent().removeClass('flex')
		$alertBg.removeClass('flex')
	})

	//点击我要抢房租
	$('.j-me-start').click(function(){
		//如果按钮是灰色，直接返回
		if($(this).hasClass('btns-btn1-style2')){
			return false
		}
		if($(this).hasClass('get-to')){
			$('.alert-box').addClass('flex');
			$('.getinfo').addClass('flex');
			return false
		}
		//老虎机闪灯
		clearInterval(timerFlash)
		timerFlash = setInterval(function(){
			$(".decoration").toggleClass("flash");
		}, 60);

		//开始滚动
		$scroll.addClass('infinity-animate')
		//滚动之后按钮变灰色
		$(this).removeClass('btns-btn1-style1').addClass('btns-btn1-style2')

		//设置 应该停在哪里
		var stopIndex = rnd(0, $scroll.children().length)
		console.log(stopIndex)
		//给目标元素添加 class
		$scroll.children().eq(stopIndex).addClass('scroll-stop')
		//计算 停下时的top值
		var stopTop = $scroll.children().eq(0).height()*stopIndex;
		//提示的文字
		//var showHtml = $('.scroll-stop').html();
		var money = parseFloat($('.scroll-stop').text());
		if ($(this).hasClass('help')) {
			var data = {
					u_id:$('input[name=help_id]').val(),
					h_money:money
				};
		} else {
			var data = {
					h_money:money
				};
		}
		
		
			//提交数据
			var url = 'http://' + window.location.host + '/index/index/help';
			
			status = true;
			error = true;
			$.ajax({
				type: 'POST',
				url: url,
				data: data,
				dataType: 'json',
				success: function(json){
					var json = JSON.parse(json);
					
					if(json.errcode == 0){
						num_money = json.num_money;
						$('.scroll-stop').html("<span>" + parseFloat(json.money)+ "元</span>");
						if (json.status == 3) {
							status = false;
						} 
						//console.log($('.scroll-stop').html());
						
					} else {
						error = false;
						alert(json.info);
						
					}
				},
				error: function(){
					
				}
			})
		//提示的文字
		
		//3秒钟之后自动停止滚动
		clearTimeout(timer);
		timer = setTimeout(function(){
			$scroll.css({
				"transform": "translateY(-"+stopTop+"px)",
				"-webkit-transform": "translateY(-"+stopTop+"px)"
			})

			$scroll.removeClass('infinity-animate')

			if (status && error) {
				//显示 我抢到的弹窗
				$alertBg.addClass('flex')
				$('.me').addClass('flex')
				//设置提示文字 xx元
				$('.me').find('h3').html($('.scroll-stop span').html());
				$('.mymoney').text(num_money);
			} else {
				if (error){
					$('.over').addClass('flex');
					$('.alert-box').addClass('flex');
				}
			}
			//老虎机闪灯
			clearInterval(timerFlash)
			timerFlash = setInterval(function(){
				$(".decoration").toggleClass("flash");
			}, 800);

		}, 3000)
	})

	//点击邀请好友帮你抢钱
	$('.j-invite-friends').click(function(){
		if($(this).hasClass('get-to')){
			$('.alert-box').addClass('flex');
			$('.getinfo').addClass('flex');
			return false
		}
		$alertBg.addClass('flex')
		$('.share-tips').addClass('flex')
		$alertBg.click(function(){
			$alertBg.removeClass('flex')
			$('.share-tips').removeClass('flex')
		})
	})


	//弹窗的确定按钮
	$('.alert-btn').click(function(){
		if($(this).html() == '提交'){
			var username = $('[name=username]').val();
			var tel = $('input[name=tel]').val();

			if($.trim(username) == ''){
				alert('用户名不能为空')
				return false;
			}
			if($.trim(tel) == ''){
				alert('手机号不能为空')
				return false;
			}else{
				if(!tel.match(/0?(13|14|15|18)[0-9]{9}/)){
					alert('手机号格式错误')
					return false;
				}
			}

			console.log(username, tel)
			$alertBg.removeClass('flex')
			$(this).parent().removeClass('flex')

			//提交数据
			var url = 'http://' + window.location.host + '/index/index/joinAct';
			
			$.ajax({
				type: 'POST',
				url: url,
				data: {
					username: username,
					tel: tel
				},
				dataType: 'json',
				success: function(json){
					var json = JSON.parse(json);
					if(json.errcode == 0){
						alert(json.info);
						//提交数据返回成功之后关闭弹窗 
						$alertBg.removeClass('flex')
						$(this).parent().removeClass('flex')
						$('.j-me-start').removeClass('get-to')
						$('.j-invite-friends').removeClass('get-to')
					} else {
						alert(json.info);
					}
					
				},
				error: function(){
					
				}
			})

		}else{
			$alertBg.removeClass('flex')
			$(this).parent().removeClass('flex')
		}
	})

	//倒计时
	//活动结束时间
	var overTime = $('[data-date]').attr('data-date');

	showOverTime(overTime)

	function showOverTime(overTime){
		var aDate = overTime.split('-');
		
		var y = aDate[0]-0;
		var m = aDate[1]-1;
		var d = aDate[2]-0;
		var targetTime = new Date(y, m, d).getTime();
		one()
		setInterval(one, 1000)

		function one(){
			var setpTime = (targetTime - new Date().getTime())/1000;

			var nowD = Math.floor(setpTime/86400);
			var nowH = Math.floor(setpTime%86400/3600);
			var nowM = Math.floor(setpTime%86400%3600/60)
			var nowS = Math.floor(setpTime%86400%3600%60)
			
			$('.countdown').html(nowD+'天'+nowH+'小时'+nowM+'分'+nowS+'秒')
		}
	}

	//随机数
	function rnd(m, n){
		return Math.floor(Math.random()*(n-m)+m);
	}

}

	//设置53样式
	if(!!$('#mobile_icon_div').html()){
		console.log($('#mobile_icon_div').html())
		set53Style()
		console.log(1)
	}else{
		setTimeout(function(){
			set53Style()
			console.log(2)
		}, 2000)
	}
//设置 53 客服
	function set53Style(){

	//默认院校（YX）
	var defaultType = $('input[name=from_stu]').val();

	
	// 
	//如果是院校  显示离线留言
	if(defaultType == 'YX'){
	

		//设置离线留言位置
		$('#mobile_icon_div').css({
			"position": "fixed",
			"display": "block",
			"font-family": '"Helvetica Neue", Helvetica, STHeiTi, sans-serif',
			"z-index": "100000",
			"width": "33.33vw",
			"height": "8.533vw",
			"left": "33.33vw",
			"bottom": "1.973vw",
			"font-size": '3.4666vw',
			"opacity": "0"
   		})
   		$('#mobile_icon_div').children().css({
			"min-height": "initial",
			"width": "100%",
			"height": "100%",
			"box-shadow": "initial",
			"margin-left": "0px",
			"margin-top": "0px"
   		})
   		$('#mobile_icon_div').children().children().eq(0).css('display','none')
   		$('#mobile_icon_div').children().children().eq(1).html('在线答疑').css({
			"position": "relative",
			"color": "#fff",
			"background": "none",
			"padding-top": 0,
			"padding-left": 0,
			"padding-right": "7.2vw",
			"padding-bottom": 0,
			"min-height": "initial",
			"z-index": 1,
			"box-sizing": "border-box",
			"line-height": "9.333vw",
			"text-align": "right",
			"width": "100%",
			"word-wrap": "break-word",
			"height": "100%",
			"border-radius": 0,
			"font-size": "3.4666vw",
			"display": "block"
		})
	}else{
		//移除离线留言
		$('#mobile_icon_div').remove()
	}
}
