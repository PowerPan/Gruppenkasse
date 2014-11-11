<?php

/**
 * @author Johannes Rudolph
 * @copyright 2012
 */


class Transaktion {
    
    private $id;
    private $datum;
    private $beschreibung;
    private $betrag;
    private $einzelsumme;
    private $benutzer_id;
    private $gruppe_id;
    private $benutzer_dabei;
    private $typ;
    
    function __construct($id = null)
    {
        $this->mysql =  new MySQL;
        if($id)
        {
            $this->set_id($id);
        }            
    }
    
    private function set_id($id){
        $this->id = $id;
        $this->read();    
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function read(){
        $mysql = new MySQL;
        $mysql->query("select datum,beschreibung,betrag,einzelsumme,benutzer_id,gruppe_id,save_datum,typ from transaktionen where id = '".$this->id."'");    
        $row = $mysql->fetchRow();
        $this->datum = $row['datum'];
        $this->beschreibung = $row['beschreibung'];
        $this->betrag = $row['betrag'];
        $this->benutzer_id = $row['benutzer_id'];
        $this->gruppe_id = $row['gruppe_id'];
        $this->typ = $row['typ'];
        $this->einzelsumme = $row['einzelsumme'];
        
        $mysql->query("select benutzer_id from ver_transaktion_benutzer where transaktion_id = '".$this->id."'");
        while($row = $mysql->fetchRow()){
            $this->benutzer_dabei[] = $row['benutzer_id'];
        }  
    } 
    
    public function print_neue_transaktion_form(){
        $gruppe = new Gruppe();
        $gruppen = $gruppe->get_gruppen_benutzer_for_selectbox($_SESSION['benutzer']->get_id());
        if(count($gruppen) == 1){
            $gruppe->set_id($gruppen[0]['id']);
            $teilnehmer = $gruppe->get_gruppenbenutzer_fuer_checkbox_selectbox();
            foreach($teilnehmer as $benutzer){
                $teilnehmer_checkboxen[] = input_checkbox_text("benutzer_".$benutzer['id'],$benutzer['name']);
                $teilnhemer_id[] = $benutzer['id'];
            }
            $teilnehmer_checkboxen = implode("<br />\n",$teilnehmer_checkboxen);
            $teilnhemer_id = implode(",",$teilnhemer_id);
            $teilnehmer_checkboxen .= "\n".input_hidden("benutzer_ids",$teilnhemer_id);
        }
        echo print_table_kopf("true","","");
        echo print_table_zeile("Datum",input_text_date_jquery("datum"));
        echo print_table_zeile("Beschreibung",input_text("beschreibung"));
        if(count($gruppen) > 1)
            echo print_table_zeile("Gruppe",selectbox("gruppe",$gruppen,false,false,false,false,"read_benutzer_zu_gruppe_checkboxen()",count($gruppen)));
        else
            echo "<input type=\"hidden\" value=\"".$gruppen[0]['id']."\" id=\"selectbox_gruppe\">";
        $divteilnehmer = "<div id=\"teilnehmer\">\n";
        $divteilnehmer .= $teilnehmer_checkboxen;
        $divteilnehmer .= "</div>";
        echo print_table_zeile("Teilnehmer",$divteilnehmer);
        echo print_table_zeile("Ich hab mich da auch dran beteiligt?",input_checkbox_text('eigeneteilnahme',$_SESSION['benutzer']->get_name(),true));
        echo print_table_zeile("Betrag",input_text("betrag")." €");
        
        echo print_table_zeile("&nbsp;",button_javasctipt("speichern","save_neue_transaktion()"));
        echo print_table_fuß();
        echo input_hidden("benutzer_id",$_SESSION['benutzer']->get_id());
    }
    
    public function print_neuer_bargeldausgleich_form(){
        $gruppe = new Gruppe();
        $gruppen = $gruppe->get_gruppen_benutzer_for_selectbox($_SESSION['benutzer']->get_id());
        if(count($gruppen) == 1){
            $gruppe->set_id($gruppen[0]['id']);
            $teilnehmer = $gruppe->get_gruppenbenutzer_fuer_checkbox_selectbox(); 
            $teilnehmer_selectbox = selectbox("anbenutzer",$teilnehmer,null,null,null,null,null,count($teilnehmer));           
        }
        echo print_table_kopf("true","","");
        echo print_table_zeile("Datum",input_text_date_jquery("datum"));
        if(count($gruppen) > 1)
            echo print_table_zeile("Gruppe",selectbox("gruppe",$gruppen,false,false,false,false,"read_benutzer_zu_gruppe_selectbox()",count($gruppen)));
        else
            echo "<input type=\"hidden\" value=\"".$gruppen[0]['id']."\" id=\"selectbox_gruppe\">";
        $divteilnehmer = "<div id=\"teilnehmer\">\n";
        $divteilnehmer .= $teilnehmer_selectbox;
        $divteilnehmer .= "</div>";
        echo print_table_zeile("An",$divteilnehmer);
        echo print_table_zeile("Betrag",input_text("betrag")." €");
        
        echo print_table_zeile("&nbsp;",button_javasctipt("speichern","save_neuer_bargeldausgleich()"));
        echo print_table_fuß();
        echo input_hidden("benutzer_id",$_SESSION['benutzer']->get_id());    
    }
     
    public function save_neu($benutzer,$benutzer_dabei,$gruppe,$datum,$beschreibung,$betrag,$eigeneteilnahme){
        $betrag = str_replace(",",".",$betrag);
        
        //Werte auf Fehler überprüfen
        if($benutzer_dabei == ""){
            echo "Keine Beteiligte Person ausgewählt";
            return false;
        }
        if($datum == ""){
            echo "Kein Datum angegeben";
            return false;    
        }
        if(strlen($beschreibung) < 10){
            echo "Die Beschreibung ist zu Kurz";
            return false;
        }
        if($betrag == ""){
            echo "Kein Betrag angegeben";
            return false;    
        }
        if($betrag < 0){
            echo "Negativ Beträge sind nicht zulässig";
            return false;    
        }
        if($betrag < 0.01){
            echo "Es sollte mindestestens 1ct sein";
            return false;    
        }
        $mysql = new MySQL();
        if($eigeneteilnahme == "true")
            $einzelsumme = $betrag/(count($benutzer_dabei)+1);
        else 
            $einzelsumme = $betrag/(count($benutzer_dabei));
        $mysql->query("insert into transaktionen (datum,beschreibung,betrag,einzelsumme,benutzer_id,gruppe_id,save_datum) values ('".date_german2mysql($datum)."','".$beschreibung."','".$betrag."','".$einzelsumme."','".$benutzer."','".$gruppe."',NOW())");  
        $transaktion_id = $mysql->last_insert_id;
        if($eigeneteilnahme == "true")
            $query[] = "('".$transaktion_id."','".$benutzer."')";
        foreach ($benutzer_dabei as $benutzerdabei){
            $query[] = "('".$transaktion_id."','".$benutzerdabei."')";
        }
        $query = implode(",",$query);
        $query = "insert into ver_transaktion_benutzer (transaktion_id,benutzer_id) values ".$query;
        $mysql->query($query);
        foreach ($benutzer_dabei as $benutzerdabei){
            $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzerdabei."' and gruppe_id = '".$gruppe."'");
            $row = $mysql->fetchRow();
            $kontostand = $row['kontostand'] - $einzelsumme;
            $mysql->query("update ver_benutzer_gruppe set kontostand = '".$kontostand."' where benutzer_id = '".$benutzerdabei."' and gruppe_id = '".$gruppe."'");   
        }
        $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'");
        $row = $mysql->fetchRow();
        
            $kontostand = $row['kontostand'] + ($einzelsumme * count($benutzer_dabei));
            $mysql->query("update ver_benutzer_gruppe set kontostand = '".$kontostand."' where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'");        
        
    }
    
