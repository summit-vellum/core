<?php

namespace Vellum\Contracts;


/**
 *
 */
interface Actionable
{
  /**
   * Icon to display in the resource row.
   */
  public function icon();

  /**
   * Actionable link to trigger.
   */
  public function link(int $id, $data);

  /**
   * User permission linked to model.
   */
  public function permission();

  /**
   * Parent element styles.
   */
  public function styles();
}
