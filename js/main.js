$("a#toggleMenu").click(function() {
	$("body").toggleClass("mobileNav");
});

$("a#toggleSearch").click(function() {
	$("body").toggleClass("mobileSearch");
	$("#searchBoxFront").find("input").focus();
});


$(this).parent().siblings('div.bottom').find("input.post").focus();


$("a#sectionNavButton").click(function() {
	$(this).next().toggleClass("active");
});

$("div.legendaContainer").click(function() {
	$(this).toggleClass("active");
});

/*
$("li.select-language").click(function() {

	event.stopPropagation()

	console.log("clicked");
	
	current_language = $(".lang-selected").text();
	
	new_language = "<span>" + $(this).data("language")  + "</span>";
	
	//console.log(new_language);
		
	if(current_language.indexOf(new_language) == -1) { 
		$(".lang-selected").append(new_language);
	} else {
		console.log($(".lang-selected").text());
		$(".lang-selected").text().replace(new_language, '');
	}
	
});
*/

// Load dialog on click
$(".legendaContainer h4").click(function (e) {
	$('.legenda').modal();
	e.preventDefault();
});

// functie demo language switch
/* WME (I commented-out checkboxes in header.php too)
$("li.select-language").click(function() {

	
	if( $("#nederlands").is(":checked") && $("#english").is(":checked") )
	{
		$(".lang-selected").text('NL/EN');
		$("header#mainHeader h1#idTag span").css('background-image', 'url(img/logo-deltaexpertise-nl.png)');
	}
	else if( $("#nederlands").is(":checked") )
	{
		$(".lang-selected").text('NL');
		$("header#mainHeader h1#idTag span").css('background-image', 'url(img/logo-deltaexpertise-nl.png)');
	}
	else if( $("#english").is(":checked") )
	{
		$(".lang-selected").text('EN');
		$("header#mainHeader h1#idTag span").css('background-image', 'url(img/logo-deltaexpertise-en.png)');
	}
	else
	{
		$(".lang-selected").text('NL');
		$("header#mainHeader h1#idTag span").css('background-image', 'url(img/logo-deltaexpertise-nl.png)');
	}
	
});
*/
//WME quick fix for logo dependent on selected language
//alert($(".lang-selected").text());
var scriptpath = $("script[src]").last().attr("src").split('?')[0].split('/').slice(0, -1).join('/')+'/';
var indexUrl = scriptpath + 'index.php';		//used in search.js
var nllogo = scriptpath+'skins/deltaskin/img/logo-deltaexpertise-nl.png';
var enlogo = scriptpath+'skins/deltaskin/img/logo-deltaexpertise-en.png';
if( $(".lang-selected").text()=='nl')
{
	$("header#mainHeader h1#idTag span").css('background-image', 'url('+nllogo+')');
}
else if( $(".lang-selected").text()=='en')
{
	$("header#mainHeader h1#idTag span").css('background-image', 'url('+enlogo+')');
}
//End of WME quick fix for logo dependent on selected language

$(function() {
    //$('.context').on( "hover", function() {
    //	alert('hi');
    //    selector = $(this).data('ref');
     //   console.log('selector:' + selector);
    //    $('.context[data-ref="'+selector+'"]').toggleClass('context-hover');
        //console.log('test:' + test);
    //});
});

$(window).load(function() {

	checkHeight();




	/*  Reveal function for displaying large images in content */

	//$('.thumb.tleft').each(function() {
	//
	//	var $this = $(this);
	//	var $maxWidth = $('#page').width();
	//	var $fullWidth = $('#body').width();
	//	var $image = $this.find("img");
	//	var $imageNativeWidth = $image.attr("width");
    //
	//	$this.find('').html('');
    //
	//	if( $imageNativeWidth > $maxWidth ) {
	//		$this.addClass("zoom");
	//	}
    //
	//	$this.css('width', $maxWidth);
    //
	//	if( $this.hasClass('zoom') && $maxWidth >= $fullWidth ) {
	//		$this.addClass("move");
	//	} else {
    //
	//		$this.addClass("slide");
    //
	//		$this.on("click", function() {
    //
	//			if($this.attr('data-toggled') === 'off') {
	//				$this.attr('data-toggled','on');
	//				$this.css('width', $fullWidth);
	//			} else {
	//				$this.attr('data-toggled','off');
	//				$(this).css("width", $maxWidth);
	//			}
	//		});
    //
	//	}
    //
	//});
});
//$('img[usemap]').maphilight();
$(document).load($(window).bind("resize", checkHeight));

function checkHeight() 	{

	$(".breadcrumb").each(function() {
		$this = $(this);
		//console.log($this.height());
		if($this.height() > 80) {
			$this.addClass('breadcrumb--wrap');
		} else {
			$this.removeClass('breadcrumb--wrap');
		}
	});

}

$(".toggle a").click(function() {
	$(this).closest(".breadcrumb").toggleClass("open");
});