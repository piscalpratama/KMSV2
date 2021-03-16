<?php 

class language_swicth {
	private $language_available =array('english','indonesia');
	private $language_default ='indonesia';
	private $language_file =array('text');
	private $parameter_get ='lang';
	private $parametersession ='multilanguage';
	function __construct()
	{
		#parent::__construct();
		#session_destroy();
		$this->run_language();
	}
	public function run_language()
	{
		$CI =& get_instance();
		$language = $this->language_default;
		$language_swicthto = $CI->input->get($this->parameter_get);
		$parametersessioninrun = $this->parametersession;
		if ($language_swicthto) {
			if (in_array($language_swicthto, $this->language_available)) {
				$CI->session->set_userdata( array('multilanguage'=> $language_swicthto));
			}
		}
		$session_lang_swicth = $CI->session->userdata($this->parametersession);
		if (!$session_lang_swicth) {
			$CI->session->set_userdata( array('multilanguage' => $language));
			$language=$this->language_default ;
		}else{
			$language=$session_lang_swicth ;
		}
		$language_file=$this->language_file;
		foreach ($language_file as $key) {
			if ($key!='') {
				$CI->lang->load($key, $language);
			}
		}
		
	}
}
