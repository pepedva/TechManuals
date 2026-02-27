<?php
// app/Models/DownloadTokenModel.php
namespace App\Models;

use CodeIgniter\Model;

class DownloadTokenModel extends Model
{
    protected $table         = 'download_tokens';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['order_id','token','expires_at','used','used_at','ip_address'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = false;

    /**
     * Crea un token único de descarga que expira en N horas.
     */
    public function createToken(int $orderId, int $hoursValid = 24): string
    {
        $token = bin2hex(random_bytes(32)); // 64 chars hex
        $expires = date('Y-m-d H:i:s', strtotime("+{$hoursValid} hours"));

        $this->insert([
            'order_id'   => $orderId,
            'token'      => $token,
            'expires_at' => $expires,
            'used'       => 0,
        ]);

        return $token;
    }

    /**
     * Valida el token: existe, no usado y no expirado.
     * Retorna la fila o null si no es válido.
     */
    public function validateToken(string $token): ?array
    {
        return $this->where('token', $token)
                    ->where('used', 0)
                    ->where('expires_at >=', date('Y-m-d H:i:s'))
                    ->first();
    }

    /**
     * Marca el token como usado (descarga realizada).
     */
    public function markUsed(string $token, string $ip = ''): void
    {
        $this->where('token', $token)->set([
            'used'    => 1,
            'used_at' => date('Y-m-d H:i:s'),
            'ip_address' => $ip,
        ])->update();
    }
}
