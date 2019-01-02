<?php
namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PropertySearch
{
    /**
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
     * Retourne le prix maximum pour la recherche
     * @Assert\Range(
     *      min = 10000,
     *      max = 100000000,
     *      minMessage = "price.minMessage",
     *      maxMessage = "price.maxMessage"
     * )
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

}