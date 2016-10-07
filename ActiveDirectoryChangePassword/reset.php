<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" media="all" href="reset.css"/>
<head>
<title>Reset</title>

<SCRIPT TYPE="text/javascript"> function popupform(myform, windowname) { if (! window.focus)return true; window.open('', windowname, 'height=200,width=400,scrollbars=yes'); myform.target=windowname; return true; } </SCRIPT>

</head>
<body>
<div id='LogoH2'>
<img src="img/logo_m4u_sm.png">
<h2 style="color:#00aaef">Reset de Senha</h2>
<form action="geramail.php" method="POST" onSubmit="popupform(this, 'join')">

Endereço de E-mail: <input type="text" name="email" size="20" /> <input type="submit" name="ForgotPassword" value=" Solicitar Reset " />

</form>

</div>
</body>

</html>
