<?php
/*
Plugin Name: Wp Super Login
Plugin URI: http://www.wpajans.net
Description: Theme sidebar add login box.
Version: 1.2
Author: WpAJANS
Author URI: http://www.wpajans.net
License: GNU
*/

function acme_login_redirect( $redirect_to, $request, $user  ) {
  return ( is_array( $user->roles ) && in_array( 'administrator', $user->roles ) ) ? admin_url() : site_url();
}

add_action('wp_logout','go_home');
function go_home(){
  wp_redirect( site_url() );
  exit();
}

add_filter( 'login_redirect', 'acme_login_redirect', 10, 3 );
add_action( 'register_form', 'ts_show_extra_register_fields' );
function ts_show_extra_register_fields(){
?>
  <p>
    <label for="password">Password<br/>
    <input id="password" class="input" type="password" tabindex="30" size="25" value="" name="password" />
    </label>
  </p>
  <p>
    <label for="repeat_password">Repeat password<br/>
    <input id="repeat_password" class="input" type="password" tabindex="40" size="25" value="" name="repeat_password" />
    </label>
  </p>
<?php
}

// Check the form for errors
add_action( 'register_post', 'ts_check_extra_register_fields', 10, 3 );
function ts_check_extra_register_fields($login, $email, $errors) {
  if ( $_POST['password'] !== $_POST['repeat_password'] ) {
    $errors->add( 'passwords_not_matched', "<strong>ERROR</strong>: Passwords must match" );
  }
  if ( strlen( $_POST['password'] ) < 5 ) {
    $errors->add( 'password_too_short', "<strong>ERROR</strong>: Passwords must be at least eight characters long" );
  }

}
?><?php

add_action( 'user_register', 'ts_register_extra_fields', 100 );
function ts_register_extra_fields( $user_id ){
  $userdata = array();

  $userdata['ID'] = $user_id;
  if ( $_POST['password'] !== '' ) {
    $userdata['user_pass'] = $_POST['password'];
  }
  $new_user_id = wp_update_user( $userdata );
}
?><?php

add_filter( 'gettext', 'ts_edit_password_email_text' );
function ts_edit_password_email_text ( $text ) {
  if ( $text == 'A password will be e-mailed to you.' ) {
    $text = 'If you leave password fields empty one will be generated for you. Password must be at least eight characters long.';
  }
  return $text;
}


function remove_password_email_text ( $text ) {
   if ($text == 'Kayıt tamamlandı. Lütfen e-posta adresinize bakın.'){$text = 'Lütfen Giriş Yapınız...';}
   if ($text == 'Registration complete. Please check your e-mail.'){$text = 'Please Login...';}
    return $text;
 }    
add_filter( 'gettext', 'remove_password_email_text' );

register_activation_hook(__FILE__, 'eklenti_varsayilan');
function eklenti_varsayilan( ) {
    add_option('eklenti_secenek', 'English');
    add_option('theme_select', 'Blue');
}
register_deactivation_hook(__FILE__, 'eklenti_kaldirildi');
function eklenti_kaldirildi( ) {
    delete_option('eklenti_secenek');
    delete_option('theme_select');
}

add_action('admin_menu', 'wp_super_login');
 
