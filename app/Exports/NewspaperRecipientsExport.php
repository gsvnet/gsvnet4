<?php

namespace App\Exports;

use App\Models\User;
use GSVnet\Users\UsersRepository;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NewspaperRecipientsExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct(
        private UsersRepository $users
    ) {}

    private function recipientToCsv(User $user)
    {
        $hasProfile = ! empty($user->profile);

        return [
            $hasProfile ? $user->profile->initials : '',
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $hasProfile ? $user->profile->present()->genderLocalized : '',
            $hasProfile ? $user->profile->address : '',
            $hasProfile ? $user->profile->zip_code : '',
            $hasProfile ? $user->profile->town : '',
            $hasProfile ? $user->profile->country : '',
        ];
    }

    public function collection(): Collection
    {
        $recipients = $this->users->getSICRecipients()->sortBy(function (User $user) {
            return $user->profile->zip_code;
        });

        return $recipients->map($this->recipientToCsv(...));
    }

    public function headings(): array
    {
        return [
            'Initialen', 'Voornaam', 'Tussenvoegsel', 'Achternaam',
            'Geslacht', 'Adres', 'Postcode', 'Woonplaats', 'Land'
        ];
    }
}
