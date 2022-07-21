<?php

namespace App\Console\Commands;

use App\Models\NurseLang;
use Illuminate\Console\Command;

class SetDefaultLang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'default:nurse_lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update lang in nurse langs table to english lang level A1';

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
     * @return int
     */
    public function handle()
    {
        $nurseLangs = NurseLang::all()->groupBy('nurse_id');
        foreach ($nurseLangs as $langs){
            $langs[0]->lang_id = 1;
            $langs[0]->lang = 'english';
            $langs[0]->level = 'A1';
            $langs[0]->save();

            if(isset($langs[1])){
                $langs[1]->lang_id = 2;
                $langs[0]->lang = 'german';
                $langs[1]->level = 'B1';
                $langs[1]->save();
            }
        }

        return 0;
    }
}
