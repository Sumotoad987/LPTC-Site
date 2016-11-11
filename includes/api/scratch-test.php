<?php
  /**
   * Functional tests for the Scratch API helper classes.
   */
  require_once('scratch.php');

  // ScratchProjects Tests
  assert_options(ASSERT_BAIL, 1);

  $projects = ScratchProjects::getUserShared('kyla_errity');
  assert(
    count($projects) > 0,
    'Check that more than one projects are returned.'
  );
  assert(
    !empty($projects[0]['id']),
    'Check that a project ID is returned.'
  );

  $project = ScratchProjects::getUserProjectById('kyla_errity', '101499178');
  assert(
    $project['id'] === 101499178,
    'Check that the returned project ID equals 101499178.');

  $response = ScratchProjects::getUserFavorites('kdsjhfksjdhfakfhsakdjfh');
  assert(
    $response['HttpCode'] === 404,
    'Check that the response code for the invalid user is 404.'
  );

  echo('All Scratch API tests passed!')
?>
