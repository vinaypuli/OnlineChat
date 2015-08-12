<?php
session_start();
 
//session started


if(isset($_GET['logout'])){
// $fp = fopen("log1.html", 'a');
// fwrite($fp, "<div class='msgln'><i>User ". $_SESSION['name'] ." has left the chat session.</i><br></div>");
// fclose($fp);
session_destroy();
header("Location: index.php"); //Redirect the user
}


function logout(){

    echo 'Loggedout';
}

?>



<?php
function loginForm(){
  // 
  // Login form , Username and Password 
echo'

<div id="loginform">

<form method="post" action="index.php" onSubmit="return validateForm();">
<p>Please enter your name to continue:</p>
<label for="name">Username:</label>
<input type="text" name="name" id="name" /> <br />
<div id="passbox"
<label for = "password" >Password:</label>
<input type="text" name="password" id="password" />
</div>
 <input type="submit" name="enter" id="enter" value="Enter" /> 
</form>

<script>

function validateForm(){
  
  return true;}

}
</script>
</div>

';
}


function chatpage($friend){

//  Friends page 


$var1 = "friend1";
$var2 = "friend2";
$var3 = "friend3";
$var4 = "friend4";

if (strcmp($friend, $var1) == 0) {
    $logfile = $_SESSION['name']."_log1.html";
}

if (strcmp($friend, $var2) == 0) {
    $logfile = $_SESSION['name']."_log2.html";
}
if (strcmp($friend, $var3) == 0) {
    $logfile = $_SESSION['name']."_log3.html";
}
if (strcmp($friend, $var4) == 0) {
    $logfile = $_SESSION['name']."_log4.html";
}

?>


<div id="wrapper">

<div id="menu">






<p class="welcome">welcome <b><?php echo $_SESSION['name']; ?></b></p>

<p class="welcome">You are chatting with <b><?php echo $friend; ?></b></p>
<p class="logout"><a id="exit" href="#">Exit Chat</a></p>
<div style="clear:both"></div>
</div>


<div id="chatbox"></div>
<?php
if(file_exists($logfile) && filesize($logfile) > 0){
    $handle = fopen($logfile, "r");
    $contents = fread($handle, filesize($logfile));
    fclose($handle);

    echo $contents;
}
// CHAT BOX and LOG FIle download  & Additional functionality backtrack 
?>
<form name="message" action="">
<input name="usermsg" type="text" id="usermsg" size="63" />
<input name="submitmsg" type="submit"  id="submitmsg" value="Send" />
<input name="logfile" type="hidden" id="logfile" value="<?php echo htmlspecialchars($logfile);?>" />
<input name="friendname" type="hidden" id="friendname" value="<?php echo htmlspecialchars($friend);?>" />
</form>
</div>



<pre>  <form name = "backtrack" action= "index.php">
<input type = "submit" id = "back" value = "BACK to Friends">

</form></pre>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
</script>


<script type="text/javascript">
// Java script functions 

$(document).ready(function(){
   
  $("#exit").click(function(){
       var exit = confirm("Are you sure you want to end the session?");
       if(exit==true){window.location = 'index.php?logout=true';}
   });


   $("#submitmsg").click(function(){
      var logtag = $("#logfile").val();
      var friendname = $("#friendname").val();
      var clientmsg = $("#usermsg").val();
      $.post("post.php", {text: clientmsg, logfile: logtag, friendid : friendname});
      $("#usermsg").attr("value", "");
      return false;
   });

    

  
   
   setInterval (loadLog, 20);
                              
                              // LOading log file using ajax call 



function loadLog(){
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
    var logfile = $("#logfile").val();
    $.ajax({ url: logfile,
             cache: false,
             success: function(html){
                $("#chatbox").html(html);
                var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20;
                if(newscrollHeight > oldscrollHeight){
                    $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
                }
             },
    });
}
});
</script>
<?php
}


//validating username and password , if they are not entered alert type in 


if(isset($_POST['enter'])){
  if($_POST['name'] != ""){
     if($_POST['password']==""){
      echo '<span class="error">Please type in a password</span>';

     }
     else
     {
           $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));

     }
  }
  else{
    echo '<span class="error">Please type in a name</span>';
  
  }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>chat</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="userpage.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Courgette">
 <link href="http://fonts.googleapis.com/css?family=Lobster" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css">
</head>
<body>

<?php

// DIrecting to loginform and friends chatbox
if(!isset($_SESSION['name'])){
loginForm();
}
elseif(isset($_POST['friend1'])){

chatpage($_POST['friend1']);

}
elseif(isset($_POST['friend2'])){

chatpage($_POST['friend2']);

}
elseif(isset($_POST['friend3'])){

chatpage($_POST['friend3']);

}
elseif(isset($_POST['friend4'])){

chatpage($_POST['friend4']);

}
else{

?>
    <div>
        <p class="welcome">Welcome, <b><?php echo $_SESSION['name']; ?></b></p>
        
    </div>
    
    <div>
            <div id="friendform">  
            <form action="index.php" method="post">
            <p>Please Click a Friend name to chat:</p>
            <input type="submit" name="friend1" id="friend1" value="friend1" />
            <input type="submit" name="friend2" id="friend2" value="friend2" />
            <input type="submit" name="friend3" id="friend3" value="friend3" />
            <input type="submit" name="friend4" id="friend4" value="friend4" />

            </form>
            
            </div>
      </div>

      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js">
      </script>
 
<?php
}
?>

</body
</html>
