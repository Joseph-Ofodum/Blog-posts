<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


//Method to create a delete expired tokens command from the database
class DeleteExpiredTokens extends Command
{
    protected $signature = 'app:delete-expired-tokens';
    protected $description = 'Delete expired personal access tokens';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now();
        DB::table('personal_access_tokens')->where('expires_at', '<', $now)->delete();

        $this->info('Expired tokens deleted successfully.');
}
}
