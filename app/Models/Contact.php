<?php

namespace App\Models;

use App\Models\Traits\Organisationable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasDefaultTenant;
use Filament\Models\Contracts\HasName;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

class Contact extends Authenticatable implements FilamentUser, HasName, HasTenants, HasDefaultTenant
{
    use HasFactory, SoftDeletes, Organisationable, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
        ];
    }

    public function fullName(): Attribute
    {
        return Attribute::make(function () {
            return $this->first_name . ' ' . $this->last_name;
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function dismissedAnnouncements(): BelongsToMany
    {
        return $this->belongsToMany(Announcement::class, 'dismissed_announcements', 'contact_id', 'announcement_id');
    }

    public function findLatestAnnouncement(): ?int
    {
        return Announcement::whereNotIn('id', function ($query) {
            $query->select('announcement_id')
                ->from('dismissed_announcements')
                ->where('contact_id', auth()->id());
        })->where('show_to_clients', true)->latest()->first()->id ?? null;
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return true;
    }

    public function getTenants(Panel $panel): array|Collection
    {
        return collect($this->organisation);
    }

    public function getDefaultTenant(Panel $panel): ?Model
    {
        return $this->organisation;
    }
}
