<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\Html\Editor\Fields\BelongsTo;

class SafesTransaction extends Model
{
    use HasFactory;

    protected $guarded = array('id');
    protected $table = 'safes_transactions';
    protected $appends = ['type'];

    public function safable()
    {
        return $this->morphTo();
    }

    public function safe()
    {
        return $this->belongsTo(Safe::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function getTypeAttribute()
    {
        return $this->safable_type == Invoice::class ? 'invoice' : 'expense';

    }
}
