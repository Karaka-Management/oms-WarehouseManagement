<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\Profile
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

$location = $this->getData('location');

echo $this->getData('nav')->render();
?>
<div class="row">
    <div class="col-xs-12">
        <section class="portlet">
            <div class="portlet-head"><?= $this->printHtml($location->name); ?></div>
            <div class="portlet-body">
        </section>
    </div>
</div>