/*
HTML5+APP 混合APP 定制播放器  
http://www.html5-app.com/
联系QQ: 2564034335
DATA:2019-03-07
*/

(function(window,document)
	{
		var AppH5Video=function(videoID,options)
		 {
			 if(!(this instanceof AppH5Video))
			 {return new AppH5Video(videoID,options);}
						// 参数合并  
						this.options=this.extend({ 
						autoplay:false, //是否自动播放视频
						showfull:true, //是否显示全屏按钮
						fakefull:false,//true开启假全屏模式,false 恢复默认全屏模式
						loop:false,//是否循环媒体 
						back:true,
						drag:true //是否开启左右滑动快进后退功能
						},options);
						// 判断传进来的是DOM还是字符串  
						if((typeof videoID)==="string")
						{  
						this.video=document.getElementById(videoID); 
						}else{
						this.video=videoID;	
						}
						var _this=this;
							_this.useFakeFullscreen=this.options.fakefull;
							_this.player=new MediaElementPlayer(videoID,{
							showPosterWhenEnded:true,
							clickToPlayPause:false ,
							useFakeFullscreen:_this.useFakeFullscreen, 
							controlsTimeoutDefault:1000,
							useIOSFullscreen:_this.useFakeFullscreen,
							autoRewind:false,
							features:["fullscreen"],
							keyActions:[],
							success:function (media,videodom){
								_this.mediadom=media; 
								videodom.style.display="";	
							}
							}
							);
						this.dom=document;	
						this.container=this.dom.querySelector(".mejs__container");
						var layers=document.createElement("div");
						layers.className="mediae-layers";
						layers.innerHTML='<div class="mediae-icon-list"><span class="mediae-icon-last"></span><span class="mediae-icon-play"></span><span class="mediae-icon-next"></span><p id="mediae_Time_show"><span id="mediae_currentTime_one">00:00</span> / <span id="mediae_duration_one">00:00</span></p> </div><span class="mediae-icon-full"></span><p id="mediae-title"></p><span id=返回 <span id=返回 class="mui-icon mui-icon-left-nav mui-pull-left" style="color:#FFFFFF;padding:10px 0px 0px 5px;"></span>';
						this.container.querySelector(".mejs__inner").appendChild(layers);
						var randiv=document.createElement("div");
						randiv.className="mediae-controls";
						randiv.innerHTML='<span id="mediae_currentTime_two">00:00</span><span class="range-span-controls"> <input type="range" id="mui-range" value="0" min="0" max="100" ><span id="range-load"><span class="range-lk"></span> <span class="range-lp"></span> </span></span><span id="mediae_duration_two">00:00</span>';
						this.container.appendChild(randiv); 
						var loading=document.createElement("div");
						    loading.className="mediae-loading";
							loading.innerHTML='<div><span class="mediae-loading-icon"></span></div> ';
					    var dragtimewrap=document.createElement("div");
						    dragtimewrap.className="mediae-dragtime-wrap";
						var dragtime=document.createElement("span");
						    dragtime.className="mediae-dragtime";
							dragtime.innerHTML="";
						
						var adjust=document.createElement("div");
							adjust.className="mediae-adjust";
							adjust.innerHTML='<div class="mediae-left-volume"><span class="mediae-left-volume-icon"></span> <span class="mediae-left-volume-rand"><i></i></span>  <span class="mediae-left-volume-icon mediae-left-volume-min"> </span>  </div>\
							<div class="mediae-right-brightness"><span class="mediae-right-brightness-icon"></span> <span class="mediae-right-brightness-rand"><i></i></span>  <span class="mediae-right-brightness-icon mediae-right-brightness-min"> </span>  </div>';
	                    this.container.appendChild(adjust);
						this.vol_left=adjust.querySelector(".mediae-left-volume");
						this.brig_right=adjust.querySelector(".mediae-right-brightness");
						dragtimewrap.appendChild(dragtime);	
						this.dragtime=dragtime;
						this.dragtimewrap=dragtimewrap;
						this.loading=loading;
						
						this.container.appendChild(loading); 
						this.container.appendChild(dragtimewrap); 
						this.mediae_duration_one=this.container.querySelector("#mediae_duration_one");
						this.mediae_duration_two=this.container.querySelector("#mediae_duration_two");
						this.mediae_currentTime_one=this.container.querySelector("#mediae_currentTime_one");
						this.mediae_currentTime_two=this.container.querySelector("#mediae_currentTime_two");
						this.mediaetitle=this.container.querySelector("#mediae-title");
						this.nextBut=this.container.querySelector(".mediae-icon-next");
						this.lastBut=this.container.querySelector(".mediae-icon-last");
						this.range=this.container.querySelector(".mediae-controls input[type=range]");
						this.rangelk=this.container.querySelector(".range-lk"); //进度条
						this.rangelp=this.container.querySelector(".range-lp"); //缓冲条
						this.layers=layers;
						this.wrap=randiv;
						this.isture=false;
						this.isnextState=false;
						this.islastState=false;
						this.isfull=false;
						this.memory=false;
						this.memoryVideoID="";
						this.init();
		           }				
						AppH5Video.prototype={
						init:function() 
						 {
							 this.event();
						 },
						 extend:function(obj,obj2)  //参数合并 
						 {
						 for(var k in obj2){  
						 obj[k] = obj2[k];  
						 }  
						 return obj;  
						 }
						 ,setPlay:function(data)
						 {   var _this=this;
							 if(this.options.autoplay)
							 {
							 this.video.setAttribute("autoplay","autoplay"); 
							 }
							 if(this.options.loop)
							 {
							 this.video.setAttribute("loop","loop"); 
							 }
							 
							var loop=this.container.querySelector(".mediae-icon-play").classList.contains("loop");
							if(loop)
							{
							this.container.querySelector(".mediae-icon-play").classList.remove("loop");   
							}
							 
							 if(data.memoryVideoID)
							 {
							 if(data.memoryVideoID!="")
							 { 	
							 this.memoryVideoID=data.memoryVideoID; 
							 if(localStorage.getItem(data.memoryVideoID))
							 {  setTimeout(function(){
							     var mvideotime=localStorage.getItem(data.memoryVideoID);
								// console.log("mvideotime011:"+mvideotime);
							     mvideotime=JSON.parse(mvideotime);
							 	 _this.mediae_currentTime_one.innerHTML=_this.Second(mvideotime[0]);
							 	 _this.range.value=mvideotime[1];
							 	_this.range.style.backgroundSize=""+mvideotime[1]+"% 100%"; 
							 	_this.rangelk.style.width=""+mvideotime[1]+"%"; 
								},1000); 
							 }
							 }
							 }else{
							 this.memoryVideoID=""; 
							 }
							 this.memory=false;
							 this.video.setAttribute("poster",data.poster);
							 this.video.setAttribute("src",data.src);
							 this.player.setPoster(data.poster); 
							 this.player.setSrc(data.src);
							 
							 this.mediaetitle.innerHTML=data.title;
							 this.mediae_duration_one.innerHTML=data.duration;
							 this.mediae_duration_two.innerHTML=data.duration;

						 },next:function(fu){
							    var _this=this;
								this.nextBut.classList.add("show");
								this.isnextState=true;
								this.nextBut.addEventListener("tap",function(){	
									if(!_this.isnextState)
									{
									 return;
									}
									_this.setRange();
									fu();
								});	
									
						 },last:function(fu){
							    var _this=this;
								this.lastBut.classList.add("show");
								this.islastState=true;
								this.lastBut.addEventListener("tap",function(){
									if(!_this.islastState)
									{
									 return;
									}
									_this.setRange();
									fu();
								});			
						 },
						 setRange:function(){
							var _this=this;
							_this.video.setAttribute("autoplay","autoplay"); 
							if(_this.isfull)
							{
							_this.wrap.style.display="none";	
							}
							_this.isture=true;
							_this.range.value=0;
							_this.range.style.backgroundSize="0% 100%"; 
							_this.rangelk.style.width="0%";
							_this.rangelp.style.width="0%";
							_this.range.style.display="none";  
						 },
						 nextButState:function(bool)
						 {   this.isnextState=bool;
							 if(bool)
							 {
							 this.nextBut.classList.add("show");
							 }else{
							 this.nextBut.classList.remove("show");
							 } 
						 },
						 lastButState:function(bool)
						 {   this.islastState=bool;
							 if(bool)
							 {
							 this.lastBut.classList.add("show");
							 }else{
							 this.lastBut.classList.remove("show");
							 } 
						 },innerHTML:function(html)
						 {
							 var div=document.createElement("div");
							     div.innerHTML=html;
							 this.layers.appendChild(div); 
						 },
						 Media:function()
						 {
						 return this.player; 
						 },
						 Video:function()
						 {
						 return this.video; 
						 },
						 MediaDom:function()
						 {
						 return this.mediadom; 
						 },
						 hide:function()
						 {
							this.range.style.display="none";
							this.layers.style.display="none";
							this.wrap.style.display="none";	
						
						 },
						 setloading:function(bool){
							 if(bool)
							 {
							 this.loading.style.display="block";
							 this.wrap.style.display="none";
							 }else{
							this.loading.style.display="none"; 	 
							 } 
						 },orientation:function(fn01,fu02)
						 {
							 //监听是否全屏,安卓有效
							 	document.addEventListener('webkitfullscreenchange', function() 
							 	{
							 	var el = document.webkitFullscreenElement; //获取全屏元素
							 	if(el) 
							 	{
							 	fn01();
								//锁死屏幕方向为横屏			
							 	} 
							 	else
							 	{   	
							 	fn02();
							 	}
								}); 
							 	//监听IOS是否横竖屏 
							 	document.addEventListener('orientationchange', function() 
							 	{
							 	if(window.orientation==180||window.orientation==0)
							 	{
							 	fn02();
							 	}
							 	if(window.orientation==90||window.orientation==-90){
							 	//横屏状态
								fn01();
							 	}
							 	}); 
						 }
						 ,event:function()
							{  
							var _this=this;
							var video=this.video;
							var player=this.player;
							var container=this.container;
							var range=this.range;
							var layers=this.layers;
							var mediae_duration_one=this.mediae_duration_one;
							var mediae_duration_two=this.mediae_duration_two;
							var mediae_currentTime_one=this.mediae_currentTime_one;
							var mediae_currentTime_two=this.mediae_currentTime_two;
				
							//var isfull=_this.isfull;
							var timeout=null;
							var hasError=false;
							var iswait=false;
							var playstate=false;
							if(this.options.autoplay)
							{
							range.style.display="none";	
							layers.style.display="none";
							}
							if(!this.options.showfull)
							{
							container.querySelector(".mediae-icon-full").style.display="none";	
                            }
							
							if(!this.options.showfull)
							{
							container.querySelector(".mediae-icon-full").style.display="none";	
							}
							if(!this.options.back)
							{
							container.querySelector(".mediae-icon-back").style.display="none";		
							}
							//container.querySelector(".mediae-icon-back").addEventListener('tap', function (e) {
							//	mui.back();	
							//});
							
							//点击视频
							container.addEventListener('tap', function (e) {
								
							if(_this.loading.style.display=="block")
							{
								return;	
						    }
								
							if(hasError)
							{  container.querySelector(".mejs__overlay-error").parentNode.style.display="none";
							player.load();
							setTimeout(function(){
							if(hasError)
							{
							container.querySelector(".mejs__overlay-error").parentNode.style.display="block";		 
							} 
							},200);
							return; 
							}
							var dis=container.querySelector(".mejs__overlay-loading").parentNode.style.display;
							if(iswait || dis=="")
							{
							return;	
							}
							showcl();
							}); 
							
							if(this.options.drag)
							{
							  this.touch();
							}
							
							//一打开让滑条归零
							setTimeout(function(){
							if(_this.memoryVideoID!="")
							{ 				
							if(!localStorage.getItem(_this.memoryVideoID))
							{
							range.value=0;
							}
							}
							},180);
							var rangelk=this.rangelk;
							var rangelp=this.rangelp;
							var range=this.range;
							var mediaeTitle=this.mediaetitle;
							//监测视频播放进度，让进度条走起来
							video.addEventListener("timeupdate", function(e)
							{
							var val=0;	
							if(!_this.isture)
							{
							val = (100 /video.duration) *video.currentTime;
							range.value=val;
							range.style.backgroundSize=""+val+"% 100%"; 
							rangelk.style.width=""+val+"%"; 

							}
							var times=_this.Second(video.currentTime);
							mediae_currentTime_one.innerHTML=times;
							mediae_currentTime_two.innerHTML=times;
							setProgressRail(e);
							var times=_this.Second(video.duration);
							if(times.indexOf("NaN")<0)
							{
							mediae_duration_one.innerHTML=times
							mediae_duration_two.innerHTML=times;
							}
							//console.log("_this.memoryVideoID:"+_this.memoryVideoID+"  "+_this.memory);
							if(_this.memoryVideoID!="" && _this.memory)
							{
								
							 if(isNaN(parseInt(val)))
							 {
							  val=0;
							 }
							//console.log("_this.memoryVideoID:"+_this.memoryVideoID+"  "+parseInt(val));
							 localStorage.setItem(_this.memoryVideoID,"["+video.currentTime+","+parseInt(val)+"]");
							}
							
							
							});
							
							video.addEventListener('play', function () {
								//range.value=0;
								//range.style.backgroundSize="0% 100%"; 
								//rangelk.style.width="0%"; 
								range.style.display="none";
								layers.style.display="none";
							
								if(_this.memoryVideoID!="")
								{ 			
								if(localStorage.getItem(_this.memoryVideoID) && !_this.memory)
								{
								//	console.log("_this.memoryVideoID--------------:"+_this.memoryVideoID+"  "+_this.memory);
									_this.memory=true;
								var mvideotime=localStorage.getItem(_this.memoryVideoID);
								    mvideotime=JSON.parse(mvideotime);
									if(mvideotime[0]<video.duration)
									{
									_this.player.setCurrentTime(mvideotime[0]);
									 mediae_currentTime_one.innerHTML=_this.Second(mvideotime[0]);
									_this.range.value=mvideotime[1];
									_this.range.style.backgroundSize=""+mvideotime[1]+"% 100%"; 
									_this.rangelk.style.width=""+mvideotime[1]+"%"; 
									}
								}else if(!localStorage.getItem(_this.memoryVideoID))
								{
									_this.memory=true;
								}
								
								}
								
							});
							
							
							function setProgressRail(e) {
							var  target;
							if(e !== undefined)
							{ 
							target=e.target;
							}else{
							target=video;
							}
							var percent = null;
							if (target && target.buffered && target.buffered.length > 0 && target.buffered.end && video.duration) {
							percent = target.buffered.end(target.buffered.length - 1) / video.duration;
							} else if (target && target.bytesTotal !== undefined && target.bytesTotal > 0 && target.bufferedBytes !== undefined) {
							percent = target.bufferedBytes / target.bytesTotal;
							} else if (e && e.lengthComputable && e.total !== 0) {
							percent = e.loaded / e.total;
							}
							if (percent !== null) {
							percent = Math.min(1, Math.max(0, percent));
							var val=percent*100;
							rangelp.style.width=""+parseFloat(val)+"%";	
							}
							}
							

							video.addEventListener('error', function (e) {

							range.style.display="none";
							setTimeout(function(){
							layers.style.display="block";
							layers.style.background='none';
							container.querySelector(".mediae-icon-list").style.display="none";
							container.querySelector(".mediae-icon-full").style.display="none";
							},500);
							
						
							hasError = true;
							});  
							video.addEventListener('waiting', function () {
								iswait=true;
							});

							video.addEventListener('playing', function () {
							layers.style.background='rgba(0, 0, 0, 0.48)';	
							container.querySelector(".mediae-icon-list").style.display="block";	
							container.querySelector(".mediae-icon-full").style.display="block";
							
							hasError = false;
							playstate=true;
							iswait=false;
							_this.isture=false;
							_this.loading.style.display="none";
							
						   var loop=container.querySelector(".mediae-icon-play").classList.contains("loop");
							   if(loop)
							   {
								container.querySelector(".mediae-icon-play").classList.remove("loop");   
							   }
							container.querySelector(".mediae-icon-play").classList.add("pause");
							_this.wrap.style.display="block";
							if(_this.isfull)
							{	
							_this.wrap.style.display="none";	
							}
							if(_this.memoryVideoID!="" && !_this.options.autoplay)
							{ 				
							if(localStorage.getItem(_this.memoryVideoID) && !_this.memory)
							{
							_this.memory=true;
							var mvideotime=localStorage.getItem(_this.memoryVideoID);
							//console.log("mvideotime:"+mvideotime);
							mvideotime=JSON.parse(mvideotime);
							if(mvideotime[0]<video.duration)
							{
							_this.player.setCurrentTime(mvideotime[0]);
							mediae_currentTime_one.innerHTML=_this.Second(mvideotime[0]);
							_this.range.value=mvideotime[1];
							_this.range.style.backgroundSize=""+mvideotime[1]+"% 100%"; 
							_this.rangelk.style.width=""+mvideotime[1]+"%"; 
							}
							}
							}
							

							});
							
							video.addEventListener('pause', function () {
							container.querySelector(".mediae-icon-play").classList.remove("pause");	
								
							});
							
							
							video.addEventListener('play', function () {
							hasError = false;
							});

							//媒体数据加载完成，获得视频总时间，获得总时间有点慢
							video.addEventListener("loadedmetadata", function()
							{
							hasError = false;
							var time=_this.Second(video.duration);
							if(time.indexOf("NaN")<0)
							{
							mediae_duration_one.innerHTML=time;
							mediae_duration_two.innerHTML=time;
							}
							
							});

							video.addEventListener("ended", function()
							{
							//video.pause();
							container.querySelector(".mediae-icon-play").classList.add("loop");

							setTimeout(function(){
							range.style.backgroundSize="100% 100%";
							rangelk.style.width="100%";  
							},180);
                            container.querySelector(".mejs__poster-img").parentNode.style.display='';
							layers.style.display="block";
							range.style.display="none";
							});

							range.addEventListener("input", function()
							{ 
							
							_this.isture=true;
							var val=this.value;
							range.style.backgroundSize=""+val+"% 100%";
							rangelk.style.width=""+val+"%";
							var time=video.duration*(val / 100);
							if(playstate)
							{
                            _this.dragtimewrap.style.display='block';
						    _this.dragtime.innerHTML=_this.Second(time)+" / "+_this.Second(video.duration);
							}
							
						   
							});
							
							//进度条事件，当拖动进度条时，让它在当前时间开始播放
							range.addEventListener("change", function()
							{
							_this.isture=false;
							_this.dragtimewrap.style.display='none';
							var val=this.value;
							range.style.backgroundSize=""+val+"% 100%";
							rangelk.style.width=""+val+"%";
							if(video)
							{
							var time=video.duration*(this.value / 100);
							//console.log("dd--:"+time);
							//video.currentTime=time;
							if(!isNaN(parseInt(time)))
							{
							_this.player.setCurrentTime(time);
							}
							
							}

							setTimeout(function(){
							
							range.style.display="none";
							
							},5000);
							
							});

							container.querySelector(".mediae-icon-play").addEventListener("tap",function(){

							showcl();
							if (video.paused || video.ended) //当暂停或结束
							{
							player.play();
							if(this.classList.contains("loop"))
							{
							this.classList.remove("loop");
							}
							this.classList.add("pause");
							
							}
							else //否则暂停播放
							{
							player.pause(); 
							this.classList.remove("pause");

							}

							});
							//点击全屏

							container.querySelector(".mediae-icon-full").addEventListener("tap",function(){

							isfullshow();
							});

							var isfullshow=function(){
                  
							if(_this.isfull)
							{
							if(mui.os.android && !_this.useFakeFullscreen)
							{
							plus.screen.lockOrientation('portrait-primary'); //锁死屏幕方向为竖屏	
							}	
							fullclose("");
							
							player.exitFullScreen();
							_this.isfull=false;
							}else{
							if(mui.os.android && !_this.useFakeFullscreen)
							{
							plus.screen.lockOrientation('landscape'); //锁死屏幕方向为横屏		
							}	
						
                            fullclose("landscape");
							player.enterFullScreen();
							_this.isfull=true;
							}
							}

							var showcl=function()
							{
								
							range.style.display="block";	
							layers.style.display="block";
							_this.wrap.style.display="inline-block";	
							if(timeout!=null)
							{ 
							return;  
							}

							timeout=setTimeout(function(){
							if(!_this.isture)
							{
							range.style.display="none";
							layers.style.display="none";

							if(_this.isfull)
							{
							_this.wrap.style.display="none";	
							}else{
							_this.wrap.style.display="inline-block";		
							}

							}
							clearTimeout(timeout);
							timeout=null;
							},5000);
							
							}
							//监听是否全屏,安卓有效
							document.addEventListener('webkitfullscreenchange', function() 
							{
							var el = document.webkitFullscreenElement; //获取全屏元素
							if(el) 
							{
							if(mui.os.plus)
							{
						//	plus.navigator.setFullscreen(true);
							if(!_this.useFakeFullscreen)
							{
							plus.screen.lockOrientation('landscape'); //锁死屏幕方向为横屏
							}
							_this.mediaetitle.style.width="70%";
							fullclose("landscape");
							}					
							} 
							else
							{   	
							if(mui.os.plus)
							{ 
                            _this.mediaetitle.style.width="40%";
						//	plus.navigator.setFullscreen(false);
							if(!_this.useFakeFullscreen)
							{	
							plus.screen.lockOrientation('portrait-primary'); //锁死屏幕方向为竖屏
							}
							fullclose("portrait-primary");
							}						
							}
							}); 

							//监听IOS是否横竖屏 
							document.addEventListener('orientationchange', function() 
							{
							if(window.orientation==180||window.orientation==0)
							{
							_this.mediaetitle.style.width="40%";	
							fullclose("portrait-primary");
							}
							if(window.orientation==90||window.orientation==-90){
							//横屏状态
							_this.mediaetitle.style.width="70%";
							fullclose("landscape");

							}
							}); 

							var fullclose=function(type)
							{
							if(type=="landscape")
							{
							_this.isfull=true;
							container.querySelector(".mediae-icon-full").classList.add("fullclose");
							_this.wrap.style.bottom="20px";
							//container.querySelector(".mediae-icon-back").style.display="none";
							document.getElementById("返回").style.display="none";
							container.querySelector(".range-span-controls").classList.add("range-span-full");
							mediae_currentTime_two.style.display="inline-block";
							mediae_duration_two.style.display="inline-block";
							container.querySelector("#mediae_Time_show").style.display="none";
							mediaeTitle.style.display="inline-block";
							layers.style.display="none";
							_this.wrap.style.display="none";
							_this.dragtimewrap.style.bottom="15%";
							}else{
							_this.isfull=false;
							mediaeTitle.style.display="none";
							//container.querySelector(".mediae-icon-back").style.display="";
							document.getElementById("返回").style.display = "";
							container.querySelector("#mediae_Time_show").style.display="block";
							mediae_currentTime_two.style.display="none";	
							mediae_duration_two.style.display="none";
							container.querySelector(".mediae-icon-full").classList.remove("fullclose");	
							container.querySelector(".range-span-controls").classList.remove("range-span-full");
							_this.wrap.style.bottom="0px";
							_this.wrap.style.display="";	
							_this.layers.style.display="";
							_this.dragtimewrap.style.bottom="12%";
							
// 							if(mui.os.plus &&　mui.os.ios)
// 							{
// 							plus.navigator.setFullscreen(true);		
// 							}
							}
							} 
							},
							Second:function(second)  //把时间转换成分钟
							{
							var hour = parseInt(second / (60* 60));
							var minute = parseInt((second/60) % 60);
							var second = parseInt(second % 60);
							var count=(hour > 0 ?((hour < 10 ? "0" + hour:hour) + ":") : "") + (minute < 10 ? "0" + minute:minute) + ":" + (second < 10 ? "0" + second:second);
							return count; 
							},touch:function(){
							var startx, starty;	
						    var _this=this;
							var wit=window.screen.width; 
						    var	getDirection=function(startx, starty, endx, endy) {
							var angx = endx - startx;
							var angy = endy - starty;
							var result = 0;
							//如果滑动距离太短
							if (Math.abs(angx) < 2 && Math.abs(angy) < 2) {
							return result;
							}
							var angle = getAngle(angx, angy);
							if (angle >= -135 && angle <= -45) {
							result = 1;
							} else if (angle > 45 && angle < 135) {
							result = 2;
							} else if ((angle >= 135 && angle <= 180) || (angle >= -180 && angle < -135)) {
							result = 3;
							} else if (angle >= -45 && angle <= 45) {
							result = 4;
							}
							return result;
							}
						    var getAngle=function(angx, angy) {
							return Math.atan2(angy, angx) * 180 / Math.PI;
							}
							var x=0,y=0,dragtime=0,isdrag=false;
							//手指接触屏幕
							_this.container.addEventListener("touchstart", function(e) {
							startx = e.touches[0].pageX;
							starty = e.touches[0].pageY;
							dragtime=_this.video.currentTime;
							}, false);
							var rand01=_this.container.querySelector(".mediae-left-volume-rand i"); 
							var rand02=_this.container.querySelector(".mediae-right-brightness-rand i"); 
							if(mui.os.plus)
							{
								mui.plusReady(function () {
								   var vol=plus.device.getVolume();
								   var brig=plus.screen.getBrightness();
								       rand01.style.height=(vol*100)+"%";
								       rand02.style.height=(brig*100)+"%";
								});
	
							}	
							var isvol=false;
							var isbrig=false;
										
							var valnum=0;			
							//手指离开屏幕
							_this.container.addEventListener("touchmove", function(e) {
							var endx, endy;
							endx = e.changedTouches[0].pageX;
							endy = e.changedTouches[0].pageY;
							var direction = getDirection(startx, starty, endx, endy);
							switch (direction) {
							case 0:
						   // console.log("未滑动！");
							break;
							case 1: 
							 if(!mui.os.plus || !_this.isfull)
							 {
								break;
							 }
							if(wit/2>=endx)
							{
							   
							  isvol=true;
							   var vol=plus.device.getVolume();
							 //  console.log("右向上:"+vol);
									_this.vol_left.style.display="block";
									rand01.style.height=(Math.ceil(vol*100)>98?100:Math.ceil(vol*100))+"%";
									var v=0;   
									if(valnum==vol)
									{
									v=vol+(vol<0.1?0.1:0.1);	
									}else{
									v=vol+(vol<0.1?0.1:0.3);	
									}
								   if(v<=1)
								   {
									var vm=v>0.9?1:v;	
									plus.device.setVolume(vm);
									valnum=plus.device.getVolume();
									}		   
							}else{
								isbrig=true;
							   var brig=plus.screen.getBrightness();
							       _this.brig_right.style.display="block";
								   rand02.style.height=(Math.ceil(brig*100)>98?100:Math.ceil(brig*100))+"%";
							       var v=brig+0.03; 
								   if(v<=1)
								   {
									var ms=v>0.9?1:v;
									plus.screen.setBrightness(ms); 
									 // console.log("右向上:"+ms);
								   }
							   //  
							}
							break;
							case 2:
							if(!mui.os.plus || !_this.isfull)
							{
							break;
							}
							if(wit/2>=endx)
							{
							   // console.log("左向下！:"+endx);
							    isvol=true;
								var vol=plus.device.getVolume();
								 _this.vol_left.style.display="block";
								rand01.style.height=(Math.ceil(vol*100)<0.1?0:Math.ceil(vol*100))+"%";
								var v=parseFloat(vol-0.03);
								if(v>=0  && v<=1)
								{
								plus.device.setVolume(v<0.1?0:v);   
								}   
								   
							}else{
							   
							    isbrig=true;
								var brig=plus.screen.getBrightness();
								_this.brig_right.style.display="block";
								rand02.style.height=(Math.ceil(brig*100)<0.1?0:Math.ceil(brig*100))+"%";
								var v=parseFloat(brig-0.03);
								if(v<=1 && v>=0)
								{
								plus.screen.setBrightness(v<0.1?0:v); 
								 // console.log("右向下！:"+v);
								}
								
							}
							break;
							case 3:
							//console.log("向左！");
							  dragtime=dragtime-2;
								if( Math.round(dragtime)<=Math.round(_this.video.duration)  && Math.round(dragtime)>=0)
								{	
								isdrag=true;
								_this.dragtimewrap.style.display='block';
								_this.dragtime.innerHTML=_this.Second(dragtime)+" / "+_this.Second(_this.video.duration);
								}
							break;
							case 4:
							//console.log("向右！");
							var currentTime=_this.video.currentTime;
							dragtime=dragtime+2;
							if(Math.round(dragtime)<=Math.round(_this.video.duration)  && Math.round(dragtime)>=0)
							{	
							isdrag=true;
							_this.dragtimewrap.style.display='block';
							_this.dragtime.innerHTML=_this.Second(dragtime)+" / "+_this.Second(_this.video.duration);
							}	
							break;
							default:
							}
							}, false);
							
							_this.container.addEventListener('touchend', function (e) {
							//console.log("拖动结束:");
							_this.dragtimewrap.style.display='none';
							dragnum=0;
							if(isdrag)
							{isdrag=false;
							_this.video.currentTime=dragtime;
							}
							
							if(isvol)
							{
								setTimeout(function(){
									if(!isvol)
									{
								 _this.vol_left.style.display="none";
								    }
									 
								},2000);
							  isvol=false;
							}
							if(isbrig)
							{
								setTimeout(function(){
									if(!isbrig)
									{
								 _this.brig_right.style.display="none";	
								    }
								 
								},2000);
							  isbrig=false;	
							}
							
							});

							
							///////	
							}

					   }
		
window.AppH5Video=AppH5Video; 

}(window,document));
