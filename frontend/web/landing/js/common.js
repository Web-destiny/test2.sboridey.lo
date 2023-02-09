// $('body').hide()

AOS.init({
	// once: true
	// anchorPlacement: 'top-center',
});
AOS.init({disable: 'mobile'});

$('.mobile-menu__toggler').click(function() {
	$('.page-header').toggleClass('open-mobile');
	$('body').toggleClass('overf');
	$('.page-navigation li a').toggleClass('opened');

	if ($('.page-navigation li a').hasClass('opened')) {
			$('.page-navigation li a').click(function() {
				$('.page-header').removeClass('open-mobile');
				$('body').removeClass('overf');
				$('.page-navigation li a').removeClass('opened');
			})

	}
});

$('.close-mobile-nav').click(function() {
	$('.page-header').toggleClass('open-mobile');
	$('body').toggleClass('overf');
	$('.page-navigation li a').toggleClass('opened');
})


// $('#telephone').on('input', function() {
// 	$(this).val($(this).val().replace(/[A-Za-zА-Яа-яЁё]/, ''))
// });

$(window).scroll(function(){
	let headerHeight = $('header').height();
	if ($(window).scrollTop() >= headerHeight) {
			$('.page-header').addClass('fixed-header');
			// $('main.page-content').css('padding-top', headerHeight );
	}
	else {
			$('.page-header').removeClass('fixed-header');
	}
});

$(function(){
	let swiper_home = new Swiper('.swiper.case-slider', {
		slidesPerView: 1,
		speed: 1000,
		loop: true,
		// autoplay: {
		// 	delay: 4000,
		// 	disableOnInteraction: false,
		// },
		
			navigation: {
				nextEl: '.swiper-button-next__new',
				prevEl: '.swiper-button-prev__new',
			},
	});
});


var element = document.getElementById('phone');
var maskOptions = {
    mask: '+7(000)000-00-00',
    lazy: false
} 
var mask = new IMask(element, maskOptions);

// var element2 = document.getElementById('email');
// var maskOptions2 = {    
//     mask:function (value) {
//                 if(/^[a-z0-9_\.-]+$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@[a-z0-9-]+$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@[a-z0-9-]+\.$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}\.$/.test(value))
//                     return true;
//                 if(/^[a-z0-9_\.-]+@[a-z0-9-]+\.[a-z]{1,4}\.[a-z]{1,4}$/.test(value))
//                     return true;
//                 return false;
//                     },
//     lazy: false
// } 
// var mask2 = new IMask(element2, maskOptions2);