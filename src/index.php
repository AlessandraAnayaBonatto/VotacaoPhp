<!DOCTYPE html>
<?php


	if(isset($_GET['nome']))
	{
		$nome= $_GET['nome'];
	}else
	{
		$nome= '';
	}
	
	$today = date("H:i:s");
?>

<html>
	<head>

		<title> Formulário </title>

	</head>
	<body>
	
		<form method='get'>		
			<label for='txtNome'>Nome: </label>
			<input type='text' name='nome' id='txtNome'/>			
						
		</form>
		<p>
		<?php
			if(!empty ($nome))
			{
				if ($today >= "00:00:01" && $today <= "12:00:00" )
				{					
					echo "Bom Dia $nome";
				}else if ( $today <= "18:00:00")
				{
					echo "Boa Tarde $nome";
				}else
				{
					echo "Boa Noite $nome";
				}
			}
		?>
		</p>
		
		<?= $today?>
		
		<? !empty($nome) ? "Boa noite $nome!" :""?>
	</body>
</html>