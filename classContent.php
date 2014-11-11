<?php

/**
 * @author Johannes Rudolph
 * @copyright 2011
 */

class Content {
    
    private $seite;
    private $inventarseiten;
    private $adresseiten;
    private $auftragsseiten;
      
    function __construct(){
        if(isset($_GET['seite'])){
            $this->seite = $_GET['seite'];     
        }     
        else{
            $this->seite = "start";
        }  
    }
    
    public function ausgabe($seite){
        $this->mainmenue();
        if(isset($_SESSION['benutzer'])){
            switch($seite){
               
                case "start":                   echo "eingeloogt";
                                                    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
                case "meinegruppen":                $_SESSION['benutzer']->print_benutzer_gruppen();
                                                    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
                case "meinedaten":                 $_SESSION['benutzer']->print_meine_daten();
                                                    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
                case "neuetransaktion":             $transaktion = new Transaktion();
                                                    $transaktion->print_neue_transaktion_form();
                                                    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
                case "neuerbargeldausgleich":       $transaktion = new Transaktion();
                                                    $transaktion->print_neuer_bargeldausgleich_form();
                                                    break;
////////////////////////////////////////////////////////////////////////////////////////////////////////////
                case "transaktion":                 $transaktion = new Transaktion();
                                                    $transaktion->print_transaktions_uebersicht_benutzer($_SESSION['benutzer']->get_id());
                                                    break;
            }
        }
        else{
            $benutzer = new Benutzer();
            $benutzer->print_login_form();
        }
    }

    
    public function mainmenue(){
        echo "<table>";
        echo "<tr>";
        $this->menue_punkt("Neue Transaktionen","neuetransaktion");
        $this->menue_punkt("Neuer Bargeldausgleich","neuerbargeldausgleich");
        $this->menue_punkt("Meine Daten","meinedaten");
        $this->menue_punkt("Meine Gruppen","meinegruppen");
        $this->menue_punkt("Transaktionen","transaktion");
        $this->menue_punkt("Logout","logout");
        echo "</tr>";
        echo "</table>";
    }
    
    public function footer(){
        echo "<p>Developed by <a href=\"http://twitter.com/umutm\">Umut Muhaddisoglu</a> 2008. Updated for HTML5/CSS3 by <a href=\"http://mediagearhead.com\">Giles Wells</a> 2010.</p>";    
    }
    
    private function menue_punkt($Name,$Link){
        echo "<td>[&nbsp;";
        echo "<a ";
        echo "href=\"?seite=".$Link."\">".$Name."</a>";
        echo "&nbsp;]</td>\n";
    }
    
    public function print_div_top_bar($title,$linkbox = null,$link = null){
        
    }
}

?>