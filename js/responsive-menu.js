/**
 * Responsive menu.
 */
jQuery(function( $ ){

    $(".nav-primary").before('<div class="responsive-menu-icon"></div><div class="responsive-menu-icon-search"></div>');

	$("header .genesis-nav-menu").addClass("responsive-menu");
	
    $(".responsive-menu-icon").click(function(){
       $(".responsive-menu-icon").toggleClass("menu-open");
	   $(".nav-primary").toggleClass("nav-header-show");
       $(".site-header .search-form").removeClass("header-search-show");
    });

    $(".responsive-menu-icon-search").click(function(){
       $(".site-header .search-form").toggleClass("header-search-show");
       $(".nav-primary").removeClass("nav-header-show");
    });

	$(window).resize(function(){
		if(window.innerWidth > 800) {
			$("header .genesis-nav-menu, header .genesis-nav-menu .sub-menu").removeAttr("style");
			$(".responsive-menu > .menu-item").removeClass("menu-open");
			$(".nav-primary").removeClass("nav-header-show");
			$(".site-header .search-form").removeClass("header-search-show");
			$(".responsive-menu-icon").removeClass("menu-open");
		}
	});

	$(".responsive-menu > .menu-item").click(function(event){
		if (event.target !== this)
		return;
			$(this).find(".sub-menu:first").slideToggle("fast",function() {
			$(this).parent().toggleClass("menu-open");
		});
	});

});