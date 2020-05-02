<?php

namespace App\Console\Commands;

use App\Sensor;
use DB;
use Illuminate\Console\Command;

class ImportSensorDataCommand extends Command
{
    protected $signature = 'import:sensordata
{folder : An absolute or relative path to a folder containing one or more csv files with data.}
{--dry-run : Don\'t change the database, but show what would happen.}
{--Y|yes : Auto-confirm all questions}';

    protected $description = 'Imports sensor data from a folder of csv-files.
The referenced sensors should already exist, or the data will be skipped.
This will create duplicates when run twice.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $path = $this->argument('folder');
        if (substr($path, -1) !== '/') {
            $path = $path . '/';
        }
        $path = $path . '*.csv';
        $files = glob($path);

        $data = [];
        $sensors = Sensor::pluck('id');

        foreach ($files as $path) {
            if (($file = fopen($path, 'r')) === false) {
                $this->error("Can't open {$path}");
                continue;
            }

            // A line looks like
            // UTCDateTime,ID,Value
            $headers = fgetcsv($file);
            while (($csv_line = fgetcsv($file)) !== false) {
                // Check if referenced sensor exists
                if ($sensors->contains($csv_line[1]) === false) {
                    $this->error("Sensor {$csv_line[1]} does not exist.");
                    continue;
                }

                $data[] = [
                    'created_at' => $csv_line[0],
                    'updated_at' => $csv_line[0],
                    'sensor_id' => $csv_line[1],
                    'value' => $csv_line[2],
                ];
            }

            fclose($file);
        }

        if ($this->option('dry-run')) {
            $count = count($data);
            $this->line("{$count} records ready for insertion.");
            if ($this->confirm('Do you want to see them all?')) {
                $this->table(['Timestamp', 'Timestamp', 'Sensor', 'Value'],
                             $data);
            }
            return;
        }

        if ($this->option('yes') || $this->confirm('Do you wish to continue?')) {
            // Split the data in blocks,
            // otherwise we'll get too many placeholder exception
            $chunks = array_chunk($data, 100);

            $this->line('Starting DB transaction');
            DB::transaction(function () use ($chunks) {
                foreach ($chunks as $chunk) {
                    DB::table('sensor_datapoints')
                        ->insert($chunk);
                }
            });
            $this->info('Done.');
        } else {
            $this->error('User-requested abort.');
        }
    }
}
