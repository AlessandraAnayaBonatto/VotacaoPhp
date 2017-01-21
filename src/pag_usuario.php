<?php
	session_start ();	
 
	if (!empty($_SESSION ['$email']))
	{
		$email = $_SESSION ['$email'];
 
		require_once 'conexao.php';	
  
		$dados = $db -> query ("select
								us.id,
								us.email,
								us.nome,
								us.data_nascimento,
								br.nome as bairro
								
								from 
								usuario us,
								bairro br
								
								where 
								us.id_bairro = br.id
								and us.email = '$email'"
								) -> fetch();
	}
	else 
	{
		header ('location: index.php');
	}
?>
	
<!DOCTYPE html>
<html>
<head>
	<title>Página do Usuário</title>
</head>
<body>

	<h1>Eleições 2016</h1>

	<div>
		<h2>Seus dados</h2>		
		<p>Nome: <?= $dados['nome']?> </p>
		
		<p>Data de Nascimento:<?= $dados['data_nascimento'] ?></p>		
		
		<p>Bairro: <?=$dados['bairro']?></p>		

		<p>E-mail: <?= $dados['email'] ?> </p>		
			
		<a href='altera_dados.php'>
		<p><input type='submit' value='Editar Dados'/>
		</a>
		
		<a href='cadastro.php'>
		<p><input type='submit' value='Voltar'/>
		</a>
		
		
	
	
	</div>
	
		


</body>
</html>