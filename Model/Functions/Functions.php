<?
/*
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "06/08/2018",
	"MODEL": "Functions",
	"LAST EDIT": "06/08/2018",
	"VERSION":"0.0.1"
*/

class Model_Functions_Functions {

	public $_conexao;

	public $_consulta;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

	}

	function checkLogin(){

		/* VERIFICA SE NÃO EXISTE SESSÃO DE LOGIN, SE NÃO TIVER, REDIMENCIONA PRA FORA ! */
		if(!isset($_SESSION['login']) and count($_SESSION['login']) < 1){

			header('location: /login');
			exit;
		}
	}

	/* GERA TOKEN DE SEGURAÇA NOS FORMULÁRIO */
	function _TokenForm($formulario){

		$token = $this->HASH(md5(uniqid(microtime(), true)));

		$_SESSION['login'][$formulario.'_token'] = $token;

		return $token;
	}

	function _verificaToken($formulario, $send){

		/* $send = $_POST ou $_GET */
		if(!isset($_SESSION['login'][$formulario.'_token'])){
			return false;
		}

		if(!isset($send) or empty($send)){
			return false;
		}

		if(isset($_SESSION['login'][$formulario.'_token']) and $_SESSION['login'][$formulario.'_token'] !== $send){
			return false;
		}

		return true;
	}

	/**
	** @see Cria o hash da senha, usando MD5 e SHA-1 + Salt
	** @param string
	** @return string
	**/

	function HASH($string){

		/**
		** @see NUNCA !!!!
		** @see NUNCA, JAMAIS, ALTERE O VALOR DA VARIÁVEL $salt
		**/
		$string = (string) $string;
		$salt = '31256578196*&%@#*(!$!+_%$(_+!%anpadfbahidpqwm,ksdpoqww[pqwṕqw[';

		return sha1(substr(md5($salt.$string), 5,25));
	}
}