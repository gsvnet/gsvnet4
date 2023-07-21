<?php

namespace App\Exports\Sheets;

use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ExMemberSheet implements FromCollection, WithHeadings, WithTitle {
    /**
     * Extract relevant user (profile) information to array
     * 
     * @param User $user
     * @return array
     */
    public function exMemberToCsv(User $user)
    {
        $hasProfile = ! empty($user->profile);
        $hasYearGroup = $hasProfile && ! empty($user->profile->yearGroup);

        return [
            $hasProfile ? $user->profile->initials : '',
            $user->firstname,
            $user->middlename,
            $user->lastname,
            $hasProfile ? $user->profile->present()->regionName : '',
            $hasYearGroup ? $user->profile->yearGroup->name : '',
            $hasYearGroup ? (int) $user->profile->yearGroup->year : '',
            $hasProfile ? $user->profile->present()->inaugurationDateSimple : '',
            $hasProfile ? $user->profile->present()->resignationDateSimple : '',
            $user->email,
            $user->username
        ];
    }

    /**
     * Return former member (non-reunist) collection
     *
     * Creates and returns a collection of users whose type is equal to UserTypeEnum::EXMEMBER.
     *
     * @return Collection
     **/
    public function collection()
    {
        return User::where('type', UserTypeEnum::EXMEMBER)
            ->get()
            ->map($this->exMemberToCsv(...));
    }

    /**
     * Return sheet headings
     *
     * @return string
     **/
    public function headings(): array
    {
        return [
            'Initialen', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Regio',
            'Jaarverband', 'Jaar van lidmaatschap', 'Inauguratiedatum', 
            'Bedankdatum', 'E-mail', 'Gebruikersnaam'
        ];
    }

    /**
     * Return sheet title
     *
     * @return string
     **/
    public function title(): string
    {
        return 'Oud-leden';
    }
}