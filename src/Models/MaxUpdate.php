<?php

namespace VioletSun\MAX\Models;

use Illuminate\Database\Eloquent\Model;
use VioletSun\MAX\Enums\UpdateProcessingEnum;
use VioletSun\MAX\Enums\UpdateTypeEnum;

/**
 * @property UpdateTypeEnum $type
 * @property int $chat_id
 * @property int $user_id
 * @property array $data
 * @property UpdateProcessingEnum $processing
 */
class MaxUpdate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'chat_id',
        'user_id',
        'data',
        'processing',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => UpdateTypeEnum::class,
            'data' => 'array',
            'processing' => UpdateProcessingEnum::class,
        ];
    }

    public static function boot(): void
    {
        parent::boot();
        self::creating(function (MaxUpdate $model) {
            if (empty($model->data)) {
                $model->data = [];
            }
        });
    }

    public function maxUser()
    {
        return $this->hasOne(MaxUser::class, '', 'user_id');
    }
}
