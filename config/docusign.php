<?php
return [
    'integration_key' => 'af2be383-ee06-4f01-a3e9-75bb60335f98',
    'user_id' => 'ee574ee2-9b74-47c7-b012-4f2b88aa7b9c', // found in DocuSign
    'rsa_key_path' => CONFIG . 'docusign/private.key', // generate a private RSA key
    'account_id' => 'baaa357b-cf8e-4418-98ca-ff5a95be8df5',
    'base_uri' => 'https://demo.docusign.net/restapi',
    'redirect_uri' => 'http://localhost/nat/docusign/callback',
];