/**
 * @file X.js
 * @author youranreus
 */

//移动端Hover补偿
var mobileHover = function () {
    $('*').on('touchstart', function () {
        $(this).trigger('hover');
    }).on('touchend', function () {
        $(this).trigger('hover');
    });
};



function PreFancybox(){
	$("#post img").each(function(){
				$(this).wrap(function(){
					if($(this).is(".bq"))
					{
						 return '';
					}
					if($(this).is("#feedme-content img"))
					{
						return '';
					}
				return '<a data-fancybox="gallery" no-pjax data-type="image" href="' + $(this).attr("src") + '" class="light-link"></a>';
		 })
	});
}

function wookmark(){
	(function ($){
$('.tiles').imagesLoaded(function() {
var options = {
autoResize: true,
container: $('#wookmark'), 
offset: 15, //图片间距
itemWidth: 350 //图片宽度，此值改变后，需要同时变更多处数值，不建议修改。
};
var handler = $('.tiles li');
handler.wookmark(options);
});
})(jQuery);
}



//赞赏按钮
function feedme_show(){
	if($("#feedme-content").css("display")=='none'){
		 $("#feedme-content").slideDown();
	}else{
		 $("#feedme-content").slideUp();
	 }
}
//OwO设置
Smilies = {
    dom: function(id) {
        return document.getElementById(id);
    },
    grin: function(tag) {
        tag = ' ' + tag + ' ';
        myField = this.dom("textarea");
        document.selection ? (myField.focus(), sel = document.selection.createRange(), sel.text = tag, myField.focus()) : this.insertTag(tag);
    },
    insertTag: function(tag) {
        myField = Smilies.dom("textarea");
        myField.selectionStart || myField.selectionStart == "0" ? (startPos = myField.selectionStart, endPos = myField.selectionEnd, cursorPos = startPos, myField.value = myField.value.substring(0, startPos) + tag + myField.value.substring(endPos, myField.value.length), cursorPos += tag.length, myField.focus(), myField.selectionStart = cursorPos, myField.selectionEnd = cursorPos) : (myField.value += tag, myField.focus());
    }
}
//OwO开关
function OwO_show(){
	if($("#OwO-container").css("display")=='none'){
		 $("#OwO-container").slideDown();
	}else{
		 $("#OwO-container").slideUp();
	 }
}

//侧栏菜单开关
function sideMenu_toggle(){

	if($("#pjax-container").css("opacity") == 1)
	{
		$("#pjax-container").css("opacity","0.1");
		$("#sliderbar").removeClass("move_left");
		$("#sliderbar").addClass("move_right");
		$("#sliderbar-cover").toggle();
		$("#m_search").toggle();
	}
	else {
		$("#pjax-container").css("opacity","1");
		$("#sliderbar").removeClass("move_right");
		$("#sliderbar").addClass("move_left");
		$("#sliderbar-cover").toggle();
		$("#m_search").toggle();
	}

}


function gototop(){
	$('body').animate({scrollTop:0},500);
	return false;
}


//侧栏内容开关
function show_slide_content(id){

	var rotate = {
		"-webkit-transition":" .3s ease all",
		"-moz-transition": ".3s ease all",
		"-ms-transition": ".3s ease all",
		"-o-transition": ".3s ease all",
		transition: ".3s ease all",
		"-webkit-transform":" rotate(180deg)",
		"-moz-transform":" rotate(180deg)",
		"-ms-transform": "rotate(180deg)",
		"-o-transform": "rotate(180deg)",
	  transform: "rotate(180deg)"
	};

	var rotate2 = {
		"-webkit-transition":" .3s ease all",
		"-moz-transition": ".3s ease all",
		"-ms-transition": ".3s ease all",
		"-o-transition": ".3s ease all",
		transition: ".3s ease all",
		"-webkit-transform":" rotate(0deg)",
		"-moz-transform":" rotate(0deg)",
		"-ms-transform": "rotate(0deg)",
		"-o-transform": "rotate(0deg)",
	  transform: "rotate(0deg)"
	};

	if($("#Sliderbar-content-"+id).css("display")=='none'){
		 $("#Sliderbar-content-"+id).slideDown();
		 $("#Sliderbar-content-"+id).prev().find('i').css(rotate);
	}else{
		 $("#Sliderbar-content-"+id).slideUp();
		 $("#Sliderbar-content-"+id).prev().find('i').css(rotate2);
	 }
}

//ajax评论
function ajaxc(){
		var replyTo = '',   //回复评论时候的ID
		submitButton = $(".submit").eq(0),  //提交评论按钮
		commentForm = $("#comment-form"),   //评论表单
		newCommentId = "";   //新评论的ID
		var bindButton = function () {
			$(".comment-reply a").click(function () {
					replyTo = $(this).parent().parent().parent().attr("id");
			});
			$(".cancel-comment-reply a").click(function () { replyTo = ''; });
	};
		bindButton();

		/**
		 * 发送前的处理
		 */
		function beforeSendComment() {
			$("#comment-loading").fadeIn();
			$(".submit").fadeOut();
			$("#OwO-container").slideUp();
		}

		/**
		 * 发送后的处理
		 * @param {boolean} ok
		 */
		function afterSendComment(ok) {
				if (ok) {
						$("#textarea").val('');
						replyTo = '';
				}
				bindButton();
		}
		$("#comment-form").submit(function () {
				commentData = $(this).serializeArray();
				beforeSendComment();
				$.ajax({
						type: $(this).attr('method'),
						url: $(this).attr('action'),
						data: commentData,
						error: function (e) {
								console.log('Ajax Comment Error');
								window.location.reload();
						},
						success: function (data) {
								if (!$('#comments', data).length) {
										var msg = $('title').eq(0).text().trim().toLowerCase() === 'error' ? $('.container', data).eq(0).text() : '评论提交失败！';

										toastr.warning(msg, 'QAQ');
										$("#comment-loading").fadeOut();
										$(".submit").fadeIn();
										afterSendComment(false);
										return false;
								}

								$("input,textarea", commentForm).attr('disabled', false);
								$("#textarea").val('');

								var newComment;
								newCommentId = $(".comment-list", data).html().match(/id=\"?comment-\d+/g).join().match(/\d+/g).sort(function (a, b) { return a - b }).pop();
								if('' === replyTo) {
										if(!$('.comment-list').length) {
												newComment  = $("#li-comment-" + newCommentId, data);
												$('.comments-header').after('<ol class="comment-list"></ol>');
												$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
										}
										else if($('.prev').length) {
												$('#page-nav ul li a').eq(1).click();
										}
										else {
												newComment  = $("#li-comment-" + newCommentId, data);
												$('.comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
										}
										$('html,body').animate({scrollTop:$('#response').offset().top - 100},1000);
								}
								else {
										newComment = $("#li-comment-" + newCommentId, data);
										if ($('#' + replyTo).find('.comment-children').length) {
												$('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
												TypechoComment.cancelReply();
										}
										else {
												$('#' + replyTo).append('<div class="comment-children"><ol class="comment-list"></ol></div>');
												$('#' + replyTo + ' .comment-children .comment-list').first().prepend((newComment).addClass('animated fadeInUp'));
												TypechoComment.cancelReply();
										}
								}
								afterSendComment(true);

						},
						error:function(){
							$("#comment-loading").fadeOut();
							$(".submit").fadeIn();
						},
						complete:function(){
							toastr.success('送信完了', '发送成功');
							$("#comment-loading").fadeOut();
							$(".submit").fadeIn();
						}
				});
				return false;
		});
}

