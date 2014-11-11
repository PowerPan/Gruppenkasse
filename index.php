<?
    header('Content-Type: text/html; charset=iso-8859-1');
    include_once("classMySQL.php");
    include_once("function.inc.php");

    include_once("classBenutzer.php");
    include_once("classContent.php");
    
    include_once("classGruppe.php");
    include_once("classTransaktion.php");

    
    
    session_start();
    
    if($_GET['seite'] == "logout"){
        session_unset();
        session_destroy();
    }
    

    
    
    /*print_r($_GET);
    br();
    print_r($_POST);
    br();
    
    print_r($_SESSION);
    br();/*
    print_r($_SERVER);*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gruppenkasse</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
    <!--<meta http-equiv="content-type" content="text/html; charset=utf-8" />-->


    <link rel="stylesheet" href="css/ui-lightness/jquery-ui-1.8.20.custom.css">
    <link rel="stylesheet" href="css/simple.css">
    
    <script src="function.js" type="text/javascript"></script>    


    <script src="js/jquery-1.7.2.js"></script>
    <script src="js/ui/jquery.ui.core.js"></script>
	<script src="js/ui/jquery.ui.widget.js"></script>
	<script src="js/ui/jquery.ui.datepicker.js"></script>
    

	<script src="js/ui/jquery.ui.mouse.js"></script>
	<script src="js/ui/jquery.ui.button.js"></script>
	<script src="js/ui/jquery.ui.draggable.js"></script>
	<script src="js/ui/jquery.ui.position.js"></script>
	<script src="js/ui/jquery.ui.dialog.js"></script>
    
    
    

</head>
<body>

<?  
$content = new Content();

$content->ausgabe($_GET['seite']);
 ?>

</body>
</html>