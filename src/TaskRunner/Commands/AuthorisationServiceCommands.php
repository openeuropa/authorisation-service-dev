<?php

declare(strict_types = 1);

namespace Ec\Europa\AuthorisationServiceDev\TaskRunner\Commands;

use GuzzleHttp\Client;
use OpenEuropa\SyncopePhpClient\Api\AnyTypeClassesApi;
use OpenEuropa\SyncopePhpClient\Api\AnyTypesApi;
use OpenEuropa\SyncopePhpClient\ApiException;
use OpenEuropa\SyncopePhpClient\Configuration;
use OpenEuropa\SyncopePhpClient\Model\AnyTypeClassTO;
use OpenEuropa\SyncopePhpClient\Api\SchemasApi;
use OpenEuropa\SyncopePhpClient\Model\AnyTypeTO;
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
      ->setHost($endpoint)
      ->setDebug(TRUE);

    // Creates schema field.
    $schemaApi = new SchemasApi(
      new Client(),
      $config
    );

    $xSyncopeDomain = 'Master';
    $schemaTO = new SchemaTO(['key' => 'eulogin_id']);
    $schemaTO->setClass('org.apache.syncope.common.lib.to.PlainSchemaTO');

    try {
      $schemaApi->createSchema('PLAIN', $xSyncopeDomain, $schemaTO);
    }
    catch (ApiException $e) {
      echo 'Exception when calling SchemasApi->createSchema: ', $e->getMessage(), PHP_EOL;
    }

    // Creates new AnyType class BaseOeUser.
    $anyTypeClassApi = new AnyTypeClassesApi(
      new Client(),
      $config
    );
    $anyTypeClassTo = new AnyTypeClassTO(['key' => 'BaseOeUser', 'plainSchemas' => ['eulogin_id']]);
    try {
      $anyTypeClassApi->createAnyTypeClass($xSyncopeDomain, $anyTypeClassTo);
    }
    catch (ApiException $e) {
      echo 'Exception when calling AnyTypeClassesApi->createAnyTypeClass: ', $e->getMessage(), PHP_EOL;
    }

    // Creates new AnyType OeUser.
    $anyTypeApi = new AnyTypesApi(
      new Client(),
      $config
    );

    $anyTypeTO = new AnyTypeTO(
      [
        'key' => 'OeUser',
        'kind' => 'ANY_OBJECT',
        'classes' => ['BaseOeUser'],
      ]);
    try {
      $anyTypeApi->createAnyType($xSyncopeDomain, $anyTypeTO);
    }
    catch (ApiException $e) {
      echo 'Exception when calling AnyTypesApi->createAnyType: ', $e->getMessage(), PHP_EOL;
    }

  }

}
