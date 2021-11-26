<?php
class TrailingLayout implements PageLayout {

	public function fetchPagedLinks($parent, $queryVars) {
	
		$currentPage = $parent->getPageNumber();
		$totalPages = $parent->fetchNumberPages();
		$str = "";

		if($totalPages >= 1) {
		
			for($i = 1; $i <= $totalPages; $i++) {
		
				$str .= " <a href=\"?page={$i}$queryVars\">Pagina $i</a>";
				$str .= $i != $totalPages ? " | " : "";
			}
		}

		return $str;
	}
}
?>