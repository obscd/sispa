<?php
if (!isset($_SESSION)) {
  session_start();
}

function usuario($lvlus)
{
	switch($lvlus)
	{
		case 0:
			$ipus = "0";
			return ($ipus);
			break;
		case 1:
			$ipus = "0,1";
			return ($ipus);
			break;
		case 2:
			$ipus = "0,1,2";
			return ($ipus);
			break;
		case 3:
			$ipus = "0,1,3";
			return ($ipus);
			break;
		case 4:
			$ipus = "0,1,4";
			return ($ipus);
			break;
		case 5:
			$ipus = "0,1,5";
			return ($ipus);
			break;
               case 100:
			$ipus = "0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30";
			return ($ipus);
			break;

	}
	
}

?>