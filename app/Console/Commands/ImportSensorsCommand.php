<?php

namespace App\Console\Commands;

use App\SensorType;
use DB;
use Illuminate\Console\Command;

class ImportSensorsCommand extends Command
{
    protected $signature = 'import:sensors
{filename : Path (absolute, relative or URL to the sensor csv file.)}
{--dry-run : When set, print the database changes, but don\'t run them}
{--Y|yes : Auto-confirm all questions.}';

    protected $description = 'Imports a sensor list into the database.
This command can safely be run multiple times, it will only add new sensors,
not create duplicates.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $file = fopen($this->argument('filename'), 'r');
        if ($file == false) {
            $this->error('Failed to open file.');
            return;
        }

        $headers = fgetcsv($file);
        $data = [];
        while (($csv_line = fgetcsv($file)) !== false) {
            // A line consists of:
            // line,ID,unit,MeasureType,name,room,Description

            // First, see if we already have a SensorType
            // TODO: This could be made faster by caching the types...
            $type = SensorType::where('type', $csv_line[6])
                  ->where('unit', $csv_line[2])->first();
            if (is_null($type)) {
                $type = SensorType::create([
                    'type' => $csv_line[6],
                    'unit' => $csv_line[2],
                ]);
            }

            // Load data into array
            $data[] = [
                'id' => $csv_line[1],
                'name' => $csv_line[4],
                'room' => $csv_line[5],
                'sensor_type_id' => $type->id,
            ];
        }
        fclose($file);

        if ($this->option('dry-run')) {
            $this->table(['id', 'Type', 'Unit'],
                         SensorType::all(['id', 'type', 'unit'])
                         ->toArray());
            $count = count($data);
            $this->line("{$count} records ready to insert.");
            $this->table(['id', 'Name', 'Room', 'Type'],
                         $data);
            return;
        }

        if ($this->option('yes') || $this->confirm('Do you wish to continue?')) {
            DB::transaction(function () use ($data) {
                DB::table('sensors')
                    // Ignore duplicates, so this can be run multiple times
                    ->insertOrIgnore($data);
            });
            $this->info('Done.');
        } else {
            $this->error('User-requested abort.');
        }
    }
}
