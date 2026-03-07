<?php
$url=fn($p)=>\Core\View::url($p);
$s=$settings;
$v=fn($g,$k)=>htmlspecialchars($s[$g][$k]??'');
$shippingMethod = $s['shipping']['method'] ?? 'flat';
$carriers = [];
try { $carriers = \Core\Database::fetchAll("SELECT * FROM wk_shipping_carriers WHERE is_active=1 ORDER BY name"); } catch(\Exception $e) {}
?>
<div style="display:flex;gap:12px;margin-bottom:24px">
    <a href="<?= $url('admin/shipping') ?>" class="wk-btn wk-btn-secondary">🚚 Manage Carriers</a>
</div>

<form method="POST" action="<?= $url('admin/shipping/settings/update') ?>">
    <?= \Core\Session::csrfField() ?>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:900px">
        <div>
            <div class="wk-card">
                <div class="wk-card-header"><h2>Shipping Method</h2></div>
                <div class="wk-card-body">
                    <div class="wk-form-group">
                        <label>Method</label>
                        <select name="shipping_method" class="wk-select" id="shippingMethod" onchange="toggleShipping()">
                            <option value="flat" <?= $shippingMethod==='flat'?'selected':'' ?>>Flat Rate</option>
                            <option value="free" <?= $shippingMethod==='free'?'selected':'' ?>>Free Shipping</option>
                            <option value="free_above" <?= $shippingMethod==='free_above'?'selected':'' ?>>Free Above Threshold</option>
                            <option value="per_item" <?= $shippingMethod==='per_item'?'selected':'' ?>>Per Item</option>
                            <option value="weight" <?= $shippingMethod==='weight'?'selected':'' ?>>Weight Based</option>
                        </select>
                    </div>

                    <!-- Flat Rate -->
                    <div class="sf" data-m="flat">
                        <div class="wk-form-group">
                            <label>Flat Rate Amount</label>
                            <input type="number" step="0.01" name="shipping_flat_rate" class="wk-input" value="<?= $v('shipping','flat_rate') ?: $v('checkout','shipping_flat_rate') ?>" placeholder="50.00">
                            <div style="font-size:11px;color:var(--wk-text-muted);margin-top:3px">Same shipping charge for every order</div>
                        </div>
                    </div>

                    <!-- Free Shipping -->
                    <div class="sf" data-m="free" style="display:none">
                        <div style="padding:16px;background:#d1fae5;border-radius:8px;font-size:13px;color:#10b981;font-weight:700;margin-top:8px">
                            ✓ All orders ship free — no charge at checkout.
                        </div>
                    </div>

                    <!-- Free Above Threshold -->
                    <div class="sf" data-m="free_above" style="display:none">
                        <div class="wk-form-group">
                            <label>Shipping Rate (below threshold)</label>
                            <input type="number" step="0.01" name="shipping_flat_rate_below" class="wk-input" value="<?= $v('shipping','flat_rate_below') ?>" placeholder="50.00">
                        </div>
                        <div class="wk-form-group">
                            <label>Free Shipping Threshold</label>
                            <input type="number" step="0.01" name="shipping_free_threshold" class="wk-input" value="<?= $v('shipping','free_threshold') ?>" placeholder="500.00">
                            <div style="font-size:11px;color:var(--wk-text-muted);margin-top:3px">Orders above this amount get free shipping</div>
                        </div>
                    </div>

                    <!-- Per Item -->
                    <div class="sf" data-m="per_item" style="display:none">
                        <div class="wk-form-group">
                            <label>Charge Per Item</label>
                            <input type="number" step="0.01" name="shipping_per_item" class="wk-input" value="<?= $v('shipping','per_item') ?>" placeholder="10.00">
                            <div style="font-size:11px;color:var(--wk-text-muted);margin-top:3px">Multiplied by total items in cart</div>
                        </div>
                        <div class="wk-form-group">
                            <label>Max Shipping Cap <span style="font-weight:500;text-transform:none">(optional)</span></label>
                            <input type="number" step="0.01" name="shipping_per_item_cap" class="wk-input" value="<?= $v('shipping','per_item_cap') ?>" placeholder="No cap">
                        </div>
                    </div>

                    <!-- Weight Based -->
                    <div class="sf" data-m="weight" style="display:none">
                        <div class="wk-form-group">
                            <label>Base Rate (first 1kg)</label>
                            <input type="number" step="0.01" name="shipping_weight_base" class="wk-input" value="<?= $v('shipping','weight_base') ?>" placeholder="50.00">
                        </div>
                        <div class="wk-form-group">
                            <label>Per Additional kg</label>
                            <input type="number" step="0.01" name="shipping_weight_per_kg" class="wk-input" value="<?= $v('shipping','weight_per_kg') ?>" placeholder="20.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <?php if (!empty($carriers)): ?>
            <div class="wk-card" style="margin-bottom:20px">
                <div class="wk-card-header"><h2>📦 Carrier Rates</h2><span style="font-size:12px;color:var(--wk-text-muted);font-weight:600">Optional overrides</span></div>
                <div class="wk-card-body">
                    <p style="font-size:12px;color:var(--wk-text-muted);margin-bottom:14px">Set carrier-specific flat rates. Leave empty to use the default method.</p>
                    <?php foreach ($carriers as $c): ?>
                    <div class="wk-form-group">
                        <label><?= htmlspecialchars($c['name']) ?></label>
                        <input type="number" step="0.01" name="shipping_carrier_rate_<?= $c['id'] ?>" class="wk-input"
                               value="<?= $v('shipping','carrier_rate_'.$c['id']) ?>" placeholder="Use default">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php else: ?>
            <div class="wk-card" style="margin-bottom:20px">
                <div class="wk-card-body" style="text-align:center;padding:28px;color:var(--wk-text-muted)">
                    <div style="font-size:28px;margin-bottom:8px;opacity:.3">🚚</div>
                    <p style="font-weight:700;margin-bottom:4px">No carriers configured</p>
                    <p style="font-size:13px">Add carriers in <a href="<?= $url('admin/shipping') ?>" style="color:var(--wk-purple);font-weight:700">Shipping Carriers</a> to set per-carrier rates.</p>
                </div>
            </div>
            <?php endif; ?>

            <button type="submit" class="wk-btn wk-btn-primary" style="width:100%;justify-content:center">Save Shipping Settings</button>
        </div>
    </div>
</form>

<script>
function toggleShipping() {
    const m = document.getElementById('shippingMethod').value;
    document.querySelectorAll('.sf').forEach(f => f.style.display = f.dataset.m === m ? 'block' : 'none');
}
toggleShipping();
</script>