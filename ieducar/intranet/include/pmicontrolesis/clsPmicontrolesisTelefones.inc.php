<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*																	     *
*	@author Prefeitura Municipal de Itaja�								 *
*	@updated 29/03/2007													 *
*   Pacote: i-PLB Software P�blico Livre e Brasileiro					 *
*																		 *
*	Copyright (C) 2006	PMI - Prefeitura Municipal de Itaja�			 *
*						ctima@itajai.sc.gov.br					    	 *
*																		 *
*	Este  programa  �  software livre, voc� pode redistribu�-lo e/ou	 *
*	modific�-lo sob os termos da Licen�a P�blica Geral GNU, conforme	 *
*	publicada pela Free  Software  Foundation,  tanto  a vers�o 2 da	 *
*	Licen�a   como  (a  seu  crit�rio)  qualquer  vers�o  mais  nova.	 *
*																		 *
*	Este programa  � distribu�do na expectativa de ser �til, mas SEM	 *
*	QUALQUER GARANTIA. Sem mesmo a garantia impl�cita de COMERCIALI-	 *
*	ZA��O  ou  de ADEQUA��O A QUALQUER PROP�SITO EM PARTICULAR. Con-	 *
*	sulte  a  Licen�a  P�blica  Geral  GNU para obter mais detalhes.	 *
*																		 *
*	Voc�  deve  ter  recebido uma c�pia da Licen�a P�blica Geral GNU	 *
*	junto  com  este  programa. Se n�o, escreva para a Free Software	 *
*	Foundation,  Inc.,  59  Temple  Place,  Suite  330,  Boston,  MA	 *
*	02111-1307, USA.													 *
*																		 *
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
/**
* @author Prefeitura Municipal de Itaja�
*
* Criado em 07/07/2006 08:37 pelo gerador automatico de classes
*/

require_once( "include/pmicontrolesis/geral.inc.php" );

class clsPmicontrolesisTelefones
{
	var $cod_telefones;
	var $ref_funcionario_cad;
	var $ref_funcionario_exc;
	var $nome;
	var $ddd_numero;
	var $numero;
	var $responsavel;
	var $ddd_celular;
	var $celular;
	var $email;
	var $endereco;
	var $data_cadastro;
	var $data_exclusao;
	var $ativo;
	
	// propriedades padrao
	
	/**
	 * Armazena o total de resultados obtidos na ultima chamada ao metodo lista
	 *
	 * @var int
	 */
	var $_total;
	
	/**
	 * Nome do schema
	 *
	 * @var string
	 */
	var $_schema;
	
	/**
	 * Nome da tabela
	 *
	 * @var string
	 */
	var $_tabela;
	
	/**
	 * Lista separada por virgula, com os campos que devem ser selecionados na proxima chamado ao metodo lista
	 *
	 * @var string
	 */
	var $_campos_lista;
	
	/**
	 * Lista com todos os campos da tabela separados por virgula, padrao para selecao no metodo lista
	 *
	 * @var string
	 */
	var $_todos_campos;
	
	/**
	 * Valor que define a quantidade de registros a ser retornada pelo metodo lista
	 *
	 * @var int
	 */
	var $_limite_quantidade;
	
	/**
	 * Define o valor de offset no retorno dos registros no metodo lista
	 *
	 * @var int
	 */
	var $_limite_offset;
	
