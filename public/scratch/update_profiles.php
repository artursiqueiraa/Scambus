<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';

$b = new Banco();
$c = $b->conectar();

$perfis = [
    1 => [
        'nome' => 'João Tech Master',
        'whatsapp' => '(11) 98888-7777',
        'biografia' => 'Desenvolvedor Full Stack com mais de 10 anos de mercado. Especialista em transformar ideias complexas em código limpo e escalável. Mentor de tecnologia nas horas vagas.',
        'especialidade' => 'Arquitetura de Sistemas & Cloud',
        'nivel' => 'Diamante',
        'scoins' => 500
    ],
    2 => [
        'nome' => 'Maria Marketing & Hardware',
        'whatsapp' => '(21) 97777-6666',
        'biografia' => 'Unindo o mundo digital ao físico. Ofereço consultoria em tráfego pago e também realizo manutenção de hardware de alta performance.',
        'especialidade' => 'Marketing Estratégico & Hardware',
        'nivel' => 'Ouro',
        'scoins' => 350
    ],
    4 => [
        'nome' => 'Carlos Poliglota & Músico',
        'whatsapp' => '(31) 96666-5555',
        'biografia' => 'Acredito que a comunicação é a base de tudo. Ensino inglês para negócios e violão popular para quem busca um novo hobby ou profissão.',
        'especialidade' => 'Idiomas & Música',
        'nivel' => 'Prata',
        'scoins' => 200
    ],
    19 => [
        'nome' => 'Ricardo Design & Saúde',
        'whatsapp' => '(41) 95555-4444',
        'biografia' => 'Arquiteto focado em design de interiores sustentável. Também sou entusiasta da vida saudável e ajudo pessoas com planos de treino eficientes.',
        'especialidade' => 'Arquiteto & Consultor Fitness',
        'nivel' => 'Ouro',
        'scoins' => 420
    ],
    21 => [
        'nome' => 'Leanderson Consultoria Acadêmica',
        'whatsapp' => '(51) 94444-3333',
        'biografia' => 'Especialista em metodologia científica. Meu objetivo é tirar o peso da burocracia acadêmica das costas dos estudantes com revisões impecáveis.',
        'especialidade' => 'Metodologia Científica & ABNT',
        'nivel' => 'Prata',
        'scoins' => 180
    ]
];

echo "Atualizando perfis selecionados...\n";

$sql = "UPDATE usuarios SET 
        nome = :nome, 
        whatsapp = :whatsapp, 
        biografia = :biografia, 
        especialidade = :especialidade, 
        nivel = :nivel, 
        scoins = :scoins 
        WHERE id = :id";

$stmt = $c->prepare($sql);

foreach ($perfis as $id => $dados) {
    $dados['id'] = $id;
    $stmt->execute($dados);
    echo "Perfil do usuário ID {$id} atualizado com sucesso!\n";
}

echo "Finalizado! Todos os perfis estão completos.\n";