function wp_super_login()
 {
 add_options_page('Super Login','Super Login', '8', 'wp_super_login', 'eklentim_fonks');
 }
 
 function eklentim_fonks() {
 ?>
<?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){
?>
 <div style="margin-top:10px;">
            <h2>Wp Super Login Management Page</h2>
<?php echo "Available Language ".$eklenti_bilgisi=get_option('eklenti_secenek')?>
                <form method="post" action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
                    <label for="Langue">Please select language</label>
                    <select name="langue" id="">
                      <option value="English" selected>English</option>
                      <option value="Turkish">Turkish</option>
                      <option value="French">French</option>
                    </select><br />
                            <h2>Theme Select</h2>
           <?php echo "Available Theme ".$eklenti_bilgisi=get_option('theme_select')?>
<br>
                   Please select theme <select name="theme" id="">
                      <option value="Blue" selected>Blue</option>
                      <option value="Pink">Pink</option>
                      <option value="Purple">Purple</option>
                      <option value="Red">Red</option>
                    </select>
                    <br>
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                                </form>
        </div>
 <?php }
  ?>
  <?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){
?>
 <div style="margin-top:10px;">
  <h2> Wp Super Login Yönetim Sayfası</h2>
<?php echo "Mevcut Dil ".$eklenti_bilgisi=get_option('eklenti_secenek')?>
                <form method="post" action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
                    <label for="Langue">Lütfen Dil Seçiniz</label>
                    <select name="langue" id="">
                      <option value="English">English</option>
                      <option value="Turkish" selected>Turkish</option>
                      <option value="French">French</option>
                    </select><br />
                     <h2>Tema Seç</h2>
           <?php echo "Mevcut Tema ".$eklenti_bilgisi=get_option('theme_select')?>
<br>
                   Lütfen Tema Seçin <select name="theme" id="">
                      <option value="Blue" selected>Mavi</option>
                      <option value="Pink">Pembe</option>
                      <option value="Purple">Mor</option>
                      <option value="Red">Kırmızı</option>
                    </select>
                    <br>
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                </form>
        </div>
        <?}?>

     <?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){
?>
 <div style="margin-top:10px;">
  <h2> Wp Super Login Gestion page</h2>
<?php echo "Langues disponibles ".$eklenti_bilgisi=get_option('eklenti_secenek')?>
                <form method="post" action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
                    <label for="Langue">Se il vous plaît Sélectionnez une langue</label>
                    <select name="langue" id="">
                      <option value="English">English</option>
                      <option value="Turkish">Turkish</option>
                      <option value="French" selected>French</option>
                    </select><br />
                     <h2>Choisissez un Thème</h2>
           <?php echo "Thèmes disponibles ".$eklenti_bilgisi=get_option('theme_select')?>
<br>
                   Se il vous plaît sélectionnez thème <select name="theme" id="">
                      <option value="Blue" selected>Bleu</option>
                      <option value="Pink">Rose</option>
                      <option value="Purple">Pourpre</option>
                      <option value="Red">Rouge</option>
                    </select>
                    <br>
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                </form>
        </div>

        <?}}

 if ($_POST['hidden'] == 'tmm') {
 $bizim_verimiz = $_POST['langue'];
 $theme_data = $_POST['theme'];
 update_option('eklenti_secenek', $bizim_verimiz);
 update_option('theme_select', $theme_data);
 
 }

function login_add(){
if (is_user_logged_in()): {
      $current_user = wp_get_current_user();

if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'<div id="login"><h1>';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="loginPink"><h1>';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="loginPurple"><h1>';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo'<div id="loginRed"><h1>';
}   
             if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){

 echo'Hi! '.$current_user->display_name.'</h1>
  '; 
  if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo '<div id="logins">'; 
}

if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo '<div id="loginsPink">';
  } 
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo '<div id="loginsPurple">';
  } 
  if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo '<div id="loginsRed">';
  } 
  echo'<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Dashboard</a>
  <a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/profile.php">Edit My Profile</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Sign Out</a>
  </div>
</div>
';
}
else if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){
echo'Merhaba! '.$current_user->display_name.'</h1>
  '; 
  if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo '<div id="logins">'; 
}

if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo '<div id="loginsPink">';
  } 
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo '<div id="loginsPurple">';
  } 
  if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo '<div id="loginsRed">';
  } 
  echo'<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Başlangıç</a>
  <a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/profile.php">Profilimi Düzenle</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Çıkış</a>
  </div>
</div>
';
}

else if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){
echo'Bonjour Il! '.$current_user->display_name.'</h1>
  '; 
  if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo '<div id="logins">'; 
}

if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo '<div id="loginsPink">';
  } 
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo '<div id="loginsPurple">';
  } 
  if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo '<div id="loginsRed">';
  } 
  echo'<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Début</a>
  <a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/profile.php">Modifier mon profil</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Sortie</a>
  </div>
</div>
';
}

} endif;

