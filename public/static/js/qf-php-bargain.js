$(function(){
	//解决 手机 click事件 300ms延迟
	FastClick.attach(document.body);

	var timer = null;
	var $alertBox = $('.alert-box');
	var $helpList = $('.j-help-list');
	


	//点击活动说明
	$('.j-eventdescription').click(function(){
		$alertBox.addClass('flex');
		$('.alert-01').addClass('flex');
	})

	//点击二维码
	$('.j-qrcode-btn').click(function(){
		
		$alertBox.addClass('flex');
		$('.alert-02').addClass('flex');
		
		
	})

	//点击我要参加  弹出表格
	$('.j-join').click(function(){
		 bReg = $('#talk').val();
		 if (bReg == 1) {
			$alertBox.addClass('flex');
			$('.alert-04').addClass('flex');
		}
	})

	//点击关闭
	$('.alert-close').each(function(){
		$(this).click(function(){
			$(this).parent().removeClass('flex');
			$alertBox.removeClass('flex');
		})
	})
	//关闭分享提示
	//$('.alert-close').click(function(){
	$alertBox.click(function(){
		if ($('.share-tips').hasClass('flex')) {
			$('.share-tips').removeClass('flex');
			$alertBox.removeClass('flex');
		}
		
		
	})
	// $('.share').click(function(ev){
	// 	$('.alert-11').removeClass('flex')
	// 	$('.share-tips').addClass('flex');
		
	// 	return false;
	// })
	//点击邀请好友帮你喊按钮
	$('.j-share-friend').click(function(){
		$alertBox.addClass('flex')
		$('.share-tips').addClass('flex')
	})
	//点击获取助力列表
	$('.friends-help').click(function(){
		$alertBox.addClass('flex');
		$('.alert-12').addClass('flex');
	})
	//获取信息弹窗的确定按钮
	$('.j-alert-04-ent').click(function(){
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
			if(!tel.match(/0?(13|14|15|18|17)[0-9]{9}/)){
				alert('手机号格式错误')
				return false;
			}
		}

		
		// $alertBox.removeClass('flex')
		// $(this).parent().removeClass('flex')

		//提交数据
		var url = 'http://' + window.location.host + '/index/index/joinAct';
		if ($(this).hasClass('flex')) {
			var data =  {
				username: username,
				tel: tel,
				money:$('input[name=money]').val()
			}
		} else {
			var data =  {
				username: username,
				tel: tel
			}
		}
		$.ajax({
			type: 'POST',
			url: url,
			data:data,
			dataType: 'json',
			success: function(json){
				var json = JSON.parse(json);
				if(json.errcode == 0){
					bReg = 0;
					$('#talk').val(0);
					//提交数据返回成功之后关闭弹窗 
					$alertBox.removeClass('flex');
					$('.alert-04').removeClass('flex');
					$('#sub').removeClass('j-join');
					$('#sub').text('已报名');
					//$('.speek-btn').removeClass('j-join');
					//$('.speek-btn').attr('id','talk_btn');
					
					$(this).parent().removeClass('flex')
					$alertBox.addClass('flex');
					$('.alert-13').addClass('flex');
					
				} else {
					alert(json.info);
				}
				
			},
			error: function(){
				
			}
		})

	})

	//设置进度条对应数字样式
	var parentBarW = $('.j-head-bar').width();
	var childBarW = $('.j-head-bar').children().width();
	//数字的索引
	var numIndex = (childBarW*10/parentBarW)|0;
	$('.j-head-bar-num').children().removeClass('active')
	$('.j-head-bar-num').children().eq(numIndex).addClass('active')

	//助力团部分滚动
	//复制列表的第一个放到最后
	$helpList.append($helpList.children().eq(0).clone());
	//获取每一条的高度
	var listHeight = $helpList.children().eq(0).height();
	//当前元素的索引
	var curEleIndex = 0;

	timer = setInterval(function(){
		curEleIndex++;
		$helpList.css({
			webkitTransition: ".6s all ease",
			transition: ".6s all ease"
		})

		setTimeout(function(){
			$helpList.css({
				'webkitTransform': "translateY(-"+curEleIndex*listHeight+"px)",
				'transform': "translateY(-"+curEleIndex*listHeight+"px)"
			})
		}, 0)
		//console.log(curEleIndex)

		$helpList[0].addEventListener('webkitTransitionEnd', scrollEnd, false)
		$helpList[0].addEventListener('transitionend', scrollEnd, false)

	}, 2000)


	function scrollEnd(){
		if(curEleIndex == $helpList.children().length-1){
			$helpList.css({
				webkitTransition: 'none',
				transition: 'none'
			})
			curEleIndex = 0;
			$helpList.css({
				'webkitTransform': "translateY(0px)",
				'transform': "translateY(0px)"
			})
		}
		$helpList[0].removeEventListener('webkitTransitionEnd', scrollEnd, false)
		$helpList[0].removeEventListener('transitionend', scrollEnd, false)
	}


	// //长按语音按钮
	// var timer2 = null;

	// $('.speek-btn')[0].addEventListener('touchstart', function(ev){

	// 	//用户按住按钮的时候显示第二张图
	// 	$('.speek-btn').children().removeClass('active');
	// 	$('.speek-btn').children().eq(1).addClass('active')

	// 	//按住按钮1秒钟后触发
	// 	timer2 = setTimeout(function(){
	// 		console.log('用户在长按')
	// 		//解除touchend事件
	// 		$('.speek-btn')[0].removeEventListener('touchend', fnTouchEnd, false)

	// 		//用户按住超过1秒时显示第三张图
	// 		$('.speek-btn').children().removeClass('active');
	// 		$('.speek-btn').children().eq(2).addClass('active')			

	// 		//长按时需要干的事情。。。
	// 		console.log('调用微信录音接口')

	// 		//用户一秒之后抬起手指
	// 		$('.speek-btn')[0].addEventListener('touchend', function(){
	// 			//用户停止按时显示第一张图
	// 			$('.speek-btn').children().removeClass('active');
	// 			$('.speek-btn').children().eq(0).addClass('active')
	// 		}, false)
	// 	}, 1000)

	// 	//用户在一秒之内抬起手指
	// 	$('.speek-btn')[0].addEventListener('touchend', fnTouchEnd, false)

	// 	//阻止默认事件
	// 	ev.preventDefault();
	// }, false)

	// function fnTouchEnd(){
	// 	//用户没有长按
	// 	clearTimeout(timer2)
	// 	console.log('用户没有长按')
	// 	//用户停止按时显示第一张图
	// 	$('.speek-btn').children().removeClass('active');
	// 	$('.speek-btn').children().eq(0).addClass('active')

	// }		
})