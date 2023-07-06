<?php

namespace App\Console\Commands;

use Aloha\Twilio\Twilio;
use App\EmailLog;
use App\MessageLog;
use App\Notifications\CustomEmailNotification;
use App\NotificationSchedules;
use App\UserMovingRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification to all user which have incoming jobs';

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
        $notificationSchedules = NotificationSchedules::all();
        foreach ($notificationSchedules as $notificationSchedule) {
            $date = Carbon::now()->addDays($notificationSchedule->days)->format('Y-m-d');
            $userMovingRequests = UserMovingRequest::with('User')
                ->where('status', '=', $notificationSchedule->status)
                ->where('booking_date', '=', $date)
                ->get();
            foreach ($userMovingRequests as $userMovingRequest) {
                $user = $userMovingRequest->user;
                if ($notificationSchedule->sms === 1){
                    if ($user->mobile != null){
                        $number = $user->mobile;
                        if (Str::startsWith($number, 0)) {
                            $number = substr($number, 1);
                        }
                        $number = "+1" . $number;
                        $message = $notificationSchedule->message;
                        $accountId = 'ACc5886f183282fbcace065280d142130f';
                        $token = '7f03c89f925819851bdf5873e99b3b29';
                        $fromNumber = '+16176558341';
                        $twilio = new Twilio($accountId, $token, $fromNumber);
                        $twilio->message($number, $message);
                        $options = [
                            "mobile" => $number,
                            "message" => $message
                        ];
                        try {
                            $messageLog = new MessageLog($options);
                            $messageLog->save();
                        } catch (Exception $exception) {
                        }
                    }
                }

                if ($notificationSchedule->email === 1){
                    if ($user->email != null){
                        $message = $notificationSchedule->message;
                        $user->notify(new CustomEmailNotification($message, []));
                        $options = [
                            "email" => $user->email,
                            "message" => $message
                        ];
                        try {
                            $emailLog = new EmailLog($options);
                            $emailLog->save();
                        } catch (Exception $exception) {
                        }
                    }
                }
            }
        }
        return true;
    }
}
