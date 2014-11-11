<?php

/**
 * @author ohyeah
 * @copyright 2010
 */

    function date_mysql2german($date) {
		if(strlen($date) >1) {
			if(strlen($date) == 10) {
				$d    =    explode("-",$date);	    
				return    sprintf("%02d.%02d.%04d", $d[2], $d[1], $d[0]);
			}
			else {
				$da 	= explode(" ",$date);
				$da[0]	= date_mysql2german($da[0]);
				$date 	= $da[0]." ".$da[1];
				return $date;
			}
		}
		else {
			return null;
		}
	}
    
	function date_german2mysql($date) {
		if(strlen($date) >1) {
			if(strlen($date) == 10) {
				$d    =    explode(".",$date);	    
				return    sprintf("%04d-%02d-%02d", $d[2], $d[1], $d[0]);
			}
			else {
				$da 	= explode(" ",$date);
				$da[0]	= date_german2mysql($da[0]);
				$date 	= $da[0]." ".$da[1];
				return $date;
			}
		}
		else {
			return null;
		}
	}
    
    function button_javasctipt($text,$action,$icon = null){
        $return = "<table cellpadding=\"0\" cellspacing=\"0\"><tr>\n";
        $return .= "<td valign=\"top\">";
        $return .= "<b><a onclick=\"".$action."\" style=\"cursor: pointer\">[&nbsp;".$text."&nbsp;]</a></b>";
        $return .= "</td>";
        if($icon != null){
            $return .= "<td> ";
            $return .= "&nbsp;&nbsp;&nbsp;<img src=\"".$icon."\"  alt=\"\" onclick=\"".$action."\" style=\"cursor: pointer\" />\n";
            $return .= "</td>";
        }
        $return .= "</tr></table>\n";
        return $return;
    }
    
    function button_html($text,$link,$icon = null,$align = null){
        $return = "<table align=\"".$align."\" cellpadding=\"0\" cellspacing=\"0\">\n";
        $return .= "<tr>\n";
        $return .= "<td valign=\"top\">\n";
        $return .= "<b><a onclick=\"location.href='".$link."'\" style=\"cursor: pointer\">[&nbsp;".$text."&nbsp;]</a></b>\n";
        $return .= "</td>\n";
        if($icon != null){
            $return .= "<td>";
            $return .= "&nbsp;&nbsp;&nbsp;<img src=\"".$icon."\"  alt=\"\" onclick=\"location.href='".$link."'\" style=\"cursor: pointer\" />\n";
            $return .= "</td>\n";
        }
        $return .= "</tr>\n";
        $return .= "</table>\n";
        return $return;
    }
    function input_text_date_jquery($id,$value = null){
        /*$return = "<script>\n";
        $return .= "$(function() {\n";
        $return .= "$( \"#datepicker\" ).datepicker();{\n";
        $return .= "});\n";
        $return .= "</script>\n";*/     
        jquery_datepiker($id);
        $return .= "<input class=\"text\" type=\"text\" id=\"input_text_".$id."\" size=\"10\">\n";     	
        return $return;
    }
    
    function input_text_date($id,$value = null){
        $return = "<input type=\"text\" name=\"input_text_".$id."\" size=\"10\" id=\"input_text_".$id."\" onchange=\"\" value=\"".$value."\"/>\n";
        $return .= "<img src=\"img/calendar.png\" id=\"calender_".$id."\" style=\"cursor: pointer;\" title=\"Date selector\" alt=\"\" />\n";
        $return .= "<script type=\"text/javascript\">\n";
        $return .= "\tCalendar.setup({ \n";
        $return .= "\tinputField     :    \"input_text_".$id."\",     // id of the input field \n";
        $return .= "\tifFormat       :    \"%d.%m.%Y\",      // format of the input field \n";
        $return .= "\tbutton         :    \"calender_".$id."\",  // trigger for the calendar (button ID)\n";
        $return .= "\talign          :    \"Tl\",           // alignment (defaults to \"Bl\") \n";
        $return .= "\tsingleClick    :    true \n";
        $return .= "}); \n";
        $return .= "</script> \n";
        return $return;
    }
    
    function input_text($id,$value = null,$size = null,$onchange = null){
        return "<input type=\"text\"  class=\"text\" id=\"input_".$id."\" name=\"input_".$id."\" value=\"".$value."\"  size=\"".$size."\" onchange=\"".$onchange."\" />" ;
    }
    
    function input_hidden($id,$value = null){
        return "<input type=\"hidden\" id=\"hidden_".$id."\" name=\"input_".$id."\" value=\"".$value."\" />" ;
    }
    
    function input_password($id,$size = null){
        return "<input type=\"password\" class=\"text\" id=\"password".$id."\" name=\"password".$id."\"  size=\"".$size."\"/>" ;
    }
    
    function img($url,$alt,$link = null,$width = null,$onclick = null,$target = null){
        if($link){
            $return .="<a href=\"".$link."\"";
            if($target)
                $return .=" target=\"".$target."\" ";            
            $return .= ">";
        }
        $return .= "<img src=\"".$url."\" alt=\"".$alt."\" ";
        if($onclick)
            $return .= " onclick=\"".$onclick."\" style=\"cursor: pointer;\"";
        if($width)
            $return .= " width=\"".$width."\" ";
        $return .= "/>";
        if($link)
            $return .= "</a>";
        return $return;
    }
    
    function input_checkbox($id,$checked = null,$onchange = null,$disabled  = null,$value = null){
        if(!$value)
            $value = "1";
        $return .= "<input onchange=\"".$onchange."\" type=\"checkbox\" id=\"input_checkbox_".$id."\" name=\"input_checkbox_".$id."\" value=\"".$value."\" ";
        if($checked){
            $return .= " checked = \"checked\" ";    
        }
        if($disabled){
            $return .= " disabled=\"disabled\" ";
        }
        $return .= "/>" ;
        return $return;
    }
    
    function input_checkbox_text($id,$text,$checked = null,$onchange = null,$disabled = null,$value = null){
        $return .= input_checkbox($id,$checked,$onchange,$disabled,$value);
        $return .= $text;
        return $return;
    }
    
    function input_checkbox_text_img($id,$text,$img,$checked = null,$onchange = null,$disabled = null,$value = null){
        $return .=input_checkbox_text($id,$text,$checked,$onchange,$disabled,$value);
        $return .= "&nbsp;";
        $return .=img($img,$text);
        return $return;
    }
    
    function br(){
        echo "<br />\n";
    }
    
    function leerzeile($cloums){
        $return .= "\t<tr >\n";
        for($i = 0; $i < $cloums;$i++){
            $return .= "\t\t<td>&nbsp;</td>\n";    
        }
        $return .= "\t</tr>\n";
        return $return;
    }
    
    function infobox($title,$text){
        $return .= "<a class=\"info\" href=\"#\">[ ".$title." ]\n";
        $return .= "<span>\n";
        $return .= "<b>".$title."</b><br /><br />\n";
        $return .= $text;
        $return .= "</span>\n";
        return $return;
    }
    
    function selectbox($id,$values,$selected = null,$disabled = false,$multiple = false,$leerzeile = false,$onchange = false,$size = null){
        //$return .= $onchange;
        //echo count($values);
        //echo $selected;
        if(!is_array($values))
            $values = explode(";",$values);
        if(count($values) == 1)
            $selected = $values[0]['id'];
        if(!is_array($selected))
            $selected = array($selected);
        else if(is_array($selected[0])){            
            foreach ($selected as $select) {
                $selected[] = $select['id'];
            }
        }
        
        //print_r($selected);
        
        $return .= "<select ";
        if($multiple)
            $return .= "size=\"".count($values)."\"  multiple=\"multiple\" ";   

        if($size)
            $return .= "size=\"".$size."\" ";       
        $return .= "name=\"".$id."[]\" id=\"selectbox_".$id."\" "; 
        
        if($onchange)
            $return .= " onchange=\"".$onchange."\" ";
        
        if($disabled)
            $return .= "disabled=\"disabled\" ";
        
        $return .= ">\n";
        
        if($leerzeile)
            $return .= "<option value=\"0\" > </option>\n"; 
        
        
        
        foreach($values as $value){
  
            if(!is_array($value)){
                $no_arry_value = $value;
                $value = Array();
                $value['id'] = $no_arry_value;
                $value['name'] = $no_arry_value;
            }
            

            $return .= "<option value=\"".$value['id']."\" ";
            
            if($selected != null){
                if(in_array($value['id'],$selected)) 
                    $return .= "selected=\"selected\" ";
            }    
            $return .= ">".$value['name']."</option>\n"; 
        }
		
        $return .= "</select>\n"; 
        return $return;
    }
    
    function selectbox_land($land = null){
        include_once("mysql_connect.inc");
        $query_countrys = "select id, de_Name name from land order by de_Name";
        $quelle_countrys = mysql_query($query_countrys);
        $return .= "<table cellpadding=\"0\" cellspacing=\"0\">\n";
		$return .= "<tr>\n";
		$return .= "<td>\n";
		$return .= "<select id='selectbox_land' onchange=\"flagge();\">\n";
		$return .= "<option value=\"0\"></option>\n";
		while($ergebnis = mysql_fetch_assoc($quelle_countrys)) { 
            $return .= "<option ";
            if($land == $ergebnis['id']){
                $return .= "selected=\"selected\" ";
            }
            $return .= "value=\"".$ergebnis['id']."\">".str_replace("&","&amp;",$ergebnis['name'])."</option>\n";
		} 
		$return .= "</select>\n";
		$return .= "</td>\n";
        $return .= "<td>&nbsp;&nbsp;&nbsp;</td>\n";
		$return .= "<td>\n";
	    $return .= "<div id='flagge'>";
        if($land != null){
            $return .= "<img border='0' src='flagge.php?id=".$land."' alt=''/>";    
        }
        $return .= "</div>\n";
		$return .= "</td>\n";
		$return .= "</tr>\n";
		$return .= "</table>\n";
        return $return;
    }
    
    function land_zu_id($id){
        include_once("mysql_connect.inc");
        $query = "select de_Name land from land where id = '".$id."'";
        $quelle = mysql_query($query);
        $row = mysql_fetch_assoc($quelle);
        return $row['land'];
    }
    
    function email_senden($empfaenger,$betreff,$email,$absenderemail = null,$absendername = null){
        include_once("addon/phpmailer/class.phpmailer.php");
        date_default_timezone_set('Europe/Berlin');
        $mail = new PHPMailer();
	    $mail->AddAddress($empfaenger);
        if($absenderemail != null){
            $mail->From =$absenderemail;
            if($absendername != null){
                $mail->FromName = $absendername; 
            }  
        }
		$mail->Subject = $betreff;
		$mail->Body = $email;

        //EMail senden und ?berpr?fen ob sie versandt wurde
        if(!$mail->Send()) {
            //$mail->Send() liefert FALSE zur?ck: Es ist ein Fehler aufgetreten
            $return .= "Die Email konnte nicht gesendet werden\n";
			$return .= "Fehler: " . $mail->ErrorInfo . "\n";
        }
		else{
			//$mail->Send() liefert TRUE zur?ck: Die Email ist unterwegs
			//$return .= "Email ist weg";
		}
        return $return;	
    }
    
    function get_url(){
        $url = $_SERVER['HTTP_REFERER'];
        $url = explode("index.php",$url);
        $url = $url[0];
        return $url;
    }
    
    function header_bild(){
        $path = "css/images/banner";
        if($dir=opendir($path)){
            while($file=readdir($dir)){
                if (!is_dir($file) && $file != "." && $file != ".."){
                    $files[]=$file;
                }
            }
            closedir($dir);
        }
        $banner = round(rand(0,count($files)-1));
        $return .= $files[$banner];
        return $return;
    }
    
    function get_monat_deutsch_lang($monat){
    	switch($monat) {
			case 1: $monatwaort = "Januar";
					break;
			case 2: $monatwaort = "Februar";
					break;
			case 3: $monatwaort = "März";
					break;
			case 4: $monatwaort = "April";
					break;
			case 5: $monatwaort = "Mai";
					break;
			case 6: $monatwaort = "Juni";
					break;
			case 7: $monatwaort = "Juli";
					break;
			case 8: $monatwaort = "August";
					break;
			case 9: $monatwaort = "September";
					break;
			case 10: $monatwaort = "Oktober";
					break;
			case 11: $monatwaort = "November";
					break;
			case 12: $monatwaort = "Dezember";
					break;	
		}
		return $monatwaort;	
    }
    
    function get_anzahl_wochen_monat($monat,$jahr){
    	$tage = date("t",mktime(0,0,0,$monat,1,$jahr));
		$ewoche = date("W",gmmktime(0,0,0,$monat,1,$jahr));
		$lwoche = date("W",gmmktime(0,0,0,$monat,$tage,$jahr));
		if($monat == 1 and ($ewoche == "52" or $ewoche == "53")){
			if($ewoche == 52){
				$ewoche = 0;
			}
			if($ewoche == 53){
				$ewoche = -0;
			}
		}
		if($monat == 12 and $lwoche == "1"){
			$lwoche = 53;
		}	
		return $lwoche-$ewoche+1;
    }
    
    function get_erste_woche($monat,$jahr){
    	$ewoche = date("W",gmmktime(0,0,0,$monat,1,$jahr));	
    	return $ewoche;
    }
    
    function get_woche($tag,$monat,$jahr){
    	$woche = date("W",gmmktime(0,0,0,$monat,$tag,$jahr));	
    	return $woche;
    }
    
    function zufallsstring($length) {
		$buchstaben = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		settype($length, "integer");
		settype($rndstring, "string");
		settype($a, "integer");
		settype($b, "integer");	       
		for ($a = 0; $a <= $length; $a++) {
			$b = rand(0, strlen($buchstaben) - 1);
			$rndstring .= $buchstaben[$b];
		}	       
		return $rndstring;       
	}
 function seitenzahlen($zeilen,$proseite,$seite,$link) {
	 	$link = $link."&page=";
		$seiten = ceil($zeilen/$proseite);
		$return .= "<table align=\"center\">
				<tr>
					<td>";
		if ($seiten >1) {
			$i = 1;
            if($seite != 1){
                $zurueck = $seite-1;
                $return .= " <a href='".$link.$zurueck."'>&lt;--zurück</a> ";    
            }            
			if ($seite > 4) { // Wenn mehr als 3 Seiten dann ...
            $return .= " <a href='".$link.$i."'>1</a> ";
			 $return .= " ... ";
			}		
			while($i <= $seiten){
				if (	   $seite-3 == $i 
						or $seite-2 == $i 
						or $seite-1 == $i 
						or $seite == $i 
						or $seite+1 == $i 
						or $seite+2 == $i 
						or $seite+3 == $i 
						or (
                            (
                               $i == 5 
                            or $i == 6)
                            and $seite == 1) 
						or (($i == 5 or $i == 6)and $seite == 2)
						or (
                            (      $i+6 == $seiten 
                                or $i+5 == $seiten 
                                or $i+4 == $seiten) 
                            and $seite >= $seiten-7)) {
					if ($i == $seite) {
						$return .= "<b> ".$i." </b>";
					}
					else {
						$return .= " <a href='".$link.$i."'>".$i."</a> ";
					}
				}
				$i++;
			}		
			if($seiten-1==$seite or $seiten-2==$seite or $seiten-3==$seite or $seiten-4==$seite or $seiten-5==$seite or $seiten-6==$seite or $seiten==$seite) {
			}
			else {
				$return .= " ... ";
			}
			$i--;
            if(
                ($i == $seite and $i == $seiten)
                or
                ($i == $seite+1 and $i == $seiten)
                or
                ($i == $seite+2 and $i == $seiten)
                or
                ($i == $seite+3 and $i == $seiten) 
                or
                ($i == $seite+4 and $i == $seiten)
                or
                ($i == $seite+5 and $i == $seiten)
                or
                ($i == $seite+6 and $i == $seiten)              
            ){
                
            }
            else{
                //$return .= " <a href='".$link.$i."'>Letzte Seite</a> ";    
                $return .= " <a href='".$link.$i."'>".$seiten."</a> ";   
            }
            if($seite != $seiten){
            $vor = $seite+1;
            $return .= " <a href='".$link.$vor."'>vor--&gt;</a> ";    
            }
            
			
		}
		else{
			$return .= "<b>1</b>";
		}
		$return .= "</td>
			</tr>
		</table>";
        return $return;
	}
    
 function mouseover_info_box($text,$inhalt){
    return "<span class=\"tool\">".$text."<span class=\"tip\">".$inhalt."</span></span>"; 
 }
    
 function monat($date = null){
    if($date == null){
        $monat = date("n");
    }
    else{
        $monat = date("n",strtotime($date));
    }
    switch($monat){
        case "1":   $return .= "Januar";break;
        case "2":   $return .= "Februar";break;
        case "3":   $return .= "M&auml;rz";break;
        case "4":   $return .= "April";break;
        case "5":   $return .= "Mai";break;
        case "6":   $return .= "Juni";break;
        case "7":   $return .= "Juli";break;
        case "8":   $return .= "August";break;
        case "9":   $return .= "September";break;
        case "10":   $return .= "Oktober";break;
        case "11":   $return .= "November";break;
        case "12":   $return .= "Dezember";break;
    }
    return $return;
}

