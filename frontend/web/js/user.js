
$(function	()	{
	
	//scroll to top of the page
	$("#scroll-to-top").click(function()	{
		$("html, body").animate({ scrollTop: 0 }, 600);
		 return false;
	});
	
	//scrollable sidebar
	$('.scrollable-sidebar').slimScroll({
		height: '100%',
		size: '0px'
	});
	
	//Sidebar menu dropdown
	$('aside li').hover(
       function(){ $(this).addClass('open') },
       function(){ $(this).removeClass('open') }
	)
	
	//Collapsible Sidebar Menu
	$('.openable > a').click(function()	{	
		if(!$('#wrapper').hasClass('sidebar-mini'))	{
			if( $(this).parent().children('.submenu').is(':hidden') ) {
				$(this).parent().siblings().removeClass('open').children('.submenu').slideUp();
				$(this).parent().addClass('open').children('.submenu').slideDown();
			}
			else	{
				$(this).parent().removeClass('open').children('.submenu').slideUp();
			}
		}
		
		return false;
	});
		
	//Toggle Menu
	$('#sidebarToggle').click(function()	{
		$('#wrapper').toggleClass('sidebar-display');
		$('.main-menu').find('.openable').removeClass('open');
		$('.main-menu').find('.submenu').removeAttr('style');
	});

	$('#sizeToggle').click(function()	{
	
		$('#wrapper').off("resize");
	
		$('#wrapper').toggleClass('sidebar-mini');
		$('.main-menu').find('.openable').removeClass('open');
		$('.main-menu').find('.submenu').removeAttr('style');
		$.cookie('sizeToggle', $('#wrapper').attr('class'), {expires:365,path:'/'});
	});

	if(jQuery.type($.cookie('sizeToggle')) != 'undefined')	{
		$('#wrapper').removeClass('sizeToggle');
		$('#wrapper').addClass($.cookie('sizeToggle'));
	}

	if(!$('#wrapper').hasClass('sidebar-mini'))	{ 
		if (Modernizr.mq('(min-width: 768px)') && Modernizr.mq('(max-width: 868px)')) {
			$('#wrapper').addClass('sidebar-mini');
		}
		else if (Modernizr.mq('(min-width: 869px)'))	{
			if(!$('#wrapper').hasClass('sidebar-mini'))	{
			}
		}
	}

	//show/hide menu
	$('#menuToggle').click(function()	{
		$('#wrapper').toggleClass('sidebar-hide');
		$('.main-menu').find('.openable').removeClass('open');
		$('.main-menu').find('.submenu').removeAttr('style');
	});
	
	$(window).resize(function() {
		if (Modernizr.mq('(min-width: 768px)') && Modernizr.mq('(max-width: 868px)')) {
			$('#wrapper').addClass('sidebar-mini').addClass('window-resize');
			$('.main-menu').find('.openable').removeClass('open');
			$('.main-menu').find('.submenu').removeAttr('style');
		}
		else if (Modernizr.mq('(min-width: 869px)'))	{
			if($('#wrapper').hasClass('window-resize'))	{
				$('#wrapper').removeClass('sidebar-mini window-resize');
				$('.main-menu').find('.openable').removeClass('open');
				$('.main-menu').find('.submenu').removeAttr('style');
			}
		}
		else	{
			$('#wrapper').removeClass('sidebar-mini window-resize');
			$('.main-menu').find('.openable').removeClass('open');
			$('.main-menu').find('.submenu').removeAttr('style');
		}
	});
	
	//fixed Sidebar
	$('#fixedSidebar').click(function()	{
		if($(this).prop('checked'))	{
			$('aside').addClass('fixed');
		}	
		else	{
			$('aside').removeClass('fixed');
		}
	});
	
	//Inbox sidebar (inbox.html)
	$('#inboxMenuToggle').click(function()	{
		$('#inboxMenu').toggleClass('menu-display');
	});
	
	//Collapse panel
	$('.collapse-toggle').click(function()	{
	
		$(this).parent().toggleClass('active');
	
		var parentElm = $(this).parent().parent().parent().parent();
		
		var targetElm = parentElm.find('.panel-body');
		
		targetElm.toggleClass('collapse');
	});
	
	
	//Hover effect on touch device
	$('.image-wrapper').bind('touchstart', function(e) {
		$('.image-wrapper').removeClass('active');
		$(this).addClass('active');
    });
	
	//Dropdown menu with hover
	$('.hover-dropdown').hover(
       function(){ $(this).addClass('open') },
       function(){ $(this).removeClass('open') }
	)
	
	// Popover
    $("[data-toggle=popover]").popover();
	
	// Tooltip
    $("[data-toggle=tooltip]").tooltip();

    //头像提示用户信息
	$('[rel=author]').popover({
	    trigger : 'manual',
        container: 'body',
	    html : true,
        placement: 'auto right',
	    content : '<div class="popover-user"></div>',
	}).on('mouseenter', function(){
	    var _this = this;
	    $(this).popover('show');
	    $.ajax({
	        url: $(this).attr('href'),
	        success: function(html){
	            $('.popover-user').html(html);
                $('.popover .btn-success, .popover .btn-danger').click(function(){
                    $.ajax({
                        url: $(this).attr('href'),
                        success: function(data) {
                            $('.popover .btn-success').text('关注成功').addClass('disabled');
                            $('.popover .btn-danger').text('取消成功').addClass('disabled');
                        },
                        error: function (XMLHttpRequest, textStatus) {
                            $(_this).popover('hide');
                            $('#modal').modal({ remote: '/site/login'});
                        }
                    });
                    return false;
                });
	        }
	    });
	    $('.popover').on('mouseleave', function () {
	        $(_this).popover('hide');
	    });
	}).on('mouseleave', function () {
	    var _this = this;
	    setTimeout(function () {
	        if(!$('.popover:hover').length) {
	            $(_this).popover('hide')
	        }
	    }, 100);
	});
	
});

$(window).scroll(function(){
		
	 var position = $(window).scrollTop();
	
	 //Display a scroll to top button
	 if(position >= 200)	{
		$('#scroll-to-top').attr('style','bottom:16%;');	
	 }
	 else	{
		$('#scroll-to-top').removeAttr('style');
	 }
});
