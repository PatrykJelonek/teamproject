<?php

namespace App\Mail;

use App\Models\Company;
use App\Models\University;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CompanyWorkerVerifiedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $subject = "Twoja prośba o dołączenie do firmy została zaakceptowana!";

    /**
     * @var Company
     */
    private $company;

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown(
            'emails.company.company_worker_verified_email',
            [
                'fullName' => $this->user->full_name,
                'companyName' => $this->company->name,
            ]
        );
    }
}
