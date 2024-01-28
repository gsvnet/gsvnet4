<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePotentialRequest;
use App\Jobs\StorePotential;
use App\Models\UserProfile;
use GSVnet\Core\ImageHandler;
use GSVnet\Users\Profiles\ProfilesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct(
        private ProfilesRepository $profiles,
        private ImageHandler $imageHandler
    ) {}

    public function index()
    {
        return view('word-lid.index');
    }

    public function becomeMember()
    {
        return view('word-lid.word-lid');
    }

    public function becomeMemberIFrame()
    {
        return view('iframes.word-lid');
    }

    private function attemptLogin(Request $request)
    {
        // Set user if the user is or can be logged in
        $user = null;

        if (Auth::check() || Auth::attempt($request->only('email', 'password'))) {
            // Prevent session fixation
            $this->session()->regenerate();

            $user = Auth::user();
        }

        return $user;
    }

    /**
     * Store or promote to potential, then log user in.
     */
    public function store(StorePotentialRequest $request)
    {
        \Log::info('Potential wil lid worden', $request->except('password', 'password_confirmation'));

        // App\Models\User or null
        $user = $this->attemptLogin($request);

        StorePotential::dispatch($request, $user);

        // Log user in
        $this->attemptLogin($request);

        // Redirect to the become-member page which shows some congrats page
        return redirect()->action([$this::class, 'becomeMember']);
    }

    public function study()
    {
        return view('word-lid.study');
    }

    public function showCorona()
    {
        return view('word-lid.corona');
    }

    public function faq()
    {
        return view('word-lid.faq');
    }

    public function complaints()
    {
        return view('word-lid.complaints');
    }

    // Show original (resized) photo
    public function showPhoto(Request $request, UserProfile $profile, string $type = '')
    {
        $path = $this->imageHandler->getAbsolutePath($profile->photo_path, $type);

        return response()->file($path);
    }
}