if ( !is_user_logged_in()): { 

  echo'
';
?>









<?

if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <span href="#" class="button" id="toggle-login">Giriş Yap</span>
  <span href="#" class="button" id="toggle-register">Kayıt Ol</span>
  <div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
echo'
  <span href="#" class="button" id="toggle-loginPink">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerPink">Kayıt Ol</span>
  <div id="loginPink">';}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  ?>
  <span href="#" class="button" id="toggle-loginPurple">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerPurple">Kayıt Ol</span>
  <?
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  ?>
  <span href="#" class="button" id="toggle-loginRed">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerRed">Kayıt Ol</span> 
  <?
  echo'<div id="loginRed">';
}
?>  <h1>Giriş Yap</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'loginform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'loginformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'loginformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'loginformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php" method="post">
    <input type="text" name="log" placeholder="Kullanıcı Adınız" />
    <input type="password" name="pwd" placeholder="Şifreniz" />
      <div class="squaredTwo">
  <input type="checkbox"   id="squaredTwo" name="rememberme" />
  <label for="squaredTwo"></label> <div class="Rememberme" style="margin: -16px 38px 7px;
color: rgb(0, 0, 0);
width: 150px;">Beni Hatırla</div></div>
    <input type="submit" name="wp-submit" id="login" value="Giriş Yap" />
  </form>
</div>
<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <div id="register">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="registerPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="registerPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo'<div id="registerRed">';
}
?>  <h1>Üye Ol</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'registerform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'registerformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'registerformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'registerformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php?action=register" method="post">
    <input type="text" name="user_login" placeholder="Kullanıcı Adınız" />
    <input type="text" name="user_email" placeholder="E-posta adresiniz" />
    <input id="password" type="password" placeholder="Şifreniz" name="password" />
    <input id="repeat_password" type="password" placeholder="Şifrenizi Tekrar Girin" name="repeat_password" />

     
    <input type="submit" name="submit" id="registerb" value="Kayıt Ol" />
  </form>
</div>
<?}?>




<?

if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <span href="#" class="button" id="toggle-login">Login</span>
  <span href="#" class="button" id="toggle-register">Register</span>
  <div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
echo'
  <span href="#" class="button" id="toggle-loginPink">Login</span>
  <span href="#" class="button" id="toggle-registerPink">Register</span>
  <div id="loginPink">';}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  ?>
  <span href="#" class="button" id="toggle-loginPurple">Login</span>
  <span href="#" class="button" id="toggle-registerPurple">Register</span>
  <?
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  ?>
  <span href="#" class="button" id="toggle-loginRed">Login</span>
  <span href="#" class="button" id="toggle-registerRed">Register</span> 
  <?
  echo'<div id="loginRed">';
}
?>  <h1>Login</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'loginform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'loginformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'loginformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'loginformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php" method="post">
    <input type="text" name="log" placeholder="User Name" />
    <input type="password" name="pwd" placeholder="Password" />
      <div class="squaredTwo">
  <input type="checkbox"   id="squaredTwo" name="rememberme" />
  <label for="squaredTwo"></label> <div class="Rememberme" style="margin: -16px 38px 7px;
color: rgb(0, 0, 0);
width: 150px;">Remember me?</div></div>
    <input type="submit" name="wp-submit" id="login" value="Login" />
  </form>
</div>
<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <div id="register">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="registerPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="registerPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo'<div id="registerRed">';
}
?>  <h1>Register</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'registerform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'registerformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'registerformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'registerformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php?action=register" method="post">
    <input type="text" name="user_login" placeholder="User Name" />
    <input type="text" name="user_email" placeholder="E-mail address" />
    <input id="password" type="password" placeholder="Password" name="password" />
    <input id="repeat_password" type="password" placeholder="Password Again" name="repeat_password" />

     
    <input type="submit" name="submit" id="registerb" value="Register" />
  </form>
</div>
<?}?>







<?

if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <span href="#" class="button" id="toggle-login">S\'identifier</span>
  <span href="#" class="button" id="toggle-register">Se enregistrer</span>
  <div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
