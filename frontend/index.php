<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <header>

    </header>

    <div class="form-lg">
        <div class="card">
            <p>DATOS PERSONALES</p>
            <form action="guardar.php" method="POST">
                <div class="input-group">
                    <label class="labelForm">Name:</label>
                    <input class="inputText" type="text" name="name" id="name" placeholder="Carlos">
                </div>
                <div class="input-group">
                    <label class="labelForm">Apellido:</label>
                    <input class="inputText" type="text" name="last_name" id="last_name" placeholder="Sanchez">
                </div>
                <div class="input-group">
                    <label class="labelForm">Edad:</label>
                    <input class="inputText" type="text" name="age" id="age" placeholder="20">
                </div>
                <div class="input-group">
                    <input class="buttonSave" type="submit" value="GUARDAR">
                </div>
            </form>
        </div>
    </div>

    <div class="card">

        <table class="table">

            <thead>
            <tr>
                <th>NOMBRE</th>
                <th>APELLIDO</th>
                <th>EDAD</th>
                <th>OPCIONES</th>
            </tr>
            </thead>
            <tbody>
            
            <?php
                $data = file_get_contents("http://localhost:8080/getUser");
                $res = json_decode($data);
                
                if($res != ""){
                for($i=0;$i<count($res);$i++){
                    echo "<tr>";
                    echo "<td>". $res[$i]->name."</td>";
                    echo "<td>". $res[$i]->last_name."</td>";
                    echo "<td>". $res[$i]->age."</td>";
                    echo "<td>";
                    echo "<a class='delete' href='eliminar.php?id=". $res[$i]->id. "'>Eliminar</a>";
                    echo "<a class='editar' href='buscarID.php?id=". $res[$i]->id. "'>Editar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                }
            ?>
            </tbody>
        </table>
    </div>

    <script src="confirmar.js"></script>
</body>
</html>