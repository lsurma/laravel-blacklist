<?php

namespace LSurma\LaravelBlacklist\Database\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use LSurma\LaravelBlacklist\Consts\Type;
use LSurma\LaravelBlacklist\LaravelBlacklistServiceProvider;

class BlacklistSeeder extends Seeder
{
    protected $seedsDataPath = null;
    protected $table = null;

    public function __construct()
    {
        $this->seedsDataPath = __DIR__ . '/../../seeds-data/';

        $model = LaravelBlacklistServiceProvider::getBlacklistModel();
        $this->table = (new $model)->getTable();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::disableQueryLog();

        $this->seedPasswords();
        $this->seedEmailDomains();

        DB::enableQueryLog();
    }

    protected function seedPasswords()
    {
        $path = $this->seedsDataPath . 'passwords-blacklist.txt';

        // Seed blacklist database with forbidden passwords
        $source = file($path);

        // Prepare flat array to bulk insert
        $passwords = array_map(function($password) {
            return ['type' => Type::PASSWORD, 'value' => trim($password)];
        }, $source);

        // Seed via insert ignore to prevent errors
        DB::table($this->table)->insertOrIgnore($passwords);
    }

    protected function seedEmailDomains()
    {
        $path = $this->seedsDataPath . 'email-domains-blacklist.txt';

        // Disposable/temp/fake e-mail domains
        $source = file($path);

        // Prepare flat array to bulk insert
        $emailsDomains = array_map(function($domain) {
            return ['type' => Type::EMAIL_DOMAIN, 'value' => trim($domain)];
        }, $source);

        // Make inserts in chunks
        $emailsDomainsChunks = array_chunk($emailsDomains, 5000);

        foreach($emailsDomainsChunks as $domains) {
            DB::table($this->table)->insertOrIgnore($domains);
        }
    }
}
