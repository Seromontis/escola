<?
/*
{
	"AUTHOR":"MVC_Maydana",
	"CREATED_DATA": "09/04/2018",
	"NUCLEO": "MVC_Maydana",
	"LAST EDIT": "07/06/2018",
	"VERSION":"0.0.3"
}
*/

/**
** Agradecer ao Moisés (https://github.com/themoiza)
** que me ajudou, me auxiliando até aqui.
**/
class MVC_Maydana {

	protected $controller = 'index';
	protected $visao 	  = 'index';
	protected $action 	  = 'index';
	protected $url 		  = array();
	protected $conexao;

	function __construct(){
		
		// COLOCAR A URL EM UM ARRAY PARA TER CONTROLE MVC
		if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){

			$url = $this->parseUrl($_SERVER['REQUEST_URI']);
			$this->url = $url;
		}

		if(empty($url[1])){

			// SE NÃO HOUVER NADA NA URL, EXIBE O CONTROLADOR/VISÃO INDEX
			$this->controller = 'index';
			$this->action 	  = 'index';
			$this->visao 	  = 'index';

			try{

				require_once (DIR.'Controller/index/index.php');

			}catch(PDOException $e){

				/**
				** Caso controlador não seja encontrado
				**/
			}

			$controlador = new $this->controller;
			$controlador->index();

		}else{

			// EXISTE ALGO NA URL, VERIFICAR SE OQUE TEM NA URL EXISTE UM CONTROLADOR
			if(file_exists(DIR.'Controller/'.$url[1].'/'.$url[1].EXTENSAO_CONTROLADOR)){

				// MONTA O CONTROLADOR E ACTION (SE TIVER NA URL)
				$this->controller = $url[1];
				$this->visao 	  = $url[1];

				try{

					if(file_exists(DIR.'Controller/'.$url[1].'/'.$url[1].EXTENSAO_CONTROLADOR)){

						require_once (DIR.'Controller/'.$url[1].'/'.$url[1].EXTENSAO_CONTROLADOR);
		
					}else{

						require_once (DIR.'Controller/index/index'.EXTENSAO_CONTROLADOR);
					}
				

				}catch(PDOException $e){

					/**
					** Caso controlador não seja encontrado
					**/
				}

				$controlador = new $this->controller;

				// VERIFICA SE EXISTE A ACTION NO CONTROLADOR,
				if(isset($url[2]) and !empty($url[2])){

					$action = str_replace('-', '', $url[2]);

					if(method_exists($controlador, $action)){

						$this->action 	  = $action;
						// AQUI EXECUTA A ACTION EXISTENTE NO CONTROLADOR E NA URL
						$controlador->{$this->action}();

					}else{
						// ACTION NÃO ENCONTRADA / 404!
						$this->error404();
					}
				}else{
					// AQUI EXECUTA A ACTION INDEX (TODO CONTROLADOR TEM)
					$controlador->index();
				}

			}else{
				// 404 CONTROLADOR NÃO EXISTE
				$this->error404();
			}
		}
	}

	public function error404(){

		try{

			require_once (DIR.'Controller/erro404/erro404'.EXTENSAO_CONTROLADOR);

		}catch(PDOException $e){

			/**
			** Caso controlador não seja encontrado
			**/
		}

		$erro404 = new erro404;

		$erro404->index();
	}
	
	// "QUEBRA" O URL PARA DEFINIR OQUE É CONTROLADOR, ACTION..
	private function parseUrl($url){

		$array = explode('/', $url);
		$temp = array();

		foreach ($array as $key => $value) {

			$temp[$key] = preg_replace('/\?.*$|\!.*$|#.*$|\'.*$|\@.*$|\$.*$|&.*$|\*.*$|\+.*$|\..*$/', '', $value);
		}
		
		return $temp;
	}

}

function _autoload($classe){

	$php = str_replace('_', '/', $classe);

	try{

		if(is_file(DIR.$php.EXTENSAO_CONTROLADOR)){

			require_once (DIR.$php.EXTENSAO_CONTROLADOR);
		}
		
	}catch(PDOException $e){

		/**
		** @see Remover o ECHO antes de publicar
		**/

		echo $classe.': Classe nao encontrada';
	}
}

spl_autoload_register('_autoload');

/**
** RESPONSAVEL PELO DEBUG, exemplo, new de($variavel); ou new de('allow');
** @see Créditos - Criador : Moises - https://github.com/themoiza
**/
class de{

	function __construct($a){

		if(is_array($a)){

			echo '<pre>';
			print_r($a);
			exit;

		}else{

			echo '<pre>';
			var_dump($a);
			exit;
		}
	}
}