	/**
	 * Define o campo padrao para ser usado como padrao de ordenacao no metodo lista
	 *
	 * @var string
	 */
	var $_campo_order_by;
	
	
	/**
	 * Construtor (PHP 4)
	 *
	 * @return object
	 */
	function clsPmicontrolesisTelefones( $cod_telefones = null, $ref_funcionario_cad = null, $ref_funcionario_exc = null, $nome = null, $ddd_numero, $numero = null, $data_cadastro = null, $data_exclusao = null, $ativo = null, $ddd_celular, $celular = null, $responsavel = null, $email = null, $endereco = null)
	{
		$db = new clsBanco();
		$this->_schema = "pmicontrolesis.";
		$this->_tabela = "{$this->_schema}telefones";
		
		$this->_campos_lista = $this->_todos_campos = "cod_telefones, ref_funcionario_cad, ref_funcionario_exc, nome, responsavel, ddd_numero, numero, ddd_celular, celular, email, endereco, data_cadastro, data_exclusao, ativo";
		
		if( is_numeric( $ref_funcionario_exc ) )
		{
			if( class_exists( "clsFuncionario" ) )
			{
				$tmp_obj = new clsFuncionario( $ref_funcionario_exc );
				if( method_exists( $tmp_obj, "existe") )
				{
					if( $tmp_obj->existe() )
					{
						$this->ref_funcionario_exc = $ref_funcionario_exc;
					}
				}
				else if( method_exists( $tmp_obj, "detalhe") )
				{
					if( $tmp_obj->detalhe() )
					{
						$this->ref_funcionario_exc = $ref_funcionario_exc;
					}
				}
			}
			else
			{
				if( $db->CampoUnico( "SELECT 1 FROM funcionario WHERE ref_cod_pessoa_fj = '{$ref_funcionario_exc}'" ) )
				{
					$this->ref_funcionario_exc = $ref_funcionario_exc;
				}
			}
		}
		if( is_numeric( $ref_funcionario_cad ) )
		{
			if( class_exists( "clsFuncionario" ) )
			{
				$tmp_obj = new clsFuncionario( $ref_funcionario_cad );
				if( method_exists( $tmp_obj, "existe") )
				{
					if( $tmp_obj->existe() )
					{
						$this->ref_funcionario_cad = $ref_funcionario_cad;
					}
				}
				else if( method_exists( $tmp_obj, "detalhe") )
				{
					if( $tmp_obj->detalhe() )
					{
						$this->ref_funcionario_cad = $ref_funcionario_cad;
					}
				}
			}
			else
			{
				if( $db->CampoUnico( "SELECT 1 FROM funcionario WHERE ref_cod_pessoa_fj = '{$ref_funcionario_cad}'" ) )
				{
					$this->ref_funcionario_cad = $ref_funcionario_cad;
				}
			}
		}


		if( is_numeric( $cod_telefones ) )
		{
			$this->cod_telefones = $cod_telefones;
		}
		if( is_string( $nome ) )
		{
			$this->nome = $nome;
		}
		if( is_numeric( $ddd_numero ) )
		{
			$this->ddd_numero = $ddd_numero;
		}
		if( is_numeric( $numero ) )
		{
			$this->numero = $numero;
		}
		if( is_numeric( $ddd_celular ) )
		{
			$this->ddd_celular = $ddd_celular;
		}
		if( is_numeric( $celular ) )
		{
			$this->celular = $celular;
		}
		if( is_string( $responsavel ) )
		{
			$this->responsavel = $responsavel;
		}
		if( is_string( $email ) )
		{
			$this->email = $email;
		}
		if( is_string( $endereco ) )
		{
			$this->endereco = $endereco;
		}
		if( is_string( $data_cadastro ) )
		{
			$this->data_cadastro = $data_cadastro;
		}
		if( is_string( $data_exclusao ) )
		{
			$this->data_exclusao = $data_exclusao;
		}
		if( is_numeric( $ativo ) )
		{
			$this->ativo = $ativo;
		}

	}

