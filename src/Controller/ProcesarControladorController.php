<?php

namespace App\Controller;

use App\Entity\Paciente;
use App\Entity\Visita;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProcesarControlador extends AbstractController
{
    #[Route('/', name: "formulario")]
    public function index(): Response
    {
        return $this->render("paciente/index.html.twig");
    }

    #[Route('/procesar', name: "procesar_formulario", methods: ['POST'])]
    public function procesar(Request $request, EntityManagerInterface $em): Response
    {
        // Capturar datos del formulario
        $id_paciente = $request->request->get('id_paciente');
        $nombre = $request->request->get('nombre');
        $fecha_nac = $request->request->get('fecha_nac');
        $genero = $request->request->get('genero');
        $fecha_visita = $request->request->get('fecha_visita');
        $nombre_medico = $request->request->get('nombreMedico');
        $recibe_medicamentos = $request->request->get('generoMedicamentos');

        // Verificar si el paciente ya existe
        if ($id_paciente) {
            $paciente = $em->getRepository(Paciente::class)->find($id_paciente);
        }

        // Si no existe, crear nuevo paciente
        if (empty($id_paciente) || !$paciente) {
            $paciente = new Paciente();
            $paciente->setNombre($nombre);
            $paciente->setFechaNacimiento(new \DateTime($fecha_nac));
            $paciente->setGenero($genero);
            $em->persist($paciente);
            $em->flush();
        }

        // Crear la visita
        $visita = new Visita();
        $visita->setFechaVisita(new \DateTime($fecha_visita));
        $visita->setNombreMedico($nombre_medico);
        $visita->setRecibeMedicamentos($recibe_medicamentos);
        $visita->setPaciente($paciente);
        $em->persist($visita);
        $em->flush();

        // Guardar en archivo TXT
        $txtData = "Paciente: " . $paciente->getNombre() .
            " | Fecha Nac: " . $paciente->getFechaNacimiento()->format('Y-m-d') .
            " | Género: " . $paciente->getGenero() .
            " | Fecha Visita: " . $visita->getFechaVisita()->format('Y-m-d') .
            " | Médico: " . $visita->getNombreMedico() .
            " | Medicamentos: " . $visita->getRecibeMedicamentos() . "\n";
        file_put_contents('datos_paciente.txt', $txtData, FILE_APPEND);

        // Guardar en JSON paciente
        $pacienteData = [
            'id' => $paciente->getId(),
            'nombre' => $paciente->getNombre(),
            'fecha_nacimiento' => $paciente->getFechaNacimiento()->format('Y-m-d'),
            'genero' => $paciente->getGenero()
        ];
        file_put_contents('datos_paciente.json', json_encode($pacienteData, JSON_PRETTY_PRINT));

        // Guardar en JSON visita
        $visitaData = [
            'id' => $visita->getId(),
            'fecha_visita' => $visita->getFechaVisita()->format('Y-m-d'),
            'nombre_medico' => $visita->getNombreMedico(),
            'recibe_medicamentos' => $visita->getRecibeMedicamentos(),
            'paciente_id' => $paciente->getId()
        ];
        file_put_contents('visita.json', json_encode($visitaData, JSON_PRETTY_PRINT));

        return $this->render('paciente/respuesta.html.twig', [
            'paciente' => $paciente,
            'visita' => $visita
        ]);
    }
}