<?php $e=fn($v)=>\Core\View::e($v); $url=fn($p)=>\Core\View::url($p); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <p style="color:var(--wk-text-muted);font-weight:600"><?= count($pages) ?> page<?= count($pages)!==1?'s':'' ?></p>
    <a href="<?= $url('admin/pages/create') ?>" class="wk-btn wk-btn-primary">+ New Page</a>
</div>
<div class="wk-card">
<table class="wk-table"><thead><tr><th>Page</th><th>URL</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($pages as $p): ?>
<tr>
    <td style="font-weight:800"><?= $e($p['title']) ?></td>
    <td><a href="<?= $url('page/'.$p['slug']) ?>" target="_blank" style="font-family:var(--font-mono);font-size:12px;color:var(--wk-purple)">/page/<?= $e($p['slug']) ?> ↗</a></td>
    <td><span class="wk-badge <?= $p['is_active']?'wk-badge-success':'wk-badge-danger' ?>"><?= $p['is_active']?'Active':'Hidden' ?></span></td>
    <td style="font-size:13px;color:var(--wk-text-muted)"><?= date('M j, Y', strtotime($p['updated_at'])) ?></td>
    <td>
        <div style="display:flex;gap:6px">
            <a href="<?= $url('admin/pages/edit/'.$p['id']) ?>" class="wk-btn wk-btn-secondary wk-btn-sm">Edit</a>
            <form method="POST" action="<?= $url('admin/pages/delete/'.$p['id']) ?>" onsubmit="return confirm('Delete this page?')">
                <?= \Core\Session::csrfField() ?>
                <button type="submit" class="wk-btn wk-btn-sm" style="background:none;border:2px solid var(--wk-red);color:var(--wk-red);padding:4px 10px;border-radius:6px;font-weight:700;cursor:pointer;font-size:12px">Delete</button>
            </form>
        </div>
    </td>
</tr>
<?php endforeach; ?>
</tbody></table>
</div>