<?php
/**
 * VIEW: _dashboard.php
 * Página principal do sistema com estatísticas e visão geral.
 */

$stats = SystemCore::getDashboardStats();

// Helper para formatar moeda
function formatCurrency($value) {
    return 'R$ ' . number_format($value, 2, ',', '.');
}

// Helper para formatar número
function formatNumber($value) {
    return number_format($value, 0, ',', '.');
}

?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Linha de Cartões de Estatísticas (WMS & Logística) -->
    <div class="row">

        <!-- Despachos Entregues (Últimos 30 dias) -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Despachos Entregues (30d)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['entregues']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Despachos em Processamento -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Despachos em Processamento</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['em_processamento']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shipping-fast fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total de Mercadorias Cadastradas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Mercadorias</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['total_mercadorias']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quantidade Total em Estoque -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Qtd. Total em Estoque</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['qtd_total_estoque']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Linha de Cartões de Estatísticas (CRM & Financeiro) -->
    <div class="row">

        <!-- Total de Clientes -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total de Clientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['total_clientes']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-handshake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Oportunidades Abertas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Oportunidades Abertas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatNumber($stats['oportunidades_abertas']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullhorn fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vendas Mês Corrente -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Vendas Mês Corrente</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatCurrency($stats['pedidos_venda_mes']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contas Atrasadas -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Contas Atrasadas (Pagar/Receber)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo formatCurrency($stats['contas_atrasadas']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Gráficos e Tabelas (Placeholder) -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Resumo Financeiro (Aberto)</h6>
                </div>
                <div class="card-body">
                    <p>Contas a Pagar (Futuras): <strong><?php echo formatCurrency($stats['contas_a_pagar_aberto']); ?></strong></p>
                    <p>Contas a Receber (Futuras): <strong><?php echo formatCurrency($stats['contas_a_receber_aberto']); ?></strong></p>
                    <p>Ticket Médio de Venda (Mês): <strong><?php echo formatCurrency($stats['ticket_medio']); ?></strong></p>
                    <hr>
                    <p class="text-muted">Espaço reservado para gráficos de fluxo de caixa e vendas.</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Próximos Despachos</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Espaço reservado para uma lista dos próximos despachos com data prevista de entrega.</p>
                </div>
            </div>
        </div>
    </div>

</div>
