<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class Statuschart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(array $inboundData, array $outboundData, array $xAxisLabels): \ArielMejiaDev\LarapexCharts\BarChart
    {
        sort($xAxisLabels);
      
        return $this->chart->barChart()
            ->setTitle('Inbound vs Outbound.')
            // ->setSubtitle('Wins during season 2021.')
            ->addData('Inbound', $inboundData)
            ->addData('Outbound', $outboundData)
            // ->setYaxis([
            //     'title' => [
            //         'text' => 'Values',
            //     ],
            // ])
            ->setXAxis($xAxisLabels);
           
    //     return $this->chart->barChart()
    // ->setTitle('San Francisco vs Boston.')
    // ->setSubtitle('Wins during season 2021.')
    // ->addData('San Francisco', [6, 9, 3, 4, 10, 8])
    // ->addData('Boston', [7, 3, 8, 2, 6, 4])
    // ->setXAxis(['January', 'February', 'March', 'April', 'May', 'June']);
           
           
        // print_r($data);die;
    }
    
}
