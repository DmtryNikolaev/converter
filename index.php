<?php require_once('src/views/app.html'); ?>

<?php
$api_key = 'c12708446dcc574db47b3ff6908b2650';
$result = '';
if (isset($_POST['conversion'])) {
    $request = $_POST['conversion'];
    [$count, $crypto,, $currency] = explode(' ', $request);
    $crypto = strtoupper($crypto);
    $currency = strtoupper($currency);
    $url = "https://min-api.cryptocompare.com/data/pricemulti?fsyms=$crypto&tsyms=$currency&api_key=$api_key";
    $minute = 60;
    $isExisted = apcu_exists($crypto);

    if (!$isExisted) {
        $cost = json_decode(file_get_contents($url), true)[$crypto][$currency];

        apcu_store($crypto, [$crypto => $cost], $minute);
    }


    $resultOfexpression = (int) apcu_fetch($crypto)[$crypto] * (int) $count;
    $result = "$resultOfexpression $currency";
}

?>
<div class="container mt-3">
    <form method="POST" class="col-6 p-0">
        <input type="text" name="conversion" class="form-control mb-2" placeholder="2 btc in usd">
        <input type="submit" value="Расчет" class="btn btn-primary w-100">
        <span>Расчет: <b><?= $result; ?></b></span>
    </form>
</div>