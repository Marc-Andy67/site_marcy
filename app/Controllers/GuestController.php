<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Guest;
use App\Core\Mailer;

class GuestController extends Controller
{
    public function index()
    {
        $this->view('rsvp', ['title' => 'RSVP - Marcy et Leroy']);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Basic validation
            $firstName = trim($_POST['first_name'] ?? '');
            $lastName = trim($_POST['last_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');

            if (empty($firstName) || empty($lastName) || empty($_POST['email']) || empty($phone)) {
                $this->view('rsvp', ['title' => 'RSVP - Marcy et Leroy', 'error' => 'Veuillez remplir tous les champs obligatoires.']);
                return;
            }

            // Phone format validation (simple regex: allows digits, spaces, plus, dots, dashes, 10-20 chars)
            if (!preg_match('/^[0-9+\-\. ]{10,20}$/', $phone)) {
                $this->view('rsvp', ['title' => 'RSVP - Marcy et Leroy', 'error' => 'Numéro de téléphone invalide.']);
                return;
            }

            $email = trim($_POST['email']);
            // Default to attending (1) as the radio button is removed and hidden input is 'yes'
            $isAttending = 1;

            // Auto-refusal logic: If not attending, set to 'Refused' (2). Otherwise 'Pending' (0).
            $isApproved = $isAttending ? 0 : 2;

            $guestModel = new Guest();

            // Check for existing email
            $existingGuest = $guestModel->findByEmail($email);

            if ($existingGuest) {
                // Status 2 is "Refused". Allow them to update their submission.
                if ($existingGuest['is_approved'] == 2) {
                    $updateData = [
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                        'phone' => $phone,
                        'age' => (int) ($_POST['age'] ?? 0),
                        'plus_one_age' => (int) ($_POST['plus_one_age'] ?? 0),
                        'is_attending' => $isAttending,
                        'plus_one' => (int) ($_POST['plus_one'] ?? 0),
                        'dietary_restrictions' => trim($_POST['dietary_restrictions'] ?? ''),
                        'message' => trim($_POST['message'] ?? ''),
                        'is_approved' => $isApproved
                    ];

                    // Update existing record
                    if ($guestModel->update($existingGuest['id'], $updateData)) {
                        // Add email to notification data
                        $updateData['email'] = $email;
                        $this->sendEmailNotification($updateData);

                        $this->view('rsvp_success', ['title' => 'Merci !', 'guest' => $updateData]);
                        return;
                    }
                }

                $this->view('rsvp', [
                    'title' => 'RSVP - Marcy et Leroy',
                    'error' => 'Cette adresse email a déjà été utilisée pour une réservation.'
                ]);
                return;
            }

            $data = [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => $email,
                'phone' => $phone,
                'age' => (int) ($_POST['age'] ?? 0),
                'plus_one_age' => (int) ($_POST['plus_one_age'] ?? 0),
                'is_attending' => $isAttending,
                'plus_one' => (int) ($_POST['plus_one'] ?? 0),
                'dietary_restrictions' => trim($_POST['dietary_restrictions'] ?? ''),
                'message' => trim($_POST['message'] ?? ''),
                'is_approved' => $isApproved
            ];

            if ($guestModel->create($data)) {
                // Send email notification
                $this->sendEmailNotification($data);

                $this->view('rsvp_success', ['title' => 'Merci !', 'guest' => $data]);
            } else {
                echo "Une erreur est survenue.";
            }
        }
    }



    private function sendEmailNotification($data)
    {
        $to = 'marcy.pivert@gmail.com';
        $subject = "Nouvelle RSVP : {$data['first_name']} {$data['last_name']}";

        $attendance = $data['is_attending'] ? "OUI" : "NON";
        $color = $data['is_attending'] ? "#28a745" : "#dc3545"; // Green for Yes, Red for No

        // HTML Email Template
        $messageBody = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        </head>
        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
            <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 8px;'>
                <div style='background-color: #1a1a1a; padding: 15px; border-radius: 8px 8px 0 0; text-align: center;'>
                    <h1 style='color: #ffd700; margin: 0; font-size: 24px; font-family: \"Playfair Display\", serif;'>Nouvelle Réponse RSVP</h1>
                </div>
                
                <div style='padding: 20px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);'>
                    <p style='font-size: 16px; margin-bottom: 20px; color: #555;'>Une nouvelle réponse vient d'arriver sur le site :</p>
                    
                    <table style='width: 100%; border-collapse: collapse; margin-bottom: 20px;'>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; width: 40%; font-weight: bold; color: #333;'>Nom :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; color: #555;'>{$data['first_name']} {$data['last_name']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #333;'>Email :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; color: #555;'>{$data['email']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #333;'>Téléphone :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; color: #555;'>{$data['phone']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #333;'>Présence :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: {$color};'>{$attendance}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #333;'>+1 Invités :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; color: #555;'>{$data['plus_one']}</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; font-weight: bold; color: #333;'>Restrictions :</td>
                            <td style='padding: 10px; border-bottom: 1px solid #eee; color: #555;'>" . ($data['dietary_restrictions'] ?: 'Aucune') . "</td>
                        </tr>
                    </table>
                    
                    <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #ffd700; margin-top: 20px;'>
                        <strong style='display: block; margin-bottom: 5px; color: #333;'>Message :</strong>
                        <em style='color: #666;'>" . nl2br(htmlspecialchars($data['message'] ?: 'Aucun message', ENT_QUOTES, 'UTF-8')) . "</em>
                    </div>
                    
                    <p style='text-align: center; margin-top: 30px; font-size: 12px; color: #aaa;'>
                        Ceci est un message automatique envoyé depuis votre site Marcy & Leroy.
                    </p>
                </div>
            </div>
        </body>
        </html>
        ";

        // Use PHPMailer via our wrapper
        $mailer = new Mailer();
        $sent = $mailer->send($to, $subject, $messageBody);

        // LOGGING (Fallback or confirmation)
        $logDir = __DIR__ . '/../../storage/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $status = $sent ? "SENT" : "FAILED";
        $logEntry = "[" . date('Y-m-d H:i:s') . "] [$status] TO: $to | SUBJECT: $subject\n" . $messageBody . "\n";
        file_put_contents($logDir . '/mail.log', $logEntry, FILE_APPEND);
    }
}
