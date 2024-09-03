<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResources extends JsonResource
{
    public $success;
    // public $status;
    public $message;
    public $resource;

    public function __construct($success, $message, $resource, $status = 200)
    {
        parent::__construct($resource);
        $this->success  = $success;
        $this->message = $message;
        // $this->status = $status;
    }

    public function toArray(Request $request): array
    {
        return [
            'success'   => $this->success,
            // 'status'      => $this->status,
            'message'   => $this->message,
            'data'      => $this->resource
        ];
    }
}
