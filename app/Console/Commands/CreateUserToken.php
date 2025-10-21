<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-token {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new API token for a user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found.');
            return 1;
        }

        $token = $user->createToken('api-token');

        $this->info('User token:');
        $this->line($token->plainTextToken);

        return 0;
    }
}
