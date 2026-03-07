<?php
namespace Core;

/**
 * All payment gateway plugins must implement this interface.
 */
interface PaymentGatewayInterface
{
    public function createOrder(array $order): array;
    public function verifyPayment(array $payload): array;
    public function refund(string $paymentId, float $amount): array;
    public function getPublicConfig(): array;
    public function webhook(\Core\Request $request): void;
}
