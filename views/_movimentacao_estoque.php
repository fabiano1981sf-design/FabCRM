<?php
/**
 * VIEW: _movimentacao_estoque.php (Versão Aprimorada)
 * Módulo de Movimentação de Estoque (WMS & LOGÍSTICA)
 */

// Lógica de carregamento de dados
$movimentacoes = SystemCore::getEstoqueMovements();
$mercadorias = SystemCore::getMercadorias();

// Título da página
$page_title = 'Movimentação de Estoque';
$module_name = 'movimentacao_estoque';
$form_action = 'index.php?page=' . $module_name;

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $page_title; ?></h1>

    <?php if (isset($msg)): ?>
        <div class="alert alert-<?php echo $msg['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $msg['text']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Registrar Nova Movimentação</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo $form_action; ?>" id="movimentacaoForm">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="mercadoria_id" class="form-label">Mercadoria</label>
                        <select class="form-control" id="mercadoria_id" name="mercadoria_id" required>
                            <option value="">Selecione a Mercadoria</option>
                            <?php foreach ($mercadorias as $item): ?>
                                <option value="<?php echo $item['id']; ?>" data-estoque="<?php echo $item['quantidade_estoque']; ?>">
                                    <?php echo htmlspecialchars($item['nome']) . ' (SKU: ' . $item['sku'] . ' | Estoque: ' . $item['quantidade_estoque'] . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="form-control" id="tipo" name="tipo" required>
                            <option value="entrada">Entrada</option>
                            <option value="saida">Saída</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="quantidade" class="form-label">Quantidade</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" min="1" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="observacao" class="form-label">Observação</label>
                        <input type="text" class="form-control" id="observacao" name="observacao">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Registrar Movimentação</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Histórico de Movimentações</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Mercadoria</th>
                            <th>Tipo</th>
                            <th>Quantidade</th>
                            <th>Usuário</th>
                            <th>Observação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movimentacoes as $mov): ?>
                            <tr>
                                <td><?php echo $mov['id']; ?></td>
                                <td><?php echo htmlspecialchars(date('d/m/Y H:i:s', strtotime($mov['data_movimentacao']))); ?></td>
                                <td><?php echo htmlspecialchars($mov['mercadoria_nome']); ?> (<?php echo $mov['mercadoria_sku']; ?>)</td>
                                <td>
                                    <?php 
                                    $badge_class = ($mov['tipo'] == 'entrada') ? 'bg-success' : 'bg-danger';
                                    echo "<span class=\"badge $badge_class\">" . ucfirst($mov['tipo']) . "</span>";
                                    ?>
                                </td>
                                <td><?php echo $mov['quantidade']; ?></td>
                                <td><?php echo htmlspecialchars($mov['usuario_nome']); ?></td>
                                <td><?php echo htmlspecialchars($mov['observacao']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript para Validação Extra (Adicionado para evitar saídas maiores que estoque) -->
<script>
document.getElementById('movimentacaoForm').addEventListener('submit', function(e) {
    const tipo = document.getElementById('tipo').value;
    const quantidade = parseInt(document.getElementById('quantidade').value);
    const selectedOption = document.getElementById('mercadoria_id').selectedOptions[0];
    const estoqueAtual = parseInt(selectedOption.dataset.estoque);

    if (tipo === 'saida' && quantidade > estoqueAtual) {
        alert('Quantidade de saída maior que o estoque disponível (' + estoqueAtual + ')!');
        e.preventDefault();
    }
});
</script>