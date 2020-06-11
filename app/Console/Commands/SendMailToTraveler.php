<?php

namespace App\Console\Commands;

use App\trips;
use Illuminate\Console\Command;
use App\Http\Controllers\MailController;
use Illuminate\Support\Carbon;
class SendMailToTraveler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trips:sendToTravelers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send mail to users which will travel after two days';

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
        $expDate = date('Y-m-d',strtotime('+1 days'));
        $today = date('Y-m-d',strtotime(now()));
        $trips=trips::where('status','active')->whereDate('start_at', $expDate)->get();
        $i=0;
        if($trips){
            foreach ($trips as $trip){
                $message='We send you an email to remind you of the trip date is : '.$trip->start_at.' .
                         for full trip details ';
                $url=\route('users.tripDetails',['trip_id'=>$trip->id]);
                $usersJoined=\App\userTrips::where('trip_id',$trip->id)->get();
                if($usersJoined){
                    foreach ($usersJoined as $user){
                        $user=\App\User::find($user->user_id);
                        MailController::sendEmail($user,$url,'remember your safari trip',$message);
                        $i++;
                    }
                }
            }


        }
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($i." founded traveler");
    }
}
