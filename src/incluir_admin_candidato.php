<!DOCTYPE html>
<?php

	session_start ();
	
	$candidato = [];
	
	$erros = [];
	
	require_once 'conexao.php';

	//Vendo se o usuario está logado 
	if(empty($_SESSION['$email']))
	{
		header ('location: index.php');
	}
	
	//Validando se o usuario é administrador.
	if ($_SESSION['$Administrador'] != 1)
	{
		header ('location: index_logado.php');
	}

	//POST (quando eu salvo as informçãoes do formulário)
	if (isset($_POST['numero']) AND ($_POST['nome']))
	{
		$post_numero_novo = $_POST['numero'];
		$post_novo_nome = $_POST['nome'];
		$pode_salvar = true;
		
		//Validações de espaço vazio
		if(trim($post_numero_novo) == '')
		{
			$erros [] = "É preciso informar um número válido";
			$pode_salvar = false;
		}
		
		
		if(trim($post_novo_nome) == '')
		{
			$erros [] = "É preciso informar um nome válido";
			$pode_salvar = false;
			
		}
		
		
		//Valida se já existe no banco
		
		if($pode_salvar == true)
		{
			$existe_numero = $db -> query ("select * from candidato where numero = $post_numero_novo") -> fetch();
			if (isset($existe_numero['numero']))
			{
				$erros [] = "numero ja existente";
				$pode_salvar = false;
			}
			
			$existe_nome = $db -> query ("select * from candidato where nome = '$post_novo_nome'") -> fetch();
			if (isset($existe_nome['nome']))
			{
				$erros [] = "nome ja existente";
				$pode_salvar = false;
			}
		}
		//Se as validações foram ok a variavel pode salver vai estar true e vamos poder salvar.
		if($pode_salvar)
		{		
			require_once 'conexao.php';
		
			$db -> exec ("insert into candidato
				(numero,nome)
					values
				($post_numero_novo, '$post_novo_nome')
				");	
			
			header ('location: tela_admin.php');						
		}
	}
	
	
	
?>
<html>
<head>
	<title>Tela Incluir Candidato</title>
</head>
<body>
	
	<h3>Incluir Candidato </h3>
	
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<div align='left'>
		<label for='numero'>Número: </label>
		<input id='numero' type='number' name='numero'  placeholder='Informe o número'/>
	</div>
	</br>
	</br>
	<div align='left'>
		<label for='nome'>Nome: </label>
		<input id='nome' type='txt' name='nome'  placeholder='Informe o nome'/>
	</div>
	</br>
	<input type='submit' value='Salvar'/>
	</form>
	
	<a href='tela_admin.php'>
		<p><input type='submit' value='Voltar'/>
	</a>

	<ul style='color: red'>
		<?php foreach ($erros as $erro): ?>
			<li><?=$erro?></li>
		<?php endforeach;?>
	</ul>


</body>
</html>