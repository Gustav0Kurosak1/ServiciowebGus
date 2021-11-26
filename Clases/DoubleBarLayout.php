<?php
class DoubleBarLayout implements PageLayout {

	function __construct($q = "") {
        ($q == "" ? $this->q = "" : $this->q = "buscar-".str_replace(" ","-",$q));
        
	}

	public function fetchPagedLinks($parent, $queryVars) {

		$currentPage = $parent->getPageNumber();
		$str = "";

		if(!$parent->isFirstPage()) {
			if($currentPage != 1 && $currentPage != 2 && $currentPage != 3) {
					$str .= "<a href='".$this->q."/1$queryVars/' title='Primero'>Primero</a> &lt; ";
			}
		}

		if(!$parent->isFirstPage()) {
			$previousPage = $currentPage - 1;
			$str .= "<a href=\"".$this->q."/$previousPage$queryVars/\">&lt; Atras</a> ";
		}

		for($i = $currentPage - 2; $i <= $currentPage + 2; $i++) {
			if($i < 1) {
				continue;
			}
	
			if($i > $parent->fetchNumberPages()) {
				break;
			}
	
			if($i == $currentPage) {
				$str .= "<i>Pagina $i</i>";
			}
			else {
				$str .= "<a href=\"".$this->q."/$i$queryVars/\">$i</a>";
			}
			($i == $currentPage + 2 || $i == $parent->fetchNumberPages()) ? $str .= " " : $str .= " | ";
		}

		if (!$parent->isLastPage()) {
			if($currentPage != $parent->fetchNumberPages() && $currentPage != $parent->fetchNumberPages() -1 && $currentPage != $parent->fetchNumberPages() - 2)
			{
				$str .= " &gt; <a href=\"".$this->q."/".$parent->fetchNumberPages()."$queryVars/\" title=\"Ultimo\">Ultimo(".$parent->fetchNumberPages().") </a>";
			}
		}

		if(!$parent->isLastPage()) {
			$nextPage = $currentPage + 1;
			$str .= "<a href=\"".$this->q."/$nextPage$queryVars/\">Siguiente &gt;</a>";
		}
		return $str;
	}
}
?>