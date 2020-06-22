## Mini Aspire

### Installation 

_**Initializing Valet (optional), and install MySQL (optional)**_
https://laravel.com/docs/7.x/valet#installation

#### Steps:
- composer install
- php artisan key:generate
- php artisan migrate:fresh --seed **(change database connection in .env first)**


### User Stories
- As Authenticated users, I could apply loan application
- Weekly repayment frequency
- As as manager, I could approve loan applicaition, so users could have money and start to repay.
- After the loan is approved the user must be able to submit the weekly loan
repayments

### What to Test
- Applying for loan
    - Customer can apply a loan application
        - Emails, term, amount must be required
        - Loan must have a default status of new
    - View Loan details
    - View List of created applications
- Repay weekly loan
    - Guest cannot repay
    - Customer can repay their loan
    - Cannot repay DONE loan.
    - Mark loan application as DONE when the loan is paid off
    - 
- Approve loan (Not done yet)
    - Admin can approve a loan




