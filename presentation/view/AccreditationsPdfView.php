<?php
namespace Campusapp\Presentation\View;

use Campusapp\Presentation\Model\AccreditationsModel;
use Campusapp\Service\AccreditationsService;

class AccreditationsPdfView extends PdfView implements IPdfView
{
    private $model;
    private $service;
    private $users;
    private $margins;
    
    public function __construct(array $users) {
        parent::__construct();
        $this->users = $users;
        $this->model = new AccreditationsModel();
        $this->service = new AccreditationsService();
        $this->setConstants();
    }
    
    private function setConstants() {
        $this->margins = ['left'=>10, 'top'=>5, 'right'=>10, 'bottom'=>2];
    }
    
    private function formatPage() {
        $orientation = 'P';
        $size = 'A4';
        $this->pdf->AddPage($orientation, $size);
        $this->pdf->SetMargins($this->margins['left'], $this->margins['top'], $this->margins['right']);
    }
    
    public function getPdf() {
        $this->pdf->SetAutoPageBreak(TRUE);
        $this->formatPage();
        $pos = ['x' => $this->margins['left'], 'y' => $this->margins['top']];
        $width = 10 * $this->service->getImageWidth();
        $height = 10 * $this->service->getImageHeight();
        $index = 0;
        foreach ($this->users as $user) {
            $file = $this->service->makeAccreditation($user);
            $this->pdf->Image($file, $pos['x'], $pos['y'], $width, $height);
            unlink($file);
            $pos['x'] += $width;
            if (($pos['x'] + $width + $this->margins['left'] + $this->margins['right']) > 210) {
                $pos['x'] = $this->margins['left'];
                $pos['y'] += $height;
                if (($pos['y'] + $height + $this->margins['top'] + $this->margins['bottom']) > 297) {
                    $pos['y'] = $this->margins['top'];
                    $this->formatPage();
                }
            }
        }
        $this->pdf->Output('');
    }
}