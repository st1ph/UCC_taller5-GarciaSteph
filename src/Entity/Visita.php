<?php

namespace App\Entity;

use App\Repository\VisitaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitaRepository::class)]
class Visita
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $fecha_visita = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre_medico = null;

    #[ORM\Column(length: 2)]
    private ?string $recibe_medicamentos = null;

    #[ORM\ManyToOne(inversedBy: 'visitas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paciente $paciente = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaVisita(): ?\DateTime
    {
        return $this->fecha_visita;
    }

    public function setFechaVisita(\DateTime $fecha_visita): static
    {
        $this->fecha_visita = $fecha_visita;

        return $this;
    }

    public function getNombreMedico(): ?string
    {
        return $this->nombre_medico;
    }

    public function setNombreMedico(string $nombre_medico): static
    {
        $this->nombre_medico = $nombre_medico;

        return $this;
    }

    public function getRecibeMedicamentos(): ?string
    {
        return $this->recibe_medicamentos;
    }

    public function setRecibeMedicamentos(string $recibe_medicamentos): static
    {
        $this->recibe_medicamentos = $recibe_medicamentos;

        return $this;
    }

    public function getPaciente(): ?Paciente
    {
        return $this->paciente;
    }

    public function setPaciente(?Paciente $paciente): static
    {
        $this->paciente = $paciente;

        return $this;
    }
}
