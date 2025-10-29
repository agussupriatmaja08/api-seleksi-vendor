<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\ReportInterface;

class ReportController extends Controller
{

    protected $reportService;
    public function __construct(ReportInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Report 1: Item per Vendor
     * @authenticated 
     */
    public function getItemVendorReport()
    {
        $reportData = $this->reportService->getReportItemVendor();

        $response = [
            "status" => true,
            "message" => "data ditemukan",
            "data" => $reportData
        ];

        return response()->json($response);
    }

    /**
     * Report 2: Rank vendor dengan transaksi paling banyak
     * @authenticated 
     */
    public function getMostTransactedReport()
    {
        $reportData = $this->reportService->getMostTransacted();

        $response = [
            "status" => true,
            "message" => "data ditemukan",
            "data" => $reportData
        ];

        return response()->json($response);
    }

    /**
     * Report 3: Rate up/down harga dari item
     * @authenticated 
     */
    public function getRateReport()
    {
        $reportData = $this->reportService->getRateReport();

        $response = [
            "status" => true,
            "message" => "data ditemukan",
            "data" => $reportData
        ];

        return response()->json($response);
    }
}