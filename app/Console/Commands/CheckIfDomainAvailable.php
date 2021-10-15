<?php

namespace App\Console\Commands;

use App\Models\Word;
use Helge\Client\SimpleWhoisClient;
use Helge\Loader\JsonLoader;
use Helge\Service\DomainAvailability;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckIfDomainAvailable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'domain:available';

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
        $whoisClient = new SimpleWhoisClient();
        $dataLoader = new JsonLoader(app_path('../vendor/helgesverre/domain-availability/src/data/servers.json'));

        $service = new DomainAvailability($whoisClient, $dataLoader);

        foreach (Word::where('status', 'waiting')->cursor() as $word) {
            if ($service->isAvailable($word->name.'.com', true) && $service->isAvailable($word->name.'.fr')) {
                $word->status = 'success';
            } else {
                $word->status = 'failed';
            }
            $word->save();
        }

        return Command::SUCCESS;
    }
}
