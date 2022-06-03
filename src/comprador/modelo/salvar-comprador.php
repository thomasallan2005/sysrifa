<?php

    // Obter a nossa conexão com o banco de dados
    include('../../conexao/conn.php');

    // Obter os dados enviados do formulário via $_REQUEST
    $requestData = $_REQUEST;

    // Verificação de campos obrigatório do formulário
    if(empty($requestData['NOME'])){
        // Caso a variável venha vazia do formulário, retornar um erro
        $dados = array(
            "tipo" => 'error',
            "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
        );
    } else {
        // Caso os campos obrigatórios venham preenchidos, iremos realizar o cadastro
        $ID = isset($requestData['ID']) ? $requestData['ID'] : '';
        $operacao = isset($requestData['operacao']) ? $requestData['operacao'] : '';

        // Verificação para cadastro ou atualização de registro
        if($operacao == 'insert') {
            // Comandos para o INSERT no banco de dados ocorrerem
            try{
                $stmt = $pdo->prepare('INSERT INTO COMPRADOR (NOME, CELULAR) VALUES (:a, :b)');
                $stmt->execute(array(
                    ':a' => utf8_decode($requestData['NOME']),
                    ':b' => utf8_decode($requestData['CELULAR'])
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Registro salvo com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Existe(m) campo(s) obrigatório(s) não preenchido(s).'
                );
        } 
        } else {
            // Se a nossa operação vir vazia então iremos realizar um UPDATE
            try {
            $stmt = $pdo->prepare('UPDATE TIPO SET NOME = :a WHERE ID = :id');
                $stmt->execute(array(
                    ':id' => $ID,
                    ':a' => utf8_decode($requestData['NOME'])
                ));
                $dados = array(
                    "tipo" => 'success',
                    "mensagem" => 'Registro atualizado com sucesso.'
                );
            } catch(PDOException $e) {
                $dados = array(
                    "tipo" => 'error',
                    "mensagem" => 'Não foi possivel atualizar o registro.'.$e
                );
        }
        }
    }

    // Converter o nosso array de retorno em uma representação JSON
    echo json_encode($dados);