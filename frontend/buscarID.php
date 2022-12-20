<?php

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}


if(!empty($_GET['id'])){

    $id = $_GET['id'];        

    $data = file_get_contents("http://localhost:8080/getUser/".$id);
    $res = json_decode($data);

    editForm($res);

}else{
    echo "<script>
    window.location.href='index.php';
    alert('Hubo un error');
    </script>";
}


function editForm($data){
    echo "
    <!DOCTYPE html>
    <html lang='es'>
    <head>
        <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Crud</title>
        <link rel='stylesheet' href='style.css'>
    </head>
    <body>
    
        <header>
    
        </header>
    
        <div class='form-lg'>
            <div class='card'>
                <p>EDITAR REGISTRO</p>
                <form action='modificar.php' method='POST'>
                    <input type='text' name='id' value='".$data[0]->id."' hidden>
                    <div class='input-group'>
                        <label class='labelForm'>Name:</label>
                        <input class='inputText' type='text' name='name' value='".$data[0]->name."'>
                    </div>
                    <div class='input-group'>
                        <label class='labelForm'>Apellido:</label>
                        <input class='inputText' type='text' name='last_name' value='".$data[0]->last_name."'>
                    </div>
                    <div class='input-group'>
                        <label class='labelForm'>Edad:</label>
                        <input class='inputText' type='text' name='age' value='".$data[0]->age."'>
                    </div>
                    <div class='input-group2'>
                        <input class='buttonSave' type='submit' value='MODIFICAR'>
                    </div>
                    <div class='input-group2'>
                        <a class='back' href='index.php'>REGRESAR</a>
                    </div>
                </form>
            </div>
        </div>
    ";
}
    

?>