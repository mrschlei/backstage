(function ($) {
$(document).ready(function() {
	
	$(".mobilebutton").click(function(){
		$(".region-header .globalnav ul").slideToggle("");
		$(".mobilebutton").attr("aria-expanded",$(this).attr("aria-expanded")==="true"?"false":"true");
	});
	$(window).resize(function(){
	//	$(".region-header .globalnav ul").removeAttr("style");
	});
	$(".region-header .globalnav").accessibleDropDown();

	$('div.region.region-sidebar-first.well .block-title').html($('div.region.region-sidebar-first.well .block-title').text().replace($('div.region.region-sidebar-first.well .block-title').text(), '<a href="javascript:link()">'+$('div.region.region-sidebar-first.well .block-title').text()+'</a>'));
	$("div.region.region-sidebar-first.well .block-title").attr("aria-expanded", false).attr("role", "button");
	$("div.region.region-sidebar-first.well .block-title").click(function(){
		$("div.region.region-sidebar-first.well ul.menu.nav").slideToggle("");
		$("div.region.region-sidebar-first.well .block-title").toggleClass('open');
		$("div.region.region-sidebar-first.well .block-title").attr("aria-expanded",$(this).attr("aria-expanded")==="true"?"false":"true");
	});
	$(window).resize(function(){
		$("div.region.region-sidebar-first.well ul.menu.nav").removeAttr("style");
	});

	$('a.dropdown-toggle').removeAttr('data-toggle');
	$('a.dropdown-toggle').removeAttr('data-target');

	$(".field-name-field-faq-expanded-text").prev().addClass("field-name-field-faq-initial-text-clickable");
	$(".field-name-field-faq-expanded-text").prev().removeClass("field-name-field-faq-initial-text");
	$(".field-name-field-faq-expanded-text").hide();
	$(".field-name-field-faq-initial-text-clickable").click(function() {
		$(this).next(".field-name-field-faq-expanded-text").slideToggle();
		$(this).toggleClass("field-name-field-faq-initial-text-clickable-open");
		});

	$(".expand-all-content").click(function() {
		if($(this).html()=='Expand All Content') { $(".field-name-field-faq-initial-text-clickable").addClass("field-name-field-faq-initial-text-clickable-open").next().slideDown(); } else { $(".field-name-field-faq-initial-text-clickable-open").removeClass("field-name-field-faq-initial-text-clickable-open").next().slideUp(); }
		$(this).html($(this).html() == 'Hide All Content' ? 'Expand All Content' : 'Hide All Content');
		});

	$(".click-expanded-text").prev().addClass("click-initial-text-clickable");
	$(".click-expanded-text").prev().removeClass("click-initial-text");
	$(".click-expanded-text").hide();
	$(".click-initial-text-clickable").click(function() {
		$(this).next(".click-expanded-text").slideToggle();
		$(this).toggleClass("click-initial-text-clickable-open");
		});

	$(".click-expand-all-content").click(function() {
		if($(this).html()=='Expand All Content') { $(".click-initial-text-clickable").addClass("click-initial-text-clickable-open").next().slideDown(); } else { $(".click-initial-text-clickable-open").removeClass("click-initial-text-clickable-open").next().slideUp(); }
		$(this).html($(this).html() == 'Hide All Content' ? 'Expand All Content' : 'Hide All Content');
		});
		
	//CLICK-TO-EXPAND TREE UL
	$("ul.expand-tree ul").hide();
	$("ul.expand-tree div").click(function() {
		$(this).next("ul").slideToggle();
		$(this).toggleClass("tree-open");
 		});
	$(".expand-all-tree-content").click(function() {
		if($(this).html()=='Expand All Content')
			{
				$("ul.expand-tree div").addClass("tree-open").next().slideDown();
			} else {
				$("ul.expand-tree div").removeClass("tree-open").next().slideUp();
			}
		$(this).html($(this).html() == 'Hide All Content' ? 'Expand All Content' : 'Hide All Content');
		});
		
	//PROJECT ROLES DESCRIPTIONS
	$(".project-role-managers").hide();
	$(".project-role-group").click(function() {
		$(this).next(".project-role-managers").slideToggle();
		$(this).toggleClass("project-role-group-open");
 		});
	$(".project-role-groups").hide();
	$(".project-role-department").click(function() {
		$(this).next(".project-role-groups").slideToggle();
		$(this).toggleClass("project-role-department-open");
		});
	$(".expand-all-project-content").click(function() {
		if($(this).html()=='Expand All Content')
			{
				$(".project-role-department").addClass("project-role-department-open").next().slideDown();
				$(".project-role-group").addClass("project-role-group-open").next().slideDown();
			} else {
				$(".project-role-department-open").removeClass("project-role-department-open").next().slideUp();
				$(".project-role-group-open").removeClass("project-role-group-open").next().slideUp();
			}
		$(this).html($(this).html() == 'Hide All Content' ? 'Expand All Content' : 'Hide All Content');
		});

	$(".image-zoom").fancybox({		'autoScale'	: true,		'titleShow' : false,		'onClosed': function() {			$("#fancy-content").empty();		}	});	$(".modal-info").fancybox({
		'type'		: 'iframe',
		'autoDimensions': false,
		'autoScale'	: false,
		'width'		: '80%',
		'height'	: '80%',
		'padding'	: 0,
		'scrolling'	: 'auto',
		'titleShow'     : false,
		'onClosed'	: function() {
			$("#fancy-content").empty();
		}
	});
	$("a[rel=gallery]").fancybox({
		'autoScale'	: true,
		'titleShow' : true,
		'titlePosition'	: 'inside',
		'onClosed': function() {
			$("#fancy-content").empty();
		}
	});
	
	$('#acronym-table').filterTable({ 
		inputSelector: '#its-acronym-input-filter'
		});

	$(".answer").hide();
	$(".answer").width($(".question").width());
	$(".question").click(function() {
		$(this).next(".answer").slideToggle();
		$(this).toggleClass("open");
		});
	$("#toggle_all").click(function() {
		//$(".question").toggleClass("open").next().slideToggle();
		var text = $('#toggle_all').text();
		$("#toggle_all").text(
			text == "Show All Answers" ? "Hide All Answers" : "Show All Answers");
		if(text == "Show All Answers") { $(".answer").slideDown(); $(".question").addClass("open"); } else { $(".answer").slideUp(); $(".question").removeClass("open"); }
	});
		$("#edit-search-block-form--2").attr("placeholder", "").val("").focus().blur();
	
	//console.log("test");
	if(document.getElementById('tabs')){
	$('#tabs').responsiveTabs({
    	startCollapsed: 'accordion'
	});
	}
	
});
$.fn.accessibleDropDown = function ()
{
	var el = $(this);
	$("a", el).focus(function() {
		$(this).parents("li").addClass("hover");
		$(this).parents("li").setAttribute("aria-expanded", true);
	}).blur(function() {
		$(this).parents("li").removeClass("hover");
		$(this).parents("li").setAttribute("aria-expanded", false);
	});
}
})(jQuery);

function link() {}
