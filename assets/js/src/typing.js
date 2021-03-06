
const TYPE_SPEED = 0;
const PANELS = document.querySelectorAll('.panel');

var panelsArr = [];

if(document.querySelector('.page-template-page-story_layout')) {

	class Panel {

		constructor(int) {

			this.id = int;
			this.el = document.querySelector("#panel-" + this.id);
			this.complete = false;
			this.created = false;
			this.type = "type" in this.el.dataset ? this.el.dataset.type : "typed";
			this.fired = false;

			this.nextTrigger = ((int) => {
				trigger = document.querySelectorAll('#panel-' + int + ' .btn-next');
				return trigger;
			})(this.id);

			// Options for "Typed" panels (most of them)
			if( this.type == "typed" ) {

				// Find source for typing
				this.typedSrc = ((int) => {
					let el = document.querySelector("#panel-" + int + ' .js-typed-src');
					return el;
				})(this.id);

				// Create an element to hold typed content
				this.typedEl = ((int) => {
					let ref = this.typedSrc;
					let div = document.createElement('div');
							div.classList.add('js-typed', 'panel-content');
							div.setAttribute('aria-hidden', 'true');
							insertAfter(ref, div);
					let el = document.querySelector("#panel-" + int + ' .js-typed');
					return el;
				})(this.id);

				// Options for all panels
				this.typedOpts = {
					strings: [this.typedSrc.innerHTML],
					typeSpeed: TYPE_SPEED,
					showCursor: false,
					onComplete: () => {
						showButtons(this.nextTrigger);
						this.complete = true;
					}
				}
			}
		}

		// Setting up Panel Functions
		setUpChildren() {
			let kids = this.el.children;
			let nextPanelId = this.id + 1;
			let nextPanel = this.getNextPanel();

			for (let i = 0; i < kids.length; i++) {
				let kid = kids[i];

				// Single button
				if (kid.classList.contains('btn-next')) {
					kid.setAttribute('href', '#panel-' + nextPanelId);
				}

				// Multiple buttons
				if (kid.classList.contains('js-decision')) {

					// Add hrefs to links within buttons within li's!
					for (let i = 0; i < kid.children.length; i++) {
						kid.children[i].setAttribute('href', '#panel-' + nextPanelId);
					}

					kid.addEventListener('click', (e) => {
						this.complete = true;
						let nextPanel = this.getNextPanel();
						showButtons(nextPanel.nextTrigger);

						let btns = document.querySelectorAll('#panel-' + this.id + ' button');
						btns.forEach((b) => {
							b.classList.remove('js-selected');
						});

						// console.log(nextPanel.nextTrigger);

						for (let i = 0; i < kid.children.length; i++) {
							kid.children[i].classList.remove('js-selected');
						}

						let el = e.target;
						if (el && el.tagName == "BUTTON") {
							let btn = el;
							console.log('hi');
							showTab(nextPanel, btn);
						}
					});
				}
			}
		}

		getNextPanel() {
			let currId = this.id;
			let nextId = currId + 1;

			let nextPanel = panelsArr.find((panel) => {
				return panel.id == nextId;
			});

			return nextPanel;
		}

	}


	PANELS.forEach((el, index) => {

		// Add an id to each panel
		el.id = 'panel-' + index;

		// Create panel obj for each element
		let p = new Panel(index);

		// Mark objects created and set up children (buttons)
		p.created = true;
		p.setUpChildren();

		panelsArr.push(p);
	});


	// Type first panel
	document.addEventListener("DOMContentLoaded", function (event) {
		let firstPanel = panelsArr[0];
		typeIt(firstPanel);
		addScrollListener();
	});

}; // end selector check

function typeIt(panel) {
	panel.fired = true;
	if (!panel.complete && panel.type == "typed") {
		let typed = new Typed(panel.typedEl, panel.typedOpts);
		if( panel.id == 2 ) {
			runBlinkingAnimation("#panel-2 .character-1");
		}
	}
}

function showTab(panel, btn) {
	let tabs = document.querySelectorAll('#panel-' + panel.id + ' .js-tab');
	let type = btn.dataset.contentRef;

	tabs.forEach((tab) => {
		tab.classList.add('js-hidden');

		if (tab.getAttribute('id') == type) {
			tab.classList.remove('js-hidden');
		}
	});

	btn.classList.add('js-selected');
}


