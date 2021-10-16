<?php

namespace App\Console\Commands;

use App\Models\Rule;
use App\Models\Word;
use Illuminate\Console\Command;

class RuleApplier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rule:apply';

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
        foreach (Rule::cursor() as $rule) {
            foreach (Word::where('status', 'success')->cursor() as $word) {
                if (preg_match('/'.$rule->regex.'/', $word->name)) {
                    $word->status = 'refused';
                    $word->save();
                }
            }
        }
        return Command::SUCCESS;
    }
}
