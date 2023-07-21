<?php

namespace App\Exports;

use App\Exports\Sheets\ExMemberSheet;
use App\Exports\Sheets\MemberSheet;
use App\Exports\Sheets\ReunistSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MembersExport implements WithMultipleSheets
{
    use Exportable;

    /**
    * @return array
    */
    public function sheets(): array
    {
        return [
            new MemberSheet(),
            new ReunistSheet(),
            new ExMemberSheet()
        ];
    }
}
