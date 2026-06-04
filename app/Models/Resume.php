<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Resume extends Model
{
    /** @use HasFactory<\Database\Factories\ResumeFactory> */
    use HasFactory;

    /**
     * Templates disponíveis e se cada um usa foto.
     * 5 sem foto + 5 com foto = 10 modelos.
     */
    public const TEMPLATES = [
        // sem foto
        'modern' => ['label' => 'Moderno', 'photo' => false],
        'classic' => ['label' => 'Clássico', 'photo' => false],
        'compact' => ['label' => 'Compacto', 'photo' => false],
        'minimal' => ['label' => 'Minimalista', 'photo' => false],
        'technical' => ['label' => 'Técnico', 'photo' => false],
        'executive' => ['label' => 'Executivo', 'photo' => false],
        // com foto
        'sidebar' => ['label' => 'Sidebar', 'photo' => true],
        'banner' => ['label' => 'Banner', 'photo' => true],
        'elegant' => ['label' => 'Elegante', 'photo' => true],
        'card' => ['label' => 'Cartão', 'photo' => true],
        'corporate' => ['label' => 'Corporativo', 'photo' => true],
    ];

    protected $fillable = [
        'user_id',
        'slug',
        'title',
        'template',
        'photo_path',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Resume $resume) {
            if (empty($resume->slug)) {
                $resume->slug = static::generateSlug();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** Usa o slug nas rotas em vez do id. */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Os templates que usam foto de perfil. */
    public static function templatesWithPhoto(): array
    {
        return array_keys(array_filter(self::TEMPLATES, fn ($t) => $t['photo']));
    }

    /** Este template usa foto? */
    public function usesPhoto(): bool
    {
        return self::TEMPLATES[$this->template]['photo'] ?? false;
    }

    /** URL pública da foto (ou null). */
    public function photoUrl(): ?string
    {
        return $this->photo_path ? asset('storage/'.$this->photo_path) : null;
    }

    /** Gera um slug curto e único para o link compartilhável. */
    public static function generateSlug(): string
    {
        do {
            $slug = Str::lower(Str::random(8));
        } while (static::where('slug', $slug)->exists());

        return $slug;
    }
}
