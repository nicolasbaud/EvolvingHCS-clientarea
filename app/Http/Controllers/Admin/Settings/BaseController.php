<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Commands\EnvironmentWriterTrait;
use App\Models\Setting;
use Illuminate\Support\Facades\Artisan;

class BaseController extends Controller
{
    use EnvironmentWriterTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.settings.base');
    }

    public function update(Request $request)
    {
        if (config('app.name') != $request->APP_NAME) {
            if (Setting::where('key', 'APP_NAME')->count() == '0') {
                Setting::create(['key' => 'APP_NAME', 'value' => $request->APP_NAME]);
            }
        }
        if (config('app.url') != $request->APP_URL) {
            if (Setting::where('key', 'APP_URL')->count() == '0') {
                Setting::create(['key' => 'APP_URL', 'value' => $request->APP_URL]);
            }
        }
        if (config('mail.mailers.smtp.host') != $request->MAIL_HOST) {
            if (Setting::where('key', 'MAIL_HOST')->count() == '0') {
                Setting::create(['key' => 'MAIL_HOST', 'value' => $request->MAIL_HOST]);
            }
        }
        if (config('mail.mailers.smtp.port') != $request->MAIL_PORT) {
            if (Setting::where('key', 'MAIL_PORT')->count() == '0') {
                Setting::create(['key' => 'MAIL_PORT', 'value' => $request->MAIL_PORT]);
            }
        }
        if (config('mail.mailers.smtp.encryption') != $request->MAIL_ENCRYPTION) {
            if (Setting::where('key', 'MAIL_ENCRYPTION')->count() == '0') {
                Setting::create(['key' => 'MAIL_ENCRYPTION', 'value' => $request->MAIL_ENCRYPTION]);
            }
        }
        if (config('mail.mailers.smtp.username') != $request->MAIL_USERNAME) {
            if (Setting::where('key', 'MAIL_USERNAME')->count() == '0') {
                Setting::create(['key' => 'MAIL_USERNAME', 'value' => $request->MAIL_USERNAME]);
            }
        }
        if (config('mail.mailers.smtp.password') != $request->MAIL_PASSWORD) {
            if (Setting::where('key', 'MAIL_PASSWORD')->count() == '0') {
                Setting::create(['key' => 'MAIL_PASSWORD', 'value' => $request->MAIL_PASSWORD]);
            }
        }

        return redirect(route('admin.settings'))->with('success', 'Paramètres édités, veuillez patienter 1 minute afin de les voir apparaitre.');
    }
}
