<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Guest;
use App\Core\Mailer;

class AdminController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $guestModel = new Guest();
        $guests = $guestModel->getAllWithCompanions();

        // Calculate stats
        $totalGuests = 0;
        $totalAttending = 0; // Approved confirmed guests (including +1)
        $totalDeclined = 0;  // Guests who said No
        $pending = 0;        // Waiting for approval (requests)
        $refused = 0;        // Rejected by admin

        foreach ($guests as $guest) {
            // Pending
            if ($guest['is_approved'] == 0) {
                $pending++;
            }
            // Refused by Admin
            elseif ($guest['is_approved'] == 2) {
                $refused++;
            }
            // Approved
            elseif ($guest['is_approved'] == 1) {
                if ($guest['is_attending']) {
                    $totalAttending += (1 + count($guest['companions'] ?? []));
                }
            }

            // Global Declines (regardless of approval, usually auto-approved or ignored)
            if (!$guest['is_attending']) {
                $totalDeclined++;
            }
        }

        $this->view('admin/dashboard', [
            'title' => 'Tableau de Bord - Marcy et Leroy',
            'guests' => $guests,
            'stats' => [
                'total_attending' => $totalAttending,
                'total_declined' => $totalDeclined,
                'pending' => $pending,
                'refused' => $refused,
                'total_responses' => count($guests)
            ]
        ]);
    }

    public function approve()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guest_id'])) {
            $guestId = $_POST['guest_id'];
            $guestModel = new Guest();
            $guest = $guestModel->getWithCompanions($guestId);

            if ($guest && $guestModel->approve($guestId)) {
                $this->sendDecisionEmail($guest, 'approved');
            }

            header('Location: /admin');
            exit;
        }
    }

    public function reject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guest_id'])) {
            $guestId = $_POST['guest_id'];
            $guestModel = new Guest();
            $guest = $guestModel->findById($guestId);

            if ($guest && $guestModel->reject($guestId)) {
                $this->sendDecisionEmail($guest, 'rejected');
            }

            header('Location: /admin');
            exit;
        }
    }

    private function sendDecisionEmail($guest, $status)
    {
        $to = $guest['email'];
        $subject = ($status === 'approved') ? "Mariage Marcy & Leroy - Confirmation de votre présence" : "Mariage Marcy & Leroy - Mise à jour de votre statut";

        $bodyContent = "";
        if ($status === 'approved') {
            $companionsBlock = "";
            if (!empty($guest['companions'])) {
                $companionsBlock = "<div style='margin-top: 20px; padding: 15px; background: rgba(0,0,0,0.03); border-radius: 5px;'>
                                      <p style='margin-top:0;'><strong>Accompagnants enregistrés :</strong></p>
                                      <ul style='margin-bottom:0;'>";
                foreach ($guest['companions'] as $comp) {
                    $child = !empty($comp['children_menu']) ? ' — Menu enfant' : '';
                    $companionsBlock .= "<li>" . htmlspecialchars($comp['first_name']) . ", " . (int)$comp['age'] . " ans" . $child . "</li>";
                }
                $companionsBlock .= "</ul></div>";
            }

            $bodyContent = "
                <p>Nous sommes très heureux de vous compter parmi nous pour célébrer notre mariage 🎉<br>
                Votre réponse via le formulaire a bien été enregistrée, et nous vous remercions sincèrement d’avoir confirmé votre présence.</p>
                {$companionsBlock}
                <p>Nous avons hâte de partager ce moment unique avec vous.<br>
                N'hésitez pas à consulter régulièrement le site pour découvrir le programme et les détails du jour J.</p>
                <p>Toutes les informations pratiques vous seront communiquées prochainement.</p>
                <p>À très bientôt !</p>
                <br>
                <p>Bien cordialement,</p>
                <p>Marcy et Leroy</p>
            ";
        } else {
            $bodyContent = "
                <p>Nous vous remercions d’avoir pris le temps de répondre à notre invitation.<br>
                Nous comprenons parfaitement que vous ne puissiez pas être présent(e) à notre mariage.</p>
                <p>Votre attention nous touche beaucoup et nous penserons à vous en ce jour si spécial.</p>
                <p>Au plaisir de vous revoir très bientôt.</p>
                <br>
                <p>Bien cordialement,</p>
                <p>Marcy et Leroy</p>
            ";
        }

        $messageBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px;'>
                <div style='text-align: center; background: #000; padding: 20px; border-radius: 8px 8px 0 0;'>
                     <h2 style='color: #fff; margin:0;'>Marcy & Leroy</h2>
                </div>
                <div style='padding: 20px; color: #333;'>
                    <p>Bonjour {$guest['first_name']},</p>
                    {$bodyContent}
                </div>
                <p style='text-align: center; font-size: 12px; color: #999; margin-top: 20px;'>Ceci est un message automatique.</p>
            </div>
        </body>
        </html>
        ";

        $mailer = new \App\Core\Mailer();
        $mailer->send($to, $subject, $messageBody);
    }
}
