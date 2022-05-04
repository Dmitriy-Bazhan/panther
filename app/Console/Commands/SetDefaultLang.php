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
    protected $signature = 'lang:default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            $langs[0]->lang = 'English';
            $langs[0]->level = 'A1';
            $langs[0]->save();
        }

        echo 'Success';
        return 0;
    }
}
