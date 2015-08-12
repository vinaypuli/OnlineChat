<?php
session_start();
if(isset($_SESSION['name'])){
   $text = $_POST['text'];
   $logtag = $_POST['logfile'];
   $friend = $_POST['friendid'];


   $fp= fopen($logtag, 'a');
   fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$_SESSION['name']."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
   fwrite($fp, "<div class='msgln'>(".date("g:i A").") <b>".$friend."</b>: ".stripslashes(htmlspecialchars($text))."<br></div>");
   fclose($fp);

}
?>