<?

require_once "PageLayout.php";

class Paginated {

	private $rs;
	private $pageSize;
	private $pageNumber;
	private $rowNumber;
	private $offSet;
	private $layout;
    
	function __construct($obj, $displayRows = 10, $pageNum = 1) {
		$this->setRs($obj);
		$this->setPageSize($displayRows);
		$this->assignPageNumber($pageNum);
		$this->setRowNumber(0);
		$this->setOffSet(($this->getPageNumber() - 1) * ($this->getPageSize()));
	}

	public function setOffSet($offSet) {
		$this->offSet = $offSet;
	}

	public function getOffSet() {
		return $this->offSet;
	}


	public function getRs() {
		return $this->rs;
	}

	public function setRs($obj) {
		$this->rs = $obj;
	}

	public function getPageSize() {
		return $this->pageSize;
	}

	public function setPageSize($pages) {
		$this->pageSize = $pages;
	}

	public function getPageNumber() {
		return $this->pageNumber;
	}

	public function setPageNumber($number) {
		$this->pageNumber = $number;
	}

	public function getRowNumber() {
		return $this->rowNumber;
	}

	public function setRowNumber($number) {
		$this->rowNumber = $number;
	}

	public function fetchNumberPages() {
		if (!$this->getRs()) {
			return false;
		}

		$pages = ceil(($this->getRs() > 900 ? 890 : $this->getRs()) / (float)$this->getPageSize());
		return $pages;
	}

	public function assignPageNumber($page) {
		if(($page <= 0) || ($page > $this->fetchNumberPages()) || ($page == "")) {
			$this->setPageNumber(1);
		}
		else {
			$this->setPageNumber($page);
		}

	}

	public function fetchPagedRow() {
		if((!$this->getRs()) || ($this->getRowNumber() >= $this->getPageSize())) {
			return false;
		}

		$this->setRowNumber($this->getRowNumber() + 1);
		$index = $this->getOffSet();
		$this->setOffSet($this->getOffSet() + 1);
		return $this->rs[$index];
	}

	public function isFirstPage() {
		return ($this->getPageNumber() <= 1);
	}

	public function isLastPage() {
		return ($this->getPageNumber() >= $this->fetchNumberPages());
	}

	public function getLayout() {
		return $this->layout;
	}

	public function setLayout(PageLayout $layout) {
		$this->layout = $layout;
	}

	public function fetchPagedNavigation($queryVars = "") {
		return $this->getLayout()->fetchPagedLinks($this, $queryVars);
	}
}
?>