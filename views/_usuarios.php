<?php
/**
 * VIEW: _usuarios.php
 * Módulo de Usuários (ADMINISTRAÇÃO)
 */

// Lógica de carregamento de dados
$usuarios = SystemCore::getUsers();

// Título da página
$page_title = 'Usuários';
$module_name = 'usuarios';
$form_action = 'index.php?page=' . $module_name . ($id ? '&action=edit&id=' . $id : '');

// Dados para edição
$edit_data = $edit_data ?? ['id' => '', 'nome' => '', 'email' => '', 'role' => 'visualizador'];

$role_options = ['admin' => 'Administrador', 'despachante' => 'Despachante', 'visualizador' => 'Visualizador'];

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
            <h6 class="m-0 font-weight-bold text-primary"><?php echo $id ? 'Editar' : 'Cadastrar Novo'; ?> Usuário</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="<?php echo $form_action; ?>">
                <?php if ($id): ?>
                    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($edit_data['nome']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($edit_data['email']); ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="role" class="form-label">Nível de Acesso</label>
                        <select class="form-control" id="role" name="role" required>
                            <?php foreach ($role_options as $key => $value): ?>
                                <option value="<?php echo $key; ?>" <?php echo ($edit_data['role'] == $key) ? 'selected' : ''; ?>>
                                    <?php echo $value; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Senha <?php echo $id ? '(Deixe em branco para não alterar)' : ''; ?></label>
                        <input type="password" class="form-control" id="password" name="password" <?php echo $id ? '' : 'required'; ?>>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirm" class="form-label">Confirmar Senha</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" <?php echo $id ? '' : 'required'; ?>>
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
            <h6 class="m-0 font-weight-bold text-primary">Lista de Usuários</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Nível de Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $item): ?>
                            <tr>
                                <td><?php echo $item['id']; ?></td>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td><?php echo htmlspecialchars($item['email']); ?></td>
                                <td><?php echo $role_options[$item['role']]; ?></td>
                                <td>
                                    <a href="index.php?page=<?php echo $module_name; ?>&action=edit&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-info">Editar</a>
                                    <?php if ($item['id'] != $currentUser['id']): // Não permite excluir o próprio usuário logado ?>
                                        <a href="index.php?page=<?php echo $module_name; ?>&action=delete&id=<?php echo $item['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">Excluir</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
