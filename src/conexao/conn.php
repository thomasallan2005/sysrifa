<?php

    // Carregar as credenciais do banco de dados
    $hostname = "sql212.epizy.com";
    $database = "epiz_31820076_sysrifa";
    $user = "	epiz_31820076";
    $password = "cVGDozGny8ux";

    try {
        $pdo = new PDO('mysql:host='.$hostname.';dbname='.$database, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo 'Conexão com o banco de dados '.$database.' foi realizado com sucesso!';
    } catch (PDOException $e) {
        echo 'Erro: '.$e->getMessage();
    }
