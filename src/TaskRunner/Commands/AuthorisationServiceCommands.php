<?php

declare(strict_types = 1);

namespace Ec\Europa\AuthorisationServiceDev\TaskRunner\Commands;

use GuzzleHttp\Client;
use OpenEuropa\SyncopePhpClient\Configuration;
use OpenEuropa\SyncopePhpClient\SyncopePhpClient\Api\AccessTokensApi;
use OpenEuropa\SyncopePhpClient\SyncopePhpClient\Api\SchemasApi;
use OpenEuropa\TaskRunner\Commands\AbstractCommands;
use OpenEuropa\SyncopePhpClient\Model\SchemaTO;

/**
 * Class AuthorisationServiceCommands.
 */
class AuthorisationServiceCommands extends AbstractCommands {

  /**
   * Setups Authorisation Service demo data.
   *
   * @command oe-authorisation-service:setup
   */
  public function runAuthorisationServiceSetup(): void {
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
      echo 'Exception when calling SchemasApi->createSchema: ', $e->getMessage(), PHP_EOL;
    }



  }

}
