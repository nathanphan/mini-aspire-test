<?php

namespace Tests\Feature;

use App\LoanApplication;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApplyLoanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * a helper to apply loan quickly.
     * @param array $param
     */
    protected function applyLoan($param = []) {
        $application = factory(LoanApplication::class)->raw($param);

        $this->post('/applications', $application)
            ->assertSessionHasErrors(array_keys($param));
    }

    /** @test */
    public function guest_cannot_apply_for_loan_application()
    {
        // $this->withoutExceptionHandling();

        $application = factory(LoanApplication::class)->raw();

        $this->post('/applications', $application)->assertRedirect('/login');
    }

    /** @test */
    public function guest_cannot_view_a_single_loan_application()
    {
        $application = factory(LoanApplication::class)->create();

        $this->get($application->path())->assertRedirect('/login');
    }


    /** @test */
    public function authenticated_customer_can_apply_loan_application()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/applications/create')->assertStatus(200);

        $applicationData = factory(LoanApplication::class)->raw([
            'borrower_id' => auth()->id()
        ]);

        $this->post('/applications', $applicationData)
            ->assertStatus(201)
            ->assertRedirect('/applications');

        $this->assertDatabaseHas('loan_applications', $applicationData);

        $this->get('/applications')->assertSee($applicationData['term']);
    }

    /** @test */
    public function authenticated_customer_can_view_their_loan_application()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $application = factory(LoanApplication::class)->create([
            'borrower_id' => auth()->id()
        ]);

        $this->get($application->path())
            ->assertSee($application->first_name)
            ->assertSee($application->note);
    }

    /** @test */
    public function authenticated_customer_cannot_view_application_of_others()
    {
        $this->signIn();

        $application = factory(LoanApplication::class)->create();

        $this->get($application->path())->assertStatus(403);
    }

    /** @test */
    public function email_is_required_create_application()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'email' => ''
        ]);


        $this->assertEquals(0, LoanApplication::count());
    }

    /** @test */
    public function email_must_be_valid()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'email' => 'bad-email-address'
        ]);

        $this->assertEquals(0, LoanApplication::count());
    }

    /** @test */
    public function term_is_required_create_application()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'term' => ''
        ]);

        $this->assertEquals(0, LoanApplication::count());
    }

    /** @test */
    public function term_is_at_least_1_to_create_application()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'term' => '0'
        ]);

        $this->assertEquals(0, LoanApplication::count());
    }

    /** @test */
    public function amount_is_required_create_application()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'amount' => NULL
        ]);

        $this->assertEquals(0, LoanApplication::count());
    }

    /** @test */
    public function amount_must_be_at_least_100_dollar_to_create_application()
    {
        //$this->withoutExceptionHandling();
        $this->signIn();

        $this->applyLoan([
            'amount' => '10'
        ]);

        $this->assertEquals(0, LoanApplication::count());
    }
}
