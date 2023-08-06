<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee Entry</title>
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>


</head>


<body>
@section('title', 'Page Title')
@include('topbar.sidebar')





<div class="content-wrapper">


<main>
        <nav>
            <div class="nav nav-tabs position-fix top-0 start-0" id="nav-tab" role="tablist" style="background-color: rgb(163, 34, 163)">
              <button class="nav-link active link-light" id="off-tab" data-bs-toggle="pill" data-bs-target="#off" type="button" role="tab" aria-controls="off" aria-selected="true">Official Info</button>
              <button class="nav-link link-light" id="per-tab" data-bs-toggle="pill" data-bs-target="#per" type="button" role="tab" aria-controls="per" aria-selected="false">Personal Info</button>              
              <button class="nav-link link-light" id="add-tab" data-bs-toggle="pill" data-bs-target="#add" type="button" role="tab" aria-controls="add" aria-selected="false">Address</button>
              <button class="nav-link link-light" id="nomi-tab" data-bs-toggle="pill" data-bs-target="#nomi" type="button" role="tab" aria-controls="nomi" aria-selected="false">Nominee</button>
              <button class="nav-link link-light" id="academi-tab" data-bs-toggle="pill" data-bs-target="#academi" type="button" role="tab" aria-controls="academi" aria-selected="false">Academic Info</button>
              <button class="nav-link link-light" id="exp-tab" data-bs-toggle="pill" data-bs-target="#exp" type="button" role="tab" aria-controls="exp" aria-selected="false">Experience</button>
              <button class="nav-link link-light" id="train-tab" data-bs-toggle="pill" data-bs-target="#train" type="button" role="tab" aria-controls="train" aria-selected="false">Professional Training</button>
              <button class="nav-link link-light" id="pass-tab" data-bs-toggle="pill" data-bs-target="#pass" type="button" role="tab" aria-controls="pass" aria-selected="false">Passport</button>                   
              <button class="nav-link link-light" id="pic-tab" data-bs-toggle="pill" data-bs-target="#pic" type="button" role="tab" aria-controls="pic" aria-selected="false">Photo & Signature</button> 
            </div>
        </nav>

        <div class="overflow-auto min-vh-100"
  style="max-width: 1920px;  scrollbar-width: none;  -ms-overflow-style: none;">

        <div class="tab-content" id="nav-tabContent" style="background-color:rgb(255, 224, 255)">

            {{-- official info section starts --}}
            <div class="tab-pane fade show active" id="off" role="tabpanel" aria-labelledby="off-tab" tabindex="0">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                        <h3 class="text-center">Official Information</h3>

                        {{-- Employee Id input --}}
                        <div class="mb-3 row">
                            <label for="emp_id" class="col-sm-3 col-form-label">Employee Id :</label>
                            <div class="col-sm-7">
                                <input list="empno" type="text" class="form-control" name="emp_id" id="emp_id" placeholder="Enter Employee Id"/>
                                <datalist id="empno">
                                   
                            </datalist>
                             </div>
                             <div class="col">
                            <button class="btn btn-info">Find</button>    </div>
                        </div>

                        {{-- User name input --}}
                        <div class="mb-3 row" >
                            <label for="uname" class="col-sm-3 col-form-label">User Name :</label>
                            <div class="col-sm-8" style="font-family:Arial, Solaimanlipi, Helvetica, sans-serif;">
                                <input type="text" class="form-control" name="uname" id="uname" placeholder="User Name">
                            </div>
                        </div>

                        {{-- Employee name input --}}
                        <div class="mb-3 row">
                            <label for="emp_name" class="col-sm-3 col-form-label">Employee Name :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="emp_name" id="emp_name" placeholder="Enter Employee Name"/>
                            </div>
                        </div>

                        {{-- Other language input --}}
                        <div class="mb-3 row">
                            <label for="other_lang" class="col-sm-3 col-form-label">Other Language :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="other_lang" id="other_lang"  placeholder="Employee Name Other Lang"/>
                            </div>
                        </div>

                        {{-- Official email input --}}
                        <div class="mb-3 row">
                            <label for="ofc_email" class="col-sm-3 col-form-label">Official Email : </label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="ofc_email" id="ofc_email" aria-describedby="emailHelpId" placeholder="Enter Official Email"/>
                            </div>
                        </div>

                        {{-- Designation input --}}
                        <div class="mb-3 row">
                            <label for="designation" class="col-sm-3 col-form-label">Designation : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct one">Select One</option>
                
                                </select>
                            </div>
                        </div>

                        {{-- Office input --}}
                        <div class="mb-3 row">
                            <label for="office" class="col-sm-3 col-form-label">Office : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct one">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Shift input --}}
                        <div class="mb-3 row">
                            <label for="shift" class="col-sm-3 col-form-label">Shift/Shift Group : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct one">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Roastering check --}}
                        <div class="mb-3 row">
                            <div class="col-md-3"></div>
                            <div class="form-check col-md-8 ml-2">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Is Roastering Employee
                                </label>
                            </div>
                        </div>

                        {{-- Office floor selection --}}
                        <div class="mb-3 row">
                            <label for="ofc_flr" class="col-sm-3 col-form-label">Office Floor : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct office floor">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Department selection --}}
                        <div class="mb-3 row">
                            <label for="dept" class="col-sm-3 col-form-label">Department: </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct dept">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Other responsibilities --}}
                        <div class="mb-3 row">
                            <label for="otr_resp" class="col-sm-3 col-form-label">Others Responsibility: </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct One">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Work group selection --}}
                        <div class="mb-3 row">
                            <label for="work" class="col-sm-3 col-form-label">Work Group :</label>
                            <div class="col-sm-8 pt-2">
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="radio1" name="work" value="option1">
                                    <label class="form-check-label" for="radio1">Staff</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="radio" class="form-check-input" id="radio2" name="work" value="option2" checked>
                                    <label class="form-check-label" for="radio2">Worker</label>
                                </div>
                            </div>
                        </div>

                        {{-- Salary type --}}
                        <div class="mb-3 row">
                            <label for="salary" class="col-sm-3 col-form-label">Salary Type :</label>
                            <div class="col-sm-8 pt-2">
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio1" name="salary" value="option1" checked>
                                <label class="form-check-label" for="radio1">Regular</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio2" name="salary" value="option2">
                                <label class="form-check-label" for="radio2">Production</label>
                              </div>
                            </div>
                        </div>
 
                        {{-- Card No entry --}}
                        <div class="mb-3 row">
                            <label for="ac_no" class="col-sm-3 col-form-label">Card No/AC No :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ac_no" id="ac_no"  placeholder="Card No/AC No"/>
                            </div>
                        </div>

                        {{-- Joining date --}}
                        <div class="mb-3 row">
                            <label for="join_date" class="col-sm-3 col-form-label">Joining Date :</label>
                            <div class="col-sm-8">
                            <div class='input-group date' id='datetimepicker'>
                              <input type='text'name="join_date" class="form-control" placeholder ="DD/MM/YYYY"/>
                          <span class="input-group-addon">
                             <span class="glyphicon glyphicon-calendar"></span>
            </span>
            </div>
                            </div>
                        </div>

                        {{-- Grade selection --}}
                        <div class="mb-3 row">
                            <label for="grade" class="col-sm-3 col-form-label">Grade : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct grade">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Gross input --}}
                        <div class="mb-3 row">
                            <label for="gross" class="col-sm-3 col-form-label">Gross :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="gross" id="gross"  placeholder="Gross"/>
                            </div>
                        </div>

                        {{-- Second gross input --}}
                        <div class="mb-3 row">
                            <label for="sec_gross" class="col-sm-3 col-form-label">Second Gross :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="sec_gross" id="sec_gross"  placeholder="Second Gross"/>
                            </div>
                        </div>

                        {{-- Employee Type selection --}}
                        <div class="mb-3 row">
                            <label for="emp_type" class="col-sm-3 col-form-label">Employee Type : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct emp_type">Select One</option>
                                    
                                </select>
                            </div>
                        </div>

                        {{-- Contract start date --}}
                        <div class="mb-3 row">
                            <label for="con_st" class="col-sm-3 col-form-label">Contract Start Date :</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="con_st" id="con_st"  placeholder="Contract Start Date"/>
                            </div>
                        </div>

                        {{-- Contract end date --}}
                        <div class="mb-3 row">
                            <label for="con_end" class="col-sm-3 col-form-label">Contract End Date :</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="con_end" id="con_end"  placeholder="Contract End Date"/>
                            </div>
                        </div>

                        {{-- Type of Work --}}
                        <div class="mb-3 row">
                            <label for="work_type" class="col-sm-3 col-form-label">Type of Work : </label>
                            <div class="col-sm-8">
                              <select class="form-select" aria-label="Default select example">
                                <option selected placeholder="Selct work_type">Select One</option>
                                
                                
                              </select>
                            </div>
                        </div>

                        {{-- Employee group selection --}}
                        <div class="mb-3 row">
                            <label for="emp_grp" class="col-sm-3 col-form-label">Employee Group : </label>
                            <div class="col-sm-8">
                              <select class="form-select" aria-label="Default select example">
                                <option selected placeholder="Selct emp_grp">Select One</option>
                                
                                
                              </select>
                            </div>
                        </div>

                        {{-- Manager selection --}}
                        <div class="mb-3 row">
                            <label for="manager" class="col-sm-3 col-form-label">Manager : </label>
                            <div class="col-sm-8">
                              <select class="form-select" aria-label="Default select example">
                                <option selected placeholder="Selct manager">Select One</option>
                                
                              </select>
                            </div>
                        </div>

                          <div class="mb-3 row">
                            <label for="job_loc" class="col-sm-3 col-form-label">Job Location :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="job_loc" id="job_loc"  placeholder="Job Location"/>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="pro_period" class="col-sm-3 col-form-label">Probation Period :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="pro_period" id="pro_period"  placeholder="Month"/>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="conf_date" class="col-sm-3 col-form-label">Confirmation Date :</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="conf_date" id="conf_date"  placeholder="Confirmation Date"/>
                            </div>
                          </div>
                          <div class="mb-3 row">
                            <label for="off_phn" class="col-sm-3 col-form-label">Official Phone & PABX Ext. No :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="off_phn" id="off_phn"  placeholder="Official Phone & PABX Ext. No"/>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label for="bank_ac" class="col-sm-3 col-form-label">Bank A/C No :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="bank_ac" id="bank_ac"  placeholder="Bank Acc No"/>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label for="bank_info" class="col-sm-3 col-form-label">Bank Info :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="bank_info" id="bank_info"  placeholder="Bank Name, Branch Name"/>
                            </div>
                          </div>

                          <div class="mb-3 row">
                            <label for="global_id" class="col-sm-3 col-form-label">Global Id :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="global_id" id="global_id"  placeholder="Empoyee Global Id No"/>
                            </div>
                          </div>
 
                          <div class="mb-3 row">
                            <label for="identifier" class="col-sm-3 col-form-label">Identifier :</label>
                            <div class="col-sm-8">
                            <textarea type="text" class="form-control" name="identifier" id="identifier"  placeholder="Empoyee Identifier"/></textarea>
                            </div>
                          </div>
 
                          <div class="mb-3 row">
                            <label for="pay_mode" class="col-sm-3 col-form-label" >Payment Mode: </label>
                             <div class="col-sm-8">
                            <select class="form-select" aria-label="Default select example" >
                                <option selected placeholder="Select Payment Mode">Cash</option>
                                
                              </select>
                             </div>
                          </div>
 
                          <div class="mb-3 row">
                          <label for="leave_proc" class="col-sm-3 col-form-label">Is Leave Auto Process : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="leave_proc">
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="leave_open" class="col-sm-3 col-form-label">Is Leave Auto Open : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="leave_open" checked>
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="leave_fixed" class="col-sm-3 col-form-label">Is Fixed Leave : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="leave_fixed">
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="honor" class="col-sm-3 col-form-label">Is Honorarium : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="honor">
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="pf_elig" class="col-sm-3 col-form-label">Is PF Eligible : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="pf_elig">
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="ot_pay" class="col-sm-3 col-form-label">Is OT Payable : </label>
                          <div class="form-check col-sm-1">
                            <input class="form-check-input" type="checkbox" value="" id="ot_pay" checked>
                          </div>
                          <div class="form-check col-sm-8">
                            <input class="form-check-input" type="checkbox" value="" id="ot_pay" disable>
                            <label class="form-check-label" for="ot_pay">Is Buyer OT</label>
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="mask" class="col-sm-3 col-form-label">Is Masked : </label>
                          <div class="form-check col-sm-9">
                            <input class="form-check-input" type="checkbox" value="" id="mask">
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label for="emp_status" class="col-sm-3 col-form-label">Employee Status :</label>
                          <div class="col-sm-8">
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio1" name="emp_status" value="option1" >
                              <label class="form-check-label" for="radio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio2" name="emp_status" value="option2" checked>
                              <label class="form-check-label" for="radio2">Inactive</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio3" name="emp_status" value="option3">
                              <label class="form-check-label" for="radio2">Lefty</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio4" name="emp_status" value="option4">
                              <label class="form-check-label" for="radio2">Hold</label>
                            </div>
                          </div>
                        </div>

                        <div class="mb-3 row">
                          <label for="discont_date" class="col-sm-3 col-form-label">Date of Discontinuation :</label>
                          <div class="col-sm-8">
                          <input type="date" class="form-control" name="discont_date" id="discont_date"  placeholder=""/>
                          </div>
                        </div>
                        <div class="mb-3 row">
                          <label for="discont_reason" class="col-sm-3 col-form-label">Reason of Discontinuation :</label>
                          <div class="col-sm-8">
                          <input type="text" class="form-control" name="discont_reason" id="discont_reason"  placeholder="Final settled">
                          </div>
                        </div>

                        {{-- action buttons --}}
                        <div class="row-md-6 m-3 text-center p-3">
                            <button class="btn btn-success" type="submit">Save</button>
                            <button class="btn btn-warning" type="button">Edit</button>
                            <button class="btn btn-primary" type="button">Clear</button>
                        </div>

                    </div>
                </form>
            </div>
            {{-- official info section ends --}}

            {{-- personal info section starts --}}
            <div class="tab-pane fade" id="per" role="tabpanel" aria-labelledby="per-tab" tabindex="1">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                        <h3 class="text-center">Personal Information</h3>
                       
                        {{-- Father name input --}}
                        <div class="mb-3 row">                         
                           <label for="fname" class="col-sm-3 col-form-label">Father Name :</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" name="fname" id="fname" placeholder="Father Name" tabindex="1">
                           </div> 
                        </div>

                        {{-- Mother name input --}}
                        <div class="mb-3 row">
                           <label for="mname" class="col-sm-3 col-form-label">Mother Name :</label>
                           <div class="col-sm-8">
                                <input type="text" class="form-control" name="mname" id="mname" placeholder="Mother Name"/>
                           </div>
                        </div>

                        {{-- Height input --}}
                        <div class="mb-3 row">
                           <label for="height" class="col-sm-3 col-form-label">Height :</label>
                           <div class="col-sm-8">
                                <input type="text" class="form-control" name="height" id="height"  placeholder="Height"/>
                           </div>
                        </div>

                        {{-- Contact no input --}}
                        <div class="mb-3 row">
                            <label for="contact" class="col-sm-3 col-form-label">Contact No :</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" name="contact" id="contact"  placeholder="Contact No"/>
                            </div>
                        </div>

                        {{-- Personal Email input --}}
                         <div class="mb-3 row">
                           <label for="validationDefaultUsername" class="col-sm-3 col-form-label">Personal Email : </label>
                           <div class="col-sm-8">
                           <input type="email" class="form-control" name="validationDefaultUsername" id="validationDefaultUsername" aria-describedby="emailHelpId" placeholder="Email" required/>
                           </div>
                         </div>

                         {{-- Date of Birth --}}
                        <div class="mb-3 row">
                            <label for="dob" class="col-sm-3 col-form-label">Date of Birth :</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="dob" id="dob"  placeholder="Date of Birth"/>
                            </div>
                        </div>

                        {{-- Gender selection --}}
                        <div class="mb-3 row">
                            <label for="gender" class="col-sm-3 col-form-label">Gender :</label>
                            <div class="col-sm-8">
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio1" name="gender" value="option1">
                                <label class="form-check-label" for="radio1">Male</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio2" name="gender" value="option2">
                                <label class="form-check-label" for="radio2">Female</label>
                              </div>
                              <div class="form-check form-check-inline">
                                 <input type="radio" class="form-check-input" id="radio3" name="gender" value="option2">
                                 <label class="form-check-label" for="radio2">Others</label>
                              </div>
                            </div>
                        </div>

                        {{-- Religion selection --}}
                        <div class="mb-3 row">
                            <label for="religion" class="col-sm-3 col-form-label">Religion : </label>
                            <div class="col-sm-8">
                            <select class="form-select" aria-label="Default select example">
                                <option selected placeholder="Select Religion">Select Religion</option>
                                <option value="1">Islam</option>
                                <option value="2">Hindu</option>
                                <option value="3">Christian</option>
                                <option value="4">Buddhist</option>
                              </select>
                            </div>
                        </div>

                        {{-- Nationality input --}}
                        <div class="mb-3 row">
                            <label for="national" class="col-sm-3 col-form-label">Nationality :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="national" id="national"  placeholder="Nationality"/>
                            </div>
                        </div>

                        {{-- National Id input --}}
                        <div class="mb-3 row">
                            <label for="national_id" class="col-sm-3 col-form-label">National Id:</label>
                             <div class="col-sm-8">
                            <input type="text" class="form-control" name="national_id" id="national_id"  placeholder="National Id"/>
                             </div>
                        </div>

                        {{-- Birth Certificate --}}
                        <div class="mb-3 row">
                            <label for="b_cirtificate" class="col-sm-3 col-form-label">Birth Certificate:</label>
                             <div class="col-sm-8">
                            <input type="text" class="form-control" name="b_cirtificate" id="b_cirtificate"  placeholder="Birth Certificate"/>
                             </div>
                        </div>

                        {{-- TIN input --}}
                        <div class="mb-3 row">
                            <label for="tin" class="col-sm-3 col-form-label">TIN:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="tin" id="tin"  placeholder="TIN"/>
                            </div>
                        </div>

                        {{-- Blood group --}}
                        <div class="mb-3 row">
                           <label for="b_grp" class="col-sm-3 col-form-label" >Blood Group: </label>
                            <div class="col-sm-8">
                             <select class="form-select" aria-label="Default select example" >
                               <option selected placeholder="Select Blood Group">Select Blood Group</option>
                               <option value="1">A+</option>
                               <option value="2">A-</option>
                               <option value="3">B+</option>
                               <option value="4">B-</option>
                               <option value="5">B-</option>
                               <option value="6">O+</option>
                               <option value="7">O-</option>
                               <option value="8">AB+</option>
                               <option value="9">AB-</option>
                             </select>
                            </div>
                        </div>

                        {{-- Marital Status --}}
                         <div class="mb-3 row">
                            <label for="marital" class="col-sm-3 col-form-label">Marital Status: </label>
                             <div class="col-sm-8">
                            <select class="form-select" aria-label="Default select example" filter="true">
                                <option selected placeholder="Select Marital Status">Select Marital Status</option>
                                <option value="1">Married</option>
                                <option value="2">Unmarried</option>   
                              </select>
                            </div>
                          </div>

                          {{-- Emergency contact name input --}}
                          <div class="mb-3 row">
                            <label for="ec_name" class="col-sm-3 col-form-label">Emergency Contact Name:</label>
                             <div class="col-sm-8">
                            <input type="text" class="form-control" name="ec_name" id="ec_name"  placeholder="Emergency Contact Name"/>
                             </div>
                          </div>

                          {{-- Emergency contact address input --}}
                          <div class="mb-3 row">
                            <label for="ec_addr" class="col-sm-3 col-form-label">Emergency Contact Address:</label>
                             <div class="col-sm-8">
                            <textarea class="form-control" name="ec_addr" id="ec_addr"  placeholder="Emergency Contact Address"></textarea>
                             </div>
                          </div>

                          {{-- Emergency contact number input --}}
                          <div class="mb-3 row">
                            <label for="ec_no" class="col-sm-3 col-form-label">Emergency Contact No:</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" name="ec_no" id="ec_no"  placeholder="Emergency Contact No"/>
                            </div>
                          </div>

                          {{-- Emergency contact person relation input --}}
                          <div class="mb-3 row">
                            <label for="ec_name" class="col-sm-3 col-form-label">Emergency Contact Person Relation : </label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="ec_rel" id="ec_rel"  placeholder="Emergency Contact Relation"/>
                            </div>
                          </div>

                          {{-- Action buttons --}}
                         <div class="row-md-6 m-3 text-center p-3">
                           <button class="btn btn-success" type="submit">Save</button>
                           <button class="btn btn-warning" type="button">Edit</button>
                           <button class="btn btn-primary" type="button">Clear</button>
                         </div>
                    </div>
                </form>
            </div>
            {{-- personal info section ends --}}

            {{-- address section starts --}}
            <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add-tab" tabindex="2">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                        <h3 class="text-center">Address</h3>
                     
                        {{-- Type of Address --}}
                        <div class="mb-3 row">
                            <label for="type" class="col-sm-3 col-form-label">Type : </label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected placeholder="Selct type">Present</option>
                                    <option value="1">Permanent</option>
                          
                                </select>
                            </div>
                        </div>
                      
                        {{-- Division selection --}}
                        <div class="mb-3 row">
                          <label for="division" class="col-sm-3 col-form-label">Division : </label>
                          <div class="col-sm-8">
                          <select class="form-select" aria-label="Default select example">
                              <option selected placeholder="Selct division">Select One</option>
                              
                            </select>
                          </div>
                        </div>

                        {{-- District selection --}}
                        <div class="mb-3 row">
                          <label for="district" class="col-sm-3 col-form-label">District : </label>
                          <div class="col-sm-8">
                          <select class="form-select" aria-label="Default select example">
                              <option selected placeholder="Select district">Select District</option>
                              
                            </select>
                          </div>
                        </div>

                        {{-- Thana selection --}}
                        <div class="mb-3 row">
                         <label for="thana" class="col-sm-3 col-form-label" >Thana : </label>
                          <div class="col-sm-8">
                         <select class="form-select" aria-label="Default select example" >
                             <option selected placeholder="Select thana">Select Thana</option>
                             
                           </select>
                          </div>
                       </div>

                       {{-- Post code --}}
                       <div class="mb-3 row">
                          <label for="p_code" class="col-sm-3 col-form-label">Post Code : </label>
                           <div class="col-sm-8">
                          <select class="form-select" aria-label="Default select example" filter="true">
                              <option selected placeholder="Select post code">Select Post Code</option>
                                 
                            </select>
                          </div>
                        </div>
                       
                        {{-- Area input --}}
                        <div class="mb-3 row">
                          <label for="area" class="col-sm-3 col-form-label">Area :</label>
                          <div class="col-sm-8">
                          <textarea class="form-control" name="area" id="area"  placeholder="Write address here"/></textarea>
                          </div>
                        </div>

                        {{-- Status check --}}
                        <div class="mb-3 row">
                          <label for="status" class="col-sm-3 col-form-label">Status :</label>
                          <div class="col-sm-8 pt-2">
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio1" name="status" value="option1" checked>
                              <label class="form-check-label" for="radio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input type="radio" class="form-check-input" id="radio2" name="status" value="option2">
                              <label class="form-check-label" for="radio2">Inactive</label>
                            </div>
                          </div>
                        </div>

                       {{-- Action buttons --}}
                       <div class="row-md-6 m-3 text-center p-3">
                         <button class="btn btn-success" type="submit">Save</button>
                         <button class="btn btn-warning" type="button">Edit</button>
                         <button class="btn btn-danger" type="button">Clear</button>
                         <button class="btn btn-primary" type="button">Clear</button>
                       </div>
                    </div>
                </form>
            </div>
            {{-- address section ends --}}

            {{-- Nominee section starts --}}
            <div class="tab-pane fade" id="nomi" role="tabpanel" aria-labelledby="nomi-tab" tabindex="3">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center p-2">Nominee</h3>
                       
                       {{-- Name input --}}
                        <div class="mb-3 row">
                           <label for="name" class="col-sm-3 col-form-label">Name :</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" name="name" id="name" placeholder="Name"/>
                           </div>
                        </div>
    
                        {{-- NID info --}}
                         <div class="mb-3 row">
                           <label for="nid" class="col-sm-3 col-form-label">NID :</label>
                           <div class="col-sm-8">
                           <input type="text" class="form-control" name="nid" id="nid" placeholder="National Id"/>
                           </div>
                         </div>

                         {{-- Relation with nominee --}}
                         <div class="mb-3 row">
                           <label for="relation" class="col-sm-3 col-form-label">Relation :</label>
                           <div class="col-sm-8">
                           <input type="text" class="form-control" name="relation" id="relation"  placeholder="Relation"/>
                           </div>
                         </div>

                         {{-- Date of BIrth --}}
                        <div class="mb-3 row">
                            <label for="dob" class="col-sm-3 col-form-label">Date of Birth :</label>
                            <div class="col-sm-8">
                            <input type="date" class="form-control" name="dob" id="dob"  placeholder="Date of Birth"/>
                            </div>
                        </div>
                        
                        {{-- GEnder selection --}}
                        <div class="mb-3 row">
                            <label for="gender" class="col-sm-3 col-form-label">Gender :</label>
                            <div class="col-sm-8">
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio1" name="gender" value="option1">
                                <label class="form-check-label" for="radio1">Male</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="radio2" name="gender" value="option2">
                                <label class="form-check-label" for="radio2">Female</label>
                              </div>
                              <div class="form-check form-check-inline">
                                 <input type="radio" class="form-check-input" id="radio3" name="gender" value="option2">
                                 <label class="form-check-label" for="radio2">Others</label>
                              </div>
                            </div>
                        </div>
    
                        {{-- Contact address --}}
                        <div class="mb-3 row">
                           <label for="cont_add" class="col-sm-3 col-form-label">Contact Address : </label>
                           <div class="col-sm-8">
                           <input type="email" class="form-control" name="cont_add" id="cont_add" aria-describedby="" placeholder="Contact Address & No"/>
                           </div>
                        </div>
    
                        {{-- Email address --}}
                        <div class="mb-3 row">
                          <label for="email" class="col-sm-3 col-form-label">Email : </label>
                          <div class="col-sm-8">
                          <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelpId" placeholder="Email"/>
                          </div>
                        </div>
                          
                        {{-- Photo --}}
                        <div class="mb-3 row">
                          <label for="photo" class="form-label col-sm-3">Photo :</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="file" id="photo">
                          </div>                      
                        </div>
    
                        {{-- Signature --}}
                        <div class="mb-3 row">
                          <label for="sign" class="form-label col-sm-3">Signature :</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="file" id="sign">
                          </div>                      
                        </div>
    
                        {{-- Action Buttons --}}
                         <div class="row-md-6 m-3 text-center p-3">
                           <button class="btn btn-white border-black" type="submit">Add</button>
                           <button class="btn btn-danger" type="button">Delete</button>
                         </div>
                    </div>
                    
                   </form>
            </div>
            {{-- Nominee section ends --}}

            {{-- academic info section starts --}}
            <div class="tab-pane fade" id="academi" role="tabpanel" aria-labelledby="academi-tab" tabindex="4">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center">Academic Info</h3>
      
                       {{-- Degree selection --}}
                       <div class="mb-3 row">
                        <label for="degree" class="col-sm-3 col-form-label">Degree : </label>
                        <div class="col-sm-8">
                          <select class="form-select" aria-label="Default select example">
                            <option selected placeholder="Select degree">Select Qualification</option>
                          </select>
                        </div>
                       </div>
      
                        {{-- Level input --}}
                        <div class="mb-3 row">
                           <label for="level" class="col-sm-3 col-form-label">Level :</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" name="level"  id="level" placeholder="Level"/>
                           </div>
                        </div>
      
                        {{-- Institution name  --}}
                         <div class="mb-3 row">
                           <label for="institute" class="col-sm-3 col-form-label">Institute :</label>
                           <div class="col-sm-8">
                                <input type="text" class="form-control" name="institute" id="institute" placeholder="Institute"/>
                           </div>
                         </div>

                         {{-- Board/University input --}}
                         <div class="mb-3 row">
                           <label for="brd_uni" class="col-sm-3 col-form-label">Board/University :</label>
                           <div class="col-sm-8">
                                <input type="text" class="form-control" name="brd_uni" id="brd_uni"  placeholder="Board or University"/>
                           </div>
                         </div>

                         {{-- Sesion input --}}
                        <div class="mb-3 row">
                            <label for="session" class="col-sm-3 col-form-label">Session :</label>
                            <div class="col-sm-8">
                                <input type="tel" class="form-control" name="session" id="session"  placeholder="Session"/>
                            </div>
                        </div>
                         
                        {{-- Passing Year --}}
                        <div class="mb-3 row">
                            <label for="pass_yr" class="col-sm-3 col-form-label">Passing Year : </label>
                            <div class="col-sm-8">
                            <select class="form-select" aria-label="Default select example">
                                <option selected placeholder="Selct pass_yr">Select Passing Year</option>
                              </select>
                            </div>
                        </div>
      
                        {{-- Subject / group --}}
                        <div class="mb-3 row">
                            <label for="sub_grp" class="col-sm-3 col-form-label">Subject/Group :</label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="sub_grp" id="sub_grp"  placeholder="Subject or Group"/>
                            </div>
                        </div>
      
                        {{-- Result input --}}
                        <div class="mb-3 row">
                            <label for="gpa" class="col-sm-3 col-form-label">Division/GPA:</label>
                             <div class="col-sm-8">
                            <input type="text" class="form-control" name="gpa" id="gpa"  placeholder="Result"/>
                             </div>
                        </div>
      
                        {{-- Action buttons --}}
                        <div class="row-md-6 m-3 text-center p-3">
                           <button class="btn btn-white border-black" type="submit">Add</button>
                           <button class="btn btn-danger" type="button">Delete</button>
                        </div>

                    </div>
                   </form>
            </div>
            {{-- academic info section ends --}}

            {{-- experience info section starts --}}
            <div class="tab-pane fade" id="exp" role="tabpanel" aria-labelledby="exp-tab" tabindex="5">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center p-2">Experience</h3>
                   
                        {{-- Designation --}}
                        <div class="mb-3 row">
                           <label for="designation" class="col-sm-3 col-form-label">Designation :</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" name="designation" id="designation" placeholder="Designation"/>
                           </div>
                        </div>
        
                        {{-- Organization info --}}
                         <div class="mb-3 row">
                           <label for="org_add" class="col-sm-3 col-form-label">Organization Name & Address :</label>
                           <div class="col-sm-8">
                           <textarea class="form-control" name="org_add" id="org_add" placeholder="Organization Name & Address"/></textarea>
                           </div>
                         </div>
                         
                         {{-- Department input --}}
                          <div class="mb-3 row">
                            <label for="dept" class="col-sm-3 col-form-label">Department :</label>
                             <div class="col-sm-8">
                            <input type="text" class="form-control" name="dept" id="dept"  placeholder="Department"/>
                             </div>
                          </div>
        
                          {{-- Date from --}}
                          <div class="mb-3 row">
                            <label for="date_from" class="col-sm-3 col-form-label">Date From :</label>
                             <div class="col-sm-8">
                            <input type="date" class="form-control" name="date_from" id="date_from"  placeholder="Date From"/>
                             </div>
                          </div>
                         
                          {{-- Date To --}}
                          <div class="mb-3 row">
                            <label for="date_to" class="col-sm-3 col-form-label">Date To :</label>
                             <div class="col-sm-8">
                            <input type="date" class="form-control" name="date_to" id="date_to"  placeholder="Date To"/>
                             </div>
                          </div>
        
                          {{-- Responsibilities --}}
                          <div class="mb-3 row">
                            <label for="response" class="col-sm-3 col-form-label">Responsibilities:</label>
                             <div class="col-sm-8">
                            <textarea class="form-control" name="response" id="response"  placeholder="Responsibilities"></textarea>
                             </div>
                          </div>
        
                        {{-- Action Buttons --}}
                         <div class="row-md-6 m-3 text-center">
                           <button class="btn btn-white border-black" type="submit">Add</button>
                           <button class="btn btn-danger" type="button">Delete</button> 
                         </div>

                    </div>
                   </form>
            </div>
            {{-- experience info section ends --}}

            {{-- professional training section starts --}}
            <div class="tab-pane fade" id="train" role="tabpanel" aria-labelledby="train-tab" tabindex="6">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center p-2">Professional Training</h3>
                       
                        {{-- Title input --}}
                        <div class="mb-3 row">
                           <label for="title" class="col-sm-3 col-form-label">Title :</label>
                           <div class="col-sm-8">
                              <input type="text" class="form-control" name="title" id="title" placeholder="Title">
                           </div>
                        </div>
        
                        {{-- Organization info --}}
                         <div class="mb-3 row">
                           <label for="conduct" class="col-sm-3 col-form-label">Conducted/Organized By :</label>
                           <div class="col-sm-8">
                           <textarea class="form-control" name="conduct" id="conduct" placeholder="Organized By"></textarea>
                           </div>
                         </div>
                         
                         {{-- Start date --}}
                        <div class="mb-3 row">
                            <label for="date_from" class="col-sm-3 col-form-label">Start Date:</label>
                             <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_from" id="date_from"  placeholder="Start Date"/>
                             </div>
                        </div>
                         
                        {{-- End date --}}
                        <div class="mb-3 row">
                            <label for="date_to" class="col-sm-3 col-form-label">End Date :</label>
                             <div class="col-sm-8">
                                <input type="date" class="form-control" name="date_to" id="date_to"  placeholder="End Date"/>
                             </div>
                        </div>
        
                        {{-- Topic input --}}
                        <div class="mb-3 row">
                            <label for="topic" class="col-sm-3 col-form-label">Topics :</label>
                             <div class="col-sm-8">
                                <textarea class="form-control" name="topic" id="topic"  placeholder="Topics"></textarea>
                             </div>
                        </div>
        
                        {{-- Action buttons --}}
                         <div class="row-md-6 m-3 text-center p-3">
                           <button class="btn btn-white border-black" type="submit">Add</button>
                           <button class="btn btn-danger" type="button">Delete</button>
                         </div>
                    </div>
                    
                   </form>
            </div>
            {{-- professional training section ends --}}

            {{-- passport section starts --}}
            <div class="tab-pane fade" id="pass" role="tabpanel" aria-labelledby="pass-tab" tabindex="7">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center">Passport</h3>

                       {{-- Passport no input --}}
                        <div class="mb-3 row">
                           <label for="pass_no" class="col-sm-3 col-form-label">Passport No :</label>
                           <div class="col-sm-8">
                             <input type="text" class="form-control" name="pass_no" id="pass_no" placeholder="Passport No"/>
                           </div>
                        </div>

                        {{-- Issue date input --}}
                         <div class="mb-3 row">
                           <label for="iss_dt" class="col-sm-3 col-form-label">Issue Date : </label>
                           <div class="col-sm-8">
                           <input type="date" class="form-control" name="iss_dt" id="iss_dt" placeholder="Issue Date"/>
                          </div>
                         </div>

                         {{-- Expire date input --}}
                         <div class="mb-3 row">
                           <label for="exp_dt" class="col-sm-3 col-form-label">Expire Date : </label>
                           <div class="col-sm-8">
                           <input type="date" class="form-control" name="exp_dt" id="exp_dt"  placeholder="Expire Date"/>
                          </div>
                         </div>

                         {{-- Issueing Authority --}}
                         <div class="mb-3 row">
                           <label for="iss_auth" class="col-sm-3 col-form-label">Issuing Authority : </label>
                           <div class="col-sm-8">
                           <input type="email" class="form-control" name="iss_auth" id="iss_auth" aria-describedby="" placeholder="Issuing Authority"/>
                          </div>
                         </div>

                        {{-- Remarks input --}}
                        <div class="mb-3 row">
                            <label for="remark" class="col-sm-3 col-form-label">Remarks : </label>
                            <div class="col-sm-8">
                                <input type="email" class="form-control" name="remark" id="remark" aria-describedby="" placeholder="Remarks"/>
                            </div>
                        </div>
                         
                        {{-- Action Buttons --}}
                         <div class="row-md-6 m-3 text-center p-3">
                           <button class="btn btn-success" type="submit">Save</button>
                           <button class="btn btn-warning" type="button">Edit</button>
                           <button class="btn btn-primary" type="button">Clear</button>
                         </div>

                    </div>
                   </form>
            </div>
            {{-- passport section ends --}}

            {{-- photo & signature section starts --}}
            <div class="tab-pane fade" id="pic" role="tabpanel" aria-labelledby="pic-tab" tabindex="8">
                <form action="" method="">
                    <div class="container col-lg-6 p-3">
                       <h3 class="text-center p-2">Photo & Signature</h3>
                          
                       {{-- Photo attach --}}
                        <div class="mb-3 row">
                          <label for="photo" class="form-label col-sm-3">Photo :</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="file" id="photo">
                          </div>                      
                        </div>
    
                        {{-- Signature attach --}}
                        <div class="mb-3 row">
                          <label for="sign" class="form-label col-sm-3">Signature :</label>
                          <div class="col-sm-8">
                            <input class="form-control" type="file" id="sign">
                          </div>                      
                        </div>
    
                        {{-- Action buttons --}}
                        <div class="row-md-6 m-3 text-center">
                           <button class="btn btn-success" type="submit">Save</button>
                           <button class="btn btn-primary" type="button">Clear</button>                         
                        </div>

                    </div>
                   </form>
            </div>
            {{-- photo & signature section ends --}}
        
        </div>
        

     </main>

     
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    </div>
    <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">

            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2014-2023 <a href="#">FDL ERP</a>.</strong> All rights reserved.
        </footer>
    </div>

  
<script type="text/javascript" src="{{ URL::asset('plugins/jquery/jquery.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script type="text/javascript" src="{{ URL::asset('dist/js/adminlte.min.js') }} "></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script type="text/javascript">
    $('#datetimepicker').datepicker({  
       format: 'dd-M-yyyy'
     });  

     $("#emp_id").on('keyup', function(e) {
        e.preventDefault();
      
       var empno= $("#emp_id").val();
      // alert(empno);
            $.ajax({
              url: 'empsearch',
              method: 'get',
                data : {
                    'search_key' : empno
                },
              success: function(response) {
                var res = response.data;
                var html = '';
                var htmldata=res.map(function(item){
          
                    html +='<option value='+item.po_number+'>';

                  //console.log(item);
                })
                    //console.log(htmldata)
               $("#empno").empty();
                $("#empno").append(html);

              },error: function(response){
                
              }
            });
          
      

      
      });
</script>
</body>
</html>