<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';

$b = new Banco();
$c = $b->conectar();

try {
    // 1. Limpeza
    echo "Limpando tabelas de serviços...\n";
    $c->exec("DELETE FROM servico_fotos");
    $c->exec("DELETE FROM favoritos");
    $c->exec("DELETE FROM trocas");
    $c->exec("DELETE FROM servicos");

    // 2. Novos Dados (Trocas Justas)
    $novos = [
        [
            'titulo' => 'Desenvolvimento de Landing Page Premium',
            'descricao_oferece' => 'Criação de uma landing page moderna e responsiva utilizando as melhores práticas de UI/UX para converter seu negócio.',
            'descricao_aceita' => 'Consultoria jurídica, Aulas de Idiomas ou Crédito em SCoins.',
            'categoria_id' => 1,
            'usuario_id' => 1,
            'valor_scoins' => 100
        ],
        [
            'titulo' => 'Consultoria Estratégica de Marketing Digital',
            'descricao_oferece' => 'Análise de presença online, definição de persona e plano de ação para redes sociais e tráfego pago.',
            'descricao_aceita' => 'Design de logotipo, Edição de vídeo ou SCoins.',
            'categoria_id' => 1,
            'usuario_id' => 2,
            'valor_scoins' => 80
        ],
        [
            'titulo' => 'Aulas de Inglês para Negócios',
            'descricao_oferece' => 'Foco em conversação, vocabulário corporativo, apresentações e reuniões internacionais. Nível intermediário/avançado.',
            'descricao_aceita' => 'Aulas de violão, Manutenção de PC ou SCoins.',
            'categoria_id' => 6,
            'usuario_id' => 4,
            'valor_scoins' => 50
        ],
        [
            'titulo' => 'Projeto de Design de Interiores (1 Ambiente)',
            'descricao_oferece' => 'Planejamento completo de um cômodo (sala, quarto ou office) com planta baixa, escolha de cores e mobiliário.',
            'descricao_aceita' => 'Pintura residencial, Instalação elétrica ou SCoins.',
            'categoria_id' => 3,
            'usuario_id' => 19,
            'valor_scoins' => 120
        ],
        [
            'titulo' => 'Revisão Técnica e ABNT de Trabalhos Acadêmicos',
            'descricao_oferece' => 'Correção gramatical, ortográfica e adequação completa às normas da ABNT para TCCs e artigos científicos.',
            'descricao_aceita' => 'Digitação de dados, Pesquisa bibliográfica ou SCoins.',
            'categoria_id' => 2,
            'usuario_id' => 21,
            'valor_scoins' => 45
        ],
        [
            'titulo' => 'Mentoria para Pitch Deck de Startups',
            'descricao_oferece' => 'Estruturação de narrativa e design de slides para investidores. Ajudo você a contar a história do seu negócio.',
            'descricao_aceita' => 'Modelagem 3D, Análise de dados ou SCoins.',
            'categoria_id' => 1,
            'usuario_id' => 1,
            'valor_scoins' => 150
        ],
        [
            'titulo' => 'Manutenção Preventiva de Notebook (Hardware)',
            'descricao_oferece' => 'Limpeza interna, troca de pasta térmica e check-up de componentes para evitar superaquecimento.',
            'descricao_aceita' => 'Formatação de SO, Backup em nuvem ou SCoins.',
            'categoria_id' => 4,
            'usuario_id' => 2,
            'valor_scoins' => 60
        ],
        [
            'titulo' => 'Aula Particular de Violão (Iniciantes)',
            'descricao_oferece' => 'Aprenda os primeiros acordes, ritmos e leitura de cifras. Aula prática e dinâmica para todas as idades.',
            'descricao_aceita' => 'Aulas de canto, Leitura de partitura ou SCoins.',
            'categoria_id' => 6,
            'usuario_id' => 4,
            'valor_scoins' => 40
        ],
        [
            'titulo' => 'Planejamento Nutricional e Treino Individualizado',
            'descricao_oferece' => 'Guia completo de alimentação balanceada e rotina de exercícios focada em seus objetivos de saúde e estética.',
            'descricao_aceita' => 'Massagem relaxante (Spa), Aulas de Yoga ou SCoins.',
            'categoria_id' => 5,
            'usuario_id' => 19,
            'valor_scoins' => 75
        ],
        [
            'titulo' => 'Tradução Técnica Inglês/Português (Artigos)',
            'descricao_oferece' => 'Tradução profissional de textos técnicos, manuais ou artigos científicos com precisão terminológica.',
            'descricao_aceita' => 'Redação de conteúdo, SEO ou SCoins.',
            'categoria_id' => 2,
            'usuario_id' => 21,
            'valor_scoins' => 90
        ]
    ];

    echo "Inserindo novos serviços...\n";
    $sql = "INSERT INTO servicos (titulo, descricao_oferece, descricao_aceita, categoria_id, usuario_id, valor_scoins, status) 
            VALUES (:titulo, :descricao_oferece, :descricao_aceita, :categoria_id, :usuario_id, :valor_scoins, 'ativo')";
    $stmt = $c->prepare($sql);

    foreach ($novos as $s) {
        $stmt->execute($s);
    }

    echo "Sucesso! " . count($novos) . " serviços de 'Troca Justa' foram cadastrados.\n";

} catch (PDOException $e) {
    die("Erro no seeding: " . $e->getMessage());
}
