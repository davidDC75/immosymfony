<?php
namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PropertyRepository")
 * @UniqueEntity(
 *      fields="title",
 *      message="add.edit.property.title.unique"
 * )
 * @UniqueEntity(
 *      fields="address",
 *      message="add.edit.property.address.unique"
 * )
 * @Vich\Uploadable
 */
class Property
{
    /**
     * HEAT
     * @var array
     */
    const HEAT=[
            0=> "property.heattype.electric",
            1=>"property.heattype.gas",
            2=>"property.heattype.fireplace"
        ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      min = 10,
     *      max = 200,
     *      minMessage = "add.edit.property.title.minMessage",
     *      maxMessage = "add.edit.property.title.maxMessage"
     * )
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 30,
     *      max = 1500,
     *      minMessage = "add.edit.property.surface.minMessage",
     *      maxMessage = "add.edit.property.surface.maxMessage"
     * )
     */
    private $surface;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 30,
     *      minMessage = "add.edit.property.rooms.minMessage",
     *      maxMessage = "add.edit.property.rooms.maxMessage"
     * )
     */
    private $rooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 30,
     *      minMessage = "add.edit.property.bedrooms.minMessage",
     *      maxMessage = "add.edit.property.bedrooms.maxMessage"
     * )
     */
    private $bedrooms;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 0,
     *      max = 50,
     *      minMessage = "add.edit.property.floor.minMessage",
     *      maxMessage = "add.edit.property.floor.maxMessage"
     * )
     */
    private $floor;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Range(
     *      min = 10000,
     *      max = 100000000,
     *      minMessage = "add.edit.property.price.minMessage",
     *      maxMessage = "add.edit.property.price.maxMessage"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $heat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     *      pattern="/^[0-9]{5}$/",
     *      match=true,
     *      message="add.edit.property.codePostal.format"
     * )
     */
    private $postal_code;

    /**
     * @ORM\Column(type="boolean",options={"default": false})
     */
    private $sold=false;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Option", inversedBy="properties")
     */
    private $options;

    /**
     * $imageFile
     * @Assert\Image(
     *      mimeTypes="image/jpeg",
     *      mimeTypesMessage="add.edit.property.image.format"
     * )
     * @Vich\UploadableField(mapping="properties_image",fileNameProperty="filename")
     *
     * @var File|null
     */
    private $imageFile;

    /**
     * $filename
     *
     * @var string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $filename;

    /**
     * @ORM\Column(type="datetime",options={"default": "2010-01-01 00:00:00"})
     */
    private $updated_at;

    /**
     * Constructeur
     * Rempli la propriété created_at lors de l'instanciation d'un nouvel objet Property
     */
    public function __construct()
    {
        $this->created_at=new \DateTime();
        $this->updated_at=new \DateTime();
        $this->options = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Retourne le slug d'un titre
     * @return string
     */
    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->title);
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): self
    {
        $this->surface = $surface;

        return $this;
    }

    public function getRooms(): ?int
    {
        return $this->rooms;
    }

    public function setRooms(int $rooms): self
    {
        $this->rooms = $rooms;

        return $this;
    }

    public function getBedrooms(): ?int
    {
        return $this->bedrooms;
    }

    public function setBedrooms(int $bedrooms): self
    {
        $this->bedrooms = $bedrooms;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Retourne le prix formaté
     * @return string
     */
    public function getFormattedPrice(): string
    {
        return number_format($this->price,0,'',' ');
    }

    public function getHeat(): ?int
    {
        return $this->heat;
    }

    public function setHeat(int $heat): self
    {
        $this->heat = $heat;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    public function setPostalCode(string $postal_code): self
    {
        $this->postal_code = $postal_code;

        return $this;
    }

    public function getSold(): ?bool
    {
        return $this->sold;
    }

    public function setSold(bool $sold): self
    {
        $this->sold = $sold;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Option[]
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    public function addOption(Option $option): self
    {
        if (!$this->options->contains($option)) {
            $this->options[] = $option;
            $option->addProperty($this);
        }

        return $this;
    }

    public function removeOption(Option $option): self
    {
        if ($this->options->contains($option)) {
            $this->options->removeElement($option);
            $option->removeProperty($this);
        }

        return $this;
    }

    /**
     * Get $imageFile
     *
     * @return  File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * Set $imageFile
     *
     * @param  File|null  $imageFile
     *
     * @return  Property
     */
    public function setImageFile(?File $imageFile=null): Property
    {
        $this->imageFile = $imageFile;

        // Only change the updated at if the file is really uploaded to avoir database updates.
        // This is needed when the file should be set when loading the entity.
        // https://github.com/dustin10/VichUploaderBundle/blob/master/Resources/doc/known_issues.md
        if ($this->imageFile instanceof UploadedFile) {
            $this->updated_at=new \Datetime('now');
        }

        return $this;
    }


    /**
     * Get $filename
     *
     * @return  string|null
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * Set $filename
     *
     * @param  string|null  $filename
     *
     * @return  Property
     */
    public function setFilename(?string $filename=null): Property
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
