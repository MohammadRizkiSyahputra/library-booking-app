<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\App;
use App\Models\RegisterModel;

class ProfileController extends Controller
{
    public function index()
    {
        $this->setTitle('Profile | Library Booking App');
        $this->setLayout('main');
        return $this->render('profile/index');
    }

    public function uploadKubaca(Request $request, Response $response)
{
    /** @var \App\Models\RegisterModel|null $user */
    $user = App::$app->user;
    if (!$user) { $response->redirect('/login'); return; }

    if ($request->isPost() && isset($_FILES['kubaca_image'])) {
        // basic validation
        $f = $_FILES['kubaca_image'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            App::$app->session->setFlash('error', 'Upload failed.');
            $response->redirect('/profile'); return;
        }

        // security: limit mime + size (<= 2MB)
        $allowed = ['image/jpeg','image/png','image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime  = finfo_file($finfo, $f['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed, true) || $f['size'] > 2*1024*1024) {
            App::$app->session->setFlash('error', 'Only JPG/PNG/WEBP up to 2MB.');
            $response->redirect('/profile'); return;
        }

        // store file
        $dir = App::$ROOT_DIR . '/public/uploads/kubaca/';
        if (!is_dir($dir)) { mkdir($dir, 0775, true); }
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $filename = sprintf('%d_%s.%s', $user->id, bin2hex(random_bytes(5)), strtolower($ext));
        $path = $dir . $filename;

        if (!move_uploaded_file($f['tmp_name'], $path)) {
            App::$app->session->setFlash('error', 'Cannot save file.');
            $response->redirect('/profile'); return;
        }

        // save relative file name only
        $stmt = App::$app->db->prepare("UPDATE users SET kubaca_image = :img WHERE id = :id");
        $stmt->bindValue(':img', $filename);
        $stmt->bindValue(':id',  $user->id);
        $stmt->execute();

        App::$app->session->setFlash('success', 'Upload successful! Waiting for admin verification.');
        $response->redirect('/profile'); return;
    }

        $response->redirect('/profile');
    }

}
