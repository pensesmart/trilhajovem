<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	*																	     *
	*	@author Prefeitura Municipal de Itajaï¿½								 *
	*	@updated 29/03/2007													 *
	*   Pacote: i-PLB Software Pï¿½blico Livre e Brasileiro					 *
	*																		 *
	*	Copyright (C) 2006	PMI - Prefeitura Municipal de Itajaï¿½			 *
	*						ctima@itajai.sc.gov.br					    	 *
	*																		 *
	*	Este  programa  ï¿½  software livre, vocï¿½ pode redistribuï¿½-lo e/ou	 *
	*	modificï¿½-lo sob os termos da Licenï¿½a Pï¿½blica Geral GNU, conforme	 *
	*	publicada pela Free  Software  Foundation,  tanto  a versï¿½o 2 da	 *
	*	Licenï¿½a   como  (a  seu  critï¿½rio)  qualquer  versï¿½o  mais  nova.	 *
	*																		 *
	*	Este programa  ï¿½ distribuï¿½do na expectativa de ser ï¿½til, mas SEM	 *
	*	QUALQUER GARANTIA. Sem mesmo a garantia implï¿½cita de COMERCIALI-	 *
	*	ZAï¿½ï¿½O  ou  de ADEQUAï¿½ï¿½O A QUALQUER PROPï¿½SITO EM PARTICULAR. Con-	 *
	*	sulte  a  Licenï¿½a  Pï¿½blica  Geral  GNU para obter mais detalhes.	 *
	*																		 *
	*	Vocï¿½  deve  ter  recebido uma cï¿½pia da Licenï¿½a Pï¿½blica Geral GNU	 *
	*	junto  com  este  programa. Se nï¿½o, escreva para a Free Software	 *
	*	Foundation,  Inc.,  59  Temple  Place,  Suite  330,  Boston,  MA	 *
	*	02111-1307, USA.													 *
	*																		 *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/**
 * @author Adriano Erik Weiguert Nagasava
 */
require_once ("include/clsBase.inc.php");
require_once ("include/clsListagem.inc.php");
require_once ("include/clsBanco.inc.php");
require_once( "include/pmieducar/geral.inc.php" );
require_once ("include/localizacaoSistema.php");

class clsIndexBase extends clsBase
{
	function Formular()
	{
		$this->SetTitulo( "{$this->_instituicao} i-Educar - Turma" );
		$this->processoAp = "586";
        $this->addEstilo("localizacaoSistema");
	}
}

class indice extends clsListagem
{
	/**
	 * Referencia pega da session para o idpes do usuario atual
	 *
	 * @var int
	 */
	var $pessoa_logada;

	/**
	 * Titulo no topo da pagina
	 *
	 * @var int
	 */
	var $titulo;

	/**
	 * Quantidade de registros a ser apresentada em cada pagina
	 *
	 * @var int
	 */
	var $limite;

	/**
	 * Inicio dos registros a serem exibidos (limit)
	 *
	 * @var int
	 */
	var $offset;

	var $cod_turma;
	var $ref_usuario_exc;
	var $ref_usuario_cad;
	var $ref_ref_cod_serie;
	var $ref_ref_cod_escola;
	var $ref_cod_infra_predio_comodo;
	var $nm_turma;
	var $sgl_turma;
	var $max_aluno;
	var $multiseriada;
	var $data_cadastro;
	var $data_exclusao;
	var $ativo;
	var $ref_cod_turma_tipo;
	var $hora_inicial;
	var $hora_final;
	var $hora_inicio_intervalo;
	var $hora_fim_intervalo;

	var $ref_cod_instituicao;
	var $ref_cod_curso;
	var $ref_cod_escola;
	var $visivel;

