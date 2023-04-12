@extends('layouts.pages.yields')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Borrowing Agreement Form</h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <p>
            This Borrowing Agreement is made and entered into on [Date] between {{Auth::user()->first_name}} {{ Auth::user()->last_name }} a student of School of Computer Studies, collectively referred to as the "Parties".
        </p>

        Item Description: The Lender agrees to lend the Borrower the following inventory management system (the "System") for the purpose of [Purpose of Borrowing], which includes but is not limited to managing, tracking, and organizing inventory for the Borrower's business operations. The System may include hardware, software, and any related peripherals or accessories.

Condition of the System: The Borrower acknowledges that the System is being borrowed in its current condition, and the Borrower shall be responsible for using the System in a careful and responsible manner. The Borrower shall also be responsible for returning the System in the same condition, ordinary wear and tear excepted. Any damages or loss to the System during the borrowing period shall be the responsibility of the Borrower, and the Borrower shall reimburse the Lender for the repair or replacement costs.

Duration of Borrowing: The Borrower shall borrow the System for a period of [Duration of Borrowing], commencing from the Effective Date, unless otherwise agreed upon by both Parties in writing. The Borrower shall promptly return the System to the Lender upon the expiration or termination of the borrowing period, or upon the request of the Lender.

Rights and Obligations: The Borrower shall have the right to use the System solely for the purposes stated in this Agreement, and shall not transfer, lease, sublet, sell, or otherwise dispose of the System to any third party without the prior written consent of the Lender. The Borrower shall also be responsible for maintaining the confidentiality and security of any passwords, access codes, or other security measures associated with the System.

Liability and Indemnity: The Borrower shall be solely responsible for the proper use, operation, and maintenance of the System during the borrowing period, and shall indemnify and hold harmless the Lender from any claims, damages, liabilities, or losses arising out of the use, possession, or transportation of the System, including but not limited to any claims related to data breaches, loss of data, or unauthorized access to the System.

Governing Law and Jurisdiction: This Agreement shall be governed by and construed in accordance with the laws of [State/Country]. Any disputes arising out of or in connection with this Agreement shall be resolved through amicable negotiation, and if not resolved, shall be subject to the exclusive jurisdiction of the courts of [State/Country].

Entire Agreement: This Agreement contains the entire understanding between the Parties with respect to the subject matter hereof and supersedes all prior agreements, understandings, or representations, whether written or oral, relating to the borrowing of the System.

Amendment and Waiver: Any amendment or waiver of this Agreement must be in writing and signed by both Parties. Failure to enforce any provision of this Agreement shall not be deemed a waiver of such provision or any other provision hereof.

Severability: If any provision of this Agreement is found to be invalid, illegal, or unenforceable, the validity, legality, and enforceability of the remaining provisions shall not in any way be affected or impaired.

Binding Effect: This Agreement shall be binding upon and inure to the benefit of the Parties hereto and their respective successors, assigns, and legal representatives.

IN WITNESS WHEREOF, the Parties have executed this
    </div>
@endsection
