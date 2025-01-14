<?php
/**
 * Gestion de l'affichage des visiteurs pour validation 
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Rémi Barlet <rbarlet@protonmail.com>
 * @copyright 2019 Rémi Barlet
 * @license   ???
 * @link      ???
 */

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
switch ($action) {
//cas ou la page est affichée depuis la vue entête
case 'saisirVisiteurMois':
    //cloture des mois antérieurs
    $moisACloturer = $pdo->clotureFiches();
    //réinitialisation des variables de session visiteur et mois
    $_SESSION['visiteur'] = null;
    $_SESSION['mois'] = null;
    //sélection du visiteur par défaut ou choisi par l'utilisateur
    $leVisiteur = filter_input(INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING);
    $lesVisiteurs = $pdo->getListeVisiteurs();
    if ($leVisiteur == null) {
        $lesCles = array_keys($lesVisiteurs);
        $visiteurASelectionner = $lesCles[0][0];
    } else {
        $visiteurASelectionner = $leVisiteur;
    }
    //sélection du mois
    $lesMois = $pdo->getLesMoisAValider();
    /* 
    * Afin de sélectionner par défaut le dernier mois dans la zone de liste
    * on demande toutes les clés, et on prend la première,
    * les mois étant triés décroissants
    */
    $lesClesMois = array_keys($lesMois);
    $moisASelectionner = $lesClesMois[0];
    include 'vues/v_listeVisiteursMois.php';
    include 'vues/v_pied.php';    
    break;

case 'afficherFichesSaisies':
    //effet de la validation du formulaire de choix du visiteur/mois
    $_SESSION['visiteur'] = filter_input(
        INPUT_POST, 'lstVisiteurs', FILTER_SANITIZE_STRING
    );
    $_SESSION['mois'] = filter_input(
        INPUT_POST, 'lstMois', FILTER_SANITIZE_STRING
    );
    //enregistrement des listes des visiteurs et des mois à valider
    $lesVisiteurs = $pdo->getListeVisiteurs();
    $lesMois = $pdo->getLesMoisAValider();
    //enregistrement des visiteur/mois affichés par défaut dans le form de sélection
    $visiteurASelectionner = $_SESSION['visiteur'];
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/v_listeVisiteursMois.php';
    //message affiché par le formulaire de modification des frais forfaitisés
    $messageModif = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    //infos fiche pour la vue résumé
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    //variables pour la vue résumé
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    //variable à afficher dans le formulaire frais forfaitisés
    $lesFraisForfait = $pdo->getLesFraisForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    //variable à afficher dans le formulaire frais hors forfait
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    include 'vues/v_validationFichesResume.php';
    include 'vues/v_validationFraisForfait.php';
    include 'vues/v_validationFraisHorsForfait.php';
    include 'vues/v_validationFiche.php';     
    include 'vues/v_pied.php';    
    break;  

case 'validationForfait':
    //enregistrement des listes des visiteurs et des mois à valider
    $lesVisiteurs = $pdo->getListeVisiteurs();
    $lesMois = $pdo->getLesMoisAValider();
    //enregistrement des visiteur/mois affichés par défaut dans le form de sélection
    $visiteurASelectionner = $_SESSION['visiteur'];
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/v_listeVisiteursMois.php';
    //variables destinées à la vue v_validationFichesResume.php
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais(
        $visiteurASelectionner, $moisASelectionner
    );
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    /*
    *message affiché par le formulaire de modification des frais forfaitisés 
    *qui vient d'être validé
    */
    $messageModif = 'Les modifications ont été prises en compte';

    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    $lesFrais = filter_input(
        INPUT_POST, 'lesFrais', FILTER_DEFAULT, FILTER_FORCE_ARRAY
    );
    if (lesQteFraisValides($lesFrais)) {
        $pdo->majFraisForfait(
            $visiteurASelectionner, $moisASelectionner, $lesFrais
        );
    } else {
        ajouterErreur('Les valeurs des frais doivent être numériques');
        include 'vues/v_erreurs.php';
    };
    $lesFraisForfait = $pdo->getLesFraisForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    include 'vues/v_validationFichesResume.php';
    include 'vues/v_validationFraisForfait.php';
    include 'vues/v_validationFraisHorsForfait.php';
    include 'vues/v_validationFiche.php';    
    include 'vues/v_pied.php';
    break;  

case 'validationHorsForfait' :
    //enregistrement des listes des visiteurs et des mois à valider
    $lesVisiteurs = $pdo->getListeVisiteurs();
    $lesMois = $pdo->getLesMoisAValider();
    //enregistrement des visiteur/mois affichés par défaut dans le form de sélection
    $visiteurASelectionner = $_SESSION['visiteur'];
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/v_listeVisiteursMois.php';
    //variables résumé
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais(
        $visiteurASelectionner, $moisASelectionner
    );
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    //variables destinées au formulaire de frais forfaitisés
    $messageModif = '';
    $lesFraisForfait = $pdo->getLesFraisForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    //Modif de la BDD
    //enregistrement des ids de frais refusés
    $lesIdsFraisRefus = $_POST['ligne']['refus'];
    $lesIdsFraisReport = $_POST['ligne']['report'];
    $ceMois = getMois(date('d/m/Y'));
    //création de la nouvelle fiche si inexistante
    if ($pdo->estPremierFraisMois($_SESSION['visiteur'], $ceMois)) {
        $pdo->creeNouvellesLignesFrais($_SESSION['visiteur'], $ceMois);
    }
    //modification de la BDD 
    foreach ($lesIdsFraisRefus as $uneIDRefus) {
        $pdo->majFraisHorsForfait('REFUSE : ', $uneIDRefus);
    }
    foreach ($lesIdsFraisReport as $uneIDReport) {
        $pdo->majFraisHorsForfait('REPORT : ', $uneIDReport);
    }
    //variable à afficher dans le formulaire frais hors forfait
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait(
        $_SESSION['visiteur'], $_SESSION['mois']
    );
    include 'vues/v_validationFichesResume.php';
    include 'vues/v_validationFraisForfait.php';
    include 'vues/v_validationFraisHorsForfait.php';
    include 'vues/v_validationFiche.php';
    include 'vues/v_pied.php';
    break;
    
case 'validationFiche':
    //enregistrement des listes des visiteurs et des mois à valider
    $lesVisiteurs = $pdo->getListeVisiteurs();
    $lesMois = $pdo->getLesMoisAValider();
    //enregistrement des visiteur/mois affichés par défaut dans le form de sélection
    $visiteurASelectionner = $_SESSION['visiteur'];
    $moisASelectionner = $_SESSION['mois'];
    include 'vues/v_listeVisiteursMois.php';
        //variables à afficher dans le formulaire frais forfaitisés
        $messageModif = '';
        $lesFraisForfait = $pdo->getLesFraisForfait(
            $_SESSION['visiteur'], $_SESSION['mois']
        );    
        //variable à afficher dans le formulaire frais hors forfait
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait(
            $_SESSION['visiteur'], $_SESSION['mois']
        );
    //action de la validation
    $libelleValidation = 'VA';
        //variables destinées au calcul du montant validé
        $montants = $pdo->getMontantsForfait();
        $montantTotal = 0;
        for ($i = 0; $i < count($montants); $i++) {
            $montantTotal += 
            floatval($montants[$i]['montant']) * 
            floatval($lesFraisForfait[$i]['quantite']);
        }
        for ($i = 0; $i < count($lesFraisHorsForfait); $i++) {
            $montantTotal += floatval($lesFraisHorsForfait[$i]['montant']);
        }
    $pdo->majEtatFicheFrais(
        $_SESSION['visiteur'], $_SESSION['mois'], $libelleValidation, $montantTotal
    );
    //variables résumé
    $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais(
        $visiteurASelectionner, $moisASelectionner
    );
    $numAnnee = substr($_SESSION['mois'], 0, 4);
    $numMois = substr($_SESSION['mois'], 4, 2);
    $libEtat = $lesInfosFicheFrais['libEtat'];
    $montantValide = $lesInfosFicheFrais['montantValide'];
    $nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
    $dateModif = dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
    include 'vues/v_validationFichesResume.php';
    include 'vues/v_validationFraisForfait.php';
    include 'vues/v_validationFraisHorsForfait.php';
    include 'vues/v_validationFiche.php';
    include 'vues/v_pied.php';    
    break;
}
?>