	function Gerar()
	{
		@session_start();
		$this->pessoa_logada = $_SESSION['id_pessoa'];
		session_write_close();

		$this->titulo = "Turma - Listagem";

		foreach( $_GET AS $var => $val ) // passa todos os valores obtidos no GET para atributos do objeto
			$this->$var = ( $val === "" ) ? null: $val;

		

		$lista_busca = array(
			"Ano",
			"Turma",
			"Turno",
			"Eixo",
			"Projeto"
		);


		$obj_permissao = new clsPermissoes();
		$nivel_usuario = $obj_permissao->nivel_acesso($this->pessoa_logada);
		if ($nivel_usuario == 1)
		{
			$lista_busca[] = "Escola";
			//$lista_busca[] = "Institui&ccedil;&atilde;o";
		}
		else if ($nivel_usuario == 2)
		{
			$lista_busca[] = "Escola";
		}
		$lista_busca[] = "Situação";
		$lista_busca[] = "Educador Coordenador";
		$lista_busca[] = "Alunos";
		$this->addCabecalhos($lista_busca);

		$get_escola = true;
//		$get_escola_curso = true;
		$get_escola_curso_serie = true;
		$sem_padrao = true;
		$get_curso = true;
		include("include/pmieducar/educar_campo_lista.php");

		if ( $this->ref_cod_escola )
		{
			$this->ref_ref_cod_escola = $this->ref_cod_escola;
		}

    $helperOptions = array();
    $this->inputsHelper()->dynamic('anoLetivo', array(), $helperOptions);

		$this->campoTexto( "nm_turma", "Turma", $this->nm_turma, 30, 255, false );
		$this->campoLista("visivel", "Situaï¿½ï¿½o", array("" => "Selecione", "1" => "Ativo", "2" => "Inativo"), $this->visivel);
		// Paginador
		$this->limite = 20;
		$this->offset = ( $_GET["pagina_{$this->nome}"] ) ? $_GET["pagina_{$this->nome}"]*$this->limite-$this->limite: 0;

		$obj_turma = new clsPmieducarTurma();
		$obj_turma->setOrderby( "nm_turma ASC" );
		$obj_turma->setLimite( $this->limite, $this->offset );

		if ($this->visivel == 1) {
			$visivel = true;
		} elseif ($this->visivel == 2) {
			$visivel = false;
		} else {
			$visivel = array("true", "false");
		}

		$lista = $obj_turma->lista2(
			null,
			null,
			null,
			$this->ref_ref_cod_serie,
			$this->ref_ref_cod_escola,
			null,
			$this->nm_turma,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			1,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			null,
			$this->ref_cod_curso,
			$this->ref_cod_instituicao,
			null, null, null, null, null, $visivel, null, null, $this->ano
		);

		$total = $obj_turma->_total;

		// monta a lista
		if( is_array( $lista ) && count( $lista ) )
		{
			$ref_cod_escola = "";
			$nm_escola = "";
			foreach ( $lista AS $registro )
			{
				if( class_exists( "clsPmieducarEscola" ) && $registro["ref_ref_cod_escola"] != $ref_cod_escola)
				{
					$ref_cod_escola = $registro["ref_ref_cod_escola"];
					$obj_ref_cod_escola = new clsPmieducarEscola( $registro["ref_ref_cod_escola"] );
					$det_ref_cod_escola = $obj_ref_cod_escola->detalhe();
					$ref_cod_escola = $registro["ref_ref_cod_escola"] ;
					$nm_escola = $det_ref_cod_escola["nome"];
				}
				
				$lista_busca = array(
					"<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$registro["ano"]}</a>",
					"<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$registro["nm_turma"]}</a>"
				);

        if ($registro["turma_turno_id"]) {
        	$options = array('params' => $registro["turma_turno_id"], 'return_only' => 'first-field');
				  $turno   = Portabilis_Utils_Database::fetchPreparedQuery("select nome from pmieducar.turma_turno where id = $1", $options);

				  $lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">$turno</a>";
        }
        else
				  $lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\"></a>";

				if ($registro["nm_serie"])
					$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$registro["nm_serie"]}</a>";
				else
					$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">-</a>";

				$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$registro["nm_curso"]}</a>";

				if ($nivel_usuario == 1)
				{
					if ($nm_escola)
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$nm_escola}</a>";
					else
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">-</a>";

					//$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$registro["nm_instituicao"]}</a>";
				}
				else if ($nivel_usuario == 2)
				{
					if ($nm_escola)
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$nm_escola}</a>";
					else
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">-</a>";
				}
				if (dbBool($registro["visivel"]))
				{
					$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">Ativo</a>";
				}
				else
				{
					$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">Inativo</a>";
				}
				

				if ($registro['ref_cod_regente'])
				{
					$obj_pessoa = new clsPessoa_($registro['ref_cod_regente']);
					$det = $obj_pessoa->detalhe();
					if ($det["nome"])
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">{$det["nome"]}</a>";
					else
						$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">-</a>";
				} else {
					$lista_busca[] = "<a href=\"educar_turma_det.php?cod_turma={$registro["cod_turma"]}\">-</a>";
				}
				$lista_busca[] = "<a href=\"educar_matriculas_turma_alunos_cad.php?ref_cod_turma={$registro["cod_turma"]}\">Detalhes</a>";
							
				$this->addLinhas($lista_busca);
			}
		}

		$this->addPaginador2( "educar_turma_lst.php", $total, $_GET, $this->nome, $this->limite );
		$obj_permissoes = new clsPermissoes();
		if ( $obj_permissoes->permissao_cadastra( 586, $this->pessoa_logada, 7 ) )
		{
			$this->acao = "go(\"educar_turma_cad.php\")";
			$this->nome_acao = "Novo";
		}
		$this->largura = "100%";

		$localizacao = new LocalizacaoSistema();
	    $localizacao->entradaCaminhos( array(
	         $_SERVER['SERVER_NAME']."/intranet" => "Início",
	         "educar_index.php"                  => "Trilha Jovem - Escola",
	         ""                                  => "Listagem de turmas"
	    ));
	    $this->enviaLocalizacao($localizacao->montar());
	}
}
// cria uma extensao da classe base
$pagina = new clsIndexBase();
// cria o conteudo
$miolo = new indice();
// adiciona o conteudo na clsBase
$pagina->addForm( $miolo );
// gera o html
$pagina->MakeAll();
?>
<script>

document.getElementById('ref_cod_escola').onchange = function()
{
	getEscolaCurso();
}

document.getElementById('ref_cod_curso').onchange = function()
{
	getEscolaCursoSerie();
}

</script>
