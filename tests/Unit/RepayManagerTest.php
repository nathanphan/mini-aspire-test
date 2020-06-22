<?php

namespace Tests\Unit;

use App\Payment\RepayFailedException;
use App\Payment\RepayManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\LoanApplication;

class RepayManagerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function repay_a_loan_weekly_amount_successfully()
    {
        $loanApplication = factory(LoanApplication::class)->create([
            'term' => '12', // default in weeks
            'amount' => 100, // in dollars
        ]);
        $repayManager = new RepayManager();

        $repayManager->pay($loanApplication);

        $this->assertEquals(round($loanApplication->getWeeklyRepayAmount()), $repayManager->getTotalRepay());
    }

    /** @test */
    public function repay_cannot_be_made_if_application_loan_status_is_done()
    {
        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_DONE)->create();

        try {
            $repayManager = new RepayManager();
            $repayManager->pay($loanApplication);
        } catch (RepayFailedException $exception) {
            $this->assertSame('The Application is already paid off.', $exception->getMessage());
            return;
        }

        $this->fail();
    }

    /** @test */
    public function mark_application_as_done_when_amount_reached()
    {
        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_APPROVED)->create([
            'term' => '12', // default in weeks
            'amount' => 100, // in dollars
        ]);

        $repayManager = new RepayManager();
        for ($i = 0; $i < 12; $i++) {
            $repayManager->pay($loanApplication);
        }

        $this->assertEquals(100, $repayManager->getTotalRepay());
        $this->assertEquals(LoanApplication::STATUS_DONE, $loanApplication->status);
    }

    /** @test */
    public function calculate_remaining_amount_after_repay()
    {
        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_APPROVED)->create([
                'term' => '2', // default in weeks
                'amount' => 100, // in dollars
            ]);

        $repayManager = new RepayManager();
        $repayManager->pay($loanApplication);

        $this->assertEquals(50, $repayManager->getRemainingAmount());
        $this->assertEquals(LoanApplication::STATUS_APPROVED, $loanApplication->status);
    }
}
