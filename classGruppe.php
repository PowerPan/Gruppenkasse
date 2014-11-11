<?php

/**
 * @author Johannes Rudolph
 * @copyright 2012
 */


class Gruppe {
    
    private $id;
    private $name;
    private $benutzer;
    
    private $mysql;
    
    
    function __construct($gruppe_id = null)
    {
        $this->mysql =  new MySQL;
        if($gruppe_id)
        {
            $this->set_id($gruppe_id);
        }            
    }
    
    public function set_id($id){
        $this->id = $id;
        $this->read();    
    }
    
    public function get_id(){
        return $this->id;
    }
    
    public function get_name(){
        return $this->name;
    }
    
    public function get_benutzer(){
        return $this->benutzer;
    }
    
    public function read(){
        $this->mysql->query("select name from gruppe where id = ".$this->id."");
        $row = $this->mysql->fetchRow();
        $this->name = $row['name']; 
        $this->read_benutzer();   
    }
    
    public function get_gruppenbenutzer_fuer_checkbox_selectbox(){
        $mysql = new MySQL();
        $mysql->query("select b.id from benutzer b left join ver_benutzer_gruppe as vbg on (vbg.benutzer_id = b.id) where vbg.gruppe_id = '".$this->id."' and b.id != '".$_SESSION['benutzer']->get_id()."' order by b.name");
        while($row = $mysql->fetchRow()){
            $benutzer = new Benutzer($row['id']);
            $return[] = Array("id" => $benutzer->get_id(),"name" => $benutzer->get_name());    
        }    
        return $return;
    }
    
    public function get_gruppenbenutzer_fuer_checkbox_json(){
        $mysql = new MySQL();
        $mysql->query("select b.id from benutzer b left join ver_benutzer_gruppe as vbg on (vbg.benutzer_id = b.id) where vbg.gruppe_id = '".$this->id."' and b.id != '".$_SESSION['benutzer']->get_id()."'  order by b.name");
        $json = "{ \"benutzer\" :[";
        $count = 0;
        while($row = $mysql->fetchRow()){
            $benutzer = new Benutzer($row['id']);
            $jsonpart[] = " { \"id\": ".$benutzer->get_id().",\"name\": \"".$benutzer->get_name()."\" } ";
            
           
            
            $return[] = Array("id" => $benutzer->get_id(),"name" => $benutzer->get_name());    
        } 
        $jsonpart = implode(",",$jsonpart);
        $json .= $jsonpart;
        $json .= "] }";   
        echo $json;
    }
    
    public function get_gruppen_for_selectbox(){
        //$this->mysql->query("select id,name from gruppe");
        while($row = $this->mysql->fetchRow()){
            $this->set_id($row['id']);
            $return[] = Array("id" => $this->id,"name" => $this->name);
        }
        return $return;   
    }
    
    public function get_gruppen_benutzer_for_selectbox($benutzer){
        $mysql = new MySQL();
        $mysql->query("select g.id,g.name from gruppe g left join ver_benutzer_gruppe as vbg on (vbg.gruppe_id = g.id) where vbg.benutzer_id = '".$benutzer."'");
        while($row = $mysql->fetchRow()){
            $this->set_id($row['id']);
            $return[] = Array("id" => $this->id,"name" => $this->name);
        }
        return $return;   
    }
    
    private function read_benutzer(){
        $this->mysql->query("select benutzer_id from ver_benutzer_gruppe where gruppe_id = ".$this->id."");
        while($row = $this->mysql->fetchRow()){
            $this->benutzer[] = $row['benutzer_id'];
        }
    }
    
}
?>