<?php

    //Realizar a conexão com o banco de dados
    include("../../conexao/conn.php");

    //Obter a requisição para geração da nossa tabela
    $requestData = $_REQUEST;

    //Obter as colunas que estão sendo requeridas
    $colunas = $requestData['columns'];

    //Preparar o comando sql para obtenção dos registros existentes no BD
    $sql = "SELECT ID, NOME FROM TIPO WHERE 1=1";

    //Obter o total de registro existente na tabela do BD
    $resultado = $pdo->query($sql);
    $qtdeLinhas = $resultado->rowCount();

    //Verificar se existe algum filtro determinado pelo usuário
    $filtro = $requestData['search']['value'];
    if(!empty($filtro)){
        //Montar a expressão lógica em SQL para filtrar a nossa tabela
        $sql .= " AND (ID LIKE '$filtro%' ";
        $sql .= " OR NOME LIKE '$filtro%') ";
    }
    //Obter o total de registro existente na tabela do BD de acordo com o filtro
    $resultado = $pdo->query($sql);
    $totalFiltrados = $resultado->rowCount();
    
    //Obter os valores para ordenação ORDER BY
    $colunaOrdem = $requestData['order'][0]['column'];
    $ordem = $colunas[$colunaOrdem]['data'];
    $direcao = $requestData['oreder'][0]['dir'];
    
    //Obter os valores para o LIMIT
    $inicio = $requestData['start'];
    $tamanho = $requestData['length'];
    
    //Gereando a nossa ordenação na consulta sql
    $sql .= " ORDER BY $ordem $direcao LIMIT $inicio, $tamanho";
    $resultado = $pdo->query($sql);
    $dados = array();
    while($row = $resultado->fetch(PDO::FETCH_ASSOC)){
        $dados[] = array_map('utf8_encode', $row);
    }
    
    //Construir no nosso objeto JSON no padrão DataTables
    $json_data = array(
        "draw" => intval($requestData['draw']),
        "recordsFiltered" => intval($qtdeLinhas),
        "data" => $dados
    );

    echo json_encode($json_data);