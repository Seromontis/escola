<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "06/08/2018",
	"MODEL": "GOD",
	"LAST EDIT": "06/08/2018",
	"VERSION":"0.0.1"
}
*/

class Model_God extends Model_Functions_Functions{


	public $_conexao;

	public $_eye;

	public $_layout;

	function __construct($conexao = null){

		if($conexao !== null){

			$this->_conexao = $conexao;

		}else{

			$conexao = new Model_Bancodados_Conexao;
			$this->_conexao = $conexao;
		}

		$this->_eye = new Model_View;

		$this->_layout = new Model_Layout($this->_conexao);
	}

	function _layout($controlador, $visao, $template = LAYOUT){

		$this->_layout->setView($template);
		$this->_eye->setView($controlador, $visao);

		$mustache = array(
			'{{visao}}' => $this->_eye->visao()
		);		

		return $this->comprimeHTML(str_replace(array_keys($mustache), array_values($mustache), $this->_layout->Layout()));
	}

	function _visao($visao, $bigodim = null){

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$var = $this->comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $visao));

			return $var;
		
		}else{

			return $this->comprimeHTML(str_replace('{{visao}}', $bigodim, $visao));
		}
	}

	function push($controlador, $visao, $bigodim = null){
		$this->_eye->setView($controlador, $visao);

		if(is_array($bigodim) and $bigodim !== null and $bigodim !== ''){

			@$var = $this->comprimeHTML(str_replace(array_keys($bigodim), array_values($bigodim), $this->_eye->visao())); 
			return $var;

		}else{

			return $this->comprimeHTML(str_replace('{{visao}}', $bigodim, $this->_eye->visao()));
		}
	}

	function Erro404($xhr, $mustache = array()){

		if($xhr === false){

			echo $this->_visao($this->_layout('erro404', 'erro404'), $mustache);

		}else{

			echo $this->push('erro404', 'erro404', $mustache);
		}
	}

	function comprimeHTML($html){
		$html = preg_replace(array("/\/\*(.*?)\*\//", "/<!--(.*?)-->/", "/\t+/"), ' ', $html);

		$mustache = array(
			'\t' 						=> ' ',
			PHP_EOL 					=> ' ',
			'  ' 						=> ' ',
			'   ' 						=> ' ',
			'    ' 						=> ' ',
			'> <' 						=> '><',
			'NAOENTER'					=> PHP_EOL
		);
		
		return str_replace(array_keys($mustache), array_values($mustache), $html);
	}
}