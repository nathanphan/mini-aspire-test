<?php

namespace Tests\Feature;

use App\LoanApplication;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RepayLoanTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function guest_cannot_repay()
    {
        // $this->withoutExceptionHandling();
        $loanApplication = factory(LoanApplication::class)->create();

        $this->post($loanApplication->path() . '/repay', [])->assertRedirect('/login');
    }

    /** @test */
    public function a_customer_can_repay_a_loan()
    {
        $this->withoutExceptionHandling();

        $this->actingAs(factory(User::class)->create());

        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_APPROVED)
            ->create([
                'borrower_id' => auth()->id()
            ]);

        $this->post($loanApplication->path() . '/repay', [])
            ->assertRedirect($loanApplication->path());

        $repayHistory = $loanApplication->history()->first();
        $this->assertNotNull($repayHistory);
    }

    /** @test */
    public function authenticated_customer_cannot_repay_others_application_loan()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());

        $loanApplication = factory(LoanApplication::class)->create();

        $this->post($loanApplication->path() . '/repay', [])->assertStatus(403);
    }

    /** @test */
    public function repay_history_will_not_created_if_application_was_done()
    {
        //$this->withoutExceptionHandling();
        $this->actingAs(factory(User::class)->create());

        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_DONE)
            ->create([
                'borrower_id' => auth()->id()
            ]);

        $this->post($loanApplication->path() . '/repay', [])
            ->assertStatus(422);

        $repayHistory = $loanApplication->history()->first();
        $this->assertNull($repayHistory);
    }

    /** @test */
    public function when_amount_reached_then_mark_application_as_done()
    {
        $this->actingAs(factory(User::class)->create());

        $loanApplication = factory(LoanApplication::class)
            ->state(LoanApplication::STATUS_APPROVED)
            ->create([
                'borrower_id' => auth()->id(),
                'term' => '12',
                'amount' => 100
            ]);

        for ($i = 0; $i < 12; $i++) {
            $this->post($loanApplication->path() . '/repay', []);
        }

        $updateApplication = LoanApplication::find($loanApplication->id);

        $this->assertEquals(12, $updateApplication->history->count());
        $this->assertEquals(LoanApplication::STATUS_DONE, $updateApplication->status);
    }
}
