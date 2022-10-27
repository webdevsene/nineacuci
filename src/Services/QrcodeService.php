<?php

namespace App\Services;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Label\Margin\Margin;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;

class QrcodeService
{
    /**
     * @var BuilderInterface
     */
    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrcode($query, $objDateTime)
    {
        $url = 'https://www.ansd.sn/search?q=';

        // $objDateTime = new \DateTime('NOW');
        $dateString = $objDateTime->format('d/m/Y');

        $path = dirname(__DIR__, 2).'/public/admin/dist/assets/';

        // set qrcode
        $result = $this->builder
            ->data($url.$query)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(90)
            ->margin(0)
            ->labelText("")
            ->labelAlignment(new LabelAlignmentCenter())
            ->labelMargin(new Margin(0, 5, 5, 5))
            ->logoPath($path.'images/Logo.png')
            ->logoResizeToWidth('20')
            ->logoResizeToHeight('20')
            ->backgroundColor(new Color(255, 255, 255))
            ->build()
            //->setForegroundColor(new Color(0, 0, 0))
            //->setBackgroundColor(new Color(255, 255, 255))
        ;

        //generate name
        $namePng = uniqid('', '') . '.png';

        //Save img png
        $result->saveToFile($path.'qr-code/'.$namePng);

        return $result->getDataUri();
    }
}