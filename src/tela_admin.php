<!DOCTYPE html>

<?php

	session_start ();
	$candidato = [];
	require_once 'conexao.php';
	
	

	//Vendo se o usuario está logado 
	if(empty($_SESSION['$email']))
	{
		header ('location: index.php');
	}
	
			
	//Validando se o usuario é administrador.
	if ($_SESSION['$Administrador'] != 1)
	{
		header ('location: tela_admin.php');
	}
	
	
	//trás as informações da tabela do candidato
	$consultaCandidato = $db -> query ("select * from candidato") -> fetchAll();
	

	//Deleta o candidato
    if (isset($_GET['DeletarCandidato'])) 
	{
		require_once 'conexao.php';
		$numero = $_GET['Numero'];
		$db -> exec ("delete from candidato where numero = $numero");
	}
	
	
	
	//trás as informações da tabela bairro
	$consultaBairro = $db -> query ("select * from bairro") -> fetchAll();
	
	
	//Deleta o bairro do banco
	if (isset($_GET['DeletarBairro']))
	{
		require_once 'conexao.php';
		$bairro = $_GET['id'];
		$db -> exec ("delete from bairro where id = $bairro");
	}
	
	
	
	
	
	
	
	
	
?>

<html>
<head>
	<title>Tela Administrador</title>
</head>
<body>

	<h3>Tela Administrador</h3>
	<br>
	
	<table>
		<tr>
			<th>Número</th>			
			<th>Nome</th>
			<th>Excluir</th>
			<th>Editar</th>
		</tr>
		
		<?php foreach ($consultaCandidato as $candidato): ?>
			<tr>
				<td><?=$candidato['numero']?></td>
				<td><?=$candidato['nome']?></td>
				<td><a href='tela_admin.php?DeletarCandidato=true&Numero=<?=$candidato['numero']?>'>Deletar</a></td>
				<td><a href='editar_candidato.php?numero=<?=$candidato['numero']?>'/>Editar</td>
			</tr>
		<?php endforeach;?>
		
	</table>
	
	<p>
		<a href='incluir_admin_candidato.php'>Incluir novo</a>	
	</p>
	
	<br>
	
	<table>
		<tr>
			<th>Id</th>			
			<th>Bairro</th>
			<th>Excluir</th>
			<th>Editar</th>
		</tr>
		
		<?php foreach ($consultaBairro as $bairro): ?>
			<tr>
				<td><?=$bairro['id']?></td>
				<td><?=$bairro['nome']?></td>
				<td><a href='tela_admin.php?DeletarBairro=true&id=<?=$bairro['id']?>'>Deletar</a></td>
				<td><a href='editar_bairro.php?id=<?=$bairro['id']?>'/>Editar</td>
			</tr>
		<?php endforeach;?>
	</table>
	
	<p>
		<a href='incluir_admin_bairro.php'/>Incluir novo</a>		
	</p>
	
	<p>
		<a href='sair_admin.php'/></td>
		<input type='submit' value='Sair'/>
	</p>
	
	
	
</body>
</html>
	
	


