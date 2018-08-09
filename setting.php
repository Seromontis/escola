<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "09/04/2018",
	"CONFIG": "Setting",
	"LAST EDIT": "22/07/2018",
	"VERSION":"0.0.9"
}
*/

/* DEBUG DESENVOLVIMENTO */
/**
TRUE = DESENVOLVIMENTO
FALSE = PRODUCAO (saveLogs);
**/
define('DEV', false);

/**
** CONFIGURAÇÕES DO MVC
**/
define('DIR', '../');

define('SAVE_SESSIONS', 'Sessions');

// É NECESSÁRIO QUE A SESSÃO/COOKIE SEJA A MESMA DO SITE
session_save_path(DIR.'Sessions');
session_set_cookie_params(9999999, '/', $_SERVER['SERVER_NAME']);

/* USANDO HOST-VIRTUAL url é só /, no windows é ../mvc_maydana/ */
define('URL_STATIC', '/');

// Usado somente no windows - xampp /* USADO PELO CONTROLE DE MVCs que eu criei em casa */
define('DIRETORIO_PROJETO', DIR);		// diretório

/**
** CONFIGURAÇÕES
**/

/**
** BANCO DADOS
** @param pgsql ou mysql
** @see demais dados em Model/Bancodados/Pssw
**/

define('BANCO_DADOS', 'pgsql');

define('ACTION', 'escola_sistema');

/* TRUE ONLINE - FALSE DESENVOLVIMENTO */
define('PRODUCAO', false);

define('URL_SITE', 'escola.local');

define('HOJE', date('d/m/Y'));

define('AGORA', date('H:i:s'));

define('IP', $_SERVER['REMOTE_ADDR']);

define('LAYOUT', 'layout');						// nome do layout (.html)

define('VERSION_MVC', '0.0.1'); 				// Version MVC

define('NOME_SISTEMA', 'Escola System');			// Nome Projeto

define('NOME_PROJETO', 'Sistema Escolar');			// Nome Projeto

define('EXTENSAO_VISAO', '.html'); 				// Extenção das views

define('EXTENSAO_CONTROLADOR', '.php'); 		// Extenção das controllers


/**
** FUNÇÕES E MODELS
**/

define('HASH_PASSWORD', '123');


/**
** CONFIGURAÇÕES IMAGEMS
**/
session_start();

$id_cliente = 0;
$array = $_SESSION['login'] ?? array();
foreach ($array as $id_conta => $info_conta){
	$id_cliente = $id_conta;
}
define('URL_DADOS', DIR.'/Dados/');
define('URL_DADOS_ALUNO', URL_DADOS.$id_cliente.'/');
define('URL_IMG_ALUNO', URL_DADOS.$id_cliente.'/alunos/');
define('URL_IMG_ALUNO_THUMBS', URL_IMG_ALUNO.'thumbs/');
define('URL_IMG_ALUNO_ORIGIN', URL_IMG_ALUNO.'origin/');
define('HEIGHT_THUMB', 190);
define('WIDTH_THUMB', 240);
define('HEIGHT_VIEW', 520);
define('WIDTH_VIEW', 840);
define('FORMATO_THUMBS', '.jpg');
define('SUBNOME_THUMBS', '_thumb');


if(!is_dir(URL_DADOS_ALUNO)){
	mkdir(URL_DADOS_ALUNO);

	mkdir(URL_DADOS_ALUNO.'alunos');
	mkdir(URL_DADOS_ALUNO.'/alunos/thumbs');
	mkdir(URL_DADOS_ALUNO.'alunos/origin');
}