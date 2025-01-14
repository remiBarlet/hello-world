<?php
/**
 * Vue État de Frais
 *
 * PHP Version 7
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */
?>
<hr>
<?php
if ($_SESSION['comptable']) {
    ?>
<div class="panel panel-comptable">
    <?php
} else {
    ?>
    <div class="panel panel-primary">
        <?php
}
?>
        <div class="panel-heading">Fiche de frais du mois de
            <?php setlocale(LC_TIME, "fr_FR.UTF-8");
        echo ' ' . strftime(
            "%B", 
            strtotime($numMois.'/01/'.$numAnnee)
        ) . ' ' . $numAnnee?> : </div>
        <div class="panel-body">
            <strong><u>Etat:</u></strong> <?php echo $libEtat ?>
            depuis le <?php echo $dateModif ?> <br>
            <strong><u>Montant validé:</u></strong> <?php 
        if ($montantValide != null) {
            echo $montantValide . ' €';
        } else {
            echo 'la fiche n\'a pas encore été validée';
        } ?>
        </div>
    </div>
    <?php 
if ($_SESSION['comptable']) {
    ?>
    <div class="panel panel-comptable">
        <?php
} else {
    ?>
        <div class="panel panel-info">
            <?php
}
?>
            <div class="panel-heading">Eléments forfaitisés</div>
            <table class="table table-bordered table-responsive">
                <tr>
                    <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $libelle = $unFraisForfait['libelle']; ?>
                    <th> <?php echo htmlspecialchars($libelle) ?></th>
                    <?php
            }
            ?>
                </tr>
                <tr>
                    <?php
            foreach ($lesFraisForfait as $unFraisForfait) {
                $quantite = $unFraisForfait['quantite']; ?>
                    <td class="qteForfait"><?php echo $quantite ?> </td>
                    <?php
            }
            ?>
                </tr>
            </table>
        </div>
        <?php 
if ($_SESSION['comptable']) {
    ?>
        <div class="panel panel-comptable">
            <?php
} else {
    ?>
            <div class="panel panel-info">
                <?php
}
?>
                <div class="panel-heading">Descriptif des éléments hors forfait -
                    <?php if ($nbJustificatifs == null) {
            echo 0; 
        } else {
            echo $nbJustificatifs;
        }
        if ($nbJustificatifs < 2) {
            ?> justificatif reçu
                    <?php 
        } else {
            ?> justificatifs reçus
                    <?php
        }
        ?>
                </div>
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>
                        <th class='montant'>Montant</th>
                    </tr>
                    <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            $date = $unFraisHorsForfait['date'];
            $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
            $montant = $unFraisHorsForfait['montant']; ?>
                    <tr>
                        <td><?php echo $date ?></td>
                        <td><?php echo $libelle ?></td>
                        <td><?php echo $montant ?></td>
                    </tr>
                    <?php
        }
        ?>
                </table>
            </div>