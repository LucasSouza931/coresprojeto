<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php
    include "../_templates/echoer.php";
    include "../_templates/head.php";

    head_constructor("Lista de requerimentos", true);
    ?>

    <meta name="description" content="Essa é a página que os admins manejam os requerimentos enviados para a CORES do IFBA Campus Eunápolis">
</head>


<body>
    <?php
    include "../_templates/header.php";
    ?>

    <main>
        <div class="flex-column">
            <h1>Painel de controle</h1>
            <div class="flex-row">
                <a href="../lista-requerimento-admin/" class="no-deco">
                    <div class="box">
                        lista de requerimentos
                    </div>
                </a>
                <a href="../lista-usuario-admin/" class="no-deco">
                    <div class="box">
                        Usuários cadastrados
                        require_once 'usuarios.php';
                        $usuarios = getUsuarios();
                        foreach ($usuarios as $usuario) {
                            echo '<li>' . $usuario['nome'] . ' - <a href="editar_usuario.php?id=' . $usuario['id'] . '">Editar</a> | <a href="usuarios.php?acao=remover&id=' . $usuario['id'] . '">Remover</a></li>';
                        }
                    </div>
                </a>
            </div>
        </div>
    </main>

    <?php
    show("../_templates/footer.html");
    ?>
</body>

</html>