// https://stackoverflow.com/questions/29891587/check-if-element-is-between-30-and-60-of-the-viewport
function addScrollListener() {
	var $ = jQuery;
	var timeout;
	$(window).on("load scroll resize", function () {
		if (timeout) {
			clearTimeout(timeout);
		}
		timeout = setTimeout(function () {
			var $window = $(window),
				hitbox_top = $window.scrollTop() + $window.height() * .3,
				hitbox_bottom = $window.scrollTop() + $window.height() * .6;

			$('.panel').each(function () {
				var $element = $(this),
					element_top = $element.offset().top,
					element_bottom = $element.offset().top + $element.height();

					$element.toggleClass("js-active-panel", hitbox_top < element_bottom && hitbox_bottom > element_top);

				});

				PANELS.forEach((el, index) => {

					if( el.classList.contains('js-active-panel') ) {

						// Get panel obj from element if
						let str = el.id;
						let int = str.replace(/[^\d.]/g, '');
						let currPanel = panelsArr.find((currPanel) => {
							return currPanel.id == int;
						});

						// Type panel
						if( !currPanel.fired ) {
							typeIt(currPanel);
						}
					}
				});

			}, 200);



	});
}






// ----
// Panel Helpers
// ----


function showButtons(btn) {
	let tabbed = btn.length > 1;
	if( tabbed ) {
		reveal(btn, true);
	} else {
		reveal(btn);
	}
}

function removeTypedSrc(elem) {
	let srcEl = elem;
	elem.nextSibling.setAttribute("aria-hidden", "false");
	elem.parentNode.removeChild(srcEl);
}



// ----
// Panel Callbacks
// ----

// TODO user closest LATER
function hideLaraPic() {
	// console.log('p1 is done');
	// let toHide = document.querySelector('.js-hide');
	// hide(toHide);
}

function showSkipBtn() {
	let btn = document.querySelector('.js-skipBtn');
	reveal(btn);
}

function showLlamaStuff() {
	const EYE = document.querySelector('#llama .eye'),
		JAW = document.querySelector('#llama .jaw'),
		TAIL = document.querySelector('#llama .tail');

	EYE.classList.add("blinking");
	JAW.classList.add("chewing");
	TAIL.classList.add("flicking");
}




// ----
// General Helpers
// ----

// https://stackoverflow.com/questions/4793604/how-to-insert-an-element-after-another-element-in-javascript-without-using-a-lib
function insertAfter(referenceNode, newNode) {
	referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}

function reveal(el, stagger = false) {
	// Stagger aimation if more than one element comes in.
	if (stagger == true) {
		let tm = new TimelineMax();
		tm.staggerTo(el, .2, { delay: 0.5, transformOrigin: "50% 50%", ease: Power2.easeOut, autoAlpha: 1 }, 0.1);
	} else {
		TweenLite.to(el, .2, { delay: 0.5, transformOrigin: "50% 50%", ease: Power2.easeOut, autoAlpha: 1 });
	}
};

function hide(el) {
	TweenLite.to(el, .2, { delay: 0.5, transformOrigin: "50% 50%", scale: 0, ease: Power2.easeOut, autoAlpha: 0 });
}













// function goToTabbedSection(btn, index) {

// 	let tabs = document.querySelectorAll('#panel-'+(index+1)+' .js-tab');
// 	let btns = document.querySelectorAll('#panel-'+index+' .decision-btns > a');

// 	let getIndex = () => {
// 		return index;
// 	}

// 	btn.addEventListener('click', (e) => {

// 		let index = getIndex();
// 		// markPanelComplete(index);

// 		btns.forEach((b) => {
// 			b.classList.remove('js-selected');
// 		});

// 		let type = btn.dataset.contentRef;
// 		btn.classList.add('js-selected');

// 		tabs.forEach(function (tab) {
// 			tab.classList.add('js-hidden');

// 			if (tab.getAttribute('id') == type) {
// 				tab.classList.remove('js-hidden');
// 			}
// 		});

// 	});
// }
