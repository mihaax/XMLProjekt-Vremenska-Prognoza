<?php
$apikljuc = "859c7e5557a1f11db4749c94f2eaa9da";
$grad = isset($_GET['grad']) ? htmlspecialchars($_GET['grad']) : "Zagreb";
$apiUrl = "http://api.openweathermap.org/data/2.5/weather?q={$grad}&appid={$apikljuc}&units=metric";

$odaziv = @file_get_contents($apiUrl);
if ($odaziv === FALSE) {
    $errorMessage = 'Nije moguće dobiti podatke o vremenskoj prognozi. Ne postoje svi podaci o gradu ili ste krivo upisali naziv grada.';
} else {
    $data = json_decode($odaziv, true);

    if ($data["cod"] != 200) {
        $errorMessage = 'Greška: ' . $data["message"];
    } else {
        $temperatura = $data["main"]["temp"];
        $vlaga = $data["main"]["humidity"];
        $opisVremena = $data["weather"][0]["description"];
        $brzinaVjetra = $data["wind"]["speed"];
        $errorMessage = null;



        $slikeVremena = [
            'Thunderstorm' => 'thunderstorm.jpg',
            'Drizzle' => 'drizzle.jpg',
            'Rain' => 'rain.jpg',
            'Snow' => 'snow.jpg',
            'Atmosphere' => 'atmosphere.jpg',
            'Clear' => 'clear.jpg',
            'Clouds' => 'clouds.jpg',
        ];


        $pozadina = 'default.jpg';
        if (stripos($opisVremena, 'thunderstorm') !== false) {
            $pozadina = $slikeVremena['Thunderstorm'];

        } elseif (stripos($opisVremena, 'drizzle') !== false) {
            $pozadina = $slikeVremena['Drizzle'];

        } elseif (stripos($opisVremena, 'rain') !== false) {
            $pozadina = $slikeVremena['Rain'];

        } elseif (stripos($opisVremena, 'snow') !== false) {
            $pozadina = $slikeVremena['Snow'];

        } elseif (stripos($opisVremena, 'mist') !== false ||
                  stripos($opisVremena, 'smoke') !== false ||
                  stripos($opisVremena, 'haze') !== false ||
                  stripos($opisVremena, 'sand') !== false ||
                  stripos($opisVremena, 'dust') !== false ||
                  stripos($opisVremena, 'fog') !== false ||
                  stripos($opisVremena, 'volcanic ash') !== false ||
                  stripos($opisVremena, 'squalls') !== false ||
                  stripos($opisVremena, 'tornado') !== false) {
            $pozadina = $slikeVremena['Atmosphere'];
            
        } elseif (stripos($opisVremena, 'clear') !== false) {
            $pozadina = $slikeVremena['Clear'];
            
        } elseif (stripos($opisVremena, 'clouds') !== false) {
            $pozadina = $slikeVremena['Clouds'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <title>Vremenska prognoza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('<?php echo isset($pozadina) ? $pozadina : 'default.jpg'; ?>') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .weather-container {
            background-color: rgba(255, 255, 255, 1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        .temperatura {
            font-size: 2em;
            margin-bottom: 10px;
        }

        .greska {
            color: red;
            font-size: 1.3em;
        }

        .temperatura, .opis {
            display: inline-block;
            vertical-align: top;
            margin-right: 20px;
            margin-left: 10px;
        }
        .opis {
            margin-top: 5px;
            text-transform: capitalize;
            font-size: 1.5em;
            color: #555;
        }
        

    </style>
</head>
<body>
    <div class="weather-container">
        <?php if ($errorMessage): ?>
            <div class="greska"><?php echo $errorMessage; ?></div>
        <?php else: ?>
            <h1>Trenutna prognoza za grad <?php echo htmlspecialchars($grad); ?></h1>
            <div class="temperatura"><?php echo round($temperatura); ?> &deg;C</div>
            <div class="opis"><?php echo htmlspecialchars($opisVremena); ?></div>
            <div class="vlaga">Vlaga: <?php echo $vlaga; ?>%</div>
            <div class="vjetar">Vjetar: <?php echo $brzinaVjetra; ?> Km/h</div>
        <?php endif; ?>
    </div>
</body>
</html>
