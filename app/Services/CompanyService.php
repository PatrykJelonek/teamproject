<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 01/07/2021
 * Time: 21:44
 */

namespace App\Services;

use App\Constants\RoleConstants;
use App\Http\Requests\CompanyActivateCompanyWorkerRequest;
use App\Http\Requests\CompanyDeactivateCompanyWorkerRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\UserCompany;
use App\Models\UserUniversity;
use App\Repositories\CompanyRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * CompanyService constructor.
     *
     * @param CompanyRepository $repository
     * @param UserRepository    $userRepository
     */
    public function __construct(CompanyRepository $repository, UserRepository $userRepository)
    {
        $this->companyRepository = $repository;
        $this->userRepository = $userRepository;
    }

    public function updateCompanyData(
        string $slug,
        string $email = null,
        string $phone = null,
        string $website = null,
        string $description = null
    ) {
        $company = $this->companyRepository->getCompanyBySlug($slug);

        if ($company !== null) {
            $company->email = $email ?? $company->email;
            $company->phone = $phone ?? $company->phone;
            $company->website = $website ?? $company->website;
            $company->description = $description ?? $company->description;
            $company->updateTimestamps();

            if ($company->update()) {
                Log::channel('user')->info(
                    'Użytkownik zmienił dane firmy!',
                    ['user_id' => Auth::id(), 'company_id' => $company->id]
                );
                return $company;
            }
        }
        Log::channel('user')->error(
            'Wystąpił problem podczas aktualizacji danych firmy!',
            [
                'user_id' => Auth::id(),
                'company_id' => $company->id ?? null,
                'data' => [
                    'slug' => $slug,
                    'email' => $email,
                    'phone' => $phone,
                    'website' => $website,
                    'description' => $description,
                ],
            ]
        );
        return null;
    }

    public function deleteCompanyWokrer(string $slug, string $userId)
    {
        $user = User::with(['companies'])->where(['id' => $userId])->whereHas(
            'companies',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->first();

        $company = $this->companyRepository->getCompanyBySlug($slug);

        if ($user !== null && $company !== null) {
            $userCompaniesRoles = $this->companyRepository->getUsersCompaniesRoles($userId, $company->id);

            if (!is_null($userCompaniesRoles) && $userCompaniesRoles->delete()) {
                $user->companies()->detach([$company->id]);
                Log::channel('user')->info(
                    'Użytkownik został usunięty z firmy!',
                    [
                        'user_id' => Auth::id(),
                        'company_id' => $company->id,
                        'deleted_user_id' => $user->id,
                    ]
                );
                return true;
            }
        }

        Log::channel('user')->error(
            'Wystąpił problem z usunięciem użytkownika z firmy!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'slug' => $slug,
                    'user_id' => $userId,
                ],
            ]
        );

        return false;
    }

    public function acceptCompanyWorker(string $slug, string $userId)
    {
        $user = User::with(['companies'])->where(['id' => $userId])->whereHas(
            'companies',
            function (Builder $query) use ($slug) {
                $query->where(['slug' => $slug]);
            }
        )->first();

        $company = $this->companyRepository->getCompanyBySlug($slug);

        if ($user !== null && $company !== null) {
            if ($user->companies()->updateExistingPivot(
                $company->id,
                [
                    'verified' => true,
                ]
            )) {
                Log::channel('user')->info(
                    'Użytkownik został zaakceptowany jako pracownik firmy!',
                    [
                        'user_id' => Auth::id(),
                        'company_id' => $company->id,
                        'data' => [
                            'slug' => $slug,
                            'userId' => $userId,
                        ],
                    ]
                );
            }

            return true;
        }

        Log::channel('user')->error(
            'Wystąpił problem z akceptacją użytkownika jako pracownika firmy!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'slug' => $slug,
                    'user_id' => $userId,
                ],
            ]
        );

        return false;
    }

    /**
     * @param string      $name
     * @param int         $cityId
     * @param string      $street
     * @param string      $streetNumber
     * @param string      $email
     * @param int         $companyCategoryId
     * @param string|null $phone
     * @param string|null $website
     * @param string|null $description
     * @param bool|null   $verified
     * @param int|null    $userId
     * @param bool|null   $draft
     *
     * @param string|null $logoUrl
     *
     * @return Company|null
     */
    public function createCompany(
        string $name,
        int $cityId,
        string $street,
        string $streetNumber,
        string $email,
        int $companyCategoryId,
        ?string $phone = null,
        ?string $website = null,
        ?string $description = null,
        ?bool $verified = false,
        ?int $userId = null,
        ?bool $draft = false,
        ?string $logoUrl = null
    ): ?Company {
        $generatedAccessCode = UtilsService::generateAccessCode();

        if ($draft) {
            $randomDraftKey = strtolower(Str::random(4));

            $name = '__' . $randomDraftKey . '__draft__' . $name;
            $email = '__' . $randomDraftKey . '__draft__' . $email;
        }

        $company = new Company();
        $company->name = $name;
        $company->city_id = $cityId;
        $company->street = $street;
        $company->street_number = $streetNumber;
        $company->email = $email;
        $company->phone = $phone;
        $company->website = $website;
        $company->description = $description;
        $company->slug = Str::slug($name);
        $company->access_code = $generatedAccessCode;
        $company->logo_url = $logoUrl;
        $company->company_category_id = $companyCategoryId;
        $company->user_id = !is_null($userId) ? $userId : Auth::id();
        $company->verified = $verified ?? false;
        $company->draft = $draft;
        $company->freshTimestamp();

        if ($company->save()) {
            Log::channel('user')->info(
                'Użytkownik dodał nową firmę!',
                [
                    'method_reference' => 'CompanyService::createCompany',
                    'user_id' => Auth::id(),
                    'data' => [
                        'name' => $name,
                        'city_id' => $cityId,
                        'street' => $street,
                        'streetNumber' => $streetNumber,
                        'email' => $email,
                        'phone' => $phone,
                        'website' => $website,
                        'description' => $description,
                        'slug' => Str::slug($name),
                        'access_code' => $generatedAccessCode,
                        'logo_url' => $logoUrl,
                        'company_category_id' => $companyCategoryId,
                        'user_id' => !is_null($userId) ? $userId : Auth::id(),
                        'accepted' => false,
                        'draft' => $draft
                    ],
                ]
            );

            return $company;
        }

        Log::channel('user')->error(
            'Nie udało się dodać nowej firmy',
            [
                'method_reference' => 'CompanyService::createCompany',
                'user_id' => Auth::id(),
                'data' => [
                    'name' => $name,
                    'city_id' => $cityId,
                    'street' => $street,
                    'streetNumber' => $streetNumber,
                    'email' => $email,
                    'phone' => $phone,
                    'website' => $website,
                    'description' => $description,
                    'slug' => Str::slug($name),
                    'access_code' => $generatedAccessCode,
                    'logo_url' => $logoUrl,
                    'company_category_id' => $companyCategoryId,
                    'user_id' => !is_null($userId) ? $userId : Auth::id(),
                ],
            ]
        );

        return null;
    }

    /**
     * @param int       $userId
     * @param int       $companyId
     * @param int       $roleId
     * @param bool|null $verified
     * @param bool|null $active
     *
     * @return UserCompany|null
     */
    public function addUserToCompanyWithRole(
        int $userId,
        int $companyId,
        int $roleId,
        ?bool $verified = false,
        ?bool $active = false
    ): ?UserCompany {
        $userCompany = new UserCompany();
        $userCompany->user_id = !empty($userId) ? $userId : Auth::id();
        $userCompany->company_id = $companyId;
        $userCompany->verified = $verified;
        $userCompany->active = $active;

        if ($userCompany->save()) {
            $userCompany->roles()->attach(
                [$roleId],
                ['created_at' => Carbon::now(),]
            );

            Log::channel(config('global.defaultLogChannel'))->info(
                'Dodano nową rolę do użytkownika w firmie!',
                [
                    'user_id' => Auth::id(),
                    'data' => [
                        'userId' => $userId,
                        'companyId' => $companyId,
                        'roleId' => $roleId,
                    ],
                ]
            );

            return $userCompany;
        }

        Log::channel(config('global.defaultLogChannel'))->error(
            'Wystąpił problem z dodaniem roli do użytkownika w firmie!',
            [
                'user_id' => Auth::id(),
                'data' => [
                    'userId' => $userId,
                    'companyId' => $companyId,
                    'roleId' => $roleId,
                ],
            ]
        );

        return null;
    }

    public function verifyCompany(string $slug)
    {
        $company = $this->companyRepository->getCompanyBySlug($slug);

        if (!is_null($company)) {
            $company->verified = true;

            if ($company->save()) {
                return $company;
            }
        }

        return null;
    }

    public function rejectCompany(string $slug)
    {
        $company = $this->companyRepository->getCompanyBySlug($slug);
        $companyAuthor = !is_null($company) ? $company->user : null;

        DB::beginTransaction();
        if (!is_null($company) && !is_null($companyAuthor)) {
            $userCompanyRole = $this->companyRepository->getUsersCompaniesRoles($companyAuthor->id, $company->id);

            if (!is_null($userCompanyRole)) {
                $userCompanyRole->delete();
                $company->users()->detach($companyAuthor->id);

                if ($company->delete()) {
                    DB::commit();
                    return $company;
                }
            }
        }

        DB::rollBack();
        return null;
    }

    public function changeCompanyWorkerRoles(int $userCompanyId, array $rolesIds)
    {
        try {
            $userCompany = UserCompany::find($userCompanyId);
            $userCompany->roles()->sync($rolesIds);
        } catch (\Exception $e) {
            throw new \Exception('Nie udało się dodać roli!');
        }
    }

    public function activateCompanyWorker(string $slug, int $userId)
    {
        $company = $this->companyRepository->getCompanyBySlug($slug);

        if (!is_null($company)) {
            $userCompany = UserCompany::where(['company_id' => $company->id, 'user_id' => $userId])->first();

            if (!is_null($userCompany)) {
                $userCompany->active = true;
                $userCompany->freshTimestamp();

                if ($userCompany->update()) {
                    return $userCompany;
                }
            }
        }

        return null;
    }

    public function deactivateCompanyWorker(string $slug, int $userId)
    {
        $company = $this->companyRepository->getCompanyBySlug($slug);

        if (!is_null($company)) {
            $userCompany = UserCompany::where(['company_id' => $company->id, 'user_id' => $userId])->first();

            if (!is_null($userCompany)) {
                $userCompany->active = false;
                $userCompany->freshTimestamp();

                if ($userCompany->update()) {
                    return $userCompany;
                }
            }
        }

        return null;
    }
}
