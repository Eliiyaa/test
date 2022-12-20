<?php

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
console_log($_GET['id']);

if(!empty($_GET['id'])){

    $id = $_GET['id'];        

    $options = array('http' =>
        array(
            'method'  => 'DELETE',
            'header'  => 'Content-type: application/x-www-form-urlencoded'
        )
    );

    $contexto = stream_context_create($options);

    $data = file_get_contents('http://localhost:8080/delete/'.$id, false, $contexto);

    $res = json_decode($data);
    console_log($res);

    if ($res === true){
        echo "<script>
        window.location.href='index.php';
        alert('Registro eliminado');
        </script>";
    }else{
        echo "<script>
        window.location.href='index.php';
        alert('No se pudo eliminar el registro');
        </script>";
    }

}else{
    echo "<script>
    window.location.href='index.php';
    alert('No deben existir campos vacios');
    </script>";
}
    

?>