<?php $usuario_logado = $_SESSION['usuario_id']; ?>
<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 700px;">

        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 2rem;">
            <div style="font-size: 2.5rem;">🌐</div>
            <h2 class="hero__title" style="font-size: 2.2rem; margin: 0; text-align: left;">Mural da Comunidade</h2>
        </div>

        <!-- TOP CONTRIBUIDORES E FILTROS -->
        <?php if(!empty($topContribuidores)): ?>
        <div style="margin-bottom: 2rem; display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 0.5rem; align-items: stretch; flex-wrap: wrap;">
            <div style="background: white; padding: 1rem; border-radius: var(--radius-md); border: 1px solid var(--color-border); flex-shrink: 0; min-width: 250px;">
                <h4 style="margin: 0 0 1rem 0; font-size: 0.95rem; color: var(--color-text-title);">🌟 Estrelas da Vizinhança</h4>
                <div style="display: flex; gap: 0.5rem;">
                    <?php foreach($topContribuidores as $top): ?>
                        <a href="?url=usuario/perfil/<?= $top['id'] ?>" title="<?= htmlspecialchars($top['nome']) ?>">
                            <?php if (!empty($top['foto_perfil'])): ?>
                                <img src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($top['foto_perfil']) ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid gold;">
                            <?php else: ?>
                                <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid gold; font-size: 0.9rem;">
                                    <?= strtoupper(substr($top['nome'], 0, 1)) ?>
                                </div>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div style="display: flex; gap: 0.5rem; align-items: center; padding: 1rem; background: white; border-radius: var(--radius-md); border: 1px solid var(--color-border); flex: 1; flex-wrap: wrap;">
                <span style="font-weight: 600; font-size: 0.9rem; color: var(--color-text-title); margin-right: 0.5rem;">Filtros:</span>
                <a href="?url=comunidade" class="btn <?= !isset($_GET['tipo']) ? 'btn--primary' : '' ?>" style="padding: 0.5rem 1rem; white-space: nowrap; <?= isset($_GET['tipo']) ? 'background:white; border:1px solid var(--color-border); color:var(--color-text-body);' : '' ?>">Tudo</a>
                <a href="?url=comunidade&tipo=OFERECENDO" class="btn <?= (isset($_GET['tipo']) && $_GET['tipo']=='OFERECENDO') ? 'btn--primary' : '' ?>" style="padding: 0.5rem 1rem; white-space: nowrap; <?= (!isset($_GET['tipo']) || $_GET['tipo']!='OFERECENDO') ? 'background:white; border:1px solid var(--color-border); color:var(--color-text-body);' : '' ?>">📢 Oferecendo</a>
                <a href="?url=comunidade&tipo=PROCURANDO" class="btn <?= (isset($_GET['tipo']) && $_GET['tipo']=='PROCURANDO') ? 'btn--primary' : '' ?>" style="padding: 0.5rem 1rem; white-space: nowrap; <?= (!isset($_GET['tipo']) || $_GET['tipo']!='PROCURANDO') ? 'background:white; border:1px solid var(--color-border); color:var(--color-text-body);' : '' ?>">🆘 Procurando</a>
                <a href="?url=comunidade&tipo=DICA" class="btn <?= (isset($_GET['tipo']) && $_GET['tipo']=='DICA') ? 'btn--primary' : '' ?>" style="padding: 0.5rem 1rem; white-space: nowrap; <?= (!isset($_GET['tipo']) || $_GET['tipo']!='DICA') ? 'background:white; border:1px solid var(--color-border); color:var(--color-text-body);' : '' ?>">💡 Dicas</a>
            </div>
        </div>
        <?php endif; ?>

        <!-- FORMULÁRIO DE POST -->
        <div class="glass-panel" style="background: white; padding: 1.5rem; margin-bottom: 3rem;">
            <form method="POST" action="?url=comunidade/postar" enctype="multipart/form-data">
                <?= Seguranca::csrfCampo() ?>
                
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <select name="tipo_post" class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.5rem; border-radius: var(--radius-md);">
                        <option value="DICA">💡 Dica / Conhecimento</option>
                        <option value="OFERECENDO">📢 Oferecendo Serviço</option>
                        <option value="PROCURANDO">🆘 Procurando Serviço</option>
                    </select>

                    <?php if(!empty($meus_servicos)): ?>
                    <select name="servico_id" class="input-glass" style="border: 1px solid var(--color-border); background: var(--color-bg-base); padding: 0.5rem; border-radius: var(--radius-md); flex: 1;">
                        <option value="">Nenhum serviço anexado</option>
                        <?php foreach($meus_servicos as $ms): ?>
                            <option value="<?= $ms['id'] ?>">Anexar: <?= htmlspecialchars($ms['titulo']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php endif; ?>
                </div>

                <textarea name="texto" rows="3" class="input-glass" placeholder="Compartilhe uma habilidade ou dica com a comunidade..." required style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%; border-radius: var(--radius-md); padding: 1rem; resize: none; margin-bottom: 1rem;"></textarea>

                <div style="display: flex; align-items: center; justify-content: space-between;">

                    <div style="display: flex; align-items: center; gap: 1rem;">

                        <!-- BOTÃO IMAGEM -->
                        <label style="cursor: pointer; color: var(--color-text-body); display: flex; align-items: center; gap: 0.5rem;" title="Adicionar imagem">
                            <img src="<?= BASE_URL ?>/uploads/icons/imagem.png" alt="Imagem" style="width: 24px; height: 24px; object-fit: contain;">
                            <input type="file" name="imagem" accept="image/*" style="display: none;">
                        </label>

                        <!-- BOTÃO VÍDEO -->
                        <label style="cursor: pointer; color: var(--color-text-body); display: flex; align-items: center; gap: 0.5rem; font-size: 1.4rem;" title="Adicionar vídeo">
                            <img src="<?= BASE_URL ?>/uploads/icons/Video.png" alt="Vídeo" style="width: 24px; height: 24px; object-fit: contain;">
                            <input type="file" name="video" accept="video/*" style="display: none;">
                        </label>

                    </div>

                    <button type="submit" class="btn btn--primary" style="padding: 0.6rem 2rem;">Publicar</button>

                </div>
            </form>
        </div>

        <!-- FEED DE POSTS -->
        <?php if (empty($posts)): ?>
            <div class="glass-panel" style="background: white; padding: 4rem; text-align: center;">
                <div style="font-size: 4rem; margin-bottom: 1rem;">💬</div>
                <p style="color: var(--color-text-body); font-size: 1.1rem;">Nenhuma publicação ainda na rede verde. Seja o primeiro a puxar assunto!</p>
            </div>
        <?php else: ?>
            <?php 
                $comunidadeModel = new Comunidade();
                foreach ($posts as $post):
                    $jaCurtiu = $post['ja_curtiu'] > 0;
                    $comentarios = $comunidadeModel->listarComentarios($post['id']);
            ?>
                <div class="glass-panel" style="background: white; padding: 0; margin-bottom: 2rem; overflow: hidden;">

                    <!-- CABEÇALHO DO POST -->
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1.5rem; position: relative;">
                        <a href="?url=usuario/perfil/<?= $post['usuario_id'] ?>" style="flex-shrink: 0;">
                            <?php 
                                $borderColor = 'var(--color-border)';
                                $medalha = '';
                                if ($post['nivel'] === 'Ouro') { $borderColor = '#FFD700'; $medalha = '🥇'; }
                                elseif ($post['nivel'] === 'Prata') { $borderColor = '#C0C0C0'; $medalha = '🥈'; }
                                elseif ($post['nivel'] === 'Bronze') { $borderColor = '#CD7F32'; $medalha = '🥉'; }
                            ?>
                            <?php if (!empty($post['foto_perfil'])): ?>
                                <img src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($post['foto_perfil']) ?>" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid <?= $borderColor ?>;">
                            <?php else: ?>
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; border: 2px solid <?= $borderColor ?>;"><?= strtoupper(substr($post['nome'], 0, 1)) ?></div>
                            <?php endif; ?>
                        </a>
                        <div style="flex: 1;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                                <a href="?url=usuario/perfil/<?= $post['usuario_id'] ?>" style="font-weight: 700; color: var(--color-text-title); text-decoration: none; font-size: 1.05rem;">
                                    <?= htmlspecialchars($post['nome']) ?> <?= $medalha ?>
                                </a>
                                <?php if ($post['tipo_post'] === 'OFERECENDO'): ?>
                                    <span style="font-size: 0.7rem; background: #e6f4ea; color: #1e8e3e; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight: bold;">📢 OFERECENDO</span>
                                <?php elseif ($post['tipo_post'] === 'PROCURANDO'): ?>
                                    <span style="font-size: 0.7rem; background: #fce8e6; color: #d93025; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight: bold;">🆘 PROCURANDO</span>
                                <?php else: ?>
                                    <span style="font-size: 0.7rem; background: #e8f0fe; color: #1a73e8; padding: 0.2rem 0.5rem; border-radius: 12px; font-weight: bold;">💡 DICA</span>
                                <?php endif; ?>
                            </div>
                            <div style="font-size: 0.8rem; color: var(--color-text-muted);">
                                <?= date('d/m/Y \à\s H:i', strtotime($post['data_criacao'])) ?>
                            </div>
                        </div>

                        <?php if ($post['usuario_id'] == $usuario_logado): ?>
                            <!-- MENU TRÊS PONTINHOS -->
                            <div style="position: relative;">
                                <button onclick="togglePostMenu(<?= $post['id'] ?>)" id="post-menu-btn-<?= $post['id'] ?>" style="background: none; border: none; cursor: pointer; padding: 0.4rem 0.6rem; border-radius: var(--radius-md); color: var(--color-text-muted); font-size: 1.3rem; line-height: 1; transition: all 0.2s ease; letter-spacing: 2px;" onmouseenter="this.style.background='var(--color-bg-base)';this.style.color='var(--color-text-title)'" onmouseleave="this.style.background='none';this.style.color='var(--color-text-muted)'">
                                    ⋯
                                </button>

                                <!-- DROPDOWN MENU -->
                                <div id="post-menu-<?= $post['id'] ?>" style="display: none; position: absolute; top: calc(100% + 6px); right: 0; background: white; border: 1px solid var(--color-border); border-radius: var(--radius-md); box-shadow: 0 8px 30px rgba(0,0,0,0.12); z-index: 100; min-width: 180px; overflow: hidden; animation: menuDropIn 0.2s ease;">
                                    <button onclick="abrirModalEditar(<?= $post['id'] ?>, <?= htmlspecialchars(json_encode($post['texto']), ENT_QUOTES, 'UTF-8') ?>)" style="width: 100%; padding: 0.85rem 1.2rem; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem; color: var(--color-text-body); transition: background 0.15s ease; text-align: left;" onmouseenter="this.style.background='var(--color-bg-base)'" onmouseleave="this.style.background='none'">
                                        <span style="font-size: 1.1rem;">✏️</span> Editar publicação
                                    </button>
                                    <div style="height: 1px; background: var(--color-border);"></div>
                                    <button onclick="confirmarExcluir(<?= $post['id'] ?>)" style="width: 100%; padding: 0.85rem 1.2rem; background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem; color: #e53e3e; transition: background 0.15s ease; text-align: left;" onmouseenter="this.style.background='#fff5f5'" onmouseleave="this.style.background='none'">
                                        <span style="font-size: 1.1rem;">🗑️</span> Excluir publicação
                                    </button>
                                </div>
                            </div>

                            <!-- Formulário oculto de exclusão -->
                            <form id="delete-form-<?= $post['id'] ?>" method="POST" action="?url=comunidade/excluir/<?= $post['id'] ?>" style="display: none;"><?= Seguranca::csrfCampo() ?></form>
                        <?php endif; ?>
                    </div>

                    <!-- TEXTO DO POST -->
                    <div style="padding: 0 1.5rem 1.5rem; color: var(--color-text-body); line-height: 1.7; font-size: 1rem;">
                        <?= nl2br(htmlspecialchars($post['texto'])) ?>
                    </div>

                    <!-- IMAGEM DO POST -->
                    <?php if (!empty($post['imagem'])): ?>
                        <div style="padding: 0 1.5rem 1.5rem;">
                            <img src="<?= BASE_URL ?>/uploads/comunidade/<?= htmlspecialchars($post['imagem']) ?>" style="width: 100%; border-radius: var(--radius-md); max-height: 500px; object-fit: cover;">
                        </div>
                    <?php endif; ?>

                    <!-- VÍDEO DO POST -->
                    <?php if (!empty($post['video'])): ?>
                        <div style="padding: 0 1.5rem 1.5rem;">
                            <video controls style="width: 100%; border-radius: var(--radius-md); max-height: 500px; background: #000;">
                                <source src="<?= BASE_URL ?>/uploads/comunidade/<?= htmlspecialchars($post['video']) ?>" type="video/mp4">
                                Seu navegador não suporta vídeos.
                            </video>
                        </div>
                    <?php endif; ?>

                    <!-- SERVIÇO ANEXADO -->
                    <?php if (!empty($post['servico_id'])): ?>
                        <div style="padding: 0 1.5rem 1.5rem;">
                            <div style="border: 1px solid var(--color-primary-light); border-radius: var(--radius-md); padding: 1rem; background: #fdfdfd; display: flex; align-items: center; gap: 1rem;">
                                <?php if (!empty($post['servico_imagem'])): ?>
                                    <img src="<?= BASE_URL ?>/uploads/servicos/<?= htmlspecialchars($post['servico_imagem']) ?>" style="width: 60px; height: 60px; border-radius: 8px; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; border-radius: 8px; background: var(--color-bg-base); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">💼</div>
                                <?php endif; ?>
                                <div style="flex: 1;">
                                    <h4 style="margin: 0 0 0.25rem 0; font-size: 1rem; color: var(--color-text-title);"><?= htmlspecialchars($post['servico_titulo']) ?></h4>
                                    <span style="font-size: 0.85rem; font-weight: bold; color: var(--color-primary);">💰 <?= $post['servico_valor'] ?> SCoins</span>
                                </div>
                                <a href="?url=servico/detalhes/<?= $post['servico_id'] ?>" class="btn btn--primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Ver Serviço</a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- AÇÕES (curtir / comentários / emoji) -->
                    <div style="border-top: 1px solid var(--color-border); padding: 1rem 1.5rem; display: flex; gap: 1rem; align-items: center; position: relative; flex-wrap: wrap;">
                        <!-- CURTIR (AJAX, sem recarregar) -->
                        <button
                            onclick="curtirPost(<?= $post['id'] ?>, this)"
                            id="btn-curtir-<?= $post['id'] ?>"
                            data-curtido="<?= $jaCurtiu ? '1' : '0' ?>"
                            style="font-weight: 600; display: flex; align-items: center; gap: 0.5rem; color: <?= $jaCurtiu ? 'var(--color-primary)' : 'var(--color-text-muted)' ?>; background: none; border: none; cursor: pointer; padding: 0.3rem 0.5rem; border-radius: var(--radius-md); transition: all 0.2s ease;"
                        >
                            <span id="icone-curtir-<?= $post['id'] ?>"><?= $jaCurtiu ? '❤️' : '🤍' ?></span>
                            <span id="curtidas-<?= $post['id'] ?>"><?= $post['total_curtidas'] ?></span>
                        </button>
                        <button onclick="toggleComentarios(<?= $post['id'] ?>)" style="font-weight: 600; display: flex; align-items: center; gap: 0.5rem; color: var(--color-text-muted); background: none; border: none; cursor: pointer; padding: 0;">
                            💬 <span><?= $post['total_comentarios'] ?></span> Comentários
                        </button>

                        <!-- BOTÃO DE EMOJI REACTION -->
                        <div style="position: relative;">
                            <button onclick="toggleEmojiPicker(<?= $post['id'] ?>)" id="emoji-btn-<?= $post['id'] ?>" style="font-weight: 600; display: flex; align-items: center; gap: 0.4rem; color: var(--color-text-muted); background: none; border: none; cursor: pointer; padding: 0.3rem 0.5rem; border-radius: var(--radius-md); transition: all 0.2s ease;" onmouseenter="this.style.background='var(--color-bg-base)';this.style.transform='scale(1.1)'" onmouseleave="this.style.background='none';this.style.transform='scale(1)'">
                                <span style="font-size: 1.25rem;">😀</span>
                                <span style="font-size: 0.85rem;">Reagir</span>
                            </button>

                            <!-- POPUP DE EMOJIS -->
                            <div id="emoji-picker-<?= $post['id'] ?>" style="display: none; position: absolute; bottom: calc(100% + 10px); left: 0; background: white; border: 1px solid var(--color-border); border-radius: 50px; padding: 0.5rem 0.75rem; box-shadow: 0 8px 30px rgba(0,0,0,0.12); z-index: 100; white-space: nowrap; animation: emojiPopIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);">
                                <div style="display: flex; gap: 0.25rem; align-items: center;">
                                    <?php
                                    $emojis = ['😄', '😐', '🤩', '😡', '😲'];
                                    foreach ($emojis as $emoji):
                                    ?>
                                        <button onclick="enviarReacaoEmoji(<?= $post['id'] ?>, '<?= $emoji ?>')" style="background: none; border: none; cursor: pointer; font-size: 1.6rem; padding: 0.3rem 0.4rem; border-radius: 50%; transition: all 0.2s ease; line-height: 1;" onmouseenter="this.style.transform='scale(1.35)';this.style.background='var(--color-bg-base)'" onmouseleave="this.style.transform='scale(1)';this.style.background='none'" title="<?= $emoji ?>">
                                            <?= $emoji ?>
                                        </button>
                                    <?php endforeach; ?>
                                </div>
                                <div style="position: absolute; bottom: -6px; left: 20px; width: 12px; height: 12px; background: white; border-right: 1px solid var(--color-border); border-bottom: 1px solid var(--color-border); transform: rotate(45deg);"></div>
                            </div>
                        </div>

                        <!-- GORJETA -->
                        <?php if ($post['usuario_id'] != $usuario_logado): ?>
                            <form method="POST" action="?url=comunidade/gorjeta/<?= $post['id'] ?>" style="margin-left: auto;">
                                <?= Seguranca::csrfCampo() ?>
                                <input type="hidden" name="valor" value="5">
                                <button type="submit" style="font-weight: 600; display: flex; align-items: center; gap: 0.4rem; color: #f59e0b; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.2); cursor: pointer; padding: 0.3rem 0.6rem; border-radius: var(--radius-md); transition: all 0.2s ease;" onmouseenter="this.style.background='rgba(245, 158, 11, 0.2)';this.style.transform='scale(1.05)'" onmouseleave="this.style.background='rgba(245, 158, 11, 0.1)';this.style.transform='scale(1)'" title="Dar 5 SCoins de Gorjeta" onclick="return confirm('Doar 5 SCoins de gorjeta para a publicação de <?= htmlspecialchars($post['nome']) ?>?')">
                                    <span style="font-size: 1.1rem;">💎</span>
                                    <span style="font-size: 0.85rem;">Dar Gorjeta (+5)</span>
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Formulário oculto para envio de emoji como comentário -->
                        <form id="emoji-form-<?= $post['id'] ?>" method="POST" action="?url=comunidade/comentar/<?= $post['id'] ?>" style="display: none;">
                            <?= Seguranca::csrfCampo() ?>
                            <input type="hidden" name="texto" id="emoji-input-<?= $post['id'] ?>">
                        </form>
                    </div>

                    <!-- ÁREA DE COMENTÁRIOS -->
                    <div id="comentarios-<?= $post['id'] ?>" style="display: none; border-top: 1px solid var(--color-border); background: var(--color-bg-base); padding: 1.5rem;">
                        <?php if (!empty($comentarios)): ?>
                            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                                <?php foreach ($comentarios as $c): ?>
                                    <div style="display: flex; gap: 0.75rem; align-items: start;">
                                        <?php if (!empty($c['foto_perfil'])): ?>
                                            <img src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($c['foto_perfil']) ?>" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                        <?php else: ?>
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem;"><?= strtoupper(substr($c['nome'], 0, 1)) ?></div>
                                        <?php endif; ?>
                                        <div class="glass-panel" style="background: white; padding: 1rem; flex: 1; border-radius: 0 16px 16px 16px;">
                                            <a href="?url=usuario/perfil/<?= $c['usuario_id'] ?>" style="font-weight: 700; color: var(--color-text-title); text-decoration: none; font-size: 0.9rem;">
                                                <?= htmlspecialchars($c['nome']) ?>
                                            </a>
                                            <p style="color: var(--color-text-body); font-size: 0.95rem; margin: 0.25rem 0;"><?= nl2br(htmlspecialchars($c['texto'])) ?></p>
                                            <span style="font-size: 0.75rem; color: var(--color-text-muted);"><?= date('d/m H:i', strtotime($c['data_criacao'])) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?> 

                        <!-- Formulário de comentário -->
                        <form method="POST" action="?url=comunidade/comentar/<?= $post['id'] ?>" style="display: flex; gap: 0.75rem;">
                            <?= Seguranca::csrfCampo() ?>
                            <input type="text" name="texto" placeholder="Adicione um comentário..." required class="input-glass" style="flex: 1; border: 1px solid var(--color-border); padding: 0.75rem 1rem;">
                            <button type="submit" class="btn btn--primary" style="padding: 0 1.5rem;">Enviar</button>
                        </form>
                    </div>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
</main>

<!-- MODAL DE EDIÇÃO -->
<div id="modal-editar" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; backdrop-filter: blur(4px); animation: modalFadeIn 0.25s ease;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; border-radius: var(--radius-md); box-shadow: 0 20px 60px rgba(0,0,0,0.2); width: 90%; max-width: 520px; overflow: hidden; animation: modalSlideIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between;">
            <h3 style="margin: 0; font-size: 1.15rem; color: var(--color-text-title);">✏️ Editar publicação</h3>
            <button onclick="fecharModalEditar()" style="background: none; border: none; cursor: pointer; font-size: 1.4rem; color: var(--color-text-muted); padding: 0.2rem 0.5rem; border-radius: var(--radius-md); transition: all 0.15s;" onmouseenter="this.style.background='var(--color-bg-base)'" onmouseleave="this.style.background='none'">✕</button>
        </div>
        <form id="form-editar-post" method="POST" action="" style="padding: 1.5rem;">
            <?= Seguranca::csrfCampo() ?>
            <textarea id="editar-texto" name="texto" rows="5" required style="border: 1px solid var(--color-border); background: var(--color-bg-base); width: 100%; border-radius: var(--radius-md); padding: 1rem; resize: none; font-size: 1rem; line-height: 1.6; font-family: inherit; transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--color-primary)'" onblur="this.style.borderColor='var(--color-border)'"></textarea>
            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 1.25rem;">
                <button type="button" onclick="fecharModalEditar()" style="padding: 0.65rem 1.5rem; border: 1px solid var(--color-border); background: white; border-radius: var(--radius-md); cursor: pointer; font-weight: 600; color: var(--color-text-body); transition: all 0.15s;" onmouseenter="this.style.background='var(--color-bg-base)'" onmouseleave="this.style.background='white'">Cancelar</button>
                <button type="submit" class="btn btn--primary" style="padding: 0.65rem 2rem;">Salvar</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Token CSRF global para fetch */
#csrf-global { display: none; }

@keyframes emojiPopIn {
    0% { opacity: 0; transform: scale(0.5) translateY(10px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes menuDropIn {
    0% { opacity: 0; transform: translateY(-8px); }
    100% { opacity: 1; transform: translateY(0); }
}
@keyframes modalFadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}
@keyframes modalSlideIn {
    0% { opacity: 0; transform: translate(-50%, -50%) scale(0.9); }
    100% { opacity: 1; transform: translate(-50%, -50%) scale(1); }
}

/* EMOJI PICKER — Mobile first */
@media (max-width: 600px) {
    [id^="emoji-picker-"] {
        position: fixed !important;
        bottom: 1.5rem !important;
        left: 50% !important;
        transform: translateX(-50%) !important;
        top: auto !important;
        right: auto !important;
        width: 92vw;
        max-width: 340px;
        display: flex;
        justify-content: space-around;
        padding: 0.8rem 1rem;
        border-radius: 18px;
        z-index: 9999;
        white-space: nowrap;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    [id^="emoji-picker-"] > div {
        justify-content: space-around;
        width: 100%;
    }
}
</style>

<script>
function toggleComentarios(id) {
    const el = document.getElementById('comentarios-' + id);
    el.style.display = el.style.display === 'none' ? 'block' : 'none';
}

function toggleEmojiPicker(id) {
    document.querySelectorAll('[id^="emoji-picker-"]').forEach(function(picker) {
        if (picker.id !== 'emoji-picker-' + id) picker.style.display = 'none';
    });
    const picker = document.getElementById('emoji-picker-' + id);
    picker.style.display = (picker.style.display === 'none' || picker.style.display === '') ? 'block' : 'none';
}

function enviarReacaoEmoji(postId, emoji) {
    document.getElementById('emoji-input-' + postId).value = emoji;
    document.getElementById('emoji-form-' + postId).submit();
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('[id^="emoji-picker-"]') && !e.target.closest('[id^="emoji-btn-"]')) {
        document.querySelectorAll('[id^="emoji-picker-"]').forEach(p => p.style.display = 'none');
    }
    if (!e.target.closest('[id^="post-menu-"]') && !e.target.closest('[id^="post-menu-btn-"]')) {
        document.querySelectorAll('[id^="post-menu-"]').forEach(function(menu) {
            if (!menu.id.includes('btn')) menu.style.display = 'none';
        });
    }
});

function togglePostMenu(id) {
    document.querySelectorAll('[id^="post-menu-"]').forEach(function(menu) {
        if (menu.id !== 'post-menu-' + id && !menu.id.includes('btn')) menu.style.display = 'none';
    });
    const menu = document.getElementById('post-menu-' + id);
    menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
}

function abrirModalEditar(postId, textoAtual) {
    document.querySelectorAll('[id^="post-menu-"]').forEach(function(menu) {
        if (!menu.id.includes('btn')) menu.style.display = 'none';
    });
    const modal = document.getElementById('modal-editar');
    document.getElementById('editar-texto').value = textoAtual;
    document.getElementById('form-editar-post').action = '?url=comunidade/editar/' + postId;
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    setTimeout(function() { document.getElementById('editar-texto').focus(); }, 100);
}

function fecharModalEditar() {
    document.getElementById('modal-editar').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('modal-editar').addEventListener('click', function(e) {
    if (e.target === this) fecharModalEditar();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') fecharModalEditar();
});

function confirmarExcluir(postId) {
    document.querySelectorAll('[id^="post-menu-"]').forEach(function(menu) {
        if (!menu.id.includes('btn')) menu.style.display = 'none';
    });
    if (confirm('Tem certeza que deseja excluir esta publicação? Esta ação não pode ser desfeita.')) {
        document.getElementById('delete-form-' + postId).submit();
    }
}

// CSRF token global para todas as chamadas fetch
const CSRF_TOKEN = '<?= Seguranca::csrfToken() ?>';

// CURTIR VIA AJAX
async function curtirPost(postId, btn) {
    try {
        btn.disabled = true;
        btn.style.opacity = '0.5';

        const formData = new FormData();
        formData.append('csrf_token', CSRF_TOKEN);

        const resp = await fetch('?url=comunidade/curtirAjax/' + postId, {
            method: 'POST',
            body: formData
        });

        if (!resp.ok) throw new Error('HTTP ' + resp.status);
        const json = await resp.json();

        if (json.ok) {
            const span    = document.getElementById('curtidas-' + postId);
            const icone   = document.getElementById('icone-curtir-' + postId);
            span.textContent  = json.total;
            icone.textContent = json.curtiu ? '❤️' : '🤍';
            btn.dataset.curtido = json.curtiu ? '1' : '0';
            btn.style.color = json.curtiu ? 'var(--color-primary)' : 'var(--color-text-muted)';
        }
    } catch(e) {
        console.error('Erro ao curtir:', e);
    } finally {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
}
</script>