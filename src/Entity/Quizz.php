<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuizzRepository")
 */
class Quizz
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $result;


    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\QuizzDet", mappedBy="quizz")
     */
    private $quizzDets;

    public function __construct()
    {
        $this->quizzDets = new ArrayCollection();
        $this->result = null;
        $this->created = new \DateTime();
    }

    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/
    /**********************************************************************************************************************************************/



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getResult(): ?bool
    {
        return $this->result;
    }

    public function setResult(bool $result): self
    {
        $this->result = $result;

        return $this;
    }

    /**
     * @return Collection|QuizzDet[]
     */
    public function getQuizzDets(): Collection
    {
        return $this->quizzDets;
    }

    public function addQuizzDet(QuizzDet $quizzDet): self
    {
        if (!$this->quizzDets->contains($quizzDet)) {
            $this->quizzDets[] = $quizzDet;
            $quizzDet->setQuizz($this);
        }

        return $this;
    }

    public function removeQuizzDet(QuizzDet $quizzDet): self
    {
        if ($this->quizzDets->contains($quizzDet)) {
            $this->quizzDets->removeElement($quizzDet);
            // set the owning side to null (unless already changed)
            if ($quizzDet->getQuizz() === $this) {
                $quizzDet->setQuizz(null);
            }
        }

        return $this;
    }
}
