<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Deck;
use App\Models\Card;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@studyflip.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $demo = User::create([
            'name'     => 'Demo Student',
            'email'    => 'demo@studyflip.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        $deck1 = Deck::create([
            'user_id'     => $demo->id,
            'title'       => 'PHP Basics',
            'description' => 'Core PHP concepts for beginners',
            'color'       => 'blue',
        ]);

        $phpCards = [
            ['What does PHP stand for?',              'PHP: Hypertext Preprocessor (recursive acronym)', 'It\'s recursive!'],
            ['How do you declare a variable in PHP?', 'Use the $ symbol. Example: $name = "John";',      'Dollar sign'],
            ['What function outputs text in PHP?',    'echo or print can both output text.',              'Most common: echo'],
            ['How do you start a PHP block?',         'Use the opening tag: <?php',                       'Don\'t forget the opening tag'],
            ['What is a PHP array?',                  'A variable that can store multiple values.',        'Like a list'],
        ];

        foreach ($phpCards as [$front, $back, $hint]) {
            Card::create(['deck_id' => $deck1->id, 'front' => $front, 'back' => $back, 'hint' => $hint]);
        }

        $deck2 = Deck::create([
            'user_id'     => $demo->id,
            'title'       => 'Laravel Concepts',
            'description' => 'Key Laravel framework concepts',
            'color'       => 'red',
        ]);

        $laravelCards = [
            ['What is MVC?',                          'Model-View-Controller - a design pattern separating concerns.',          'Separation of concerns'],
            ['What is Eloquent ORM?',                 'Laravel\'s built-in ActiveRecord ORM for database interaction.',          'Object-Relational Mapping'],
            ['What is a Laravel Migration?',          'A version control system for your database schema.',                      'Like git for your DB'],
            ['What does artisan serve do?',           'Starts the Laravel development server on localhost:8000.',               'php artisan serve'],
            ['What is a Blade template?',             'Laravel\'s templating engine with @directives like @if, @foreach, etc.', '@extends, @section'],
        ];

        foreach ($laravelCards as [$front, $back, $hint]) {
            Card::create(['deck_id' => $deck2->id, 'front' => $front, 'back' => $back, 'hint' => $hint]);
        }

        $this->command->info('Seeded: admin@studyflip.com / demo@studyflip.com (both password: "password")');
    }
}
