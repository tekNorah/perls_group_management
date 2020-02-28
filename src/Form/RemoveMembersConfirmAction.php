<?php

namespace Drupal\perls_group_management\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\views_bulk_operations\Form\ConfirmAction;

/**
 * PERLS Group Management VBO action execution confirmation form.
 */
class RemoveMembersConfirmAction extends ConfirmAction {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $view_id = NULL, $display_id = NULL) {
    $form = parent::buildForm($form, $form_state, $view_id, $display_id);

    // When deleting a group which has group members.
    // Group ID may not be available from the form state.
    $group_id = NULL;
    $group_label = NULL;

    // Check if Group ID is available from the form state.
    if (isset($form_state->getStorage()['views_bulk_operations']['arguments'][0])) {
      $group_id = $form_state->getStorage()['views_bulk_operations']['arguments'][0];
    }
    // Get the Group Label.
    if ($group_id) {
      $group_label = \Drupal::entityTypeManager()->getStorage('group')->load($group_id)->label();
    }

    // Only alter Confirm form if it a is valid group.
    if ($group_label) {
      // Change Form title to more natural language.
      $form["#title"] = t('Are you sure you wish to Remove the following members from the "@group_label" group?', ['@group_label' => $group_label]);

      // Change List title to more natural language.
      $total_results = $form_state->getStorage()['views_bulk_operations']['total_results'];
      if (!empty($total_results)) {
        $form['list']['#title'] = t('Selected @count group members:', ['@count' => $total_results]);
      }

      // Change Submit button label to be more relevant to action.
      $form['actions']['submit']['#value'] = t('Remove members');
    }

    return $form;

  }

}
