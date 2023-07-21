<?php

namespace App\Exports\Sheets;

use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class MemberSheet implements FromCollection, WithHeadings, WithTitle {
    /**
     * Extract relevant user (profile) information to array
     * 
     * @param User $user
     * @return array
     */
    public function memberToCsv(User $user)
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
            $user->email,
            $hasProfile ? $user->profile->present()->genderLocalized : '',
            $hasProfile ? $user->profile->birthdate : '',
            $hasProfile ? $user->profile->phone : '',
            $hasProfile ? $user->profile->address : '',
            $hasProfile ? $user->profile->zip_code : '',
            $hasProfile ? $user->profile->town : '',
            $hasProfile ? $user->profile->country : '',
            $hasProfile ? $user->profile->study : '',
            $hasProfile ? $user->profile->student_number : '',
            $hasProfile ? $user->profile->parent_phone : '',
            $hasProfile ? $user->profile->parent_address : '',
            $hasProfile ? $user->profile->parent_zip_code : '',
            $hasProfile ? $user->profile->parent_town : '',
            $user->username
        ];
    }

    /**
     * Return member collection
     *
     * Creates and returns a collection of users whose type is equal to UserTypeEnum::MEMBER.
     *
     * @return Collection
     **/
    public function collection()
    {
        return User::where('type', UserTypeEnum::MEMBER)
            ->get()
            ->map($this->memberToCsv(...));
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
            'E-mail', 'Geslacht', 'Geboortedatum', 'Telefoon', 'Adres', 'Postcode',
            'Woonplaats', 'Land', 'Studie', 'Studentnummer', 'Telefoon ouders',
            'Adres ouders', 'Postcode ouders', 'Woonplaats ouders', 'Gebruikersnaam'
        ];
    }

    /**
     * Return sheet title
     *
     * @return string
     **/
    public function title(): string
    {
        return 'Leden';
    }
}