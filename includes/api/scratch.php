<?php
/**
 * Set of Helpers to retrieve Scratch resources via its REST API.
 *
 * TODO(spastorelli): Add helper classes for other API resources.
 *
 * API Documentation:
 *    https://github.com/LLK/scratch-rest-api/wiki
 */

/**
 * Helper class for the Projects resource.
 *
 * API Resource Documentation:
 *    https://github.com/LLK/scratch-rest-api/wiki/Projects
 */
class ScratchProjects
{
  /**
   * Returns list of projects shared by the $user.
   *
   * @param string $user The nickname of the user.
   */
  public static function getUserShared($user) {
    $resource = array('users', $user, 'projects');
    return ScratchRestApiRequest::send($resource);
  }

  /**
   * Returns the project shared by the $user using its $projectId.
   *
   * @param string $user The nickname of the user.
   * @param string $projectId The ID of the project.
   */
  public static function getUserProjectById($user, $projectId) {
    $resource = array('users', $user, 'projects', $projectId);
    return ScratchRestApiRequest::send($resource);
  }

  /**
   * Returns a list of the $user favorites projects.
   *
   * @param string $user The nickname of the user.
   */
  public static function getUserFavorites($user) {
    $resource = array('users', $user, 'favorites');
    return ScratchRestApiRequest::send($resource);
  }

}

/**
 * Simple wrapper around cURL to issue GET requests to Scratch REST API.
 *
 * Not intended to be used directly; Resources Helper classes should be used
 * instead.
 */
class ScratchRestApiRequest
{
  const BaseUrl = 'https://api.scratch.mit.edu';

  /**
   *  Creates the API resource URL from the resource path items.
   *
   * @param array $resourceItems An array containing the items of the resource
   *      path.
   * @return string The resource URL.
   */
  private static function _createResourceUrl(&$resourceItems) {
    $resourceUrl .= ScratchRestApiRequest::BaseUrl;
    foreach ($resourceItems as $i => $item) {
      $resourceUrl .= '/' . $item;
    }
    return $resourceUrl;
  }

  /**
   * Returns an initialized cURL request object.
   *
   * @param string $resourceUrl The API resource url.
   * @return mixed The initialized request object.
   */
  private static function _prepareHttpRequest($resourceUrl) {
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, $resourceUrl);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);

    return $request;
  }

  /**
   * Issues an API request to the specific resource path.
   *
   * @param array $resourceItems An array containing the items of the resource
   *      path.
   * @return array An associative array containing the API resource response
   *      data.
   */
  public static function send(&$resourceItems) {
    $resourceUrl = ScratchRestApiRequest::_createResourceUrl($resourceItems);
    $request = ScratchRestApiRequest::_prepareHttpRequest($resourceUrl);
    $response = curl_exec($request);
    $code = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);

    $data = json_decode($response, true);
    if ($code !== 200) {
      $errorDetails = array('HttpCode' => $code);
      $data = array_merge($data, $errorDetails);
    }
    return $data;
  }

}
?>
