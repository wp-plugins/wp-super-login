<?php
/*
Plugin Name: Wp Super Login
Plugin URI: http://www.wpajans.net
Description: With this plugin now more your site will look good with a choice of 7 different themes wp-super-login plugin with you.
Version: 1.4.1
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
    add_option('custom_show', '#toggle-loginCustom,#toggle-registerCustom {
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
#toggle-loginCustom,#toggle-registerCustom span:last-child{border-left:0}


#toggle-loginCustom:hover,#toggle-registerCustom:hover{
  background:#D2527F;
}
#loginCustom{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginCustom h1{
  background:#CC337F;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}


#registerCustom{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerCustom h1{
  background:#CC337F;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}
#registerformCustom form, #registerCustom form{
  background:#F1A9A0;
  padding:6% 4%;
}
#loginformCustom form, #loginCustom form{
  background:#F1A9A0;
  padding:6% 4%;
}
#loginsCustom{
  background:#C3398D;
  padding:6% 4%;
  color:#111;
}
#loginCustom  input[type="submit"]{
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

#loginCustom input[type="submit"]:hover{
  background:#D2527F;
}
#registerCustom  input[type="submit"]{
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

#registerCustom input[type="submit"]:hover{
  background:#D2527F;
}');
}
register_deactivation_hook(__FILE__, 'eklenti_kaldirildi');
function eklenti_kaldirildi( ) {
    delete_option('eklenti_secenek');
    delete_option('theme_select');
    delete_option('custom_show');
}

add_action('admin_menu', 'wp_super_login');
 
function wp_super_login()
 {
 add_menu_page('Super Login','Super Login', '8', 'wp_super_login', 'eklentim_fonks');
 }
 
 function eklentim_fonks() {
 ?>
 <link rel=stylesheet href="<?php bloginfo('wpurl');?>/wp-content/plugins/wp-super-login/codemirror.css">
<script src="<?php bloginfo('wpurl');?>/wp-content/plugins/wp-super-login/codemirror.js"></script>
<script src="<?php bloginfo('wpurl');?>/wp-content/plugins/wp-super-login/xml.js"></script>
<style>
  .CodeMirror { height: auto; border: 1px solid #ddd; }
  .CodeMirror-scroll { max-height: 200px; }
  .CodeMirror pre { padding-left: 7px; line-height: 1.25; }
</style>
           <?php 
function plugin_name_get_version() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}
          ?>
<?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="English"){
?>
<div id="poststuff" class="metabox-holder has-right-sidebar">
              <div class="inner-sidebar">
                <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">


                              <div id="sm_pnres" class="postbox">
        <h3 class="hndle"><span>About this Plugin:</span></h3>
        <div class="inside">
          Plugin author : Mustafa KÜÇÜK<br>
          Plugin Company : <a target="_blank" href="http://www.wpajans.net">WpAJANS</a><br>
          Plugin Version : <?php echo plugin_name_get_version();?><br><br>
          You submit to us via WordPress for our free updates <a href="https://wordpress.org/support/view/plug the-reviews/wp-super-login"> ★★★★★ </a> can give :)
                                       </div>
      </div>
    
    

            </div>
          </div>
          
          <div class="has-sidebar sm-padded">

            <div id="post-body-content" class="has-sidebar-content">

              <div class="meta-box-sortabless">


          <!-- Rebuild Area -->
                <div id="sm_rebuild" class="postbox">
        <h3 class="hndle"><span>Wp Super Login Management Page</span></h3>
        <div class="inside">
    

 <div>
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
                      <option value="Yellow">Yellow</option>
                      <option value="Gray">Gray</option>
                      <option value="Orange">Orange</option>
                      <option value="Custom">Custom</option>
                    </select>
                    <br>
                                                <h2>Custom CSS</h2>

                      <div style="position: relative; margin-top: .5em;">
                        <textarea id="demotext" name="customcss"><?php echo $eklenti_bilgisi=get_option('custom_show')?></textarea>
</div>  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("demotext"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });
  </script>

                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                                </form>
        </div>


            </div>
                  </div>
      </div>
    
          

         


        </div>
        </div>
        </div>

 <?php }
  ?>
  <?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="Turkish"){
?>
<div id="poststuff" class="metabox-holder has-right-sidebar">
              <div class="inner-sidebar">
                <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">


                              <div id="sm_pnres" class="postbox">
        <h3 class="hndle"><span>Eklenti Hakkında:</span></h3>
        <div class="inside">
          Eklenti Yazarı : Mustafa KÜÇÜK<br>
          Eklentinin geliştirici şirketi : <a target="_blank" href="http://www.wpajans.net">WpAJANS</a><br>
          Eklenti Versiyonu : <?php echo plugin_name_get_version();?><br><br>
          Sizlere ücretsiz güncellemeler sunmamız için bize wordpress üzerinden <a href="https://wordpress.org/support/view/plugin-reviews/wp-super-login"> ★★★★★</a> verebilirsiniz :)
                                       </div>
      </div>
    
    

            </div>
          </div>
          
          <div class="has-sidebar sm-padded">

            <div id="post-body-content" class="has-sidebar-content">

              <div class="meta-box-sortabless">


          <!-- Rebuild Area -->
                <div id="sm_rebuild" class="postbox">
        <h3 class="hndle"><span>Eklenti yönetim sayfası</span></h3>
        <div class="inside">
    

 <div>
<?php echo "Mevcut Dil ".$eklenti_bilgisi=get_option('eklenti_secenek')?>
                <form method="post" action='<?php echo $_SERVER["REQUEST_URI"]; ?>'>
                    <label for="Langue">Lütfen Dil Seçiniz</label>
                    <select name="langue" id="">
                      <option value="English">İngilizce</option>
                      <option value="Turkish" selected>Türkçe</option>
                      <option value="French">Fransızca</option>
                    </select><br />
                     <h2>Tema Seç</h2>
           <?php echo "Mevcut Tema ".$eklenti_bilgisi=get_option('theme_select')?>
<br>
                   Lütfen Tema Seçin <select name="theme" id="">
                      <option value="Blue" selected>Mavi</option>
                      <option value="Pink">Pembe</option>
                      <option value="Purple">Mor</option>
                      <option value="Red">Kırmızı</option>
                      <option value="Yellow">Sarı</option>
                      <option value="Gray">Gri</option>
                      <option value="Orange">Turuncu</option>
                      <option value="Custom">Özel</option>

                    </select>
                    <br>
                       <h2>Özel CSS</h2>

                      <div style="position: relative; margin-top: .5em;">
                        <textarea id="demotext" name="customcss"><?php echo $eklenti_bilgisi=get_option('custom_show')?></textarea>
</div>  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("demotext"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });
  </script>
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                </form>
        </div></div>


            </div>
                  </div>
      </div>
    
          

         


        </div>
        </div>
        </div>
        <?}?>

     <?php if($eklenti_bilgisi=get_option('eklenti_secenek')=="French"){
?>



<div id="poststuff" class="metabox-holder has-right-sidebar">
              <div class="inner-sidebar">
                <div id="side-sortables" class="meta-box-sortabless ui-sortable" style="position:relative;">


                              <div id="sm_pnres" class="postbox">
        <h3 class="hndle"><span>A propos des plug-ins:</span></h3>
        <div class="inside">
          Annexes Auteur : Mustafa KÜÇÜK<br>
          La société de développement de plug-in : <a target="_blank" href="http://www.wpajans.net">WpAJANS</a><br>
          Plug-ins Version : <?php echo plugin_name_get_version();?><br><br>
          Vous nous soumettez via WordPress pour nos mises à jour gratuites <a href="https://wordpress.org/support/view/plug le super-login">-de-reviews/wp ★★★★★ </a> peut donner :)
                                       </div>
      </div>
    
    

            </div>
          </div>
          
          <div class="has-sidebar sm-padded">

            <div id="post-body-content" class="has-sidebar-content">

              <div class="meta-box-sortabless">


          <!-- Rebuild Area -->
                <div id="sm_rebuild" class="postbox">
        <h3 class="hndle"><span>Wp Super Login Gestion page</span></h3>
        <div class="inside">
    

 <div>



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
c                      <option value="Yellow">Sarı</option>
                      <option value="Gray">Gris</option>
                      <option value="Orange">Custom</option>

                    </select>
                    <br>
                      <h2>Custom CSS</h2>

                      <div style="position: relative; margin-top: .5em;">
                        <textarea id="demotext" name="customcss"><?php echo $eklenti_bilgisi=get_option('custom_show')?></textarea>
</div>  <script>
    var editor = CodeMirror.fromTextArea(document.getElementById("demotext"), {
      lineNumbers: true,
      mode: "text/html",
      matchBrackets: true
    });
  </script>
                    <input type="hidden" id="hidden" name="hidden" value="tmm"/><br />
                    <input type="submit" id="submit" name="submit" value="<?php _e('Save Changes'); ?>" />
                </form>
        </div>
</div>


            </div>
                  </div>
      </div>
    
          

         


        </div>
        </div>
        </div>
        <?}}

 if ($_POST['hidden'] == 'tmm') {
 $bizim_verimiz = $_POST['langue'];
 $theme_data = $_POST['theme'];
 $custom_data = $_POST['customcss'];
 update_option('eklenti_secenek', $bizim_verimiz);
 update_option('theme_select', $theme_data);
 update_option('custom_show', stripslashes($custom_data));
 
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
} if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo'<div id="loginYellow"><h1>';
}     if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo'<div id="loginGray"><h1>';
}    if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo'<div id="loginOrange"><h1>';
}   if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo'<div id="loginCustom"><h1>';
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
  }   if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo '<div id="loginsYellow">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo '<div id="loginsGray">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo '<div id="loginsOrange">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo '<div id="loginsCustom">';
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
  } if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo '<div id="loginsYellow">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo '<div id="loginsGray">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo '<div id="loginsOrange">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo '<div id="loginsCustom">';
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
  } if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo '<div id="loginsYellow">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo '<div id="loginsGray">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo '<div id="loginsOrange">';
  }if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo '<div id="loginsCutom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  ?>
  <span href="#" class="button" id="toggle-loginYellow">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerYellow">Kayıt Ol</span> 
  <?
  echo'<div id="loginYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  ?>
  <span href="#" class="button" id="toggle-loginGray">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerGray">Kayıt Ol</span> 
  <?
  echo'<div id="loginGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  ?>
  <span href="#" class="button" id="toggle-loginOrange">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerOrange">Kayıt Ol</span> 
  <?
  echo'<div id="loginOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  ?>
  <span href="#" class="button" id="toggle-loginCustom">Giriş Yap</span>
  <span href="#" class="button" id="toggle-registerCustom">Kayıt Ol</span> 
  <?
  echo'<div id="loginCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'loginformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'loginformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'loginformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'loginformCustom';
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
if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo'<div id="registerYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo'<div id="registerGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo'<div id="registerOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo'<div id="registerCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'registerformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'registerformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'registerformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'registerformCustom';
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
}if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  ?>
  <span href="#" class="button" id="toggle-loginYellow">Login</span>
  <span href="#" class="button" id="toggle-registerYellow">Register</span> 
  <?
  echo'<div id="loginYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  ?>
  <span href="#" class="button" id="toggle-loginGray">Login</span>
  <span href="#" class="button" id="toggle-registerGray">Register</span> 
  <?
  echo'<div id="loginGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  ?>
  <span href="#" class="button" id="toggle-loginOrange">Login</span>
  <span href="#" class="button" id="toggle-registerOrange">Register</span> 
  <?
  echo'<div id="loginOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  ?>
  <span href="#" class="button" id="toggle-loginCustom">Login</span>
  <span href="#" class="button" id="toggle-registerCustom">Register</span> 
  <?
  echo'<div id="loginCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'loginformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'loginformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'loginformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'loginformCustom';
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
}if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo'<div id="registerYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo'<div id="registerGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo'<div id="registerOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo'<div id="registerCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'registerformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'registerformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'registerformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'registerformCustom';
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
}if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  ?>
  <span href="#" class="button" id="toggle-loginYellow">S'identifier</span>
  <span href="#" class="button" id="toggle-registerYellow">Se enregistrer</span> 
  <?
  echo'<div id="loginYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  ?>
  <span href="#" class="button" id="toggle-loginGray">S'identifier</span>
  <span href="#" class="button" id="toggle-registerGray">Se enregistrer</span> 
  <?
  echo'<div id="loginGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  ?>
  <span href="#" class="button" id="toggle-loginOrange">S'identifier</span>
  <span href="#" class="button" id="toggle-registerOrange">Se enregistrer</span> 
  <?
  echo'<div id="loginOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  ?>
  <span href="#" class="button" id="toggle-loginCustom">S'identifier</span>
  <span href="#" class="button" id="toggle-registerCustom">Se enregistrer</span> 
  <?
  echo'<div id="loginCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'loginformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'loginformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'loginformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'loginformCustom';
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
}if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
  echo'<div id="registerYellow">';
}if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
  echo'<div id="registerGray">';
}if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
  echo'<div id="registerOrange">';
}if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
  echo'<div id="registerCustom">';
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
}if($eklenti_bilgisi=get_option('theme_select')=='Yellow'){
  echo'registerformYellow';
}if($eklenti_bilgisi=get_option('theme_select')=='Gray'){
  echo'registerformGray';
}if($eklenti_bilgisi=get_option('theme_select')=='Orange'){
  echo'registerformOrange';
}if($eklenti_bilgisi=get_option('theme_select')=='Custom'){
  echo'registerformCustom';
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


<?php if($eklenti_bilgisi=get_option('theme_select')=="Yellow"){
?>
  $('#registerYellow').hide();
  $('#toggle-loginYellow').attr('style',  'background-color:#FFA631');

$('#toggle-registerYellow').click(function(){
  $('#loginYellow').hide();
  $('#registerYellow').show();
  $('#toggle-loginYellow').removeAttr('style',  'background-color:#FFA631');
  $('#toggle-registerYellow').attr('style',  'background-color:#FFA631');


  $('#toggle-loginYellow').click(function(){
  $('#registerYellow').hide();
  $('#toggle-registerYellow').removeAttr('style',  'background-color:#FFA631');
  $('#toggle-loginYellow').attr('style',  'background-color:#FFA631');
  $('#loginYellow').show();

<?}?>


<?php if($eklenti_bilgisi=get_option('theme_select')=="Gray"){
?>
  $('#registerGray').hide();
  $('#toggle-loginGray').attr('style',  'background-color:#6C7A89');

$('#toggle-registerGray').click(function(){
  $('#loginGray').hide();
  $('#registerGray').show();
  $('#toggle-loginGray').removeAttr('style',  'background-color:#6C7A89');
  $('#toggle-registerGray').attr('style',  'background-color:#6C7A89');


  $('#toggle-loginGray').click(function(){
  $('#registerGray').hide();
  $('#toggle-registerGray').removeAttr('style',  'background-color:#6C7A89');
  $('#toggle-loginGray').attr('style',  'background-color:#6C7A89');
  $('#loginGray').show();

<?}?>


<?php if($eklenti_bilgisi=get_option('theme_select')=="Orange"){
?>
  $('#registerOrange').hide();
  $('#toggle-loginOrange').attr('style',  'background-color:#F89406');

$('#toggle-registerOrange').click(function(){
  $('#loginOrange').hide();
  $('#registerOrange').show();
  $('#toggle-loginOrange').removeAttr('style',  'background-color:#F89406');
  $('#toggle-registerOrange').attr('style',  'background-color:#F89406');


  $('#toggle-loginOrange').click(function(){
  $('#registerOrange').hide();
  $('#toggle-registerOrange').removeAttr('style',  'background-color:#F89406');
  $('#toggle-loginOrange').attr('style',  'background-color:#F89406');
  $('#loginOrange').show();

<?}?>

<?php if($eklenti_bilgisi=get_option('theme_select')=="Custom"){
?>
  $('#registerCustom').hide();
  $('#toggle-loginCustom').attr('style',  'background-color:#F89406');

$('#toggle-registerCustom').click(function(){
  $('#loginCustom').hide();
  $('#registerCustom').show();
  $('#toggle-loginCustom').removeAttr('style',  'background-color:#F89406');
  $('#toggle-registerCustom').attr('style',  'background-color:#F89406');


  $('#toggle-loginCustom').click(function(){
  $('#registerCustom').hide();
  $('#toggle-registerCustom').removeAttr('style',  'background-color:#F89406');
  $('#toggle-loginCustom').attr('style',  'background-color:#F89406');
  $('#loginCustom').show();

<?}?>


});});</script>
<style>@import url(http://fonts.googleapis.com/css?family=Open+Sans:300,400,700);

/* General */
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

