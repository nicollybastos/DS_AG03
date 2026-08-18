<?php

$mensagem = "";
$exibirResultado = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = htmlspecialchars($_POST["txtNome"] ?? '');
    $valorCompra = filter_var($_POST["txtValorCompra"] ?? 0, FILTER_VALIDATE_FLOAT);
    $formaPagamento = $_POST["cmbPag"] ?? '';
    
    $taxaDesconto = 0;

    if ($valorCompra !== false && $valorCompra > 0) {
        switch ($formaPagamento) {
            case "deposito":
                $taxaDesconto = 0.10; // 10%
                $nomePagamento = "Depósito Bancário";
                break;
            case "boleto":
                $taxaDesconto = 0.08; // 8%
                $nomePagamento = "Boleto Bancário";
                break;
            case "cartaoCredito":
                $taxaDesconto = 0.00; // Sem desconto
                $nomePagamento = "Cartão de Crédito";
                break;
            default:
                $nomePagamento = "";
                break;
        }

        if ($nomePagamento !== "") {
            $valorDesconto = $valorCompra * $taxaDesconto;
            $valorFinal = $valorCompra - $valorDesconto;

            $fmtOriginal = number_format($valorCompra, 2, ',', '.');
            $fmtDesconto = number_format($valorDesconto, 2, ',', '.');
            $fmtFinal = number_format($valorFinal, 2, ',', '.');

            if ($taxaDesconto > 0) {
                $mensagem = "Olá, <strong>$nome</strong>! Sua compra no valor de <strong>R$ $fmtOriginal</strong> foi realizada via <strong>$nomePagamento</strong>.<br>" .
                            "Você recebeu um desconto de <strong>R$ $fmtDesconto</strong> (" . ($taxaDesconto * 100) . "%).<br>" .
                            "<strong>Valor total a pagar: R$ $fmtFinal</strong>";
            } else {
                $mensagem = "Olá, <strong>$nome</strong>! Sua compra no valor de <strong>R$ $fmtOriginal</strong> foi realizada via <strong>$nomePagamento</strong>.<br>" .
                            "Esta modalidade não possui desconto.<br>" .
                            "<strong>Valor total a pagar: R$ $fmtFinal</strong>";
            }
            $exibirResultado = true;
        } else {
            $mensagem = "Por favor, selecione uma forma de pagamento válida.";
        }
    } else {
        $mensagem = "Por favor, insira um valor de compra válido.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madeira e Cia Ltda. - Promoção de Aniversário</title>
    <style>
        :root {
            --primary-color: #5c3d2e;
            --primary-hover: #43281c;
            --bg-color: #f8f5f2;
            --card-bg: #ffffff;
            --text-color: #333333;
            --border-color: #dddddd;
            --accent-color: #2e7d32;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: var(--card-bg);
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            overflow: hidden;
        }

        .header {
            background-color: var(--primary-color);
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.5rem;
            margin-bottom: 6px;
        }

        .header p {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        form {
            padding: 24px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        .alert {
            margin: 0 24px 24px 24px;
            padding: 16px;
            border-radius: 6px;
            background-color: #e8f5e9;
            border-left: 5px solid var(--accent-color);
            color: #1b5e20;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .alert-error {
            background-color: #ffebee;
            border-left-color: #c62828;
            color: #b71c1c;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Madeira e Cia Ltda.</h1>
        <p>Promoção de Aniversário — Calcule seu Desconto</p>
    </div>

    <form method="POST" action="">
        <div class="form-group">
            <label for="txtNome">Nome do Cliente:</label>
            <input type="text" id="txtNome" name="txtNome" placeholder="Ex: Maria Silva" required>
        </div>

        <div class="form-group">
            <label for="txtValorCompra">Valor da Compra (R$):</label>
            <input type="number" id="txtValorCompra" name="txtValorCompra" step="0.01" min="0.01" placeholder="Ex: 250.00" required>
        </div>

        <div class="form-group">
            <label for="cmbPag">Forma de Pagamento:</label>
            <select id="cmbPag" name="cmbPag" required>
                <option value="" disabled selected>Selecione uma opção...</option>
                <option value="deposito">Depósito Bancário (10% de desconto)</option>
                <option value="boleto">Boleto Bancário (8% de desconto)</option>
                <option value="cartaoCredito">Cartão de Crédito (Sem desconto)</option>
            </select>
        </div>

        <button type="submit">Calcular Valor Final</button>
    </form>

    <?php if (!empty($mensagem)): ?>
        <div class="alert <?php echo $exibirResultado ? '' : 'alert-error'; ?>">
            <?php echo $mensagem; ?>
        </div>
    <?php endif; ?>
</div>

<!-- 
COMENTÁRIO REFLEXIVO SOBRE O DESENVOLVIMENTO LÓGICO DO CÓDIGO

Para a solução do problema apresentado pela empresa Madeira e Cia Ltda., a 
abordagem lógica foi dividida em três fases principais: análise/diagnóstico, 
reestruturação do backend (PHP) e design da interface (HTML/CSS).

1. Análise dos Erros no Código Original:
   - Inversão de Regras de Negócio: No código recebido, a opção 'boleto' aplicava 
     10% ($valorCompra * 0.1) e 'deposito' aplicava 8% ($valorCompra * 0.08). 
     A regra exigia o oposto: Depósito = 10% e Boleto = 8%.
   - Incompletude da Informação ao Usuário: As mensagens originais apenas informavam 
     o valor do desconto gerado, sem efetuar a subtração e apresentar o valor final 
     a ser pago pelo cliente.
   - Ausência de Formatação Monetária: Os valores em ponto flutuante do PHP eram 
     exibidos de forma bruta (ex: R$ 80 em vez de R$ 80,00).

2. Raciocínio de Correção Backend (PHP):
   - Substituição da estrutura condicional por `switch` para tornar a leitura do código 
     mais limpa e expansível.
   - Aplicação correta das alíquotas: 0.10 para depósito e 0.08 para boleto.
   - Inclusão do cálculo da diferença ($valorCompra - $valorDesconto) para encontrar o 
     valor final líquido.
   - Uso de `number_format($valor, 2, ',', '.')` para padronizar os outputs no formato 
     monetário brasileiro (R$ 0.000,00).
   - Adição de tratamento básico para entradas inválidas ou vazias para prevenção de erros.

3. Construção do Formulário Web (HTML/CSS):
   - O layout foi idealizado em torno da identidade visual de uma marcenaria/loja de móveis, 
     utilizando tons amadeirados (RGB #5c3d2e) para criar um visual profissional.
   - Utilizou-se CSS Flexbox e estilização moderna para criar um card centralizado e responsivo.
   - Os campos foram ajustados com validações nativas do HTML5 (`required`, `step="0.01"`, `min="0.01"`) 
     para evitar que dados incorretos cheguem ao servidor.
==============================================================================
-->

</body>
</html>
