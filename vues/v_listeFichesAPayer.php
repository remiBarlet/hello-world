<?php
/**
 * Vue Liste des fiches à mettre en paiement
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
?>

<?php 
if ($lesMois == null) {
    ?> 
<hr>
<div class="row">
    <div class="col-md-6">
        <h3>Aucune fiche n'est validée pour ce visiteur</h3>
    </div>
</div>
    <?php
} else {
    ?>
<div class="row">
    <div class='col-md-4'>
    <h3>Sélectionner une fiche validée: </h3>
    </div>
    <form action="index.php?uc=suivrePaiement&action=afficherFicheValidee"
              method="post" role="form">   
        <div class="col-md-4 p-t-1">
            <select id="lstMois" name="lstMois" class="form-control">
                <?php
                foreach ($lesMois as $unMois) {
                    $mois = $unMois['mois'];
                    $numAnnee = $unMois['numAnnee'];
                    $numMois = $unMois['numMois'];
                    if ($mois == $moisASelectionner) {
                        ?>
                        <option selected value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?></option>
                        <?php
                    } else {
                        ?>
                        <option value="<?php echo $mois ?>">
                            <?php echo $numMois . '/' . $numAnnee ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-4 p-t-1">    
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                role="button">
        </div>        
    </form>
</div>
    <?php
}
?>
