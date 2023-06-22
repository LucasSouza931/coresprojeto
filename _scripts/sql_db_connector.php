<?php
function get_database_config()
{
    $server_ip = $_SERVER['SERVER_ADDR'];
    $is_local = ($server_ip === '127.0.0.1' || $server_ip === '::1');

    return $is_local ?
        [
            'db_hostname' => 'localhost',
            'db_user' => 'root',
            'db_pass' => '',
            'db_name' => 'requerimentos',
        ] : [
            'db_hostname' => 'remote_server_ip',
            'db_user' => 'remote_username',
            'db_pass' => 'remote_password',
            'db_name' => 'remote_database',
        ];
}

function connect_with_pdo()
{
    $config = get_database_config();
    $dsn = "mysql:host={$config['db_hostname']};dbname={$config['db_name']}";
    return new PDO($dsn, $config['db_user'], $config['db_pass']);
}

function handle_pdo_exception(PDOException $e)
{
    echo "
    <div class='flex-column'>
        <h1>ERRO</h1>
        
        <div class='box'>
            <p>" . $e->getMessage() . "</p>
        </div>
    </div>
    ";
}