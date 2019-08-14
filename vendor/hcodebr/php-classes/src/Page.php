<?php 

namespace Hcode;

use Rain\Tpl;

/**
 * desc 
 * @var private string $tpl
 * @var private $options = array vazio
 * @var private $defaults = array 
 */
class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"header"=>true, 
		"footer"=>true, 
		"data"=>[]
	];
	/**
	 * desc configuration of template
	 * @param $opts = array 
	 */
	public function __construct($opts = array(), $tpl_dir = "/views/")
	{
		//$this->defaults["data"]["session"] = $_SESSION; 
		$this->options = array_merge($this->defaults, $opts);

		$config = array(
		    "tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]. $tpl_dir,
		    "cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
		    "debug"         => false
		);

		Tpl::configure( $config );

		$this->tpl = new Tpl();

        $this->setData($this->options["data"]);

        if ($this->options["header"] === true) $this->tpl->draw("header"); 

    }
    /** desc optimize foreach 
	 * @param $data = arary 
	 */
    private function setData($data = array())
	{
		foreach($data as $key => $value)
		{
			$this->tpl->assign($key, $value);
		}

    }
    
	/** desc return template 
	 * @param string $name 
	 * @param array $data 
	 * @param $returnHTML
	 */
	public function setTpl($tplname, $data = array(), $returnHTML = false)
	{
		$this->setData($data);
		return $this->tpl->draw($tplname, $returnHTML);

	}

	/**des 
	 * 
	 */
	public function __destruct()
	{
		if ($this->options["footer"] === true) $this->tpl->draw("footer");

	}

}
	

?>