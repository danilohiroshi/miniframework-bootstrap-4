<?php

namespace App\Controller;

use Swift_Mailer;
use Swift_Message;
use App\FormValidation;
use Swift_SmtpTransport;
use Illuminate\Http\Request;
use App\Controller\Controller;

class AppController extends Controller
{
    /**
     * Get homepage.
     *
     * @return string
     *  Return page content.
     */
    public function home()
    {
        return $this->render('pages/index.html');
    }

    /**
     * Send email.
     *
     * @param Request $request
     *  Requested array.
     *
     * @return array
     *  Return response array.
     */
    public function contact(Request $request)
    {
        $validatedData = FormValidation::validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        if (count($validatedData) > 0) {
            return [
                'errors' => $validatedData,
            ];
        }

        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        $transport = (new Swift_SmtpTransport('mail', 1025))
            ->setUsername(null)
            ->setPassword(null);

        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        $template_html = $this->render(
            'mails/email.twig',
            array(
                'name' => $name,
                'email' => $email,
                'message' => $message,
            )
        );

        // Create a message
        $body = (new Swift_Message('Contato'))
            ->setFrom(['john@doe.com' => 'John Doe'])
            ->setTo(['receiver@domain.org' => 'A name'])
            ->setBody($template_html, 'text/html');

        // Send the message
        $result = $mailer->send($body);

        return [
            'success' => true,
        ];
    }
}
