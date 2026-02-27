<?php
// app/Models/OrderModel.php
namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id','manual_id','paypal_order_id','paypal_transaction_id',
        'amount','currency','status','buyer_email'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ── Compras de un usuario con datos del manual ───────────
    public function getUserPurchases(int $userId): array
    {
        return $this->db->table('orders o')
            ->select('o.*, m.title, m.cover_image, m.slug, dt.token, dt.expires_at, dt.used')
            ->join('manuals m', 'm.id = o.manual_id')
            ->join('download_tokens dt', 'dt.order_id = o.id', 'left')
            ->where('o.user_id', $userId)
            ->where('o.status', 'completed')
            ->orderBy('o.created_at', 'DESC')
            ->get()->getResultArray();
    }

    // ── Verificar si usuario ya compró un manual ─────────────
    public function hasPurchased(int $userId, int $manualId): bool
    {
        return $this->where('user_id', $userId)
                    ->where('manual_id', $manualId)
                    ->where('status', 'completed')
                    ->countAllResults() > 0;
    }
}
