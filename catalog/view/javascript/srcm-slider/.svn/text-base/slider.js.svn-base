function startPageInit() {
	var a = new SRCM;
	window.slider = a
}
(function (a) {
	var b = 235;
	var c = function () {
		var a = this;
		if (!Modernizr.csstransforms3d) {
			this.initSimpleSlider();
			return
		}
		this.defaultValues();
		this.hookInputs();
		$(document).ready(function () {
			setTimeout(function () {
				$("body").addClass("ready");
				$(".slideItem:first").get(0).style[a.transformProp] = "rotateY(0deg) translateZ(-20px) scale3d(1,1,1) translateY(-30px)"
			}, 400)
		});
		this.verticalCenter()
	};
	c.prototype.initSimpleSlider = function () {
		var a = this;
		$("body").addClass("ready");
		this.defaultValues();
		this.hookInputs();
		this.verticalCenter();
		this.horizontalCenter();
		this.slideItems.each(function () {
			var b = $(this).clone().removeClass("selected");
			a.items.append(b)
		});
		this.slideItems = $(".slideItem", this.slider);
		this.slideItems.each(function (c) {
			var d = $(this).get(0);
			d.style.left = b * (a.slideItems.length - c) + "px";
			$(this).attr("id", c)
		});
		var c = a.slideItems.length / 2;
		var d = a.getLeftPosition(c);
		var e = $(window).width();
		var f = 445;
		if (e < 1250) {
			d = d - (f - $(".slideInfo").offset().left) + 25
		}
		a.items.css("marginLeft", d + "px");
		a.slideItems.removeClass("selected").eq(c).addClass("selected");
		a.currentItemIndex = c;
		this.slideItems = $(".slideItem", this.slider)
	};
	c.prototype.getLeftPosition = function (a) {
		return (a - 2) * (b + 2) * -1
	};
	c.prototype.verticalCenter = function () {
		var a = this;
		var b = 808;
		var c = function () {
			var c = $(window).height();
			if (c < b) {
				$(".footer").css({
					position : "relative",
					top : "0px"
				})
			} else {
				$(".footer").css({
					position : "fixed",
					top : "auto"
				})
			}
			a.winHeight = c / 2 - 380;
			if (a.winHeight < 20) {
				a.winHeight = 20
			}
			//a.slider.css("top", a.winHeight + "px");
			a.repaintSlider()
		};
		$(window).bind("resize", c);
		c()
	};
	c.prototype.horizontalCenter = function () {
		var a = this;
		var b = function () {
			var b = a.currentItemIndex + a.currentStepFromCenter;
			var c = a.getLeftPosition(b);
			var d = $(window).width();
			var e = 445;
			if (d < 1250) {
				c = c - (e - $(".slideInfo").offset().left) + 25;
				a.items.css("marginLeft", c + "px")
			}
		};
		$(window).resize(b);
		b()
	};
	c.prototype.repaintSlider = function () {
		var a = this;
		var b = document.width / $(document).width();
		if ((b != 1 || a.prevZoomLevel != b) && !isNaN(b)) {
			setTimeout(function () {
				a.slideItems.stop(true, true).fadeOut("fast");
				setTimeout(function () {
					a.slideItems.fadeIn(50)
				}, 200)
			}, 20);
			a.prevZoomLevel = b
		}
	};
	c.prototype.defaultValues = function () {
		var a = this,
		b = 14,
		c = 0;
		this.transformProp = Modernizr.prefixed("transform");
		var d = {
			WebkitTransform : "webkitTransitionEnd",
			MozTransform : "transitionend",
			OTransform : "oTransitionEnd",
			msTransform : "MSTransitionEnd",
			transform : "transitionend"
		};
		this.transitionEndName = d[this.transformProp];
		this.currentDegree = 0;
		this.currentItemIndex = 0;
		this.isSliding = false;
		this.currentStepFromCenter = 0;
		this.slider = $(".slider");
		this.slideItems = $(".slideItem", this.slider);
		this.slideInfo = $(".slideInfo", this.slider);
		this.items = $(".items", this.slider);
		var e = this.slideItems.length;
		if (e < b) {
			var f = b - e;
			if (f > 2) {
				for (c = 0; c < f; c++) {
					this.items.append($(this.slideItems[c % e]).clone().removeClass("selected"))
				}
			}
		}
		this.slideItems = $(".slideItem");
		e = this.slideItems.length;
		this.itemDegree = 360 / e;
		var g = Math.round(305 / 2 / Math.tan(Math.PI / e));
		this.suffixTransform = " translateZ(-" + g + "px) scale3d(.8,.8, 1)";
		this.slideItems = $(".slideItem", this.slider);
		if (Modernizr.csstransforms3d) {
			this.slideItems.each(function (b) {
				var c = $(this).get(0);
				c.style[a.transformProp] = "rotateY(" + b * a.itemDegree + "deg)" + a.suffixTransform
			})
		}
	};
	c.prototype.hookInputs = function () {
		function b(b) {
			var c = b.index();
			var d = c - a.currentItemIndex;
			if (c == a.currentItemIndex) {
				return
			}
			if (d > 3) {
				d = d - a.slideItems.length
			} else if (d < -3) {
				d = (Math.abs(d) - a.slideItems.length) * -1
			}
			var e = a.currentDegree + d * a.itemDegree * -1;
			a.currentDegree = Math.round(e * 100) / 100;
			a.currentItemIndex = c;
			if (Modernizr.csstransforms3d) {
				a.currentStepFromCenter -= d;
				a.slide()
			} else {
				a.slideInfo.stop(true, true).fadeOut("fast");
				a.currentItemIndex = a.slideItems.length / 2;
				a.currentStepFromCenter = a.currentStepFromCenter - d;
				for (var f = 0; f < Math.abs(d); f++) {
					if (d > 0) {
						a.currentStepFromCenter += 1;
						a.slideLeft(true)
					} else {
						a.currentStepFromCenter -= 1;
						a.slideRight(true)
					}
				}
			}
		}
		var a = this;
		$(".arrowLeft").click(function () {
			a.slideLeft()
		});
		$(".arrowRight").click(function () {
			a.slideRight()
		});
		$(".slideItem").live("click", function () {
			if ($(this).is(".selected")) {
				location.href = $(".slideInfo").attr("href")
			}
			b($(this))
		});
		$(document).keyup(function (b) {
			if (b.keyCode == 39) {
				a.slideRight()
			} else if (b.keyCode == 37) {
				a.slideLeft()
			}
		});
		$(".container").swipe({
			triggerOnTouchEnd : false,
			allowPageScroll : "auto",
			threshold : 5,
			swipeLeft : function () {
				if (a.isSliding) {
					return false
				}
				a.slideRight()
			},
			swipeRight : function () {
				if (a.isSliding) {
					return false
				}
				a.slideLeft()
			}
		})
	};
	c.prototype.slideLeft = function (a) {
		if (this.isSliding && !a) {
			return
		}
		var c = this;
		this.isSliding = true;
		this.currentDegree -= this.itemDegree;
		this.currentStepFromCenter -= 1;
		this.currentItemIndex += 1;
		if (this.currentItemIndex >= this.slideItems.length) {
			this.currentItemIndex = 0
		}
		if (Modernizr.csstransforms3d) {
			c.slide()
		} else {
			var d = $(c.slideItems[0]);
			var e = parseInt(c.slideItems.last().css("left").replace("px", "")) - b;
			c.currentItemIndex = c.slideItems.length / 2;
			d.css("left", e + "px");
			c.slideItems.last().after(d);
			c.slideItems = $(".slideItem", c.slider);
			c.slideInfo.stop(true, true).fadeOut("fast");
			this.items.animate({
				marginLeft : "+=235px"
			}, function () {
				c.slide()
			})
		}
	};
	c.prototype.slideRight = function (a) {
		if (this.isSliding && !a) {
			return
		}
		var c = this;
		this.isSliding = true;
		this.currentDegree += this.itemDegree;
		this.currentStepFromCenter += 1;
		this.currentItemIndex -= 1;
		if (this.currentItemIndex < 0) {
			this.currentItemIndex = this.slideItems.length - 1
		}
		if (Modernizr.csstransforms3d) {
			c.slide()
		} else {
			var d = $(c.slideItems[c.slideItems.length - 1]);
			var e = parseInt(c.slideItems.first().css("left").replace("px", "")) + b;
			c.currentItemIndex = c.slideItems.length / 2;
			d.css("left", e + "px");
			c.slideItems.first().before(d);
			c.slideItems = $(".slideItem", c.slider);
			c.slideInfo.stop(true, true).fadeOut("fast");
			this.items.animate({
				marginLeft : "-=235px"
			}, function () {
				c.slide()
			})
		}
	};
	c.prototype.slide = function () {
		function h() {
			var b = $(a.slideItems[a.currentItemIndex]);
			b.addClass("selected");
			if (Modernizr.csstransforms3d) {
				d = b.get(0).style[a.transformProp];
				f = d.match(e);
				g = f[0];
				b.get(0).style[a.transformProp] = g + " translateZ(-20px) scale3d(1,1,1) translateY(-30px)"
			} else {
				a.slideInfo.fadeIn()
			}
			var c = b.attr("data-sub-header");
			$("h2", a.slideInfo).html(c != "" ? c : " ");
			$("h3", a.slideInfo).html(b.attr("data-header"));
			$("p", a.slideInfo).html(b.attr("data-intro"));
			$(a.slideInfo).attr("href", b.attr("data-link"));
			a.slideInfo.get(0).style[a.transformProp] = "translateY(0px)";
			a.slideInfo.get(0).style.opacity = "1";
			if (Modernizr.csstransforms3d) {
				setTimeout(function () {
					a.isSliding = false
				}, 400)
			} else {
				a.isSliding = false
			}
		}
		var a = this;
		this.isSliding = true;
		var b = $(".slideItem.selected").removeClass("selected");
		if (Modernizr.csstransforms3d) {
			$(".items").get(0).style[a.transformProp] = "rotateY(" + a.currentDegree + "deg)";
			var c = b.get(0);
			if (c != null) {
				var d = c.style[a.transformProp];
				var e = /rotateY\(([\d.\w]+)\)/g;
				var f = d.match(e);
				var g = f[0];
				c.style[a.transformProp] = g + a.suffixTransform
			}
		} else {
			a.slideInfo.fadeIn()
		}
		a.slideInfo.get(0).style[a.transformProp] = "translateY(20px)";
		a.slideInfo.get(0).style.opacity = "0";
		if (Modernizr.csstransforms3d) {
			b.bind(a.transitionEndName, h)
		} else {
			h()
		}
	};
	a.SRCM = c
})(window);
$(function () {
	var a = {};
	if (navigator.userAgent.match(/iPad/i)) {
		a.name = "ipad";
		a.type = "mobile"
	} else if (navigator.userAgent.match(/iPhone/i)) {
		a.name = "iphone";
		a.type = "mobile"
	} else if (navigator.userAgent.match(/android/i)) {
		a.name = "android";
		a.type = "mobile"
	} else {
		a.type = "desktop"
	}
	$("html").addClass(a.name).addClass(a.type)
})
