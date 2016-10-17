<?php
//phpinfo(); die;
ini_set('soap.wsdl_cache_enabled',0);
ini_set('soap.wsdl_cache_ttl',0);
         $client = new SoapServer( 'https://swsim.testing.stamps.com/swsim/SwsimV35.asmx?WSDL');
                  
$params = new SoapVar('<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <AuthenticateUser xmlns="https://swsim.testing.stamps.com/swsim/SwsimV35.asmx?WSDL">
      <Credentials>
        <IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</IntegrationID>
        <Username>picnframes</Username>
        <Password>postage1</Password>
      </Credentials>
    </AuthenticateUser>
  </soap:Body>
</soap:Envelope>');
$result = $client->Result($params);
print_r($result);
echo 'here';
    ?>
