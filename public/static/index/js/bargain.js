$(document).ready(function(){
	
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
		//开始滚动
		$scroll.addClass('infinity-animate')
		//滚动之后按钮变灰色
		$(this).removeClass('btns-btn1-style1').addClass('btns-btn1-style2')

		//设置 应该停在哪里
		var stopIndex = rnd(1, $scroll.children().length)
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
						console.log($('.scroll-stop').html());
						
					} else {
						alert(json.errcode);
					}
				},
				error: function(){
					
				}
			})
		//提示的文字
		
		console.log($('.scroll-stop').html());
		//3秒钟之后自动停止滚动
		
		clearTimeout(timer);
		timer = setTimeout(function(){
			$scroll.css({
				"transform": "translateY(-"+stopTop+"px)",
				"-webkit-transform": "translateY(-"+stopTop+"px)"
			})
			var showHtml = $('.scroll-stop').html();
			console.log(showHtml);
			$scroll.removeClass('infinity-animate')
			if (status) {
				//显示 我抢到的弹窗
				$alertBg.addClass('flex')
				$('.me').addClass('flex')
				//设置提示文字 xx元
				$('.me').find('h3').html(showHtml);
				$('.mymoney').text(num_money);
			} else {
				$('.over').addClass('flex');
				$('.alert-box').addClass('flex');
							
			}
			

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



}) 