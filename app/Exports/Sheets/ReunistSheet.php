<?php

namespace App\Exports\Sheets;

use App\Models\User;
use GSVnet\Core\Enums\UserTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReunistSheet implements FromCollection, WithHeadings, WithTitle {
    /**
     * Extract relevant user (profile) information to array
     * 
     * @param User $user
     * @return array
     */
    public function reunistToCsv(User $user)
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
            $hasProfile ? $user->profile->present()->genderLocalized : '',
            $hasProfile ? $user->profile->birthdate : '',
            $hasProfile ? $user->profile->phone : '',
            $hasProfile ? $user->profile->address : '',
            $hasProfile ? $user->profile->zip_code : '',
            $hasProfile ? $user->profile->town : '',
            $hasProfile ? $user->profile->country : '',
            $hasProfile ? $user->profile->study : '',
            $hasProfile ? $user->profile->company : '',
            $hasProfile ? $user->profile->profession : '',
            $user->username
        ];
    }

    /**
     * Return former member (reunist) collection
     *
     * Creates and returns a collection of users whose type is equal to UserTypeEnum::REUNIST.
     *
     * @return Collection
     **/
    public function collection()
    {
        return User::where('type', UserTypeEnum::REUNIST)
            ->get()
            ->map($this->reunistToCsv(...));
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
            'Jaarverband', 'Jaar van lidmaatschap', 'Inauguratiedatum', 'Bedankdatum',
            'E-mail', 'Geslacht', 'Geboortedatum', 'Telefoon', 'Adres', 'Postcode',
            'Woonplaats', 'Land', 'Studie', 'Bedrijf', 'Functie', 'Gebruikersnaam'
        ];
    }

    /**
     * Return sheet title
     *
     * @return string
     **/
    public function title(): string
    {
        return 'Reünisten';
    }
}