function print_top_bar($ueberschrift,$buttontext = null,$buttonlink =null){
    $return .= "<div class=\"top-bar\">";
    if($buttontext && $buttonlink)
        $return .= "<a href=\"".$buttonlink."\" class=\"button\">".$buttontext."</a>";
    $return .= "<h1>".$ueberschrift."</h1>";
    //$return .= "<div class=\"breadcrumbs\"><a href=\"?seite=neuerauftrag\">Homepage</a> / <a href=\"neuerauftrag\">Auftrag</a></div>";
    $return .= "</div>";
    return $return; 
}

function sqlvaluestring($value){
    if($value)
        $value = "'".$value."'";
    else
        $value = "NULL";
    return $value;
}

function generate_128code($text){
    // Including all required classes
    require('barcode/class/BCGFont.php');
    require('barcode/class/BCGColor.php');
    require('barcode/class/BCGDrawing.php'); 
    
    // Including the barcode technology
    include('barcode/class/BCGcode128.barcode.php'); 
    
    // The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255); 

    // Loading Font
    $font = new BCGFont('barcode/class/font/Arial.ttf', 12);
    
    $code = new BCGcode128();
    $code->setScale(3); // Resolution
    $code->setThickness(40); // Thickness
    $code->setForegroundColor($color_black); // Color of bars
    $code->setBackgroundColor($color_white); // Color of spaces
    $code->setFont($font); // Font (or 0)
    $code->parse($text); // Text
    
    
    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('temp/tempcode.png', $color_white);
    $drawing->setBarcode($code);
    $drawing->draw();
    
    // Header that says it is an image (remove it if you save the barcode to a file)
    //header('Content-Type: image/png');
    
    // Draw (or save) the image into PNG format.
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
    return 'temp/tempcode.png';
}

