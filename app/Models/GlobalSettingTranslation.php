<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GlobalSettingTranslation extends Model
{
    protected $table = 'global_setting_translations';

    protected $fillable = [
        'global_setting_id',
        'language_id',
        'site_name',
        'site_description',
    ];

    public function globalSetting(): BelongsTo
    {
        return $this->belongsTo(GlobalSetting::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
