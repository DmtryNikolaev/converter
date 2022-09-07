<?php require_once('./app.html'); ?>

<?php
$api_key = 'c12708446dcc574db47b3ff6908b2650';
$result = '';

function getRate(int $value, int $count, string $currency): string
{
    $resultOfexpression = $value * $count;
    $result = "$resultOfexpression $currency";

    return $result;
}

function getURL(string $api_key, string $currency, string $crypto): string
{
    $url = "https://min-api.cryptocompare.com/data/pricemulti?fsyms=$crypto&tsyms=$currency&api_key=$api_key";

    return $url;
}

function getCost(string $url): array
{
    return json_decode(file_get_contents($url), true);
}

function setCache(array $cost, string $currency, string $crypto): bool
{
    $isExisted = apcu_exists($crypto);
    $minute = 60;

    if (!$isExisted) {
        apcu_add($crypto, $cost, $minute);

        return true;
    }

    return false;
}

if (isset($_POST['conversion'])) {
    $request = $_POST['conversion'];
    [$count, $crypto,, $currency] = explode(' ', $request);
    $crypto = strtoupper($crypto);
    $currency = strtoupper($currency);
    $url = getURL($api_key, $currency, $crypto);
    $cost = getCost($url);
    $minute = 60;

    setCache($cost, $currency, $crypto);

    $cryptoPrice = apcu_fetch($crypto)[$crypto][$currency];

    $result = getRate($cryptoPrice, $count, $currency);
}

?>
<form method="POST" class="col-6 p-0">
    <input type="text" name="conversion" class="form-control mb-2" placeholder="2 btc in usd">
    <input type="submit" value="Расчет" class="btn btn-primary w-100">
    <span>Расчет: <b><?= $result; ?></b></span>
</form>