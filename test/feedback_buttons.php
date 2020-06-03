<?php

echo'<html>';
include $_SERVER["DOCUMENT_ROOT"] . "/includes/functions.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/head.php";
beginPage();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/header_menu.php";
beginWrapper();
?>

<!-- Main content goes here -->
<h1>Generic Page</h1>
<span class="image main"><img src="/images/pic13.jpg" alt="" /></span>
<p>

<script>
let xhttp = new XMLHttpRequest();
xhttp.open("POST", "simple.php", true);
xhttp.send('sending you same data');
let myObject = {comment: 'nopnopnop'};

</script>


</p>

<?php
endWrapper();
include $_SERVER["DOCUMENT_ROOT"] . "/includes/footer.php";
include $_SERVER["DOCUMENT_ROOT"] . "/includes/js_assets.php";
endPage();
?>
