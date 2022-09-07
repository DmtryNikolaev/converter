<?php require_once('./app.html'); ?>

<?php
$api_key = 'c12708446dcc574db47b3ff6908b2650';
$url = "https://min-api.cryptocompare.com/data/pricemulti?fsyms=BTC,ETH,DOG,USDC,USDT,MATIC,FTT,FLOW,EGLD,BTTOLD&tsyms=RUB,USD&api_key=$api_key";
$list = json_decode(file_get_contents($url), true);
?>


<ul class="list-group">

    <?php foreach ($list as $key => $value) { ?>
    <li class="list-group-item">
        <?php echo $key . ' ' . $value['RUB'] . ' RUB'; ?>/ <?php echo $value['USD'] . ' USD'; ?>
    </li>
    <?php } ?>
</ul>