<?php

namespace App\Http\Controllers;

use GSVnet\Files\FileHandler;
use Illuminate\Http\Request;

class PublicFilesController extends Controller
{
    // Perhaps this has to be coupled to the FilesRepository somewhere in the future. For now, this suffices.
    public function showPrivacyStatement(FileHandler $fileHandler)
    {
        return $fileHandler->download(
            "/app/Privacy Statement GSV.pdf", "Privacy Statement GSV.pdf");
    }
}