function print_table_kopf($form,$para1,$para2 = null,$para3 = null,$para4 = null,$para5 = null,$para6 = null,$para7 = null,$para8 = null,$para9 = null,$para10 = null){
    $parameter = Array($para1,$para2,$para3,$para4,$para5,$para6,$para7,$para8,$para9,$para10);
    $return .= "<div class=\"table\">";
    $return .= "<table class=\"listing";
    if($form)
        $return .= " form ";    
    $return .= "\" cellpadding=\"0\" cellspacing=\"0\">";
    $return .= "<tr>";
    foreach($parameter as $para){
        if($para)
            $return .= "<th>".$para."</th>";
    }
    $return .= "</tr>\n";
    return $return;
}

function print_table_fuß(){
    $return .= "</table>";
    $return .= "</div>"; 
    return $return;    
}

function print_table_zeile($para1,$para2 = null,$para3 = null,$para4 = null,$para5 = null,$para6 = null,$para7 = null,$para8 = null,$para9 = null,$para10 = null){
    $parameter = Array($para1,$para2,$para3,$para4,$para5,$para6,$para7,$para8,$para9,$para10);
    $return .= "<tr>";
    foreach($parameter as $para){
        if($para)
            $return .= "<td>".$para."</td>";
    }
    $return .= "</tr>\n";
    return $return;
}

