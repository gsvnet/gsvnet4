<?php namespace GSVnet\Users;

use App\Models\Senate;
use GSVnet\Core\Enums\UserTypeEnum;
use haampie\Gravatar\Gravatar;
use Laracasts\Presenter\Presenter;
use Carbon\Carbon;
use URL;

class UserPresenter extends Presenter
{

    public function fullName(): string
    {
        if (empty($this->entity->firstname) && empty($this->entity->middlename) && empty($this->entity->lastname))
            return 'onbekend';


        if (empty($this->entity->middlename)) {
            return $this->firstname . ' ' . $this->lastname;
        }

        return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
    }

    public function fullLastname(): string
    {
        $middlename = $this->middlename;

        if (empty($middlename))
            return $this->lastname;
        else
            return $this->middlename . ' ' . $this->lastname;
    }
    
    /**
     * Get function of user within a senate.
     * 
     * If $senate is null, will simply take the first senate it can find for the user.
     * @param \App\Models\Senate|null $senate
     * @return string
     */
    public function senateFunction(Senate $senate = null): string
    {
        $functions = config('gsvnet.senateFunctions');

        $senates = $this->entity->senates;

        if ($senates->isEmpty())
            return '';

        if (!is_null($senate)) {
            foreach ($senates as $possibleSenate) {
                if ($senate->id == $possibleSenate->id)
                    return $functions[$possibleSenate->pivot->function];
            }

            // Senate not found
            return '';
        }

        // If no specific senate was requested, just take the first one.
        $senate = $senates[0];
        return $functions[$senate->pivot->function];
    }

    public function registeredSince(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function membershipType()
    {
        $string = '';
        switch ($this->type) {
            case UserTypeEnum::VISITOR :
                $string .= 'Gast';
                break;
            case UserTypeEnum::POTENTIAL :
                $string .= 'Noviet';
                break;
            case UserTypeEnum::MEMBER:
                $string .= 'Lid';
                break;
            case UserTypeEnum::REUNIST:
                $string .= 'Reünist';
                break;
            case UserTypeEnum::EXMEMBER:
                $string .= 'Oud-lid';
                break;
            case UserTypeEnum::INTERNAL_COMMITTEE:
                $string .= 'Commissie';
                break;
            default:
                $string .= 'Onbekend';
                break;
        }

        return $string;
    }

    public function inCommiteeSince()
    {
        $since = Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->start_date);

        return $since->formatLocalized('%B %Y');
    }

    public function outCommiteeSince()
    {
        $since = Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->end_date);

        return $since->formatLocalized('%B %Y');
    }

    public function committeeFromTo()
    {
        $from = Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->start_date);

        $string = $from->formatLocalized("%Y");

        if (is_null($this->pivot->end_date)) {
            $string .= ' tot heden';
        } else {

            $to = Carbon::createFromFormat('Y-m-d H:i:s', $this->pivot->end_date);
            if ($to->isFuture()) {
                $string .= ' tot heden';
            } else {
                $string .= ' tot ';
                $string .= $to->formatLocalized("%Y");
            }
        }
        return $string;
    }

    // TODO: Create Gravatar class
    public function avatar($size = 120, $className = '')
    {
        return Gravatar::image($this->email, $size, 'mm', null, null, true);
        //return HTML::image($url, 'Avatar', ['width' => $size, 'height' => $size]);
    }

    // Let op: deze functie returned HTML, de functie hierboven returned een URL
    public function avatarDeferred($size = 120)
    {
        $url = Gravatar::image($this->email, $size, 'mm', null, null, true);
        return '<span class="img-wrap" data-gravatar-url="' . $url . '" data-gravatar-size="' . $size . '"></span>';
    }

    public function profileUrl()
    {
        return URL::action('UserController@showUser', [$this->id]);
    }
}