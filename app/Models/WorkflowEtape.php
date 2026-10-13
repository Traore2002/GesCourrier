<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowEtape extends Model
{
    use HasFactory;

    protected $fillable = ['workflow_id', 'ordre', 'role_nom', 'action_requise'];

    public function workflow()
    {
        return $this->belongsTo(Workflow::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_nom', 'nom');
    }
}