function print_table_zeile_anker($anker,$para1,$para2 = null,$para3 = null,$para4 = null,$para5 = null,$para6 = null,$para7 = null,$para8 = null,$para9 = null,$para10 = null){
    $parameter = Array($para1,$para2,$para3,$para4,$para5,$para6,$para7,$para8,$para9,$para10);
    $return .= "<tr name=\"".$anker."\">";
    foreach($parameter as $para){
        if($para)
            $return .= "<td>".$para."</td>";
    }
    $return .= "</tr>\n";
    return $return;
}

function generate_inventaraufkleber($inventarnummer,$typ,$hersteller,$bezeichnung){
    include_once("function.inc.php");
    //header('Content-type: image/png');
    // Including all required classes
    require('barcode/class/BCGFont.php');
    require('barcode/class/BCGColor.php');
    require('barcode/class/BCGDrawing.php'); 
    
    // Including the barcode technology
    include('barcode/class/BCGcode128.barcode.php'); 
    
    // The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255); 

    // Loading Font
    $font = new BCGFont('barcode/class/font/Arial.ttf', 38);
    
    $code = new BCGcode128();
    $code->setScale(4); // Resolution
    $code->setThickness(40); // Thickness
    $code->setForegroundColor($color_black); // Color of bars
    $code->setBackgroundColor($color_white); // Color of spaces
    $code->setFont($font); // Font (or 0)
    $code->parse($inventarnummer); // Text

    
    
    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('temp/tempcode.png', $color_white);
    $drawing->setBarcode($code);
    $drawing->setDPI(300);
    $drawing->draw();
    //$drawing->
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    // Header setzten
    header('Content-type: image/jpeg');
     
    // Bilder laden
    $imgsrc = imagecreatefromjpeg('vorlagetypenschild.jpg');
    $imgzeichen = imagecreatefrompng('temp/tempcode.png');
     
    // Bild Infos
    $width = imagesx($imgsrc);
    $height = imagesy($imgsrc);
     
    // Bilder erzeugen
    $img = imagecreatetruecolor($width, $height);
     
    // Bild einfügen
    imagecopy($img, $imgsrc, 0, 0, 0, 0, $width, $height);
    
    // Wasserzeichen einfügen
    imagecopy($img, $imgzeichen, 238, 394, 0, 0, imagesx($imgzeichen), imagesy($imgzeichen));
    $black = ImageColorAllocate ($img, 0, 0, 0);
    $font = 'barcode/class/font/Arial.ttf';
    imagettftext ($img, 30, 0,337, 235, $black,$font,entenc(html_entity_decode($typ)));
    imagettftext ($img, 30, 0,337, 303, $black,$font,entenc(html_entity_decode($hersteller)));
    if(strlen($bezeichnung) < 25)
        imagettftext ($img, 30, 0,337, 373, $black,$font,entenc(html_entity_decode($bezeichnung)));
    else{
        imagettftext ($img, 20, 0,337, 373, $black,$font,entenc(html_entity_decode($bezeichnung)));    
    }

    //imagestring($img, 10, 337, 265, "McCrypt ® ", $black);
    //imagestring($img, 10, 337, 335, "", $black);
    
     
    // Bild anzeigen
    imagejpeg($img);
     
    // Speicher freigeben
    imagedestroy($img);
}

