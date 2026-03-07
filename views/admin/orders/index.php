<?php $e=fn($v)=>\Core\View::e($v); $url=fn($p)=>\Core\View::url($p); $price=fn($v)=>\Core\View::price($v);
$sm=['pending'=>['warning','⏳'],'processing'=>['info','🔄'],'paid'=>['success','✓'],'shipped'=>['purple','📦'],'delivered'=>['success','✅'],'cancelled'=>['danger','✗'],'refunded'=>['danger','↩']];

// Helper to get customer name from order
$customerName = function($o) {
    if (!empty($o['first_name'])) return trim($o['first_name'].' '.($o['last_name']??''));
    $billing = json_decode($o['billing_address']??'{}', true);
    if (!empty($billing['name']) && trim($billing['name']) !== '') return trim($billing['name']);
    if (!empty($o['customer_email'])) return $o['customer_email'];
    return 'Guest';
};
?>
<?php if (empty($orders)): ?>
    <div class="wk-card"><div class="wk-empty"><div class="wk-empty-icon">🛍️</div><p style="font-weight:800">No orders yet</p></div></div>
<?php else: ?>
<div class="wk-card"><table class="wk-table"><thead><tr><th>Order</th><th>Customer</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead><tbody>
<?php foreach ($orders as $o): $s=$sm[$o['status']]??['info','?']; ?>
<tr style="cursor:pointer" onclick="window.location='<?= $url('admin/orders/'.$o['id']) ?>'">
    <td><span style="font-family:var(--font-mono);font-size:12px;font-weight:700;color:var(--wk-purple)"><?= $e($o['order_number']) ?></span></td>
    <td>
        <div style="font-weight:700"><?= $e($customerName($o)) ?></div>
        <?php if (!empty($o['customer_email'])): ?><div style="font-size:11px;color:var(--wk-text-muted)"><?= $e($o['customer_email']) ?></div><?php endif; ?>
    </td>
    <td style="font-family:var(--font-mono);font-weight:700"><?= $price($o['total']) ?></td>
    <td><span class="wk-badge <?= $o['payment_status']==='captured'?'wk-badge-success':'wk-badge-warning' ?>"><?= ucfirst($o['payment_status']) ?></span></td>
    <td><span class="wk-badge wk-badge-<?= $s[0] ?>"><?= $s[1] ?> <?= ucfirst($o['status']) ?></span></td>
    <td style="color:var(--wk-text-muted);font-size:13px"><?= date('M j, g:i A', strtotime($o['created_at'])) ?></td>
</tr>
<?php endforeach; ?>
</tbody></table></div>
<?php endif; ?>
