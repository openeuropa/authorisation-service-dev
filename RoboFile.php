<?php

use Robo\Contract\ConfigAwareInterface;

/**
 * Authorisation service dev commands.
 */
class RoboFile extends \Robo\Tasks implements ConfigAwareInterface {

  use \Robo\Common\ConfigAwareTrait;

  /**
   * Setups authorisation service demo data.
   */
  public function setup(): void {
    $username = $this->getConfig()->get('authorisation.server.username');
    $password = $this->getConfig()->get('authorisation.server.password');
    $endpoint = $this->getConfig()->get('authorisation.server.endpoint');

    $config = Configuration::getDefaultConfiguration()
      ->setUsername($username)
      ->setPassword($password)
      ->setHost($endpoint);

    // Provisions schema.
    $apiInstance = new SchemasApi(
      new Client(),
      $config
    );

    $xSyncopeDomain = 'Master';
    $schemaTO = new SchemaTO(['key' => 'eulogin_id']);

    try {
      $apiInstance->createSchema('string', $xSyncopeDomain, $schemaTO);
    } catch (Exception $e) {
      echo 'Exception when calling SchemasApi->createSchema: ', $e->getMessage(
      ), PHP_EOL;
    }
  }

}
