<?php

declare(strict_types=1);

namespace App\API\Method;

use App\Service\ResumeServiceInterface;
use stdClass;
use UMA\JsonRpc\Procedure;
use UMA\JsonRpc\Request;
use UMA\JsonRpc\Response;
use UMA\JsonRpc\Success;

/**
 * Class GetResumeMethod
 * @package App\API\Method
 */
class GetResumeMethod implements Procedure
{
    /**
     * @var ResumeServiceInterface
     */
    private ResumeServiceInterface $resumeService;

    /**
     * GetResumeMethod constructor.
     * @param ResumeServiceInterface $resumeService
     */
    public function __construct(ResumeServiceInterface $resumeService)
    {
        $this->resumeService = $resumeService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return new Success($request->id(), ['resume' => $this->getResumeService()->getResume()]);
    }

    /**
     * @return stdClass|null
     */
    public function getSpec(): ?stdClass
    {
        return null;
    }

    /**
     * @return ResumeServiceInterface
     */
    public function getResumeService(): ResumeServiceInterface
    {
        return $this->resumeService;
    }
}
