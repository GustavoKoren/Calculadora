<?php
session_start();

// Função para calcular fatorial
function factorial($n)
{
    if ($n <= 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

// Função para calcular potência
function power($x, $y)
{
    return pow($x, $y);
}

// Função para limpar o histórico
function clearHistory()
{
    $_SESSION['history'] = array();
}

// Inicialização do histórico
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = array();
}

// Verificar se foi pressionado o botão de memória
if (isset($_POST['memory'])) {
    if (!isset($_SESSION['memory'])) {
        $_SESSION['memory'] = array();
    }

    if (empty($_SESSION['memory'])) {
        $_SESSION['memory'] = array(
            'num1' => $_POST['num1'],
            'num2' => $_POST['num2'],
            'operation' => $_POST['operation']
        );
    } else {
        $_POST['num1'] = $_SESSION['memory']['num1'];
        $_POST['num2'] = $_SESSION['memory']['num2'];
        $_POST['operation'] = $_SESSION['memory']['operation'];
    }
}

// Verificar se foi pressionado o botão de limpar a memória
if (isset($_POST['clear_memory'])) {
    $_SESSION['memory'] = array();
    $_SESSION['memory_operation'] = '';
}

// Verificar se foi pressionado o botão de limpar o histórico
if (isset($_POST['clear_history'])) {
    clearHistory();
}

// Realizar a operação
if (isset($_POST['calculate'])) {
    $num1 = $_POST['num1'];
    $num2 = $_POST['num2'];
    $operation = $_POST['operation'];
    $result = 0;

    switch ($operation) {
        case '+':
            $result = $num1 + $num2;
            break;
        case '-':
            $result = $num1 - $num2;
            break;
        case '*':
            $result = $num1 * $num2;
            break;
        case '/':
            if ($num2 != 0) {
                $result = $num1 / $num2;
            } else {
                $result = "Erro: divisão por zero";
            }
            break;
        case 'n!':
            $result = factorial($num1);
            break;
        case 'x^y':
            $result = power($num1, $num2);
            break;
        default:
            $result = "Operação inválida";
            break;
    }

    // Adicionar à sessão o histórico
    $history_item = array('num1' => $num1, 'num2' => $num2, 'operation' => $operation, 'result' => $result);
    array_push($_SESSION['history'], $history_item);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora PHP</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .wrapper {
        background-color: #f4f4f4;
        padding: 20px;
    }

    .container {
        max-width: 400px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px;
    }

    .input-group {
        display: flex;
        justify-content: space-between;
        width: 100%;
        margin-bottom: 15px;
    }

    .input-group>* {
        flex: 1;
        margin-right: 10px;
    }

    input[type="text"],
    select,
    input[type="submit"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        outline: none;
    }

    input[type="submit"] {
        cursor: pointer;
        background-color: #4caf50;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
        margin-top: 5px;
    }

    input[type="submit"]:hover {
        background-color: #45a049;
    }

    ul {
        list-style-type: none;
        padding: 0;
        text-align: center;
        margin-top: 20px;
    }

    li {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        background-color: #f2f2f2;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    li:nth-child(even) {
        background-color: #e0e0e0;
    }

    h3 {
        text-align: center;
        color: #333;
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <h2>Calculadora PHP</h2>
            <form method="post">
                Número 1: <input type="text" name="num1"
                    value="<?php echo isset($_POST['num1']) ? $_POST['num1'] : ''; ?>"><br><br>
                Número 2: <input type="text" name="num2"
                    value="<?php echo isset($_POST['num2']) ? $_POST['num2'] : ''; ?>"><br><br>
                Operação:
                <select name="operation">
                    <option value="+">+</option>
                    <option value="-">-</option>
                    <option value="*">*</option>
                    <option value="/">/</option>
                    <option value="n!">n!</option>
                    <option value="x^y">x^y</option>
                </select><br><br>
                <input type="submit" name="calculate" value="Calcular">
                <input type="submit" name="memory" value="M">
                <input type="submit" name="clear_memory" value="Limpar Memória">
                <input type="submit" name="clear_history" value="Limpar Histórico">
            </form>

            <?php if (isset($result)) : ?>
            <h3>Resultado: <?php echo $result; ?></h3>
            <?php endif; ?>

            <h3>Histórico:</h3>
            <ul>
                <?php foreach ($_SESSION['history'] as $item) : ?>
                <li><?php echo $item['num1'] . ' ' . $item['operation'] . ' ' . $item['num2'] . ' = ' . $item['result']; ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>

</html>