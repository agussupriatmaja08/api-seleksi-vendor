<?php

namespace App\Services\Contracts;

interface ReportInterface
{
    public function getReportItemVendor();
    public function getMostTransacted();
    public function getRateReport();
}