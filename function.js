

function html_sonerzeichen(text){
    text = text.replace("&","&#038;");
    return text;
}

function login_user(){
    var username = document.getElementById('input_username').value;
    var passwort = document.getElementById('passwordusername').value;
    
    $.post('ajax.php?func=login_user',{username: username,passwort: passwort},function(data) {
        if(data == "")
            location.href = '?seite=start';
        else
            alert(data);                                                                
    });       
}

function save_neue_transaktion(){
    var benutzer = document.getElementById('hidden_benutzer_id').value;
    var benutzer_ids = document.getElementById('hidden_benutzer_ids').value.split(',');
    var gruppe = document.getElementById('selectbox_gruppe').value;
    var datum = document.getElementById('input_text_datum').value;
    var beschreibung = escape(document.getElementById('input_beschreibung').value);
    var betrag = document.getElementById('input_betrag').value;
    var eigeneteilnahme;
    if(document.getElementById('input_checkbox_eigeneteilnahme').checked == true)
        eigeneteilnahme = true;
    else
        eigeneteilnahme = false;
    
    var benutzer_dabei = new Array()
    for(var i=0; i < benutzer_ids.length;i++){
        if(document.getElementById('input_checkbox_benutzer_' + benutzer_ids[i]).checked == true)
            benutzer_dabei.push(benutzer_ids[i]);        
    }
        
    $.post('ajax.php?func=save_neue_transaktion',{benutzer: benutzer,benutzer_dabei: benutzer_dabei,gruppe: gruppe,datum: datum,beschreibung: beschreibung,betrag: betrag,eigeneteilnahme: eigeneteilnahme},function(data) {
        if(data.length > 0)
            alert(data);
        else
            location.href = '?seite=transaktion';    
    }); 
}

function save_neuer_bargeldausgleich(){
    var benutzer = document.getElementById('hidden_benutzer_id').value;
    var benutzer_dabei = document.getElementById('selectbox_anbenutzer').value;
    var gruppe = document.getElementById('selectbox_gruppe').value;
    var datum = document.getElementById('input_text_datum').value;
    var betrag = document.getElementById('input_betrag').value;

        
    $.post('ajax.php?func=save_neuen_bargeldausgleich',{benutzer: benutzer,benutzer_dabei: benutzer_dabei,gruppe: gruppe,datum: datum,betrag: betrag},function(data) {
        if(data.length > 0)
            alert(data);
        else
            location.href = '?seite=transaktion';    
    }); 
}

function read_benutzer_zu_gruppe_checkboxen(){
    var gruppe = document.getElementById('selectbox_gruppe').value;
    $.post('ajax.php?func=get_gruppenbenutzer_fuer_checkbox',{gruppe: gruppe},function(data) {
        var obj = eval ("(" + data + ")");
        var html = "";
        var benutzer_ids = new Array();
        for(var i = 0;i < obj.benutzer.length;i++){
            html = html + '<input onchange="" type="checkbox" id="input_checkbox_benutzer_'+ obj.benutzer[i].id +'" name="input_checkbox_benutzer_7" value="1" />' + obj.benutzer[i].name + '<br />\n'
            benutzer_ids.push(obj.benutzer[i].id)  
        }
        html = html + '<input type="hidden" id="hidden_benutzer_ids" name="input_benutzer_ids" value="'+ benutzer_ids +'" />'
        benutzer_ids = benutzer_ids.join(",")
        
        document.getElementById('teilnehmer').innerHTML = html;       
    });     
}

function read_benutzer_zu_gruppe_selectbox(){
    var gruppe = document.getElementById('selectbox_gruppe').value;
    
    $.post('ajax.php?func=get_gruppenbenutzer_fuer_checkbox',{gruppe: gruppe},function(data) {
        var obj = eval ("(" + data + ")");
        var html = '<select size="' + obj.benutzer.length + '" name="anbenutzer[]" id="selectbox_anbenutzer" >';
        var benutzer_ids = new Array();
        for(var i = 0;i < obj.benutzer.length;i++){
            html = html + '<option value='+ obj.benutzer[i].id +'>' + obj.benutzer[i].name + '</option>\n'
            benutzer_ids.push(obj.benutzer[i].id)  
        }
        html = html + '</select>'
        benutzer_ids = benutzer_ids.join(",")
        
        document.getElementById('teilnehmer').innerHTML = html;       
    });     
}

function multiple_selectbox_auslesen(id){
    select = document.getElementById(id);
    values = '';
    firstvalue = 0;
    for(var i = 0;i<=select.options.length-1;i++) {
		if(select.options[i].selected == true) {
            if(firstvalue == 0){
                firstvalue = 1;
            }
            else{
                values = values + ','    
            }
			values = values + select.options[i].value;           
		}
	}
    return values;
} 


function delete_transaktion(id){
    $.post('ajax.php?func=delete_transaktion',{id: id},function(data) {
        alert(data);
        alert("Transaktion gelöscht");
        location.href = '?seite=transaktion';    
    });     
} 
    