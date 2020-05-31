<html>
<body>

<p><b>Start typing a name in the input field below:</b></p>

<p>Suggestions: <span id="txtHint"></span></p>

<form>
First name: <input type="text" onkeyup="sendDatabaseRequest()">
</form>

<script>
function sendDatabaseRequest() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("txtHint").innerHTML = this.responseText;
      }
    };
    xmlhttp.open("POST", "gethint.php", true);
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	let myObject = {comment: 'swag2', yes: 'means no'};
    xmlhttp.send("data=" + JSON.stringify(myObject));
}
</script>

</body>
</html>
