/*xuui.js*/
xuui=function(t,n,e){var i=Node.prototype,r=NodeList.prototype,o="forEach",u="trigger",c=[][o],s=t.createElement("i");return r[o]=c,n.on=i.on=function(t,n){return this.addEventListener(t,n,!1),this},r.on=function(t,n){return this[o](function(e){e.on(t,n)}),this},n[u]=i[u]=function(n,e){var i=t.createEvent("HTMLEvents");return i.initEvent(n,!0,!0),i.data=e||{},i.eventName=n,i.target=this,this.dispatchEvent(i),this},r[u]=function(t){return this[o](function(n){n[u](t)}),this},e=function(n){var e=t.querySelectorAll(n||"☺"),i=e.length;return 1==i?e[0]:e},e.on=i.on.bind(s),e[u]=i[u].bind(s),e}(document,this);
//signin.js
xuui('#login h1 a').href=sign.href;
xuui('#login h1 a').title=sign.title;
xuui('#login h1 a').text=sign.title;

var user_login=xuui('#user_login'),user_email=xuui('#user_email'),user_pass=xuui('#user_pass');
//if(user_login)user_login.setAttribute('placeholder','用户名或电子邮件地址');
//if(user_email)user_email.setAttribute('placeholder','电子邮件');
//if(user_pass)user_pass.setAttribute('placeholder','密码');

xuui('#user_login').addEventListener('click',function(){
  xuui('#login h1 a').setAttribute('style','background:-#f0f');
});
//xuui('#rememberme').appendChild( document.createComment('span') );

//xuui('.input').addEventListener('focus',function(){
  //console.log(this.parentNode);
//});

xuui('.input').on('focus',function(e){
  e.preventDefault();
  // do something else
  this.parentNode.className="focus";
}).on('blur',function(e){
  e.preventDefault();
  if(!this.value)this.parentNode.className="";
});


var forgetmenot=xuui('#login p.forgetmenot label');
if(forgetmenot){
  forgetmenot.appendChild(document.createElement('span'));
  //xuui('#rememberme').checked=true;
}

var btn=document.createElement('button');
btn.appendChild(document.createTextNode(xuui('#wp-submit').value));
btn.type='button';
btn.className='button button-primary button-large ripple';
btn.name='wp-submit';
btn.setAttribute('data-ripple','ripple');
//btn.id='wp-submit';
btn.appendChild(document.createElement('span'));
xuui('#login form p.submit').appendChild(btn);
xuui('#wp-submit').parentNode.removeChild(xuui('#wp-submit'));

//Array.prototype.forEach.call(document.querySelectorAll('[data-ripple]'),function(element){
  // find all elements and attach effect
  //new RippleEffect(element); // element is instance of javascript element node
//});


//document.oncontextmenu=function(){return false;}
xuui('#login form').oncontextmenu=function(){return false;}

// ripple
$('[data-ripple]').ripple();
