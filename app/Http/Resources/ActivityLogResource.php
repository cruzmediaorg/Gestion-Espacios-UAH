<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

/** @mixin Activity */
class ActivityLogResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'log_name' => ucwords($this->log_name),
            'description' => $this->description,
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'causer_type' => $this->causer_type,
            'causer_id' => $this->causer_id,
            'causer' => $this->causer_id ? User::find($this->causer_id)->name : null,
            'event' => $this->event,
            'batch_uuid' => $this->batch_uuid,
            'properties' => $this->properties,
            'created_at' => $this->created_at,
            'created_at_human' => $this->created_at->diffForHumans(), // '1 hour ago
            'updated_at' => $this->updated_at,
            'more_info_url' => $this->generarUrl(),
        ];
    }

    /**
     * Genera la URL para obtener más información sobre el log.
     * En casos cuando el log_name sea "login" o "logout", no se generará la URL.
     * @return string|null
     */
    private function generarUrl(): ?string
    {

        if ($this->log_name === 'login' || $this->log_name === 'logout') {
            return null;
        }

        if ($this->event === 'deleted') {
            return null;
        }

        $recordExists = $this->subject_type::where('id', $this->subject_id)->exists();

        if (!$recordExists) {
            return null;
        }

        $prefix = $this->subject_type::ROUTE_PREFIX;

        if ($prefix) {
            return route($prefix . '.edit', $this->subject_id);
        } else {
            return null;
        }
    }
}
