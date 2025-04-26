<?php

namespace App\Http\Controllers;

use App\Models\AqiData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AqiDataExportController extends Controller
{
    public function exportToJson()
    {
        // Fetch AQI data from the database
        $aqiData = AqiData::all();

        // Return the data as a JSON file
        return Response::json($aqiData, 200, [], JSON_PRETTY_PRINT);
    }

    public function exportToCsv()
{
    $aqiData = AqiData::all();

    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=aqi_data.csv",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
    );

    $handle = fopen('php://output', 'w');
    // Add the headers of your CSV file
    fputcsv($handle, ['Sensor ID', 'AQI', 'Air Quality', 'Temperature', 'Humidity', 'Recorded At']);

    // Loop through the data and write each row to the CSV
    foreach ($aqiData as $data) {
        fputcsv($handle, [
            $data->sensor_id,
            $data->aqi,
            $data->air_quality,
            $data->temperature,
            $data->humidity,
            $data->recorded_at,
        ]);
    }

    fclose($handle);

    return response()->stream(
        function () use ($handle) {
            fclose($handle);
        },
        200,
        $headers
    );
}

}
