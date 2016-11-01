if (window.addEventListener){ // W3C standard
	window.addEventListener('load', revolution, false); // NB **not** 'onload'
}else if (window.attachEvent){ // Microsoft
	window.attachEvent('onload', revolution);
}
function revolution(){
(function() {
	"use strict";
			// Revolution Slider Initialize
			if($(".fullwidthbanner2").get(0)) {
				var rev = $(".fullwidthbanner2").revolution({
					delay:9000,
					startheight:600,//492,
					startwidth:850,

					hideThumbs:10,

					thumbWidth:100,
					thumbHeight:50,
					thumbAmount:5,

					navigationType:"verticalcentered",
					navigationArrows:"verticalcentered",

					touchenabled:"on",
					onHoverStop:"on",

					navOffsetHorizontal:0,
					navOffsetVertical:20,

					stopAtSlide:-1,
					stopAfterLoops:-1,

					shadow:0,
					fullWidth:"on"
				});

				$("#revolutionSlider .tp-caption").on("mousedown", function(e) {
					e.preventDefault();
					rev.revpause();
					return false;
				});

			}
})();
}
