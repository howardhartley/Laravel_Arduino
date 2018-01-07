<?php

namespace App\Console\Commands;

use App\Log;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete inactive and not confirmed users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $conf_date = Carbon::now()->subDays(10);
        $act_date = Carbon::now()->subDays(20);
        $conf_users = User::where('confirmed', 0)->where('created_at', '<=', $conf_date)->get();
        $act_users = User::where('is_active', 0)->where('created_at', '<=', $act_date)->get();

        if(count($conf_users) > 0 || count($act_users) > 0){

            Log::create(['goodtobad' => '3',
                'note'      => 'Αυτοματοποιημένο μήνυμα. Έχουν διαγραφεί: '.count($act_users).' ανενεργοί χρήστες. '.count($conf_users).' μη επιβεβαιωμένοι χρήστες.',
                'user_id'   => 1]);

            $conf_users->delete();
            $act_users->delete();

        }
    }
}
