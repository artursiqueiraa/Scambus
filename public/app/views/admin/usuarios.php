<main class="w-full" style="background: var(--color-bg-base); min-height: 80vh; padding: 4rem 0;">
    <div class="container" style="max-width: 1200px;">

        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 class="hero__title" style="font-size: 2.2rem; margin: 0; text-align: left;">👥 Gerenciar Usuários</h2>
                <p style="color: var(--color-text-muted); margin-top: 0.25rem;">Controle total dos membros da plataforma</p>
            </div>
            <a href="?url=admin/dashboard" class="btn btn--outline" style="border-radius: var(--radius-pill); padding: 0.6rem 1.5rem;">← Voltar ao Painel</a>
        </div>

        <div class="glass-panel" style="background: white; padding: 0; overflow: hidden;">

            <?php if(!empty($usuarios)): ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: var(--color-bg-base);">
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted); font-weight: 700;">ID</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted); font-weight: 700;">Usuário</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted); font-weight: 700;">Email</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted); font-weight: 700;">Status</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--color-text-muted); font-weight: 700;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $u):
                            $status = strtoupper(trim($u['status'] ?? 'ATIVO'));
                        ?>
                        <tr style="border-top: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='var(--color-bg-base)'" onmouseout="this.style.background='white'">

                            <td style="padding: 1rem 1.5rem; font-size: 0.85rem; color: var(--color-text-muted); font-family: 'Outfit';">#<?= $u['id'] ?></td>

                            <td style="padding: 1rem 1.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <?php if(!empty($u['foto'])): ?>
                                        <img src="<?= BASE_URL ?>/uploads/perfis/<?= htmlspecialchars($u['foto']) ?>" style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover; border: 2px solid var(--color-border);">
                                    <?php else: ?>
                                        <div style="width: 38px; height: 38px; border-radius: 50%; background: var(--color-primary-light); color: var(--color-primary); display: flex; align-items: center; justify-content: center; font-weight: 700;"><?= strtoupper(substr($u['nome'], 0, 1)) ?></div>
                                    <?php endif; ?>
                                    <strong style="color: var(--color-text-title);"><?= htmlspecialchars($u['nome']) ?></strong>
                                </div>
                            </td>

                            <td style="padding: 1rem 1.5rem; color: var(--color-text-body); font-size: 0.95rem;"><?= htmlspecialchars($u['email']) ?></td>

                            <td style="padding: 1rem 1.5rem;">
                                <?php if($status === 'ATIVO'): ?>
                                    <span style="background: #DCFCE7; color: #16A34A; padding: 0.3rem 0.8rem; border-radius: var(--radius-pill); font-size: 0.75rem; font-weight: 700;">✔ Ativo</span>
                                <?php else: ?>
                                    <span style="background: #FEE2E2; color: #DC2626; padding: 0.3rem 0.8rem; border-radius: var(--radius-pill); font-size: 0.75rem; font-weight: 700;">🔒 Bloqueado</span>
                                <?php endif; ?>
                            </td>

                            <td style="padding: 1rem 1.5rem;">
                                <?php if($u['id'] != $_SESSION['usuario_id']): ?>
                                    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">

                                        <?php if($status === 'ATIVO'): ?>
                                            <a href="?url=admin/bloquearUsuario/<?= $u['id'] ?>" class="btn btn--outline" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: #F97316; color: #F97316;">🔒 Bloquear</a>
                                        <?php else: ?>
                                            <a href="?url=admin/desbloquearUsuario/<?= $u['id'] ?>" class="btn btn--outline" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: #16A34A; color: #16A34A;">🔓 Desbloquear</a>
                                        <?php endif; ?>

                                        <a href="?url=admin/excluirUsuario/<?= $u['id'] ?>"
                                           onclick="return confirm('Tem certeza que deseja excluir o usuário <?= htmlspecialchars($u['nome']) ?>?')"
                                           class="btn btn--outline" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; border-radius: var(--radius-sm); border-color: #DC2626; color: #DC2626;">🗑</a>

                                    </div>
                                <?php else: ?>
                                    <span style="font-size: 0.85rem; color: var(--color-text-muted); font-style: italic;">Sua conta</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            <?php else: ?>
                <div style="padding: 4rem; text-align: center;">
                    <h3 style="color: var(--color-text-title);">😢 Nenhum usuário encontrado</h3>
                </div>
            <?php endif; ?>

        </div>
    </div>
</main>