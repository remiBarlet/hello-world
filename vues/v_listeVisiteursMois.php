<?php
/**
 * Vue Liste des visiteurs et du mois pour validation
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

<h2>Fiches de frais à valider</h2>
<div class="row">
    <h3>Sélectionner un visiteur médical : </h3>
</div>    
<div class="row">
    <form action="index.php?uc=validerFrais&action=validationFiches"
              method="post" role="form">
        <div class="col-md-10 col-md-offset-1">
            <div class="row">
                <div class="col-md-6">
                    <label for="lstVisiteurs" accesskey="n" class="p-t-1">Visiteur : </label>
                    <select id="lstVisiteurs" name="lstVisiteurs" class="form-control">
                        <?php
                        foreach ($lesVisiteurs as $unVisiteur) {
                            $prenom = $unVisiteur['prenom'];
                            $nom = $unVisiteur['nom'];
                            $id = $unVisiteur['id'];
                            if ($id == $visiteurASelectionner) {
                                ?> 
                        <option selected value="<?php echo $id ?>">
                                <?php echo $prenom . ' ' . $nom ?> </option>
                                <?php
                            } else {
                                ?>
                            <option value="<?php echo $id ?>">
                                <?php echo $prenom . ' ' . $nom ?> </option>
                                <?php
                            }
                        }
                        ?>    
                    </select>         
                </div>
                <div class="col-md-6">
                    <label for="lstMois" acceskey="m" class="p-t-1">Mois : </label>
                    <select id="lstMois" name="lstMois" class="form-control">
                        <?php
                        foreach ($lesMois as $unMois) {
                            $mois = $unMois['mois'];
                            $numAnnee = $unMois['numAnnee'];
                            $numMois = $unMois['numMois'];
                            if ($mois == $moisASelectionner) {
                                ?>
                                <option selected value="<?php echo $mois ?>">
                                    <?php echo $numMois . '/' . $numAnnee ?> </option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo $mois ?>">
                                    <?php echo $numMois . '/' . $numAnnee ?> </option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-md-offset-1 p-t-1">    
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                role="button">
            <input id="annuler" type="reset" value="Effacer" class="btn btn-danger" 
                role="button">
        </div>        
    </form>
</div>
