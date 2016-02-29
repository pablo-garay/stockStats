<!DOCTYPE html>
<html>

<head>
<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
</style>
</head>

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

			/* Output debugging data */
			// $xml = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=APPL");
			// echo "<br />";
			// print_r($xml);

			/* XML */
			$xmlElement = simplexml_load_file('http://dev.markitondemand.com/MODApis/Api/v2/Lookup/xml?input=' . $_POST["input"]);	 
			echo "<br /><br />";
		    
		    if ($xmlElement->count() == 0) {
			    //it's empty
			    echo "No Record has been found";
			    echo "<br />";
			    // print_r($xmlElement);
			}
			else {
			    //XML object has children
			    echo "no empty";

			    echo "<br />";

			    echo '<table style="width:100%">';
			    echo '<tr><th>Name</th><th>Symbol</th><th>Exchange</th><th>Details</th></tr>';

			    foreach ($xmlElement->LookupResult as $result) {
			    	echo '<tr>';
				   // print_r($result);
			    	echo '<th>' . $result->Name . '</th>';
			    	echo '<th>' . $result->Symbol . '</th>';
			    	echo '<th>' . $result->Exchange . '</th>';
			    	echo '<th>' . '<a href="?symbol=' . $result->Symbol . '">More Info</a>' . '</th>';

				   echo "<br />";
				   echo '</tr>';
				}
				echo "</table>";


			    // print_r($xmlElement);
			}
			//    echo "<br /><br />";
			//    print_r($xmlElement->Status);	
		}

		if (isset($_GET["symbol"])){
			/* JSON */
			$json = file_get_contents("http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=" . $_GET["symbol"]);
			echo "<br /><br />";
			$jsonResultArray = json_decode($json, true);
			if ($jsonResultArray["Status"] === "SUCCESS"){
				echo $jsonResultArray["Name"];
				echo "<br />";
				echo $jsonResultArray["Symbol"];
				echo "<br />";
				echo $jsonResultArray["LastPrice"];
				echo "<br />";
				echo round($jsonResultArray["Change"], 2);
				echo "<br />";
				echo strval(round($jsonResultArray["ChangePercent"], 2)) . "%";
				echo "<br />";
				echo $jsonResultArray["Timestamp"];
				echo "<br />";
				echo strval(round($jsonResultArray["MarketCap"] / 1000000000, 2)) . " B";
				echo "<br />";
				echo number_format(($jsonResultArray["Volume"]), $decimals = 0 , $dec_point = "." , $thousands_sep = ",");
				echo "<br />";
				$changeYTD = $jsonResultArray["LastPrice"] - $jsonResultArray["ChangeYTD"];
				if ($changeYTD < 0) echo "(" . strval(round($changeYTD, 2)) . ")";
				else strval(round($jsonResultArray["changeYTD"], 2));
				echo "<br />";
				echo strval(round($jsonResultArray["ChangePercentYTD"], 2)) . "%";
				echo "<br />";
				echo $jsonResultArray["High"];
				echo "<br />";
				echo $jsonResultArray["Low"];
				echo "<br />";
				echo $jsonResultArray["Open"];
				echo "<br />";
				print_r(($jsonResultArray["Timestamp"]));

				$matches = array();
				preg_match('/^[A-Za-z]{3} ([A-Za-z]{3}) (\d+) (\d{2}:\d{2}):\d{2} \S* (\d{4})$/', $jsonResultArray["Timestamp"], $matches);
				// echo ("<br />Timestamp " . $matches[4] . "-" . $matches[1]  . "-" . $matches[2] . " " . $matches[3]);
				// /* e.g. 2016-Feb-26 15:59 */
				// $timestamp_array = date_parse_from_format('Y-M-d H:i', $matches[4] . "-" . $matches[1]  . "-" . $matches[2] . " " . $matches[3]);
				// echo "<br />AAAAAAAAA";
				// print_r($timestamp_array);

				echo "<br />I want a girlfriend!";
				$date = DateTime::createFromFormat('Y-M-d H:i', $matches[4] . "-" . $matches[1]  . "-" . $matches[2] . " " . $matches[3]);
				echo $date->format('Y-m-d h:i A');

			} else {
				echo "There is no stock information available.";
			}
		} else {
			echo "no HEY";
		}		
	?>	

</body>
</html>