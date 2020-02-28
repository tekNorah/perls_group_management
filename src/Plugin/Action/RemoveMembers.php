<?php

namespace Drupal\perls_group_management\Plugin\Action;

use Drupal\Core\Session\AccountInterface;
use Drupal\views_bulk_operations\Action\ViewsBulkOperationsActionBase;

/**
 * Removes all selected users from current group.
 *
 * @Action(
 *   id = "perls_group_management_remove_members",
 *   label = @Translation("Remove members"),
 *   type = "group_content",
 *   confirm = TRUE,
 *   confirm_form_route_name = "perls_group_management.confirm",
 * )
 */
class RemoveMembers extends ViewsBulkOperationsActionBase {

  /**
   * {@inheritdoc}
   */
  public function execute($group_content = NULL) {
    $group_content->delete();
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    // Rely on view's permission settings instead.
    return TRUE;
  }

}
