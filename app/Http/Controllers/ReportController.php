<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\ReportInterface;
use App\Http\Controllers\Response\ApiController;



/**
 * @group Report
 *
 * API untuk mengambil data laporan.
 */
class ReportController extends ApiController
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
        return $this->sendResponse($reportData);
    }

    /**
     * Report 2: Rank vendor dengan transaksi paling banyak
     * @authenticated 
     */
    public function getMostTransactedReport()
    {
        $reportData = $this->reportService->getMostTransacted();
        return $this->sendResponse($reportData);
    }

    /**
     * Report 3: Rate up/down harga dari item
     * @authenticated 
     */
    public function getRateReport()
    {
        $reportData = $this->reportService->getRateReport();
        return $this->sendResponse($reportData);

    }
}