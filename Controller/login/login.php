<?
/*
	{
		"AUTHOR":"Matheus Maydana",
		"CREATED_DATA": "06/08/2018",
		"CONTROLADOR": "Login",
		"LAST EDIT": "06/08/2018",
		"VERSION":"0.0.1"
	}
*/
class Login {

	public $_conexao;

	public $_consulta;

	public $_util;

	public $_template = 'login';

	public $_cor;

	private $_push = false;

	private $_validacao;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);

		$this->_util = new Model_Pluggs_Utilit;

		$this->_validacao = new Model_Pluggs_Validacao;

		/* Function noLogin não permite entrar no controlador login com Login.. kk*/
		$this->_util->noLogin();

		$this->_cor = new Model_GOD;

		$this->_url = new Model_Pluggs_Url;

		if(isset($_POST['push']) and $_POST['push'] == 'push'){
			$this->_push = true;
		}
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

		$this->_template = null;
		
	}

	function index(){

		$mustache = array();

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('login', 'login', $this->_template), $mustache);

		}else{

			echo $this->_cor->push('login', 'login', $mustache);
		}
	}

	function criar(){

		/* GERA TOKEN */
		$seguranca = $this->_cor->_token();
		$url = URL_SITE;

		$mustache = array(
			'{{token}}' => $this->_cor->_TokenForm('novo_login')
		);

		if($this->_push === false){

			echo $this->_cor->_visao($this->_cor->_layout('login', 'criar', $this->_template), $mustache);

		}else{

			echo $this->_cor->push('login', 'criar', $mustache);
		}
	}

	function novo(){

		$token = $this->_cor->_verificaToken('novo_login', $_POST['token']);

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email'], $_POST['token']) and !empty($_POST['token'])){

			if($token === true){

				$email 	= $this->_util->basico($_POST['email']);
				$nome 	= $this->_util->basico($_POST['nome']);
				$senha 	= $this->_util->basico($_POST['senha']);

				/* COLOCA OS DADOS TRATATOS NUM ARRAY*/
				$dados['email'] = $email;
				$dados['nome'] 	= $nome;
				$dados['senha'] = $senha;

				$validacao = $this->_validacao->_criarLogin($dados);

				/* CASO NÃO PASSE PELA VALIDAÇÃO */
				if($validacao !== true){

					echo json_encode(array('res' => 'no', 'info' => $validacao));
					exit;
				}

				/* COLOCA DOS DADOS NA FUNÇÃO PARA CRIAR CONTA */
				$criar = $this->_consulta->newAccount($dados);

				switch ($criar) {
					case 2:

						/* SQL FAIL */
						echo json_encode(array('res' => 'no', 'info' => 'Algo de errado não está certo'));
						break;

					case 3:

						/* ACCOUNT EXIST */
						echo json_encode(array('res' => 'no', 'info' => 'Alguem já se registrou com esse e-mail, tenta outro!'));
						break;

					case 4:

						/* DADOS INVÁLIDOS */
						echo json_encode(array('res' => 'no', 'info' => 'Informe os dados principais!'));
						break;
					
					default:

					/* CRIADO COM SUCESSO */
					echo json_encode(array('res' => 'ok', 'info' => 'Sua conta foi criada com sucesso!', 'email' => $email, 'senha' => $senha));
					break;
				}
			}else{


				echo json_encode(array('res' => 'no', 'info' => 'Seu nome por acaso, é Robo ? kk'));
				exit;
			}

		}else{

			/* INFORME OS DADOS CORRETO */
			echo json_encode(array('res' => 'no', 'info' => 'Informe os dados'));
			exit;
		}
	}

	function entrar(){

		$token = $this->_cor->_verificaToken('entrar_login', $_POST['token']);

		/* SE EXISTER CONTA, SENHA E TOKEN VÁLIDO, ENTÃO FAÇA O CADASTRO */
		if(isset($_POST['email'], $_POST['token']) and !empty($_POST['token'])){

			if($token === true){

				$email = $this->_util->basico($_POST['email']);
				$senha = $this->_util->basico($_POST['senha']);

				/* COLOCA OS DADOS TRATATOS NUM ARRAY*/
				$dados['email'] = $email;
				$dados['senha'] = $senha;

				/* COLOCA DOS DADOS NA FUNÇÃO PARA FAZER O LOGIN */
				$login = $this->_consulta->login($dados);

				switch ($login) {
					case 3:

						/* SENHA ERRADA*/
						echo json_encode(array('res' => 'no', 'info' => 'E-mail ou senha incorreto!'));
						exit;

					case 4:

						/* DADOS INVÁLIDOS */
						echo json_encode(array('res' => 'no', 'info' => 'Preencha os dados conforme solicitado'));
						exit;
					
					default:

					/* LOGADO COM SUCESSO */
					echo json_encode(array('res' => 'ok', 'info' => 'Login efetuado com sucesso!'));
					exit;
				}

			}else{

				echo json_encode(array('res' => 'no', 'info' => 'Seu nome por acaso, é Robo ? kk'));
				exit;
			}
		}
		/* INFORME OS DADOS CORRETO */
		echo json_encode(array('res' => 'no', 'info' => 'Informe os dados'));
		exit;
	}

	function sair(){

		/* FALTA PASSAR UM TOKEN PARA SEGURANÇA.. */
		if(isset($_GET['usr']) AND is_numeric($_GET['usr'])){

			$return = $this->_consulta->logout($_GET['usr']);

			if($return == 2){

				if($this->_push == false){
					
					header('location: /');
					exit;

				}else{

					echo "<script>$(location).attr('href', '/');</script>";
					exit;
				}
			}
		}
	}
}