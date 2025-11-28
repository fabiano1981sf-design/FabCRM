<?php
// views/_mercadorias.php - VERSÃO FINAL E BONITA

$pageTitle = "Mercadorias";
$edit = [];
$isUpdate = false;

if (isset($_GET['edit'])) {
    $edit = SystemCore::getById('mercadorias', (int)$_GET['edit']);
    $isUpdate = !empty($edit);
}

// SALVAR / EDITAR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_mercadoria') {
    $data = [
        'id'                 => $_POST['id'] ?? null,
        'nome'               => trim($_POST['nome']),
        'sku'                => trim($_POST['sku']),
        'categoria_id'       => $_POST['categoria_id'] ?: null,
        'quantidade_estoque' => (int)($_POST['quantidade_estoque'] ?? 0)
    ];

    $result = SystemCore::saveMercadoria($data, $isUpdate);

    $tipo = $result['success'] ? 'success' : 'error';
    echo "<script>
        alert('{$result['message']}');
        window.location = 'index.php?page=mercadorias';
    </script>";
    exit;
}

// EXCLUIR
if (isset($_GET['delete'])) {
    $del = SystemCore::deleteById('mercadorias', (int)$_GET['delete']);
    echo "<script>alert('{$del['message']}'); window.location='index.php?page=mercadorias';</script>";
    exit;
}

$mercadorias = SystemCore::getMercadorias();
$categorias  = SystemCore::getCategorias();
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Mercadorias</h4>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalMercadoria">
                        Nova Mercadoria
                    </button>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>SKU</th>
                                    <th>Categoria</th>
                                    <th>Estoque Atual</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($mercadorias)): ?>
                                    <tr><td colspan="6" class="text-center py-4 text-muted">Nenhuma mercadoria cadastrada</td></tr>
                                <?php else: foreach ($mercadorias as $m): ?>
                                    <tr>
                                        <td><?= $m['id'] ?></td>
                                        <td><strong><?= htmlspecialchars($m['nome']) ?></strong></td>
                                        <td><code><?= htmlspecialchars($m['sku']) ?></code></td>
                                        <td><?= htmlspecialchars($m['categoria_nome'] ?? 'Sem categoria') ?></td>
                                        <td>
                                            <span class="badge <?= $m['quantidade_estoque'] == 0 ? 'bg-danger' : 'bg-success' ?>">
                                                <?= number_format($m['quantidade_estoque']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="?page=mercadorias&edit=<?= $m['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                            <a href="?page=mercadorias&delete=<?= $m['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Excluir esta mercadoria?')">Excluir</a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalMercadoria" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <form method="POST">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><?= $isUpdate ? 'Editar' : 'Nova' ?> Mercadoria</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="save_mercadoria">
                    <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">

                    <div class="row g-3">
                        <div class="col-md-7">
                            <label>Nome da Mercadoria *</label>
                            <input type="text" name="nome" class="form-control" 
                                   value="<?= htmlspecialchars($edit['nome'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-5">
                            <label>SKU / Código *</label>
                            <input type="text" name="sku" class="form-control text-uppercase" 
                                   value="<?= htmlspecialchars($edit['sku'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-7">
                            <label>Categoria</label>
                            <select name="categoria_id" class="form-select">
                                <option value="">-- Sem categoria --</option>
                                <?php foreach ($categorias as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= ($edit['categoria_id'] ?? '') == $c['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($c['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label>Estoque Inicial</label>
                            <input type="number" name="quantidade_estoque" class="form-control" min="0" 
                                   value="<?= $edit['quantidade_estoque'] ?? '0' ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar Mercadoria</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if ($isUpdate): ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        new bootstrap.Modal(document.getElementById('modalMercadoria')).show();
    });
</script>
<?php endif; ?>