function getschriftgroesse($text,$font,$maxlength,$startgroesse){
        $schriftgroesse = $startgroesse + 1;
        do{
            $schriftgroesse--;
            $box = imagettfbbox($schriftgroesse,0,$font,entenc($text));
            $laenge = $box[2] - $box[0];
        } while($laenge > $maxlength );
        return $schriftgroesse;    
    }

function entenc($text)
{
    $res = '';
    for ($i = 0; $i < strlen($text); $i++)
    {
        $cc = ord($text{$i});
        if ($cc >= 128 || $cc == 38)
            $res .= "&#$cc;";
        else
            $res .= chr($cc);
    }
    return $res;
} 

function button($Name,$Link=null,$onclick = null){
    $return .= "<a ";
    if($Link)
        $return .= "href=\"".$Link."\" ";
    $return .= "class=\"bootombutton\" ";
    if($onclick)
        $return .= "onclick=\"".$onclick."\"";
    $return .= ">".$Name."</a>";
    return $return;
}

function jquery_datepiker($id){
    ?>
        <script src="js/ui/i18n/jquery.ui.datepicker-de.js"></script>
        <script>       
            $(function() {
                //$( "#datepicker" ).datepicker($.datepicker.regional[ "de" ]);
                $( "#input_text_<? echo $id; ?>" ).datepicker({changeMonth: true,changeYear: true});
	       });
        </script>
    <?
}

function utf8_urldecode($str) {
    $str = preg_replace("/%u([0-9a-f]{3,4})/i","&#x\\1;",urldecode($str));
    return html_entity_decode($str,null,'UTF-8');
} 
?>