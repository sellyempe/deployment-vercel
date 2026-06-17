<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat Snap Token untuk pembayaran
     */
    public function createSnapToken($booking)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $booking->order_id,
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
            'item_details' => [
                [
                    'id' => 'trip-'.$booking->trip_id,
                    'price' => (int) $booking->total_price,
                    'quantity' => $booking->participants,
                    'name' => $booking->trip->title,
                ],
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return $snapToken;
        } catch (\Exception $e) {
            \Log::error('Midtrans Snap Error: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Verifikasi signature key dari Midtrans.
     * Format: SHA512(order_id + status_code + gross_amount + server_key)
     *
     * Ini memastikan notifikasi benar-benar berasal dari Midtrans,
     * bukan dari pihak luar yang mencoba memalsukan status pembayaran.
     *
     * @param  array  $notification  Raw payload dari Midtrans
     *
     * @throws \Exception Jika signature tidak valid
     */
    public function verifySignature(array $notification): void
    {
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';
        $signatureKey = $notification['signature_key'] ?? '';

        $serverKey = config('midtrans.server_key');

        $expectedSignature = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        // hash_equals mencegah timing attack saat membandingkan string
        if (! hash_equals($expectedSignature, $signatureKey)) {
            \Log::warning('Midtrans Webhook: Invalid signature key', [
                'order_id' => $orderId,
            ]);
            throw new \Exception('Invalid signature key');
        }
    }

    /**
     * Handle notifikasi dari Midtrans
     */
    public function handleNotification($notification)
    {
        $orderId = $notification['order_id'];
        $transactionStatus = $notification['transaction_status'];
        $paymentType = $notification['payment_type'] ?? null;
        $fraudStatus = $notification['fraud_status'] ?? null;

        \Log::info('Midtrans Notification', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
        ]);

        // Mapping status dari Midtrans ke status lokal aplikasi
        $status = $this->mapTransactionStatus($transactionStatus, $fraudStatus);

        return [
            'order_id' => $orderId,
            'status' => $status,
            'payment_type' => $paymentType,
        ];
    }

    /**
     * Map Midtrans transaction status ke status lokal
     */
    private function mapTransactionStatus($transactionStatus, $fraudStatus)
    {
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                return 'processing';
            } elseif ($fraudStatus == 'accept') {
                return 'success';
            }
        } elseif ($transactionStatus == 'settlement') {
            return 'success';
        } elseif ($transactionStatus == 'pending') {
            return 'pending';
        } elseif ($transactionStatus == 'deny') {
            return 'failed';
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            return 'cancelled';
        } elseif ($transactionStatus == 'refund') {
            return 'refunded';
        }

        return 'pending';
    }

    /**
     * Verify status transaksi langsung ke Midtrans (server-side check)
     */
    public function verifyTransaction($orderId)
    {
        try {
            $status = Transaction::status($orderId);

            return $status;
        } catch (\Exception $e) {
            \Log::error('Midtrans Verify Error: '.$e->getMessage());
            throw $e;
        }
    }
}
