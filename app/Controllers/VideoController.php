<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class VideoController extends Controller
{
    public function token()
    {
        // identity e room podem vir via GET ou POST
        $identity = $this->request->getVar('identity') ?? 'guest_' . bin2hex(random_bytes(4));
        $room     = $this->request->getVar('room') ?? null;

        $service = service('twilioVideo');
        $jwt = $service->generateToken($identity, $room);

        return $this->response->setJSON([
            'identity' => $identity,
            'token' => $jwt,
            'room' => $room
        ]);
    }

    public function joinView()
    {
        // view simples com formulário para identificar e entrar numa sala
        return view('video/join');
    }
}