<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanApplication extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_a_path()
    {
        $application = factory(\App\LoanApplication::class)->create();

        $this->assertEquals('/applications/' . $application->id, $application->path());
    }

    /** @test */
    public function it_has_a_repay_path()
    {
        $application = factory(\App\LoanApplication::class)->create();

        $this->assertEquals('/applications/'.$application->id.'/repay', $application->repayPath());
    }

    /** @test */
    public function it_has_a_borrower()
    {
        $application = factory(\App\LoanApplication::class)->create();

        $this->assertInstanceOf(User::class, $application->borrower);
    }

    /** @test */
    public function it_has_repay_history()
    {
        $application = factory(\App\LoanApplication::class)
            ->state(\App\LoanApplication::STATUS_APPROVED)
            ->create();

        $this->assertInstanceOf(Collection::class, $application->history);
    }

    /** @test */
    public function it_can_get_weekly_repay_amount()
    {
        $application = factory(\App\LoanApplication::class)
            ->create([
                'term' => '12', // default in weeks  as assumption
                'amount' => 100, // in dollars as assumption
            ]);
        // the expected value is acceptable for now. This can be improved in real life.
        $this->assertEquals(8.33, $application->getWeeklyRepayAmount());
    }

    /** @test */
    public function it_can_mark_status_as_given()
    {
        $application = factory(\App\LoanApplication::class)
            ->state(\App\LoanApplication::STATUS_APPROVED)
            ->create([
                'term' => '12', // default in weeks  as assumption
                'amount' => 100, // in dollars as assumption
            ]);

        $this->assertEquals(\App\LoanApplication::STATUS_APPROVED, $application->status);

        $application->markAs(\App\LoanApplication::STATUS_DONE);

        $this->assertEquals(\App\LoanApplication::STATUS_DONE, $application->status);
    }

    /** @test */
    public function it_has_a_default_status_as_new()
    {
        $application = factory(\App\LoanApplication::class)
            ->create();

        $this->assertEquals(\App\LoanApplication::STATUS_NEW, $application->status);
    }

    /** @test */
    public function it_can_get_specific_badge()
    {
        $application = factory(\App\LoanApplication::class)
            ->create();
        $this->assertEquals('primary', $application->getStatusBadges());

        $application->status = \App\LoanApplication::STATUS_APPROVED;
        $this->assertEquals('success', $application->getStatusBadges());

        $application->status = \App\LoanApplication::STATUS_DONE;
        $this->assertEquals('secondary', $application->getStatusBadges());
    }

    /** @test */
    public function can_get_applicant_full_name()
    {
        $application = factory(\App\LoanApplication::class)
            ->create();

        $this->assertEquals($application->first_name . ' ' . $application->last_name, $application->fullName);
    }
}
