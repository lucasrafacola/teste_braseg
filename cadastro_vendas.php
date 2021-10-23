<?php

include 'conector.php';

$id_prod = $_POST['id_prod'];
$data_venda = $_POST['data_venda'];

$recebe_preco_prod = "SELECT preco_prod FROM produtos WHERE id_prod = $id_prod";

$query_recebe_preco_prod = mysqli_query($conexao, $recebe_preco_prod);

if (mysqli_num_rows($query_recebe_preco_prod) > 0) {

	$row = mysqli_fetch_assoc($query_recebe_preco_prod);
	$preco_produto = $row['preco_prod'];

	$recebe_venda = "INSERT INTO
	vendas
	VALUES ('', '$id_prod', '$data_venda', '$preco_produto')";

	$query_venda = mysqli_query($conexao, $recebe_venda);

	header('location:index.php');
	
} else {
	echo "Digite um ID válido";
}