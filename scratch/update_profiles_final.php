<?php
$_SERVER['HTTP_HOST'] = 'localhost';
require 'configuracao/banco.php';

$b = new Banco();
$c = $b->conectar();

$perfis = [
    1 => [
        'nome' => 'João Tech Master',
        'telefone' => '(11) 98888-7777',
        'bio' => 'Desenvolvedor Full Stack com mais de 10 anos de mercado. Especialista em transformar ideias complexas em código limpo e escalável. Mentor de tecnologia nas horas vagas.',
        'formacao' => 'Engenharia de Software & Arquitetura Cloud',
        'cidade' => 'São Paulo',
        'estado' => 'SP',
        'idade' => 32,
        'nivel' => 'Ouro'
    ],
    2 => [
        'nome' => 'Maria Marketing & Hardware',
        'telefone' => '(21) 97777-6666',
        'bio' => 'Unindo o mundo digital ao físico. Ofereço consultoria em tráfego pago e também realizo manutenção de hardware de alta performance.',
        'formacao' => 'Marketing Estratégico & Engenharia de Hardware',
        'cidade' => 'Rio de Janeiro',
        'estado' => 'RJ',
        'idade' => 28,
        'nivel' => 'Prata'
    ],
    4 => [
        'nome' => 'Carlos Poliglota & Músico',
        'telefone' => '(31) 96666-5555',
        'bio' => 'Acredito que a comunicação é a base de tudo. Ensino inglês para negócios e violão popular para quem busca um novo hobby ou profissão.',
        'formacao' => 'Letras Inglês & Música Popular',
        'cidade' => 'Belo Horizonte',
        'estado' => 'MG',
        'idade' => 35,
        'nivel' => 'Prata'
    ],
    19 => [
        'nome' => 'Ricardo Design & Saúde',
        'telefone' => '(41) 95555-4444',
        'bio' => 'Arquiteto focado em design de interiores sustentável. Também sou entusiasta da vida saudável e ajudo pessoas com planos de treino eficientes.',
        'formacao' => 'Arquitetura & Urbanismo / Nutrição Esportiva',
        'cidade' => 'Curitiba',
        'estado' => 'PR',
        'idade' => 30,
        'nivel' => 'Ouro'
    ],
    21 => [
        'nome' => 'Leanderson Consultoria Acadêmica',
        'telefone' => '(51) 94444-3333',
        'bio' => 'Especialista em metodologia científica. Meu objetivo é tirar o peso da burocracia acadêmica das costas dos estudantes com revisões impecáveis.',
        'formacao' => 'Mestre em Educação & Consultor ABNT',
        'cidade' => 'Porto Alegre',
        'estado' => 'RS',
        'idade' => 40,
        'nivel' => 'Prata'
    ]
];

echo "Atualizando perfis selecionados (Versão Final Fixada)...\n";

$sql = "UPDATE usuarios SET 
        nome = :nome, 
        telefone = :telefone, 
        bio = :bio, 
        formacao = :formacao, 
        cidade = :cidade, 
        estado = :estado, 
        idade = :idade, 
        nivel = :nivel 
        WHERE id = :id";

$stmt = $c->prepare($sql);

foreach ($perfis as $id => $dados) {
    try {
        $dados['id'] = $id;
        $stmt->execute($dados);
        echo "Perfil do usuário ID {$id} ({$dados['nome']}) atualizado com sucesso!\n";
    } catch (PDOException $e) {
        echo "Erro ao atualizar ID {$id}: " . $e->getMessage() . "\n";
    }
}

echo "Processo concluído.\n";
