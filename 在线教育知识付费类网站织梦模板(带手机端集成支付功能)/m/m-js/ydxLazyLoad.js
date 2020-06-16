/**
*	图片延迟加载插件
*   @author ydx
 *   2015.5.19
*/
(function(window, $){
	//图片延迟加载实现函数
	var YdxLazyLoad = function(window, $) {
		//默认参数
		var defaultOption = {
				threshold: 0, //灵敏度
	            failure_limit : 0,
	            event: "scroll resize", //触发事件
	            effect: "fadeIn", //显示模式，支持jquery所有显示方式
	            container: window, //容器
	            effectTime: 300, //图片显示时间
	            callback: null //图片显示后执行的回调函数
			};

		//option参数管理器
		var optionHandel = {
			//设置参数对象
			setOption : function(element, opt) {
				return element.data("_YdxLazyLoadOption_", opt);
			},

			//获取参数对象
			getOption : function(element) {
				return element.data("_YdxLazyLoadOption_");
			},

			//删除对象参数
			removeOption : function(element) {
				return element.removeData("_YdxLazyLoadOption_");

			}
		};
		

		//判断图片元素位置
		var checkPosition = {
			////判断是否在纵向滚动条之上
		    above : function(element) {
		        var fold, 
					$window = $(window),
					option = optionHandel.getOption(element);
		        
		        if (option.container === undefined || option.container === window) {
		            fold = $window.height() + $window.scrollTop();
		        } else {
		            fold = $(option.container).offset().top + $(option.container).height();
		        }

		        return fold >= $(element).offset().top + option.threshold;
		    },

			//判断是否在纵向滚动条之下
			below : function(element) {
		        var fold, 
					$window = $(window),
					option = optionHandel.getOption(element);
		        
		        if (option.container === undefined || option.container === window) {
		            fold = $window.height() + $window.scrollTop();
		        } else {
		            fold = $(option.container).offset().top + $(option.container).height();
		        }

		        return fold <= $(element).offset().top - option.threshold;
			},

			//判断是否在横向滚动条左侧
		    left : function(element) {
		        var fold, 
					$window = $(window),
					option = optionHandel.getOption(element);
		        
		        if (option.container === undefined || option.container === window) {
		            fold = $window.width() + $window.scrollLeft();
		        } else {
		            fold = $(option.container).offset().left + $(option.container).width();
		        }

		        return fold >= $(element).offset().left + option.threshold;
		    },

		    //判断是否在横向滚动条右侧
		    right : function(element) {
		        var fold, 
					$window = $(window),
					option = optionHandel.getOption(element);

		        if (option.container === undefined || option.container === window) {
		            fold = $window.width() + $window.scrollLeft();
		        } else {
		            fold = $(option.container).offset().left + $(option.container).width();
		        }

		        return fold <= $(element).offset().left - option.threshold;
		    },

		    flag : function(element) {
				var option = optionHandel.getOption(element);
				return !$.rightoffold(element, element) && !$.leftofbegin(element, element) &&
					   !$.belowthefold(element, element) && !$.abovethetop(element, element);
		    }
		};

		function showImg() {
			var $this = $(this),
				opt = optionHandel.getOption($this);
			if (!opt.isLoad) {
				var currentImgSrc = opt.src || $this.attr("lazyLoadSrc");
				$(new Image()).attr("src", currentImgSrc).load([opt, $this], function(e) {
					var para = e.data,
						opt = para[0],
						element = para[1];
					element.attr("src", currentImgSrc).hide()[opt.effect](opt.effectTime);
					opt.isLoad = true;
					opt.callback && opt.callback.call(element, currentImgSrc);
					$(this).unbind("load");
					opt.onShow && opt.onShow.call(element);
				});
			}
		}

		//初始化控件
		function init() {
			//默认有lazyLoadSrc属性的都添加延迟加载
			$("[lazyLoadSrc]:visible").each(function(i, element) {
				add($(element));
			});
		}

		/**
		* 添加延迟加载绑定
		* @参数 element: 被绑定的元素
		*		opt: 设置参数
		*/		
		function add(element, opt) {
			if (optionHandel.getOption(element)) {
				return;
			}
			//element.load([opt],function(e) {
				//var opt = e.data[0],
				//	element = $(this);
				//合并参数
			opt = $.extend(true, {}, defaultOption, opt);

			//将参数保存到data中，同时绑定显示图片事件
			optionHandel.setOption(element, opt).bind("showImg", showImg);

			var $container = $(opt.container), 
				containerData = {elementMap : {}, num : 0};
			//初始化容器的存储数据
			if (!$container.data("_YdxLazyLoad_container_")) {
				$container.data("_YdxLazyLoad_container_", containerData);
			} else {
				containerData = $container.data("_YdxLazyLoad_container_");
			}

			//将元素保存到容器存储数据中
			opt._index = containerData.num;
			containerData.elementMap[containerData.num++] = element;

			//判断容器是否已绑定事件
			if (!containerData.isBind || containerData.event !== opt.event) {
				$container.bind(opt.event, function(e){
					var data = $(this).data("_YdxLazyLoad_container_"),
						elementMap = data.elementMap;

					//循环判断元素是否满足显示要求
					$.each(elementMap, function(key, el) {
						if (el.data("_YdxLazyLoadOption_")) {
							if (checkPosition.above(el) && checkPosition.left(el)) {
								el.trigger("showImg");
								delete elementMap[key];
							}
						} else {
							delete elementMap[key];
							el.remove();
						}
					});
					return false;
				});
				//标识容器已绑定事件
				containerData.isBind = true;
				containerData.event = opt.event;
			}
			//手动触发一次绑定事件
			$.each(opt.event.split(" "), function(i, event) {
				if (event === 'scroll') {
					var e = $.Event(event, {scrollTop: $('body').scrollTop()});
					$container.trigger(e);
					return;
				}				  
				$container.trigger(event);
			});

				//删除load绑定
				//element.unbind("load");
			//})
		}

		/**
		* 删除延迟加载绑定
		* @参数 element: 被绑定的元素
		*/
		function remove(element) {
			var opt = optionHandel.getOption(element);
			//删除对应容器中的映射关系
			delete $(opt.container).data("_YdxLazyLoad_container_").elementMap[opt._index];
			//删除元素中的_YdxLazyLoadOption_数据
			optionHandel.removeOption(element);
		}

		return {
			init : init,
			add : add,
			remove : remove
		};

	}(window, $);
	

	//
	$.fn.YdxLazyLoad = function(opt) {
		return this.each(function() {
			switch($.type(opt)) {
				//不传入参数或者为json对象，则进行add操作
				case "undefined":
				case "object": 
				YdxLazyLoad.add($(this), opt);
				break;
				//传入参数为string类型，则判断为方法调用
				case "string":
				var args = Array.prototype.slice.call(arguments, 1);
				args.unshift($(this));
				YdxLazyLoad[opt].call(YdxLazyLoad, args);
				break;
			}	
		});	
	};	
})(window, jQuery)	

	
