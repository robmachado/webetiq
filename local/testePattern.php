<!DOCTYPE html>
<html>
<body>

<p>A form with a password field that must contain 6 or more characters:</p>

<form action="./testPattern.php">
  Password: <input type="text" name="pw" pattern="[0-9]{4,4}" title="Quatro numeros">
  <input type="submit">
</form>

<p><strong>Note:</strong> The pattern attribute of the input tag is not supported in Internet Explorer 9 and earlier versions.</p>

</body>
</html>