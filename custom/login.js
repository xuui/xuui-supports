// signin.js
var user_login=document.querySelector('#user_login'),user_email=document.querySelector('#user_email'),user_pass=document.querySelector('#user_pass');
if(user_login)user_login.setAttribute('placeholder','用户名或电子邮件地址');
if(user_email)user_email.setAttribute('placeholder','电子邮件');
if(user_pass)user_pass.setAttribute('placeholder','密码');
document.querySelector('#login h1 a').href=sign.href;
document.querySelector('#login h1 a').title=sign.title;
document.querySelector('#login h1 a').text=sign.title;
document.querySelector('#user_login').addEventListener('click',function(){
  document.querySelector('#login h1 a').setAttribute('style','background:-#f0f');
  console.log('Hello World');
  console.log(sign);
  console.log(sign.href);
  console.log(sign.title);
});

//document.querySelector('#rememberme').appendChild( document.createComment('span') );


if(document.querySelector('#login p.forgetmenot label'))document.querySelector('#login p.forgetmenot label').appendChild(document.createElement('span'));

var btn=document.createElement('button');
btn.appendChild(document.createTextNode(document.querySelector('#wp-submit').value));
btn.type='submit';
btn.className='button button-primary button-large ripple';
btn.name='wp-submit';
btn.setAttribute('data-ripple','');
//btn.id='wp-submit';
btn.appendChild(document.createElement('span'));
document.querySelector('#login form p.submit').appendChild(btn);
document.querySelector('#wp-submit').parentNode.removeChild(document.querySelector('#wp-submit'));

Array.prototype.forEach.call(document.querySelectorAll('[data-ripple]'),function(element){
  // find all elements and attach effect
  new RippleEffect(element); // element is instance of javascript element node
});



//document.oncontextmenu=function(){return false;}
document.querySelector('#login form').oncontextmenu=function(){return false;}
