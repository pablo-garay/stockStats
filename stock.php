<!DOCTYPE html>
<html>
<body>

    <div class="body-content" style="text-align: center; padding: 15em;">
        <div style="margin-bottom: 3em;">

			<h1><i>Stock Search</i></h1>

			<form method="POST" action="">
				<label for="input">Company Name or Symbol: </label>
				<input type="text" id="input" name="input" placeholder="Enter company name e.g. Apple"
				required pattern="^[a-zA-Z0-9][a-zA-Z0-9 ]*$" 
				value="<?php if (isset($_POST["input"])) echo htmlspecialchars($_POST['input']); ?>" > </input>
				<br />
				<input type="submit" value="Search" autofocus></input>
				<input type="reset" value="Clear"></input>
				<br />	
			</form>
			<a href="http://www.markit.com/product/markit-on-demand">Powered by Markit on Demand</a>
		</div>
	</div>

	<?php
		if(isset($_POST["input"])){
			print_r($_POST);
		} else {
			echo "ccc";
		}
		echo "hello world!";
	?>

</body>
</html>