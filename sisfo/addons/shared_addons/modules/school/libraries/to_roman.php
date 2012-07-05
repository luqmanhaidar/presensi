<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class To_roman {
	
	private function cut($num, $n){
		return ($num - ($num % $n ) ) / $n;
	}
	
	public function convert ($aNumb) {
	   $rNumb= "";
		while ($aNumb> 5999) { $rNumb.= "M"; $aNumb-= 1000;}
		if(($aNumb > 0)) {
			$mill = Array("", "M", "MM", "MMM", "MMMM", "MMMMM");
			$cent = Array("", "C", "CC", "CCC", "CD", "D", "DC", "DCC", "DCCC", "CM");
			$tens = Array("", "X", "XX", "XXX", "XL", "L", "LX", "LXX", "LXXX", "XC");
			$ones = Array("", "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX");
	
			$m = $this->cut($aNumb, 1000); $aNumb%= 1000;
			$c = $this->cut($aNumb, 100); $aNumb%= 100;
			$t = $this->cut($aNumb, 10); $aNumb%= 10;
			
			return $rNumb . $mill[$m] . $cent[$c] . $tens[$t] . $ones[$aNumb];
		}
		else {
			return "Angka diantara 1 - 5999";
		}
	}
}	

?>