/* Theme Custom */
<?php echo $eklenti_bilgisi=get_option('custom_show');?>


/***********************************************************************/




/* Theme Blue */

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
#registerform form, #register form{
  background:#f0f0f0;
  padding:6% 4%;
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

/***********************************************************************/

/* Theme Pink */
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
#toggle-loginPink,#toggle-registerPink span:last-child{border-left:0}


#toggle-loginPink:hover,#toggle-registerPink:hover{
  background:#D2527F;
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
#registerformPink form, #registerPink form{
  background:#F1A9A0;
  padding:6% 4%;
}
#loginformPink form, #loginPink form{
  background:#F1A9A0;
  padding:6% 4%;
}
#loginsPink{
  background:#C3398D;
  padding:6% 4%;
  color:#111;
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

/***********************************************************************/



/* Theme Orange */
#toggle-loginOrange,#toggle-registerOrange {
width: 125px;
  background: #E87E04;
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
#toggle-loginOrange,#toggle-registerOrange span:last-child{border-left:0}


#toggle-loginOrange:hover,#toggle-registerOrange:hover{
  background:#E87E04;
}
#loginOrange{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginOrange h1{
  background:#D35400;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}


#registerOrange{
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerOrange h1{
  background:#D35400;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#fff;
}
#registerformOrange form, #registerOrange form{
  background:#F39C12;
  padding:6% 4%;
}
#loginformOrange form, #loginOrange form{
  background:#F39C12;
  padding:6% 4%;
}
#loginsOrange{
  background:#F39C12;
  padding:6% 4%;
  color:#111;
}
#loginOrange  input[type="submit"]{
  width:100%;
  background:#D35400;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginOrange input[type="submit"]:hover{
  background:#F9690E;
}
#registerOrange  input[type="submit"]{
  width:100%;
    margin: 10px 0;

  background:#D35400;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerOrange input[type="submit"]:hover{
  background:#F9690E;
}

