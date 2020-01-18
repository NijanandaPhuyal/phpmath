<?php
	require_once('rpn.php');

	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	$res = '';
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (empty($_POST["solve"])) {
		  $nameErr = "String is required";
		  echo "Alert('string is required');";
		} else {
		  $solve = $_POST["solve"];
		  $res = calc($solve);
		}
	  }
?>
<html>

<body>
	<h1>Math Solver Php</h1>
	<div>
		<p>For conditionals use: 123*32 > 22*3 ? 20 : 30</p>
		<p>Any math operation is allowed</p>
	</div>
	<h3>Try it!</h3>
	<form action="index.php" method="post">
		<input name="solve" type="text"></input>
		<input type="submit">
	</form>
	<?php
		echo $res;
	?>
</body>

</html>
