<?php

namespace App\Service;

class FSUMessageService
{
    public string $status;

    public \stdClass $awb;

    public \stdClass $flight;
    private string $message; // The raw multi-line FSU message
    private array $parsedData = []; // Array to store parsed fields

    /**
     * Constructor to initialize the message and parse it.
     *
     * @param string $message The raw FSU message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
        $this->parseMessage();
    }

    /**
     * Parses the FSU message into a structured array by prefixes.
     */
    private function parseMessage(): void
    {
        // Split the message by lines
        $lines = explode("\n", $this->message);

        foreach ($lines as $line) {
            // Skip empty lines
            $line = trim($line);
            if (empty($line)) {
                continue;
            }

            // Extract the prefix (e.g., FSU, ZEV, GIN, etc.)
            $parts = explode('/', $line, 2); // Split by '/', once
            if (strlen($parts[0]) == 3) {
                $this->parsedData['status'] = ['status' => $parts[0], 'content' => $parts[1] ?? ''];
            } else {
                $this->parsedData['awb'] = $line;
            }
        }

        if (!empty($this->parsedData)) {
            $this->parseAwbLine();
            $this->parseStatusDetails();
        }
    }

    protected function parseAwbLine()
    {
        $awbLine = $this->parsedData['awb'] ?? '';

        $pattern = '~(?<awb_no>[a-z0-9]{3,4}-[0-9]{8})(?<origin>\w{3})(?<dest>\w{3})/(?<shipment_description_code>[T|P])(?<total_pieces>\d+)([K|L](?<total_weight>[0-9\.]+))?~i';

        preg_match($pattern, $awbLine, $result);

        $awb = [
            'awb_no' => $result['awb_no'],
            'origin' => $result['origin'],
            'dest' => $result['dest'],
            'shipment_description_code' => $result['shipment_description_code'],
            'total_pieces' => $result['total_pieces']
        ];

        $this->parsedData['awb'] = $awb;

        $this->awb = (object)$awb;
    }

    protected function parseStatusDetails()
    {
        if (!empty($this->parsedData['status'])) {
            $this->status = $this->parsedData['status']['status'];
        }

        $pattern = '~^(?<call_sign>[^/]+)?/(?<flight_date>\d{2}[A-Z]{3})?/(?<origin>[A-Z]{3})(?<dest>[A-Z]{3})/(?<shipment_description_code>[T|P])(?<pcs>\d+)(?<weight_unit>[K|L])(?<weight>[0-9\.]+)(/(?<departure_time_type>[AES])(?<departure_time>\d{4})\-?(?<departure_day_mark>[PNST])?)?(/(?<arrival_time_type>[AES])(?<arrival_time>\d{4})\-?(?<arrival_day_mark>[PNST])?)?(?<more_info>.*)?~';
        $statusLine = $this->parsedData['status']['content'];

        preg_match($pattern, $statusLine, $result);

        $flight = [
            'call_sign' => $result['call_sign'],
            'flight_date' => $result['flight_date'],
            'origin' => $result['origin'],
            'dest' => $result['dest'],
            'shipment_description_code' => $result['shipment_description_code'],
            'pcs' => $result['pcs'],
            'weight_unit' => $result['weight_unit'],
            'weight' => $result['weight'],
            'departure_time_type' => $result['departure_time_type'],
            'departure_time' => $result['departure_time'],
            'departure_day_mark' => $result['departure_day_mark'],
            'arrival_time_type' => $result['arrival_time_type'],
            'arrival_time' => $result['arrival_time'],
            'arrival_day_mark' => $result['arrival_day_mark'],
        ];

        $this->parsedData['flight'] = $flight;

        $this->flight = (object)$flight;
    }

    /**
     * Get all parsed data as a structured associative array.
     *
     * @return array The parsed FSU fields grouped by their prefixes.
     */
    public function getParsedData(): array
    {
        return $this->parsedData;
    }
}