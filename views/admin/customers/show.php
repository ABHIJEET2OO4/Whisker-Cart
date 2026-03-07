<?php $e=fn($v)=>\Core\View::e($v); $c=$customer; ?>
<a href="<?= \Core\View::url('admin/customers') ?>" style="color:var(--wk-purple);font-weight:700;font-size:13px;text-decoration:none;margin-bottom:16px;display:inline-block">← Back to Customers</a>
<div class="wk-card">
    <div class="wk-card-header"><h2><?= $e($c['first_name'].' '.$c['last_name']) ?></h2></div>
    <div class="wk-card-body">
        <p><strong>Email:</strong> <?= $e($c['email']) ?></p>
        <p><strong>Phone:</strong> <?= $e($c['phone']??'—') ?></p>
        <p><strong>Orders:</strong> <?= $c['total_orders'] ?></p>
        <p><strong>Total Spent:</strong> <?= \Core\View::price($c['total_spent']) ?></p>
        <p><strong>Joined:</strong> <?= date('M j, Y', strtotime($c['created_at'])) ?></p>
    </div>
</div>
