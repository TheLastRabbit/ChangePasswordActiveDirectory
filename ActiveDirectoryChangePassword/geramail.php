<?php 
function gera_token(){

//header ('Content-type: text/html; charset=UTF-8');
//header ('Content-type: text/html; charset=ISO-8859-1');
global $email;
//GERA TOKEN
//Comentado por que a forma de criptografia ainda não está 100% inteligente.
//$salt = "498#2D83B631%3800EBD!801600D*7E3CC13";
//$salt = uniqid(mt_rand(), true);
//$mail_address = "";

// Create the unique user password reset key
//$password = hash('sha512', $salt.$email);
//$pwrurl = ";
//echo "$pwrurl";
//echo "$password<br>";
//echo "$email<br>";
//echo "$salt<br>";
$token = base64_encode($email);
$pwrurl = "http://ip-host/trocasenha2/resetpassword.php?t=$token";
//echo "$pwrurl<br>";



//Começa a parte do e-mail
$mailbody = "Prezado usuário,\n\nSe você não solicitou uma nova senha, apenas ignore este e-mail.\n\nPara resetar sua senha, clique no link abaixo. Se não for possível clicar, Copie e cole na barra de pesquisa do seu navegador e cole o TOKEN quando solicitado no campo indicado para resetar a senha.\n\nLink:" . $pwrurl . "\n\nEquipe de Infraestrutura";
//envia o e-mail para o usuário
//echo "<br>$mailbody";
$headers = 'From: Do-NotReply@company.com.br.';
mail($email, "company - Password Reset", $mailbody,$headers);



}

function ldap_Conectar($email)
{
  include "cript.php";
  $ldap_addr = 'x.x.x.x';  // Change this to the IP address of the LDAP server
  $ds = ldap_connect($ldap_addr) or die("Couldn't connect!");
  
  //ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7); // enables   
  ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ds, LDAP_OPT_REFERRALS, 0) or die("Não foi possível setar a opção LDAP!"); //Opcao importante para fazer consulta no DC inteiro do AD  
  $ldap_rdn = base64_decode($firstEntry);
  $ldap_pass = base64_decode($secondEntry);

  // Authenticate the user against the domain controller
  $flag_ldap = ldap_bind($ds,$ldap_rdn,$ldap_pass) or die ("<br><h2>Erro: </h2><br>");
  
  // $ds is a valid link identifier for a directory server
  $basedn = "DC=CORP,DC=local";
  $filter="( &(objectClass=user)(objectCategory=person)(mail=$email) )";
  $justthese = array("ou","mail","dn","sn","givenname");
  //$sr = ldap_list($ds, $basedn, $filter, $justthese);
  $sr=ldap_search($ds,$basedn,$filter,$justthese);
  $info = ldap_get_entries($ds, $sr);
  

  if (count($info) <= 1) {
    //Aqui deu erro e não deve enviar o e-mail, pois não encontrou no AD
    include "falha.php";
    echo "Nao existe este email<br>";
  } else {
    //Aqui deve entrar o código que dispara o e-mail EDITAR AQUI!!!!!
    //var_dump($info);
    include "sucesso.php";
    echo "Endereço de email encontrado<br>";
    gera_token();


  }
}
if ( isset($_POST['email']) ) {  
  $email = $_POST['email'];
  ldap_Conectar($email);
} else {
  echo "É necessário preencher o campo e-mail";
}
?>
