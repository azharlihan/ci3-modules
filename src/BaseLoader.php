<?php
namespace AzharLihan\CI3Modules;

use Exception;

/**
 * BaseLoader
 * Extended CI_Loader Class
 *
 * @package CI3Modules
 * @author Azhar Lihan <m@azharlihan.com>
 */
class BaseLoader extends \CI_Loader
{
	/**
	 * Determines whether the extend method has been called
	 *
	 * @var bool
	 */
	protected $extendCalled = false;

	/**
	 * Store an active section name
	 *
	 * @var string
	 */
	protected $sectionName;


	/**
	 * List of all sections defined in the view
	 *
	 * @var array
	 */
	protected $sections = array();

	/**
	 * Open a section and start output buffering
	 *
	 * @param  string $sectionName
	 * @return void
	 */
	public function section($sectionName)
	{
		if (!empty($this->sectionName))
			throw new Exception("Previous section is still open", 1);

		$this->sectionName = $sectionName;
		ob_start();
	}

	/**
	 * Close an opened section, and get it's content
	 *
	 * @return void
	 */
	public function endSection()
	{
		if (is_null($this->sectionName))
			throw new Exception("No section opened", 2);

		$this->sections[$this->sectionName] = ob_get_clean();
		$this->sectionName = null;
	}

	/**
	 * renderSection
	 *
	 * @param  string $sectionName
	 * @return void
	 */
	public function renderSection($sectionName)
	{
		if (isset($this->sections[$sectionName]))
			echo $this->sections[$sectionName];
	}

	/**
	 * Define a layout and call CI_Loader view method based a layout name
	 * This function must be called at the end of the view file
	 *
	 * @param  string $layoutName
	 * @return void
	 */
	public function extend($layoutName)
	{
		ob_clean();

		if ($this->extendCalled)
			throw new Exception('Layout is defined and can only be defined once.', 3);
		else
			$this->extendCalled = true;

		$this->view($layoutName);
	}
}
