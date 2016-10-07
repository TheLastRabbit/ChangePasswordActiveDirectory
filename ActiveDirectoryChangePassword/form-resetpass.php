<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Password Change Page</title>
<style type="text/css">
body {background-color:#28292d; font-family: Verdana,Arial,Courier New; font-size: 0.7em; }
input { width: 69%;padding: 7px 20px;margin: 8px 0;box-sizing: border-box; }
#container { text-align: center; width: 500px; margin: 5% auto; }
#botao{width: 40%;}
.msg_yes { margin: 0 auto; text-align: center; color: green; background: #D4EAD4; border: 1px solid green; border-radius: 10px; margin: 2px; }
.msg_no { margin: 0 auto; text-align: center; color: red; background: #FFF0F0; border: 1px solid red; border-radius: 10px; margin: 2px; }
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div id="container">
<img src="img/logo_m4u_sm.png">
<h2 style="color:#00aaef">Company - Change Password</h2>
<p style="color:#fff">A senha deve conter no mínimo 8 caracteres com pelo menos:<br/>
Uma letra maiúscula, uma letra minúscula, um número ou símbolo.<br/>
Você deve inserir uma nova senha diferente da atual.<br/></p>
<table style="width: 400px; margin: 0 auto;">
<form id='login' method='post' accept-charset='UTF-8'>
<fieldset >
<legend style="color:#fff">Change Password</legend>
<input type='hidden' name='submitted' id='submitted'/>
 
<label for='password1' style="color:#fff" >Password1*:</label>
<input type='password' name='password1' id='password1'  size="20px"/>
 
<label for='password2' style="color:#fff" >Password2*:</label>
<input type='password' name='password2' id='password2' size="20px"/>
 
<input id='botao' type='submit' name='Submit' value='Resetar' />
 
</fieldset>

</form>
</table>
</div>
</body>
</html>
