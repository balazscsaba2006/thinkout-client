<?php

declare(strict_types = 1);

namespace ThinkOut\Tests;

use PHPUnit\Framework\TestCase;
use ThinkOut\Client;

class ClientTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $username = getenv('API_USERNAME') ?: 'username';
        $password = getenv('API_PASSWORD') ?: 'password';
        $this->client = new Client($username, $password);

        parent::setUp();
    }

    /**
     * Test the configuration.
     */
    public function testConfiguration(): void
    {
        $config = $this->client->getConfig();

        $baseUri = $config['base_uri'];
        $headers = $config['headers'];

        $this->assertInstanceOf(Uri::class, $baseUri);
        $this->assertEquals('api.todoist.com', $baseUri->getHost());
        $this->assertEquals('/rest/v1/', $baseUri->getPath());
        $this->assertArrayHasKey('Authorization', $headers);
        $this->assertEquals(sprintf('Bearer %s', $this->apiToken), $headers['Authorization']);
    }

    public function testGetAllProjects(): void
    {
        $allProjects = $this->client->getAllProjects();
        $this->assertArrayHasKey('id', $allProjects[0]);
    }

    /**
     * @return int ID of the created project.
     */
    public function testCreateProject()
    {
        $createProject = $this->client->createProject($this->testName);
        $this->assertArrayHasKey('name', $createProject);
        $this->assertEquals($this->testName, $createProject['name']);

        return $createProject['id'];
    }

    /**
     * @depends testCreateProject
     *
     * @param $projectId
     */
    public function testGetProject($projectId): void
    {
        $project = $this->client->getProject($projectId);
        $this->assertArrayHasKey('name', $project);
    }

    /**
     * @depends testCreateProject
     *
     * @param $projectId
     */
    public function testUpdateProject($projectId): void
    {
        $success = $this->client->updateProject($projectId, $this->testName . '-Renamed');
        $this->assertTrue($success);
    }

    /**
     * @depends testCreateProject
     *
     * @param $projectId
     */
    public function testDeleteProject($projectId): void
    {
        $success = $this->client->deleteProject($projectId);
        $this->assertTrue($success);
    }

    public function testGetAllLabels(): void
    {
        $allLabels = $this->client->getAllLabels();
        $this->assertArrayHasKey('id', $allLabels[0]);
    }

    /**
     * @return int ID of the created label.
     */
    public function testCreateLabel()
    {
        $createLabel = $this->client->createLabel($this->testName);
        $this->assertArrayHasKey('name', $createLabel);
        $this->assertEquals($this->testName, $createLabel['name']);

        return $createLabel['id'];
    }

    /**
     * @depends testCreateLabel
     *
     * @param $labelId
     */
    public function testGetLabel($labelId): void
    {
        $label = $this->client->getLabel($labelId);
        $this->assertArrayHasKey('name', $label);
    }

    /**
     * @depends testCreateLabel
     *
     * @param $labelId
     */
    public function testUpdateLabel($labelId): void
    {
        $success = $this->client->updateLabel($labelId, $this->testName . '-Renamed');
        $this->assertTrue($success);
    }

    /**
     * @depends testCreateLabel
     *
     * @param $labelId
     */
    public function testDeleteLabel($labelId): void
    {
        $success = $this->client->deleteLabel($labelId);
        $this->assertTrue($success);
    }

    /**
     * @depends testCreateSection
     */
    public function testGetAllSections(): void
    {
        $allSections = $this->client->getAllSections();
        $this->assertArrayHasKey('id', $allSections[0]);
    }

    /**
     * @return int ID of the created section.
     */
    public function testCreateSection()
    {
        $allProjects   = $this->client->getAllProjects();
        $createSection = $this->client->createSection($this->testName, $allProjects[0]['id']);
        $this->assertArrayHasKey('name', $createSection);
        $this->assertEquals($this->testName, $createSection['name']);

        return $createSection['id'];
    }

    /**
     * @depends testCreateSection
     *
     * @param $sectionId
     */
    public function testGetSection($sectionId): void
    {
        $section = $this->client->getSection($sectionId);
        $this->assertArrayHasKey('name', $section);
    }

    /**
     * @depends testCreateSection
     *
     * @param $sectionId
     */
    public function testUpdateSection($sectionId): void
    {
        $success = $this->client->updateSection($sectionId, $this->testName . '-Renamed');
        $this->assertTrue($success);
    }

    /**
     * @depends testCreateSection
     *
     * @param $sectionId
     */
    public function testDeleteSection($sectionId): void
    {
        $success = $this->client->deleteSection($sectionId);
        $this->assertTrue($success);
    }
}
