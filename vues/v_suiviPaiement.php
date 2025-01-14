<?php
/**
 * Vue de mise en paiement ou de passage à remboursée 
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

<hr>
<form method='post'
    action='index.php?uc=suivrePaiement&action=payeeOuRemboursee'
    role='form'>
    <fieldset class="p-t-1 p-l-1 p-r-1 p-b-1">
    <?php
    if ($libEtat == 'Validée') {
        ?>
        <button class='btn btn-success pull-right' type='submit'>
            Mettre la fiche en paiement
        </button>
        <?php
    } else if ($libEtat == 'Mise en paiement') {
        ?>
        <button class='btn btn-success pull-right' type='submit'>
            Mettre la fiche à l'état 'Remboursée'
        </button>
        <?php
    }
    ?>
    </fieldset>
</form>
