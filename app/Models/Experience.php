<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'company_name',
        'company_logo',
        'role_title',
        'start_date',
        'end_date',
        'is_current',
        'location',
        'employment_type',
        'description',
        'responsibilities',
        'media_images',
        'display_order',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
        'responsibilities' => 'array',
        'media_images' => 'array',
        'display_order' => 'integer',
    ];

    /**
     * Get formatted date range
     */
    public function getDateRangeAttribute()
    {
        $start = $this->start_date instanceof \Carbon\Carbon ? $this->start_date : \Carbon\Carbon::parse($this->start_date);
        $startFormatted = $start->format('M Y');
        $end = $this->is_current ? 'Present' : ($this->end_date ? (\Carbon\Carbon::parse($this->end_date)->format('M Y')) : 'Present');
        return $startFormatted . ' - ' . $end;
    }

    /**
     * Get duration in years and months
     */
    public function getDurationAttribute()
    {
        $start = $this->start_date instanceof \Carbon\Carbon ? $this->start_date : \Carbon\Carbon::parse($this->start_date);
        $end = $this->is_current ? now() : ($this->end_date ? (\Carbon\Carbon::parse($this->end_date)) : now());
        $diff = $start->diff($end);
        $years = $diff->y;
        $months = $diff->m;
        
        $duration = [];
        if ($years > 0) {
            $duration[] = $years . ' ' . ($years == 1 ? 'yr' : 'yrs');
        }
        if ($months > 0) {
            $duration[] = $months . ' ' . ($months == 1 ? 'm' : 'm');
        }
        
        return implode(', ', $duration) ?: 'Less than 1 m';
    }

    /**
     * Scope for active experiences
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered experiences
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('start_date', 'desc');
    }
}
