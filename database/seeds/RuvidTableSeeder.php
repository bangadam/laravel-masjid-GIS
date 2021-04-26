<?php

namespace Database\Seeders;

use App\Models\Ruvid;
use Illuminate\Database\Seeder;

class RuvidTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFileName = "ruvid.csv";
        $csvFile = public_path('csv/' . $csvFileName);
        $data = $this->readCSV($csvFile, array('delimiter' => ','));
        unset($data[0]);

        foreach ($data as $item) {
            $ruvid = new Ruvid;
            $ruvid->name = $item[1];
            $ruvid->address = $item[2];
            $ruvid->phone = $item[3];

            $latlong = explode(',', $item[4]);
            $ruvid->latitude = $latlong[0];
            $ruvid->longitude = trim($latlong[1]);
            $ruvid->save();
        }
    }

    public function readCSV($csvFile, $array)
    {
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, $array['delimiter']);
        }
        fclose($file_handle);
        return $line_of_text;
    }
}
