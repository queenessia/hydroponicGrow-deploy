<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PasswordReset extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'email';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'created_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Scope untuk mencari berdasarkan email
     */
    public function scopeByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    /**
     * Scope untuk mencari berdasarkan token
     */
    public function scopeByToken($query, $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Cek apakah token sudah expired
     */
    public function isExpired($hours = 24)
    {
        return Carbon::parse($this->created_at)->addHours($hours)->isPast();
    }

    /**
     * Hapus token yang sudah expired
     */
    public static function deleteExpired($hours = 24)
    {
        return static::where('created_at', '<', Carbon::now()->subHours($hours))->delete();
    }

    /**
     * Buat atau update token reset password
     */
    public static function createToken($email, $token)
    {
        return static::updateOrCreate(
            ['email' => $email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
    }

    /**
     * Override delete method untuk menggunakan email sebagai key
     */
    public function delete()
    {
        if (is_null($this->getKeyName())) {
            throw new Exception('No primary key defined on model.');
        }

        // Use email as the key for deletion
        return $this->newQuery()
            ->where('email', $this->email)
            ->delete();
    }
}