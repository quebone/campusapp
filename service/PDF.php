<?php
namespace Campusapp\Service;

require_once __DIR__ . '/../vendor/fpdf181/fpdf.php';

class PDF extends \FPDF
{
    private $header;
    private $footer;
        
    public function setHeader($header) {
      $this->header = $header;
    }

    public function setFooter($footer) {
        $this->footer = $footer;
    }
    
    public function Header() {
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, Utils::decode($this->header), 0, 0, 'C');
        // Line break
        $this->Ln(10);
    }
    
    public function Footer() {
        // Position at 1.5 cm from bottom
//         $this->SetY(-15);
        // Arial italic 8
//         $this->SetFont('Arial','I',8);
        // Text color in gray
//         $this->SetTextColor(128);
        // Page number
//         $this->Cell(0, 10, Utils::decode('Pàgina '.$this->PageNo()), 0, 0, 'C');
    }
}