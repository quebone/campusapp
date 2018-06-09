<?php

namespace Campusapp\Presentation\View;

use Campusapp\Service\PDF;

class PdfView extends View
{
    protected $pdf;
    
    public function __construct() {
        parent::__construct();
        $this->pdf = new PDF();
    }
    
    protected function getRowHeight(array $widths, array $values, array $format, int $minHeight=6): float {
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont($format['font'], $format['style'], $format['size']);
        $pdf->SetFillColor($format['bkColor']['r'], $format['bkColor']['g'], $format['bkColor']['b']);
        $y = $pdf->GetY();
        $maxY = $y;
        foreach ($values as $i => $value) {
            $pdf->SetXY(0, $y);
            $pdf->MultiCell($widths[$i], $minHeight, $value[0]);
            $maxY = max([$maxY, $pdf->GetY()]);
        }
        return $maxY - $y;
    }
    
    protected function pageOverflown(PDF $pdf, array $margins, float $x, float $y): array {
        $overflown = [false, false];
        $width = $pdf->GetPageWidth();
        $height = $pdf->GetPageHeight();
        if ($x > ($width - $margins['left'] - $margins['right'])) $overflown[0] = true;
        if ($y > ($height - $margins['top'] - $margins['bottom'])) $overflown[1] = true;
        return $overflown;
    }
}