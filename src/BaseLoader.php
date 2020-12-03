<?php
namespace AzharLihan\CI3Modules;

use Exception;
use CI_Loader;

class BaseLoader extends CI_Loader
{
	private $sectionName = null;
	private $sections;

	public function extend($name)
	{
		$this->view($name);
	}

	public function section($name)
	{
		if (!is_null($this->sectionName)) throw new Exception("Previous section is still open", 1);
		$this->sectionName = $name;
		ob_start();
	}

	public function endSection()
	{
		if (is_null($this->sectionName)) throw new Exception("No section opened", 2);
		$this->sections[$this->sectionName] = ob_get_clean();
		$this->sectionName = null;
	}

	public function renderSection($name)
	{
		if (isset($this->sections[$name])) {
			echo $this->sections[$name];
		}
	}
}
