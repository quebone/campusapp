<?php
namespace Campusapp\Presentation\Controller;

use Campusapp\Service\RegistrationService;
use Campusapp\Presentation\Model\RegistrationModel;
use Campusapp\Service\AttendancesService;
use Campusapp\Presentation\Model\UserModel;
use Campusapp\Presentation\Model\AttendancesModel;
use Campusapp\Service\Entities\Registration;

class RegistrationController extends Controller
{
    private $rs;
    private $rm;
    
    public function __construct() {
        parent::__construct();
        $this->rs = new RegistrationService();
        $this->rm = new RegistrationModel();
    }
    
    private function fillBooleanEmptyFields(array $post): array {
        $booleanFields = [
            'firstYearInCampus', 'musicalKnowledge', 'thursdayDinner', 'fridayLunch', 'fridayDinner',
            'saturdayLunch', 'saturdayDinner', 'sundayLunch', 'emailSpread', 'imageRights', 'privacy',
        ];
        foreach ($booleanFields as $booleanField) {
            if (!isset($post[$booleanField])) $post[$booleanField] = FALSE;
        }
        return $post;
    }
    
    public function getRegistration(array $post): array {
        $data = [];
        $post = $this->decodeUrl($post);
        $user = $this->rs->getRegisteredUser($post['email'], $post['dni']);
        $um = new UserModel();
        $data['user'] = $um->getUserData($user);
        $as = new AttendancesService();
        $attendance = $as->getCurrentAttendance($user);
        if ($attendance != NULL) {
            $am = new AttendancesModel();
            $data['attendance'] = $am->getAttendanceData($attendance);
            $registration = $attendance->getRegistration();
            if ($registration != NULL) {
                $data['registration'] = $this->rm->getRegistrationData($registration);
            }
        }
        return $data;
    }
    
    public function addRegistration(array $post): Registration {
        $post = $this->normalize($post);
        $post = $this->fillBooleanEmptyFields($post);
        $ac = new AttendancesController();
        $errorIfRegistered = FALSE;
        try {
            $attendance = $ac->addAttendance($post, $errorIfRegistered);
            $registration = $this->rs->addRegistration($attendance, $post['firstYearInCampus'],
                $post['arrivalDay'], $post['arrivalTime'], $post['registrationType'],
                $post['emailSpread'], $post['imageRights'], $post['musicalKnowledge'], $post['observations']);
            return $registration;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    
    public function deleteRegistration(array $post): bool {
        $post = $this->decodeUrl($post);
        try {
            $this->rs->deleteRegistration($post['email']);
            return TRUE;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}