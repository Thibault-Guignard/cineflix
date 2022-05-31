<?php

namespace App\Tests\Back;


use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MovieTest extends WebTestCase
{
    public function testUserPageAccess(): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('user@user.com');

        $client->loginUser($testUser);

        $securedRoutes = [
            '/back/movie',
            '/back/user',
            '/back/user/new'
        ];

        foreach ($securedRoutes as $currentRoutes) {
            $client->request('GET',$currentRoutes);
            $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        }

    }

    public function testManagerPageAccess()
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail('manager@manager.com');

        $client->loginUser($testUser);

        $forbiddenRoutes = [
            '/back/user/new',
            '/back/user',
        ];
        $authorizededRoutes = [
            '/back/movie',
        ];

        foreach ($forbiddenRoutes as $currentRoutes) {
            $client->request('GET',$currentRoutes);
            $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
        };

        foreach ($authorizededRoutes as $currentRoutes) {
            $client->request('GET',$currentRoutes);
            $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        };

    }

        /**
     * @dataProvider routesForUser
     * 
     * @return void
     */
    public function testStandardUserPageAccess($urlToTest, $expectedCode, $httpMethod): void
    {
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);

        // retrieve the test user
        $standardUser = $userRepository->findOneByEmail('user@user.com');

        // simulate $standardUser being logged in
        $client->loginUser($standardUser);

        // test e.g. the profile page
        $client->request($httpMethod, $urlToTest);
        $this->assertResponseStatusCodeSame($expectedCode);
    }

    public function routesForUser()
    {
        return [
            ['/back/movie/new', Response::HTTP_FORBIDDEN, Request::METHOD_POST],
            ['/back/user/new' , Response::HTTP_FORBIDDEN, Request::METHOD_POST],

            ['/back/movie', Response::HTTP_FORBIDDEN, Request::METHOD_GET],
            ['/back/user', Response::HTTP_FORBIDDEN, Request::METHOD_GET],
            ['/back/user/new', Response::HTTP_FORBIDDEN, Request::METHOD_GET],
        ];
    }
}

