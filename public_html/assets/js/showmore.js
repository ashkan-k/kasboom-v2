(function($) {
    "use strict";
	$('#container').showmore({
		closedHeight: 250,
		buttonTextMore: 'نمایش بیشتر',
		buttonTextLess: 'بستن',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('#container1').showmore({
		closedHeight: 350,
		buttonTextMore: 'نمایش بیشتر',
		buttonTextLess: 'بستن',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('#container2').showmore({
		closedHeight: 280,
		buttonTextMore: 'نمایش بیشتر',
		buttonTextLess: 'بستن',
		buttonCssClass: 'showmore-button',
		animationSpeed: 0.5
	});
	$('.hide-details').showmore({
		closedHeight: 115,
		buttonTextMore: 'نمایش بیشتر',
		buttonTextLess: 'بستن',
		buttonCssClass: 'showmore-button1',
		animationSpeed: 0.5
	});
	if (document.documentElement.clientWidth < 900) {
		$('#container1').showmore({
			closedHeight: 450,
			buttonTextMore: 'نمایش بیشتر',
			buttonTextLess: 'بستن',
			buttonCssClass: 'showmore-button',
			animationSpeed: 0.5
		});
	}

})(jQuery);