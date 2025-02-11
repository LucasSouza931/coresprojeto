<?php
if (isset($_POST['send'])) {
    include "../_scripts/sql_db_connector.php";

    try {
        $destination = "temp";

        $pdo = connect_with_pdo();

        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $statement = $pdo->prepare("INSERT INTO requerimento (objeto, inicio, termino, obs, diretorio_anexo, usuario_id)
            VALUES (:objeto, :inicio, :termino, :obs, :diretorio_anexo, :usuario_id)");

        $statement->bindParam(':objeto', $_POST['objeto']);
        $statement->bindParam(':inicio', $_POST['inicio']);
        $statement->bindParam(':termino', $_POST['termino']);
        $statement->bindParam(':obs', $_POST['obs']);
        $statement->bindParam(':diretorio_anexo', $destination);
        $statement->bindParam(':usuario_id', $_SESSION['id']);

        $statement->execute();

        $statement = $pdo->prepare("SELECT * FROM requerimento WHERE usuario_id = " . $_SESSION['id'] . " ORDER BY id DESC LIMIT 1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if (isset($_FILES['anexo'])) {
            $errors     = array();
            $maxsize    = 4194304; //4 mb
            $acceptable = array('application/pdf');

            if (($_FILES['anexo']['size'] >= $maxsize) || ($_FILES["anexo"]["size"] == 0)) {
                $errors[] = 'Arquivo muito grande, o limite é 4 MB.';
            }

            if ((!in_array($_FILES['anexo']['type'], $acceptable)) && (!empty($_FILES["anexo"]["type"]))) {
                $errors[] = 'Arquivo invalido, o único tipo de arquivo que aceitamos é PDF.';
            }

            if (count($errors) === 0) {
                $temp = explode(".", $_FILES['anexo']['name']);
                $filename = $result[0]['id'] . "_" . $_SESSION['id'] . "_" . $result[0]['registro'] . '.' . end($temp);
                $filename = preg_replace("/[^a-zA-Z0-9_.]/", "_", $filename);
                $destination = "../anexo/" . $filename;

                move_uploaded_file($_FILES['anexo']['tmp_name'], $destination);

                $statement = $pdo->prepare("UPDATE requerimento SET diretorio_anexo = :diretorio_anexo WHERE id = :id");
                $statement->bindParam(':diretorio_anexo', $destination);
                $statement->bindParam(':id', $result[0]['id']);
                $statement->execute();

                header("Location: ../lista-requerimento-usuario/");
                exit;
            } else {
                foreach ($errors as $error) {
                    echo '<script>alert("' . $error . '");</script>';
                }

                die();
            }
        }
    } catch (PDOException $exception) {
        handle_pdo_exception($exception);
    }
}
