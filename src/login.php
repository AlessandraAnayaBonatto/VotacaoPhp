<!DOCTYPE html>


<?php

	session_start ();
	

	$cadastro_nulos = [];	
	
	if (!empty($_POST))
	{
	
		//filtros	
		$email = strtolower(trim(str_replace('%40', '@', $_POST ['email'])));
		$senha = trim($_POST ['senha']);
		
		
		//validações
		if (empty($email))
		{
			$cadastro_nulos [] = "E-mail deve ser infomado";
		}
		
		if (empty($senha))
		{
			$cadastro_nulos [] = "Senha deve ser informada";
		}
		
		require_once 'conexao.php';
	
		if(!empty($email))
		{
			
			$valida = $db -> query ("select * from usuario where email = '$email' and senha = '$senha'") -> fetch ();
			
			
			if ($email == $valida ['email'] && $senha == $valida['senha'])
			{
				$_SESSION ['$email']= $email;
				
				$_SESSION ['$Administrador'] = $valida['Administrador'];
				
			
				
				if($valida['Administrador'] == 0)
				{				
					
					header ('location:  index_logado.php');
				}
				else
				{	
					header ('location: tela_admin.php');
				}
			}else
			{
				$cadastro_nulos [] = "Usuario ou e-mail não cadastrado / senha inválida.";
			}	

			
		}

	}
	

?>


<html>
<head>
	
	<title> Tela de Login</title>
	
</head>
<body>

	<h3>Pesquisa Eleitoral</h3>
	<p><b>Login<b></p>
	
	
	<form method='post'>	
		<p>
		<label for='txtemail'>E-mail: </label>
		<input id='txtemail' type='email' name='email'  placeholder='Informe o E-mail cadastrado'/>
		</p>
		
		<p>
		<label for='txtsenha'>Senha: </label>
		<input id='txtsenha' type='password' name='senha'  placeholder='Informe a senha cadastrada'/>
		</p>

		<p>
		<input type='submit' value='Entrar'/>
		</p>
	</form>	
	
	<a href='index.php'>
		<input type='submit' value='Voltar'/>
	</a>
	
	<ul style='color: red'>
		<?php foreach ($cadastro_nulos as $cadastro_nulo): ?>
			<li><?=$cadastro_nulo?></li>
		<?php endforeach;?>
	</ul>	


</body>
</html>