    public function save_neu_bargeldausgleich($benutzer,$benutzer_dabei,$gruppe,$datum,$betrag){
        $betrag = str_replace(",",".",$betrag);
        
        //Werte auf Fehler überprüfen
        if($benutzer_dabei == ""){
            echo "Keine Beteiligte Person ausgewählt";
            return false;
        }
        if($datum == ""){
            echo "Kein Datum angegeben";
            return false;    
        }
        if($betrag == ""){
            echo "Kein Betrag angegeben";
            return false;    
        }
        if($betrag < 0){
            echo "Negativ Beträge sind nicht zulässig";
            return false;    
        }
        $mysql = new MySQL();
        $mysql->query("insert into transaktionen (datum,beschreibung,betrag,einzelsumme,benutzer_id,gruppe_id,save_datum,typ) values ('".date_german2mysql($datum)."','Bargeldausgleich','".$betrag."','".$einzelsumme."','".$benutzer."','".$gruppe."',NOW(),2)");  
        $transaktion_id = $mysql->last_insert_id;    
        $query = "insert into ver_transaktion_benutzer (transaktion_id,benutzer_id) values ('".$transaktion_id."','".$benutzer_dabei."')";
        $mysql->query($query);
        $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzer_dabei."' and gruppe_id = '".$gruppe."'");
        $row = $mysql->fetchRow();
        $kontostand = $row['kontostand'] - $betrag;
        $mysql->query("update ver_benutzer_gruppe set kontostand = '".$kontostand."' where benutzer_id = '".$benutzer_dabei."' and gruppe_id = '".$gruppe."'");
        $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'");
        $row = $mysql->fetchRow();
        $kontostand = $row['kontostand'] + $betrag;
        $mysql->query("update ver_benutzer_gruppe set kontostand = '".$kontostand."' where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'");
    }
    
    public function print_transaktions_uebersicht_benutzer($benutzer){
        echo print_table_kopf("","#","Datum","Beschreibung","Betrag","Erstellt Von","Beteiligte Personen"," ");
        $mysql = new MySQL;
        $mysql->query("select t.id,t.datum,t.beschreibung,FORMAT(t.betrag,2)betrag,t.benutzer_id from transaktionen t left join ver_transaktion_benutzer as vbt on (vbt.transaktion_id = t.id) where vbt.benutzer_id = '".$benutzer."' or t.benutzer_id = '".$benutzer."' group by  t.id,t.datum,t.beschreibung,t.betrag,t.benutzer_id order by datum desc,save_datum desc");
        while($row = $mysql->fetchRow()){
            $benutzer_erstellt = new Benutzer($row['benutzer_id']);
            $liste_beteiligte_personen = $this->get_beteiligtepersonen_liste($row['id']);
            $loeschbutton = "&nbsp;";
            if($benutzer_erstellt->get_id() == $_SESSION['benutzer']->get_id()){
                $loeschbutton = "<img src=\"img/delete.png\" onclick=\"delete_transaktion(".$row['id'].")\"/ style=\"cursor: pointer\">";
            }
            echo print_table_zeile($row['id'],date_mysql2german($row['datum']),$row['beschreibung'],$row['betrag']." €",$benutzer_erstellt->get_name(),$liste_beteiligte_personen,$loeschbutton);
        }
        
        echo print_table_fuß();
    }
    
    public function delete(){
        $mysql = new MySQL;
        if($this->typ == 1){
            //print_r($this->benutzer_dabei);   
            //Kontostand ersteller anpassen 
            $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$this->benutzer_id."' and gruppe_id = '".$this->gruppe_id."'"); 
            $row = $mysql->fetchRow();
            $kontostand = $row['kontostand'];
            
            echo $kontostand - $abzug;
            $row['kontostand'] = $row['kontostand'] - ($this->einzelsumme*count($this->benutzer_dabei));
            //echo $row['kontostand'];
            $mysql->query("update ver_benutzer_gruppe set kontostand = '".$row['kontostand']."' where benutzer_id = '".$this->benutzer_id."' and gruppe_id = '".$this->gruppe_id."'"); 
            //Kontostand empfänger anpasen
            foreach($this->benutzer_dabei as $teilnehmer){
                if($teilnehmer != $this->benutzer){
                    $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$teilnehmer."' and gruppe_id = '".$this->gruppe_id."'"); 
                    $row = $mysql->fetchRow();
                    $row['kontostand'] = $row['kontostand'] + $this->einzelsumme;
                    $mysql->query("update ver_benutzer_gruppe set kontostand = '".$row['kontostand']."' where benutzer_id = '".$teilnehmer."' and gruppe_id = '".$this->gruppe_id."'");  
                }
            }
        }   
        else{
            //Bargeldausgleich
            $this->benutzer_dabei = $this->benutzer_dabei[0];
            //Kontostand ersteller anpassen 
            $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$this->benutzer_id."' and gruppe_id = '".$this->gruppe_id."'"); 
            $row = $mysql->fetchRow();
            $row['kontostand'] = $row['kontostand'] - $this->betrag;
            $mysql->query("update ver_benutzer_gruppe set kontostand = '".$row['kontostand']."' where benutzer_id = '".$this->benutzer_id."' and gruppe_id = '".$this->gruppe_id."'"); 
            //Kontostand empfänger anpasen
            $mysql->query("select kontostand from ver_benutzer_gruppe where benutzer_id = '".$this->benutzer_dabei."' and gruppe_id = '".$this->gruppe_id."'"); 
            $row = $mysql->fetchRow();
            $row['kontostand'] = $row['kontostand'] + $this->betrag;
            $mysql->query("update ver_benutzer_gruppe set kontostand = '".$row['kontostand']."' where benutzer_id = '".$this->benutzer_dabei."' and gruppe_id = '".$this->gruppe_id."'");      
        }  
        $mysql->query("delete from ver_transaktion_benutzer where transaktion_id = '".$this->id."'"); 
        $mysql->query("delete from transaktionen where id = '".$this->id."'"); 
    }
    
    public function get_beteiligtepersonen_liste($transaktion){
        $mysql = new MySQL;
        $mysql->query("select benutzer_id from ver_transaktion_benutzer where transaktion_id = '".$transaktion."'");
        while($row = $mysql->fetchRow()){
            $benutzer = new Benutzer($row['benutzer_id']);
            $personen[] = $benutzer->get_name();
        }    
        $personen = implode("<br />",$personen);
        return $personen;
    }
}
?>