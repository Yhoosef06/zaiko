@extends('layouts.pages.yields')

@section('content-header')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><b>Agreement Form</b></h1>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="container-fluid px-5 text-justify">
            <div class="border border-success rounded px-5 py-5">
            <p>
                This Borrowing Agreement is made and entered into on <b>{{ date('M d, Y') }}</b> between <b>{{Auth::user()->first_name}} {{ Auth::user()->last_name }}</b> a student of <b>School of Computer Studies</b>, collectively referred to as the "Parties".
            </p>
    
            <p>The Lender agrees to lend the Borrower the following DEVICES for educational, which includes but is not limited to managing, tracking, and organizing inventory for the Borrower's business operations. The System may include hardware, software, and any related peripherals or accessories.
            </p>
    
            <p><b>Condition of the System:</b> The Borrower acknowledges that the System is being borrowed in its current condition, and the Borrower shall be responsible for using the System in a careful and responsible manner. The Borrower shall also be responsible for returning the System in the same condition, ordinary wear and tear excepted. Any damages or loss to the System during the borrowing period shall be the responsibility of the Borrower, and the Borrower shall reimburse the Lender for the repair or replacement costs.
            </p>
    
            <p><b>Duration of Borrowing:</b> The Borrower shall borrow the System for a period of discussed duration, commencing from the Effective Date, unless otherwise agreed upon by both Parties in writing. The Borrower shall promptly return the System to the Lender upon the expiration or termination of the borrowing period, or upon the request of the Lender.
            </p>
    
            <p><b>Rights and Obligations:</b> The Borrower shall have the right to use the System solely for the purposes stated in this Agreement, and shall not transfer, lease, sublet, sell, or otherwise dispose of the System to any third party without the prior written consent of the Lender. The Borrower shall also be responsible for maintaining the confidentiality and security of any passwords, access codes, or other security measures associated with the System.
            </p>
    
            <p><b>Liability and Indemnity:</b> The Borrower shall be solely responsible for the proper use, operation, and maintenance of the System during the borrowing period, and shall indemnify and hold harmless the Lender from any claims, damages, liabilities, or losses arising out of the use, possession, or transportation of the System, including but not limited to any claims related to data breaches, loss of data, or unauthorized access to the System.
            </p>
    
            <p><b>Entire Agreement:</b> This Agreement contains the entire understanding between the Parties with respect to the subject matter hereof and supersedes all prior agreements, understandings, or representations, whether written or oral, relating to the borrowing of the System.
            </p>
    
            <p><b>Amendment and Waiver:</b> Any amendment or waiver of this Agreement must be in writing and signed by both Parties. Failure to enforce any provision of this Agreement shall not be deemed a waiver of such provision or any other provision hereof.
            </p>
    
            <p><b>Severability:</b> If any provision of this Agreement is found to be invalid, illegal, or unenforceable, the validity, legality, and enforceability of the remaining provisions shall not in any way be affected or impaired.
            </p>
    
            <p><b>Binding Effect:</b> This Agreement shall be binding upon and inure to the benefit of the Parties hereto and their respective successors, assigns, and legal representatives.
            </p>
    
            <p><b>IN WITNESS WHEREOF</b>, the Parties have executed this</p>
            </div>

            <div class="row text-right py-5">
                <div class="col">
                    <a href="{{ route('agreement.approve', Auth::user()->id_number) }}" class="btn btn-success">I AGREE  <i class="bi bi-check-circle"></i></a>
                </div>
            </div>
        </div> 
    </div>
@endsection
