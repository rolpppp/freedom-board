<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\ProfileUpdateRequest;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Redirect;
    use Illuminate\View\View;

    class ProfileController extends Controller
    {
        // Handle logout
        public function logout(Request $request)
        {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }
        // Show login form
        public function showLogin()
        {
            return view('auth.login');
        }

        // Handle login
        public function login(Request $request)
        {
            $credentials = $request->only('username', 'password');
            // Debug: Show credentials being used
            \Log::debug('Login attempt', $credentials);
            $user = \App\Models\User::where('username', $credentials['username'])->first();
            if (!$user) {
                \Log::debug('No user found with username', ['username' => $credentials['username']]);
                return back()->with('error', 'No user found with that username.')->withInput();
            }
            // Debug: Show hashed password in DB
            \Log::debug('User found', ['username' => $user->username, 'hashed_password' => $user->password]);
            if (\Hash::check($credentials['password'], $user->password)) {
                \Log::debug('Password matches for user', ['username' => $user->username]);
            } else {
                \Log::debug('Password does NOT match for user', ['username' => $user->username]);
            }
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                \Log::debug('Login successful, redirecting...');
                return redirect()->intended(route('posts.index'));
            }
            \Log::debug('Login failed for user', ['username' => $credentials['username']]);
            return back()->with('error', 'Invalid username or password.')->withInput();
        }

        // Show register form
        public function showRegister()
        {
            return view('auth.register');
        }

        // Handle registration
        public function register(Request $request)
        {
            $request->validate([
                'username' => 'required|string|min:3|max:255|unique:users,username',
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user = \App\Models\User::create([
                'username' => $request->username,
                'password' => \Hash::make($request->password),
            ]);
            Auth::login($user);
            return redirect()->route('posts.index');
        }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }


    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
