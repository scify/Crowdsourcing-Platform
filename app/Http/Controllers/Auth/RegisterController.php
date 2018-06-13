<?php

namespace App\Http\Controllers\Auth;

use App\Models\Category;
use App\Models\CMS;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    // TODO: move to cms data layer manager
    protected static $defaultCmsCategories = [
        'Politics' => 'politics', 'Economy' => 'economy', 'International News' => 'international-news',
        'Society' => 'society', 'Sports' => 'sports', 'Lifestyle' => 'lifestyle'
    ];

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', 'string', Rule::in(['journalist', 'publisher'])],
            'cms_name' => 'required_if:role,publisher|regex:/[A-Za-z0-9- ]+/|unique:cms,name',
            'cms' => 'required_if:role,publisher|regex:/[a-z0-9-]+/|unique:cms,system_name',
            'logo' => 'required_if:role,publisher|image'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $this->storeUserRole($data, $user);
        return $user;
    }

    private function storeUserRole($data, $user) {
        // 4 is the journalist's role id in DB and 2 is for publisher
        $role_id = $data['role'] === 'journalist' ? 4 : 2;
        $cmsId = 1; // news central
        if ($role_id === 2)
            $cmsId = $this->storeCms($data, $user);
        $userRole = new UserRole;
        $userRole->user_id = $user->id;
        $userRole->cms_id = $cmsId;
        $userRole->role_id = $role_id;
        $userRole->save();
        return $role_id;
    }

    private function storeCms($data, $user) {
        $file = $data['logo'];
        $file->store('cms/logos', 'public');
        $filePath = '/storage/cms/logos/' . $file->hashName();
        $cms = new CMS;
        $cms->name = $data['cms_name'];
        $cms->system_name = $data['cms'];
        $cms->logo_path = $filePath;
        $cms->save();
        $this->storeCmsCategories($cms, $user);
        return $cms->id;
    }

    private function storeCmsCategories($cms, $user) {
        foreach (self::$defaultCmsCategories as $defaultCategoryName => $defaultCategorySlug) {
            $articleCategory = new Category;
            $articleCategory->name = $defaultCategoryName;
            $articleCategory->slug = $defaultCategorySlug;
            $articleCategory->cms_id = $cms->id;
            $articleCategory->user_creator_id = $user->id;
            $articleCategory->save();
        }
    }
}
