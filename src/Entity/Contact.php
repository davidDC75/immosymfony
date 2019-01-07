<?php
namespace App\Entity;

use App\Entity\Property;
use Symfony\Component\Validator\Constraints as Assert;


class Contact
{
    /**
     * $firstname
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="contact.firstname.minMessage",
     *      maxMessage="contact.firstname.maxMessage"
     * )
     */
    private $firstname;

    /**
     * $lastname
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="contact.lastname.minMessage",
     *      maxMessage="contact.lastname.maxMessage"
     * )
     */
    private $lastname;

    /**
     * $phone
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/[0-9]{10}/",
     *  message="contact.phone"
     * )
     */
    private $phone;

    /**
     * $email
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Email(
     *      message="contact.email"
     * )
     */
    private $email;

    /**
     * $message
     *
     * @var string|null
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min=15,
     *      max=400,
     *      minMessage="contact.message.minMessage",
     *      maxMessage="contact.message.maxMessage"
     * )
     */
    private $message;

    /**
     * $property
     *
     * @var Property|null
     */
    private $property;

    /**
     *
     * @return  string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     *
     * @param  string|null  $firstname
     *
     * @return  Contact
     */
    public function setFirstname($firstname): Contact
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     *
     * @return  string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     *
     * @param  string|null  $lastname
     *
     * @return  Contact
     */
    public function setLastname($lastname): Contact
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     *
     * @return  string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     *
     * @param  string|null  $phone
     *
     * @return  Contact
     */
    public function setPhone($phone): Contact
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     *
     * @return  string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     *
     * @param  string|null  $email
     *
     * @return  Contact
     */
    public function setEmail($email): Contact
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @return  string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     *
     * @param  string|null  $message
     *
     * @return  Contact
     */
    public function setMessage($message): Contact
    {
        $this->message = $message;
        return $this;
    }

    /**
     *
     * @return  Property
     */
    public function getProperty(): Property
    {
        return $this->property;
    }

    /**
     *
     * @param  Property|null  $property
     *
     * @return  Contact
     */
    public function setProperty(Property $property): Contact
    {
        $this->property = $property;
        return $this;
    }
}