<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    /**
     * @Assert\Range(
     *      min = 10000,
     *      max = 100000000,
     *      minMessage = "price.minMessage",
     *      maxMessage = "price.maxMessage"
     * )
     * @var int|null
     */
    private $maxPrice;

    /**
     * @var int|null
     * @Assert\Range(
     *      min = 30,
     *      max = 1500,
     *      minMessage = "surface.minMessage",
     *      maxMessage = "surface.maxMessage"
     * )
     */
    private $minSurface;

    /**
     * $options
     *
     * @var ArrayCollection
     */
    private $options;

    public function __construct()
    {
        $this->options=new ArrayCollection();
    }

    /**
     * Retourne le prix maximum pour la recherche
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }


    /**
     * setMaxPrice
     *
     * @param ?int $maxPrice
     * @return PropertySearch
     */
    public function setMaxPrice(int $maxPrice): PropertySearch
    {
        $this->maxPrice=$maxPrice;
        return $this;
    }

    /**
     * getMinSurface
     *
     * @return int
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * setMinSurface
     *
     * @param ?int $minSurface
     * @return PropertySearch
     */
    public function setMinSurface(int $minSurface): PropertySearch
    {
        $this->minSurface=$minSurface;
        return $this;
    }


    /**
     * Get $options
     *
     * @return  ArrayCollection
     */
    public function getOptions(): ArrayCollection
    {
        return $this->options;
    }

    /**
     * Set $options
     *
     * @param  ArrayCollection  $options  $options
     *
     * @return  self
     */
    public function setOptions(ArrayCollection $options)
    {
        $this->options = $options;

        return $this;
    }
}