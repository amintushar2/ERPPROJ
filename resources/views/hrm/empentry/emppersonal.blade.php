{{-- personal info section starts --}}

<div class="tab-pane fade show active" id="per" role="tabpanel" aria-labelledby="per-tab" tabindex="1">

    <form id="emppersonalSave2">
        @csrf

        <div class="container-fluid col-lg-10 w-100 p-5">
            <h3 class="text-center">Personal Information</h3>
            {{-- employee id input --}}
            <div id="error-list">
                <ul></ul>
            </div>
            
            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="empno" class="col-sm col-form-label">Employee ID :</label>
                        <div class="col-sm-7 input-group">

                            <input list="empno_list" type="text" class="form-control" name="empno" id="empno"
                                value="{{old('empno')}}" placeholder="employee id" value="{{old('emp_no')}}"
                                tabindex="1" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="button"><i class="bi bi-search"></i>
                                </button>
                            </div>
                            <span class="text-danger" id="massege"></span>

                            <datalist id="empno_list">
                        </div>

                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <!-- <div class="col-sm-7">
                            <button class="btn btn-info float-left" id="find_emp">Find</button>

                        </div> -->
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="card_no" class="col-sm col-form-label">Proximity Card No:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="card_no" id="card_no"
                                value="{{old('card_no')}}" placeholder="proximity card no" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                {{-- Department name input --}}
                <div class="col-md-6">
                    <div class="row p-1">
                        <label for="company_name" class="col-sm-3 col-form-label">Company Name :</label>
                        <div class="col-sm-7">
                            <select class="form-select" id="comapnylist" name="company_id"
                                aria-label="Default select example">
                                <option selected value="">Select Company</option>

                                @foreach($companyList as $comapnyLists)

                                <option value="{{$comapnyLists->company_id}}">

                                    {{$comapnyLists->company_name}}

                                </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            {{-- name input --}}

            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="first_name" class="col-sm col-form-label">First Name :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                placeholder="First Name" value="{{old('first_name')}}">

                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="last_name" class="col-sm col-form-label">Last Name :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                placeholder="Last Name" value="{{old('last_name')}}" />

                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="middle_name" class="col-sm col-form-label">Middel Name :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="middle_name" id="middle_name"
                                placeholder="Middel Name" value="{{old('middle_name')}}" />

                        </div>
                    </div>
                </div>

            </div>



            {{-- Father name input --}}



            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="father_name" class="col-sm col-form-label">Father's Name :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="father_name" id="father_name"
                                placeholder="Father's name" value="{{old('father_name')}}">
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="mother_name" class="col-sm col-form-label">Mother's Name :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="mother_name" id="mother_name"
                                placeholder="mother's name" value="{{old('mother_name')}}">
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="spouse_name" class="col-sm col-form-label">Spouse Name :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="husband_name" id="husband_name"
                                placeholder="spouse name" value="{{old('husband_name')}}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Date of Birth --}}



            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="dob" class="col-sm col-form-label">Date of Birth :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="dob" id="dob" value="{{old('dob')}}"
                                placeholder="Date of Birth" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="as_on" class="col-sm col-form-label">As on :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="as_on" id="as_on_date"
                                value="{{old('as_on')}}" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="age" class="col-sm col-form-label">Age :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="age" id="age" value="{{old('age')}}"
                                placeholder="age">
                        </div>
                    </div>
                </div>
            </div>
            {{-- bangla name input --}}

            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="bangla_name" class="col-sm col-form-label">Name in Bangla :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="b_name" id="b_name" value="{{old('b_name')}}"
                                placeholder="name in bangla">
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="sex" class="col-sm col-form-label">Gender :</label>
                        <div class="col-sm-7">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="male" name="sex"
                                    value="{{old('sex')=='Male'}}">
                                Male
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="female" name="sex"
                                    value="{{old('sex')=='Female'}}">
                                Female
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="religion_name" class="col-sm col-form-label">Religion : </label>
                        <div class="col-sm-8">
                            <select class="form-select" name="religion_id" id="religion_id"
                                aria-label="Default select example">
                                @foreach($religion as $religion)
                                <option value="{{$religion->religion_id}}">{{$religion->religion_name}}</option>

                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="nationality_desc" class="col-sm col-form-label">Nationality :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="nationality_desc" id="nationality_desc"
                                value="Bangladeshi" placeholder="Nationality" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="status" class="col-sm col-form-label">Status: </label>
                        <div class="col-sm-7">
                            <select class="form-select" name="status" id="status" aria-label="Default select example">
                                <option selected placeholder="Active">Active</option>
                                <option value="Inactive">Inactive</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="national_id_no" class="col-sm col-form-label">National Id:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="national_id_no" id="national_id_no"
                                value="{{ old('national_id_no') }}" placeholder="National Id" />
                        </div>
                    </div>
                </div>
            </div>

            <!-- ll;ll -->
            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="id_card_issue" class="col-sm col-form-label">Id Card Issue :</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" name="id_card_issue" id="id_card_issue"
                                value="{{ old('id_card_issue') }}" placeholder="National Id issue" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="passport_no" class="col-sm col-form-label">Passport No :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="passport_no" id="passport_no"
                                value="{{ old('passport_no') }}" placeholder="passport_no" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="last_education" class="col-sm col-form-label">Last Education :</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="last_education" id="last_education"
                                value="{{ old('last_education') }}" placeholder="last education" />
                        </div>
                    </div>
                </div>
            </div>



            <!-- ll;ll -->
            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="valid_till" class="col-sm col-form-label">Id Card Valid Till :</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control" name="valid_till" id="valid_till"
                                value="{{ old('valid_till') }}" placeholder="id card valid till" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="place_of_issue" class="col-sm col-form-label">Place of Issue :</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="place_of_issue" id="place_of_issue"
                                value="{{ old('place_of_issue') }}" placeholder="place issue" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="id_mark" class="col-sm col-form-label">Identification Mark:</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" name="id_mark" id="id_mark"
                                value="{{ old('id_mark') }}" placeholder="identification mark" />
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="birthday_id" class="col-sm col-form-label">Birth Certificate:</label>
                        <div class="col-sm">
                            <input type="text" class="form-control" name="birthday_id" id="birthday_id"
                                value="{{ old('birthday_id') }}" placeholder="Birth Certificate" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="blood_group" class="col-sm col-form-label">Blood Group: </label>
                        <div class="col-sm-7">
                            <select class="form-select" name="blood_group" id="blood_group"
                                aria-label="Default select example">
                                <option selected>Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="hbs_test" class="col-sm col-form-label">HBS Ag: </label>
                        <div class="col-sm-8">
                            <select class="form-select" name="hbs_test" aria-label="Default select example">
                                <option selected value="">1</option>
                                <option value="">2</option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>






            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="emp_mobile_no" class="col-sm col-form-label">SMS Mobile No:</label>
                        <div class="col-sm-7">
                            <input type="tel" class="form-control" name="emp_mobile_no" id="emp_mobile_no"
                                value="{{ old('emp_mobile_no') }}" placeholder="Emp mobile No" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="sms_mobile_no" class="col-sm col-form-label">SMS Mobile No:</label>
                        <div class="col-sm-7">
                            <input type="tel" class="form-control" name="sms_mobile_no" id="sms_mobile_no"
                                value="{{ old('sms_mobile_no') }}" placeholder="sms mobile No" />
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <label for="office_food" class="col-sm col-form-label">Office Food : </label>
                        <div class="form-check col-sm-8">
                            <input class="form-check-input" type="checkbox" id="office_food" name="office_food"
                                value="{{ old('office_food') }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="photo" class="col-sm-3 col-form-label">Photo :</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="file" id="photo" name="photo">

                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <div class="col-sm-7">
                            <div class="border dflex justify-content-centre" style="height:100px;width:100Px;">
                                <img id="preview-image" src="#" alt="Preview" width="100Px" height="100Px">


                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md">
                    <div class="row p-1">
                        <label for="signature" class="col-sm-3 col-form-label">Signature :</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="file" id="signature" name="signature">

                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="row p-1">
                        <div class="col-sm-7">
                            <div class="border dflex justify-content-centre" style="height:80px;width:200Px;">
                                <img id="preview-sign" src="#" alt="Preview" width="200Px" height="80Px">

                            </div>

                        </div>
                    </div>
                </div>

            </div>

            {{-- Action buttons --}}
            <div class="row-md-6 m-3 text-center p-3">
                <button class="btn btn-success" type="submit" id="emppersonalSave">Save</button>
                <!-- <button class="btn btn-warning" type="button">Edit</button> -->
                <button class="btn btn-primary" type="button" id="clearFieldsBtn">Clear</button>
            </div>
        </div>
    </form>

</div>
{{-- personal info section ends --}}
