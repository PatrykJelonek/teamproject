<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    /**
     * @param int   $userId
     * @param array $status Array of Internship Statuses
     *
     * @return mixed
     */
    public function getInternships(int $userId, array $status = null);

    public function getUniversities();

    public function getCompanies();

    public function getMessages(int $userId);

    public function getUserById(int $userId);

    public function getUserCompanyRoles(int $userId, $companySlug);

    public function getUserUniversityRoles(int $userId, $universitySlug);

    public function getUserStatusByName(string $name);

    public function getUserByActivationToken(string $activationToken);
}
