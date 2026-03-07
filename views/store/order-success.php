<?php $e=fn($v)=>\Core\View::e($v); $url=fn($p)=>\Core\View::url($p); ?>
<section class="wk-section" style="text-align:center;padding:80px 0">
    <div class="wk-container" style="max-width:500px">
        <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,var(--wk-green),#34d399);display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-size:36px;color:#fff;animation:successPop .5s cubic-bezier(.34,1.56,.64,1)">🎉</div>
        <h1 style="font-size:28px;font-weight:900;margin-bottom:8px">Order Placed!</h1>
        <?php if ($order): ?>
            <p style="color:var(--wk-muted);margin-bottom:8px;font-size:16px">Thank you for your purchase.</p>
            <p style="font-family:var(--font-mono);font-weight:700;font-size:14px;background:var(--wk-purple-soft);color:var(--wk-purple);display:inline-block;padding:6px 16px;border-radius:20px;margin-bottom:24px">
                <?= $e($order['order_number']) ?>
            </p>
        <?php else: ?>
            <p style="color:var(--wk-muted);margin-bottom:24px">Thank you for your order!</p>
        <?php endif; ?>
        <div style="display:flex;gap:12px;justify-content:center">
            <a href="<?= $url('') ?>" style="padding:12px 24px;border:2px solid var(--wk-border);border-radius:8px;font-weight:800;font-size:14px;transition:all .2s">Continue Shopping</a>
        </div>
    </div>
</section>
<style>@keyframes successPop{from{transform:scale(0)}to{transform:scale(1)}}</style>
<script>document.addEventListener('DOMContentLoaded', () => WhiskerStore.confetti());</script>
