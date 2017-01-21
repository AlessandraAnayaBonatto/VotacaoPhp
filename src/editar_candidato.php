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
		header ('location: index.php');
	}

	//POST (quando eu salvo as informçãoes do formulário)
	if (isset($_POST['numero']))
	{
		$numeroAntigo_candidato = $_SESSION ['$numeroCandidato'];
		
		$post_numero_novo = $_POST['numero'];
		$post_novo_nome = $_POST['nome'];
		
		require_once 'conexao.php';
		
		//Validação se o número novo já existente
		
		$existe = $db -> query ("select * from candidato where numero = $post_numero_novo") -> fetch();
		
		if (isset($existe['numero']))
		{
			$existe_numero = $existe['numero'];
			$existe_nome = $existe['nome'];
			
			$erros [] = "O número $existe_numero já pertence ao candidato $existe_nome";
		}
		else
		{
			$db -> exec ("update candidato set numero = $post_numero_novo, nome = '$post_novo_nome' where numero = $numeroAntigo_candidato ");
		
			header ('location: tela_admin.php');
		}			
	}
	
	//GET da página	(quando eu entro na página)
	if (isset($_GET['numero']))
	{
		$_SESSION ['$numeroCandidato'] = $_GET['numero']; 
	}
	
	$candidato = $_SESSION ['$numeroCandidato'];	
	$consultaCandidato = $db -> query ("select * from candidato where numero = '$candidato'") -> fetch();
?>
<html>
<head>
	<title>Tela Editar Admin</title>
</head>
<body>
	
	<h3>Editar Candidato </h3>
	
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<div align='left'>
		<label for='numero'>Número: </label>
		<input id='numero' type='number' name='numero'  placeholder='Informe o número' value='<?=$consultaCandidato['numero']?>'/>
	</div>
	</br>
	</br>
	<div align='left'>
		<label for='nome'>Nome: </label>
		<input id='nome' type='txt' name='nome'  placeholder='Informe o nome' value='<?=$consultaCandidato['nome']?>'/>
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