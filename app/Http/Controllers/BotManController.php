<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Incoming\Answer;
use App\Models\Cauhoi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    // public function handle()
    // {
    //     $botman = app('botman');

    //     $botman->hears('{message}', function ($botman, $message) {

    //         if ($message == 'hi') {
    //             $this->askName($botman);
    //         } else {
    //             $botman->reply("write 'hi' for testing...");
    //         }
    //     });

    //     $botman->listen();
    // }

    // /**
    //  * Place your BotMan logic here.
    //  */
    // public function askName($botman)
    // {
    //     $botman->ask('Hello! What is your Name?', function (Answer $answer) {

    //         $name = $answer->getText();

    //         $this->say('Nice to meet you ' . $name);
    //     });
    // }
    public $data=[];
    private $cauhoi;

    public function __construct()
    {
        $this->cauhoi = new Cauhoi();
    }
    
    
   
    public function handle() {
        $botman = app('botman');

   
        $botman->hears('{message}', function($botman, $message) {
            
            $mess = mb_strtolower($message, 'UTF-8');
            $b = DB::table('cauhoi')->get();
            //tạo mảng lưu danh sách tỉ lệ giống
            foreach ($b as $items){
                $query = $items->ten;
                $q = mb_strtolower($query, 'UTF-8');
                $a = perc(create_slug($mess),create_slug($q));
                $perc_same [] = $a;
            }
            foreach ($b as $items){
                $query = $items->ten;
                $q = mb_strtolower($query, 'UTF-8');
                $b = perc(create_slug($mess), create_slug($q));
                $same [] = $b;

                if((max($same) == max($perc_same)) && max($perc_same)!=0 && ($b>=0.5)){//
                    $mess = $items->ten;
                    break;
                }

            }

            $traloi = DB::table('cauhoi')->where('ten', $mess )->value('traloi');
            
        if(!empty($traloi)){
            $date = strtotime(date("Y-m-d"));
            $ma_cauhoi = DB::table('cauhoi')->where('ten', $mess )->value('ma');
            $luothoi = DB::table('luothoi')->where('ma_cauhoi', $ma_cauhoi )->where('ngay', $date )->value('luothoi');
            
            if($luothoi>0){
                DB::table('luothoi')->where('ma_cauhoi', $ma_cauhoi )->where('ngay', $date )
                ->update(['luothoi' => $luothoi+1]);
            }else{
                DB::table('luothoi')->insert([
                    'ma_cauhoi' => $ma_cauhoi,
                    'ngay' => $date,
                    'luothoi' =>1,
                ]);
            }

            $botman->reply('Có phải bạn muốn hỏi về '.$mess);
            $botman->reply($traloi);

        }
        else{
            $botman->reply('Tôi không có thông tin câu trả lời cho câu hỏi của bạn');

           if( Auth::user() ){
            $co_phanhoi = DB::table('phanhoi')->where('ten', $mess )->value('ma');
            if($co_phanhoi>0){
                $botman->reply('Câu hỏi của bạn đã có trong danh sách phản hồi!');

            }else{
                DB::table('phanhoi')->insert([
                    'ten' => $message,
                    'ma_user' => Auth::user()->id,
                    'ngay_phanhoi' => strtotime(date("Y-m-d H:i:s")),
                ]);
                $botman->reply('Câu hỏi của bạn sẽ được đưa vào danh sách phản hồi!');
            }
           }else{
            $botman->reply('Bạn cần phải đăng nhập để phản hồi này được gửi!');
           }
        }
   
        });
   
        $botman->listen();
}
}