echo'
  <span href="#" class="button" id="toggle-loginPink">S\'identifier</span>
  <span href="#" class="button" id="toggle-registerPink">Se enregistrer</span>
  <div id="loginPink">';}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  ?>
  <span href="#" class="button" id="toggle-loginPurple">S'identifier</span>
  <span href="#" class="button" id="toggle-registerPurple">Se enregistrer</span>
  <?
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  ?>
  <span href="#" class="button" id="toggle-loginRed">S'identifier</span>
  <span href="#" class="button" id="toggle-registerRed">Se enregistrer</span> 
  <?
  echo'<div id="loginRed">';
}
?>  <h1>S'identifier</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'loginform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'loginformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'loginformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'loginformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php" method="post">
 <input type="text" name="log" placeholder="Nom d'utilisateur" />
    <input type="password" name="pwd" placeholder="votre mot de passe" />
       <div class="squaredTwo">
  <input type="checkbox"   id="squaredTwo" name="rememberme" />
  <label for="squaredTwo"></label> <div class="Rememberme" style="margin: -16px 38px 7px;
color: rgb(0, 0, 0);
width: 150px;">Souviens-Toi De Moi</div></div>
    <input type="submit" name="submit" id="login" value="S'identifier" />
  </form>
</div>
<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'
  <div id="register">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="registerPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="registerPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo'<div id="registerRed">';
}
?>  <h1>Se enregistrer</h1>
  <form name="loginform" id="<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'registerform';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'registerformPink';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'registerformPurple';
}if($eklenti_bilgisi=get_option('theme_select')=='Red'){
  echo'registerformRed';
}
?>" action="<?php bloginfo("url");?>/wp-login.php?action=register" method="post">
    <input type="text" name="user_login" placeholder="Nom d'utilisateur" />
    <input type="text" name="user_email" placeholder="Adresse e-mails" />
    <input id="password" type="password" placeholder="Mot de passe" name="password" />
    <input id="repeat_password" type="password" placeholder="Mot de passe Encore une fois" name="repeat_password" />

     
    <input type="submit" name="submit" id="registerb" value="Se enregistrer" />
  </form>
</div>
<?}?>









<?
} endif;


