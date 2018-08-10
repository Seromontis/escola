<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "06/08/2018",
	"MODEL": "Consultas",
	"LAST EDIT": "06/08/2018",
	"VERSION":"0.0.1"
}
*/
class Model_Bancodados_Consultas {

	public $_conexao;

	public $_util;

	public $_hoje = HOJE;

	public $_agora = AGORA;

	public $_ip = IP;

	function __construct($conexao){


		$this->_conexao = $conexao->conexao();

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_util = null;

	}
}