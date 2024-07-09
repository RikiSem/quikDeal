<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const FIELDS = [
        'header' => 'header',
        'description' => 'description',
        'status' => 'status',
        'deadline' => 'deadline',
    ];

    public function setHeader(string $header): self
    {
        return $this->setAttribute('header', $header);
    }

    public function setDescription(string $description): self
    {
        return $this->setAttribute('description', $description);
    }

    public function setStatus(string $status): self
    {
        return $this->setAttribute('status', $status);
    }

    public function setDeadline(string $deadline): self
    {
        return $this->setAttribute('deadline', Carbon::createFromTimestamp($deadline));
    }
}
