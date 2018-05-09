<?php

namespace App\Controller;

use App\Entity\Observation;
use App\Form\AppObservationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ObservationController extends Controller
{

    /**
     * @Route("/observation", name="observation")
     */
    public function observationAction(SessionInterface $session)
    {
        $user = $session->get('users');
        $userId = $user->getId();

//        On récupère les observations selon l'id de l''user
        $observations = $this->container->get('appbundle.observations')->getObservationsById($userId);

//        On récupère ensuite un array des oiseaux associés à une ou plusieurs obs pour un même user
        $birds = $this->container->get('appbundle.birds')->getBirdsByObs($observations);

        return $this->render('observations/user_observation.html.twig', array('birds' => $birds, 'users' =>$user));

    }

    /**
     * @Route("/bird/{id}", name="birdInfos")
     */
    public function birdInformations($id)
    {

        $bird = $this->container->get('appbundle.birds')->getBirdById($id);

        return $this->render('observations/birdInformations.html.twig', array('bird' => $bird));
    }

    /**
     * @Route("/addObservation", name="addObservation")
     */
    public function addObservation(Request $request, SessionInterface $session)
    {
        $newObservation = new Observation();
        $form = $this->createForm(AppObservationType::class, $newObservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // On vérifie qu'il n'y ait pas d'erreur de formulaire (date / type de donnée dans le champ)
            $check = $this->container->get('appbundle.observations')->checkObservation($newObservation);

            if($check == 'errorDate')
            {
                $this->addFlash("error", "Attention, la date sélectionnée ne peut pas être supérieure à la date du jour...");
                return $this->redirectToRoute('addObservation');
            }
            else if ($check == 'errorFloat')
            {
                $this->addFlash("error", "Attention, la longitude et la latitude doivent être des nombres...");
                return $this->redirectToRoute('addObservation');
            }
            else {

                $em = $this->getDoctrine()->getManager();

                $user = $session->get('users');
                $userid = $user->getId();

                $newObservation->setUser($userid);
                // Par défaut, on attribue cette valeur à 0 pour permettre le lien en validation via la modification de cette valeur
                $newObservation->setBird(0);

                $em->persist($newObservation);
                $em->flush();

                $this->addFlash("success", "Merci pour votre participation, votre soumission a bien été transmise à nos experts !");
                return $this->redirectToRoute('addObservation');
            }
        }

        return $this->render('observations/add_observation.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/validateObs", name="validateObs")
     */
    public function validateObs()
    {
        // On récupère les observations avec la valeur Bird à 0
        $obs = $this->container->get('appbundle.observations')->getUnvalidateObs();

        return $this->render('observations/validate_observations.html.twig', array('obs' => $obs));
    }

    /**
     * @Route("/validateObsBird/{id}", name="validateObsBird")
     */
    public function validateObsBird($id)
    {
        $birdID = $_POST['birdID'];
        // On vérifie que la valeur saisie corresponde bien à un oiseau existant en BDD
        $birdExistant = $this->container->get('appbundle.birds')->getExistingBird($birdID);
        if($birdExistant == null) {
            $this->addFlash("error", "Attention, il n'y a pas de TaxRefCdName associé au numéro rentré...");
            return $this->redirectToRoute('validateObs');
        }
        else{

            // On update via DQL en fonction de l'id
            $this->container->get('appbundle.observations')->updateBirdID($birdExistant,$id);
            return $this->redirectToRoute('validateObs');
        }
    }

    /**
     * @Route("/deleteObs/{id}", name="deleteObs")
     */
    public function deleteObs($id)
    {
        // On supprime l'enregistrement de l'observation existante en BDD
        $this->container->get('appbundle.observations')->deleteObsById($id);

        return $this->redirectToRoute('validateObs');

    }

    /**
     * @Route("/getObservationsForMap/{birdID}", name="getObservationsForMap", options={"expose"=true})
     *
     * @param null $birdID
     *
     * @return Response
     */
    public function getObservationsForMap($birdID = null)
    {
        $em = $this->getDoctrine()->getManager();
        $obs = $em->getRepository('App:Observation')->getObservationsForMap($birdID);

        return new Response(json_encode($obs));
    }
}