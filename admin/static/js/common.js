$(document).ready(function() {
	$('.sidebar_navigation > ul').superfish({
		pathClass	 : 'overideThisToUse',
		delay		 : 0,
		animation	 : {height: 'show'},
		speed		 : 'normal',
		autoArrows   : false,
		dropShadows  : false, 
		disableHI	 : false, /* set to true to disable hoverIntent detection */
		onInit		 : function(){},
		onBeforeShow : function(){},
		onShow		 : function(){},
		onHide		 : function(){}
	});
	
	// $('#constant > ul').css('display', 'block');
});
 
function getURLVar(key) {
	var value = [];
	
	var query = String(document.location).split('?');
	
	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');
			
			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}
		
		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}
function loadListInfo(url) {
    $.ajax({
        url: url,
        type: 'get',
        dataType: 'html',
        beforeSend:function(){
        	$(".form-content").html('<h3><center>正在加载……</center></h3>');
        },
        success: function(html) {
            $(".form-content").html(html);
            $(".form-content").fadeIn('slow');
        }
    });
}

$(document).ready(function() {
	route = getURLVar('route');
	
	if (!route) {
		$('#dashboard').addClass('selected');
	} else {
		part = route.split('/');
		
		url = part[0];
		
		if (part[1]) {
			url += '/' + part[1];
		}
		
		$('a[href*=\'' + url + '\']').parents('li[id]').addClass('selected');
	}
	
	$('#menu ul li').on('click', function() {
		$(this).addClass('hover');
	});

	$('#menu ul li').on('mouseout', function() {
		$(this).removeClass('hover');
	});
	$(".tabs a").click(function(){
        $(this).parent().parent().children("li").removeClass("active");
        $(this).parent().addClass("active");
        $(".currnentPage").html($(this).attr("type"));
        loadListInfo($(this).attr("url"));
    });
});
