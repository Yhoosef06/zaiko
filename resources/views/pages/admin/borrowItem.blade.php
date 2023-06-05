@extends('layouts.pages.yields')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
        
                    <div class="form-group">
                        <label>ID Number</label>
                        <div id="user_id_container">
                            <input type="text" id="idNumber" name="idNumber" class="form-control"
                                placeholder="Enter ID Number here...." required>
                        </div>     
                    </div>

                    

                </div>
            </div>

            <div class="row" id="search-serial-desc" style="display: none;">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label>Search Item</label>
                        <div id="search-item">
                            <input type="text" id="search_item" name="search_item" class="form-control"
                                placeholder="Search Item to Borrow - Serial Number or Item Description"
                                required>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    


       <section class="content">
        <div id="success-message"></div>
        <div class="container-fluid">
        
              <div class="row">
                <div class="col-12">
                  <div class="card">
                   
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 250px;">
                      <table class="table table-head-fixed text-nowrap" id="notAdded">
                        <thead>
                          <tr>
                            <th class="d-none">ID</th>
                            <th class="d-none">ItemId</th>
                            <th style="background-color:#343a40; color:aliceblue">Brand</th>
                            <th style="background-color:#343a40; color:aliceblue">Model</th>
                            <th style="background-color:#343a40; color:aliceblue">Desctiption</th>
                            <th style="background-color:#343a40; color:aliceblue">Quantity</th>
                            <th style="background-color:#343a40; color:aliceblue">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                        
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>



              <div class="row">
                <div class="col-12">
                  <div class="card">
                   
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 250px;">
                    <form method="POST" id="submitAdmin">
                    <input type="text" id="student_id" name="student_id" class="form-control" style="display: none;">
                      <table class="table table-head-fixed text-nowrap" id="alreadyAdded">
                        <thead>
                          <tr>
                               <th class="d-none">ID</th>
                                <th style="background-color:#28a745; color:aliceblue">Brand</th>
                                <th style="background-color:#28a745; color:aliceblue">Model</th>
                                <th style="background-color:#28a745; color:aliceblue">Description</th>
                                <th style="background-color:#28a745; color:aliceblue">Serial</th>
                                <th style="background-color:#28a745; color:aliceblue">Quantity</th>
                                <th style="background-color:#28a745; color:aliceblue">Option</th>
                               
                          </tr>
                        </thead>
                        <tbody>
                    
                          
                      
                        </tbody>
                      </table>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    </div>
                    <!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
              </div>



              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
            
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
@endsection

