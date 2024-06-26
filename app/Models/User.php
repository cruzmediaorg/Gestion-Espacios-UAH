<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\CustomRelationship;
use App\Helper\RelateToAll;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;


/**
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $tipo
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, CustomRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'sid',
        'email',
        'password',
        'tipo'
    ];

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

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.'.$this->id;
    }

    /**
     * Obtiene los cursos donde es docente.
     * @return BelongsToMany|RelateToAll
     */
    public function cursos(): BelongsToMany|RelateToAll
    {
        if ($this->hasRole('Administrador')) {
            return $this->relatoToAll(Curso::class);
        }

        return $this->belongsToMany(Curso::class, 'curso_docente', 'docente_id', 'curso_id');
    }

    /**
     * Obtiene los permisos que tiene el usuario
     */
    protected function permisos(): Attribute
    {
        return Attribute::make(
            get: function () {
                return $this->getAllPermissions();
            }
        );
    }

    /**
     * Obtiene la lista de usuarios, según el tipo de usuario
     */

    public function scopeSegunUsuario(Builder $query): void
    {
        auth()->user()->hasRole('Administrador') ? $query : $query->where('id', auth()->id());
    }
}
