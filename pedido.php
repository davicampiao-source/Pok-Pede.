
<?php

// VERIFICA SE O FORMULÁRIO FOI ENVIADO
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Acesse a loja e faça seu pedido primeiro!";
    exit;
}

// FUNÇÃO PARA PROTEGER OS TEXTOS EXIBIDOS
function limpar($valor) {
    return htmlspecialchars((string)$valor, ENT_QUOTES, "UTF-8");
}

// RECEBER OS DADOS DO FORMULÁRIO

$inicial = $_POST["inicial"] ?? "";

$raros = $_POST["segundo"] ?? [];
$voadores = $_POST["voador"] ?? [];
$shinys = $_POST["shiny"] ?? [];

// POKÉMONS DISPONÍVEIS EM ESTOQUE

$eletricos = $_POST["eléticos"] ?? "Nenhum";
$pedra = $_POST["pedra"] ?? "Nenhum";
$fogo = $_POST["fogo"] ?? "Nenhum";
$fantasma = $_POST["fantasma"] ?? "Nenhum";
$fada = $_POST["fada"] ?? "Nenhum";

// PREÇOS DAS PROMOÇÕES

$precoInicial = 1200;
$precoRaros = 500;
$precoVoadores = 300;
$precoShinys = 10000;

// LISTAS DE POKÉMONS PERMITIDOS

$iniciasPermitidos = ["Mudkip", "Treecko", "Torchic"];

$rarosPermitidos = [
    "Ralts", "Numel", "Aron",
    "Carvanha", "Cacnea", "Slugma"
];

$voadoresPermitidos = [
    "Taillow", "Spearow", "Swablu"
];

$shinysPermitidos = [
    "Beldum", "Bagon", "Snorunt"
];

// VALIDAR OS DADOS RECEBIDOS

if (!in_array($inicial, $iniciasPermitidos, true)) {
    $inicial = "";
}

if (!is_array($raros)) {
    $raros = [];
}

if (!is_array($voadores)) {
    $voadores = [];
}

if (!is_array($shinys)) {
    $shinys = [];
}

$raros = array_intersect($raros, $rarosPermitidos);
$voadores = array_intersect($voadores, $voadoresPermitidos);
$shinys = array_intersect($shinys, $shinysPermitidos);

// VALIDAR OS POKÉMONS EM ESTOQUE

$estoquePermitido = [
    "eletricos" => [
        "Nenhum", "Pikachu", "Mareep", "Shinx",
        "Electrike", "Magnemite", "Voltorb",
        "Pachirisu", "Emolga", "Yamper", "Toxel"
    ],

    "pedra" => [
        "Nenhum", "Geodude", "Onix", "Roggenrola",
        "Nosepass", "Aron", "Rhyhorn", "Larvitar",
        "Rockruff", "Dwebble", "Tyrunt"
    ],

    "fogo" => [
        "Nenhum", "Charmander", "Vulpix", "Growlithe",
        "Ponyta", "Slugma", "Numel", "Houndour",
        "Fennekin", "Litten", "Scorbunny"
    ],

    "fantasma" => [
        "Nenhum", "Gastly", "Shuppet", "Duskull",
        "Misdreavus", "Phantump"
    ],

    "fada" => [
        "Nenhum", "Clefairy", "Ralts", "Tinkatink"
    ]
];

$estoque = [
    "Elétricos" => in_array($eletricos, $estoquePermitido["eletricos"], true) ? $eletricos : "Nenhum",
    "Pedra" => in_array($pedra, $estoquePermitido["pedra"], true) ? $pedra : "Nenhum",
    "Fogo" => in_array($fogo, $estoquePermitido["fogo"], true) ? $fogo : "Nenhum",
    "Fantasma" => in_array($fantasma, $estoquePermitido["fantasma"], true) ? $fantasma : "Nenhum",
    "Fada" => in_array($fada, $estoquePermitido["fada"], true) ? $fada : "Nenhum"
];

// CALCULAR O VALOR TOTAL

$total = 0;

if ($inicial !== "") {
    $total += $precoInicial;
}

if (count($raros) > 0) {
    $total += $precoRaros;
}

if (count($voadores) > 0) {
    $total += $precoVoadores;
}

if (count($shinys) > 0) {
    $total += $precoShinys;
}

// FORMATAÇÃO DO DINHEIRO

function dinheiro($valor) {
    return "R$ " . number_format($valor, 2, ",", ".");
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pedido - PokéPede</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="box">

    <img src="Pokemon-Logo-PNG-Background-Image.png"
         alt="Logo PokéPede"
         width="150"
         height="100">

    <h3>PokéPede</h3>

    <h1>Resumo do seu pedido!</h1>

    <hr>

    <h3>Pokémon inicial</h3>

    <?php if ($inicial !== ""): ?>

        <p><?php echo limpar($inicial); ?></p>
        <p>Preço: <?php echo dinheiro($precoInicial); ?></p>

    <?php else: ?>

        <p>Nenhum Pokémon inicial selecionado.</p>

    <?php endif; ?>

    <hr>

    <h3>Pokémons raros</h3>

    <?php if (count($raros) > 0): ?>

        <?php foreach ($raros as $pokemon): ?>

            <p><?php echo limpar($pokemon); ?></p>

        <?php endforeach; ?>

        <p>Preço da promoção: <?php echo dinheiro($precoRaros); ?></p>

    <?php else: ?>

        <p>Nenhum Pokémon raro selecionado.</p>

    <?php endif; ?>

    <hr>

    <h3>Pokémons voadores</h3>

    <?php if (count($voadores) > 0): ?>

        <?php foreach ($voadores as $pokemon): ?>

            <p><?php echo limpar($pokemon); ?></p>

        <?php endforeach; ?>

        <p>Preço da promoção: <?php echo dinheiro($precoVoadores); ?></p>

    <?php else: ?>

        <p>Nenhum Pokémon voador selecionado.</p>

    <?php endif; ?>

    <hr>

    <h3>Pokémons Shinys</h3>

    <?php if (count($shinys) > 0): ?>

        <?php foreach ($shinys as $pokemon): ?>

            <p><?php echo limpar($pokemon); ?></p>

        <?php endforeach; ?>

        <p>Preço da promoção: <?php echo dinheiro($precoShinys); ?></p>

    <?php else: ?>

        <p>Nenhum Pokémon Shiny selecionado.</p>

    <?php endif; ?>

    <hr>

    <h3>Outros Pokémons em estoque</h3>

    <?php foreach ($estoque as $categoria => $pokemon): ?>

        <?php if ($pokemon !== "Nenhum"): ?>

            <p>
                <?php echo limpar($categoria); ?>:
                <?php echo limpar($pokemon); ?>
            </p>

        <?php endif; ?>

    <?php endforeach; ?>

    <hr>

    <h2>Valor total: <?php echo dinheiro($total); ?></h2>

    <hr>

    <?php if ($total > 0): ?>

        <h3>Pedido realizado com sucesso!</h3>

        <p>Obrigado por comprar na PokéPede!</p>

    <?php else: ?>

        <h3>Nenhuma promoção foi selecionada.</h3>

        <p>Volte à loja e escolha seus Pokémon!</p>

    <?php endif; ?>

    <br>

    <a href="index.html">
        <button type="button">Voltar para a loja</button>
    </a>

    <hr>

    <footer>
        <p>&copy; 2026 Loja de Pokémons. Todos os direitos reservados.</p>
    </footer>

</div>

</body>
</html>
