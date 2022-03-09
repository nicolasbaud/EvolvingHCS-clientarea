<?php

namespace App\Console\Commands\Users;

use App\Models\User;
use Illuminate\Console\Command;

class CreateAdministratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:administrator';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new administrator';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        do {
            $details  = $this->askForUserDetails($details ?? null);
            $firstname = $details['firstname'];
            $lastname = $details['lastname'];
            $email = $details['email'];
            $tel = $details['tel'];
            $address = $details['address'];
            $region = $details['region'];
            $city = $details['city'];
            $postalcode = $details['postalcode'];
            $country = $details['country'];
            $password = $details['password'];
        } while (!$this->confirm("Create user {$firstname} {$lastname} <{$email}>?", true));

        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'role' => 'admin',
            'email' => $email,
            'tel' => $tel,
            'address' => $address,
            'region' => $region,
            'city' => $city,
            'postalcode' => $postalcode,
            'country' => $country,
            'password' => \Hash::make($password)
        ]);
        $this->info("Created new user #{$user->id}");
    }

    /**
     * @param null $defaults
     * @return array
     */
    protected function askForUserDetails($defaults = null)
    {
        $firstname = $this->ask('Prénom de l\'utilisateur ?', $defaults['firstname'] ?? null);
        $lastname = $this->ask('Nom de l\'utilisateur ?', $defaults['lastname'] ?? null);
        $tel = $this->ask('Téléphone de l\'utilisateur ?', $defaults['tel'] ?? null);
        $address = $this->ask('Adresse de l\'utilisateur ?', $defaults['address'] ?? null);
        $region = $this->ask('Région de l\'utilisateur ?', $defaults['region'] ?? null);
        $city = $this->ask('Ville de l\'utilisateur ?', $defaults['city'] ?? null);
        $postalcode = $this->ask('Code Postal de l\'utilisateur ?', $defaults['postalcode'] ?? null);
        $country = $this->ask('Pays de l\'utilisateur ?', $defaults['country'] ?? null);
        $email = $this->askUniqueEmail('Adresse email de l\'utilisateur ?', $defaults['email'] ?? null);
        $password = $this->ask('Mot de passe pour l\'utilisateur ? (sera visible)', $defaults['password'] ?? null);

        return compact('firstname', 'lastname', 'tel', 'address', 'region', 'city', 'postalcode', 'country', 'email', 'password');
    }

    /**
     * @param      $message
     * @param null $default
     * @return string
     */
    protected function askUniqueEmail($message, $default = null)
    {
        do {
            $email = $this->ask($message, $default);
        } while (!$this->checkEmailIsValid($email) || !$this->checkEmailIsUnique($email));

        return $email;
    }

    /**
     * @param $email
     * @return bool
     */
    protected function checkEmailIsValid($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('Sorry, "' . $email . '" is not a valid email address!');
            return false;
        }

        return true;
    }

    /**
     * @param $email
     * @return bool
     */
    public function checkEmailIsUnique($email)
    {
        if ($existingUser = User::whereEmail($email)->first()) {
            $this->error('Sorry, "' . $existingUser->email . '" is already in use by ' . $existingUser->name . '!');
            return false;
        }

        return true;
    }
}