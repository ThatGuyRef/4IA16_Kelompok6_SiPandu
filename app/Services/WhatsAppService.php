<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected bool $enabled;
    protected ?string $token;
    protected ?string $phoneNumberId;
    protected Client $http;

    public function __construct(?Client $client = null)
    {
        $this->enabled = (bool) config('services.whatsapp.enabled', false);
        $this->token = config('services.whatsapp.token');
        $this->phoneNumberId = config('services.whatsapp.phone_number_id');
        $this->http = $client ?? new Client([
            'base_uri' => 'https://graph.facebook.com/',
            'timeout' => 10,
        ]);
    }

    public function isConfigured(): bool
    {
        return $this->enabled && !empty($this->token) && !empty($this->phoneNumberId);
    }

    public function sendMessage(?string $to, string $message): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('WhatsApp not configured or disabled; skipping send.');
            return false;
        }
        $to = $this->normalizePhone($to);
        if (!$to) {
            Log::warning('WhatsApp send skipped: invalid or empty recipient phone.');
            return false;
        }
        try {
            $endpoint = sprintf('v19.0/%s/messages', $this->phoneNumberId);
            $resp = $this->http->post($endpoint, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'messaging_product' => 'whatsapp',
                    'to' => $to,
                    'type' => 'text',
                    'text' => [ 'body' => $message ],
                ],
            ]);
            $code = $resp->getStatusCode();
            if ($code >= 200 && $code < 300) {
                Log::info('WhatsApp message sent', ['to' => $to]);
                return true;
            }
            Log::error('WhatsApp API non-2xx response', ['status' => $code]);
            return false;
        } catch (\Throwable $e) {
            Log::error('WhatsApp send failed: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }

    protected function normalizePhone(?string $phone): ?string
    {
        if (!$phone) return null;
        // remove non-digits
        $digits = preg_replace('/\D+/', '', $phone);
        if (!$digits) return null;
        // Handle Indonesian numbers: 08xxxx -> 628xxxx, +62 -> 62
        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        }
        // already starts with country code, keep as-is
        return $digits;
    }
}
