<!DOCTYPE html>
<?php

	session_start ();

	$erros = [];
	
	require_once 'conexao.php';

	//Vendo se o usuario est� logado 
	if(empty($_SESSION['$email']))
	{
		header ('location: votar.php');
	}

	//Mostra os candidatos na tela, tr�s do banco
	$consultaCandidato = $db -> query ("select * from candidato") -> fetchAll();

	
	if (isset($_POST['numero']))
	{
		$pode_votar = true;
		
		$post_numero_candidato = $_POST['numero'];
		
		if(isset($_SESSION['$ja_votou']))
		{
			if($_SESSION['$ja_votou'])
			{
				$pode_votar = false;
				$erros [] = "Voc� j� votou, para poder substituir seu voto, saia da p�gina e fa�a seu login novamente";
			}
			
		}

		if(empty($post_numero_candidato))
		{
			$erros [] = "Erro,voc� precisa colocar um n�mero v�lido";
			$pode_votar = false;
		}
		
		$existe = $db -> query ("select * from candidato where numero = $post_numero_candidato") -> fetch();
			
		if(!isset($existe['numero']))
		{
			$erros[] = "Este n�mero n�o consta no nosso Banco de dados, Por favor informar um n�mero v�lido";
			$pode_votar = false;
		}
		if($pode_votar)
		{
			$usuario = $_SESSION['$email'];
				
			$contagem_votos = $db -> query ("update usuario set voto = $post_numero_candidato where email = '$usuario'") -> fetch();
				
			$_SESSION['$ja_votou'] = true; 		
		}
	}
?>
<html>
<head>
	<title>Tela Voto</title>
</head>
<body>
	
	<h3>Candidatos</h3>
	<table>
		<tr>
			<th>N�mero</th>			
			<th>Nome</th>
		</tr>
		
		<?php foreach ($consultaCandidato as $candidato): ?>
			<tr>
				<td><?=$candidato['numero']?></td>
				<td><?=$candidato['nome']?></td>
			</tr>
		<?php endforeach;?>
		
	</table>

	<h3>Vote Aqui</h3>	

	<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
	<div align='left'>
		<label for='numero'>N�mero: </label>
		<input id='numero' type='number' name='numero'  placeholder='Informe o n�mero'/>
	</div>
	</br>
	</br>

	<input type='submit' value='Enviar Voto'/>
	</form>
	
	<a href='index_logado.php'>
		<p><input type='submit' value='Voltar'/>
	</a>
	
	<ul style='color: red'>
		<?php foreach ($erros as $erro): ?>
			<li><?=$erro?></li>
	<?php endforeach;?>

</body>
</html>