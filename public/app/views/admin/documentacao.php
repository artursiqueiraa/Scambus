<script src="https://cdnjs.cloudflare.com/ajax/libs/mermaid/10.9.0/mermaid.min.js"></script>
<script>
mermaid.initialize({
    startOnLoad: false,
    theme: 'neutral',
    securityLevel: 'loose',
    flowchart: { useMaxWidth: true, htmlLabels: true },
    sequence: { useMaxWidth: true, showSequenceNumbers: false },
    er: { useMaxWidth: true }
});
window.addEventListener('load', function() {
    mermaid.run({ querySelector: '.mermaid' });
});
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

.doc-wrap { max-width: 1100px; margin: 40px auto; font-family: 'Plus Jakarta Sans', sans-serif; color: #1e293b; }

/* BACK LINK */
.doc-back { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-size: 0.875rem; font-weight: 600; margin-bottom: 1.25rem; transition: color 0.2s; }
.doc-back:hover { color: #0d2b6e; }

/* HEADER */
.doc-header {
    background: linear-gradient(135deg, #0d2b6e 0%, #1a3d8f 100%);
    border-radius: 20px; padding: 36px 40px; margin-bottom: 28px;
    display: flex; align-items: center; justify-content: space-between;
}
.doc-header h1 { font-size: 22px; font-weight: 800; color: #fff; margin: 0 0 6px; }
.doc-header p  { margin: 0; color: #a5b8e8; font-size: 13px; }
.doc-version {
    background: rgba(201,162,39,0.2); border: 1px solid rgba(201,162,39,0.4);
    color: #C9A227; padding: 8px 16px; border-radius: 100px;
    font-size: 12px; font-weight: 700; white-space: nowrap;
}

/* INFO GRID */
.info-grid { display: grid; grid-template-columns: repeat(5,1fr); gap: 14px; margin-bottom: 24px; }
.info-box { background: #fff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 18px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,.04); }
.info-box-icon { font-size: 26px; margin-bottom: 6px; }
.info-box-label { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing:.07em; font-weight:600; }
.info-box-value { font-size: 20px; font-weight: 800; color: #0d2b6e; margin-top: 2px; }

/* TABS */
.doc-tabs { display: flex; gap: 8px; margin-bottom: 24px; flex-wrap: wrap; }
.doc-tab {
    padding: 9px 16px; border-radius: 10px; border: 1px solid #e2e8f0;
    background: #fff; font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13px; font-weight: 600; color: #64748b; cursor: pointer; transition: all .2s;
}
.doc-tab:hover { background: #f1f5f9; color: #0d2b6e; }
.doc-tab.active { background: #0d2b6e; color: #fff; border-color: #0d2b6e; }

/* SECTIONS */
.doc-section { display: none; }
.doc-section.active { display: block; }

/* CARD */
.doc-card {
    background: #fff; border: 1px solid #e2e8f0; border-radius: 16px;
    overflow: hidden; margin-bottom: 24px; box-shadow: 0 2px 12px rgba(0,0,0,.04);
}
.doc-card-header {
    padding: 14px 22px; border-bottom: 1px solid #f1f5f9;
    display: flex; align-items: center; gap: 12px; background: #f8fafc;
}
.doc-card-icon {
    width: 34px; height: 34px; border-radius: 9px; background: #0f172a;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px; flex-shrink: 0;
}
.doc-card-header h3 { margin: 0 0 2px; font-size: 14px; font-weight: 700; color: #0f172a; }
.doc-card-header p  { margin: 0; font-size: 11px; color: #94a3b8; }

/* BODY */
.doc-card-body { padding: 24px; overflow-x: auto; background: #fff; }

/* IMAGEM DO DIAGRAMA */
.diagrama-img {
    width: 100%; border-radius: 10px;
    border: 1px solid #e2e8f0; display: block;
    margin-bottom: 0;
}
.diagrama-img-placeholder {
    background: #f8fafc; border: 2px dashed #cbd5e1;
    border-radius: 10px; padding: 40px;
    text-align: center; color: #94a3b8;
    font-size: 13px; margin-bottom: 0;
}
.diagrama-img-placeholder span { font-size: 32px; display: block; margin-bottom: 8px; }

/* CÓDIGO COLAPSÁVEL */
.code-toggle {
    margin-top: 14px; border: 1px solid #e2e8f0; border-radius: 10px; overflow: hidden;
}
.code-toggle-btn {
    width: 100%; padding: 10px 16px; background: #f8fafc;
    border: none; text-align: left; cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12px; font-weight: 600; color: #64748b;
    display: flex; align-items: center; justify-content: space-between;
    transition: background .2s;
}
.code-toggle-btn:hover { background: #f1f5f9; }
.code-toggle-btn .arrow { transition: transform .2s; }
.code-toggle-btn.open .arrow { transform: rotate(180deg); }
.code-toggle-body { display: none; }
.code-toggle-body.open { display: block; }
.code-toggle-body pre {
    margin: 0; padding: 16px; background: #0f172a;
    color: #e2e8f0; font-family: 'JetBrains Mono', monospace;
    font-size: 12px; line-height: 1.6; overflow-x: auto;
    white-space: pre;
}
.code-toggle-body pre .kw  { color: #93c5fd; }
.code-toggle-body pre .cm  { color: #64748b; font-style: italic; }

/* MERMAID */
.doc-card-body .mermaid {
    background: #fff; display: flex; justify-content: center;
    padding: 12px; border-radius: 10px; border: 1px solid #f1f5f9; min-height: 80px;
}
.doc-card-body svg { background: #fff !important; max-width: 100%; height: auto; }
.doc-card-body svg text { fill: #1e293b !important; font-family: 'Plus Jakarta Sans',sans-serif !important; font-size:13px !important; }
.doc-card-body svg .actor { fill: #dbeafe !important; stroke: #3b82f6 !important; }
.doc-card-body svg .actor > text { fill: #1e293b !important; }
.doc-card-body svg .messageText { fill: #1e293b !important; stroke: none !important; }
.doc-card-body svg .labelBox { fill: #fff !important; stroke: #94a3b8 !important; }
.doc-card-body svg .labelText { fill: #1e293b !important; }
.doc-card-body svg .loopText { fill: #1e293b !important; }
.doc-card-body svg foreignObject div,
.doc-card-body svg foreignObject span,
.doc-card-body svg foreignObject p {
    color: #1e293b !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    font-size: 13px !important; background: transparent !important;
}

/* BADGE */
.seq-badge {
    display: inline-block; padding: 3px 10px; border-radius: 100px;
    font-size: 11px; font-weight: 700; margin-left: auto;
    background: rgba(201,162,39,0.15); color: #8a6d0b;
}
</style>

<?php
/* ═══════════════════════════════════════════════
   HELPER: renderiza um bloco diagrama
   $icon, $titulo, $desc, $img, $code
═══════════════════════════════════════════════ */
function diagrama($icon, $titulo, $desc, $img, $code, $badge = '') {
    $slug = 'toggle_' . md5($titulo);
    ?>
    <div class="doc-card">
        <div class="doc-card-header">
            <div class="doc-card-icon"><?= $icon ?></div>
            <div>
                <h3><?= $titulo ?></h3>
                <p><?= $desc ?></p>
            </div>
            <?php if($badge): ?>
                <span class="seq-badge" style="margin-left:auto"><?= $badge ?></span>
            <?php endif; ?>
        </div>
        <div class="doc-card-body">

            <?php
            $caminho = BASE_URL . "/public/img/diagramas/" . $img;
            $local   = $_SERVER['DOCUMENT_ROOT'] . $caminho;
            if(file_exists($local)): ?>
                <img src="<?= $caminho ?>" class="diagrama-img" alt="<?= $titulo ?>">
            <?php else: ?>
                <div class="diagrama-img-placeholder">
                    <span>🖼️</span>
                    Exporte este diagrama do <strong>mermaid.live</strong> e salve como<br>
                    <code style="background:#e2e8f0;padding:2px 8px;border-radius:4px;font-size:12px"><?= $img ?></code><br>
                    em <code style="background:#e2e8f0;padding:2px 8px;border-radius:4px;font-size:12px"><?= BASE_URL ?>/public/img/diagramas/</code>
                </div>
            <?php endif; ?>

            <div class="code-toggle">
                <button class="code-toggle-btn" onclick="toggleCode('<?= $slug ?>', this)">
                    <span>📋 Ver código Mermaid</span>
                    <span class="arrow">▼</span>
                </button>
                <div class="code-toggle-body" id="<?= $slug ?>">
                    <pre><?= htmlspecialchars($code) ?></pre>
                </div>
            </div>

        </div>
    </div>
    <?php
}
?>

<div class="doc-wrap">

    <a href="?url=admin/dashboard" class="doc-back">← Voltar ao Painel Admin</a>

    <!-- HEADER -->
    <div class="doc-header">
        <div>
            <h1>📐 Documentação Técnica — Scambus</h1>
            <p>Diagramas UML · Arquitetura MVC · Engenharia de Sistemas · 2025</p>
        </div>
        <span class="doc-version">v1.0 · 2025</span>
    </div>

    <!-- RESUMO -->
    <div class="info-grid">
        <div class="info-box"><div class="info-box-icon">🗂️</div><div class="info-box-label">Controladores</div><div class="info-box-value">9</div></div>
        <div class="info-box"><div class="info-box-icon">🧩</div><div class="info-box-label">Modelos</div><div class="info-box-value">9</div></div>
        <div class="info-box"><div class="info-box-icon">🖥️</div><div class="info-box-label">Views</div><div class="info-box-value">20+</div></div>
        <div class="info-box"><div class="info-box-icon">👥</div><div class="info-box-label">Tipos de Usuário</div><div class="info-box-value">2</div></div>
        <div class="info-box"><div class="info-box-icon">💰</div><div class="info-box-label">Moeda Interna</div><div class="info-box-value">Scoins</div></div>
    </div>

    <!-- TABS -->
    <div class="doc-tabs">
        <button class="doc-tab active"  onclick="showTab('visao',this)">📊 Visão Geral</button>
        <button class="doc-tab" onclick="showTab('classes',this)">📦 Classes</button>
        <button class="doc-tab" onclick="showTab('casouso',this)">🎯 Casos de Uso</button>
        <button class="doc-tab" onclick="showTab('sequencias',this)">🔄 Sequências</button>
        <button class="doc-tab" onclick="showTab('er',this)">🗄️ Banco de Dados</button>
        <button class="doc-tab" onclick="showTab('mvc',this)">🏗️ Arquitetura MVC</button>
        <button class="doc-tab" onclick="showTab('fluxo',this)">🌊 Fluxo do Sistema</button>
    </div>

    <!-- ══ VISÃO GERAL ══ -->
    <div class="doc-section active" id="tab-visao">

        <?php diagrama('📊', 'Fluxo Geral do Sistema', 'Jornada completa do usuário no Scambus', 'fluxo-geral.png',
'flowchart TD
    START(["Acessa o Scambus"])
    START --> AUTH{"Esta logado?"}
    AUTH -- Nao --> LOGIN["Tela de Login"]
    LOGIN --> NOVO{"Tem conta?"}
    NOVO -- Nao --> CAD["Cadastro\nnome, email, telefone, senha"]
    CAD --> LOGIN
    NOVO -- Sim --> FORM["Preenche credenciais"]
    FORM --> VALIDA{"Credenciais validas?"}
    VALIDA -- Nao --> ERRO["Exibe erro"]
    ERRO --> LOGIN
    VALIDA -- Sim --> TIPO
    AUTH -- Sim --> TIPO{"Tipo de usuario?"}
    TIPO -- Admin --> ADMIN["Painel Admin"]
    TIPO -- Usuario --> DASH["Dashboard\nSaldo, Trocas, Servicos, Avaliacao"]
    ADMIN --> GA{"Acao admin"}
    GA --> GU["Gerenciar Usuarios\nbloq, desbloq, excluir"]
    GA --> GS["Gerenciar Servicos"]
    GA --> DOC["Ver Documentacao"]
    DASH --> ACA{"Acao"}
    ACA --> CRIAR["Criar Servico"]
    ACA --> EXPLOR["Explorar Servicos"]
    ACA --> NOTIF["Ver Notificacoes"]
    ACA --> CART["Carteira Scoins"]
    EXPLOR --> VER["Ver Servico"]
    VER --> PROP["Propor Troca"]
    PROP --> CHAT["Chat em Tempo Real"]
    CHAT --> REAL["Servico Realizado"]
    REAL --> CONF["Ambos Confirmam"]
    CONF --> FIN["Troca FINALIZADA"]
    FIN --> SC["+Scoins para cada usuario"]
    FIN --> AV["Avaliacao Mutua"]
    AV --> REP["Reputacao Atualizada"]'); ?>

    </div>

    <!-- ══ CLASSES ══ -->
    <div class="doc-section" id="tab-classes">

        <?php diagrama('📦', 'Diagrama de Classes', 'Modelos, atributos, métodos e relacionamentos', 'classes.png',
'classDiagram
    class Usuario {
        +int id
        +string nome
        +string email
        +string telefone
        +string senha
        +string foto
        +float saldo_scoins
        +string status
        +string tipo
        +buscarPorEmail(email)
        +criar(nome, email, telefone, senha)
        +buscarPerfil(id)
        +listarTodos()
        +bloquear(id)
        +desbloquear(id)
        +excluir(id)
        +calcularNivel(trocas)
    }
    class Servico {
        +int id
        +int usuario_id
        +string titulo
        +string descricao
        +string aceita_troca
        +string categoria
        +string caminho_foto
        +string status
        +criar(dados)
        +listar()
        +buscarPorId(id)
        +excluir(id)
    }
    class Troca {
        +int id
        +int usuario_origem_id
        +int usuario_destino_id
        +int servico_id
        +string status
        +propor(origem, destino, servico)
        +confirmar(id)
        +finalizar(id)
        +contarTrocas()
    }
    class Avaliacao {
        +int id
        +int avaliador_id
        +int avaliado_id
        +int troca_id
        +float nota
        +string comentario
        +criar(dados)
        +mediaUsuario(id)
    }
    class Mensagem {
        +int id
        +int troca_id
        +int usuario_id
        +string conteudo
        +datetime criado_em
        +enviar(troca_id, usuario_id, texto)
        +buscarPorTroca(troca_id)
    }
    class Notificacao {
        +int id
        +int usuario_id
        +string mensagem
        +bool lida
        +criar(usuario_id, mensagem)
        +marcarLida(id)
        +contarNaoLidas(id)
    }
    class Carteira {
        +int usuario_id
        +float saldo
        +buscarSaldo(usuario_id)
        +creditar(usuario_id, valor)
        +debitar(usuario_id, valor)
    }
    class Scoin {
        +int id
        +int usuario_id
        +float valor
        +string tipo
        +registrar(usuario_id, valor, tipo)
        +buscarPorUsuario(id)
    }
    Usuario "1" --> "0..*" Servico : cria
    Usuario "1" --> "0..*" Troca : participa
    Usuario "1" --> "0..*" Avaliacao : avalia
    Usuario "1" --> "0..*" Notificacao : recebe
    Usuario "1" --> "1" Carteira : possui
    Troca "1" --> "0..*" Mensagem : contém
    Troca "1" --> "0..2" Avaliacao : gera
    Servico "1" --> "0..*" Troca : origina
    Carteira "1" --> "0..*" Scoin : registra'); ?>

    </div>

    <!-- ══ CASOS DE USO ══ -->
    <div class="doc-section" id="tab-casouso">

        <?php diagrama('🎯', 'Casos de Uso — Usuário Comum', 'Ações disponíveis para usuários cadastrados', 'caso-uso-usuario.png',
'flowchart LR
    U(["Usuário"])
    subgraph S ["Sistema Scambus"]
        direction TB
        C1["Cadastrar-se"]
        C2["Fazer login"]
        C3["Criar servico"]
        C4["Explorar servicos"]
        C5["Favoritar servico"]
        C6["Propor troca"]
        C7["Chat em tempo real"]
        C8["Confirmar servico"]
        C9["Avaliar usuario"]
        C10["Ver dashboard"]
        C11["Editar perfil"]
        C12["Ver notificacoes"]
        C13["Ver carteira Scoins"]
    end
    U --> C1
    U --> C2
    U --> C3
    U --> C4
    U --> C5
    U --> C6
    C6 --> C7
    C7 --> C8
    C8 --> C9
    C8 --> C13
    U --> C10
    U --> C11
    U --> C12'); ?>

        <?php diagrama('🛡️', 'Casos de Uso — Administrador', 'Ações exclusivas do painel administrativo', 'caso-uso-admin.png',
'flowchart LR
    A(["Administrador"])
    subgraph P ["Painel Administrativo"]
        direction TB
        A1["Ver dashboard admin"]
        A2["Listar usuarios"]
        A3["Bloquear usuario"]
        A4["Desbloquear usuario"]
        A5["Excluir usuario"]
        A6["Listar servicos"]
        A7["Excluir servico"]
        A8["Ver estatisticas"]
        A9["Ver documentacao UML"]
    end
    A --> A1
    A --> A2
    A2 --> A3
    A2 --> A4
    A2 --> A5
    A --> A6
    A6 --> A7
    A1 --> A8
    A --> A9'); ?>

    </div>

    <!-- ══ SEQUÊNCIAS ══ -->
    <div class="doc-section" id="tab-sequencias">

        <?php diagrama('1️⃣', 'Sequência — Cadastro de Usuário', 'Validação de email + INSERT no banco', 'seq-cadastro.png',
'sequenceDiagram
    actor U as Usuário
    participant V as View cadastro.php
    participant C as ControladorAutenticacao
    participant M as Model Usuario
    participant DB as Banco MySQL

    U->>V: Preenche nome, email, telefone, senha
    V->>C: POST /autenticacao/cadastrar
    C->>M: buscarPorEmail(email)
    M->>DB: SELECT * FROM usuarios WHERE email = ?
    DB-->>M: Retorna resultado

    alt Email já cadastrado
        M-->>C: Usuário encontrado
        C-->>V: Erro: email já em uso
        V-->>U: Exibe mensagem de erro
    else Email disponível
        M-->>C: Nenhum registro
        C->>M: criar(nome, email, telefone, senha)
        M->>M: password_hash(senha)
        M->>DB: INSERT INTO usuarios (nome, email, telefone, senha) VALUES (...)
        DB-->>M: ID gerado
        M-->>C: true
        C-->>U: Redireciona para login
    end', 'SEQ-01'); ?>

        <?php diagrama('2️⃣', 'Sequência — Login', 'Autenticação, sessão e redirecionamento por tipo', 'seq-login.png',
'sequenceDiagram
    actor U as Usuário
    participant V as View login.php
    participant C as ControladorAutenticacao
    participant M as Model Usuario
    participant DB as Banco MySQL
    participant S as Sessao PHP

    U->>V: Preenche email e senha
    V->>C: POST /autenticacao/entrar
    C->>M: buscarPorEmail(email)
    M->>DB: SELECT * FROM usuarios WHERE email = ?
    DB-->>M: Retorna registro
    M-->>C: Dados do usuário

    alt Usuário não encontrado
        C-->>V: Erro: email não cadastrado
        V-->>U: Exibe mensagem de erro
    else Senha incorreta
        C-->>V: Erro: senha incorreta
        V-->>U: Exibe mensagem de erro
    else Conta bloqueada
        C-->>V: Conta bloqueada pelo administrador
        V-->>U: Exibe aviso de bloqueio
    else Login válido
        C->>S: $_SESSION[usuario_id] = id
        C->>S: $_SESSION[usuario_nome] = nome
        C->>S: $_SESSION[usuario_tipo] = tipo
        alt tipo = admin
            C-->>U: Redireciona para admin/dashboard
        else tipo = usuario
            C-->>U: Redireciona para usuario/dashboard
        end
    end', 'SEQ-02'); ?>

        <?php diagrama('3️⃣', 'Sequência — Criar Serviço', 'Upload de foto + INSERT no banco', 'seq-criar-servico.png',
'sequenceDiagram
    actor U as Usuário
    participant V as View criar.php
    participant C as ControladorServico
    participant M as Model Servico
    participant DB as Banco MySQL
    participant FS as Sistema de Arquivos

    U->>V: Preenche titulo, descricao, aceita_troca, categoria
    U->>V: Seleciona foto
    V->>C: POST /servico/criar
    C->>C: Verifica sessão ativa
    C->>FS: move_uploaded_file(foto, /uploads/servicos/)
    FS-->>C: Caminho da imagem salva
    C->>M: criar(usuario_id, titulo, descricao, aceita_troca, categoria, caminho_foto)
    M->>DB: INSERT INTO servicos (usuario_id, titulo, descricao, aceita_troca, categoria, caminho_foto, status) VALUES (...)
    DB-->>M: ID do servico criado
    M-->>C: true
    C-->>U: Redireciona para servico/ver/ID', 'SEQ-03'); ?>

        <?php diagrama('4️⃣', 'Sequência — Propor Troca', 'Proposta + notificação + aceite pelo destino', 'seq-propor-troca.png',
'sequenceDiagram
    actor UA as Usuário A
    actor UB as Usuário B
    participant C as ControladorTroca
    participant MT as Model Troca
    participant MN as Model Notificacao
    participant DB as Banco MySQL

    UA->>C: POST /troca/propor (origem, destino, servico)
    C->>C: Verifica sessão de UA
    C->>MT: propor(usuario_origem_id, usuario_destino_id, servico_id)
    MT->>DB: INSERT INTO trocas (usuario_origem_id, usuario_destino_id, servico_id, status) VALUES (..., PENDENTE)
    DB-->>MT: ID da troca
    MT-->>C: troca_id
    C->>MN: criar(UB, "Você recebeu uma proposta de troca!")
    MN->>DB: INSERT INTO notificacoes (usuario_id, mensagem, lida) VALUES (UB, msg, 0)
    DB-->>MN: OK
    C-->>UA: Redireciona para troca/ver/ID

    Note over UB: UB vê notificação
    UB->>C: GET /troca/aceitar/ID
    C->>MT: confirmar(troca_id)
    MT->>DB: UPDATE trocas SET status = ACEITA WHERE id = ?
    DB-->>MT: OK
    C->>MN: criar(UA, "Sua proposta foi aceita!")
    MN->>DB: INSERT INTO notificacoes (usuario_id, mensagem, lida) VALUES (UA, msg, 0)
    DB-->>MN: OK
    C-->>UB: Redireciona para chat da troca', 'SEQ-04'); ?>

        <?php diagrama('5️⃣', 'Sequência — Chat em Tempo Real', 'Envio via AJAX + polling de novas mensagens', 'seq-chat.png',
'sequenceDiagram
    actor UA as Usuário A
    actor UB as Usuário B
    participant C as ControladorChat
    participant M as Model Mensagem
    participant DB as Banco MySQL

    UA->>C: GET /troca/chat/troca_id
    C->>M: buscarPorTroca(troca_id)
    M->>DB: SELECT * FROM mensagens WHERE troca_id = ? ORDER BY criado_em ASC
    DB-->>M: Historico de mensagens
    M-->>C: Lista de mensagens
    C-->>UA: Renderiza chat com historico

    UA->>C: POST AJAX /chat/enviar (troca_id, conteudo)
    C->>M: enviar(troca_id, usuario_id, conteudo)
    M->>DB: INSERT INTO mensagens (troca_id, usuario_id, conteudo) VALUES (...)
    DB-->>M: ID da mensagem
    M-->>C: OK
    C-->>UA: JSON com mensagem salva

    Note over UB: Polling AJAX a cada 2 segundos
    UB->>C: GET AJAX /chat/buscar/troca_id/ultimo_id
    C->>M: buscarNovas(troca_id, ultimo_id)
    M->>DB: SELECT * FROM mensagens WHERE troca_id = ? AND id > ?
    DB-->>M: Novas mensagens
    M-->>C: Lista
    C-->>UB: JSON com novas mensagens
    UB->>UB: Renderiza na tela', 'SEQ-05'); ?>

        <?php diagrama('6️⃣', 'Sequência — Confirmar Serviço + Scoins', 'Dupla confirmação + crédito de Scoins para ambos', 'seq-confirmar.png',
'sequenceDiagram
    actor UA as Usuário A
    actor UB as Usuário B
    participant C as ControladorTroca
    participant MT as Model Troca
    participant MS as Model Scoin
    participant MN as Model Notificacao
    participant DB as Banco MySQL

    UA->>C: POST /troca/confirmar/troca_id
    C->>MT: marcarConfirmacaoA(troca_id)
    MT->>DB: UPDATE trocas SET confirmou_origem = 1 WHERE id = ?
    DB-->>MT: OK
    C-->>UA: Aguardando confirmação de UB

    UB->>C: POST /troca/confirmar/troca_id
    C->>MT: marcarConfirmacaoB(troca_id)
    MT->>DB: UPDATE trocas SET confirmou_destino = 1 WHERE id = ?
    DB-->>MT: OK

    C->>MT: finalizar(troca_id)
    MT->>DB: UPDATE trocas SET status = FINALIZADA WHERE id = ?
    DB-->>MT: OK

    C->>MS: registrar(UA, +10, CREDITO, "Troca finalizada")
    MS->>DB: INSERT INTO transacoes_scoin (usuario_id, valor, tipo) VALUES (UA, 10, CREDITO)
    DB-->>MS: OK
    C->>DB: UPDATE usuarios SET saldo_scoins = saldo_scoins + 10 WHERE id = UA

    C->>MS: registrar(UB, +10, CREDITO, "Troca finalizada")
    MS->>DB: INSERT INTO transacoes_scoin (usuario_id, valor, tipo) VALUES (UB, 10, CREDITO)
    DB-->>MS: OK
    C->>DB: UPDATE usuarios SET saldo_scoins = saldo_scoins + 10 WHERE id = UB

    C->>MN: criar(UA, "+10 Scoins recebidos!")
    MN->>DB: INSERT INTO notificacoes ...
    C->>MN: criar(UB, "+10 Scoins recebidos!")
    MN->>DB: INSERT INTO notificacoes ...

    C-->>UA: Redireciona para avaliar
    C-->>UB: Redireciona para avaliar', 'SEQ-06'); ?>

        <?php diagrama('7️⃣', 'Sequência — Avaliar Usuário', 'INSERT na avaliação + recálculo da média', 'seq-avaliar.png',
'sequenceDiagram
    actor UA as Usuário A
    participant V as View avaliar.php
    participant C as ControladorTroca
    participant MA as Model Avaliacao
    participant DB as Banco MySQL

    UA->>V: Acessa tela de avaliação
    V->>C: GET /troca/avaliar/troca_id
    C->>C: Verifica se troca está FINALIZADA
    C-->>V: Renderiza formulário (nota 1-5 + comentário)

    UA->>V: Seleciona nota e escreve comentário
    V->>C: POST /troca/avaliar
    C->>MA: criar(avaliador_id, avaliado_id, troca_id, nota, comentario)
    MA->>DB: INSERT INTO avaliacoes (avaliador_id, avaliado_id, troca_id, nota, comentario) VALUES (...)
    DB-->>MA: ID da avaliação
    MA-->>C: OK

    C->>MA: mediaUsuario(avaliado_id)
    MA->>DB: SELECT AVG(nota) FROM avaliacoes WHERE avaliado_id = ?
    DB-->>MA: Média atualizada
    MA-->>C: Nova média

    C-->>UA: Redireciona para perfil do avaliado', 'SEQ-07'); ?>

        <?php diagrama('8️⃣', 'Sequência — Bloquear / Excluir Usuário (Admin)', 'Operações admin com transaction no banco', 'seq-admin-usuario.png',
'sequenceDiagram
    actor ADM as Administrador
    participant V as View usuarios.php
    participant C as ControladorAdmin
    participant M as Model Usuario
    participant DB as Banco MySQL

    ADM->>V: Acessa painel de usuários
    V->>C: GET /admin/usuarios
    C->>M: listarTodos()
    M->>DB: SELECT id, nome, email, status FROM usuarios ORDER BY id DESC
    DB-->>M: Lista de usuários
    M-->>C: Usuários
    C-->>V: Renderiza tabela

    alt Admin clica em Bloquear
        ADM->>C: GET /admin/bloquearUsuario/id
        C->>C: Verifica se não é a própria conta
        C->>M: bloquear(id)
        M->>DB: UPDATE usuarios SET status = BLOQUEADO WHERE id = ?
        DB-->>M: OK
        C-->>ADM: Lista atualizada
    else Admin clica em Desbloquear
        ADM->>C: GET /admin/desbloquearUsuario/id
        C->>M: desbloquear(id)
        M->>DB: UPDATE usuarios SET status = ATIVO WHERE id = ?
        DB-->>M: OK
        C-->>ADM: Lista atualizada
    else Admin clica em Excluir
        ADM->>C: GET /admin/excluirUsuario/id
        C->>C: Verifica se não é a própria conta
        C->>M: excluir(id)
        M->>DB: BEGIN TRANSACTION
        M->>DB: DELETE FROM servicos WHERE usuario_id = ?
        M->>DB: DELETE FROM trocas WHERE usuario_origem_id = ? OR usuario_destino_id = ?
        M->>DB: DELETE FROM avaliacoes WHERE avaliado_id = ? OR avaliador_id = ?
        M->>DB: DELETE FROM usuarios WHERE id = ?
        M->>DB: COMMIT
        DB-->>M: OK
        M-->>C: true
        C-->>ADM: Lista atualizada
    end', 'SEQ-08'); ?>

    </div>

    <!-- ══ ER ══ -->
    <div class="doc-section" id="tab-er">

        <?php diagrama('🗄️', 'Diagrama ER — Banco de Dados', '8 entidades com atributos e chaves estrangeiras', 'er.png',
'erDiagram
    USUARIOS { int id PK
               string nome
               string email
               string telefone
               string senha
               string foto
               float saldo_scoins
               string status
               string tipo
               datetime criado_em }
    SERVICOS { int id PK
               int usuario_id FK
               string titulo
               string descricao
               string aceita_troca
               string categoria
               string caminho_foto
               string status
               datetime criado_em }
    TROCAS   { int id PK
               int usuario_origem_id FK
               int usuario_destino_id FK
               int servico_id FK
               string status
               datetime criado_em }
    MENSAGENS { int id PK
                int troca_id FK
                int usuario_id FK
                string conteudo
                datetime criado_em }
    AVALIACOES { int id PK
                 int avaliador_id FK
                 int avaliado_id FK
                 int troca_id FK
                 float nota
                 string comentario
                 datetime criado_em }
    NOTIFICACOES { int id PK
                   int usuario_id FK
                   string mensagem
                   bool lida
                   datetime criado_em }
    TRANSACOES_SCOIN { int id PK
                       int usuario_id FK
                       float valor
                       string tipo
                       string descricao
                       datetime criado_em }
    FAVORITOS { int id PK
                int usuario_id FK
                int servico_id FK
                datetime criado_em }
    USUARIOS    ||--o{ SERVICOS         : "cria"
    USUARIOS    ||--o{ TROCAS           : "origem"
    USUARIOS    ||--o{ TROCAS           : "destino"
    USUARIOS    ||--o{ AVALIACOES       : "avalia"
    USUARIOS    ||--o{ NOTIFICACOES     : "recebe"
    USUARIOS    ||--o{ TRANSACOES_SCOIN : "possui"
    USUARIOS    ||--o{ FAVORITOS        : "salva"
    SERVICOS    ||--o{ TROCAS           : "origina"
    SERVICOS    ||--o{ FAVORITOS        : "favoritado"
    TROCAS      ||--o{ MENSAGENS        : "contém"
    TROCAS      ||--o{ AVALIACOES       : "gera"'); ?>

    </div>

    <!-- ══ MVC ══ -->
    <div class="doc-section" id="tab-mvc">

        <?php diagrama('🏗️', 'Arquitetura MVC — Fluxo de Requisição', 'Do HTTP até o HTML renderizado', 'mvc.png',
'flowchart TD
    REQ(["Requisicao HTTP ?url=controlador/metodo"])
    REQ --> IDX["public/index.php"]
    IDX --> ROT["nucleo/Roteador.php\nAnalisa a URL"]
    ROT --> SES["nucleo/Sessao.php\nVerifica autenticacao"]
    SES --> CTR
    subgraph CTR ["Controladores"]
        CA["ControladorAutenticacao"]
        CH["ControladorHome"]
        CS["ControladorServico"]
        CT["ControladorTroca"]
        CU["ControladorUsuario"]
        CAD["ControladorAdmin"]
        CHAT["ControladorChat"]
        CN["ControladorNotificacao"]
        CW["ControladorCarteira"]
    end
    CTR --> MOD
    subgraph MOD ["Modelos"]
        MU["Usuario"] MS["Servico"] MT["Troca"]
        MM["Mensagem"] MA["Avaliacao"] MN["Notificacao"]
        MSC["Scoin"] MC["Carteira"]
    end
    MOD --> DB[("MySQL")]
    MOD --> VIE
    subgraph VIE ["Views"]
        VL["layout/"] VA["admin/"] VS["servicos/"]
        VT["trocas/"] VU["usuarios/"]
    end
    VIE --> RES(["HTML ao usuario"])'); ?>

    </div>

    <!-- ══ FLUXO ══ -->
    <div class="doc-section" id="tab-fluxo">

        <?php diagrama('🌊', 'Fluxo Geral do Sistema', 'Jornada completa do usuário no Scambus', 'fluxo-geral.png',
'flowchart TD
    START(["Acessa o Scambus"])
    START --> AUTH{"Esta logado?"}
    AUTH -- Nao --> LOGIN["Tela de Login"]
    LOGIN --> NOVO{"Tem conta?"}
    NOVO -- Nao --> CAD["Cadastro"]
    CAD --> LOGIN
    NOVO -- Sim --> FORM["Preenche credenciais"]
    FORM --> VALIDA{"Credenciais validas?"}
    VALIDA -- Nao --> ERRO["Exibe erro"]
    ERRO --> LOGIN
    VALIDA -- Sim --> TIPO
    AUTH -- Sim --> TIPO{"Tipo?"}
    TIPO -- Admin --> ADMIN["Painel Admin"]
    TIPO -- Usuario --> DASH["Dashboard"]
    DASH --> ACA{"Acao"}
    ACA --> CRIAR["Criar Servico"]
    ACA --> EXPLOR["Explorar Servicos"]
    EXPLOR --> VER["Ver Servico"]
    VER --> PROP["Propor Troca"]
    PROP --> CHAT["Chat"]
    CHAT --> REAL["Servico Realizado"]
    REAL --> CONF["Ambos Confirmam"]
    CONF --> FIN["Troca FINALIZADA"]
    FIN --> SC["+Scoins"]
    FIN --> AV["Avaliacao Mutua"]
    AV --> REP["Reputacao Atualizada"]'); ?>

    </div>

</div>

<script>
function showTab(name, btn) {
    document.querySelectorAll('.doc-section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.doc-tab').forEach(t => t.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

function toggleCode(id, btn) {
    const body = document.getElementById(id);
    body.classList.toggle('open');
    btn.classList.toggle('open');
}
</script>