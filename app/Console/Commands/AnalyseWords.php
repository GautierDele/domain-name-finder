<?php

namespace App\Console\Commands;

use App\Models\Word;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class AnalyseWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'analyse:words {length=5}';

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
        $tries = 0;

        while ($tries < 1000) {
            $words = Http::withoutVerifying()->asForm()->post('https://feldarkrealms.com/src/words.php', [
                'lang' => 'English',
                'words' => 10,
                'length' => $this->argument('length'),
            ]);

            preg_match_all('/<div class="col-3 mb-3">([a-zA-Z]+)<\/div>/', $words->body(), $matches);

            foreach ($matches[1] as $word) {
                Word::firstOrCreate([
                    'name' => $word
                ]);

                $tries = 0;
            }

            $tries++;
        }


        return Command::SUCCESS;
    }
}
