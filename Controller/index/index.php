<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "06/08/2018",
		"CONTROLADOR": "Index",
		"LAST EDIT": "06/08/2018",
		"VERSION":"0.0.1"
	}
*/

class Index {

	public $_func;

	private $_cor;

	private $_push = false;

	function __construct(){

		$this->_func = new Model_Functions_Functions;

		$this->_func->checkLogin();

		$this->_cor = new Model_GOD;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}

		/*new de(array(
			992006936 => array(
				'email' => 'matheus@email.com',
				'senha' => '123456',
				'nome' => 'Matheus Maydana',
				'sexo' => 1
			)
		));*/
	}

	function index(){

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('index', 'index'), $mustache);

		}else{

			echo $this->_cor->push('index', 'index');
		}
	}
}