?>
<script>
<?php if($eklenti_bilgisi=get_option('theme_select')=="Blue"){
?>
  $('#register').hide();
  $('#toggle-login').attr('style',  'background-color:#3C7A99');

$('#toggle-register').click(function(){
  $('#login').hide();
  $('#register').show();
  $('#toggle-login').removeAttr('style',  'background-color:#3C7A99');
  $('#toggle-register').attr('style',  'background-color:#3C7A99');
  $('#toggle-login').click(function(){
  $('#register').hide();
  $('#toggle-register').removeAttr('style',  'background-color:#3C7A99');
  $('#toggle-login').attr('style',  'background-color:#3C7A99');
  $('#login').show();

<?}?>
<?php if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
?>
  $('#registerPink').hide();
  $('#toggle-loginPink').attr('style',  'background-color:#D2527F');

$('#toggle-registerPink').click(function(){
  $('#loginPink').hide();
  $('#registerPink').show();
  $('#toggle-loginPink').removeAttr('style',  'background-color:#D2527F');
  $('#toggle-registerPink').attr('style',  'background-color:#D2527F');
  $('#toggle-loginPink').click(function(){
  $('#registerPink').hide();
  $('#toggle-registerPink').removeAttr('style',  'background-color:#D2527F');
  $('#toggle-loginPink').attr('style',  'background-color:#D2527F');
  $('#loginPink').show();

<?}?>

<?php if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
?>
  $('#registerPurple').hide();
  $('#toggle-loginPurple').attr('style',  'background-color:#511B72');

$('#toggle-registerPurple').click(function(){
  $('#loginPurple').hide();
  $('#registerPurple').show();
  $('#toggle-loginPurple').removeAttr('style',  'background-color:#511B72');
  $('#toggle-registerPurple').attr('style',  'background-color:#511B72');


  $('#toggle-loginPurple').click(function(){
  $('#registerPurple').hide();
  $('#toggle-registerPurple').removeAttr('style',  'background-color:#511B72');
  $('#toggle-loginPurple').attr('style',  'background-color:#511B72');
  $('#loginPurple').show();

<?}?>


<?php if($eklenti_bilgisi=get_option('theme_select')=="Red"){
?>
  $('#registerRed').hide();
  $('#toggle-loginRed').attr('style',  'background-color:#96281B');

$('#toggle-registerRed').click(function(){
  $('#loginRed').hide();
  $('#registerRed').show();
  $('#toggle-loginRed').removeAttr('style',  'background-color:#96281B');
  $('#toggle-registerRed').attr('style',  'background-color:#96281B');


  $('#toggle-loginRed').click(function(){
  $('#registerRed').hide();
  $('#toggle-registerRed').removeAttr('style',  'background-color:#96281B');
  $('#toggle-loginRed').attr('style',  'background-color:#96281B');
  $('#loginRed').show();

<?}?>

});});</script>
<style>@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

*{margin:0;padding:0;}
#triangle{
  width:0;
  border-top:12x solid transparent;
  border-right:12px solid transparent;
  border-bottom:12px solid #3399cc;
  border-left:12px solid transparent;
  margin:-11px auto;
}

.squaredTwo input[type=checkbox] {
  visibility: hidden;
}
.button {
  width:100px;
  background:#3399cc;
  display:block;
  margin:0 auto;
  margin-top:1%;
  padding:10px;
  text-align:center;
  text-decoration:none;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}



#toggle-login,#toggle-register {
width: 125px;
  background: #3399cc;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-login,#toggle-register span:last-child{border-left:0}


#toggle-login:hover,#toggle-register:hover{
  background:#2288bb;
}



#toggle-loginPink,#toggle-registerPink {
width: 125px;
  background: #CC337F;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-loginPink,#toggle-registerPin span:last-child{border-left:0}


#toggle-loginPink:hover,#toggle-registerPink:hover{
  background:#D2527F;
}


#toggle-loginPurple,#toggle-registerPurple {
width: 125px;
  background: #663399;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-loginPurple,#toggle-registerPurple span:last-child{border-left:0}


#toggle-loginPurple:hover,#toggle-registerPurple:hover{
  background:#674172;
}


#toggle-loginRed,#toggle-registerRed {
width: 125px;
  background: #D91E18;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #fff;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-loginRed,#toggle-registerRed span:last-child{border-left:0}


#toggle-loginRed:hover,#toggle-registerRed:hover{
  background:#96281B;
}



.button:hover{
  background:#2288bb;
}


#btns{
  background:#3399cc;
  display:block;
  margin:0 auto;
  margin-top:1%;
  padding:10px;
  text-align:center;
  text-decoration:none;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#btns:hover{
  background:#2288bb;
}


#login{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#login h1{
  background:#3399cc;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#loginPink{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginPink h1{
  background:#CC337F;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#loginPurple{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginPurple h1{
  background:#663399;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#loginRed{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginRed h1{
  background:#D91E18;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}









#register{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#register h1{
  background:#3399cc;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#registerPink{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerPink h1{
  background:#CC337F;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#registerPurple{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerPurple h1{
  background:#663399;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}

#registerRed{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerRed h1{
  background:#D91E18;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}


#registerform form, #register form{
  background:#f0f0f0;
  padding:6% 4%;
}
#registerformPink form, #registerPink form{
  background:#F1A9A0;
  padding:6% 4%;
}
#registerformPurple form, #registerPurple form{
  background:#AEA8D3;
  padding:6% 4%;
}
#registerformRed form, #registerRed form{
  background:#96281B;
  padding:6% 4%;
}


#loginform form, #login form{
  background:#f0f0f0;
  padding:6% 4%;
}
#loginformPink form, #loginPink form{
  background:#F1A9A0;
  padding:6% 4%;
}
#loginformPurple form, #loginPurple form{
  background:#AEA8D3;
  padding:6% 4%;
}
#loginformRed form, #loginRed form{
  background:#96281B;
  padding:6% 4%;
}
#logins{
  background:#f0f0f0;
  padding:6% 4%;
  color:#111;
}

