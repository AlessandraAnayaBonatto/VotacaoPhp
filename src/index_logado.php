<!DOCTYPE html>

<?php
	session_start ();

	$mostra1 ='';
	$mostra2 = '';

	//verifica se a sessão está logada
	if(!empty($_SESSION ['$email']))
	{
		// trás a session (número) para a varivael email , que é minha session
		$email = $_SESSION ['$email'];
		require_once 'conexao.php';

		//recupera o nome do usuario para mostrar na tela index.php
		$ola = $db -> query ("select us.nome from usuario us where us.email = '$email'")-> fetch ();

	}
	

	if (empty($email))
	{
		
	  $mostra1 = '<a href="login.php"> Login </a><a href="cadastro.php">Cadastre-se </a>';
	}
	else
	{
	  $mostra1 = "<a href='excluir.php'> Exluir conta</a> - <a href='sair.php'> Sair </a> - <a href='pag_usuario.php'> Sua Conta </a>";
	  $mostra2 = "<a>Olá </a>".$ola ['nome'];
	}

?>



<html>
<head>
	
	<title>Trabalho PHP</title>
	
</head>
<body>	

	
		
	<div align='right'>
		<p> <?=$mostra1.$mostra2 ?></p>
	</div>
	
	<h2 align='center'>Eleições 2016</h2>

	
	
	<p align='center'>
		<a href='votar.php'/></td>
		<input type='submit' value='VOTAR'/>
	</p>
	
	



</body>
</html>

