<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Funciones {

    public function galsDirectory()
    {
		//return "http://dl.dropbox.com/u/47049575/";
		return "http://yorch3004.xyz/public/";
    }
    public function paginador($base,$page,$totpages){
		$pag="";
		if($totpages>10){
			for($a=1; $a<=$totpages; $a++){
				if($page == $a){
					$pag .= '<li><a href="#" class="active"> [ ' . $a . ' ] </a></li>';
				} else {
					$pag .= "<li><a href='" . $base . $a . "'>" . $a . "</a></li>";
				}
			}
		} else {
			for($a=1; $a<=$totpages; $a++){
				if($page == $a){
					$pag .= ' <li><a href="#" class="active"> [ ' . $a . ' ] </a></li>';
				} else {
					$pag .= "<li><a href='" . $base . $a . "'>" . $a . "</a></li>";
				}
			}
		}
		return $pag;
	}
	public function getNumPages($total,$elemxpage){
		$res = $total / $elemxpage;
		$nums = explode(".", $res);
		$ent = $nums[0];
		if (isset($nums[1])) {
			$dec = $nums[1];
			if($dec > 0) {$ent = $ent + 1;}
		}
		return $ent;
	}
	public function voltearFechag($fecha){
	    $nfecha = $fecha;
		$datet = explode(" ",$fecha);
		if(strlen($datet[0])>0){
		    $date = explode ("-",$datet[0]);
			if (count($date) <= 1) {
				$datet[0] = str_replace("/","-",$datet[0]);
				$date = explode ("-",$datet[0]);
			}
			$nfecha = $date[2] . "-" . $date[1] . "-" . $date[0];
		}
		return $nfecha;
	}
	public function restaFechas($older, $newer) { 
		$fecOlder = explode(' ', $older);
		$fecNewer = explode(' ', $newer);
		$fecOlderD = explode('-', $fecOlder[0]);
		$fecNewerD = explode('-', $fecNewer[0]);
		$fecOlderT = explode(':', $fecOlder[1]);
		$fecNewerT = explode(':', $fecNewer[1]);
		$Y1 = $fecOlderD[0];
		$Y2 = $fecNewerD[0];
		$Y = $Y2 - $Y1; 
		$m1 = $fecOlderD[1];
		$m2 = $fecNewerD[1];
		$m = $m2 - $m1; 
		$d1 = $fecOlderD[2];
		$d2 = $fecNewerD[2];
		$d = $d2 - $d1; 
		$H1 = $fecOlderT[0];
		$H2 = $fecNewerT[0];
		$H = $H2 - $H1; 
		$i1 = $fecOlderT[1];
		$i2 = $fecNewerT[1];
		$i = $i2 - $i1; 
		$s1 = $fecOlderT[2];
		$s2 = $fecNewerT[2];
		$s = $s2 - $s1; 

		if($s < 0) { 
			$i = $i -1; 
			$s = $s + 60; 
		} 
		if($i < 0) { 
			$H = $H - 1; 
			$i = $i + 60; 
		} 
		if($H < 0) { 
			$d = $d - 1; 
			$H = $H + 24; 
		} 
		if($d < 0) { 
			$m = $m - 1; 
			$d = $d + $this->get_days_for_previous_month($m2, $Y2); 
		} 
		if($m < 0) { 
			$Y = $Y - 1; 
			$m = $m + 12; 
		} 
		$minutes = $d * 24 * 60;
		$minutes += $H * 60;
		$minutes += $i * 60;
		$minutes += $s;
		return $minutes;
	} 

	public function get_days_for_previous_month($current_month, $current_year) { 
	  $previous_month = $current_month - 1; 
	  if($current_month == 1) { 
	    $current_year = $current_year - 1; //going from January to previous December 
	    $previous_month = 12; 
	  } 
	  if($previous_month == 11 || $previous_month == 9 || $previous_month == 6 || $previous_month == 4) { 
	    return 30; 
	  } 
	  else if($previous_month == 2) { 
	    if(($current_year % 4) == 0) { //remainder 0 for leap years 
	      return 29; 
	    } 
	    else { 
	      return 28; 
	    } 
	  } 
	  else { 
	    return 31; 
	  } 
	}
public function getPaging($url,$aditionalItems, $totalPages,$itemsPaged,$currentPage,$limit) {
		$pages = "";
		if($totalPages <= $itemsPaged) {
			for($i=1; $i<=$totalPages; $i++)
				$pages .= $this->getPage($url,$i,$currentPage);
		}
		else if($currentPage == 1) {
			for($i=1; $i<=$itemsPaged; $i++)
				$pages .= $this->getPage($url,$i,$currentPage);
			$pages .= "<li>...</li>";
			$pages .= $this->getPage($url,$totalPages,$currentPage);
		}
		else if($currentPage == $totalPages) {
			$limit = $totalPages - ($itemsPaged - 1);
			$pages .= $this->getPage($url,1,$currentPage);
			$pages .= "<li>...</li>";
			for($i=$limit; $i<=$totalPages; $i++)
				$pages .= $i;
		}
		else if(($itemsPaged+1)==$totalPages) {
			$pages .= $this->getPage($url,1,$currentPage);
			$pages .= "<li>...</li>";
			for($i=2; $i<=$totalPages; $i++)
				$pages .= $i;
		}
		else if($currentPage < $totalPages && $currentPage > 1) {
			$aditionalItems = (int) ($itemsPaged/2);
			$init = $currentPage - $aditionalItems;
			if($init <= 1) {
				$init = 2;
				$end = $itemsPaged + 1;
			}
			else
				$end = $currentPage + $aditionalItems;
			if($end >= $totalPages) { 
				$end = $totalPages - 1;
				$init = $end - ($itemsPaged - 1);
			}
			
			$pages .= $this->getPage($url,1,$currentPage);
			$pages .= "<li>...</li>";
			for($i=($init); $i<=$end; $i++)
				$pages .= $this->getPage($url,$i,$currentPage);
			$pages .= "<li>...</li>";
			$pages .= $this->getPage($url,$totalPages,$currentPage);
		}
		
		if($currentPage > 1)
			$previousPage = '<li><a href="'.$url.(($currentPage > 1) ? ($currentPage-1) : 1).'"> &lt;&lt; </a></li>';
		else
			$previousPage = "";
		if($currentPage < $totalPages)
			$nextPage = '<li><a href="'.$url.'/'.(($currentPage < $totalPages) ? ($currentPage+1) : $totalPages).'"> &gt;&gt; </a></li>';
		else
			$nextPage = "";
		$pages = $previousPage.$pages.$nextPage;
		return $pages;
	}
	public function getPage($url,$i,$currentPage) {
		if ($i==$currentPage) {
			return '<li> ['.$i.'] </li>';
		} else {
			return '<li><a href="'.$url."/".$i.'">'. $i .'</a></li>';
		}
	}
	public function codeStringToShare($string) {
		$string = trim($string);
		$string = str_replace(":", "%3A", $string);
		$string = str_replace("/", "%2F", $string);
		$string = str_replace(" ", "%20", $string);
		return $string;
	}
}
?>