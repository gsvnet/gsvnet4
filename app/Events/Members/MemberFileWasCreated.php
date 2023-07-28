<?php

namespace App\Events\Members;

use Carbon\Carbon;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MemberFileWasCreated {
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Carbon instance for when the event was created.
     * @var Carbon
     */
    private $at;

    /**
     * Path to where member file was created
     * @var string
     */
    private $filePath;

    /**
     * Create event with path to file.
     * @param string $filePath
     */
    public function __construct($filePath)
    {
        $this->at = Carbon::now();
        $this->filePath = $filePath;
    }

    public function getAt(): Carbon
    {
        return $this->at;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }
}