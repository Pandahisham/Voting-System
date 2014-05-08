$(function() {
	// functions need to be initialize every request
	setActiveMenu();

	$(".profile-basic-credentials .controls .refresh").click(function(){
		var fname = $('input[name="fname"]');
		var mname = $('input[name="mname"]');
		var lname = $('input[name="lname"]');
		var username = $('input[name="username"]');

		var d=$(this).parent().parent().parent();
		b(d);

		getAjax('/profile')
			.success(function(data) {
				$.each(data[0], function(key, value) {
					if(key == 'fname') fname.val(value);
					if(key == 'mname') mname.val(value);
					if(key == 'lname') lname.val(value);
					if(key == 'username') username.val(value);
				});

				c(d);
			})
			.error(function() {
				c(d);
			});

		return false
	});

	$(".profile-picture .controls .refresh").click(function(){
		var image = $('.profile-pic');

		var d=$(this).parent().parent().parent();
		b(d);

		getAjax('/profile')
			.success(function(data) {
				$.each(data[0], function(key, value) {
					if(key == 'image') image.attr('src', value);
				});

				c(d);
			})
			.error(function() {
				c(d);
			});

		return false
	});
});

// sets the active/current menu
function setActiveMenu() {
	var pathname = window.location.pathname;

	if(pathname == '/dashboard') {
		$('a[href="'+ pathname +'"]').parent().addClass('active');
	}

	if(pathname == '/user') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');	
	}

	if(pathname == '/position') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');
	}

	if(pathname == '/course') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');
	}

	if(pathname == '/student') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');
	}

	if(pathname == '/candidate') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');
	}

	if(pathname == '/generate') {
		$('a[href="'+ pathname +'"]').parent().addClass('active').parent().parent().addClass('open active');
	}
}

function getAjax(destination) {
	return $.ajax({ url: destination, type: 'get' });
}

function b(d) {
    $(d).block({
        message: '<div class="el-reloader"></div>',
        overlayCSS: {
            opacity: 0.6,
            cursor: "wait",
            backgroundColor: "#000000"
        },
        css: {
            padding: "5px",
            border: "0",
            backgroundColor: "transparent"
        }
    })
}

function c(d) {
    $(d).unblock()
}