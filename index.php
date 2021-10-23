<?php

include 'conector.php';
include 'isnullOrEmpty.php';

// busca as vendas

$buscar_vendas = "SELECT
	T1.id_prod,
    T1.nome_prod,
    T2.nome_forn,
    T0.preco_venda,
    T0.data_venda
FROM vendas T0
INNER JOIN produtos T1 ON T0.id_prod = T1.id_prod
INNER JOIN fornecedores T2 ON T1.id_forn = T2.id_forn";

$query_vendas = mysqli_query($conexao, $buscar_vendas);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Teste - Braseg</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" crossorigin="anonymous">
		<!-- <link rel="stylesheet" href="assets/reset.css">
		<link rel="stylesheet" href="assets/style.css"> -->
		
	</head>
	<body>

		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>

		<header>
			<div class="container p-3 my-3 bg-dark text-white">
				<h1>Cadastro de Venda</h1>
			</div>
		</header>

		<main>
			<div class="container">
				<div class="form-control-static">
					<form action = "cadastro_vendas.php" class="form-horizontal" method = "post" class="cadastro">
						<div class="col-sm-4">
							<label for="idproduto">ID do Produto (Cadastro):</label>
							<input type="text" class="form-control" name="id_prod">
						</div>
						<div class="col-sm-4">
							<label for="data">Data da Venda:</label>
							<input type="text" class="form-control" name="data_venda" placeholder="AAAA-MM-DD">
						</div>
						
						<br>
						<input type="submit" class="btn btn-primary btn-block col-sm-4" value="Cadastrar Venda">				
					</form>
				</div>
					<br>
				<div class="form-">
					<form class="form-horizontal" class="busca">
						<div class="col-sm-4">
							<label for="idprodutopesq">ID do Produto (Consulta):</label>
							<input type="text" class="form-control" name="idprodutopesq">
						</div>
						<div class="col-sm-4">
							<label for="nomeprodutopesq">Nome do Produto:</label>
							<input type="text" class="form-control" name="nomeprodutopesq">
						</div>
						<br>
						<input type="submit" class="btn btn-primary btn-block col-sm-4" value="Buscar">
					</form>
				</div>
			</div>
			<br>
			<div class="container">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome do produto</th>
							<th>Fornecedor</th>
							<th>Preço</th>
							<th>Data da Venda</th>
						</tr>
					</thead>
					<tbody>
						<?php



							while ($receber_vendas = mysqli_fetch_array($query_vendas)) {
									$id_prod = $receber_vendas['id_prod'];
									$nome_prod = $receber_vendas['nome_prod'];
									$nome_forn = $receber_vendas['nome_forn'];
									$preco_venda = $receber_vendas['preco_venda'];
									$data_venda = $receber_vendas['data_venda'];
							
						?>
						<tr>
							<td><?php echo $id_prod;  ?></td>
							<td><?php echo $nome_prod;  ?></td>
							<td><?php echo $nome_forn;  ?></td>
							<td><?php echo $preco_venda;  ?></td>
							<td><?php echo $data_venda;  ?></td>
							
						
						<?php } 

						$somar_vendas = "SELECT
							SUM(preco_venda) as 'soma'
						FROM vendas
						GROUP BY 'soma'";

						$query_total = mysqli_query($conexao, $somar_vendas);

						$recebe_total = mysqli_fetch_assoc($query_total);

						$soma = $recebe_total['soma'];

						?>
							<td colspan="5">Total vendido: <?php echo $soma; ?></td>
						</tr>
					</tbody>
				</table>
				<br>
				<br>
			<table class="table table-hover">
				<thead>
					<tr>
						<th>ID</th>
						<th>Nome do produto</th>
						<th>Fornecedor</th>
						<th>Preço</th>
					</tr>
				</thead>
				<tbody>
					<?php  
					
					if (!isset($_GET['idprodutopesq']) ) {
						
					?>
					<tr>
						<td colspan="4">Digite o produto que você deseja consultar...</td>
					</tr>
					<?php
					} else {
						$idproduto = $_GET['idprodutopesq'];
						$nomeproduto = $_GET['nomeprodutopesq'];

						$buscar_produtos = "SELECT 
							T0.id_prod,
						    T0.nome_prod,
						    T1.nome_forn,
						    T0.preco_prod
						FROM produtos T0
						INNER JOIN fornecedores T1 ON T0.id_forn = T1.id_forn
						WHERE ";						

						if (!IsNullOrEmpty($idproduto) && !IsNullOrEmpty($nomeproduto)) {
							$buscar_produtos = $buscar_produtos."T0.id_prod = $idproduto OR T0.nome_prod LIKE '%$nomeproduto%'";
						}

						if (!IsNullOrEmpty($nomeproduto) && IsNullOrEmpty($idproduto)) {
							$buscar_produtos = $buscar_produtos."T0.nome_prod LIKE '%$nomeproduto%'";
						}

						if (!IsNullOrEmpty($idproduto) && IsNullOrEmpty($nomeproduto)) {
							$buscar_produtos = $buscar_produtos."T0.id_prod = $idproduto";
						}

						$query_busca = mysqli_query($conexao, $buscar_produtos);
						
						while ($receber_produtos = mysqli_fetch_array($query_busca)) {
									$id_prod = $receber_produtos['id_prod'];
									$nome_prod = $receber_produtos['nome_prod'];
									$nome_forn = $receber_produtos['nome_forn'];
									$preco_prod = $receber_produtos['preco_prod'];									
										
					?>
					<tr>
						<td><?php echo $id_prod; ?></td>
						<td><?php echo $nome_prod; ?></td>
						<td><?php echo $nome_forn; ?></td>
						<td><?php echo $preco_prod; ?></td>
					</tr>
					<?php } } ?>
				</tbody>
			</table>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>