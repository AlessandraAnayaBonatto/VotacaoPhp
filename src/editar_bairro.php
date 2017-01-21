<!DOCTYPE html>
<?php

	
	session_start ();	
	
	$erros = [];

	
	require_once 'conexao.php';
	
	$erros = [];

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
	if (isset($_POST['bairro']))
	{
		$idBairro = $_SESSION ['$idBairro'];
		$post_nome = $_POST['bairro'];
		
		require_once 'conexao.php';
		
		//Validação se o bairro novo já existente			
		$existe = $db -> query ("select * from bairro where nome= '$post_nome'") -> fetch();
		
		if (isset($existe['nome']))
		{		
			$existe_nome = $existe['nome'];	
			
			if($existe['nome'] == "")
			{
				$erros [] = "É preciso informar um bairro válido";
			}
			else
			{					
				
				$erros [] = "O Bairro $existe_nome já está cadastrado em nosso sistema.";
			}
		}
		else
		{
			$db -> exec ("update bairro set nome ='$post_nome' where id = $idBairro ");
		
			header ('location: tela_admin.php');
		}		
	}
	
	//GET da página	(quando eu entro na página)
	if (isset($_GET['id']))
	{
		$_SESSION ['$idBairro'] = $_GET['id'];
	}
	
	$bairro = $_SESSION ['$idBairro'];	
	$consultaBairro = $db -> query ("select * from bairro where id = '$bairro'") -> fetch();
	

?>
<html>
<head>
	<title>Tela Editar Admin</title>
</head>
<body>
	
	<h3>Editar Bairro </h3>
	
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<div align='left'>
		<label for='bairro'>Bairro: </label>
		<input id='bairro' type='txtbairro' name='bairro' value='<?=$consultaBairro['nome']?>'/>
	</div>
	</br>
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