<?php 
/*$content ="<?xml version=\"1.0\" encoding=\"utf-8\"?><soapenv:Envelope xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" >
    <soapenv:Header/>
<soapenv:Body>
 <sws:PlaceOrder xmlns=\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36\">
<sws:Credentials>
<sws:IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</sws:IntegrationID>
<sws:Username>poloblade</sws:Username>
<sws:Password>polo6920</sws:Password>
</sws:Credentials>
<sws:Skus>
        <sws:Sku>
          <sws:Id>1</sws:Id>
          <sws:Quantity>10</sws:Quantity>
          <sws:SkuSubTotal>10.15</sws:SkuSubTotal>
        </sws:Sku>
        <sws:Sku>
          <sws:Id>1</sws:Id>
          <sws:Quantity>10</sws:Quantity>
          <sws:SkuSubTotal>10.15</sws:SkuSubTotal>
        </sws:Sku>
      </sws:Skus>
            </sws:PromoCode>
<sws:ShippingAddress>
<sws:FullName>Sanjeev Kango</sws:FullName>
<sws:NamePrefix/>
<sws:FirstName/>
<sws:MiddleName/>
<sws:LastName/>
<sws:NameSuffix/>
<sws:Title/>
<sws:Department/>
<sws:Company>STAMPS.COM</sws:Company>
<sws:Address1>12959 CORAL TREE PL</sws:Address1>
<sws:Address2/>
<sws:Address3/>
<sws:City>Santa Monica</sws:City>
<sws:State>CA</sws:State>
<sws:ZIPCode>90405</sws:ZIPCode>
<sws:ZIPCodeAddOn></sws:ZIPCodeAddOn>
<sws:DPB></sws:DPB>
<sws:CheckDigit></sws:CheckDigit>
<sws:Province/>
<sws:PostalCode>90066</sws:PostalCode>
<sws:Country>US</sws:Country>
<sws:Urbanization/>
<sws:PhoneNumber/>
<sws:Extension/>
</sws:ShippingAddress>
<sws:StoreShippingMethod>Basic</sws:StoreShippingMethod>
</soapenv:Body>
</soapenv:Envelope>";*/
$content = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <PlaceOrder xmlns="http://stamps.com/xml/namespace/2014/05/swsim/swsimv36">
    <Credentials>
<IntegrationID>60b81f53-cb40-4875-96a9-6ad82e10970a</IntegrationID>
<Username>poloblade</Username>
<Password>polo6920</Password>
</Credentials>
      <Skus>
        <Sku>
          <Id>1</Id>
          <Quantity>10</Quantity>
          <SkuSubTotal>10.20</SkuSubTotal>
        </Sku>
        <Sku>
          <Id>2</Id>
          <Quantity>10</Quantity>
          <SkuSubTotal>21.02</SkuSubTotal>
        </Sku>
      </Skus>
      <PromoCode></PromoCode>
      <ShippingAddress>
        <FullName>Sanjiv Kumar</FullName>
        <NamePrefix>Mr.</NamePrefix>
        <FirstName>Sanjiv</FirstName>
        <MiddleName>TT</MiddleName>
        <LastName>RR</LastName>
        <NameSuffix>RR</NameSuffix>
        <Title>SK</Title>
        <Department>Test</Department>
        <Company>STAMPS</Company>
        <Address1>12959 CORAL TREE PL</Address1>
        <Address2></Address2>
        <Address3></Address3>
        <City>Santa Monica</City>
        <State>CA</State>
        <ZIPCode>90405</ZIPCode>
        <ZIPCodeAddOn></ZIPCodeAddOn>
        <DPB></DPB>
        <CheckDigit></CheckDigit>
        <Province></Province>
        <PostalCode></PostalCode>
        <Country>US</Country>
        <Urbanization></Urbanization>
        <PhoneNumber></PhoneNumber>
        <Extension></Extension>
        <CleanseHash></CleanseHash>
        <OverrideHash></OverrideHash>
      </ShippingAddress>
      <StoreShippingMethod>Basic</StoreShippingMethod>
    </PlaceOrder>
  </soap:Body>
</soap:Envelope>';

$headers = array("User-Agent: Crosscheck Networks SOAPSonar",
"Content-Type: text/xml; charset=utf-8",
"SOAPAction:\"http://stamps.com/xml/namespace/2014/05/swsim/swsimv36/PlaceOrder\"",
"Content-Length:" . strlen($content));
$soap_do = curl_init();
curl_setopt($soap_do, CURLOPT_URL,'https://swsim.stamps.com/swsim/swsimv36.asmx' );
//curl_setopt($soap_do, CURLOPT_HEADER, true);
curl_setopt($soap_do, CURLINFO_HEADER_OUT, true);
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 7200);
curl_setopt($soap_do, CURLOPT_TIMEOUT, 7200);
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($soap_do, CURLOPT_POST, true );            
curl_setopt($soap_do, CURLOPT_POSTFIELDS, $content);
curl_setopt($soap_do, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($soap_do);
echo $res;
echo '<pre>';
//echo '<br />result is=' . $res;
//echo htmlentities($res);
$doc = new DOMDocument('1.0', 'utf-8');
    $doc->loadXML( $res);
    $XMLresults = $doc->getElementsByTagName("TrackingNumber");
    $output = $XMLresults->item(0)->nodeValue;
	echo $output;
	$stampurl = $doc->getElementsByTagName("URL");
    $stamp = $stampurl->item(0)->nodeValue;
	echo '<br>';
	echo $stamp;
?>