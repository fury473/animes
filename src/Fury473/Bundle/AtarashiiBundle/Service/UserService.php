<?php

namespace Fury473\Bundle\AtarashiiBundle\Service;

use GuzzleHttp\Exception\ClientException;

/**
 * Class User
 * @author Olivier Haag <olivierhaag92@gmail.com>
 * @link https://atarashii.fury473.com/docs/2.0/user/
 */
class UserService extends AbstractService
{

    /**
     * @param string $username
     * @return array
     */
    public function profile($username)
    {
        $response = $this->getClient()->request('GET', '/2.1/profile/' . $username);

        return $this->getSerializer()->decode((string) $response->getBody(), 'json');
    }

    /**
     * Uses Request User & Request Password to verify credentials on MAL
     * @return boolean
     */
    public function verifyCredentials()
    {
        try {
            $this->getClient()->request('GET', '/2.1/account/verify_credentials');
        } catch (ClientException $e) {
            return false;
        }

        return true;
    }

}
