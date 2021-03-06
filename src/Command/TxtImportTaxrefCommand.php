<?php

namespace App\Command;

use App\Entity\Bird;
use App\Entity\BirdFamily;
use App\Entity\BirdStatus;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TxtImportTaxrefCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('txt:import:taxref')
            ->setDescription('Importe la base Taxref')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $fileToImport = 'data_import_all.txt';

        $tabProtected = ['E', 'S', 'C', 'I', 'M', 'B', 'D', 'A', 'W', 'E', 'Y', 'Z'];

        // important, permet de ne pas écrire dans le logger de la bdd,
        // ce qui allège grandement l'utilisation de la mémoire
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $io = new SymfonyStyle($input, $output);

        $io->title('Traitement du fichier "'. $fileToImport .'"');

        $stream = fopen('%kernel.root_dir%/../src/Data/'. $fileToImport, 'r');

        $reader = Reader::createFromStream($stream);

        $reader->setDelimiter("\t"); // définie la tabulation comme délimiteur dans le fichier
        $reader->setHeaderOffset(0); // récupère les entêtes du fichier

        $io->text('Lecture du fichier en cours...');
        $records = $reader->getRecords();
        $nb = iterator_count($records);

        $io->text('Nombre de ligne détectée dans le fichier : '. $nb);
        $io->text('Débute le parcours du fichier');
        $io->text('');

        $io->progressStart($nb); // bar de progression

        $batchSize = 50;
        $i = 1;
        $detectedClassAves = false;

        foreach ($records as $row) {
            if (
                'Aves' === $row['CLASSE'] &&
                '' !== $row['NOM_VERN']
            )
            {
                if (false === $detectedClassAves)
                {
                    $io->text('');
                    $io->section('Classe Aves détectée, importation en base');
                    $detectedClassAves = true;
                }

                $birdStatus = $this->em->getRepository(BirdStatus::class)
                    ->findOneBy([
                        'label' => $row['FR'],
                    ]);
                if (
                    null === $birdStatus &&
                    '' !== $row['FR']
                )
                {
                    $birdStatus = (new BirdStatus())
                        ->setLabel($row['FR']);
                    $this->em->persist($birdStatus);
                    $this->em->flush();
                }

                $birdFamily = $this->em->getRepository(BirdFamily::class)
                    ->findOneBy([
                        'label' => $row['FAMILLE'],
                    ]);
                if (
                    null === $birdFamily &&
                    '' !== $row['FAMILLE']
                )
                {
                    $birdFamily = (new BirdFamily())
                        ->setLabel($row['FAMILLE']);
                    $this->em->persist($birdFamily);
                    $this->em->flush();
                }

                $bird = $this->em->getRepository(Bird::class)
                    ->findOneBy([
                        'taxrefVern' => trim($row['NOM_VERN']),
                    ])
                ;
                if (
                    null === $bird &&
                    '' != $row['NOM_VERN'] &&
                    null !== $birdFamily
                )
                {
                    $bird = (new Bird())
                        ->setProtected(false)
                        ->setTaxrefCdName($row['CD_NOM'])
                        ->setTaxrefClass($row['CLASSE'])
                        ->setTaxrefVern(trim($row['NOM_VERN']))
                        ->setTaxrefUrlImage($row['URL']);
                    $this->em->persist($bird);

                    if (null !== $birdFamily) {
                        $bird->setBirdFamily($birdFamily->getId());
                    }

                    if (null !== $birdStatus) {
                        $bird->setBirdStatus($birdStatus->getId());

                        if (in_array($birdStatus->getLabel(), $tabProtected)) {
                            $bird->setProtected(true);
                        }
                    }

                    $this->em->flush();

                    if (0 === ($i % $batchSize))
                    {
                        // permet de vider le cache concernant les objets birds
                        $this->em->clear(Bird::class);
                    }

                    $i++;
                }
            }


            if (
                'Aves' !== $row['CLASSE'] &&
                true === $detectedClassAves
            )
            {
                $io->section('Fin de section de la classe Aves, continue la lecture du fichier');
                $detectedClassAves = false;
            }

            $io->progressAdvance();
        }

        $this->em->flush();
        // vide tout le cache de l'entité manager interface
        $this->em->clear();

        $io->progressFinish();

        $io->success('Traitement du fichier terminé');
    }
}
