<?php

namespace App\Console\Commands;

use App\Models\ApiUser;
use App\Util\QApiHandler;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to create a new Author on Q-test-API.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {        
        $credentials = [            
            'email' => $this->ask('Q-test-API email:', 'ahsoka.tano@q.agency'),
            'password' => $this->ask('Q-test-API password:', 'Kryze4President'),
        ];

        $handler = new QApiHandler();
        $token = $handler->attemptLogin($credentials)['token_key'];

        $data = [
            'first_name' => $this->ask('First name', 'Tomas'),
            'last_name' => $this->ask('Last name:', 'Martincic'),
            'birthday' => $this->ask('Birthday:', Carbon::now()),
            'gender' => $this->ask('Gender:', 'male'),
            'place_of_birth' => $this->ask('Place of birth:', 'Zagreb'),
            'biography' => $this->ask('biography', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),
        ];

        $handler->createAuthor($data, $token);

        return 0;
    }
}
