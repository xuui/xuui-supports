/*xu.js*/
xuui=function(t,n,e){var i=Node.prototype,r=NodeList.prototype,o='forEach',u='trigger',c=[][o],s=t.createElement('i');return r[o]=c,n.on=i.on=function(t,n){return this.addEventListener(t,n,!1),this},r.on=function(t,n){return this[o](function(e){e.on(t,n)}),this},n[u]=i[u]=function(n,e){var i=t.createEvent('HTMLEvents');return i.initEvent(n,!0,!0),i.data=e||{},i.eventName=n,i.target=this,this.dispatchEvent(i),this},r[u]=function(t){return this[o](function(n){n[u](t)}),this},e=function(n){var e=t.querySelectorAll(n||'☺'),i=e.length;return 1==i?e[0]:e},e.on=i.on.bind(s),e[u]=i[u].bind(s),e}(document,this);
//signin.js
xuui('#login h1 a').href=sign.href;
xuui('#login h1 a').title=sign.title;
xuui('#login h1 a').text=sign.title;

var user_login=document.querySelector('#user_login'),user_email=document.querySelector('#user_email'),user_pass=document.querySelector('#user_pass');
if(user_login)user_login.setAttribute('placeholder',user_login.parentNode.innerText);
if(user_email)user_email.setAttribute('placeholder',user_email.parentNode.innerText);
if(user_pass)user_pass.setAttribute('placeholder',user_pass.parentNode.innerText);

xuui('#user_login').on('click',function(){
  xuui('#login h1 a').setAttribute('style','background:-#f0f');
});
xuui('.input').on('focus',function(e){e.preventDefault();
  this.parentNode.className='focus';
}).on('blur',function(e){e.preventDefault();
  if(!this.value)this.parentNode.className='';
});

if(xuui('#login p.forgetmenot label').length>0){
  xuui('#login p.forgetmenot label').appendChild(document.createElement('span'));
}
var btn=document.createElement('button');
btn.appendChild(document.createTextNode(xuui('#wp-submit').value));
btn.type='submit';
btn.className='button button-primary button-large ripple-wrapper';
btn.name='wp-submit';
btn.setAttribute('data-ripple','ripple');
//btn.id='wp-submit';
btn.appendChild(document.createElement('span'));
xuui('#login form p.submit').appendChild(btn);
xuui('#wp-submit').parentNode.removeChild(xuui('#wp-submit'));


//document.oncontextmenu=function(){return false;}
xuui('#login form').oncontextmenu=function(){return false;}