#loginsPink{
  background:#C3398D;
  padding:6% 4%;
  color:#111;
}

#loginsPurple{
  background:#AEA8D3;
  padding:6% 4%;
  color:#111;
}

#loginsRed{
  background:#96281B;
  padding:6% 4%;
  color:#111;
}
input[type="text"],input[type="password"]{
  background:#fff;
  width:92%;
  margin-bottom:4%;
  border:1px solid #ccc;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:95%;
  color:#555;
}

#login  input[type="submit"]{
  width:100%;
  background:#3399cc;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#login input[type="submit"]:hover{
  background:#2288bb;
}

#loginRed  input[type="submit"]{
  width:100%;
  background:#CF000F;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginRed input[type="submit"]:hover{
  background:#CF000F;
}

#loginPink  input[type="submit"]{
  width:100%;
  background:#D2527F;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginPink input[type="submit"]:hover{
  background:#D2527F;
}

#loginPurple  input[type="submit"]{
  width:100%;
  background:#674172;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginPurple input[type="submit"]:hover{
  background:#674172;
}


#register  input[type="submit"]{
  width:100%;
  background:#3399cc;
    margin: 10px 0;

  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#register input[type="submit"]:hover{
  background:#2288bb;
}

#registerRed  input[type="submit"]{
  width:100%;
    margin: 10px 0;

  background:#CF000F;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerRed input[type="submit"]:hover{
  background:#CF000F;
}

#registerPink  input[type="submit"]{
  width:100%;
    margin: 10px 0;

  background:#D2527F;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerPink input[type="submit"]:hover{
  background:#D2527F;
}

#registerPurple  input[type="submit"]{
  width:100%;
  background:#674172;
  border:0;
  padding:4%;
  margin: 10px 0;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerPurple input[type="submit"]:hover{
  background:#674172;
}


/* SQUARED TWO */
.squaredTwo {
  width: 28px;
  height: 28px;
  background: #fcfff4;

  background: -webkit-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  background: -moz-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  background: -o-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  background: -ms-linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  background: linear-gradient(top, #fcfff4 0%, #dfe5d7 40%, #b3bead 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fcfff4', endColorstr='#b3bead',GradientType=0 );
  
  -webkit-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
  -moz-box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
  box-shadow: inset 0px 1px 1px white, 0px 1px 3px rgba(0,0,0,0.5);
  position: relative;
}

.squaredTwo label {
  cursor: pointer;
  position: absolute;
  width: 20px;
  height: 20px;
  left: 4px;
  top: 4px;

  -webkit-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
  -moz-box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);
  box-shadow: inset 0px 1px 1px rgba(0,0,0,0.5), 0px 1px 0px rgba(255,255,255,1);

  background: -webkit-linear-gradient(top, #222 0%, #45484d 100%);
  background: -moz-linear-gradient(top, #222 0%, #45484d 100%);
  background: -o-linear-gradient(top, #222 0%, #45484d 100%);
  background: -ms-linear-gradient(top, #222 0%, #45484d 100%);
  background: linear-gradient(top, #222 0%, #45484d 100%);
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#222', endColorstr='#45484d',GradientType=0 );
}

.squaredTwo label:after {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
  filter: alpha(opacity=0);
  opacity: 0;
  content: '';
  position: absolute;
  width: 9px;
  height: 5px;
  background: transparent;
  top: 4px;
  left: 4px;
  border: 3px solid #fcfff4;
  border-top: none;
  border-right: none;

  -webkit-transform: rotate(-45deg);
  -moz-transform: rotate(-45deg);
  -o-transform: rotate(-45deg);
  -ms-transform: rotate(-45deg);
  transform: rotate(-45deg);
}

.squaredTwo label:hover::after {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";
  filter: alpha(opacity=30);
  opacity: 0.3;
}

.squaredTwo input[type=checkbox]:checked + label:after {
  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
  filter: alpha(opacity=100);
  opacity: 1;
}

</style>
<?  
}

?>