/***********************************************************************/


/* Theme Yellow */

#toggle-loginYellow,#toggle-registerYellow {
width: 125px;
  background: #F7CA18;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #000;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-loginYellow,#toggle-registerYellow span:last-child{border-left:0}


#toggle-loginYellow:hover,#toggle-registerYellow:hover{
  background:#F4D03F;
}
#loginYellow {
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginYellow h1{
  background:#F5D76E;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#000;
}
#registerYellow {
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerYellow h1{
  background:#F5D76E;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#000;
}
#registerformYellow form, #registerYellow form{
  background:#CA6924;
  padding:6% 4%;
}
#loginformYellow form, #loginYellow form{
  background:#CA6924;
  padding:6% 4%;
}
#loginsYellow{
  background:#CA6924;
  padding:6% 4%;
  color:#111;
}
#loginYellow  input[type="submit"]{
  width:100%;
  background:#F5AB35;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginYellow input[type="submit"]:hover{
  background:#F9690E;
}
#registerYellow  input[type="submit"]{
  width:100%;
    margin: 10px 0;

  background:#F5AB35;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerYellow input[type="submit"]:hover{
  background:#F9690E;
}

/***********************************************************************/

/* Theme Gray */

#toggle-loginGray,#toggle-registerGray {
width: 125px;
  background: #D2D7D3;
  display: block;
  margin: 0 auto;
  margin-top: 1%;
  padding: 10px;
  text-align: center;
  text-decoration: none;
  color: #000;
  cursor: pointer;
  transition: background .3s;
  border-left: 1px solid #fff;
  -webkit-transition: background .3s;
  float: left;
}
#toggle-loginGray,#toggle-registerGray span:last-child{border-left:0}


