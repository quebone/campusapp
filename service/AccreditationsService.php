<?php
namespace Campusapp\Service;

use Campusapp\Service\Entities\User;

class AccreditationsService extends Service
{
    private $res = 300;
    private $font = 'fonts/PoplarStd.otf';
    private $measures = [
        'width' => 5.9 * 300,
        'height' => 9.5 * 300,
        'editionLeft' => 0.75 * 300,
        'editionTop' => 4.0 * 300,
        'qrLeft' => 2.9 * 300,
        'qrTop' => 1.9 * 300,
        'qrSize' => 2.4 * 300,
        'title1Left' => 0.75 * 300,
        'title1Top' => 5.2 * 300,
        'title2Left' => 0.75 * 300,
        'title2Top' => 6.2 * 300,
        'bandTop' => 6.75 * 300,
        'bandHeight' => 1.0 * 300,
        'nameTop' => 7.75 * 300,
        'nameWidth' => 5.0 * 300,
        'roleTop' => 8.9 * 300,
    ];
    
    private $fontSizes = [
        'edition' => 550.0,
        'title1' => 160.0,
        'title2' => 170.0,
        'role' => 200.0,
    ];
    
    public function __construct() {
        parent::__construct();
    }
    
    public function makeAccreditation(User $user): bool {
        $im = @imagecreatetruecolor($this->measures['width'], $this->measures['height']);
        $white = imagecolorallocate($im, 255, 255, 255);
        $black = imagecolorallocate($im, 0, 0, 0);
        $grey = imagecolorallocate($im, 128, 128, 128);
        imagefill($im, 0, 0, $white);
        $qr = $this->getQR($user->getEmail());
        imagecopyresampled($im, $qr, $this->measures['qrLeft'], $this->measures['qrTop'], 0, 0, $this->measures['qrSize'], $this->measures['qrSize'], 500, 500);
        $edition = $this->getCurrentEdition();
        imagettftext($im, $this->fontSizes['edition'], 0, $this->measures['editionLeft'],
            $this->measures['editionTop'], $black, $this->font, $edition);
        $title1 = "CAMPUS GOSPEL";
        $title2 = "RAJADELL-" . date('Y');
        imagettftext($im, $this->fontSizes['title1'], 0, $this->posLeft($this->fontSizes['title1'], $title1),
            $this->measures['title1Top'], $black, $this->font, $title1);
        imagettftext($im, $this->fontSizes['title2'], 0, $this->posLeft($this->fontSizes['title2'], $title2),
            $this->measures['title2Top'], $black, $this->font, $title2);
        imagefilledrectangle($im, 0, $this->measures['bandTop'] + $this->measures['bandHeight'], $this->measures['width'], $this->measures['bandTop'], $black);
        $name = $user->getName() . " " . $user->getSurnames();
        $fontSize = $this->optimizeFontSize($name, $this->measures['nameWidth']);
        $posBottom = $this->posBottom($this->measures['bandHeight'], $fontSize, $name);
        imagettftext($im, $fontSize, 0, $this->posLeft($fontSize, $name),
            $this->measures['nameTop'] - $posBottom, $white, $this->font, $name);
        $role = strtoupper('organització');
        imagettftext($im, $this->fontSizes['role'], 0, $this->posLeft($this->fontSizes['role'], $role),
            $this->measures['roleTop'], $black, $this->font, $role);
        imagepng($im, TMPDIR.'accreditation.png');
        imagedestroy($im);
        return TRUE;
    }
    
    private function getCurrentEdition(): int {
        return intval(date('Y')) - 2004;
    }
    
    private function getQR(string $value) {
        
        $qr = imagecreatefrompng("https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=$value&choe=UTF-8");
        return $qr;
    }
    
    private function posLeft(float $size, string $text): float {
        $box = imageftbbox($size, 0, $this->font, $text);
        $posLeft = ($this->measures['width'] - ($box[2] - $box[0])) / 2;
        return $posLeft;
    }
    
    private function posBottom(float $height, float $fontSize, string $text): float {
        $box = imageftbbox($fontSize, 0, $this->font, $text);
        $posBottom = ($height - ($box[1] - $box[7])) / 2;
        return $posBottom;
    }
    
    private function optimizeFontSize(string $text, float $width, float $maxSize=170.0): float {
        $box = imageftbbox(100, 0, $this->font, $text);
        $boxWidth = $box[2] - $box[0];
        $fontSize = 100 * $width / $boxWidth;
        if ($fontSize < $maxSize) return $fontSize;
        return $maxSize;
    }
}