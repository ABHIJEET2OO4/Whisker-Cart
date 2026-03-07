<?php
namespace Core;

abstract class BaseGateway implements PaymentGatewayInterface
{
    protected array $config;
    protected bool $testMode;
    protected string $code;

    public function __construct(string $gatewayCode)
    {
        $this->code = $gatewayCode;
        $row = Database::fetch(
            "SELECT config, is_test_mode FROM wk_payment_gateways WHERE gateway_code=?",
            [$gatewayCode]
        );
        $this->config = $row ? (json_decode($row['config'], true) ?? []) : [];
        $this->testMode = $row ? (bool)$row['is_test_mode'] : true;
    }

    protected function cfg(string $key): string
    {
        if ($this->testMode && isset($this->config["test_{$key}"])) {
            return $this->config["test_{$key}"];
        }
        return $this->config[$key] ?? '';
    }

    protected function logTransaction(int $orderId, array $data): int
    {
        return Database::insert('wk_payment_transactions', [
            'order_id'         => $orderId,
            'gateway_code'     => $this->code,
            'transaction_id'   => $data['transaction_id'] ?? null,
            'gateway_order_id' => $data['gateway_order_id'] ?? null,
            'amount'           => $data['amount'],
            'currency'         => $data['currency'] ?? 'INR',
            'status'           => $data['status'] ?? 'initiated',
            'gateway_response' => json_encode($data['response'] ?? []),
        ]);
    }

    protected function markOrderPaid(int $orderId, string $paymentId): void
    {
        Database::update('wk_orders', [
            'payment_status'=>'captured', 'payment_id'=>$paymentId,
            'payment_gateway'=>$this->code, 'status'=>'paid',
        ], 'id=?', [$orderId]);

        // Reduce stock
        $items = Database::fetchAll("SELECT product_id, quantity FROM wk_order_items WHERE order_id=?", [$orderId]);
        foreach ($items as $item) {
            Database::query("UPDATE wk_products SET stock_quantity=GREATEST(0,stock_quantity-?) WHERE id=?",
                [$item['quantity'], $item['product_id']]);
        }
    }
}
