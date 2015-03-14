<?php
/*
Plugin Name: Wp Super Login
Plugin URI: http://www.wpajans.net
Description: Theme sidebar add login box.
Version: 1.1
Author: WpAJANS
Author URI: http://www.wpajans.net
License: GNU
*/

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
?>
 <div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
 <?php
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
if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'<div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="loginPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
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
    <input type="submit" name="submit" id="login" value="Giriş Yap" />
  </form>
</div>
<?}?>
<? if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'<div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="loginPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
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
width: 150px;">Remember me!</div></div>

    <input type="submit" name="submit" id="login" value="Login" />
  </form>
</div>
<?}?>
<? if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){

?>

<?php 
if($eklenti_bilgisi=get_option('theme_select')=="Blue"){

  echo'<div id="login">';
           }
if($eklenti_bilgisi=get_option('theme_select')=="Pink"){
  echo'<div id="loginPink">';
}
if($eklenti_bilgisi=get_option('theme_select')=="Purple"){
  echo'<div id="loginPurple">';
}if($eklenti_bilgisi=get_option('theme_select')=="Red"){
  echo'<div id="loginRed">';
}
?>   <h1>S'identifier</h1>
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
<?}?>
<?
} endif;
?>
<style>@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

*{margin:0;padding:0;}

.squaredTwo input[type=checkbox] {
  visibility: hidden;
}
.button{
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