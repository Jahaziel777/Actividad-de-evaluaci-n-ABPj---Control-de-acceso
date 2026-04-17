<?php
$archivo = "auditoria.txt";
$lineas = [];

if (file_exists($archivo)) {
    $lineas = file($archivo);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Control de Acceso</title>

    <!-- Auto refresh cada 5 segundos -->
    <meta http-equiv="refresh" content="5">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #0f172a;
            color: white;
            margin: 0;
        }

        header {
            background: #020617;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            letter-spacing: 2px;
        }

        .container {
            padding: 20px;
        }

        .filtro {
            margin-bottom: 15px;
            text-align: center;
        }

        input {
            padding: 10px;
            width: 300px;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e293b;
            border-radius: 10px;
            overflow: hidden;
        }

        th {
            background: #334155;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #0f172a;
        }

        .denegado {
            background: #7f1d1d !important;
            color: #fecaca;
            font-weight: bold;
        }

        .permitido {
            background: #14532d !important;
            color: #bbf7d0;
        }
    </style>

    <script>
        function filtrar() {
            let input = document.getElementById("buscador").value.toLowerCase();
            let filas = document.querySelectorAll("tbody tr");

            filas.forEach(fila => {
                let texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(input) ? "" : "none";
            });
        }
    </script>
</head>

<body>

<header>
    🚨 DASHBOARD DE CONTROL DE ACCESOS 🚨
</header>

<div class="container">

    <!-- 🔍 Filtro -->
    <div class="filtro">
        <input type="text" id="buscador" onkeyup="filtrar()" placeholder="Buscar por ID o nombre...">
    </div>

    <!-- 📊 Tabla -->
    <table>
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Estado</th>
                <th>Detalle</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($lineas as $linea): ?>
            <?php
                $clase = "";

                if (strpos($linea, "DENEGADO") !== false || strpos($linea, "ALARMA") !== false) {
                    $clase = "denegado";
                } else {
                    $clase = "permitido";
                }

                $partes = explode(" - ", $linea);

                $fecha = $partes[0] ?? "";
                $estado = $partes[1] ?? "";
                $detalle = $partes[2] ?? "";
            ?>

            <tr class="<?php echo $clase; ?>">
                <td><?php echo $fecha; ?></td>
                <td><?php echo $estado; ?></td>
                <td><?php echo $detalle; ?></td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>

</div>

</body>
</html>