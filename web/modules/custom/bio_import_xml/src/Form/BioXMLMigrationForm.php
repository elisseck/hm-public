<?php
/**
 * @file
 * Administrative form for migrating Biographies from Filemaker to Drupal.
 */
namespace Drupal\bio_import_xml\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\bio_import_xml\Helpers;

class BioXMLMigrationForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [ 'bio_import_xml.settings' ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'bio_import_xml_migration_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $formId = $this->getFormId();

        // TODO: Display data in migration table marked as "new"

        $form[$formId] = [
            '#type' => 'fieldset',
            '#title' => t('Import Filemaker XML Feed.'),
        ];

        $form[$formId]['clean_xml'] = [
            '#type' => 'submit',
            '#value' => t('1. Clean feed.'),
            '#submit' => [ '::clean' ],
        ];
        $form[$formId]['ingest_xml'] = [
            '#type' => 'submit',
            '#value' => t('2. Validate and store feed records'),
            '#submit' => [ '::ingest' ],
        ];
        $form[$formId]['process_data'] = [
            '#type' => 'submit',
            '#value' => t('3. Import records to website'),
            '#submit' => [ '::import' ],
        ];
        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function clean() {
        $fmPath = $this->getEditableConfigNames()['fm_path'];

        $cleaned = Helpers\BioXMLMigrationCleaner::clean($fmPath);
        if ($cleaned) {
            \drupal_set_message(t('XML Document has been cleaned.'), 'status');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function ingest() {
        \drupal_set_message(t('populate custom table with xml data.'), 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function import() {
        \drupal_set_message(t('import as bonafide Drupal nodes.'), 'status');
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        parent::submitForm($form, $form_state);
    }
}