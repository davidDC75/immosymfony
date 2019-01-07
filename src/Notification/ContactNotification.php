<?php
namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;

class ContactNotification
{

    /**
     * $mailer
     *
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * $renderer
     *
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer,Environment $renderer)
    {
        $this->mailer=$mailer;
        $this->renderer=$renderer;
    }

    public function notify(Contact $contact)
    {
        $subject='Agence : '.$contact->getProperty()->getTitle();

        $message=(new \Swift_Message($subject))
            ->setFrom(getenv('MAIL_FROM_CONTACT'))
            ->setTo(getenv('MAIL_TO_CONTACT'))
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('emails/contact.html.twig',[
                'contact'=>$contact
            ]),'text/html');

        $this->mailer->send($message);
    }

}