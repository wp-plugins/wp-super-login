<?php
/*
Plugin Name: Wp Super Login
Plugin URI: http://www.wpajans.net
Description: Theme sidebar add login box.
Version: 1.0
Author: WpAJANS
Author URI: http://www.wpajans.net
License: GNU
*/

//Varsayılan Değer Atayalım
register_activation_hook(__FILE__, 'eklenti_varsayilan');
function eklenti_varsayilan( ) {
    add_option('eklenti_secenek', 'English');
}
//Değerleri Silelim
register_deactivation_hook(__FILE__, 'eklenti_kaldirildi');
function eklenti_kaldirildi( ) {
    delete_option('eklenti_secenek');
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
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                </form>
        </div>
        <?}}

//Değerlerimizi güncelleyelim
 if ($_POST['hidden'] == 'tmm') {
 //Gönderdiğimiz veriyi alalım
 $bizim_verimiz = $_POST['langue'];
 update_option('eklenti_secenek', $bizim_verimiz);
?>
 <div class="updated"><p><strong><?php _e('Options saved.'); ?></strong></p></div>
 <?php
 }
function login_add(){
if (is_user_logged_in()): {
	    $current_user = wp_get_current_user();

	echo'

<div id="login">
  <h1>
              
             ';

             if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){

 echo'Hi! '.$current_user->display_name.'</h1>
  <div id="logins">
<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Dashboard</a>
	<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/profile.php">Edit My Profile</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Sign Out</a>
  </div>
</div>
';
}
else if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){
echo'Merhaba '.$current_user->display_name.'</h1>
  <div id="logins">
<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Başlangıç</a>
	<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/profile.php">Profilimi Düzenle</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Çıkış Yap</a>
  </div>
</div>
';
}

else if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){
echo'Bonjour Il '.$current_user->display_name.'</h1>
  <div id="logins">
<a id="btns" href="'.get_bloginfo("wpurl").'/wp-admin/">Début</a>
	<a id="btns" href="'.get_bloginfo("wpurl")
	.'/wp-admin/profile.php">Modifier mon profil</a>

<a id="btns" href="'.wp_logout_url($_SERVER['REQUEST_URI']).'">Se Déconnecter</a>
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

<div id="login">
  <h1>Giriş Yap</h1>
  <form name="loginform" id="loginform" action="<?php bloginfo("url");?>/wp-login.php" method="post">
    <input type="text" name="log" placeholder="Kullanıcı Adınız" />
    <input type="password" name="pwd" placeholder="Şifreniz" />
    <input type="submit" name="submit" id="login" value="Giriş Yap" />
  </form>
</div>
<?}?>
<? if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){

?>

<div id="login">
  <h1>Login</h1>
  <form name="loginform" id="loginform" action="<?php bloginfo("url");?>/wp-login.php" method="post">
    <input type="text" name="log" placeholder="User Name" />
    <input type="password" name="pwd" placeholder="Password" />
    <input type="submit" name="submit" id="login" value="Login" />
  </form>
</div>
<?}?>
<? if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){

?>

<div id="login">
  <h1>S'identifier</h1>
  <form name="loginform" id="loginform" action="<?php bloginfo("url");?>/wp-login.php" method="post">
    <input type="text" name="log" placeholder="Nom d'utilisateur" />
    <input type="password" name="pwd" placeholder="votre mot de passe" />
    <input type="submit" name="submit" id="login" value="S'identifier" />
  </form>
</div>
<?}?>
<?
} endif;
echo'
<style>@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

*{margin:0;padding:0;}


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

#loginform form, #login form{
  background:#f0f0f0;
  padding:6% 4%;
}
#logins{
  background:#f0f0f0;
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

#login input[type="submit"]{
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
</style>
';
}

?>