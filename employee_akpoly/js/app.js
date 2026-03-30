/* Template Name: Neloz - Responsive Bootstrap 4 Landing Page Template
   Author: Themesdesign
   Version: 1.0.0
   Created: Jan 2019
   File Description: Main js file
*/

(function ($) {

    'use strict';
	// STICKY
	$(window).scroll(function() {
	    var scroll = $(window).scrollTop();

	    if (scroll >= 50) {
	        $(".sticky").addClass("nav-sticky");
	    } else {
	        $(".sticky").removeClass("nav-sticky");
	    }
	});


	// SmoothLink
	$('.nav-item a, .mouse-down a').on('click', function(event) {
	    var $anchor = $(this);
	    var target = $anchor.attr('href');

	    if (!target || target.charAt(0) !== '#' || $(target).length === 0) {
	        return;
	    }

	    var startY = window.pageYOffset;
	    var endY = $(target).offset().top - 20;
	    var distance = endY - startY;
	    var duration = 1200;
	    var startTime = null;

	    function easeInOutCubic(progress) {
	        return progress < 0.5
	            ? 4 * progress * progress * progress
	            : 1 - Math.pow(-2 * progress + 2, 3) / 2;
	    }

	    function animateScroll(currentTime) {
	        if (!startTime) {
	            startTime = currentTime;
	        }

	        var elapsed = currentTime - startTime;
	        var progress = Math.min(elapsed / duration, 1);
	        var easedProgress = easeInOutCubic(progress);

	        window.scrollTo(0, startY + (distance * easedProgress));

	        if (progress < 1) {
	            window.requestAnimationFrame(animateScroll);
	        }
	    }

	    window.requestAnimationFrame(animateScroll);
	    event.preventDefault();
	});


	// scrollspy
	$(".navbar-nav").scrollspy({
	    offset: 70
	});


	//owlCarousel
	$('.owl-carousel').owlCarousel({
	    autoplay:true,
	    autoplayTimeout:3000,
	    loop:true,
	    margin:10,
	    nav:true,
	    responsive:{
	        0:{
	            items:1
	        },
	        600:{
	            items:2
	        },
	        1000:{
	            items:3
	        }
	    }
	})

	// contact

	$('#contact-form').submit(function() {

	    var action = $(this).attr('action');

	    $("#message").slideUp(750, function() {
	        $('#message').hide();

	        $('#submit')
	            .before('')
	            .attr('disabled', 'disabled');

	        $.post(action, {
	                name: $('#name').val(),
	                email: $('#email').val(),
	                comments: $('#comments').val(),
	            },
	            function(data) {
	                document.getElementById('message').innerHTML = data;
	                $('#message').slideDown('slow');
	                $('#cform img.contact-loader').fadeOut('slow', function() {
	                    $(this).remove()
	                });
	                $('#submit').removeAttr('disabled');
	                if (data.match('success') != null) $('#cform').slideUp('slow');
	            }
	        );

	    });

	    return false;

	});

	// loader
	$(window).on('load', function() {
	    $('#status').fadeOut();
	    $('#preloader').delay(350).fadeOut('slow');
	    $('body').delay(350).css({
	        'overflow': 'visible'
	    });
	});
	
})(jQuery)
