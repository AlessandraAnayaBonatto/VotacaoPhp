<!DOCTYPE html>


<?php

	session_start ();

	$falta_dados = [];
	
	require_once 'conexao.php';
	
	$listabairros = $db->query('select * from bairro');
	
	if (!empty($_POST))
	{
		
	
		//filtros	
		$email = strtolower(trim(str_replace('%40', '@', $_POST ['email'])));
		$senha = trim($_POST ['senha']);
		$nome = strtoupper (trim ($_POST['nome']));
		$data_nascimento = trim  ($_POST ['data']);
		$id_bairro = $_POST ['id_bairro'];
		
		
		
		//validações
		
		if  (empty ($nome))
		{
			$falta_dados [] = "Informe o Nome";
		}
		
		if  (empty ($data_nascimento))
		{
			$falta_dados [] = "Informe a data de nascimento";
		}
		
		if  (empty ($id_bairro))
		{
			$falta_dados [] = "Informe o Bairro";
		}
		
		if (empty($email))
		{
			$falta_dados [] = "E-mail deve ser infomado";
		}
		
		if (empty($senha))
		{
			$falta_dados [] = "Senha deve ser informada";
		}

		
		if (!empty ($email) &&!empty ($senha) &&!empty ($nome) &&!empty ($data_nascimento) &&!empty ($id_bairro))
		{
			require_once 'conexao.php';
			
			$teste = $db -> query ("select email from  usuario where email = '$email'")-> fetch ();
			
			
			if ($teste['email'] == $email)
			{	
		
				$falta_dados [] = 'Usuário já cadastrado';
					
			}
			else 
			{
				$db -> exec ("insert into usuario
				(email,nome,senha,data_nascimento,id_bairro)
					values
				('$email','$nome', '$senha','$data_nascimento','$id_bairro')");
				
				$_SESSION ['$email'] = $email;
				
				header ('location: pag_usuario.php');
			}
		}

	}else
	{
		$email = '';
		$nome = '';
		$senha = '';
		$data_nascimento = '';
		$id_bairro = '';
	}


?>

<html>
<head>
	<title>Tela de Cadastro </title>
</head>
<body>
	

	<h3>Pesquisa Eleitoral</h3>
	<p><b>Cadastro<b></p>
	
	
	<form method='post'>
	
		<p>
		<label for='txtnome'>Nome: </label>
		<input id='txtnome' type='nome' name='nome'  placeholder='Informe o Nome Completo:'/>
		</p>
		
		<p>
		<label for='txtdata'>Data de nascimento: </label>
		<input id='txtdata' type='date' name='data'  placeholder='Informe a data a ser cadastrada'/>
		</p>
		
		<div> 
			<label for="txtIdBairo">Bairro:</label> 
				<select name = "id_bairro" id="txtIdBairo"> 
					<?php foreach($listabairros as $listabairro): ?>
					<option value = '<?= $listabairro['id']?>' <?php if ($id_bairro == $listabairro['id']) echo "selected" ?> > 
					<?= $listabairro['nome']?></option>
					<?php endforeach; ?>
				</select>
		</div>
		
		<p>
		<label for='txtemail'>E-mail: </label>
		<input id='txtemail' type='email' name='email'  placeholder='Informe o E-mail:'/>
		</p>			
		
		<p>
		<label for='txtsenha'>Senha: </label>
		<input id='txtsenha' type='password' name='senha'  placeholder='Informe a senha cadastrada'/>
		</p>
		
		<p>
		<input type='submit' value='Enviar'/>
		</p>
	</form>
	
	<a href='index.php'>
			<p><input type='submit' value='Voltar'/>
	</a>
		
	<ul style='color: red'>
		<?php foreach ($falta_dados as $falta_dado): ?>
			<li><?=$falta_dado?></li>
		<?php endforeach;?>
	</ul>	

</body>
</html>