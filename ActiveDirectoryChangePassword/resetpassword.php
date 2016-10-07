<?php
//DECODIFICA O TOKEN ----------------------- PASSO 1 OK
//echo $_GET['t'];
$email = base64_decode($_GET['t']);
//echo "$email<br>";

include "form-resetpass.php";

if (isset($_POST["submitted"])) {
  reset_password();

}

// Verifica Se as SENHAS BATEM ------------ PASSO 2
function reset_password()
{
  global $email;
  
  $password1 = (trim($_POST['password1']));
  $password2 = (trim($_POST['password2']));
  //Salva as entradas de senha do usuário
 // echo "<br>$password1<br>";
 //echo "$password2<br>";

if (strlen($password1) < 8 ) {
    echo '<span style="color:#AFA;text-align:center;">Error E103 - Sua nova senha é muito curta. Ela deve possuir pelo menos 8 caracters.</span>';
    return false;
  }
  if (!preg_match("/[0-9]/",$password1)) {
    echo '<span style="color:#AFA;text-align:center;">Error E104 - Sua nova senha deve conter pelo menos um número.</span>';
    return false;
  }
  if (!preg_match("/[a-zA-Z]/",$password1)) {
    echo '<span style="color:#AFA;text-align:center;">Error E105 - Sua nova senha deve conter pelo menos uma letra.</span>';
    return false;
  }
  if (!preg_match("/[A-Z]/",$password1)) {
    echo '<span style="color:#AFA;text-align:center;">Error E106 - Sua nova senha deve conter pelo menos uma letra Maiuscula.</span>';
    return false;
  }
  if (!preg_match("/[a-z]/",$password1)) {
    echo '<span style="color:#AFA;text-align:center;">Error E107 - Sua nova senha deve conter pelo menos uma letra Minuscula.</span>';
    return false;
  }
  if($password1 == $password2)
  {
    ldap_Conectar($email);

  } else {

    echo '<span style="color:#AFA;text-align:center;">As senhas não conferem, tente novamente!</span>';
  }

  }

// Verifica se o E-mail Realmente Existe e efetua a troca -------- PASSO 3
function ldap_Conectar($email)
{
  include "cript.php";
  $password1 = trim($_POST['password1']);

  $ldap_addr = 'ldaps://domain.name:636';  // Change this to the IP address of the LDAP server
  $ds = ldap_connect($ldap_addr) or die("Couldn't connect!");
  
  //ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7); // enables   
  ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ds, LDAP_OPT_REFERRALS, 0) or die("Não foi possível setar a opção LDAP!"); //Opcao importante para fazer consulta no DC inteiro do AD  
  $ldap_rdn = base64_decode($firstEntry);
  $ldap_pass = base64_decode($secondEntry);



  // Authenticate the user against the domain controller
  $flag_ldap = ldap_bind($ds,$ldap_rdn,$ldap_pass) or die ("<br><h2>Erro: </h2><br>");
  
  // $ds is a valid link identifier for a directory server
  $basedn = "DC=domain,DC=name";
  $filter="( &(objectClass=user)(objectCategory=person)(mail=$email) )";
  $justthese = array("*","ou","mail","dn","sn","givenname");
  /*
    echo '<pre>';
    print_r ($justthese);
    echo '</pre>';
  */
  $sr=ldap_search($ds,$basedn,$filter,$justthese);
  $info = ldap_get_entries($ds, $sr);
 /*  
    echo '<pre>';
    print_r ($info);
    echo '</pre>';
*/   
  //Essa parada pega a base DN do usuário !!!!!:D
  $res = ldap_search($ds, $basedn, $filter);
  $first = ldap_first_entry($ds, $res);
  $data = ldap_get_dn($ds, $first);
  $passwordRetryCount = $info[0]["badpasswordtime"][0];
  $passwordhistory = $info[0]["userpassword"][0];
  //echo "The desired DN is: $data<br>";

/* Start the testing VERIFICA SE A CONTA ESTÁ TRANCADA OU SE FOI USADA ANTERIORMENTE!*/
  if ( $passwordRetryCount == 3 ) {
    echo '<span style="color:#AFA;text-align:center;">Error E101 - Sua conta está trancada!</span>';
    return false;
  }  
$history_arr = ldap_get_values($ds,$first,"userpassword");
  if ( $history_arr ) {
    echo '<span style="color:#AFA;text-align:center;">Error E102 - Sua nova senha confere com uma usada anteriormente. Você deve criar uma nova senha!</span>';
    return false;
  }
 //Reseta a senha do usuário  

   $userdata['unicodePwd'] = iconv('UTF-8', 'UTF-16LE',"\"" . $password1 . "\"");
   $result = ldap_mod_replace($ds, $data , $userdata);

} 

?>
