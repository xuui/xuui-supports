// ripple.
/*
function RippleEffect(element){
  this.element=element;this.element.addEventListener('mousedown',this.run.bind(this),false);
}
RippleEffect.prototype={run:function(event){
  var ripplerContainer=this.element.querySelector('.ripple-container');
  var offsetInfo=this.element.getBoundingClientRect();
  if(ripplerContainer){ripplerContainer.remove();}
  var rippleContainer=document.createElement('div');
  rippleContainer.style.position='fixed';
  rippleContainer.style.zIndex=99;
  rippleContainer.style.width=offsetInfo.width+'px';
  rippleContainer.style.left=offsetInfo.left+'px';
  rippleContainer.style.top=offsetInfo.top+'px';
  rippleContainer.style.height=offsetInfo.height+'px';
  rippleContainer.className='ripple-container';
  rippleContainer.style.overflow='hidden';
  this.element.appendChild(rippleContainer);
  var circleD=offsetInfo.width*2;
  var ripple=document.createElement('div');
  ripple.style.position='absolute';
  ripple.style.width=circleD+'px';
  ripple.style.height=circleD+'px';
  ripple.style.borderRadius='500px';
  ripple.style.left=((event.pageX-offsetInfo.left)-circleD/2)+'px';
  ripple.style.top=((event.pageY-offsetInfo.top)-circleD/2)+'px';
  ripple.className='ripple';rippleContainer.appendChild(ripple);
  ripple.addEventListener('animationend',function(){rippleContainer.remove();}.bind(this),false);
}};

*/

(function($,ua){var
  isChrome=/chrome/i.exec(ua),isAndroid=/android/i.exec(ua),hasTouch='ontouchstart'in window&&!(isChrome&&!isAndroid);$.fn.ripple=function(options){var rippled=false,opts=$.extend({},{color:'#fff'},options);opts.event=(hasTouch&&'touchstart.ripple')||'mousedown.ripple';opts.end_event=(hasTouch&&'touchend.ripple touchcancel.ripple')||'mouseup.ripple mouseleave.ripple';$(this).on(opts.event,function(ev){var x,y,touch_ev,$paper=$(this),$ink=$('<div/>'),size=Math.max($paper.width(),$paper.height());rippled=true;$paper.trigger('beforeripple').addClass('ripple-active');$ink.addClass('ripple-effect').css({height:size,width:size});touch_ev=hasTouch?ev.originalEvent.touches[0]:ev;x=touch_ev.pageX-$paper.offset().left-$ink.width()/2;y=touch_ev.pageY-$paper.offset().top-$ink.height()/2;$ink.css({top:y+'px',left:x+'px',backgroundColor:opts.color}).appendTo($paper);}).on(opts.end_event,function(){var $paper=$(this),$ink=$paper.find('.ripple-effect');if(!rippled){return;}
  rippled=false;$paper.trigger('afterripple').removeClass('ripple-active');$ink.css({backgroundColor:'transparent'}).one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend',function(){$ink.remove();});});return $(this);};}(window.jQuery,navigator.userAgent));