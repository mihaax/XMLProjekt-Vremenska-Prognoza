<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Vremenska prognoza</title>
    <style>
        body {
            position: relative;
            font-family: Arial, sans-serif;
            background-image: url("sky.jpg");
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0px;
            right: 0px;
            bottom: 0px;
            left: 0px;
            background-color: rgba(108,122,137,0.5);
        }

        .form-container {
            position: absolute;
            background-color: rgba(255,255,255,1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .form-container input {
            padding: 10px;
            margin: 10px 0;
            font-size: 1em;
        }
        .form-container button {
            padding: 10px 20px;
            font-size: 1em;
            background-color: #00008B;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #0056b3;
        }
        #tablicaGradova {
            display: none;
            margin-top: 20px;
            max-height: 300px;
            overflow-y: auto;
        }
        #tablicaGradova table {
            width: 100%;
            border-collapse: collapse;
        }
        #tablicaGradova th, #tablicaGradova td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        #tablicaGradova th {
            background-color: #f2f2f2;
        }

    </style>

    <script>
        function toggleTable() {
            var table = document.getElementById('tablicaGradova');
            if (table.style.display === 'none') {
                table.style.display = 'block';
            } 
            else {
                table.style.display = 'none';
            }
        }
    </script>
    
</head>
<body>
    <div class="form-container">
        <h1>Vremenska prognoza</h1>
        <form action="weather.php" method="GET">
            <input type="text" name="grad" placeholder="Unesite ime grada" required>
            <button type="submit">Prikaži prognozu</button>
        </form>
        <button onclick="toggleTable()">Prikaži/Sakrij listu gradova</button>
        <div id="tablicaGradova">
            <?php
            $xml = simplexml_load_file('gradovi.xml');
            echo '<table>';
            echo '<tr><th>Grad</th></tr>';
            foreach ($xml->city as $city) {
                echo '<tr><td>' . $city->name . '</td></tr>';
            }
            echo '</table>';
            ?>
        </div>
    </div>
</body>
</html>