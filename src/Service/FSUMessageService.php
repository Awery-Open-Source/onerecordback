<?php

namespace App\Service;

use App\Entity\Awb;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;

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

    public static function getDescOfStatus($status)
    {
        return self::getStatusDescriptions()[$status] ?? 'Unknown';
    }

    public static function getStatusDescriptions()
    {
        return [
            'BKD'=>'BOOKED (The consignment has been booked for transport)',
            'BRF'=>'BOOKING RECEIVED BY FORWARDER (A booking confirmation should be sent from the Forwarder to the Shipper)',
            'PUP'=>'PICK UP (From shipper)',
            'REW'=>'RECEIVED EXPORT WAREHOUSE (Arrival of freight at forwarder warehouse)',
            'SDO'=>'SHIPMENT DATA ON-HAND',
            'DEW'=>'TRUCK DEPARTING FORWARDER’S EXPORT WAREHOUSE/HUB (Loaded truck departs forwarder branch facility to hub)',
            'FWB'=>'FREIGHT TRACKING WAYBILL (MANIFEST/ The Forwarders Electronic (Master) Air Waybill)',
            'TAC'=>'TRUCK ARRIVAL AT CARRIER (Arrival of truck at carrier) USED FOR HAWB',
            'DOC'=>'TRUCK ARRIVES AT DEPARTURE AIRLINE WAREHOUSE (The truck arrives at the Airline’s domain at Origin Airport)',
            'FOH'=>'FREIGHT ON HAND (Freight received at the origin airport by an Airline or a GHA/Ground Handling Agent)',
            'RCS'=>'RECEIVED CARGO FROM SHIPPER, READY FOR CARRIAGE (Freight and document / data received at origin airport by Airline / GHA and confirmed to be “Ready for carriage” for transportation to airport of destination)',
            'RCT'=>'RECEIVED FROM INTERLINE TRANSFER (airline to indicate that a shipment is received from an interline partner and that an acceptance check has been done by the receiving carrier)',
            'UWS'=>'LIR - CONSOLIDATION (Palletization has been finalized)',
            'FOW'=>'FREIGHT OUT FROM GROUND HANDLER WAREHOUSE CONTROL (Control of the shipment passes from the warehouse handler to the ramp handler)',
            'DEP'=>'DEPARTED',
            'ARR'=>'ARRIVED',
            'ALS'=>'AIRCRAFT UNLOADING START',
            'ALE'=>'AIRCRAFT UNLOADING END (Monitor the ramp handling agent and the transport handling agent in case of 2 different providers)',
            'FIW'=>'FREIGHT INTO WAREHOUSE (The time that the control of the shipment passes from the ramp handler to the warehouse handler)',
            'RCF'=>'RECEIVED CARGO FROM FLIGHT (The time and location at which the freight is planned to be checked in at the airport warehouse)',
            'AWR'=>'DOCUMENT RECEIPT INTO IMPORT WAREHOUSE AT DESTINATION AIRPORT (The arrival documentation has been physically received from flight at destination) NOT SURE WHETHER IT SHOULD BE DISPLAYED →ALSO AT THIS STAGE, WE TRANSFER THE SHIPMENT TO ANOTHER CARRIER IF IT IS AN INTERLINE OR ANOTHER DESTINATION',
            'NFD'=>'NOTIFIED FOR DELIVERY (Confirmation to Forwarder of the Notification to Consignee or Consignee’s Agent that Freight + Documents are On Hand)',
            'AWD'=>'DOCUMENT DELIVERY AT DESTINATION (The arrival documentation has been physically made available to the consignee or the consignee’s agent)',
            'HDP'=>'HANDOVER OF DOCUMENTS FROM FORWARDER TO 3RD PARTY BROKER/CONSIGNEE (Third party takes over the customs clearance and the transport of the shipment)',
            'CCD'=>'CUSTOMS CLEARED',
            'DLV'=>'DELIVERY OF FREIGHT AT DESTINATION (Full custody of Freight is transferred to the Consignee or their Agent at Destination)',
            'DIW'=>'DEPARTED INTO IMPORT HUB',
            'RIW'=>'RECEIVED INTO IMPORT HUB',
            'TPN'=>'THIRD-PARTY/ CONSIGNEE NOTIFICATION',
            'SPC'=>'PICK UP FREIGHT BY CONSIGNEE (The consignee is picking up the freight directly from the respective Import Hub/Warehouse)',
            'OFD'=>'OUT FOR DELIVERY TO CONSIGNEE',
            'POD'=>'PROOF OF DELIVERY'];
    }

    public static function generateFsu($event_id, EntityManagerInterface $entityManager)
    {
        $event = $entityManager->getRepository(Event::class)->find($event_id);
        $awb = $entityManager->getRepository(Awb::class)->find($event->awb_id);
        $totalPieces = $awb->total_pieces??0;//todo calculate total pieces
        $dateAction = $event->dateAction->format('dMHi');
        return <<<EOT
FSU/12
{$awb->awb_no}{$awb->origin}{$awb->destination}/T$totalPieces}K{$awb->weight}
{$event->type}/{$dateAction}/{$event->location}/T{$event->qty}K{$event->weight}/$event->text}
EOT;
    }
}