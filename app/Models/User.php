<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// Import model Appointment agar relasi bisa dideteksi
use App\Models\Appointment; 

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'telepon', // Diubah dari 'phone' menjadi 'telepon' agar sesuai dengan form registrasi yang disajikan
        'alamat',  
        'role',
        'profile_picture',
    ];
    // Jika kolom di database Anda menggunakan bahasa Inggris, gunakan:
    /*
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone', // Jika kolom database Anda adalah 'phone'
        'address', // Jika kolom database Anda adalah 'address'
        'role',
        'profile_picture',
    ];
    */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // --- RELATIONS (Hubungan) ---

    /**
     * Get the appointments for the user.
     * Pengguna memiliki banyak janji temu (one-to-many relationship)
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'user_id', 'id');
        // Secara eksplisit mendefinisikan foreign key (user_id) dan local key (id)
    }

    // --- HELPER METHODS (Metode Pembantu) ---
    
    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is customer (default role).
     */
    public function isCustomer(): bool
    {
        // Secara default, jika bukan admin, anggap sebagai customer atau pastikan role adalah 'customer'
        return $this->role === 'customer';
        // Atau jika hanya ada 2 role: return !$this->isAdmin();
    }
}