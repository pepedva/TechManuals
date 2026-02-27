<?php
// app/Models/UserModel.php
namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['name','email','password','avatar','provider','provider_id','email_verified','role'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // ── Buscar por email ─────────────────────────────────────
    public function findByEmail(string $email): ?array
    {
        return $this->where('email', $email)->first();
    }

    // ── Buscar o crear usuario OAuth ─────────────────────────
    public function findOrCreateOAuth(array $data): array
    {
        $user = $this->where('provider', $data['provider'])
                     ->where('provider_id', $data['provider_id'])
                     ->first();

        if ($user) {
            // Actualizar nombre y avatar si cambiaron
            $this->update($user['id'], [
                'name'   => $data['name'],
                'avatar' => $data['avatar'] ?? $user['avatar'],
            ]);
            return $this->find($user['id']);
        }

        // Verificar si ya existe el email con otro proveedor
        $byEmail = $this->findByEmail($data['email']);
        if ($byEmail) {
            $this->update($byEmail['id'], [
                'provider'    => $data['provider'],
                'provider_id' => $data['provider_id'],
                'avatar'      => $data['avatar'] ?? $byEmail['avatar'],
            ]);
            return $this->find($byEmail['id']);
        }

        // Crear nuevo usuario
        $id = $this->insert([
            'name'           => $data['name'],
            'email'          => $data['email'],
            'avatar'         => $data['avatar'] ?? null,
            'provider'       => $data['provider'],
            'provider_id'    => $data['provider_id'],
            'email_verified' => 1,
            'role'           => 'user',
        ]);

        return $this->find($id);
    }
}
