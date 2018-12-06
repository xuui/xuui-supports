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

//document.oncontextmenu=function(){return false;}
document.querySelector('#loginform').oncontextmenu=function(){return false;}
