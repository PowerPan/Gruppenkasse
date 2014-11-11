<?php

/**
 * @author Johannes Rudolph
 * @copyright 2011
 */

class Benutzer {
    
    private $id;
    private $email;
    private $vorname;
    private $name;
    private $last_login;
    
    private $gruppen;
    private $mysql;
    
    
    function __construct($benutzer_id = null)
    {
        $this->mysql =  new MySQL;
        if($benutzer_id)
        {
            $this->set_id($benutzer_id);
        }            
    }
    
    private function set_id($id){
        $this->id = $id;
        $this->read();    
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function get_name(){
        return $this->vorname." ".$this->name;
    }
    
    private function read_benutzer_gruppen(){
        $mysql = new MySQL();
        $this->gruppen = "";
        $mysql->query("select gruppe_id from ver_benutzer_gruppe where benutzer_id = '".$this->id."'");
        while($row = $mysql->fetchRow()){
            $this->gruppen[] = $row['gruppe_id'];
        }    
    }
    
    private function get_kontostand_in_gruppe($benutzer,$gruppe){
        $mysql = new MySQL;
        $mysql->query("select round(kontostand,2) kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'");
        //echo "select kontostand from ver_benutzer_gruppe where benutzer_id = '".$benutzer."' and gruppe_id = '".$gruppe."'";
        $row = $mysql->fetchRow();
        return $row['kontostand']." Ä";
    }
    
    private function read(){
        $mysql = new MySQL();
        $mysql->query("select
                        b.id
                        ,b.vorname
                        ,b.name
                        ,b.last_login
                        ,b.email
                    from
                        benutzer b
                        
                    where
                        b.id = '".$this->id."'
                    ");
        $row = $mysql->fetchRow();
        //print_r($row);
        $this->email =$row['email'];
        $this->vorname = $row['vorname'];
        $this->name = $row['name'];
        $this->last_login = $row['last_login'];
        $this->read_benutzer_gruppen();
        
    }
    
    public function print_benutzer_gruppen(){
        //print_r($this->gruppen);
        echo print_table_kopf("false","Gruppe","Mitglieder","Kontostand");
        //print_r($this->gruppen);
        foreach($this->gruppen as $gruppe){
            $firstrow = 0;
            $gruppe = new Gruppe($gruppe);
            foreach($gruppe->get_benutzer() as $benutzer){
                $benutzer = new Benutzer($benutzer);
                if($firstrow == 0)
                    echo print_table_zeile($gruppe->get_name(),$benutzer->get_name(),$this->get_kontostand_in_gruppe($benutzer->get_id(),$gruppe->get_id()));
                else
                    echo print_table_zeile("&nbsp;",$benutzer->get_name(),$this->get_kontostand_in_gruppe($benutzer->get_id(),$gruppe->get_id())); 
                $firstrow = 1;
                
            } 
        }
        echo print_table_fuﬂ();
    }
    
    public function login($username,$passwort){
        $this->mysql->query("select b.passwort_md5,b.id from benutzer b where b.email = '".$username."'");
        $passwort = md5("on".$passwort."ma");
        //echo $passwort;
        //echo "select b.passwort,b.id from benutzer b left join adressen as a on (b.adressen_id = a.id) where a.email = '".$username."'";
        $row = $this->mysql->fetchRow();
        if($row['passwort_md5'] == $passwort){
            $this->set_id($row['id']);
            $this->mysql->query("update benutzer set last_login = NOW() where id = ".$this->id."");
            return true;
        }
        else
            return false;
    }
    
    public function print_meine_daten(){
        $this->read();
        echo print_table_kopf("false","Meine Daten"," ");
        echo print_table_zeile("Name",$this->vorname." ".$this->name);
        echo print_table_zeile("eMail",$this->email);
        echo print_table_fuﬂ();
        echo br();
        echo print_table_kopf("false","Gruppe","Kontostand");
        foreach ($this->gruppen as $gruppe){
            $gruppe = new Gruppe($gruppe);
            echo print_table_zeile($gruppe->get_name(),$this->get_kontostand_in_gruppe($this->id,$gruppe->get_id()));
        }
        echo print_table_fuﬂ();
        //print_r($_SESSION['benutzer']);
    }
    
    public function print_login_form(){      
        echo "<div class=\"table\">";
        echo "<form>";
        echo "<table class=\"listing form\" cellpadding=\"0\" cellspacing=\"0\">";
        echo "<tr>";
        echo "<th>Username</th>";
        echo "<td>";
        echo input_text("username",null,30);
        echo "</td>";
        echo "</tr>\n";
        echo "<tr>";
        echo "<th>Passwort</th>";
        echo "<td>";
        echo input_password("username",30);
        echo "</td>";
        echo "</tr>\n";
        //echo "<tr><th colspan=\"2\">Passwort veressen ?</th><tr>";
        echo "<tr><th colspan=\"2\">";
        echo "<a style=\"cursor: pointer\" onclick=\"login_user()\">Login</a>";
        echo "</th>";
        echo "</tr>\n";
        echo "</table>";
        echo "</form>";
        echo "</div>";    
    }
}

?>