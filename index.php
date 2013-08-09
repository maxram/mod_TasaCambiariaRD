<?php include('rd-tasas-cambio.php'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>RD Tasas Cambio</title>
		<meta name="viewport" content="width=device-width; initial-scale=1.0" />
	</head>
	<body>
		<div>
			<header>
				<h1>RD Tasas Cambio test</h1>
			</header>
			<div>
			<?php 
				// pr(getUSDRates());
				// pr(getEURRates());
				pr(getAllCurrencyRates());
			?>
			</div>
			<footer>
				<p>
					&copy; Copyright  by Ignacio Cano
				</p>
			</footer>
		</div>
	</body>
</html>
