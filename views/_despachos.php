<?php
/**
 * VIEW: _despachos.php
 * Módulo de Despachos (WMS & LOGÍSTICA)
 */

// Lógica de carregamento de dados
$despachos = SystemCore::getDespachos();
$transportadoras = SystemCore::getTransportadoras();
$mercadorias = SystemCore::getMercadorias();

// Título da página
$page_title = 'Despachos';
$module_name = 'despachos';
$form_action = 'index.php?page=' . $module_name . ($id ? '&action=edit&id=' . $id : '');

// Dados para edição
$edit_data = $edit_data ?? [
    'id' => '', 'codigo_rastreio' => '', 'data_envio' => date('Y-m-d'), 
    'data_prevista_entrega' => '', 'status' => 'Em Processamento', 
    'origem_nome' => '', 'origem_cep' => '', 'origem_endereco' => '', 
    'destino_nome' => '', 'destino_cep' => '', 'destino_endereco' => '', 
    'destino_telefone' => '', 'numero_nota' => '', 'anotacao1' => '', 
    'anotacao2' => '', 'transportadora_id' => '', 'mercadoria_principal_id' => ''
];

$status_options = ['Em Processamento', 'Em Trânsito', 'Aguardando Retirada', 'Entregue', 'Cancelado'];

?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?php echo $page_title; ?></h1>

    <?php if (isset($msg)): ?>
        <div class="alert alert-<?php echo $msg['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $msg['text']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Formulário de Cadastro/Edição -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $id ? 'Editar' : 'Cadastrar Novo'; ?> Despacho</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo $form_action; ?>">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="codigo_rastreio" class="form-label">Código de Rastreio</label>
                        <input type="text" class="form-control" id="codigo_rastreio" name="codigo_rastreio" value="<?php echo htmlspecialchars($edit_data['codigo_rastreio']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="data_envio" class="form-label">Data de Envio</label>
                        <input type="date" class="form-control" id="data_envio" name="data_envio" value="<?php echo htmlspecialchars($edit_data['data_envio']); ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="data_prevista_entrega" class="form-label">Previsão de Entrega</label>
                        <input type="date" class="form-control" id="data_prevista_entrega" name="data_prevista_entrega" value="<?php echo htmlspecialchars($edit_data['data_prevista_entrega']); ?>">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <?php foreach ($status_options as $status): ?>
                                <option value="<?php echo $status; ?>" <?php echo ($edit_data['status'] == $status) ? 'selected' : ''; ?>>
                                    <?php echo $status; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="transportadora_id" class="form-label">Transportadora</label>
                        <select class="form-control" id="transportadora_id" name="transportadora_id">
                            <option value="">Selecione</option>
                            <?php foreach ($transportadoras as $transp): ?>
                                <option value="<?php echo $transp['id']; ?>" <?php echo ($edit_data['transportadora_id'] == $transp['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($transp['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="mercadoria_principal_id" class="form-label">Mercadoria Principal</label>
                        <select class="form-control" id="mercadoria_principal_id" name="mercadoria_principal_id">
                            <option value="">Selecione</option>
                            <?php foreach ($mercadorias as $merc): ?>
                                <option value="<?php echo $merc['id']; ?>" <?php echo ($edit_data['mercadoria_principal_id'] == $merc['id']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($merc['nome']) . ' (SKU: ' . $merc['sku'] . ')'; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr>
                <h5>Dados de Destino</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="destino_nome" class="form-label">Nome/Razão Social Destino</label>
                        <input type="text" class="form-control" id="destino_nome" name="destino_nome" value="<?php echo htmlspecialchars($edit_data['destino_nome']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="destino_cep" class="form-label">CEP Destino</label>
                        <input type="text" class="form-control" id="destino_cep" name="destino_cep" value="<?php echo htmlspecialchars($edit_data['destino_cep']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="destino_telefone" class="form-label">Telefone Destino</label>
                        <input type="text" class="form-control" id="destino_telefone" name="destino_telefone" value="<?php echo htmlspecialchars($edit_data['destino_telefone']); ?>">
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="destino_endereco" class="form-label">Endereço Destino</label>
                        <input type="text" class="form-control" id="destino_endereco" name="destino_endereco" value="<?php echo htmlspecialchars($edit_data['destino_endereco']); ?>">
                    </div>
                </div>

                <hr>
                <h5>Outras Informações</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="numero_nota" class="form-label">Número da Nota Fiscal</label>
                        <input type="text" class="form-control" id="numero_nota" name="numero_nota" value="<?php echo htmlspecialchars($edit_data['numero_nota']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="anotacao1" class="form-label">Anotação 1</label>
                        <input type="text" class="form-control" id="anotacao1" name="anotacao1" value="<?php echo htmlspecialchars($edit_data['anotacao1']); ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="anotacao2" class="form-label">Anotação 2</label>
                        <input type="text" class="form-control" id="anotacao2" name="anotacao2" value="<?php echo htmlspecialchars($edit_data['anotacao2']); ?>">
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary"><?php echo $id ? 'Salvar Alterações' : 'Cadastrar'; ?></button>
                <?php if ($id): ?>
                    <a href="index.php?page=<?php echo $module_name; ?>" class="btn btn-secondary">Cancelar Edição</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- Tabela de Registros -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Lista de Despachos</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Rastreio</th>
                            <th>Data Envio</th>
                            <th>Status</th>
                            <th>Destino</th>
                            <th>Transportadora</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($despachos as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo htmlspecialchars($item['codigo_rastreio']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($item['data_envio'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php 
                                        if ($item['status'] === 'Entregue') echo 'success';
                                        else if ($item['status'] === 'Cancelado') echo 'danger';
                                        else if ($item['status'] === 'Em Trânsito') echo 'info';
                                        else echo 'warning';
                                    ?>">
                                        <?php echo $item['status']; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($item['destino_nome']); ?></td>
                                <td><?php echo htmlspecialchars($item['transportadora_nome']); ?></td>
                                <td>
                                    <a href="index.php?page=<?php echo $module_name; ?>&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">Editar</a>
                                    <a href="index.php?page=<?php echo $module_name; ?>&action=delete&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este despacho?');">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