	/**
	 * Cria um novo registro
	 *
	 * @return bool
	 */
	function cadastra()
	{
		if( is_numeric( $this->ref_funcionario_cad ) && is_string( $this->nome ) )
		{
			$db = new clsBanco();
			
			$campos = "";
			$valores = "";
			$gruda = "";
			
			if( is_numeric( $this->ref_funcionario_cad ) )
			{
				$campos .= "{$gruda}ref_funcionario_cad";
				$valores .= "{$gruda}'{$this->ref_funcionario_cad}'";
				$gruda = ", ";
			}
			if( is_string( $this->nome ) )
			{
				$campos .= "{$gruda}nome";
				$valores .= "{$gruda}'{$this->nome}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->ddd_numero ) )
			{
				$campos .= "{$gruda}ddd_numero";
				$valores .= "{$gruda}'{$this->ddd_numero}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->numero ) )
			{
				$campos .= "{$gruda}numero";
				$valores .= "{$gruda}'{$this->numero}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->ddd_celular ) )
			{
				$campos .= "{$gruda}ddd_celular";
				$valores .= "{$gruda}'{$this->ddd_celular}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->celular ) )
			{
				$campos .= "{$gruda}celular";
				$valores .= "{$gruda}'{$this->celular}'";
				$gruda = ", ";
			}
			if( is_string( $this->responsavel ) )
			{
				$campos .= "{$gruda}responsavel";
				$valores .= "{$gruda}'{$this->responsavel}'";
				$gruda = ", ";
			}
			if( is_string( $this->email ) )
			{
				$campos .= "{$gruda}email";
				$valores .= "{$gruda}'{$this->email}'";
				$gruda = ", ";
			}
			if( is_string( $this->endereco ) )
			{
				$campos .= "{$gruda}endereco";
				$valores .= "{$gruda}'{$this->endereco}'";
				$gruda = ", ";
			}
			$campos .= "{$gruda}data_cadastro";
			$valores .= "{$gruda}NOW()";
			$gruda = ", ";
			$campos .= "{$gruda}ativo";
			$valores .= "{$gruda}'1'";
			$gruda = ", ";

			
			$db->Consulta( "INSERT INTO {$this->_tabela} ( $campos ) VALUES( $valores )" );
			return $db->InsertId( "{$this->_tabela}_cod_telefones_seq");
		}
		return false;
	}
	
	/**
	 * Edita os dados de um registro
	 *
	 * @return bool
	 */
	function edita()
	{
		if( is_numeric( $this->cod_telefones ) && is_numeric( $this->ref_funcionario_exc ) )
		{

			$db = new clsBanco();
			$set = "";

			if( is_numeric( $this->ref_funcionario_cad ) )
			{
				$set .= "{$gruda}ref_funcionario_cad = '{$this->ref_funcionario_cad}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->ref_funcionario_exc ) )
			{
				$set .= "{$gruda}ref_funcionario_exc = '{$this->ref_funcionario_exc}'";
				$gruda = ", ";
			}
			if( is_string( $this->nome ) )
			{
				$set .= "{$gruda}nome = '{$this->nome}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->ddd_numero ) )
			{
				$set .= "{$gruda}ddd_numero = '{$this->ddd_numero}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->numero ) )
			{
				$set .= "{$gruda}numero = '{$this->numero}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->ddd_celular ) )
			{
				$set .= "{$gruda}ddd_celular = '{$this->ddd_celular}'";
				$gruda = ", ";
			}
			if( is_numeric( $this->celular ) )
			{
				$set .= "{$gruda}celular = '{$this->celular}'";
				$gruda = ", ";
			}
			if( is_string( $this->responsavel ) )
			{
				$set .= "{$gruda}responsavel = '{$this->responsavel}'";
				$gruda = ", ";
			}
			if( is_string( $this->email ) )
			{
				$set .= "{$gruda}email = '{$this->email}'";
				$gruda = ", ";
			}
			if( is_string( $this->endereco ) )
			{
				$set .= "{$gruda}endereco = '{$this->endereco}'";
				$gruda = ", ";
			}
			if( is_string( $this->data_cadastro ) )
			{
				$set .= "{$gruda}data_cadastro = '{$this->data_cadastro}'";
				$gruda = ", ";
			}
			$set .= "{$gruda}data_exclusao = NOW()";
			$gruda = ", ";
			if( is_numeric( $this->ativo ) )
			{
				$set .= "{$gruda}ativo = '{$this->ativo}'";
				$gruda = ", ";
			}


			if( $set )
			{
				$db->Consulta( "UPDATE {$this->_tabela} SET $set WHERE cod_telefones = '{$this->cod_telefones}'" );
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Retorna uma lista filtrados de acordo com os parametros
	 *
	 * @return array
	 */
	function lista( $int_cod_telefones = null, $int_ref_funcionario_cad = null, $int_ref_funcionario_exc = null, $str_nome = null, $int_ddd_numero = null, $int_numero = null, $date_data_cadastro_ini = null, $date_data_cadastro_fim = null, $date_data_exclusao_ini = null, $date_data_exclusao_fim = null, $int_ativo = null, $int_ddd_celular = null, $int_celular = null, $str_responsavel = null, $str_email = null, $str_endereco = null )
	{
		$sql = "SELECT {$this->_campos_lista} FROM {$this->_tabela}";
		$filtros = "";
		
		$whereAnd = " WHERE ";
		
		if( is_numeric( $int_cod_telefones ) )
		{
			$filtros .= "{$whereAnd} cod_telefones = '{$int_cod_telefones}'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_ref_funcionario_cad ) )
		{
			$filtros .= "{$whereAnd} ref_funcionario_cad = '{$int_ref_funcionario_cad}'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_ref_funcionario_exc ) )
		{
			$filtros .= "{$whereAnd} ref_funcionario_exc = '{$int_ref_funcionario_exc}'";
			$whereAnd = " AND ";
		}
		if( is_string( $str_nome ) )
		{
			$filtros .= "{$whereAnd} nome LIKE '%{$str_nome}%'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_ddd_numero ) )
		{
			$filtros .= "{$whereAnd} ddd_numero = '{$int_ddd_numero}'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_numero ) )
		{
			$filtros .= "{$whereAnd} numero = '{$int_numero}'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_ddd_celular ) )
		{
			$filtros .= "{$whereAnd} ddd_celular = '{$int_ddd_celular}'";
			$whereAnd = " AND ";
		}
		if( is_numeric( $int_celular ) )
		{
			$filtros .= "{$whereAnd} celular = '{$int_celular}'";
			$whereAnd = " AND ";
		}
		if( is_string( $str_responsavel ) )
		{
			$filtros .= "{$whereAnd} responsavel LIKE '%{$str_responsavel}%'";
			$whereAnd = " AND ";
		}
		if( is_string( $str_email ) )
		{
			$filtros .= "{$whereAnd} email LIKE '%{$str_email}%'";
			$whereAnd = " AND ";
		}
		if( is_string( $str_endereco ) )
		{
			$filtros .= "{$whereAnd} endereco LIKE '%{$str_endereco}%'";
			$whereAnd = " AND ";
		}
		if( is_string( $date_data_cadastro_ini ) )
		{
			$filtros .= "{$whereAnd} data_cadastro >= '{$date_data_cadastro_ini}'";
			$whereAnd = " AND ";
		}
		if( is_string( $date_data_cadastro_fim ) )
		{
			$filtros .= "{$whereAnd} data_cadastro <= '{$date_data_cadastro_fim}'";
			$whereAnd = " AND ";
		}
		if( is_string( $date_data_exclusao_ini ) )
		{
			$filtros .= "{$whereAnd} data_exclusao >= '{$date_data_exclusao_ini}'";
			$whereAnd = " AND ";
		}
		if( is_string( $date_data_exclusao_fim ) )
		{
			$filtros .= "{$whereAnd} data_exclusao <= '{$date_data_exclusao_fim}'";
			$whereAnd = " AND ";
		}
		if( is_null( $int_ativo ) || $int_ativo )
		{
			$filtros .= "{$whereAnd} ativo = '1'";
			$whereAnd = " AND ";
		}
		else
		{
			$filtros .= "{$whereAnd} ativo = '0'";
			$whereAnd = " AND ";
		}

		
		$db = new clsBanco();
		$countCampos = count( explode( ",", $this->_campos_lista ) );
		$resultado = array();
		
		$sql .= $filtros . $this->getOrderby() . $this->getLimite();
		
		$this->_total = $db->CampoUnico( "SELECT COUNT(0) FROM {$this->_tabela} {$filtros}" );
		
		$db->Consulta( $sql );
		
		if( $countCampos > 1 )
		{
			while ( $db->ProximoRegistro() ) 
			{
				$tupla = $db->Tupla();
			
				$tupla["_total"] = $this->_total;
				$resultado[] = $tupla;
			}
		}
		else 
		{
			while ( $db->ProximoRegistro() ) 
			{
				$tupla = $db->Tupla();
				$resultado[] = $tupla[$this->_campos_lista];
			}
		}
		if( count( $resultado ) )
		{
			return $resultado;
		}
		return false;
	}
	
	/**
	 * Retorna um array com os dados de um registro
	 *
	 * @return array
	 */
	function detalhe()
	{
		if( is_numeric( $this->cod_telefones ) )
		{

		$db = new clsBanco();
		$db->Consulta( "SELECT {$this->_todos_campos} FROM {$this->_tabela} WHERE cod_telefones = '{$this->cod_telefones}'" );
		$db->ProximoRegistro();
		return $db->Tupla();
		}
		return false;
	}
	
	/**
	 * Retorna um array com os dados de um registro
	 *
	 * @return array
	 */
	function existe()
	{
		if( is_numeric( $this->cod_telefones ) )
		{

		$db = new clsBanco();
		$db->Consulta( "SELECT 1 FROM {$this->_tabela} WHERE cod_telefones = '{$this->cod_telefones}'" );
		$db->ProximoRegistro();
		return $db->Tupla();
		}
		return false;
	}
	
	/**
	 * Exclui um registro
	 *
	 * @return bool
	 */
	function excluir()
	{
		if( is_numeric( $this->cod_telefones ) && is_numeric( $this->ref_funcionario_exc ) )
		{

		/*
			delete
		$db = new clsBanco();
		$db->Consulta( "DELETE FROM {$this->_tabela} WHERE cod_telefones = '{$this->cod_telefones}'" );
		return true;
		*/

		$this->ativo = 0;
			return $this->edita();
		}
		return false;
	}
	
	/**
	 * Define quais campos da tabela serao selecionados na invocacao do metodo lista
	 *
	 * @return null
	 */
	function setCamposLista( $str_campos )
	{
		$this->_campos_lista = $str_campos;
	}
	
	/**
	 * Define que o metodo Lista devera retornoar todos os campos da tabela
	 *
	 * @return null
	 */
	function resetCamposLista()
	{
		$this->_campos_lista = $this->_todos_campos;
	}
	
	/**
	 * Define limites de retorno para o metodo lista
	 *
	 * @return null
	 */
	function setLimite( $intLimiteQtd, $intLimiteOffset = null )
	{
		$this->_limite_quantidade = $intLimiteQtd;
		$this->_limite_offset = $intLimiteOffset;
	}
	
	/**
	 * Retorna a string com o trecho da query resposavel pelo Limite de registros
	 *
	 * @return string
	 */
	function getLimite()
	{
		if( is_numeric( $this->_limite_quantidade ) )
		{
			$retorno = " LIMIT {$this->_limite_quantidade}";
			if( is_numeric( $this->_limite_offset ) )
			{
				$retorno .= " OFFSET {$this->_limite_offset} ";
			}
			return $retorno;
		}
		return "";
	}
	
	/**
	 * Define campo para ser utilizado como ordenacao no metolo lista
	 *
	 * @return null
	 */
	function setOrderby( $strNomeCampo )
	{
		// limpa a string de possiveis erros (delete, insert, etc)
		//$strNomeCampo = eregi_replace();
		
		if( is_string( $strNomeCampo ) && $strNomeCampo )
		{
			$this->_campo_order_by = $strNomeCampo;
		}
	}
	
	/**
	 * Retorna a string com o trecho da query resposavel pela Ordenacao dos registros
	 *
	 * @return string
	 */
	function getOrderby()
	{
		if( is_string( $this->_campo_order_by ) )
		{
			return " ORDER BY {$this->_campo_order_by} ";
		}
		return "";
	}
	
}
?>
