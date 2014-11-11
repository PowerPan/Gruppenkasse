<?
    //session_start();
    date_default_timezone_set('Europe/Berlin');
    header('Content-Type: text/html; charset=iso-8859-1');
	include_once("classMySQL.php");
    include_once("function.inc.php");
    
    include_once("classBenutzer.php");
    include_once("classContent.php");
    
    include_once("classGruppe.php");
    include_once("classTransaktion.php");

    session_start();
	$func = $_GET['func'];
    //print_r($_POST);
	switch($func){

////////////////////////////////////////////////////////////////////////////////////////////////////////////                                                 
        case "login_user":                              $benutzer = new Benutzer();
                                                        if($benutzer->login($_POST['username'],$_POST['passwort'])){
                                                            $_SESSION['benutzer'] = $benutzer;
                                                            
                                                             //header("Location: http://localhost/onvema");
                                                        }
                                                        else    
                                                            echo "Username oder Passwort falsch";
                                                            //echo md5("onpendel2004ma");
                                                        //
                                                        break;
        case "get_gruppenbenutzer_fuer_checkbox":       $gruppe = new Gruppe($_POST['gruppe']);
                                                        $gruppe->get_gruppenbenutzer_fuer_checkbox_json();
                                                        break;
        case "save_neue_transaktion":                   $transaktion = new Transaktion();
                                                        $transaktion->save_neu($_POST['benutzer'],$_POST['benutzer_dabei'],$_POST['gruppe'],$_POST['datum'],utf8_urldecode($_POST['beschreibung']),$_POST['betrag'],$_POST['eigeneteilnahme']);
                                                        break;
        case "delete_transaktion":                      $transaktion = new Transaktion($_POST['id']);
                                                        //print_r($transaktion);
                                                        $transaktion->delete();
                                                        break;
        case "save_neuen_bargeldausgleich":             $transaktion = new Transaktion();
                                                        $transaktion->save_neu_bargeldausgleich($_POST['benutzer'],$_POST['benutzer_dabei'],$_POST['gruppe'],$_POST['datum'],$_POST['betrag']);
                                                        break;
    
   }
    

?>