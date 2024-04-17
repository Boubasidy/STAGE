<?php

namespace App\Controller;

use App\Entity\AnneeUniversitaire;
use App\Entity\Element;
use App\Entity\Epreuve;
use App\Entity\Etudiant;
use App\Entity\Note;
use App\Form\NoteType;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;

class EtudiantController extends AbstractController
{
    /*private $entityManager;
    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }*/
    private $codeep;
    private $insertionReussie = 0;
    private $insertionNonReussie = [];

    #[Route('etudiant', name: 'app_etudiant')]
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }

    #[Route('/etudiant/information', name: 'etudiant_information')]
    public function etudiant_information(Request $request, EtudiantRepository $etudiantRepository, EntityManagerInterface $em, managerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $validator = Validation::createValidator();
        $form = $this->createFormBuilder()
            ->add('csv_file', FileType::class, [
                'label' => 'Fichier CSV',
                'attr' => [
                    'accept' => '.csv',
                    'multiple' => false,
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                ],
                'help' => 'Cliquez ici pour obtenir de l\'aide sur le format du fichier CSV.',
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $csvFile = $form->get('csv_file')->getData();
            // Traiter le fichier CSV et renvoyer les données
            // ...
            $file = fopen($csvFile->getPathname(), 'r');
            $csvData = [];

            $headers = fgetcsv($file);

            while (($data = fgetcsv($file)) !== false) {
                $rowData = [];
                foreach ($headers as $index => $header) {
                    $rowData[$header] = $data[$index] ?? null;
                }
                $csvData[] = $rowData;
            }

            fclose($file);
            foreach ($csvData as $record) {
                //creation de l'etudiant
                if (!empty($record['numetd'])) {
                    if (!$entityManager->getRepository(Etudiant::class)->findOneBy(["numetd" => $record['numetd']])) {
                        $etudiant = new Etudiant();
                        $etudiant->setNumetd($record['numetd']);
                        $etudiant->setPrenom($record['prenom']);
                        $etudiant->setNom($record['nom']);
                        $etudiant->setSexe($record['sexe']);
                        //$date_string = $record['datenaiss.'];
                        //$date = \DateTime::createFromFormat('d/m/Y', $date_string);
                        //$etudiant->setDatnaiss($date);
                        $etudiant->setEmail($record['email']);
                        $etudiant->setVillnaiss($record['villnaiss']);
                        $etudiant->setDepnaiss($record['depnaiss']);
                        //$etudiant->setAdresse($record['bur.dis.2'].' '.$record['lib.bdi2']);
                        $etudiant->setNationalite($record['nationalite']);
                        $etudiant->setTel($record['tel']);
                        $etudiant->setDerdiplome($record['derdiplome']);
                        $etudiant->setRegistre($record['registre']);
                        $etudiant->setStatut($record['statut']);
                        $etudiant->setSports($record['sports']);
                        $etudiant->setHandicape($record['handicape']);
                        //$date_string = $record['dateinsc'];
                        //$date = \DateTime::createFromFormat('d/m/Y', $date_string);


                        //$etudiant->setDateinsc($date);
                    }

                    #$date_string = $record['date nai.'];
                    #dd($date_string);
                    /*$date_format = 'dd/mm/YY';
                    $date1 = DateTimeImmutable::createFromFormat($date_format, $date_string);*/ else {

                        $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(["numetd" => $record['numetd']]);
                        /*$etudiant->setNationalite($record['nationalite']);
                        $etudiant->setTel($record['tel']);
                        //$etudiant->setAdresse($record['bur.dis.2'].' '.$record['lib.bdi2']);
                        $etudiant->setDerdiplome($record['derdiplome']);
                        $etudiant->setRegistre($record['registre']);
                        $etudiant->setStatut($record['statut']);
                        $etudiant->setSports($record['sport']);
                        $etudiant->setHandicape($record['handicape']);

                        $date_string = $record['dateinsc'];
                        $date = \DateTime::createFromFormat('d/m/Y', $date_string);


                        $etudiant->setDateinsc($date);*/
                    }

                    //validation sur la base de données
                    $errors = $validator->validate($etudiant);
                    if (count($errors) > 0) {
                        // Gérer les erreurs de validation pour l'entité
                        foreach ($errors as $error) {
                            echo $error->getMessage() . "\n";
                        }
                    } else {
                        $entityManager->persist($etudiant);
                        $entityManager->flush();
                        $this->insertionReussie++;
                    }
                }
            }
            // Traitement du formulaire ici, par exemple enregistrer le fichier CSV
            // $formData = $form->getData();
            // Faire quelque chose avec les données du formulaire

            // Redirection après traitement
            return $this->redirectToRoute('etudiant_visualisation');
        }

        return $this->render('etudiant/info.html.twig', [
            'form' => $form->createView(),
            'insertionReussie' => $this->insertionReussie
            // Passer le formulaire à la vue Twig
        ]);
    }

    #[Route('etudiant/note', name: 'etudiant_note')]
    public function etudiant_note(Request $request, managerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $validator = Validation::createValidator();
        $form = $this->createFormBuilder()
            ->add('csv_file', FileType::class, [
                'label' => 'Fichier CSV',
                'attr' => [
                    'accept' => '.csv',
                    'multiple' => false,
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                ],
                'help' => 'Cliquez ici pour obtenir de l\'aide sur le format du fichier CSV.',
            ])
            ->add('anneeuniversitaire', EntityType::class, [
                'class' => AnneeUniversitaire::class,
                'choice_label' => 'annee',
            ])
            ->add('element', EntityType::class, [
                'class' => Element::class,
                'choice_label' => 'codeelt',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $csvFile = $form->get('csv_file')->getData();
            // Traiter le fichier CSV et renvoyer les données
            // ...
            $file = fopen($csvFile->getPathname(), 'r');
            $csvData = [];


            while (($data = fgetcsv($file)) !== false) {
                $data_tab = explode('-', $data[0]);
                $csvData[] = $data_tab;
            }

            fclose($file);
            foreach ($csvData as $record) {
                $note = new Note();
                $note->setNote($record[2]);
                $etudiant = $entityManager->getRepository(Etudiant::class)->findOneBy(["numetd" => $record[0]]);
                $note->setEtudiant($etudiant);
                $note->setElement($form->get('element')->getData());
                $note->setAnneeuniversitaire(($form->get('anneeuniversitaire')->getData()));

                $errors = $validator->validate($note);
                if (count($errors) > 0) {
                    // Gérer les erreurs de validation pour l'entité
                    foreach ($errors as $error) {
                        echo $error->getMessage() . "\n";
                    }
                } else {
                    $this->codeep = $form->get('element')->getData();
                    $entityManager->persist($note);
                    $entityManager->flush();
                }
            }


            return $this->redirectToRoute('note_visualisation');
        }


        return $this->render('etudiant/note.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('etudiant/visualisation', name: 'etudiant_visualisation')]
    public function etudiant_visualisation(managerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $etudiants = $entityManager->getRepository(Etudiant::class)->findAll();

        return $this->render('etudiant/visualisation.html.twig', [
            'etudiants' => $etudiants,
        ]);
    }
    #[Route('etudiant/visualisationNote', name: 'note_visualisation')]
    public function note_visualisation(managerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $epreuve = $entityManager->getRepository(Epreuve::class)->findOneBy(["codeepreuve" => 'EPREUVE1']);
        $type = $epreuve->getTypeepreuve();
        $nommat = $epreuve->getMatiere()->getNommat();
        $notes = $epreuve->getElement()->getNotes();
        $long = $notes->count();
        $somme = 0;
        $comptmoyen = 0;
        $comptvalid = 0;
        foreach ($notes as $note) {
            $somme = $somme + $note->getNote();
        }
        $moyen = $somme / $long;
        foreach ($notes as $note) {
            if ($note->getNote() >= $moyen) {
                $comptmoyen = $comptmoyen + 1;
            }
            if ($note->getNote() >= 10) {
                $comptvalid = $comptvalid + 1;
            }
        }



        return $this->render('etudiant/visualisationNote.html.twig', [
            'type' => $type,
            'notes' => $notes,
            'nommat' => $nommat,
            'long' => $long,
            'moyen' => $moyen,
            'compteurmoy' => $comptmoyen,
            'compteurval' => $comptvalid,
        ]);
    }
}
