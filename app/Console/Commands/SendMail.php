<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Mailgun\Mailgun;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a mail to  user on specific day';

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
        //
        $email_array = [];
        $template = DB::table('mail_templates')

            ->selectRaw('template_id,from_email,template_subject,template')

            ->get();

        
        $booking_details = DB::table('booking_form')
                        ->join('booking_personal_info', 'booking_personal_info.booking_id', '=', 'booking_form.booking_id')
                        ->select('booking_form.booking_date as booking_date', 'booking_personal_info.email as email','booking_form.booking_id as booking_id')
                        ->where('booking_form.status','pending')
                        ->get();


            foreach ($template as $tempkey) {
                # code...
                foreach ($booking_details as $bookingkey) {
                    # code...
                    if($tempkey->template_id!=0 && $tempkey->template_id!=100){

                        if(date("Y-m-d")==date('Y-m-d', strtotime('-'.$tempkey->template_id.' day', strtotime($bookingkey->booking_date))) && !in_array($bookingkey->booking_id, $email_array)){
                            $this->info($bookingkey->booking_id);
                            array_push($email_array, $bookingkey->booking_id);
                            $this->info(print_r($email_array));
                            $mgClient = Mailgun::create(env('MAIL_GUN_PRIVATE'));
                            $domain = env('MAIL_GUN_DOMAIN');
                                $params = array(
                                    'from'    => $tempkey->from_email,
                                    'to'      => $bookingkey->email,
                                    'subject' => $tempkey->template_subject,
                                    'html'    => $tempkey->template 
                                );

                            # Make the call to the client.
                            $mgClient->messages()->send($domain, $params);
                        }
                
                    }

   
                }
            }

    }
}
