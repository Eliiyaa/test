<?php

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

if(!empty($_POST['name']) && !empty($_POST['last_name']) && !empty($_POST['age'])){
    console_log("No pasa");

    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $age = $_POST['age'];

    $datapost = http_build_query(
        array(
            'name' => $name,
            'last_name' => $last_name,
            'age' => $age,
        )
    );        

    $options = array('http' =>
        array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $datapost,
        )
    );

    $contexto = stream_context_create($options);

    $data = file_get_contents('http://localhost:8080/saveUser', false, $contexto);

    $res = json_decode($data);

    if ($res === true){
        echo "<script>
        window.location.href='index.php';
        alert('Registro guardado');
        </script>";
    }else{
        echo "<script>
        window.location.href='index.php';
        alert('No se pudo guardar el registro');
        </script>";
    }

}else{
    echo "<script>
    window.location.href='index.php';
    alert('No deben existir campos vacios');
    </script>";
}
    

?>