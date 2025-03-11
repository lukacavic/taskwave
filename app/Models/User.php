<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Traits\Organisationable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasFactory, Notifiable, Organisationable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
        'password',
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

    public function fullName(): Attribute
    {
        return Attribute::make(function () {
            return $this->first_name . ' ' . $this->last_name;
        });
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'user_id')->whereDoes;
    }

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class, 'link_project_users', 'user_id', 'project_id');
    }

    public function dismissedAnnouncements(): BelongsToMany
    {
        return $this->belongsToMany(Announcement::class, 'dismissed_announcements', 'user_id', 'announcement_id');
    }

    public function findLatestAnnouncement(): ?int
    {
        return Announcement::whereNotIn('id', function ($query) {
            $query->select('announcement_id')
                ->from('dismissed_announcements')
                ->where('user_id', auth()->id());
        })->where('show_to_users', true)->latest()->first()->id ?? null;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->projects()->exists($tenant);
    }

    public function getTenants(Panel $panel): array|Collection
    {
        return $this->projects;
    }
}
