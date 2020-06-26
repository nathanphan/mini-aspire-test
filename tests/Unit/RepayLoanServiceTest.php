<?php

namespace Tests\Unit;

use App\Payment\RepayFailedException;
use App\Payment\RepayManager;
use App\Services\RepayLoanService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\LoanApplication;

class RepayLoanServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function repay_a_loan_weekly_amount_successfully()
    {
        $loanApplication = factory(LoanApplication::class)->create([
            'term' => '12', // default in weeks
            'amount' => 100, // in dollars
        ]);
        $repayService = new RepayLoanService();
        $repayService->repay($loanApplication);

        $this->assertEquals($loanApplication->getWeeklyRepayAmount(), $loanApplication->getTotalRepaid());
    }

    /** @test */
    public function repay_cannot_be_made_if_application_loan_status_is_done()
    {
        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_DONE)->create();

        try {
            $repayService = new RepayLoanService();
            $repayService->repay($loanApplication);
        } catch (RepayFailedException $exception) {
            $this->assertSame('The Application is already paid off.', $exception->getMessage());
            return;
        }

        $this->fail();
    }

    /** @test */
//    public function mark_application_as_done_when_amount_reached()
//    {
//        $loanApplication = factory(LoanApplication::class)
//            ->state(LoanApplication::STATUS_APPROVED)->create([
//            'term' => '12', // default in weeks
//            'amount' => 100, // in dollars
//        ]);
//
//        $repayManager = new RepayManager();
//        for ($i = 0; $i < 12; $i++) {
//            $repayManager->pay($loanApplication);
//        }
//
//        $this->assertEquals(100, $repayManager->getTotalRepay());
//        $this->assertEquals(LoanApplication::STATUS_DONE, $loanApplication->status);
//    }
}
