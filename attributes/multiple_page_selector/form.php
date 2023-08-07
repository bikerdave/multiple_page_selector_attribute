<?php
defined('C5_EXECUTE') or die("Access Denied.");

/** @var string $uniqueID */
/** @var array $pages */
?>

<div id="mpsapp-<?= $uniqueID; ?>">

    <table class="table" style="vertical-align: middle;">
        <tbody>
            <template v-for="(page, index) in pages" :key="index">
                <tr>
                    <td class="page-selector-container"><div :data-cid="page.cID" class="page-selector-init"></div></td>
                    <td style="width: 45px;"><button class="btn btn-danger btn-sm page-remove pull-right" @click.prevent="removePage(index)"><i class="fa fa-times"></i></button></td>
                    <td style="width: 85px;"><button class="btn btn-link btn-sm" v-if="index !== 0"><i class="fa fa-arrow-up moveLink" @click.prevent="moveUp(index)"></i></button> <button class="btn btn-link btn-sm" v-if="index !== pages.length-1"><i class="fa fa-arrow-down moveLink" @click.prevent="moveDown(index)"></i></button></td>
                </tr>
            </template>
        </tbody>
    </table>

    <button class="btn btn-primary" @click.prevent="addPage"><?= t('Add Page'); ?></button>
</div>

<script>
    new Vue({
        el: '#mpsapp-<?= $uniqueID; ?>',
        data: {
            pages: <?= json_encode($pages); ?>,
        },
        mounted: function () {

            $( "#mpsapp-<?= $uniqueID; ?> .page-selector-init" ).each(function( index ) {
                $(this).concretePageSelector({
                    'inputName': '<?= $this->field('cID'); ?>[]',
                    'cID' : $(this).data('cid'),
                    'chooseText' : '<?= t('Select Page'); ?>'
                });
            });

            $('#mpsapp-<?= $uniqueID; ?> .page-selector-init').removeClass('page-selector-init');
        },
        updated: function () {
            for (let i = 0; i < this.pages.length; i++) {
                $('#mpsapp-<?= $uniqueID; ?> .page-selector-container').eq(i).html('<div class="page-selector-init"></div>');
                $('#mpsapp-<?= $uniqueID; ?> .page-selector-init').concretePageSelector({
                    'inputName': '<?= $this->field('cID'); ?>[]',
                    'cID' : this.pages[i].cID,
                    'chooseText' : 'Select Page'
                });

                $('#mpsapp-<?= $uniqueID; ?> .page-selector-init').removeClass('page-selector-init');
            }
        },
        methods: {
            addPage: function (event) {
                this.updateCIDs();
                this.pages.push({
                    cID: ''
                });
            },
            removePage: function (index) {
                this.updateCIDs();
                this.pages.splice(index, 1);
            },
            moveUp: function(rowIndex) {
                this.updateCIDs();
                this.pages.splice(rowIndex - 1, 0, this.pages.splice(rowIndex, 1)[0]);
            },
            moveDown: function (rowIndex) {
                this.updateCIDs();
                this.pages.splice(rowIndex + 1, 0, this.pages.splice(rowIndex, 1)[0]);
            },
            updateCIDs: function() {
                let pages = this.pages;
                $('#mpsapp-<?= $uniqueID; ?> .page-selector-container input').each(function(index){
                    pages[index].cID = $(this).val() > 0 ? $(this).val() : '';
                });
            }
        }
    });
</script>

<style>
    .moveLink {
        cursor: pointer;
    }
</style>

