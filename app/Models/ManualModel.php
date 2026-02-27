<?php
// app/Models/ManualModel.php
namespace App\Models;

use CodeIgniter\Model;

class ManualModel extends Model
{
    protected $table         = 'manuals';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'category_id','title','slug','description','short_desc',
        'price','cover_image','file_path','pages','language',
        'level','active','featured','downloads_count'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // ── Listado del portafolio con categoría ─────────────────
    public function getPortafolio(?string $category = null, ?string $level = null): array
    {
        $builder = $this->db->table('manuals m')
            ->select('m.*, c.name AS category_name, c.slug AS category_slug, c.icon AS category_icon')
            ->join('categories c', 'c.id = m.category_id')
            ->where('m.active', 1)
            ->orderBy('m.featured', 'DESC')
            ->orderBy('m.created_at', 'DESC');

        if ($category) {
            $builder->where('c.slug', $category);
        }
        if ($level) {
            $builder->where('m.level', $level);
        }

        return $builder->get()->getResultArray();
    }

    // ── Detalle de un manual por slug ────────────────────────
    public function getBySlug(string $slug): ?array
    {
        return $this->db->table('manuals m')
            ->select('m.*, c.name AS category_name, c.icon AS category_icon')
            ->join('categories c', 'c.id = m.category_id')
            ->where('m.slug', $slug)
            ->where('m.active', 1)
            ->get()->getRowArray();
    }

    // ── Manuales destacados para el home ─────────────────────
    public function getFeatured(int $limit = 6): array
    {
        return $this->db->table('manuals m')
            ->select('m.*, c.name AS category_name')
            ->join('categories c', 'c.id = m.category_id')
            ->where('m.active', 1)
            ->where('m.featured', 1)
            ->limit($limit)
            ->get()->getResultArray();
    }

    // ── Incrementar contador de descargas ────────────────────
    public function incrementDownload(int $id): void
    {
        $this->db->query("UPDATE manuals SET downloads_count = downloads_count + 1 WHERE id = ?", [$id]);
    }
}
