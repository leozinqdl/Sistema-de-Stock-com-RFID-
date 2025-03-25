<?php
class indexModel
{
	public function headerXls($name = null)
	{
		if(!$name)
			$name = "relatorio";

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		header("Content-Disposition: attachment; filename=\"$name.xls\"");
		header("Content-Transfer-Encoding: binary ");
		session_start();
		$_SESSION["xls_sets"] = 1;
	}
}