#toggle-loginGray:hover,#toggle-registerGray:hover{
  background:#BDC3C7;
}
#loginGray {
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#loginGray h1{
  background:#ABB7B7;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#000;
}
#registerGray {
  margin:0 auto;
  margin-top:8px;
  margin-bottom:2%;
  transition:opacity 1s;
  -webkit-transition:opacity 1s;
}


#registerGray h1{
  background:#ABB7B7;
  padding:20px 0;
  font-size:140%;
  font-weight:300;
  text-align:center;
  color:#000;
}
#registerformGray form, #registerGray form{
  background:#95A5A6;
  padding:6% 4%;
}
#loginformGray form, #loginGray form{
  background:#95A5A6;
  padding:6% 4%;
}
#loginsGray{
  background:#95A5A6;
  padding:6% 4%;
  color:#111;
}
#loginGray  input[type="submit"]{
  width:100%;
  background:#787878;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#loginGray input[type="submit"]:hover{
  background:#DADFE1;
}
#registerGray  input[type="submit"]{
  width:100%;
    margin: 10px 0;

  background:#787878;
  border:0;
  padding:4%;
  font-family:".Open Sans.",sans-serif;
  font-size:100%;
  color:#fff;
  cursor:pointer;
  transition:background .3s;
  -webkit-transition:background .3s;
}

#registerGray input[type="submit"]:hover{
  background:#DADFE1;
}

/***********************************************************************/

/* Theme Purple */

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
#registerformPurple form, #registerPurple form{
  background:#AEA8D3;
  padding:6% 4%;
}
#loginformPurple form, #loginPurple form{
  background:#AEA8D3;
  padding:6% 4%;
}
#loginsPurple{
  background:#AEA8D3;
  padding:6% 4%;
  color:#111;
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

/***********************************************************************/

/* Theme Red */

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
#registerformRed form, #registerRed form{
  background:#96281B;
  padding:6% 4%;
}
#loginformRed form, #loginRed form{
  background:#96281B;
  padding:6% 4%;
}
#loginsRed{
  background:#96281B;
  padding:6% 4%;
  color:#111;
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

/***********************************************************************/

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