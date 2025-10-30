<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Contracts\ReportInterface;
use App\Http\Controllers\Response\ApiController;



/**
 * @group Report
 *
 * API untuk mengelola Laporan.
 */
class ReportController extends ApiController
{
    protected $reportService;
    public function __construct(ReportInterface $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Get Report Item per Vendor
     *
     * @authenticated 
     */
    public function getItemVendorReport()
    {
        $reportData = $this->reportService->getReportItemVendor();
        return $this->sendResponse($reportData);
    }

    /**
     * Get Report Ranking Vendor
     * 
     * @authenticated 
     */
    public function getMostTransactedReport()
    {
        $reportData = $this->reportService->getMostTransacted();
        return $this->sendResponse($reportData);
    }

    /**
     * Get Report Rate Harga
     *
     * @authenticated 
     */
    public function getRateReport()
    {
        $reportData = $this->reportService->getRateReport();
        return $this->sendResponse($reportData);

    }
}