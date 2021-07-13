<?php

declare(strict_types = 1);

namespace ThinkOut;

use GuzzleHttp\Client as GuzzleClient;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Symfony\Component\Filesystem\Filesystem;
use ThinkOut\Response\SignInData;
use Webmozart\Assert\Assert;

class Authenticator
{
    use HelperTrait;

    public const DESERIALIZE_FORMAT = 'json';
    private const API_URL = 'https://api.thinkout.io/api/partners/';
    private const AUTH_FILE = '.auth';

    private string $username;
    private string $password;
    private Filesystem $filesystem;
    private SignInData $signInData;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public function authenticate(bool $forced = false): SignInData
    {
        // check if already authenticated in current process
        if (false === $forced && isset($this->signInData)) {
            return $this->signInData;
        }

        // check if there is a cached authentication file
        if (false === $forced && $this->getFilesystem()->exists([self::AUTH_FILE])) {
            $path = sprintf('%s/%s', realpath(\dirname(__DIR__)), self::AUTH_FILE);
            $data = file_get_contents($path);
            Assert::string($data);

            $unserialized = unserialize($data, ['allowed_classes' => [SignInData::class]]);
            if (false !== $unserialized) {
                /** @var SignInData $unserialized */
                $config = Configuration::forUnsecuredSigner();
                /** @var UnencryptedToken $token */
                $token = $config->parser()->parse($unserialized->getToken());

                // check if the token is not expired
                $exp = $token->claims()->get('exp');
                $now = new \DateTime('now', new \DateTimeZone('UTC'));
                if (null === $exp || $now > $exp) {
                    return $this->doAuthentication();
                }

                return $this->signInData = $unserialized;
            }
        }

        // re-authenticate via API
        return $this->doAuthentication();
    }

    private function doAuthentication(): SignInData
    {
        $client = new GuzzleClient(['base_uri' => self::API_URL]);
        $response = $client->post('users/signin', $this->preparePostData([
            'email' => $this->username,
            'password' => $this->password,
        ]));

        $content = $response->getBody()->getContents();
        /** @var SignInData $signIn */
        $signIn = $this->getSerializer()->deserialize($content, SignInData::class, 'json');
        $this->getFilesystem()->dumpFile(self::AUTH_FILE, $this->signInData->serialize());

        return $this->signInData = $signIn;
    }

    private function getFilesystem(): Filesystem
    {
        return $this->filesystem ?? ($this->filesystem = new Filesystem());
    }
}
