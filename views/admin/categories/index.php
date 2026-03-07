<?php $e=fn($v)=>\Core\View::e($v); $url=fn($p)=>\Core\View::url($p); ?>
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px">
    <p style="color:var(--wk-text-muted);font-weight:600"><?= count($categories) ?> categor<?= count($categories)!==1?'ies':'y' ?></p>
    <a href="<?= $url('admin/categories/create') ?>" class="wk-btn wk-btn-primary">+ Add Category</a>
</div>
<?php if (empty($categories)): ?>
    <div class="wk-card"><div class="wk-empty"><div class="wk-empty-icon">📂</div><p style="font-weight:800">No categories yet</p><p><a href="<?= $url('admin/categories/create') ?>">Create your first category</a></p></div></div>
<?php else: ?>
<div class="wk-card"><table class="wk-table"><thead><tr><th>Category</th><th>Parent</th><th>Products</th><th>Status</th><th></th></tr></thead><tbody>
<?php foreach ($categories as $c): ?>
<tr>
    <td>
        <div style="font-weight:800"><?= $c['parent_name'] ? '↳ ' : '' ?><?= $e($c['name']) ?></div>
        <div style="font-size:11px;color:var(--wk-text-muted);font-family:var(--font-mono)">/<?= $e($c['slug']) ?></div>
    </td>
    <td style="color:var(--wk-text-muted)"><?= $c['parent_name'] ? $e($c['parent_name']) : '—' ?></td>
    <td style="font-weight:700"><?= $c['product_count'] ?></td>
    <td><span class="wk-badge <?= $c['is_active']?'wk-badge-success':'wk-badge-danger' ?>"><?= $c['is_active']?'Active':'Inactive' ?></span></td>
    <td style="display:flex;gap:8px">
        <a href="<?= $url('admin/categories/edit/'.$c['id']) ?>" class="wk-btn wk-btn-secondary wk-btn-sm">Edit</a>
        <form method="POST" action="<?= $url('admin/categories/delete/'.$c['id']) ?>" onsubmit="return confirm('Delete this category? Products will be unlinked.')">
            <?= \Core\Session::csrfField() ?><button type="submit" class="wk-btn wk-btn-danger wk-btn-sm">Delete</button>
        </form>
    </td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>
