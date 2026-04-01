<?php

namespace App\Controllers;

use App\Core\Controller;

class GiftController extends Controller
{
    public function index()
    {
        $this->view('gift', [
            'title' => 'Liste de Mariage - Marcy et Leroy'
        ]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $amount = floatval($_POST['amount'] ?? 0);
            $message = trim($_POST['message'] ?? '');
            $paymentMethod = $_POST['payment_method'] ?? 'online';

            if (empty($name) || empty($email) || $amount <= 0) {
                $this->view('gift', [
                    'title' => 'Liste de Mariage - Marcy et Leroy',
                    'error' => 'Veuillez remplir tous les champs obligatoires avec un montant valide.'
                ]);
                return;
            }

            $donationModel = new \App\Models\Donation();
            $data = [
                'name' => $name,
                'email' => $email,
                'amount' => $amount,
                'message' => $message,
                'payment_method' => $paymentMethod
            ];

            if ($donationModel->create($data)) {
                $this->sendConfirmationEmail($data);
                $this->view('gift_success', ['title' => 'Merci !', 'donation' => $data]);
            } else {
                $this->view('gift', [
                    'title' => 'Liste de Mariage - Marcy et Leroy',
                    'error' => 'Une erreur est survenue lors de l\'enregistrement.'
                ]);
            }
        }
    }

    private function sendConfirmationEmail($data)
    {
        $mailer = new \App\Core\Mailer();
        $to = $data['email'];
        $subject = "Confirmation de votre participation - Marcy et Leroy";

        // Payment Instructions
        $paymentInstructions = "";
        if ($data['payment_method'] === 'transfer') {
            $paymentInstructions = "<p><strong>IBAN pour le virement :</strong><br>FR76 1027 8010 0900 0213 8680 118<br>Titulaire : Marcy et Leroy</p><p><strong>Ou via Wero (Virement instantané) :</strong><br>Numéro : 06 73 65 33 71</p>";
        } else {
            $paymentInstructions = "<p>Pour finaliser votre don en ligne (PayPal) : <a href='https://paypal.me/marcyetleroy/{$data['amount']}' style='color: #ffd700;'>Cliquez ici</a></p>";
        }

        $body = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
        </head>
        <body style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;'>
            <div style='max-width: 600px; margin: 0 auto; background-color: white; padding: 20px; border-radius: 8px;'>
                <h1 style='color: #333; text-align: center;'>Merci {$data['name']} !</h1>
                <p>Nous avons bien enregistré votre promesse de don de <strong>{$data['amount']} €</strong>.</p>
                <p>C'est un geste qui nous touche énormément.</p>
                
                <div style='background-color: #f9f9f9; padding: 15px; border-left: 4px solid #ffd700; margin: 20px 0;'>
                    {$paymentInstructions}
                </div>
                
                <p style='font-size: 12px; color: #999; text-align: center;'>Ceci est un message automatique.</p>
            </div>
        </body>
        </html>
        ";

        $mailer->send($to, $subject, $body);

        // Notify Admins
        $adminBody = "Nouveau don promis par {$data['name']} ({$data['email']}) d'un montant de {$data['amount']} €.<br>Message: {$data['message']}";
        $mailer->send('marcy.pivert@gmail.com', 'Nouveau Don !', $adminBody);
    }
}
