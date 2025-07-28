<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Cookie\Cookie;
use DateTime;

class Setroom extends Model
{
    public function setRoom($roomId): array
    {
        $cookie = new Cookie('room', $roomId, [
            'expires' => time() + 86400, // 1 day
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]);
        service('response')->setCookie($cookie);

        return ['success' => true, 'message' => 'Room set successfully.'];
    }

    public function clearRoom(): array
    {
        $cookie = new Cookie('room', '', [
            'expires' => time() - 3600, // Expire the cookie
            'path' => '/',
            'secure' => true,
            'httponly' => true,
        ]);
        service('response')->setCookie($cookie);

        return ['success' => true, 'message' => 'Room cleared successfully.'];
    }
}