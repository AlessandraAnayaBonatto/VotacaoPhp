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
		header ('location: index_logado.php');
	}

	//POST (quando eu salvo as informçãoes do formulário)
	if (isset($_POST['bairro']))
	{
		$post_nome = $_POST['bairro'];
		
		
		if($post_nome == '')
		{
			$erros [] = "é preciso informar um Bairro válido";
		
		}else
		{
		
		require_once 'conexao.php';
		
		//Validação se o bairro novo já existente			
		$existe = $db -> query ("select * from bairro where nome= '$post_nome'") -> fetch();
		
		if (isset($existe['nome']))
		{			
			$existe_nome = $existe['nome'];
						
			$erros [] = "O Bairro $existe_nome já está cadastrado em nosso sistema.";
	
		}
		else
		{
			$db -> exec ("insert into bairro
				(nome)
					values
				('$post_nome')
				");		
				
				$_SESSION ['$idBairro'] = $_GET['id'];

			header ('location: tela_admin.php');
		}	
		}
		

	}
	

?>
<html>
<head>
	<title>Tela Incluir Bairro</title>
</head>
<body>
	
	<h3>Incluir Bairro </h3>
	
	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<div align='left'>
		<label for='bairro'>Bairro: </label>
		<input id='bairro' type='txtbairro' name='bairro'/>
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
		
	


</body>
</html>