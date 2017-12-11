<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php 
	$arrayDesordenado = [2,4,6,8,1,3,5,7];
	$arrayOrdenado = [1,2,3,4,5,6,7,8,9];

	function seleccionDirecta ($arrayToSort) {
		$arrayLength = count($arrayToSort);

		for ($i=0; $i < $arrayLength; $i++) { 

			for ($j= $i+1; $j < $arrayLength; $j++){
				
				if ($arrayToSort[$i] > $arrayToSort[$j]) {
					
					$temp = $arrayToSort[$i];

					$arrayToSort[$i] = $arrayToSort[$j];
					
					$arrayToSort[$j] = $temp;
				}
			}
		}

		return $arrayToSort;
	}

	function quickSort ($arrayToSort) {
		if (count($arrayToSort) < 2) {
			return $arrayToSort;
		}

		$smallers = $biggers = array();
		$pivot = $arrayToSort[0];

		$arrayLength = count($arrayToSort);
		for ($i=1; $i < $arrayLength; $i++) {
			
			if ($pivot >= $arrayToSort[$i]) {
				$smallers[] = $arrayToSort[$i];
			} else {
				$biggers[] = $arrayToSort[$i];
			}
		}
		return array_merge(quickSort($smallers), (array)$pivot, quickSort($biggers));
	}

	function burbuja ($arrayToSort) {
		if(count($arrayToSort) <= 1) {
			return $arrayToSort;
		} 

		$arrayLength = count($arrayToSort);	
			for ($i=1; $i < $arrayLength; $i++) { 
				
				for ($j=0; $j < $arrayLength - 1 ; $j++) { 
					
					if ($arrayToSort[$j] > $arrayToSort[$j + 1]) {
						$temp = $arrayToSort[$j];
						$arrayToSort[$j] = $arrayToSort[$j + 1];
						$arrayToSort[$j + 1] = $temp;
					}
				}
		}
		
		return $arrayToSort;
	}	
	?>

	<form action="" method="get">
		<p>Selecciona el algoritmo de ordenación que deseas emplear</p>
		<input type="radio" name="algoritmo" value="porSeleccionDirecta"> Selección directa <br>
		<input type="radio" name="algoritmo" value="porQuickSort"> QuickSort <br>
		<input type="radio" name="algoritmo" value="porBurbuja"> Burbuja <br> 
		<input type="submit" value="submit">
	</form>

	<?php 
		if( isset($_GET['algoritmo'])) {

			switch ($_GET['algoritmo']) {
				case "porSeleccionDirecta":
					$arrayAPresentar = seleccionDirecta($arrayDesordenado);
					echo implode("-", $arrayAPresentar);
					break;
				
				case "porQuickSort":
					$arrayAPresentar = quickSort($arrayDesordenado);
					echo implode("-", $arrayAPresentar);
					break;

				case "porBurbuja":
					$arrayAPresentar = burbuja($arrayDesordenado);
					echo implode("-", $arrayAPresentar);
					break;
			}
		}

	 ?>

</body>
</html>