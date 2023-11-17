<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>The Dream</title>
</head>
<body>
<div class="flex flex-col justify-center text-center pt-6">
    <h1 class="text-3xl font-bold underline pb-6" >The dream | Choose your destination</h1>
    <form method="get">
        <label for="number">Local Rate:</label>
        <input class="border border-black" type="number" id="number" name="number" step="0.01" required>
        <hr>
        <div class="flex flex-row gap-x-4 justify-center" >
            <input type="radio" id="nzd" name="rate" value="nzd">
            <label for="nzd">Nouvelle-Zélande</label><br>
            <input type="radio" id="aud" name="rate" value="aud">
            <label for="aud">Australie</label><br>
            <input type="radio" id="drh" name="rate" value="drh">
            <label for="drh">Maroc</label><br>
            <input type="radio" id="yen" name="rate" value="yen">
            <label for="yen">Japon</label>
        </div>
        <hr class="p-6" >
        <input type="submit" class="flex w-auto m-auto justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" value="Convert">
    </form>
    <?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['number']) && isset($_GET['rate'])) {
    $number = floatval($_GET['number']);
    $selectedRate = $_GET['rate'];

    // Préparez la requête cURL
    $curl = curl_init();
    curl_setopt_array($curl, [
        CURLOPT_URL => "https://currency-conversion-and-exchange-rates.p.rapidapi.com/latest?from=EUR&to=AUD%2CNZD%2CJPY%2CMAD",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "X-RapidAPI-Host: currency-conversion-and-exchange-rates.p.rapidapi.com",
            "X-RapidAPI-Key: efb5917a05msh041ce2aaa7dc31bp1298f9jsnf8011bc7ffe3"
        ],
    ]);

    // Exécutez la requête cURL
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $data = json_decode($response, true);

        // Récupérez le taux de change approprié
        $currencyMap = ['nzd' => 'NZD', 'aud' => 'AUD', 'drh' => 'MAD', 'yen' => 'JPY'];
        if (array_key_exists($selectedRate, $currencyMap) && isset($data['rates'][$currencyMap[$selectedRate]])) {
            $rate = $data['rates'][$currencyMap[$selectedRate]];
            $convertedAmount = $number * $rate;
            echo "<br>Converted Amount: " . $convertedAmount;
        } else {
            echo "<br>Invalid currency selection or rate not available.";
        }
    }
}
?>


</div>
</body>
</html>
